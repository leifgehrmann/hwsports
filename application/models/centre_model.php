<?php
class Centre_model extends MY_Model {

	/**
	 * Returns an array of data from a specific centre
	 *  
	 * @return array
	 **/
	public function get_centre($centreID) {
		return $this->get_object($centreID, "centreID", "centreData");
	}

	/**
	 * Creates a centre with data.
	 * returns the centreID of the new centre if it was successful; otherwise FALSE.
	 *  
	 * @return int
	 **/
	public function insert_centre($data) {
		return $this->insert_object($data, "centreID", "centreData");
	}
	
	/**
	 * Updates a centre with data.
	 *
	 * @return boolean
	 **/
	public function update_centre($centreID, $data){

		$this->db->trans_start();

		foreach($data as $key=>$value) {
			$escKey = $this->db->escape($key);
			$escValue = $this->db->escape($value);
			$dataQueryString = 	"UPDATE `centreData` ".
								"SET `value`=$escValue ".
								"WHERE `key`=$escKey ".
								"AND `centreID`=$centreID";
			$this->db->query($dataQueryString);
		}
		$this->db->trans_complete();
		return true;
	}
}