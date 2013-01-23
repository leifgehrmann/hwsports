<?php
class Tournament_model extends CI_Model {

	/**
	 * $centreID is int(11)
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
		return $output;
	}

	/**
	 * Returns a 2d array of data for all tournaments
	 *  
	 * @return array
	 **/
	public function get_tournaments($tournamentID, $fields=array("name","shortName","address","headerColour","backgroundColour","footerText"))
	{
		$output = array();
		$queryString = "SELECT DISTINCT tournamentID FROM tournamentData";
		$queryData = $this->db->query($queryString);
		$data = $queryData->result_array();
		foreach($data as $tournament) {
			$output[] = $this->get_tournament($tournament['tournamentID'],$fields);
		}
		return $output;
	}

	/**
	 * Returns an array of data from a specific tournament
	 *  
	 * @return array
	 **/
	public function get_tournament($tournamentID)
	{
		$fields = array();
		$fieldsQuery = $this->db->query("SELECT `key` FROM `tournamentData` WHERE `tournamentID` = ".$this->db->escape($tournamentID) );
		$fieldsResult = $fieldsQuery->result_array();
		foreach($fieldsResult as $fieldResult) {
			$fields[] = $fieldResult['key'];
		}
		
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
		$dataQueryString .= "FROM tournamentData WHERE tournamentID = ".$this->db->escape($tournamentID);
		$dataQuery = $this->db->query($dataQueryString);
		$output = array_merge(array("tournamentID"=>$tournamentID), $dataQuery->row_array());
		return $output;
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
		$this->db->trans_start();

		$this->db->query("INSERT INTO tournamentData (tournamentID) VALUES (".$this->db->escape($tournamentID).")");
		$tournamentID = $this->db->insert_id();

		$insertDataArray = array();
		foreach($data as $key=>$value) {
			$dataArray = array(
					'tournamentID' => $this->db->escape($tournamentID),
					'key' => $this->db->escape($key),
					'value' => $this->db->escape($value)
				);
			$insertDataArray[] = $dataArray;
		}
		if ($this->db->insert_batch('tournamentData',$insertDataArray)) {
			// db success
			$this->db->trans_complete();
			return $tournamentID;
		} else {
			// db fail
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
}