<?php
class Venues_model extends CI_Model {

	/**
	 * $venueID is int(11)
	 *  
	 * @return boolean
	 **/

	public function venue_exists($venueID)
	{
		$output = array();
		$queryString = 	"SELECT ".$this->db->escape($venueID)." AS venueID, ".
						"EXISTS(SELECT 1 FROM venues WHERE venueID = ".$this->db->escape($venueID).") AS `exists`";
		$queryData = $this->db->query($queryString);
		$output = $queryData->row_array();
		return $output['exists'];
	}

	/**
	 * Returns a 2d array of venue data
	 *  
	 * @return array
	 **/

	public function get_venues($centreID, $fields=array("name","description","directions","lat","lng"))
	{
		$output = array();
		$queryString = "SELECT venueID FROM venues WHERE centreID = ".$this->db->escape($centreID);
		$queryData = $this->db->query($queryString);
		$data = $queryData->result_array();
		foreach($data as $venue) {
			$output[] = $this->get_venue($venue['venueID'],$fields);
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
			$dataQueryString .= "MAX(CASE WHEN `key`=".$this->db->escape($field)." THEN value END ) AS ".$this->db->escape($field);
			if($i<$len-1)
				$dataQueryString .= ", ";
			else
				$dataQueryString .= " ";
			$i++;
		}
		$dataQueryString .= "FROM venueData WHERE venueID = ".$this->db->escape($venueID);
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
		$this->db->trans_start();

		$this->db->query("INSERT INTO venues (centreID) VALUES (".$this->db->escape($centreID).")");
		$venueID = $this->db->insert_id();

		$insertDataArray = array();
		foreach($data as $key=>$value) {
			$dataArray = array(
					'venueID' => $this->db->escape($venueID),
					'key' => $this->db->escape($key),
					'value' => $this->db->escape($value)
				);
			$insertDataArray[] = $dataArray;
		}
		if ($this->db->insert_batch('venueData',$insertDataArray)) {
			// db success
			$this->db->trans_complete();
			return $venueID;
		} else {
			// db fail
			return -1;
		}
	}

	/**
	 * Updates a venue with data.
	 *
	 * @return boolean
	 **/
	public function update_venue($venueID, $data){

		$this->db->trans_start();

		if($this->venue_exists($venueID)){
			foreach($data as $key=>$value) {
				$escKey = $this->db->escape($key);
				$escValue = $this->db->escape($value);
				$dataQueryString = 	"UPDATE `venueData` ".
									"SET `value`=$escValue ".
									"WHERE `key`=$escKey ".
									"AND `venueID`=$venueID";
				$this->db->query($dataQueryString);
			}
			$this->db->trans_complete();
			return true;
		} else {
			return false;
		}
	}
}