<?php
class MY_Model extends CI_Model {
    
	public function __construct() {
        parent::__construct();
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
		// Sanitize / escape input variables into underscored variable names for simplicity
		$_objectID = mysql_real_escape_string($objectID);
		$_objectIDKey = mysql_real_escape_string($objectIDKey);
		$_dataTableName = mysql_real_escape_string($dataTableName);
		$_relationTableName = mysql_real_escape_string($relationTableName);
		
		// If user gave us something other than an array, assume bad input - return FALSE
		if(!is_array($relations)) return FALSE;
		// Create query to get all the key names so we know what to select later on
		$dataKeysQuery = $this->db->query("SELECT `key` FROM `$_dataTableName` WHERE `$_objectIDKey` = '$_objectID'");
		// Get all the key names into an indexed array
		$dataKeys = array_map( function($row) { return $row['key']; }, $dataKeysQuery->result_array() );
		// If we have no data about this tournament, return FALSE to make logic easier in controller 
		if(count($dataKeys)==0) return FALSE;
		// Create SQL selection segments for each key in the data, ready to implode with commas into a full SQL query 
		foreach($dataKeys as $dataKey) $dataQueryStringParts[] = "MAX(CASE WHEN `key`='$dataKey' THEN value END ) AS $dataKey";
		// Build and execute query to actually select data from data table
		$dataQueryString = "SELECT " . implode(', ', $dataQueryStringParts) . " FROM `$_dataTableName` WHERE `$_objectIDKey` = '$_objectID'";
		$dataQuery = $this->db->query($dataQueryString);
		// No data was returned by the query, something must have gone wrong
		if ($dataQuery->num_rows() == 0) return FALSE;
		// Put the returned data in the data variable ready to add more to and eventually output 
		$object = $dataQuery->row_array();

		// Loop through all the relations we were given and grab all the data for them, stitch it onto the data we already have about this object 
		foreach($relations as $relation) {
			// Get the ID of whichever other object we wish to grab data for 
			$relationObjectIDQuery = $this->db->query("SELECT `{$relation['objectIDKey']}` FROM `$_relationTableName` WHERE `$_objectIDKey` = '$_objectID'");			
			// If the relation table does not return a result when queried for the relation object key, we have bad input - die. 
			if ($relationObjectIDQuery->num_rows() == 0) return FALSE;
			// Get the row which contains the actual ID of the object we want to grab data for
			$relationObjectIDQueryRow = $relationObjectIDQuery->row_array();
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
		
		// Lump all inserts into one transaction
		$this->db->trans_start();
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
		
		// Return TRUE: if we got to here it must have all worked
		return TRUE;
	}
	
	// Deletes an object from the database, optionally also deleting any dependents
	// Required: $objectID, $objectIDKey, $data, $dataTableName. 
	// Example usage: delete_object(1, "centreID", 'centreData');
	// Returns: TRUE if update was successful, FALSE otherwise.
	public function delete_object($testRun=TRUE, $objectID, $objectIDKey, $dataTableName, $relationTableName, $dependents = array()) {
		// This string will hold the message to the user explaining what will be deleted
		$testResults = "If this delete query is executed, the following rows will be deleted: \n";
		// Lump all data table updates into one transaction in case one fails
		$this->db->trans_start();
		// Append the data table and then the relation table to the list of tables to delete from - this way they are processed in the right order
		$tables = $dependents;
		$tables[] = $dataTableName;
		$tables[] = $relationTableName;
		
		// Iterate through tables to delete corresponding entries from - execute in order to satisfy foreign keys
		foreach( $tables as $table ) {
			if($testRun) {
				$rows = $this->db->get_where($table, array($objectIDKey => $objectID))->result_array();
				foreach($rows as $row) {
					$rowfields = array();
					$testResults .= "Table: $table; Row: ";
					foreach($row as $key=>$value) $rowfields[] = "[$key] = $value";
					$testResults .= implode(' | ',$rowfields)." \n\n";
				}
			} else {			
				// Delete the rows in the table table which reference the deleted object 
				$this->db->where($objectIDKey, $objectID);
				$this->db->delete($table);
			}
		}
		
		// Complete transaction, all is well
		$this->db->trans_complete();
		
		// Return TRUE: if we got to here it must have all worked
		if($testRun) return $testResults;
		else return TRUE;
	}

}