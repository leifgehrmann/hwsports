<?php
class MY_Model extends CI_Model {
    
	public function __construct()
    {
        parent::__construct();
    }

	// Queries an object from the database
	// Required: $objectID, $objectIDKey, $dataTableName. Example usage: get_object(23, 'tournamentID', 'tournamentData');
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
	
	// Inserts a new object into the database
	// Required: $data, $objectIDKey, $dataTableName. Example usage: insert_object(array("address"=>"14 Parkhead Loan"), 'centreID', 'centreData');
	// Returns: ID of object created.
	public function insert_object($data, $objectIDKey, $dataTableName, $relationTableName = false, $relations = array()) {
		// Sanitize / escape input variables into underscored variable names for simplicity
		$_objectIDKey = mysql_real_escape_string($objectIDKey);
		$_dataTableName = mysql_real_escape_string($dataTableName);
		$_relationTableName = mysql_real_escape_string($relationTableName);
		
		// If we've been given a relational table and relations to go in that table, we should create the entry in that first to get the ID to use for the data
		if( $relationTableName && count($relations) ) {
			// Insert the row in the relation table with all the relations specified, generating an ID using AUTO_INCREMENT 
			$this->db->insert($relationTableName, $relations);
			// Get the generated ID of this new object
			$objectID = $this->db->insert_id();
		} else {
			// Since we're storing IDs only in the data table, we can't have a primary key or auto increment on it
			// Therefore to get the next ID to insert, we have to find the current highest and increment it to get a unique ID
			$maxRow = $this->db->query("SELECT MAX($_objectIDKey) AS maxID FROM `$_dataTableName`")->row_array();
			$objectID = $maxRow['maxID']+1;
		}
		
		// Lump all queries into one transaction
		$this->db->trans_start();
		// Loop through input data
		foreach($data as $key => $value) {
			// Sanitize inputs
			$_key = mysql_real_escape_string($key);
			$_value = mysql_real_escape_string($value);
			// Insert a row of data into the data table with correct keys and the newly generated ID
			var_dump("INSERT INTO `$_dataTableName` ('$_objectIDKey', 'key', 'value') VALUES ('$objectID', '$_key', '$_value')");
			$this->db->query("INSERT INTO `$_dataTableName` ('$_objectIDKey', 'key', 'value') VALUES ('$objectID', '$_key', $_value')");
		}
		// Complete transaction, all is well
		$this->db->trans_complete();
		
		// Return the newly generated ID of this object, ready for referencing with get_object
		return $objectID;
	}
				
	// $this->db->query("UPDATE `$_dataTableName` SET `value` = '$_value' WHERE `key` = '$_key'");

}