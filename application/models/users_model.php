<?php
class Users_model extends CI_Model {

	public function user_exists($userID)
	{
		$output = array();
		$queryString = 	"SELECT ".$this->db->escape($userID)." AS userID, ".
						"EXISTS(SELECT 1 FROM users WHERE id = ".$this->db->escape($userID).") AS `exists`";
		$queryData = $this->db->query($queryString);
		$output = $queryData->row_array();
		return (bool)$output['exists'];
	}

	public function get_users($centreID)
	{
		// To find out if a user is associated with the centre...

		// Tickets > "userID"
		// Tournaments[teamSport=1] > "teams"    >> TeamsUsers > "userID"
		// Tournaments[teamSport=0] > "athletes" >> "userID"
		// UserData[centreID=1] > userID

		$output = array();
		$queryString = "SELECT userID FROM userData WHERE `key`='centreID' AND `value`=".$this->db->escape($centreID);
		$queryData = $this->db->query($queryString);
		$data = $queryData->result_array();
		foreach($data as $user) {
			$output[] = $this->get_user($user['userID']);
		}
		return $output;
	}

	/*public function get_tournament_users($tournamentID)
	{
		$output = array();
		$queryString = "SELECT userID FROM users WHERE centreID = ".$this->db->escape($centreID);
		$queryData = $this->db->query($queryString);
		$data = $queryData->result_array();
		foreach($data as $user) {
			$output[] = $this->get_user($user['userID']);
		}
		return $output;
	}*/

	public function get_user($userID)
	{
		$fields = array();
		$fieldsQuery = $this->db->query("SELECT `key` FROM `userData` WHERE `userID` = ".$this->db->escape($userID) );
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
		$dataQueryString .= "FROM userData WHERE userID = ".$this->db->escape($userID);
		$dataQuery = $this->db->query($dataQueryString);
		
		$output = array_merge(array("userID"=>$userID), $dataQuery->row_array());
		return $output;
	}
	
	public function update_user($userID, $data)
	{
		$this->db->trans_start();
		if($this->user_exists($userID)){
			foreach($data as $key=>$value) {
				$escKey = $this->db->escape($key);
				$escValue = $this->db->escape($value);
				$dataQueryString1 = "DELETE FROM `userData` WHERE `key`=$escKey AND `userID`=$userID";
				$dataQueryString2 = "INSERT INTO `userData` (
										`userID`,
										`key`,
										`value`
									) VALUES (
										$userID,
										$escKey,
										$escValue
									)";
				$this->db->query($dataQueryString1);
				$this->db->query($dataQueryString2);
			}
			return $this->db->trans_complete();
		}
		return false;
	}

	/**
	 * returns an array of teamIDs that the user
	 * is a part of.
	 *
	 * @return array
	 **/
	public function team_memberships($userID){
		$output = array();
		$queryString = 	"SELECT teamID FROM usersTeams WHERE userID = ".$this->db->escape($userID);
		$queryData = $this->db->query($queryString);
		$output = $queryData->result_array();

		$teams = array();
		foreach($output as $row)
			$teams[] = $row['userID'];

		return $teams;
	}
	/**
	 * returns an array of tournamentIDs that the user
	 * is a part of.
	 *
	 * @return array
	 **/
	public function tournament_memberships($userID,$centreID){
		$tournamentIDs = array();

		// Get a list of all teams that the user is associated with.
		$teams = $this->team_memberships($userID);

		// Get a list of all tournaments with the key "teams" or "athletes"
		// defined. We will then iterate through every row checking if 
		// the userID or teamID exist in the thing.

		$tournaments = array();
		$queryString = 	"SELECT T.tournamentID, ".
		 				"MAX(CASE WHEN TD.`key`='teams' THEN value END ) AS teams, ".
		 				"MAX(CASE WHEN TD.`key`='athletes' THEN value END ) AS athletes ".
		 				"FROM tournaments AS T, tournamentData AS TD ".
		 				"WHERE TD.tournamentID = T.tournamentID ".
		 				"AND T.centreID = ".$this->db->escape($centreID);
		$queryData = $this->db->query($queryString);
		$tournaments = $queryData->result();

		foreach($tournaments as $tournament) 
			if(isset($tournaments['teams'])){
				$tournamentTeams = explode(",",$tournaments['teams']);
				$intersection = array_intersect($teams, $tournamentTeams)
				if(!empty($intersection)){
					$tournamentIDs[] = $tournamentID;
				}
			} else if(isset($tournaments['athletes'])){
				$tournamentAthletes = explode(",",$tournaments['athletes']);
				if(!empty(in_array($userID, $tournamentAthletes))){
					$tournamentIDs[] = $tournamentID;
				}
			}
		
		return $tournamentIDs;
	}
}