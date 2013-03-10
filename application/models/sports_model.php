<?php
class Sports_model extends MY_Model {

	public function __construct() {
        parent::__construct();
		// Basic variables which apply to all table operations
		$this->objectIDKey = "sportID";
		$this->dataTableName = "sportData";
		$this->relationTableName = "sports";
    }
	
	/**
	 * Returns all data about a specific sport, including sport category data
	 *  
	 * @return array
	 **/
	public function get($ID) {
		// The relations we are setting up here will pull all the sport category data
		$relations = array(
						array( 
							"objectIDKey" => "sportCategoryID",
							"dataTableName" => "sportCategoryData"
						)
					);
		// Get all data about this sport, the append the data from associated tables as specified above
		$sport = $this->get_object($ID, $this->objectIDKey, $this->dataTableName, $this->relationTableName, $relations);
		// We could do some other specific functional processing here before returning the results if we need to
		return $sport;
	}	
	
	/**
	 * Returns all data about all users at current centre
	 * 
	 * @return array
	 **/
	public function get_all() {
		// Fetch the IDs for everything at the current sports centre
		$IDRows = $this->db->get_where($this->relationTableName, array('centreID' => $this->centreID))->result_array();
		// Create empty array to output if there are no results
		$all = array();
		// Loop through all result rows, get the ID and use that to put all the data into the output array 
		foreach($IDRows as $IDRow) {
			$all[] = $this->get($IDRow[$this->objectIDKey]);
		}
		return $all;
	}
	
	/**
	 * Creates a new sport with data
	 * Returns the ID of the new object if it was successful.
	 * Returns FALSE on any error or insertion failure (including foreign key restraints).
	 *  
	 * @return int
	 **/
	public function insert($data, $relationIDs=array()) {
		return $this->insert_object($data, $this->objectIDKey, $this->dataTableName, $relationIDs);
	}

	/**
	 * Updates data for a specific sport.
	 * Returns TRUE on success.
	 * Returns FALSE on any error or insertion failure (including foreign key restraints).
	 *
	 * @return boolean
	 **/
	public function update($ID, $data) {
		return $this->update_object($ID, $this->objectIDKey, $data, $this->dataTableName);
	}

	/**
	 * Deletes a sport with data.
	 * Also deletes all objects which depend on it, unless $testRun is TRUE in which case a string is returned showing all
	 * Returns TRUE on success.
	 * Returns FALSE on any error or deletion failure (most likely forgotten foreign key restraints).
	 *
	 * @return boolean
	 **/
	public function delete($ID, $testRun=TRUE) {
		$output = "";
		if($testRun) $output .= "If this delete query is executed, the following objects will be deleted: \n\n";
		$output .= $this->delete_object($ID, $this->objectIDKey, $this->relationTableName, $testRun);
		if($testRun) $output .= "If this looks correct, click 'Confirm'. Otherwise please update or delete dependencies manually.";
		return $output;
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
	public function get_sport_categories() {
		// Query to return the IDs for all sport categories
		$IDRows = $this->db->distinct()->get('sportCategoryData')->result_array();
		// Loop through all result rows, get the ID and use that to put all the data into the output array
		foreach($IDRows as $IDRow) {
			$all[$IDRow['sportCategoryID']] = $this->get_sport_category($IDRow['sportCategoryID']);
		}
		return $all;
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
}