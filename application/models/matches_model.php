<?php
class Matches_model extends MY_Model {

	public function __construct() {
        parent::__construct();
		// Basic variables which apply to all table operations
		$this->objectIDKey = "matchID";
		$this->dataTableName = "matchData";
		$this->relationTableName = "matches";
    }
	
	/**
	 * Returns all data about a specific match, including related data (sport, sport category, venue, tournament)
	 *  
	 * @return array
	 **/
	public function get($ID) {
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
		$match = $this->get_object($ID, $this->objectIDKey, $this->dataTableName, $this->relationTableName, $relations);
		// We could do some other match-specific functional processing here before returning the results if we need to
		return $match;
	}	
	
	/**
	 * Returns all data about all matches at a specific centre, optionally between two DateTimes passed (or before, or after, if only one is passed)
	 *  
	 * @return array
	 **/
	public function get_all($startTime=FALSE,$endTime=FALSE) {

		// Fetch the IDs for everything at the current sports centre
		$IDRows = $this->db->select($this->objectIDKey)
						   ->from($this->relationTableName)
						   ->join('venues', 'matches.venueID = venues.venueID')
						   ->where('centreID', $this->centreID)
						   ->get()->result_array();
		// Create empty array to output if there are no results
		$all = array();
		// Loop through all result rows, get the ID and use that to put all the data into the output array 
		foreach($IDRows as $IDRow) {
			$all[$IDRow[$this->objectIDKey]] = $this->get($IDRow[$this->objectIDKey]);
		}

		if($startTime==FALSE && $endTime == FALSE) {
			return $all;
		} else {
			// Set up extremes for comparison if we aren't given an end time, or have a FALSE startTime, allowing for 
			$startTime = ( $startTime ? $startTime : new DateTime('1st January 0001'));
			$endTime = ( $endTime ? $endTime : new DateTime('31st December 9999'));
			return $this->datetime_range($all, $startTime, $endTime, 'startTime', 'endTime');
		}
	}

	/**
	 * Returns all data about all matches in a specific tournament
	 *  
	 * @return array
	 **/
	public function get_tournament_matches($tournamentID) {
		// Query to return the IDs for everything which takes place at the specified sports centre
		$where = array('tournamentID' => $tournamentID);
		$IDRows = $this->db->select($this->objectIDKey)
							   ->from($this->relationTableName)
							   ->where($where)
							   ->get()->result_array();
		// Loop through all result rows, get the ID and use that to put all the data into the output array 
		foreach($IDRows as $IDRow) {
			$all[$IDRow['matchID']] = $this->get($IDRow['matchID']);
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

			if($this->venues_model->get($venueID) == FALSE) return FALSE;

			// Query to return the IDs for everything which takes place at the specified sports centre
			$IDsQuery = $this->db->select("matchID")->where("venueID", $venueID)->get("matches")->result_array();
			// Loop through all result rows, get the ID and use that to put all the data into the output array 
			$all = array();
			foreach($IDsQuery as $IDRow) {
				$all[$IDRow['matchID']] = $this->get($IDRow['matchID']);
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
			if($matches === FALSE) return FALSE;

			$filtered = array();
			foreach($matches as $match) {

				try {
					$matchStartTime = new DateTime($match['startTime']);
					$matchEndTime 	= new DateTime($match['endTime']);
				} catch (Exception $e) {
					return "ERROR: Invalid date in database. Debug Exception: ".$e->getMessage();
				}

				if( $startTime < $matchEndTime && $matchStartTime < $endTime )
					$filtered[$match['matchID']] = $match;
			}
			return $filtered;
		}
	}

	/**
	 * Creates a new match with data, using the sport ID as specified.
	 * Returns the ID of the new object if it was successful.
	 * Returns FALSE on any error or insertion failure (including foreign key restraints).
	 *  
	 * @return int
	 **/
	public function insert($data, $relationIDs=array()) {
		return $this->insert_object($data, $this->objectIDKey, $this->dataTableName, $this->relationTableName, $relationIDs);
	}

	/**
	 * Updates data for a specific match.
	 * Returns TRUE on success.
	 * Returns FALSE on any error or insertion failure (including foreign key restraints).
	 *
	 * @return boolean
	 **/
	public function update($ID, $data, $relationIDs=array()) {
		return $this->update_object($ID, $data, $this->objectIDKey, $this->dataTableName, $this->relationTableName, $relationIDs);
	}

	/**
	 * Deletes a match with data.
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
}