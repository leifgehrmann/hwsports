<?php
class Users_model extends MY_Model {

	/**
	 * Returns all data about a specific user
	 *  
	 * @return array
	 **/
	public function get_user($userID) {
		// Get all the userData
		$user = $this->get_object($userID, "userID", "userData");
		return $user;
	}
	
	/**
	 * Returns all data about all users at a specific centre
	 *  
	 * @return array
	 **/
	public function get_users($centreID) {
		// To find out if a user is associated with the centre...
		// Tickets > "userID"
		// Tournaments[teamSport=1] > "teams"    >> TeamsUsers > "userID"
		// Tournaments[teamSport=0] > "athletes" >> "userID"
		// UserData[centreID=1] > userID
		
		// Query to return the IDs for everything which takes place at the specified sports centre
		$IDsQuery = $this->db->query("SELECT userID FROM userData WHERE `key`='centreID' AND `value`=".$this->db->escape($centreID));
		// Loop through all result rows, get the ID and use that to put all the data into the output array 
		foreach($IDsQuery->result_array() as $IDRow) {
			$all[] = $this->get_user($IDRow['userID']);
		}
		return $all;
	}
	
	/**
	 * Returns all data about users in a particular tournament
	 *  
	 * @return array
	 **/
	public function get_tournament_users($tournamentID) {
		// Load the teams model since we want to use the get_tournament_teams function
		$this->load->model('users_model');
		// Loop through all teams in tournament
		foreach($this->teams_model->get_tournament_teams($tournamentID) as $team) {
			// Loop through all users in team, add to output array
			foreach($team['users'] as $user) {
				$all[] = $user;
			}
		}
		return $all;
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
				$intersection = array_intersect($teams, $tournamentTeams);
				if(!empty($intersection)){
					$tournamentIDs[] = $tournamentID;
				}
			} else if(isset($tournaments['athletes'])){
				$tournamentAthletes = explode(",",$tournaments['athletes']);
				$intersection = in_array($userID, $tournamentAthletes);
				if(!empty($intersection)){
					$tournamentIDs[] = $tournamentID;
				}
			}
		
		return $tournamentIDs;
	}
}