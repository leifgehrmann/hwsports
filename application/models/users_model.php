<?php
class Users_model extends CI_Model {

	public function __construct() {
        parent::__construct();
		// Basic variables which apply to all table operations
		$this->objectIDKey = "userID";
		$this->dataTableName = "userData";
		$this->relationTableName = "users";
    }
	
	/**
	 * Returns all data about a specific user
	 *  
	 * @return array
	 **/
	public function get($ID) {
		// Get all the userData
		return $this->get_object($ID, $this->objectIDKey, $this->dataTableName, $this->relationTableName);
	}
	
	/**
	 * Returns all data about currently logged in user, or false if not logged in
	 *  
	 * @return array
	 **/
	public function get_logged_in() {
		$logged_in = $this->ion_auth->user()->row();
		if($logged_in) return $this->get($logged_in->userID);
		return false;
	}
	
	/**
	 * Searches by email and returns all data about a specific user
	 *  
	 * @return array
	 **/
	public function find_by_email($email) {
		$userRow = $this->db->get_where('users',array('email' => $email))->row_array();
		if(count($userRow)) return $this->get($userRow['userID']);
		else return false;
	}
	
	/**
	 * Returns all data about all users at current centre
	 * 
	 * @return array
	 **/
	public function get_all($where = false) {
		// Fetch the IDs for everything at the current sports centre
		if(is_array($where)) $this->db->where( $where );
		$this->db->where( array('centreID' => $this->centreID) );
		$IDRows = $this->db->get($this->relationTableName)->result_array();
		// Create empty array to output if there are no results
		$all = array();
		// Loop through all result rows, get the ID and use that to put all the data into the output array 
		foreach($IDRows as $IDRow) {
			$all[$IDRow[$this->objectIDKey]] = $this->get($IDRow[$this->objectIDKey]);
		}
		return $all;
	}
	
	/**
	 * Registers a new user, with the specified email, password and userData
	 * Returns the ID of the new object if it was successful.
	 * Returns FALSE on any error or insertion failure (including foreign key restraints).
	 *  
	 * @return int
	 **/
	public function register($email, $password, $data) {
		// Lump all data table updates into one transaction in case one fails, so we can rollback and don't end up with users with no data 
		$this->db->trans_begin();
		$userID = $this->ion_auth->register($email, $password);
		if($userID) {	
			$userDataStatus = $this->update($userID, $data);
			if ($userDataStatus && ($this->db->trans_status() !== FALSE) ) {
				$this->db->trans_commit();
				return $userID;
			}
		}
		$this->db->trans_rollback();
		return false;
	}
	
	/**
	 * Creates a new user with data, using the standard insert format. Takes email and password out of input array
	 * Returns the ID of the new object if it was successful.
	 * Returns FALSE on any error or insertion failure (including foreign key restraints).
	 *  
	 * @return int
	 **/
	public function insert($data, $relationIDs=array()) {
		if(isset($data['email'])) {
			$email = $data['email']; unset($data['email']);
			if( isset($data['password']) ) {
				$password = $data['password']; unset($data['password']);
			} else {
				$password = generatePassword();
			}
			return $this->register($email,$password,$data);
		}
		return false;
	}

	/**
	 * Updates data for a specific user.
	 * Returns TRUE on success.
	 * Returns FALSE on any error or insertion failure (including foreign key restraints).
	 *
	 * @return boolean
	 **/
	public function update($ID, $data, $relationIDs=array()) {
		return $this->update_object($ID, $data, $this->objectIDKey, $this->dataTableName, $this->relationTableName, $relationIDs);
	}

	/**
	 * Deletes a user with data.
	 * Also deletes all objects which depend on it, unless $testRun is TRUE in which case a string is returned showing all
	 * Returns TRUE on success.
	 * Returns FALSE on any error or deletion failure (most likely forgotten foreign key restraints).
	 *
	 * @return boolean
	 **/
	public function delete($ID, $testRun=TRUE) {
		$output = "";
		$deletedRows = $this->delete_object($ID, $this->objectIDKey, $this->relationTableName, $testRun);
		if($testRun) {
			foreach( $deletedRows as $deletedObject ) $output .= "<li>$deletedObject</li>";
			return $output;
		}
		return $deletedRows;
	}
	
	/**
	 * Returns all data about users in a particular tournament
	 *  
	 * @return array
	 **/
	public function get_tournament_users($tournamentID) {
		// Loop through all teams in tournament
		foreach($this->teams_model->get_tournament_teams($tournamentID) as $team) {
			// Loop through all users in team, add to output array
			foreach($team['users'] as $user) {
				$all[] = $user;
			}
		}
		return (empty($all) ? FALSE : $all);
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
			$teams[] = $row['teamID'];

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