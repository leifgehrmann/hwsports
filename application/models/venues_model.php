<?php
class Venues_model extends CI_Model {

	/**
	 * Returns a 2d array of venue data
	 *  
	 * @return array
	 **/

	public function get_venues($centreID, $fields=array("name","description","directions","lat","lng"))
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
	public function get_venue($venueID, $fields=array("name","description","directions","lat","lng"))
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

	/**
	 * Creates a venue with data.
	 * returns the venueID of the new venue if it was
	 * successful. If not, it should return -1.
	 *  
	 * @return int
	 **/
	public function insert_venue($centreID, $data)
	{
		$this->db->query("INSERT INTO venues (centreID) VALUES ($centreID)");
		$venueID = $this->db->insert_id();

		$insertDataArray = array();
		foreach($data as $key=>$value) {
			$dataArray = array(
					'venueID' => $venueID,
					'key' => $key,
					'value' => $value
				);
			$insertDataArray[] = $dataArray;
		}
		if ($this->db->insert_batch('venueData',$insertDataArray)) {
			// db success
			return $venueID;
		} else {
			// db fail
			return -1;
		}
	}

	/**
	 * Updates a venue with data.
	 * return True if success, False if failure
	 *  
	 * @return int
	 **/
	public function update_venue($venueID, $data){

	}
}