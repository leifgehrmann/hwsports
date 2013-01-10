<?php
class Venues_model extends CI_Model {

	/**
	 * Returns a 2d array of venue data
	 *  
	 * @return array
	 **/

	public function get_all_venues_data($centreID, $fields)
	{
		$output = array();
		$queryString = "SELECT venueID FROM venues WHERE centreID = $centreID";
		$query = $this->db->query($queryString);
		$array = $query->result_array();
		foreach($array as $venue) {
			$output[] = $this->get_venue_data($venue['venueID'],$fields);
		}
		return $output;
	}

	/**
	 * Returns an array of data from a specific venue
	 *  
	 * @return array
	 **/
	public function get_venue_data($venueID, $fields=array("name","description","directions","lat","lng"))
	{
		$dataQueryString = "SELECT ";
		$i = 0;
		$len = count($fields);
		foreach($fields as $field) {
			$dataQueryString .= "MAX(CASE WHEN `key`='$field' THEN value END ) AS $field";
			if($i<$len-1)
				$dataQueryString .= ", ";
			else
				$dataQueryString .= " ";
			$i++;
		}
		$dataQueryString .= "FROM venueData WHERE venueID = $venueID";
		$dataQuery = $this->db->query($dataQueryString);
		$output = array_merge(array("venueID"=>$venueID), $dataQuery->row_array());
		return $output;
	}

	public function create_venue($centreID, $data)
	{

	}
}