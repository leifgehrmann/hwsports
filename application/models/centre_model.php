<?php
class Centre_model extends MY_Model {

	public function __construct() {
        parent::__construct();
		// Basic variables which apply to all table operations
		$this->objectIDKey = "centreID";
		$this->dataTableName = "centreData";
    }
	/**
	 * Returns an array of all data about a specific centre
	 * 
	 * @return array
	 **/
	public function get($ID) {
		return $this->get_object($ID, $this->objectIDKey, $this->dataTableName);
	}

	/**
	 * Creates a new centre with data.
	 * Returns the centreID of the new centre if it was successful.
	 * Returns FALSE on any error or insertion failure (including foreign key restraints).
	 * 
	 * @return int
	 **/
	public function insert($data) {
		return $this->insert_object($data, $this->objectIDKey, $this->dataTableName);
	}
	
	/**
	 * Updates data for a specific centre.
	 * Returns TRUE on success.
	 * Returns FALSE on any error or insertion failure (including foreign key restraints).
	 * 
	 * @return boolean
	 **/
	public function update($ID, $data) {
		return $this->update_object($ID, $data, $this->objectIDKey, $this->dataTableName);
	}
	
	/**
	 * Deletes a centre with data.
	 * Also deletes all objects which depend on it. 
	 * If $testRun is TRUE, no deletion occurs. Instead, a string is returned showing all deletions which would occur otherwise.
	 * Returns TRUE on success.
	 * Returns FALSE on any error or deletion failure (most likely forgotten foreign key restraints).
	 *
	 * @return boolean
	 **/
	public function delete($ID, $testRun=TRUE) {
		return $this->delete_object($ID, $this->objectIDKey, $this->dataTableName, $testRun);
	}
	
}