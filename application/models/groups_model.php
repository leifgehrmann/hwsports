<?php
class Groups_model extends MY_Model {

	public function __construct() {
        parent::__construct();
		// Basic variables which apply to all table operations
		$this->objectIDKey = "groupID";
		$this->dataTableName = "userGroups";
    }
	
	/**
	 * Returns all data about a specific group
	 *  
	 * @return array
	 **/
	public function get($ID) {
		// Get all the groupData
		return $this->db->get_where($this->dataTableName, array($this->objectIDKey => $ID) )->row_array();
	}
	
	/**
	 * Returns all data about all groups at current centre
	 * 
	 * @return array
	 **/
	public function get_all() {
		// Fetch the IDs for everything at the current sports centre
		$IDRows = $this->db->get($this->dataTableName)->result_array();
		// Create empty array to output if there are no results
		$all = array();
		// Loop through all result rows, get the ID and use that to put all the data into the output array 
		foreach($IDRows as $IDRow) {
			$all[$IDRow[$this->objectIDKey]] = $this->get($IDRow[$this->objectIDKey]);
		}
		return $all;
	}
	
	/**
	 * Creates a new group with data
	 * Returns the ID of the new object if it was successful.
	 * Returns FALSE on any error or insertion failure (including foreign key restraints).
	 *  
	 * @return int
	 **/
	public function insert($data) {
		$this->db->insert( $this->dataTableName, $data);
		return $this->db->insert_id();
	}

	/**
	 * Updates data for a specific group.
	 * Returns TRUE on success.
	 * Returns FALSE on any error or insertion failure (including foreign key restraints).
	 *
	 * @return boolean
	 **/
	public function update($ID, $data) {
		return $this->db->update($this->dataTableName, $data, array($this->objectIDKey => $ID) );
	}

	/**
	 * Deletes a group with data.
	 * Also deletes all objects which depend on it, unless $testRun is TRUE in which case a string is returned showing all
	 * Returns TRUE on success.
	 * Returns FALSE on any error or deletion failure (most likely forgotten foreign key restraints).
	 *
	 * @return boolean
	 **/
	public function delete($ID, $testRun=TRUE) {
		if($testRun) {
			return "<li>Group with {$this->objectIDKey} = $ID (1 row)</li>";
		}
		return $this->db->delete($this->dataTableName, array($this->objectIDKey => $ID) );
	}
	
}