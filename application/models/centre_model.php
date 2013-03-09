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
	 * returns the centreID of the new centre if it was
	 * successful. If not, it should return -1.
	 *  
	 * @return int
	 **/
	public function insert_centre($data)
	{	
		$this->db->trans_start();

		$this->db->query("INSERT INTO centreData (centreID) VALUES (".$this->db->escape($centreID).")");
		$centreID = $this->db->insert_id();

		$insertDataArray = array();
		foreach($data as $key=>$value) {
			$dataArray = array(
					'centreID' => $this->db->escape($centreID),
					'key' => $this->db->escape($key),
					'value' => $this->db->escape($value)
				);
			$insertDataArray[] = $dataArray;
		}
		if ($this->db->insert_batch('centreData',$insertDataArray)) {
			// db success
			$this->db->trans_complete();
			return $centreID;
		} else {
			// db fail
			return -1;
		}
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