<?php
class MY_Model extends CI_Model {
    
	public function __construct() {
        parent::__construct();
		
		// This array sets up the relationships for deletion, since there's no easy way to guess or calculate this
		// Basically each "object" has an array of other "objects" which directly reference it
		// Therefore if we are deleting an object, we must get the IDs of any other objects which reference it
		// Then call the delete_object function on those objects before trying to delete our original object
		$this->table_dependents = array(
			'centreData' => array('sports'=>'sportID','venues'=>'venueID','tournaments'=>'tournamentID','teams'=>'teamID'),
			'sports' => array('matches'=>'matchID','tournaments'=>'tournamentID','sportData'=>'sportID'),
			'venues' => array('matches'=>'matchID','tournamentVenues'=>'venueID','venueData'=>'venueID'),
			'tournaments' => array('tickets'=>'ticketID','matches'=>'matchID','tournamentVenues'=>'tournamentID','tournamentActors'=>'tournamentID','tournamentData'=>'tournamentID'),
			'teams' => array('teamsUsers'=>'teamID','teamData'=>'teamID'),
			'matches' => array('tickets'=>'ticketID','matchActors'=>'matchActorID','matchData'=>'matchID'),
			'tickets' => array('ticketData'=>'ticketID'),
			'users' => array('teamsUsers'=>'userID','tickets'=>'ticketID','usersGroups'=>'userID','userData'=>'userID'),
			'matchActors' => array('matchActorResults'=>'resultID'),
			'matchActorResults' => array('matchActorResultData'=>'resultID'),
			// Empty arrays for tables which have no dependents
			'sportData' => array(),
			'venueData' => array(),
			'teamData' => array(),
			'matchData' => array(),
			'ticketData' => array(),
			'userData' => array(),
			'usersGroups' => array(),
			'matchActorResultData' => array(),
			'teamsUsers' => array(),
			'tournamentData' => array(),
			'tournamentVenues' => array(),
			'tournamentActors' => array()
		);
    }

	/* Queries an object from the database
	* Required: 		Int $objectID, String $objectIDKey, String $dataTableName. 
	* Optional: 		String $relationTableName, Array $relations
	* Returns: 			Array of data about object.
	* Basic example: 	get_object(23, 'tournamentID', 'tournamentData');
	* Complex example: [Returns a tournament, including all data about the corresponding sport, and all data about the corresponding sport category]
		$relations = array(
			array( 
				"objectIDKey" => "sportID",
				"dataTableName" => "sportData",
				"relationTableName" => "sports",
				"relations" => array( 
					array( 
						"objectIDKey" => "sportCategoryID",
						"dataTableName" => "sportCategoryData"
					)
				)
			)
		);
		$tournament = $this->get_object($tournamentID, "tournamentID", "tournamentData", "tournaments", $relations);
	*/
	public function get_object($objectID, $objectIDKey, $dataTableName, $relationTableName = "", $relations = array()) {
		// If user gave us something other than an array, assume bad input - return FALSE
		if(!is_array($relations)) return FALSE;
		// Create query to get all the key names so we know what to select later on
		$dataKeysRows = $this->db->select('key')->from($dataTableName)->where($objectIDKey,$objectID)->get()->result_array();
		// Get all the key names into an indexed array
		$dataKeys = array_map( function($row) { return $row['key']; }, $dataKeysRows );
		// If we have no data about this tournament, return FALSE to make logic easier in controller 
		if(count($dataKeys)==0) return FALSE;
		// Create SQL selection segments for each key in the data, ready to implode with commas into a full SQL query 
		foreach($dataKeys as $dataKey) $dataQueryStringParts[] = "MAX(CASE WHEN `key`='$dataKey' THEN value END ) AS $dataKey";
		// Build and execute query to actually select data from data table
		$dataQueryString = "SELECT ".implode(', ', $dataQueryStringParts)." 
						    FROM `".mysql_real_escape_string($dataTableName)."` 
							 WHERE `".mysql_real_escape_string($objectIDKey)."` = '".mysql_real_escape_string($objectID)."'";
		$dataQuery = $this->db->query($dataQueryString);
		// No data was returned by the query, something must have gone wrong
		if ($dataQuery->num_rows() == 0) return FALSE;
		// Put the returned data in the data variable ready to add more to and eventually output 
		$object = $dataQuery->row_array();

		// Loop through all the relations we were given and grab all the data for them, stitch it onto the data we already have about this object 
		foreach($relations as $relation) {
			// Get the ID of whichever other object we wish to grab data for 
			$relationObjectIDQueryRow = $this->db->select($relation['objectIDKey'])->from($relationTableName)->where($objectIDKey,$objectID)->get()->row_array();
			// If the relation table does not return a result when queried for the relation object key, we have bad input - die. 
			if(count($relationObjectIDQueryRow)==0) return FALSE;
			// Get the actual ID, put it into relation array for safekeeping
			$relation['objectID'] = $relationObjectIDQueryRow[$relation['objectIDKey']];
			// Put the ID in the object output array too, controllers might use it for other things
			$object[$relation['objectIDKey']] = $relation['objectID']; 
			// Set blank values for the relation variables if they have been omitted
			$relation['relationTableName'] = (isset($relation['relationTableName']) ? $relation['relationTableName'] : '');
			$relation['relations'] = (isset($relation['relations']) ? $relation['relations'] : array() );
			// Get the data for the actual object, passing in the known parameters
			$object[$relation['dataTableName']] = $this->get_object($relation['objectID'], $relation['objectIDKey'], $relation['dataTableName'], $relation['relationTableName'], $relation['relations']);
		}
		
		// Add all values from the relational table to the output - this covers structure such as users table
		if($relationTableName) {
			$relationTableData = $this->db->select('*')->from($relationTableName)->where($objectIDKey,$objectID)->get()->row_array();			
			foreach($relationTableData as $field=>$value) {
				// Add value directly to object, overwriting existing values
				$object[$field]=$value;
			}
		}
		
		// Put the ID value which we already know back into the output for convenience
		$object[$objectIDKey] = $objectID;
		// Finally return all the data - a beautifully crafted multidimensional array
		return $object;
	}
	
	/* Inserts a new object into the database
	* Required: 		Array $data, String $objectIDKey, String $dataTableName.
	* Optional: 		String $relationTableName, Array $relations
	* Returns: 			ID of object created.
	* Basic example: 	insert_object( array("address"=>"14 Parkhead Loan"), 'centreID', 'centreData');
	* Complex example: 	
	*/
	public function insert_object($data, $objectIDKey, $dataTableName, $relationTableName = false, $relations = array()) {
		// Lump all inserts into one transaction
		$this->db->trans_start();
		
		// If we've been given a relational table and relations to go in that table, we should create the entry in that first to get the ID to use for the data
		if( $relationTableName && count($relations) ) {
			// Insert the row in the relation table with all the relations specified, generating an ID using AUTO_INCREMENT 
			$this->db->insert($relationTableName, $relations);
			// Get the generated ID of this new object
			$objectID = $this->db->insert_id();
		} else {
			// Since we're storing IDs only in the data table, we can't have a primary key or auto increment on it
			// Therefore to get the next ID to insert, we have to find the current highest and increment it to get a unique ID
			$this->db->select_max($objectIDKey);
			$maxRow = $this->db->get($dataTableName)->row_array();
			// This is the actual numerical ID we wish to insert data as
			$objectID = $maxRow[$objectIDKey]+1;
		}
		// Loop through input data
		foreach($data as $key => $value) {
			// Set the values for the insert
			$insert = array(
				$objectIDKey => $objectID,
				'key'   => $key,
				'value' => $value
			);
			// Create the insert - active record sanitizes inputs automatically. Return false if insert fails.
			if(!$this->db->insert($dataTableName, $insert)) return FALSE;			
		}
		// Complete transaction, all is well
		$this->db->trans_complete();
		
		// Check for insertion failure
		if ($this->db->trans_status() === FALSE) {
			return FALSE;
		}
		
		// Return the newly generated ID of this object, ready for referencing with get_object
		return $objectID;
	}
	
	// Updates an object in the database with new values
	// Required: $objectID, $data, $objectIDKey, $dataTableName. 
	// Example usage: update_object(1, array("address"=>"14 Parkhead Loan"), "centreID", 'centreData');
	// Returns: TRUE if update was successful, FALSE otherwise.
	public function update_object($objectID, $data, $objectIDKey, $dataTableName, $relationTableName = false, $relationIDs = array()) {
		// If we've been given a relational table and relations to go in that table, we should update the entry in that first in case of foreign key restraints
		if( $relationTableName && count($relationIDs) ) {
			// Update the correct row in the relation table with the new relation IDs specified 
			$this->db->where($objectIDKey, $objectID);
			// If the update fails, return FALSE
			if(!$this->db->update($relationTableName, $relationIDs)) return FALSE;
		}
		
		// Lump all updates into one transaction
		$this->db->trans_start();
		// Loop through input data
		foreach($data as $key => $value) {
			// Set the values for the replace into
			$replace = array(
				$objectIDKey => $objectID,
				'key'   => $key,
				'value' => $value
			);
			// Create the insert - active record sanitizes inputs automatically. Return false if insert fails.
			if(!$this->db->replace_into($dataTableName, $replace)) return FALSE;			
		}
		// Complete transaction, all is well
		$this->db->trans_complete();
		
		// Check for insertion failure
		if ($this->db->trans_status() === FALSE) {
			return FALSE;
		}
		
		// Return TRUE: if we got to here it must have all worked
		return TRUE;
	}
	
	// Deletes an object from the database, optionally also deleting any dependents
	// Required: $testRun, $objectID, $objectIDKey, $primaryTableName. 
	// Example usage: delete_object(1, "centreID", "centreData", false);
	// Returns: TRUE if update was successful, FALSE otherwise.
	public function delete_object($objectID, $objectIDKey, $primaryTableName, $testRun=TRUE) {
		// This string will hold the message showing what will be deleted
		$testResults = array();
		// Lump all data table updates into one transaction in case one fails
		$this->db->trans_start();
		// Get the list of tables this object might have dependent rows in
		$dependents = $this->table_dependents[$primaryTableName];
		// Iterate through dependents to process corresponding entries from - these should be in a specific order to satisfy foreign keys
		foreach( $dependents as $table=>$field ) {
			// Search this table for our object key/ID - if it exists, we want to delete whatever object was referencing our object
			//var_dump("Searching table: $table for field: $objectIDKey set to value: $objectID"); 
			$dependentRows = $this->db->get_where($table, array($objectIDKey => $objectID))->result_array();
			// Loop through all rows which were referencing this object
			foreach($dependentRows as $dependentRow) {
				//$testResults[] = "Calling delete object on $table - $field, deleting ID: {$dependentRow[$field]}\n";
				// Now call the delete function on dependent object - we get the ID from the field name (specified in the global array) in the returned row 
				$deleteResult = $this->delete_object($dependentRow[$field], $field, $table, $testRun);
				if(!$deleteResult) return FALSE;
				if($testRun) $testResults += $deleteResult;
			}
		}
		
		// We've dealt with any dependents, now we just need to delete the row(s) in our primary table
		if($testRun) {
			$rows = $this->db->get_where($primaryTableName, array($objectIDKey => $objectID))->result_array();
			// Start message showing what will be deleted
			$testResults[] = ucfirst($primaryTableName)." with $objectIDKey = $objectID (".count($rows)." rows)\n";
			foreach($rows as $row) {
				$rowfields = array();
				$rowResult = "Table: $primaryTableName; Row: ";
				foreach($row as $key=>$value) $rowfields[] = "[$key] = $value";
				$rowResult .= implode(' | ',$rowfields)." \n";
				//$testResults[] = $rowResult;
			}
		} else {			
			// Delete the rows in the table table which reference the deleted object 
			$this->db->where($objectIDKey, $objectID);
			// If the delete fails, return false
			if(!$this->db->delete($primaryTableName)) return FALSE;
		}
		
		// Complete transaction, all is well
		$this->db->trans_complete();
		// Return TRUE: if we got to here it must have all worked
		if($testRun) {
			$testResultsUnique = array_unique($testResults);
			return $testResultsUnique;
		}
		return TRUE;
	}

	
	function datetime_range($inputArray, $startTime, $endTime, $startKey, $endKey) {
		try {
			$startTime = is_object($startTime) ? $startTime : new DateTime($startTime);
			$endTime = is_object($endTime) ? $endTime : new DateTime($endTime);
		} catch (Exception $e) {
			log_message('error', "ERROR: Invalid input date. Debug Exception: ".$e->getMessage());
			return FALSE;
		}
		
		foreach($inputArray as $inputArrayKey => $element) {
			try {
				$elementStartTime = is_object($element[$startKey]) ? $element[$startKey] : new DateTime($element[$startKey]);
				$elementEndTime = is_object($element[$endKey]) ? $element[$endKey] : new DateTime($element[$endKey]);
			} catch (Exception $e) {
				log_message('error', "ERROR: Invalid date in database. Debug Exception: ".$e->getMessage());
				return FALSE;
			}

			if( !($startTime < $elementEndTime && $elementStartTime < $endTime) ) unset($inputArray[$inputArrayKey])
		}
		return $inputArray;
	}
}