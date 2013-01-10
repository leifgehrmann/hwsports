<?php
class Venues_model extends CI_Model {

	/**
	 * Returns a 2d array of venueID => 
	 *  
	 * @return array
	 **/

	public function get_venues($centreID,$fields=array("name","description","directions","lat","lng"))
	{
		$output = array();
		$queryString = "SELECT venueID FROM venues WHERE centreID = $centreID";
		$query = $this->db->query($queryString);
		$array = $query->result_array();
		foreach($array as $venue) {
			$dataQueryString = "SELECT ";
			foreach($fields as $field) {
				$dataQueryString .= "MAX(CASE WHEN `key`='$field' THEN value END ) AS $field, ";
			}
				//"MAX(CASE WHEN `key`='name' THEN value END ) AS name, " .
				//"MAX(CASE WHEN `key`='description' THEN value END ) AS description, " .
				//"MAX(CASE WHEN `key`='directions' THEN value END ) AS directions, " .
				//"MAX(CASE WHEN `key`='lat' THEN value END ) AS lat, " .
				//"MAX(CASE WHEN `key`='lng' THEN value END ) AS lng " .
				$dataQueryString .= "FROM venueData WHERE venueID = {$venue['venueID']}";
			$dataQuery = $this->db->query($dataQueryString);
			$output[$venue['venueID']] = array_merge($venue, $dataQuery->row_array());
		}
		return $output;
	}

	public function get_venue_data($centreID, $venueID)
	{

	}

	public function create_venue($centreID, $data)
	{

	}
}