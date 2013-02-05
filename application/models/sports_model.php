<?php
class Sports_model extends CI_Model {

	/**
	 * $sportID is int(11)
	 *  
	 * @return boolean
	 **/

	public function sport_exists($sportID)
	{
		$output = array();
		$queryString = 	"SELECT ".$this->db->escape($sportID)." AS sportID, ".
						"EXISTS(SELECT 1 FROM sports WHERE sportID = ".$this->db->escape($sportID).") AS `exists`";
		$queryData = $this->db->query($queryString);
		$output = $queryData->row_array();
		return $output['exists'];
	}

	/**
	 * Returns a 2d array of sport data
	 *  
	 * @return array
	 **/

	public function get_sports($centreID)
	{
		$output = array();
		$queryString = "SELECT sportID FROM sports WHERE centreID = ".$this->db->escape($centreID);
		$queryData = $this->db->query($queryString);
		$data = $queryData->result_array();
		foreach($data as $sport) {
			$output[] = $this->get_sport($sport['sportID']);
		}
		return $output;
	}

	/**
	 * Returns an array of data from a specific sport
	 *  
	 * @return array
	 **/
	public function get_sport($sportID)
	{
		$fields = array();
		$fieldsQuery = $this->db->query("SELECT `key` FROM `sportData` WHERE `sportID` = ".$this->db->escape($sportID) );
		$fieldsResult = $fieldsQuery->result_array();
		foreach($fieldsResult as $fieldResult) {
			$fields[] = $fieldResult['key'];
		}

		/* Query the ids that are associated with this match */
		$relational = array();
		$relationalString = "SELECT sportCategoryID FROM sports WHERE sportID = ".$this->db->escape($sportID);
		$relationalQuery = $this->db->query($relationalString);
		$relationalResult = $relationalQuery->result_array();

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
		$dataQueryString .= "FROM sportData WHERE sportID = ".$this->db->escape($sportID);
		$dataQuery = $this->db->query($dataQueryString);
		$output = array_merge(array("sportID"=>$sportID), $dataQuery->row_array());
		$output['sportCategoryID'] = $relationalResult[0]['sportCategoryID'];
		$output['sportCategory'] = $this->get_sport_category($relationalResult[0]['sportCategoryID']);
		return $output;
	}

	public function get_sport_categories()
	{
		$output = array();
		$queryString = "SELECT DISTINCT sportCategoryID FROM sportCategoryData";
		$queryData = $this->db->query($queryString);
		$data = $queryData->result_array();
		foreach($data as $sportCategory) {
			$output[$sportCategory['sportCategoryID']] = $this->get_sport_category($sportCategory['sportCategoryID']);
		}
		return $output;
	}

	public function get_sport_category($sportCategoryID)
	{
		$fields = array();
		$fieldsQuery = $this->db->query("SELECT `key` FROM `sportCategoryData` WHERE `sportCategoryID` = ".$this->db->escape($sportCategoryID) );
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
		$dataQueryString .= "FROM sportCategoryData WHERE sportCategoryID = ".$this->db->escape($sportCategoryID);
		$dataQuery = $this->db->query($dataQueryString);
		$output = array_merge($dataQuery->row_array());
		return $output;
	}
	
	
	public function get_sport_category_roles($sportCategoryID)
	{
		$output = array();
		// Get roles for this sportCategoryID
		$rolesQuery = $this->db->query("SELECT * FROM `sportCategoryRoles` WHERE `sportCategoryID` = ".$this->db->escape($sportCategoryID) );
		$rolesResult = $rolesQuery->result_array();
		foreach($rolesResult as $roleResult) {
			// Get sections for this role
			$roleInputSectionsQuery = $this->db->query("SELECT sportCategoryRoleInputSectionID,label FROM `sportCategoryRoleInputSections` WHERE `sportCategoryRoleID` = ".$this->db->escape( $roleResult['sportCategoryRoleID'] )." ORDER BY position ASC" );
			$roleInputSectionsResult = $roleInputSectionsQuery->result_array();
			$sections = array();
			foreach($roleInputSectionsResult as $roleInputSectionResult) {
				// Get inputs for this section
				$roleInputsQuery = $this->db->query("SELECT sportCategoryRoleInputID,keyName,inputType,formLabel FROM `sportCategoryRoleInputs` WHERE `sportCategoryRoleInputSectionID` = ".$this->db->escape( $roleInputSectionResult['sportCategoryRoleInputSectionID'] )." ORDER BY position ASC" );
				$roleInputsResult = $roleInputsQuery->result_array();
				$inputs = array();
				foreach($roleInputsResult as $roleInput) {
					$inputs[ $roleInput['sportCategoryRoleInputID'] ] = array (
						'keyName' => $roleInput['keyName'],
						'inputType' => $roleInput['inputType'],
						'formLabel' => $roleInput['formLabel']
					};
				}
					
				$sections[ $roleInputSectionResult['sportCategoryRoleInputSectionID'] ] = array (
					'label' => $roleInputSectionResult['label'],
					'inputs' => $inputs
				};
			}
			
			// Add role to output
			$output[] = array (
				'name' => $roleResult['sportCategoryRoleName'],
				'inputSections' => $sections
			);
		}
		
		return $output;
	}

	/**
	 * Creates a sport with data.
	 * returns the sportID of the new sport if it was
	 * successful. If not, it should return -1.
	 *  
	 * @return int
	 **/
	public function insert_sport($centreID, $data)
	{	
		$this->db->trans_start();

		$this->db->query("INSERT INTO sports (centreID) VALUES (".$this->db->escape($centreID).")");
		$sportID = $this->db->insert_id();

		$insertDataArray = array();
		foreach($data as $key=>$value) {
			$dataArray = array(
					'sportID' => $this->db->escape($sportID),
					'key' => $this->db->escape($key),
					'value' => $this->db->escape($value)
				);
			$insertDataArray[] = $dataArray;
		}
		if ($this->db->insert_batch('venueData',$insertDataArray)) {
			// db success
			$this->db->trans_complete();
			return $sportID;
		} else {
			// db fail
			return -1;
		}
	}

	/**
	 * Updates a sport with data.
	 *
	 * @return boolean
	 **/
	public function update_venue($sportID, $data){

		$this->db->trans_start();

		if($this->venue_exists($sportID)){
			foreach($data as $key=>$value) {
				$escKey = $this->db->escape($key);
				$escValue = $this->db->escape($value);
				$dataQueryString = 	"UPDATE `venueData` ".
									"SET `value`=$escValue ".
									"WHERE `key`=$escKey ".
									"AND `sportID`=$sportID";
				$this->db->query($dataQueryString);
			}
			$this->db->trans_complete();
			return true;
		} else {
			return false;
		}
	}
}