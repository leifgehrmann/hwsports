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
	public function get_all($where = false) {
		// Fetch the IDs for everything at the current sports centre
		if(is_array($where)) $this->db->where( $where );
		$this->db->where( array('centreID' => $this->centreID) );
		$IDRows = $this->db->get($this->relationTableName)->result_array();
		// Create empty array to output if there are no results
		$all = array();
		// Loop through all result rows, get the ID and use that to put all the data into the output array 
		foreach($IDRows as $IDRow) {
			$all[$IDRow[$this->objectIDKey]] = $this->get($IDRow[$this->objectIDKey]);
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
		$relationIDs['centreID'] = $this->centreID;
		return $this->insert_object($data, $this->objectIDKey, $this->dataTableName, $this->relationTableName, $relationIDs);
	}

	/**
	 * Updates data for a specific sport.
	 * Returns TRUE on success.
	 * Returns FALSE on any error or insertion failure (including foreign key restraints).
	 *
	 * @return boolean
	 **/
	public function update($ID, $data, $relationIDs=array()) {
		return $this->update_object($ID, $data, $this->objectIDKey, $this->dataTableName, $this->relationTableName, $relationIDs);
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
		$deletedRows = $this->delete_object($ID, $this->objectIDKey, $this->relationTableName, $testRun);
		if($testRun) {
			foreach( $deletedRows as $deletedObject ) $output .= "<li>$deletedObject</li>";
			return $output;
		}
		return $deletedRows;
	}
	
	
	/**
	 * Returns all data about a specific sport category
	 *  
	 * @return array
	 **/
	public function get_sport_category($sportCategoryID) {
		// Get all data about this sport, the append the data from associated tables as specified above
		return $this->get_object($sportCategoryID, "sportCategoryID", "sportCategoryData");
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
		// Get roles for this sportCategoryID
		$this->db->where('sportCategoryID',$sportCategoryID);
		$rolesRows = $this->db->get('sportCategoryRoles')->result_array();
		// Put all roles in output array, with all of their descendent sections and inputs
		$output = array();
		foreach($rolesRows as $rolesRow) {
			// Get sections for this role, add to output along with role name
			$output[$rolesRow['sportCategoryRoleID']] = $rolesRow;
			$output[$rolesRow['sportCategoryRoleID']]['inputSections'] = $this->get_sport_category_role_input_sections($rolesRow['sportCategoryRoleID']);
		}
		return $output;
	}
	
	public function get_sport_category_role_input_sections($sportCategoryRoleID) {
		// Get sections for this role
		$this->db->where('sportCategoryRoleID',$sportCategoryRoleID);
		$this->db->order_by('position','asc');
		$roleInputSectionsRows = $this->db->get('sportCategoryRoleInputSections')->result_array();
		// Put all sections in output array, with all of their descendent inputs as value
		$output = array();
		foreach($roleInputSectionsRows as $roleInputSectionsRow) {
			$output[$roleInputSectionsRow['sportCategoryRoleInputSectionID']] = $roleInputSectionsRow;
			$output[$roleInputSectionsRow['sportCategoryRoleInputSectionID']]['inputs'] = $this->get_sport_category_role_input_section_inputs($roleInputSectionsRow['sportCategoryRoleInputSectionID']);
		}
		return $output;
	}
	
	public function get_sport_category_role_input_section_inputs($sportCategoryRoleInputSectionID) {
		// Get inputs for this section
		$this->db->where('sportCategoryRoleInputSectionID',$sportCategoryRoleInputSectionID);
		$this->db->order_by('position','asc');
		$roleInputsRows = $this->db->get('sportCategoryRoleInputs')->result_array();
		$inputs = array();
		foreach($roleInputsRows as $roleInput) {
			$inputs[ $roleInput['sportCategoryRoleInputID'] ] = $roleInput;
		}
		return $inputs;
	}
	
	public function get_sport_category_role_inputs($sportCategoryRoleID) {
		// Get sections for this role
		$this->db->where('sportCategoryRoleID',$sportCategoryRoleID);
		$this->db->order_by('position','asc');
		$roleInputSectionsRows = $this->db->get('sportCategoryRoleInputSections')->result_array();
		// Put all sections in output array, with all of their descendent inputs as value
		$output = array();
		foreach($roleInputSectionsRows as $roleInputSectionsRow) {
			$output += $this->get_sport_category_role_input_section_inputs($roleInputSectionsRow['sportCategoryRoleInputSectionID']);
		}
		return $output;
	}
}