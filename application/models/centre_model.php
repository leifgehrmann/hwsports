<?php
class Centre_model extends CI_Model {

	/**
	 * $centreID is int(11)
	 *  
	 * @return boolean
	 **/

	public function centre_exists($centreID)
	{
		$output = array();
		$queryString = 	"SELECT ".$this->db->escape($centreID)." AS centreID, ".
						"EXISTS(SELECT 1 FROM centreData WHERE centreID = ".$this->db->escape($centreID).") AS `exists`";
		$queryData = $this->db->query($queryString);
		$output = $queryData->row_array();
		return $output;
	}

	/**
	 * Returns a 2d array of data for all centres
	 *  
	 * @return array
	 **/
	public function get_centres($centreID, $fields=array("name","shortName","address","headerColour","backgroundColour","footerText"))
	{
		$output = array();
		$queryString = "SELECT DISTINCT centreID FROM centreData";
		$queryData = $this->db->query($queryString);
		$data = $queryData->result_array();
		foreach($data as $centre) {
			$output[] = $this->get_centre($centre['centreID'],$fields);
		}
		return $output;
	}

	/**
	 * Returns an array of data from a specific centre
	 *  
	 * @return array
	 **/
	public function get_centre($centreID)
	{
		
		$fieldsQuery = $this->db->query("SELECT key FROM centreData WHERE centreID = ".$this->db->escape($centreID) );
		$fields = $fieldsQuery->result_array();
		
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
		$dataQueryString .= "FROM centreData WHERE centreID = ".$this->db->escape($centreID);
		$dataQuery = $this->db->query($dataQueryString);
		$output = array_merge(array("centreID"=>$centreID), $dataQuery->row_array());
		return $output;
	}

	/**
	 * Creates a centre with data.
	 * returns the centreID of the new centre if it was
	 * successful. If not, it should return -1.
	 *  
	 * @return int
	 **/
	public function insert_centre($data)
	{	
		$this->db->trans_start();

		$this->db->query("INSERT INTO centreData (centreID) VALUES (".$this->db->escape($centreID).")");
		$centreID = $this->db->insert_id();

		$insertDataArray = array();
		foreach($data as $key=>$value) {
			$dataArray = array(
					'centreID' => $this->db->escape($centreID),
					'key' => $this->db->escape($key),
					'value' => $this->db->escape($value)
				);
			$insertDataArray[] = $dataArray;
		}
		if ($this->db->insert_batch('centreData',$insertDataArray)) {
			// db success
			$this->db->trans_complete();
			return $centreID;
		} else {
			// db fail
			return -1;
		}
	}

	/**
	 * Updates a centre with data.
	 *
	 * @return boolean
	 **/
	public function update_centre($centreID, $data){

		$this->db->trans_start();

		if($this->centre_exists($centreID)){
			foreach($data as $key=>$value) {
				$escKey = $this->db->escape($key);
				$escValue = $this->db->escape($value);
				$dataQueryString = 	"UPDATE `centreData` ".
									"SET `value`=$escValue ".
									"WHERE `key`=$escKey ".
									"AND `centreID`=$centreID";
				$this->db->query($dataQueryString);
			}
			$this->db->trans_complete();
			return true;
		} else {
			return false;
		}
	}
}