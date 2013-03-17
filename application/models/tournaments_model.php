<?php
class Tournaments_model extends MY_Model {
	
	public function __construct() {
        parent::__construct();
		// Load models we might be referencing



		// Basic variables which apply to all table operations
		$this->objectIDKey = "tournamentID";
		$this->dataTableName = "tournamentData";
		$this->relationTableName = "tournaments";
		
		$this->load->model("users_model");
		$this->load->model("teams_model");
		
		$this->actor_tables_models = array(
			"users" => $this->users_model,
			"teams" => $this->teams_model
		);
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
			} else {
				// postRegistration means we need staff to moderate the competitor list
				$tournament['status'] = "postRegistration";
			}
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
	public function get_all($startTime = FALSE, $endTime = FALSE) {
		// Fetch the IDs for everything at the current sports centre
		$this->db->where( array('centreID' => $this->centreID) );
		$IDRows = $this->db->get($this->relationTableName)->result_array();
		// Create empty array to output if there are no results
		$all = array();
		// Loop through all result rows, get the ID and use that to put all the data into the output array 
		foreach($IDRows as $IDRow) {
			$all[$IDRow[$this->objectIDKey]] = $this->get($IDRow[$this->objectIDKey]);
		}

		if($startTime != FALSE || $endTime != FALSE){
			$startTime = ( $startTime ? $startTime : new DateTime('1st January 0001'));
			$endTime = ( $endTime ? $endTime : new DateTime('31st December 9999'));
			return $this->datetime_range($all,$startTime,$endTime,'tournamentStart','tournamentEnd');
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
		$actorRows = $this->db->select('actorID, roleID, sportCategoryRoleName, actorTable')
					->from('tournamentActors')
					->join('sportCategoryRoles', 'sportCategoryRoles.sportCategoryRoleID = tournamentActors.roleID')
					->where('tournamentID',$ID)
					->get()
					->result_array();
		// We should return an empty array if there are no actors at all, so create it here
		$actors = array();
		foreach($actorRows as $actorRow) {
			// For each actor, get the actual actor data, using the model as defined by the global array in the constructor 
			$actor = $this->actor_tables_models[$actorRow['actorTable']]->get($actorRow['actorID']);
			// Append the actor to the output array, in a sub array of the role name - therefore from your sport-specific function you might use $actors['Umpire'] to get all the umpires, etc.
			$actors[$actorRow['sportCategoryRoleName']][$actorRow['actorID']] = $actor;
		}
		// Return all actors
		return $actors;
	}

	/**
	 * Returns all data about all venues in a tournament
	 *  
	 * @return array
	 **/
	public function get_venues($ID) {
		// Check if ID exists
		if(!$this->get($ID)) return FALSE;
		// Select all info about venues for this specific tournament
		$venueRows = $this->db->select('venueID')
					->from('tournamentVenues')
					->where('tournamentID',$ID)
					->get()
					->result_array();
		// We should return an empty array if there are no venues at all, so create it here
		$venues = array();
		foreach($venueRows as $venueRow) {
			// Get the value of the venues_model
			$venue = $this->venues_model->get($venueRow['venueID']);
			// add the venue to the array
			$venues[$venueRow['venueID']] = $venue;
		}
		// Return all actors
		return $venues;
	}

	/**
	 * Inserts the venues into the tournamentVenues table, which allows staff the manage a list of venues that are used.
	 *  
	 * @return boolean
	 **/
	public function insert_venues($tournamentID, $venueIDs) {
		if(!$this->get($tournamentID)) return FALSE;
		// Lump all inserts into one transaction
		$this->db->trans_start();
		
		foreach($venueIDs as $venueID) {
			if(!$this->venues_model->get($venueID)) return FALSE;
			$this->db->$insert = array(
				'tournamentID'   => $tournamentID,
				'venueID' => $venueID
			);
			// Create the insert - active record sanitizes inputs automatically. Return false if insert fails.
			if(!$this->db->insert("tournamentVenues", $insert)) return FALSE;			
		}
		// Complete transaction, all is well
		$this->db->trans_complete();
		return TRUE;
	}

	/**
	 * Updates the tournament to use a list of venues
	 *  
	 * @return boolean
	 **/
	public function update_venues($tournamentID, $venueIDs) {
		if(!$this->get($tournamentID)) return FALSE;
		// Lump all inserts into one transaction
		
		$venues = $this->get_venues($tournamentID);
		$venuesToDelete = array();
		foreach($venues as $venue)
			$venuesToDelete[] = $venue['venueID'];
		$this->db->trans_start();
		if(!$this->delete_venues($venuesToDelete))
			return FALSE;
		if(!$this->insert_venues($venueIDs))
			return FALSE;
		// Complete transaction, all is well
		$this->db->trans_complete();
		return TRUE;
	}

	/**
	 * Deletes 1 or more venues to the tournamentVenues table - essentially allowing staff to select which venues should be used for scheduling
	 *  
	 * @return array
	 **/
	public function delete_venues($tournamentID, $venueIDs) {
		if(!$this->get($tournamentID)) return FALSE;
		// Lump all inserts into one transaction
		$this->db->trans_start();
		
		foreach($venueIDs as $venueID) {
			if(!$this->venues_model->get($venueID)) return FALSE;
			$this->db->$delete = array(
				'tournamentID'   => $tournamentID,
				'venueID' => $venueID
			);
			// Create the delete - active record sanitizes inputs automatically. Return false if delete fails.
			if(!$this->db->delete("tournamentVenues", $delete)) return FALSE;			
		}
		// Complete transaction, all is well
		$this->db->trans_complete();
		return TRUE;
	}

	/**
	 * Creates a new tournament with data, using the sport ID as specified.
	 * Returns the ID of the new object if it was successful.
	 * Returns FALSE on any error or insertion failure (including foreign key restraints).
	 *  
	 * @return int
	 **/
	public function insert($data, $relationIDs=array()) {
		$relationIDs['centreID']=$this->centreID;
		return $this->insert_object($data, $this->objectIDKey, $this->dataTableName, $this->relationTableName, $relationIDs);
	}

	/**
	 * Updates data for a specific tournament.
	 * Returns TRUE on success.
	 * Returns FALSE on any error or insertion failure (including foreign key restraints).
	 *
	 * @return boolean
	 **/
	public function update($ID, $data, $relationIDs=array()) {
		return $this->update_object($ID, $data, $this->objectIDKey, $this->dataTableName, $this->relationTableName, $relationIDs);
	}

	/**
	 * Deletes a tournament with data.
	 * Also deletes all objects which depend on it. 
	 * If $testRun is TRUE, no deletion occurs. Instead, a string is returned showing all deletions which would occur otherwise.
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
	
}