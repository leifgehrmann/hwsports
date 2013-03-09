<?php
class Tournaments_model extends MY_Model {
	
	/**
	 * Returns all data about a specific tournament, including sport and sport category data
	 *  
	 * @return array
	 **/
	public function get_tournament($tournamentID) {
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
		$tournament = $this->get_object($tournamentID, "tournamentID", "tournamentData", "tournaments", $relations);
		if(empty($tournament)) return FALSE;
		
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
			$this->update_tournament($tournamentID,array("competitorsModerated" => "false"));
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

	public function get_tournament_actors($tournamentID){
		$this->load->model('users_model');
		$this->load->model('teams_model');
		
		$tournament = $this->get_tournament($tournamentID);
		if($tournament == FALSE) return FALSE;
		
		$actorRows = $this->db->select('actorID, roleID, sportCategoryRoleName, actorTable, actorMethod')
					->from('tournamentActors')
					->join('sportCategoryRoles', 'sportCategoryRoles.sportCategoryRoleID = tournamentActors.roleID')
					->where('tournamentID',$tournamentID)
					->get()
					->result_array();
					
		$actors = array();
		foreach($actorRows as $actorRow) {
			eval("\$actor = \$this->{$actorRow['actorMethod']}({$actorRow['actorID']});");
			$actors[$actorRow['sportCategoryRoleName']][] = $actor;
		}
		return $actors;

	}

	/**
	 * Returns all data about all tournaments at a specific centre
	 *  
	 * @return array
	 **/
	public function get_tournaments($centreID) {
		// Query to return the IDs for everything which takes place at the specified sports centre
		$IDsQuery = $this->db->query("SELECT tournamentID FROM tournaments WHERE centreID = ".$this->db->escape($centreID));
		// Loop through all result rows, get the ID and use that to put all the data into the output array 
		foreach($IDsQuery->result_array() as $IDRow) {
			$all[] = $this->get_tournament($IDRow['tournamentID']);
		}
		return (empty($all) ? FALSE : $all);
	}

	/**
	 * Creates a new tournament with data, using the sport ID as specified.
	 * Returns the ID of the new object if it was successful.
	 * Returns FALSE on any error or insertion failure (including foreign key restraints).
	 *  
	 * @return int
	 **/
	public function insert_tournament($data,$sportID) {
		return $this->insert_object($data, "tournamentID", "tournamentData" );
	}

	/**
	 * Updates data for a specific tournament.
	 * Returns TRUE on success.
	 * Returns FALSE on any error or insertion failure (including foreign key restraints).
	 *
	 * @return boolean
	 **/
	public function update_tournament($tournamentID, $data) {
		return $this->update_object($tournamentID, "tournamentID", $data, 'tournamentData');
	}

	/**
	 * Deletes a tournament with data.
	 *
	 * @return boolean
	 **/
	public function delete_tournament($tournamentID){
		//$this->db->query("DELETE FROM tournamentData WHERE tournamentID = $tournamentID");
		//$this->db->query("DELETE FROM tournaments WHERE tournamentID = $tournamentID");
		return $this->delete_object($tournamentID, "tournamentID", $data, 'tournamentData');
	}

}