<?php
class Tournaments_model extends MY_Model {

	/**
	 * Returns a 2d array of data for all tournaments
	 *  
	 * @return array
	 **/
	public function get_tournaments($centreID)
	{
		$output = array();
		$queryString = "SELECT tournamentID FROM tournaments WHERE centreID = ".$this->db->escape($centreID);;
		$queryData = $this->db->query($queryString);
		$data = $queryData->result_array();
		foreach($data as $tournament) {
			$output[] = $this->get_tournament($tournament['tournamentID']);
		}
		return $output;
	}
	
	/**
	 * Returns an array containing all known data about a specific tournament ID
	 *  
	 * @return array
	 **/
	public function get_tournament($tournamentID) {
		$relations = array(
						array( 
							"objectIDKey" => "sportID",
							"dataTableName" => "sportData",
							"relationTableName" => "sports",
							"relations" => array( 
								array( 
									"objectIDKey" => "sportCategoryID",
									"dataTableName" => "sportCategoryData",
									"relationTableName" => "",
									"relations" => array()
								)
							)
						)
					);
		$tournament = $this->get_object($tournamentID, "tournamentID", "tournamentData", "tournaments", $relations);
		
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
		
		return $tournament;
	}
	
	/**
	 * Returns a string specifying the status of a specific tournament
	 *  
	 * @return string : preRegistration, inRegistration, postRegistration, preTournament, inTournament, postTournament or ERROR
	 **/
	public function get_tournament_status($tournamentID) {
		$tournament = $this->get_tournament($tournamentID);
		return $tournament['status'];
	}
	
	/**
	 * Creates a tournament with data.
	 *  
	 * @return integer ID of new tournament, or FALSE if failed
	 **/
	public function insert_tournament($data) {	
		// Get sport ID from input data, then unset it from data array since we don't want it in tournamentData, it's a field in the tournaments table
		$sportID = $data['sport'];
		unset($data['sport']);
		
		$this->db->query("INSERT INTO tournaments (centreID,sportID) VALUES ({$this->data['centre']['centreID']},$sportID)");
		$tournamentID = $this->db->insert_id();
		// Insert failed, we can't proceed
		if($this->db->affected_rows()==0) return FALSE;
		
		// Batch insert, do it as one transaction for efficiency
		$this->db->trans_start();
		$insertDataArray = array();
		foreach($data as $key=>$value) {
			$insertDataArray[] = array(
				'tournamentID' => $tournamentID,
				'key' => $key,
				'value' => $value
			);
		}
		// Batch insert failed?
		if ( !$this->db->insert_batch('tournamentData',$insertDataArray) ) return FALSE;
		
		// Success
		$this->db->trans_complete();
		return $tournamentID;
	}

	/**
	 * Updates a tournament with data.
	 *
	 * @return boolean
	 **/
	public function update_tournament($tournamentID, $data){

		$this->db->trans_start();

		if($this->tournament_exists($tournamentID)){
			foreach($data as $key=>$value) {
				if(!is_string($key)) return false;
				$escKey = $this->db->escape($key);
				$escValue = $this->db->escape($value);
				$dataQueryString = 	"UPDATE `tournamentData` ".
									"SET `value`=$escValue ".
									"WHERE `key`=$escKey ".
									"AND `tournamentID`=$tournamentID";
				$this->db->query($dataQueryString);
			}
			$this->db->trans_complete();
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Deletes a tournament with data.
	 *
	 * @return boolean
	 **/
	public function delete_tournament($tournamentID){
		if($this->tournament_exists($tournamentID)){
			$this->db->query("DELETE FROM tournamentData WHERE tournamentID = $tournamentID");
			$this->db->query("DELETE FROM tournaments WHERE tournamentID = $tournamentID");
			return true;
		} else {
			return false;
		}
	}











	
}