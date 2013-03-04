<?php
class Tournaments_model extends CI_Model {

	/**
	 * $tournamentID is int(11)
	 *  
	 * @return boolean
	 **/

	public function tournament_exists($tournamentID)
	{
		$output = array();
		$queryString = 	"SELECT ".$this->db->escape($tournamentID)." AS tournamentID, ".
						"EXISTS(SELECT 1 FROM tournamentData WHERE tournamentID = ".$this->db->escape($tournamentID).") AS `exists`";
		$queryData = $this->db->query($queryString);
		$output = $queryData->row_array();
		return $output['exists'];
	}
	
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
	 * Returns an array of data from a specific tournament
	 *  
	 * @return array
	 **/
	public function get_tournament($tournamentID) {
		$fields = array();
		$fieldsQuery = $this->db->query("SELECT `key` FROM `tournamentData` WHERE `tournamentID` = ".$this->db->escape($tournamentID) );
		$fieldsResult = $fieldsQuery->result_array();
		foreach($fieldsResult as $fieldResult) {
			$fields[] = $fieldResult['key'];
		}
		if(count($fields)==0)
			return array();
		
		/* Query the ids that are associated with this match */
		$relational = array();
		$relationalString = "SELECT sportID FROM tournaments WHERE tournamentID = ".$this->db->escape($tournamentID);
		$relationalQuery = $this->db->query($relationalString);
		$relationalResult = $relationalQuery->result_array();
		
		if(isset($relationalResult[0]['sportID'])){
			$relationalString = "SELECT * FROM sports WHERE sportID = ".$relationalResult[0]['sportID'];
			$relationalQuery = $this->db->query($relationalString);
			$relationalResult = $relationalQuery->result_array();
		} 
		
		$dataQueryString = "SELECT ";
		$i = 0;
		$len = count($fields);
		foreach($fields as $field) {
			$dataQueryString .= "MAX(CASE WHEN `key`='$field' THEN value END ) AS $field";
			if($i<$len-1)
				$dataQueryString .= ", ";
			else
				$dataQueryString .= " ";
			$i++;
		}
		$dataQueryString .= "FROM tournamentData WHERE tournamentID = ".$this->db->escape($tournamentID);
		$dataQuery = $this->db->query($dataQueryString);
		$output = array_merge(array("tournamentID"=>$tournamentID), $dataQuery->row_array());
		if(isset($relationalResult[0]['sportID']))
			$output['sportID'] = $relationalResult[0]['sportID'];
		if(isset($relationalResult[0]['sportCategoryID']))
			$output['sportCategoryID'] = $relationalResult[0]['sportCategoryID'];
		return $output;
	}
	
	/**
	 * Returns a string specifying the status of a specific tournament
	 *  
	 * @return string
	 **/
	public function get_tournament_status($tournamentID) {
		$tournament = $this->get_tournament($tournamentID);
		$today = new DateTime();
		
		$registrationStartDate = DateTime::createFromFormat(DATE_TIME_FORMAT, $tournament['registrationStart']);
		$registrationEndDate = DateTime::createFromFormat(DATE_TIME_FORMAT, $tournament['registrationEnd']);
		$tournamentStartDate = DateTime::createFromFormat(DATE_TIME_FORMAT, $tournament['tournamentStart']);
		$tournamentEndDate = DateTime::createFromFormat(DATE_TIME_FORMAT, $tournament['tournamentEnd']);
		
		if(empty($registrationStartDate)) {
			return("ERROR: Invalid registrationStartDate. Database contains: ".$tournament['registrationStart'].", which should be in the format: ".DATE_TIME_FORMAT); 
		}
		if(empty($registrationEndDate)) {
			return("ERROR: Invalid registrationEndDate. Database contains: ".$tournament['registrationEnd'].", which should be in the format: ".DATE_TIME_FORMAT); 
		}
		if(empty($tournamentStartDate)) {
			return("ERROR: Invalid tournamentStartDate. Database contains: ".$tournament['tournamentStart'].", which should be in the format: ".DATE_TIME_FORMAT); 
		}
		if(empty($tournamentEndDate)) {
			return("ERROR: Invalid tournamentEndDate. Database contains: ".$tournament['tournamentEnd'].", which should be in the format: ".DATE_TIME_FORMAT); 
		}
		
		if( ($today < $registrationStartDate) && ($today < $registrationEndDate) &&
			($today < $tournamentStartDate) && ($today < $tournamentEndDate) ) {
			return("preRegistration");
		} elseif( ($today >= $registrationStartDate) && ($today < $registrationEndDate) &&
			($today < $tournamentStartDate) && ($today < $tournamentEndDate) ) {
			return("inRegistration");
		} elseif( ($today >= $registrationStartDate) && ($today >= $registrationEndDate) &&
			($today < $tournamentStartDate) && ($today < $tournamentEndDate) ) {
			
			// If the competitor list has been moderated, we are pre-start, not post-registration: all we are waiting for is the start date, no other staff interaction is required.
			if( isset($tournament['competitorsModerated']) && ( $tournament['competitorsModerated'] == "true" ) ) {
				return("preTournament");
			} 
			// Otherwise, we are still awaiting the staff to moderate the competitor list - set competitorsModerated to false in the DB to make this clear.
			$this->update_tournament($tournamentID,array("competitorsModerated" => "false"));
			// postRegistration means we need staff to moderate the competitor list
			return("postRegistration");
		} elseif( ($today >= $registrationStartDate) && ($today >= $registrationEndDate) &&
			($today >= $tournamentStartDate) && ($today < $tournamentEndDate) ) {
			return("inTournament");
		} elseif( ($today >= $registrationStartDate) && ($today >= $registrationEndDate) &&
			($today >= $tournamentStartDate) && ($today >= $tournamentEndDate) ) {
			return("postTournament");
		} else {
			return("ERROR: Tournament has invalid dates. Today's date is: ".$today->format(DATE_TIME_FORMAT).".
					Registration start date is: ".$registrationStartDate->format(DATE_TIME_FORMAT)."
					Registration end date is: ".$registrationEndDate->format(DATE_TIME_FORMAT)."
					Tournament start date is: ".$tournamentStartDate->format(DATE_TIME_FORMAT)."
					Tournament start date is: ".$tournamentEndDate->format(DATE_TIME_FORMAT)."
					Please correct the dates below.");
		}
	}
	
	/**
	 * Creates a tournament with data.
	 * returns the tournamentID of the new tournament if it was
	 * successful. If not, it should return -1.
	 *  
	 * @return int
	 **/
	public function insert_tournament($data)
	{	
		$sportID = $data['sport'];
		unset($data['sport']);
		
		
		$this->db->trans_start();
		
		$this->db->query("INSERT INTO tournaments (centreID,sportID) VALUES ({$this->data['centre']['centreID']},$sportID)");
		$tournamentID = $this->db->insert_id();
		if($tournamentID) {
			
			$insertDataArray = array();
			foreach($data as $key=>$value) {
				$insertDataArray[] = array(
					'tournamentID' => $tournamentID,
					'key' => $key,
					'value' => $value
				);
			}
			if ($this->db->insert_batch('tournamentData',$insertDataArray)) {
				// db success
				$this->db->trans_complete();
				return $tournamentID;
			} else {
				// db fail
				print_r($this->db->last_query()); die();
				return -1;
			}
		} else {
			return -1;
		}
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