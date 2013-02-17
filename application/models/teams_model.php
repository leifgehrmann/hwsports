<?php
class Teams_model extends CI_Model {

	/**
	 * $teamID is int(11)
	 *  
	 * @return boolean
	 **/

	public function team_exists($teamID)
	{
		$output = array();
		$queryString = 	"SELECT ".$this->db->escape($teamID)." AS teamID, ".
						"EXISTS(SELECT 1 FROM teams WHERE teamID = ".$this->db->escape($teamID).") AS `exists`";
		$queryData = $this->db->query($queryString);
		$output = $queryData->row_array();
		return $output['exists'];
	}

	/**
	 * Returns all team data for the teams in a particular tournament
	 *  
	 * @return array
	 **/

	public function get_tournament_teams($tournamentID)
	{
		/*$output = array();
		$queryString = "SELECT sportID FROM sports WHERE centreID = ".$this->db->escape($centreID);
		$queryData = $this->db->query($queryString);
		$data = $queryData->result_array();
		foreach($data as $sport) {
			$output[] = $this->get_sport($sport['sportID']);
		}
		return $output;*/
	}

	/**
	 * Returns all team data for the teams in a 
	 *  
	 * @return array
	 **/

	public function get_teams($centreID)
	{
		$output = array();
		$queryString = "SELECT teamID FROM teams WHERE centreID = ".$this->db->escape($centreID);
		$queryData = $this->db->query($queryString);
		$data = $queryData->result_array();
		foreach($data as $team) {
			$output[] = $this->get_team($team['teamID']);
		}
		return $output;
	}

	/**
	 * Returns an array of data for a specific team
	 * It should also return all team members.
	 *  
	 * @return array
	 **/
	public function get_team($teamID)
	{
		$fields = array();
		$fieldsQuery = $this->db->query("SELECT `key` FROM `teamData` WHERE `teamID` = ".$this->db->escape($teamID) );
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
		$dataQueryString .= "FROM teamData WHERE teamID = ".$this->db->escape($teamID);
		$dataQuery = $this->db->query($dataQueryString);

		// We would also like to get all the users from the team.
		// So someone should add that in later.

		$output = array_merge(array("teamID"=>$teamID), $dataQuery->row_array());
		return $output;
	}

	/**
	 * Creates a sport with data.
	 * returns the sportID of the new sport if it was
	 * successful. If not, it should return -1.
	 *  
	 * @return int
	 **/
	public function insert_team($centreID, $data)
	{	
		$this->db->trans_start();

		$this->db->query("INSERT INTO teams (teamID) VALUES (".$this->db->escape($teamID).")");
		$teamID = $this->db->insert_id();

		$insertDataArray = array();
		foreach($data as $key=>$value) {
			$dataArray = array(
					'teamID' => $this->db->escape($sportID),
					'key' => $this->db->escape($key),
					'value' => $this->db->escape($value)
				);
			$insertDataArray[] = $dataArray;
		}
		if ($this->db->insert_batch('teamData',$insertDataArray)) {
			// db success
			$this->db->trans_complete();
			return $sportID;
		} else {
			// db fail
			return -1;
		}
	}

	/**
	 * Updates a team with data.
	 *
	 * @return boolean
	 **/
	public function update_team($teamID, $data){

		$this->db->trans_start();

		if($this->team_exists($teamID)){
			foreach($data as $key=>$value) {
				$escKey = $this->db->escape($key);
				$escValue = $this->db->escape($value);
				$dataQueryString = 	"UPDATE `teamData` ".
									"SET `value`=$escValue ".
									"WHERE `key`=$escKey ".
									"AND `teamID`=$teamID";
				$this->db->query($dataQueryString);
			}
			$this->db->trans_complete();
			return true;
		} else {
			return false;
		}
	}
}