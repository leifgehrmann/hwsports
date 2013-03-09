<?php
class Matches_model extends MY_Model {

	/**
	 * Returns all data about a specific match, including related data (sport, sport category, venue, tournament)
	 *  
	 * @return array
	 **/
	public function get_match($matchID) {
		// The relations we are setting up here will pull all the data about this matches sport type, the venue it is in and the tournament it is in
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
						),
						array( 
							"objectIDKey" => "venueID",
							"dataTableName" => "venueData"
						),
						array( 
							"objectIDKey" => "tournamentID",
							"dataTableName" => "tournamentData"
						)
					);
		// Get all data about this match from matchData, the append all the data from associated tables as specified above
		$match = $this->get_object($matchID, "matchID", "matchData", "matches", $relations);
		// We could do some other match-specific functional processing here before returning the results if we need to
		return $match;
	}	
	
	/**
	 * Returns all data about all matches at a specific centre
	 *  
	 * @return array
	 **/
	public function get_matches($centreID,$startTime=FALSE,$endTime=FALSE) {

		if($startTime==FALSE && $endTime == FALSE) {
			// Query to return the IDs for everything which takes place at the specified sports centre
			$IDsQuery = $this->db->query("SELECT matchID FROM matches LEFT JOIN venues ON matches.venueID = venues.venueID WHERE venues.centreID = ".$this->db->escape($centreID));
			// Loop through all result rows, get the ID and use that to put all the data into the output array 
			foreach($IDsQuery->result_array() as $IDRow) {
				$all[] = $this->get_match($IDRow['matchID']);
			}
			return (empty($all) ? FALSE : $all);
		} else {

			$startTime = ( $startTime ? $startTime : new DateTime('1st January 0001'));
			$endTime = ( $endTime ? $endTime : new DateTime('31st December 9999'));

			try {
				$startTime = ( is_object($startTime) ? $startTime : new DateTime($startTime));
				$endTime = ( is_object($endTime) ? $endTime : new DateTime($endTime));
			} catch (Exception $e) {
				log_message('error', "ERROR: Invalid input date. Debug Exception: ".$e->getMessage());
				return FALSE;
			}

			$matches = $this->get_matches($venueID);
			if($matches == FALSE) return FALSE;

			$filtered = array();
			foreach($matches as $match) {

				try {
					$matchStartTime = new DateTime($match['startTime']);
					$matchEndTime 	= new DateTime($match['endTime']);
				} catch (Exception $e) {
					log_message('error', "ERROR: Invalid date in database. Debug Exception: ".$e->getMessage());
					return FALSE;
				}

				if( $startTime < $matchEndTime && $matchStartTime < $endTime )
					$filtered[] = $match;
			}
			return $filtered;
		}
	}

	/**
	 * Returns all data about all matches in a specific tournament
	 *  
	 * @return array
	 **/
	public function get_tournament_matches($tournamentID) {
		// Query to return the IDs for everything which takes place at the specified sports centre
		$IDsQuery = $this->db->query("SELECT matchID FROM matches WHERE tournamentID = ".$this->db->escape($tournamentID));
		// Loop through all result rows, get the ID and use that to put all the data into the output array 
		foreach($IDsQuery->result_array() as $IDRow) {
			$all[] = $this->get_match($IDRow['matchID']);
		}
		return (empty($all) ? FALSE : $all);
	}
	
	/**
	 * HAS NOT BEEN TESTED
	 * Returns a multidimensional array of match data
	 * @param startTime 	A dateTime Object
	 * @param endTime 	A dateTime Object
	 * @return array
	 **/
	public function get_venue_matches($venueID,$startTime=FALSE,$endTime=FALSE)
	{
		if($startTime==FALSE && $endTime == FALSE) {
			// verify that the venue exists
			$this->load->model('venues_model');
			if($this->venues_model->get_venue($venueID) == FALSE) return FALSE;

			// Query to return the IDs for everything which takes place at the specified sports centre
			$IDsQuery = $this->db->select("matchID")->where("venueID", $venueID)->get("matches")->result_array();
			// Loop through all result rows, get the ID and use that to put all the data into the output array 
			$all = array();
			foreach($IDsQuery as $IDRow) {
				$all[] = $this->get_match($IDRow['matchID']);
			}
			return $all;
		} else {

			$startTime = ( $startTime ? $startTime : new DateTime('1st January 0001'));
			$endTime = ( $endTime ? $endTime : new DateTime('31st December 9999'));

			try {
				$startTime = ( is_object($startTime) ? $startTime : new DateTime($startTime));
				$endTime = ( is_object($endTime) ? $endTime : new DateTime($endTime));
			} catch (Exception $e) {
				return "ERROR: Invalid input date in database. Debug Exception: ".$e->getMessage();
			}

			$matches = $this->get_venue_matches($venueID);
			if($matches == FALSE) return FALSE;

			$filtered = array();
			foreach($matches as $match) {

				try {
					$matchStartTime = new DateTime($match['startTime']);
					$matchEndTime 	= new DateTime($match['endTime']);
				} catch (Exception $e) {
					return "ERROR: Invalid date in database. Debug Exception: ".$e->getMessage();
				}

				if( $startTime < $matchEndTime && $matchStartTime < $endTime )
					$filtered[] = $match;
			}
			return $filtered;
		}
	}

	/**
	 * Creates a match with data.
	 * returns the matchID of the new match if it was
	 * successful. If not, it should return -1.
	 *  
	 * @return int
	 **/
	public function insert_match($centreID, $data)
	{	
		$this->db->trans_start();

		$this->db->query("INSERT INTO matches (centreID) VALUES (".$this->db->escape($centreID).")");
		$matchID = $this->db->insert_id();

		$insertDataArray = array();
		foreach($data as $key=>$value) {
			$dataArray = array(
					'matchID' => $this->db->escape($matchID),
					'key' => $this->db->escape($key),
					'value' => $this->db->escape($value)
				);
			$insertDataArray[] = $dataArray;
		}
		if ($this->db->insert_batch('matchData',$insertDataArray)) {
			// db success
			$this->db->trans_complete();
			return $matchID;
		} else {
			// db fail
			return -1;
		}
	}

	/**
	 * Updates a match with data.
	 *
	 * @return boolean
	 **/
	public function update_match($matchID, $data){

		$this->db->trans_start();

		foreach($data as $key=>$value) {
			$escKey = $this->db->escape($key);
			$escValue = $this->db->escape($value);
			$dataQueryString = 	"UPDATE `matchData` ".
								"SET `value`=$escValue ".
								"WHERE `key`=$escKey ".
								"AND `matchID`=$matchID";
			$this->db->query($dataQueryString);
		}
		$this->db->trans_complete();
		return true;
	}
}