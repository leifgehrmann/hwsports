<?php
class Venues_model extends MY_Model {

	/**
	 * Returns all data about a specific venue
	 *  
	 * @return array
	 **/
	public function get_venue($venueID) {
		// Get all the venueData
		$venue = $this->get_object($venueID, "venueID", "venueData");
		return $venue;
	}
	
	/**
	 * Returns all data about all venues at a specific centre
	 *  
	 * @return array
	 **/
	public function get_venues($centreID) {
		// Query to return the IDs for everything which takes place at the specified sports centre
		$IDsQuery = $this->db->query("SELECT venueID FROM venues WHERE centreID = ".$this->db->escape($centreID));
		// Loop through all result rows, get the ID and use that to put all the data into the output array 
		foreach($IDsQuery->result_array() as $IDRow) {
			$all[] = $this->get_venue($IDRow['venueID']);
		}
		return (empty($all) ? FALSE : $all);
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
	}
}