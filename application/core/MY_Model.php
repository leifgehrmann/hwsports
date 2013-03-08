<?php
class MY_Model extends CI_Model {
    
	public function __construct()
    {
        parent::__construct();
    }

	public function get_data($objectID, $objectIDKey, $relationTableName, $dataTableName, $relations = array()) {
		// Sanitize / escape input variables into underscored variable names for simplicity
		$_objectID = mysql_real_escape_string($objectID);
		$_objectIDKey = mysql_real_escape_string($objectIDKey);
		$_relationTableName = mysql_real_escape_string($relationTableName);
		$_dataTableName = mysql_real_escape_string($dataTableName);
		
		// If user gave us something other than an array, assume bad input - return FALSE
		if(!is_array($relations)) return FALSE;
		// Create query to get all the key names so we know what to select later on
		$dataKeysQuery = $this->db->query("SELECT `key` FROM `$_dataTableName` WHERE `$_objectIDKey` = '$_objectID'");
		// Get all the key names into an indexed array
		$dataKeys = array_values($dataKeysQuery->result_array());
		// If we have no data about this tournament, return FALSE to make logic easier in controller 
		if(count($dataKeys)==0) return FALSE;
		
		// Create SQL selection segments for each key in the data, ready to implode with commas into a full SQL query 
		foreach($dataKeys as $dataKey) $dataQueryStringParts[] = "MAX(CASE WHEN `key`='$dataKey' THEN value END ) AS $dataKey";
		// Build and execute query to actually select data from data table 
		$dataQuery = $this->db->query("SELECT " . implode(', ', $dataQueryStringParts) . " FROM `$_dataTableName` WHERE `$_objectIDKey` = '$_objectID'");
		// No data was returned by the query, something must have gone wrong
		if ($dataQuery->num_rows() == 0) return FALSE;
		// Put the returned data in the data variable ready to add more to and eventually output 
		$data = $dataQuery->row_array();

		// Loop through all the relations we were given and grab all the data for them, stitch it onto the data we already have about this object 
		foreach($relations as $relation) {
			// Create escaped version of relation input array
			$relation = array_map(mysql_real_escape_string, $relation);
			// Get the ID of whichever other object we wish to grab data for 
			$relationObjectIDQuery = $this->db->query("SELECT `{$relation['objectIDKey']}` FROM `$_relationTableName` WHERE `$_objectIDKey` = '$_objectID'");
			// If the relation table does not return a result when queried for the relation object key, we have bad input - die. 
			if ($relationObjectIDQuery->num_rows() == 0) return FALSE;
			// Get the row which contains the actual ID of the object we want to grab data for
			$relationObjectIDQueryRow = $relationObjectIDQuery->row_array();
			// Get the actual ID, put it into relation array for safekeeping
			$relation['objectID'] = $relationObjectIDQueryRow[$relation['objectIDKey']];
			// Get the data for the actual object, passing in the known parameters
			$data['relations'][$relation['relationTableName']] = $this->get_data($relation['objectID'], $relation['objectIDKey'], $relation['relationTableName'], $relation['dataTableName'], $relation['relations']);
		}
		
		return $data;
	}

}