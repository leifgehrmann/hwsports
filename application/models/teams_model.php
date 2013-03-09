<?php
class Teams_model extends MY_Model {

	/**
	 * Returns all data about a specific team, including all team members in $team['users']
	 *  
	 * @return array
	 **/
	public function get_team($teamID) {
		// Get all the teamData
		$team = $this->get_object($teamID, "teamID", "teamData");
		// Load the users model since we want to use the get_user function
		$this->load->model('users_model');
		// Query the teamsUsers table for user IDs
		$userIDsQuery = $this->db->query("SELECT `userID` FROM `teamsUsers` WHERE `teamID` = ".$this->db->escape($teamID) );
		foreach($usersQuery->result_array() as $userIDrow) {
			// Put each user into the team array, indexed by their userID for convenience
			$team['users'][$userIDrow['userID']] = $this->users_model->get_user($userIDrow['userID']);
		}
		return $team;
	}
	
	/**
	 * Returns all data about all teams at a specific centre
	 *  
	 * @return array
	 **/
	public function get_teams($centreID) {
		// Query to return the IDs for everything which takes place at the specified sports centre
		$IDsQuery = $this->db->query("SELECT teamID FROM teams WHERE centreID = ".$this->db->escape($centreID));
		// Loop through all result rows, get the ID and use that to put all the data into the output array 
		foreach($IDsQuery->result_array() as $IDRow) {
			$all[] = $this->get_team($IDRow['teamID']);
		}
		return (empty($all) ? FALSE : $all);
	}

	/**
	 * Returns all data about teams in a particular tournament
	 *  
	 * @return array
	 **/
	public function get_tournament_teams($tournamentID) {
		// Not implemented yet (should teams table have a tournament field, or should it be in tournamentData?)
		return FALSE;
	}

	/**
	 * Creates a team with data.
	 * returns the teamID of the new team if it was
	 * successful. If not, it should return -1.
	 *  
	 * @return int
	 **/
	public function insert_team($centreID,$data)
	{	
		// Create team, get ID
		$this->db->query("INSERT INTO teams (centreID) VALUES ({$centreID})");
		$teamID = $this->db->insert_id();

		$this->db->trans_start();
		
		$insertDataArray = array();
		foreach($data as $key=>$value) {
			$insertDataArray[] = array(
				'teamID' => $this->db->escape($teamID),
				'key' => $this->db->escape($key),
				'value' => $this->db->escape($value)
			);
		}
		if ($this->db->insert_batch('teamData',$insertDataArray)) {
			// db success
			$this->db->trans_complete();
			return $teamID;
		} else {
			// db fail
			return false;
		}
	}

	
	/**
	 * Adds users to team
	 *  
	 * @return bool
	 **/
	public function add_team_members($teamID, $userIDs)
	{	
		$this->db->trans_start();
		
		$insertDataArray = array();
		foreach($userIDs as $userID) {
			$insertDataArray[] = array(
				'teamID' => $this->db->escape($teamID),
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
	 * Updates a team with data.
	 *
	 * @return boolean
	 **/
	public function update_team($teamID, $data){

		$this->db->trans_start();

		if($this->team_exists($teamID)){
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
										$teamID,
										$escKey,
										$escValue
									)";
				$this->db->query($dataQueryString1);
				$this->db->query($dataQueryString2);
			}
			$this->db->trans_complete();
			return true;
		} else {
			return false;
		}
	}
}