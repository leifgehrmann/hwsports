<?php
class Teams_model extends MY_Model {

	public function __construct() {
		// Load models we might be referencing
		$this->load->model('users_model');
		
		// Basic variables which apply to all table operations
		$this->objectIDKey = "teamID";
		$this->dataTableName = "teamData";
		$this->relationTableName = "teams";
    }

	/**
	 * Returns all data about a specific team, including all team members in $team['users']
	 *  
	 * @return array
	 **/
	public function get($ID) {
		// Get all the teamData
		$team = $this->get_object($ID, $this->objectIDKey, $this->dataTableName);
		// Fetch the IDs for all users in the team
		$IDRows = $this->db->get_where('teamsUsers', array('teamID' => $ID))->result_array();
		// Loop through all result rows, get the ID and use that to put all the data into the output array 
		foreach($IDRows as $IDRow) {
			$team['users'][$IDRow['userID']] = $this->users_model->get_user($IDRow['userID']);
		}
		return $team;
	}
	
	/**
	 * Returns all data about all teams at current centre
	 *  
	 * @return array
	 **/
	public function get_all() {
		// Fetch the IDs for everything at the current sports centre
		$IDRows = $this->db->get_where($this->relationTableName, array('centreID' => $this->centreID))->result_array();
		// Create empty array to output if there are no results
		$all = array();
		// Loop through all result rows, get the ID and use that to put all the data into the output array 
		foreach($IDRows as $IDRow) {
			$all[] = $this->get($IDRow[$this->objectIDKey]);
		}
		return $all;
	}
	
	/**
	 * Creates a new tournament with data, using the sport ID as specified.
	 * Returns the ID of the new object if it was successful.
	 * Returns FALSE on any error or insertion failure (including foreign key restraints).
	 *  
	 * @return int
	 **/
	public function insert($data, $relationIDs=array()) {
		return $this->insert_object($data, $this->objectIDKey, $this->dataTableName, $relationIDs);
	}

	/**
	 * Updates data for a specific tournament.
	 * Returns TRUE on success.
	 * Returns FALSE on any error or insertion failure (including foreign key restraints).
	 *
	 * @return boolean
	 **/
	public function update($ID, $data) {
		return $this->update_object($ID, $this->objectIDKey, $data, $this->dataTableName);
	}
	
	/**
	 * Adds users to team
	 *  
	 * @return bool
	 **/
	public function add_team_members($ID, $userIDs)
	{	
		$this->db->trans_start();
		
		$insertDataArray = array();
		foreach($userIDs as $userID) {
			$insertDataArray[] = array(
				$this->objectIDKey => $this->db->escape($ID),
				'userID' => $this->db->escape($userID)
			);
		}
		if ($this->db->insert_batch('teamsUsers',$insertDataArray)) {
			// db success
			$this->db->trans_complete();
			return true;
		} else {
			// db fail
			return false;
		}
	}
	
	
	/**
	 * Deletes a tournament with data.
	 * Also deletes all objects which depend on it, unless $testRun is TRUE in which case a string is returned showing all
	 * Returns TRUE on success.
	 * Returns FALSE on any error or deletion failure (most likely forgotten foreign key restraints).
	 *
	 * @return boolean
	 **/
	public function delete($ID, $testRun=TRUE) {
		$dependents = array(
			'sports' => 'centreID',
			'venues' => 'centreID',
			'tournaments' => 'centreID',
			'teams' => 'centreID'
		);
		return $this->delete_object($testRun, $ID, $this->objectIDKey, $this->dataTableName, false, $dependents);
	}

	
	/**
	 * Updates a team with data.
	 *
	 * @return boolean
	 **/
	public function update_team($ID, $data){

		$this->db->trans_start();

		foreach($data as $key=>$value) {
			$escKey = $this->db->escape( str_replace("'", '', $key) );
			$escValue = $this->db->escape($value);
			error_log("About to INSERT teamData: ".var_export($data,1));
			
			$dataQueryString1 = "DELETE FROM `teamData` WHERE `key`=$escKey AND `teamID`=$userID";
			$dataQueryString2 = "INSERT INTO `teamData` (
									`teamID`,
									`key`,
									`value`
								) VALUES (
									$ID,
									$escKey,
									$escValue
								)";
			$this->db->query($dataQueryString1);
			$this->db->query($dataQueryString2);
		}
		$this->db->trans_complete();
		return true;
	}
}