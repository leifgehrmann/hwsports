<?php
class Centre_model extends MY_Model {

	/**
	 * Returns an array of all data about a specific centre
	 *  
	 * @return array
	 **/
	public function get_centre($centreID) {
		return $this->get_object($centreID, "centreID", "centreData");
	}

	/**
	 * Creates a new centre with data.
	 * Returns the centreID of the new centre if it was successful.
	 * Returns FALSE on any error or insertion failure (including foreign key restraints).
	 *  
	 * @return int
	 **/
	public function insert_centre($data) {
		return $this->insert_object($data, "centreID", "centreData");
	}
	
	/**
	 * Updates data for a specific centre.
	 * Returns TRUE on success.
	 * Returns FALSE on any error or insertion failure (including foreign key restraints).
	 *
	 * @return boolean
	 **/
	public function update_centre($centreID, $data) {
		return $this->update_object($centreID, "centreID", $data, 'centreData');
	}
}