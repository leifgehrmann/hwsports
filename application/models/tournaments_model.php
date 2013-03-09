<?php
class Tournaments_model extends MY_Model {
	
	public function __construct() {
        parent::__construct();
		// Load models we might be referencing
		$this->load->model('users_model');
		$this->load->model('teams_model');
		// Basic variables which apply to all table operations
		$this->objectIDKey = "tournamentID";
		$this->dataTableName = "tournamentData";
		$this->relationTableName = "tournaments";
    }

	/**
	 * Returns all data about a specific tournament, including sport and sport category data
	 *  
	 * @return array
	 **/
	public function get($ID) {
		// These relations will pull all the data about this tournament's sport type and sport category
		$relations = array(
						array(
							"objectIDKey" => "sportID",
							"dataTableName" => "sportData",
							"relationTableName" => "sports",
							"relations" => array(
								array(
									"objectIDKey" => "sportCategoryID",
									"dataTableName" => "sportCategoryData"
								)
							)
						)
					);
		$tournament = $this->get_object($ID, $this->objectIDKey, $this->dataTableName, $this->relationTableName, $relations);
		// This tournament ID doesn't exist
		if(!$tournament) return FALSE;
		
		// Start tournament status logic - sets tournament[status] to value: preRegistration, inRegistration, postRegistration, preTournament, inTournament, postTournament or ERROR 
		try {
			$today = new DateTime();
			$registrationStartDate = new DateTime($tournament['registrationStart']);
			$registrationEndDate = new DateTime($tournament['registrationEnd']);
			$tournamentStartDate = new DateTime($tournament['tournamentStart']);
			$tournamentEndDate = new DateTime($tournament['tournamentEnd']);
		} catch (Exception $e) {
			$tournament['status'] = "ERROR: Invalid date in database. Debug Exception: ".$e->getMessage();
		}
		
		if( ($today < $registrationStartDate) && ($today < $registrationEndDate) &&
			($today < $tournamentStartDate) && ($today < $tournamentEndDate) ) {
			$tournament['status'] = "preRegistration";
		} elseif( ($today >= $registrationStartDate) && ($today < $registrationEndDate) &&
			($today < $tournamentStartDate) && ($today < $tournamentEndDate) ) {
			$tournament['status'] = "inRegistration";
		} elseif( ($today >= $registrationStartDate) && ($today >= $registrationEndDate) &&
			($today < $tournamentStartDate) && ($today < $tournamentEndDate) ) {
			
			// If the competitor list has been moderated, we are pre-start, not post-registration: all we are waiting for is the start date, no other staff interaction is required.
			if( isset($tournament['competitorsModerated']) && ( $tournament['competitorsModerated'] == "true" ) ) {
				$tournament['status'] = "preTournament";
			} 
			// Otherwise, we are still awaiting the staff to moderate the competitor list - set competitorsModerated to false in the DB to make this clear.
			$this->update_tournament($ID,array("competitorsModerated" => "false"));
			// postRegistration means we need staff to moderate the competitor list
			$tournament['status'] = "postRegistration";
		} elseif( ($today >= $registrationStartDate) && ($today >= $registrationEndDate) &&
			($today >= $tournamentStartDate) && ($today < $tournamentEndDate) ) {
			$tournament['status'] = "inTournament";
		} elseif( ($today >= $registrationStartDate) && ($today >= $registrationEndDate) &&
			($today >= $tournamentStartDate) && ($today >= $tournamentEndDate) ) {
			$tournament['status'] = "postTournament";
		} else {
			$tournament['status'] = "ERROR: Tournament has invalid dates. Today's date is: ".datetime_to_public($today).".
					Registration start date is: ".datetime_to_public($registrationStartDate)."
					Registration end date is: ".datetime_to_public($registrationEndDate)."
					Tournament start date is: ".datetime_to_public($tournamentStartDate)."
					Tournament start date is: ".datetime_to_public($tournamentEndDate)."
					Please correct the dates below.";
		}
		// End tournament status logic 
		
		return $tournament;
	}

	/**
	 * Returns all data about all tournaments at current centre
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
	 * Returns all data about all actors in a tournament (teams, users, umpires, fluffy bunnies)
	 *  
	 * @return array
	 **/
	public function get_actors($ID) {
		// Check if ID exists
		if(!$this->get($ID)) return FALSE;
		// Select all info about actors for this specific tournament - join the roles table so we get info about how to handle the different roles
		$actorRows = $this->db->select('actorID, roleID, sportCategoryRoleName, actorTable, actorMethod')
					->from('tournamentActors')
					->join('sportCategoryRoles', 'sportCategoryRoles.sportCategoryRoleID = tournamentActors.roleID')
					->where('tournamentID',$ID)
					->get()
					->result_array();
		// We should return an empty array if there are no actors at all, so create it here
		$actors = array();
		foreach($actorRows as $actorRow) {
			// For each actor, use eval with the actorMethod and actorID from the database to get the actual actor data 
			eval("\$actor = \$this->{$actorRow['actorMethod']}({$actorRow['actorID']});");
			// Append the actor to the output array, in a sub array of the role name - therefore from your sport-specific function you might use $actors['Umpire'] to get all the umpires, etc.
			$actors[$actorRow['sportCategoryRoleName']][] = $actor;
		}
		// Return all actors
		return $actors;
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

}