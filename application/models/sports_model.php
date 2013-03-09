<?php
class Sports_model extends MY_Model {

	/**
	 * Returns all data about a specific sport, including sport category data
	 *  
	 * @return array
	 **/
	public function get_sport($sportID) {
		// The relations we are setting up here will pull all the sport category data
		$relations = array(
						array( 
							"objectIDKey" => "sportCategoryID",
							"dataTableName" => "sportCategoryData"
						)
					);
		// Get all data about this sport, the append the data from associated tables as specified above
		$sport = $this->get_object($sportID, "sportID", "sportData", "sports", $relations);
		// We could do some other specific functional processing here before returning the results if we need to
		return $sport;
	}	
	
	/**
	 * Returns all data about all sports at a specific centre
	 *  
	 * @return array
	 **/
	public function get_sports($centreID) {
		// Query to return the IDs for everything which takes place at the specified sports centre
		$IDsQuery = $this->db->query("SELECT sportID FROM sports WHERE centreID = ".$this->db->escape($centreID));
		// Loop through all result rows, get the ID and use that to put all the data into the output array 
		foreach($IDsQuery->result_array() as $IDRow) {
			$all[] = $this->get_sport($IDRow['sportID']);
		}
		return (empty($all) ? FALSE : $all);
	}
	
	
	/**
	 * Returns all data about a specific sport category
	 *  
	 * @return array
	 **/
	public function get_sport_category($sportCategoryID) {
		// Get all data about this sport, the append the data from associated tables as specified above
		$sport = $this->get_object($sportCategoryID, "sportCategoryID", "sportCategoryData");
	}
	
	/**
	 * Returns all data about all sport categories at a specific centre
	 *  
	 * @return array
	 **/
	public function get_sport_categories($centreID) {
		// Query to return the IDs for everything which takes place at the specified sports centre
		$IDsQuery = $this->db->query("SELECT DISTINCT sportCategoryID FROM sportCategoryData");
		// Loop through all result rows, get the ID and use that to put all the data into the output array 
		foreach($IDsQuery->result_array() as $IDRow) {
			$all[$IDRow['sportCategoryID']] = $this->get_sport_category($IDRow['sportCategoryID']);
		}
		return (empty($all) ? FALSE : $all);
	}
	
	
	public function get_sport_category_roles($sportCategoryID)
	{
		$output = array();
		// Get roles for this sportCategoryID
		$rolesQuery = $this->db->query("SELECT * FROM `sportCategoryRoles` WHERE `sportCategoryID` = ".$this->db->escape($sportCategoryID) );
		$rolesResult = $rolesQuery->result_array();
		foreach($rolesResult as $roleResult) {
			// Get sections for this role
			$roleInputSectionsQuery = $this->db->query("SELECT * FROM `sportCategoryRoleInputSections` WHERE `sportCategoryRoleID` = ".$this->db->escape( $roleResult['sportCategoryRoleID'] )." ORDER BY position ASC" );
			$roleInputSectionsResult = $roleInputSectionsQuery->result_array();
			$sections = array();
			foreach($roleInputSectionsResult as $roleInputSectionResult) {
				// Get inputs for this section
				$roleInputsQuery = $this->db->query("SELECT * FROM `sportCategoryRoleInputs` WHERE `sportCategoryRoleInputSectionID` = ".$this->db->escape( $roleInputSectionResult['sportCategoryRoleInputSectionID'] )." ORDER BY position ASC" );
				$roleInputsResult = $roleInputsQuery->result_array();
				$inputs = array();
				foreach($roleInputsResult as $roleInput) {
					$inputs[ $roleInput['sportCategoryRoleInputID'] ] = array (
						'tableName' => $roleInput['tableName'],
						'tableKeyName' => $roleInput['tableKeyName'],
						'keyName' => $roleInput['keyName'],
						'inputType' => $roleInput['inputType'],
						'formLabel' => $roleInput['formLabel']
					);
				}
					
				$sections[ $roleInputSectionResult['sportCategoryRoleInputSectionID'] ] = array (
					'label' => $roleInputSectionResult['label'],
					'inputs' => $inputs
				);
			}
			
			// Add role to output
			$output[$roleResult['sportCategoryRoleID']] = array (
				'name' => $roleResult['sportCategoryRoleName'],
				'inputSections' => $sections
			);
		}
		
		return $output;
	}
	
	public function get_sport_category_role_inputs($sportCategoryRoleID)
	{
		$output = array();
		
		// Get sections for this role
		$roleInputSectionsQuery = $this->db->query("SELECT sportCategoryRoleInputSectionID,label FROM `sportCategoryRoleInputSections` WHERE `sportCategoryRoleID` = ".$this->db->escape( $sportCategoryRoleID )." ORDER BY position ASC" );
		$roleInputSectionsResult = $roleInputSectionsQuery->result_array();
		$sections = array();
		foreach($roleInputSectionsResult as $roleInputSectionResult) {
			// Get inputs for this section
			$roleInputsQuery = $this->db->query("SELECT * FROM `sportCategoryRoleInputs` WHERE `sportCategoryRoleInputSectionID` = ".$this->db->escape( $roleInputSectionResult['sportCategoryRoleInputSectionID'] )." ORDER BY position ASC" );
			$roleInputsResult = $roleInputsQuery->result_array();
			foreach($roleInputsResult as $roleInput) {
				$output[ $roleInput['sportCategoryRoleInputID'] ] = array (
					'tableName' => $roleInput['tableName'],
					'tableKeyName' => $roleInput['tableKeyName'],
					'keyName' => $roleInput['keyName'],
					'inputType' => $roleInput['inputType'],
					'formLabel' => $roleInput['formLabel']
				);
			}
		}
		
		return $output;
	}
	
	public function get_sport_category_role_input_section_inputs($sportCategoryRoleInputSectionID)
	{
		$output = array();
		// Get inputs for this section
		$roleInputsQuery = $this->db->query("SELECT sportCategoryRoleInputID,keyName,inputType,formLabel FROM `sportCategoryRoleInputs` WHERE `sportCategoryRoleInputSectionID` = ".$this->db->escape( $sportCategoryRoleInputSectionID )." ORDER BY position ASC" );
		$roleInputsResult = $roleInputsQuery->result_array();
		$inputs = array();
		foreach($roleInputsResult as $roleInput) {
			$inputs[ $roleInput['sportCategoryRoleInputID'] ] = array (
				'keyName' => $roleInput['keyName'],
				'inputType' => $roleInput['inputType'],
				'formLabel' => $roleInput['formLabel']
			);
		}
		
		return $inputs;
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
	}
}