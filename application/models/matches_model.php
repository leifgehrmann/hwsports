<?php
class Matches_model extends CI_Model {

	/**
	 * $matchID is int(11)
	 *  
	 * @return boolean
	 **/

	public function match_exists($matchID)
	{
		$output = array();
		$queryString = 	"SELECT ".$this->db->escape($matchID)." AS matchID, ".
						"EXISTS(SELECT 1 FROM matches WHERE matchID = ".$this->db->escape($matchID).") AS `exists`";
		$queryData = $this->db->query($queryString);
		$output = $queryData->row_array();
		return $output;
	}

	/**
	 * Returns a 2d array of match data
	 *  
	 * @return array
	 **/
	public function get_matches($centreID, $fields=array("name","startTime","endTime","description","tournamentID"))
	{
		$output = array();
		$queryString = "SELECT matchID, venues.venueID FROM matches LEFT JOIN venues ON matches.venueID = venues.venueID WHERE venues.centreID = ".$this->db->escape($centreID);
		$queryData = $this->db->query($queryString);
		$data = $queryData->result_array();
		foreach($data as $match) {
			$output[] = $this->get_match($match['matchID'],$fields);
		}
		return $output;
	}

	/**
	 * Returns an array of data from a specific match
	 *  
	 * @return array
	 **/
	public function get_match($matchID, $fields=array("name","startTime","endTime","description","tournamentID"))
	{
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
		$dataQueryString .= "FROM matchData WHERE matchID = ".$this->db->escape($matchID);
		$dataQuery = $this->db->query($dataQueryString);
		$output = array_merge(array("matchID"=>$matchID), $dataQuery->row_array());
		return $output;
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

		if($this->match_exists($matchID)){
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
		} else {
			return false;
		}
	}
}