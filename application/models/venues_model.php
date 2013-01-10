<?php
class venues extends CI_Model {

	public function get_venues($centreID)
	{
		$output = array();
		$queryString = "SELECT venueID FROM venues WHERE centreID = $centreID";
		$query = $this->db->query($queryString);
		$array = $query->result_array();
		foreach($array as $venue) {
			$dataQueryString = "SELECT " .
				"MAX(CASE WHEN `key`='name' THEN value END ) AS name, " .
				"MAX(CASE WHEN `key`='description' THEN value END ) AS description, " .
				"MAX(CASE WHEN `key`='directions' THEN value END ) AS directions, " .
				"MAX(CASE WHEN `key`='lat' THEN value END ) AS lat, " .
				"MAX(CASE WHEN `key`='lng' THEN value END ) AS lng " .
				"FROM venueData WHERE venueID = {$venue['venueID']}";
			$dataQuery = $this->db->query($dataQueryString);
			$output = array_merge($venue, $dataQuery->row_array());
		}
		return $output;
	}

	public function get_venue_data($centreID, $venueID)
	{

	}

	public function create_venue_data($centreID, $data)
	{

	}
}