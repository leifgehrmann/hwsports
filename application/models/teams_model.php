<?php
class Teams_model extends CI_Model {

	/**
	 * $teamID is int(11)
	 *  
	 * @return boolean
	 **/

	public function team_exists($teamID)
	{
		$output = array();
		$queryString = 	"SELECT ".$this->db->escape($teamID)." AS teamID, ".
						"EXISTS(SELECT 1 FROM teams WHERE teamID = ".$this->db->escape($teamID).") AS `exists`";
		$queryData = $this->db->query($queryString);
		$output = $queryData->row_array();
		return $output['exists'];
	}

	/**
	 * Returns all team data for the teams in a particular tournament
	 *  
	 * @return array
	 **/

	public function get_tournament_teams($tournamentID)
	{
		/*$output = array();
		$queryString = "SELECT sportID FROM sports WHERE centreID = ".$this->db->escape($centreID);
		$queryData = $this->db->query($queryString);
		$data = $queryData->result_array();
		foreach($data as $sport) {
			$output[] = $this->get_sport($sport['sportID']);
		}
		return $output;*/
	}

	/**
	 * Returns all team data for the teams in a 
	 *  
	 * @return array
	 **/

	public function get_teams($centreID)
	{
		$output = array();
		$queryString = "SELECT teamID FROM teams WHERE centreID = ".$this->db->escape($centreID);
		$queryData = $this->db->query($queryString);
		$data = $queryData->result_array();
		foreach($data as $team) {
			$output[] = $this->get_team($team['teamID']);
		}
		return $output;
	}

	/**
	 * Returns an array of data for a specific team
	 * It should also return all team members.
	 *  
	 * @return array
	 **/
	public function get_team($teamID)
	{
		$fields = array();
		$fieldsQuery = $this->db->query("SELECT `key` FROM `teamData` WHERE `teamID` = ".$this->db->escape($teamID) );
		$fieldsResult = $fieldsQuery->result_array();
		foreach($fieldsResult as $fieldResult) {
			$fields[] = $fieldResult['key'];
		}

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
		$dataQueryString .= "FROM teamData WHERE teamID = ".$this->db->escape($teamID);
		$dataQuery = $this->db->query($dataQueryString);

		// We would also like to get all the users from the team.
		// So someone should add that in later.
		$users = array();
		$usersQuery = $this->db->query("SELECT `userID` FROM `teamsUsers` WHERE `teamID` = ".$this->db->escape($teamID) );
		$usersResult = $usersQuery->result_array();
		foreach($usersResult as $userResult) {
			$users[] = $fieldResult['key'];
		}

		$output = array_merge(array("teamID"=>$teamID), $dataQuery->row_array());
		$output['users'] = $users;
		return $output;
	}

	/**
	 * Creates a team with data.
	 * returns the teamID of the new team if it was
	 * successful. If not, it should return -1.
	 *  
	 * @return int
	 **/
	public function insert_team($data)
	{	
		// Create team, get ID
		$this->db->query("INSERT INTO teams (centreID) VALUES ({$this->data['centre']['id']})");
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
				$escKey = $this->db->escape($key);
				$escValue = $this->db->escape($value);
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