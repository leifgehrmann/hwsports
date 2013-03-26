<?php
class Tournament_actors_model extends MY_Model {
	
	public function __construct() {
        parent::__construct();
		// Load models we might be referencing
		
		// Basic variables which apply to all table operations
		$this->objectIDKey = "tournamentActorID";
		$this->dataTableName = "tournamentActorData";
		$this->relationTableName = "tournamentActors";
    }

	/**
	 * Returns all data about a specific tournament actor, including user or team data if relevant
	 *  
	 * @return array
	 **/
	public function get($ID) {
		// Get the tournamentActor row from the tournamentActors table, joined with the role data from sportCategoryRoles. This gives us the info required to get the actual actor
		$tournamentActor = $this->db->select('*')
									->from('tournamentActors')
									->join('sportCategoryRoles', 'sportCategoryRoles.sportCategoryRoleID = tournamentActors.roleID')
									->where('tournamentActorID',$ID)
									->get()->row_array();
		if($query->num_rows() == 0) return FALSE;
		// For each actor, get the actual actor data, using the model as defined by the global array in the constructor 
		$actor = $this->objects_models[$tournamentActor['actorTable']]->get($tournamentActor['actorID']);
		$actor['sportCategoryRoleName'] = $tournamentActor['sportCategoryRoleName'];
		if(!$actor) return FALSE;
		// Now get the tournamentActorData using our lovely dry code
		$actorData = $this->get_object($ID, $this->objectIDKey, $this->dataTableName);
		if(!is_array($actorData)) return FALSE;
		// Append tournamentActorData to data retrieved from user->get or team->get etc
		return $tournamentActor + $actor + $actorData;
	}

	
	public function find($actorID,$roleID) {
		// Get the tournamentActor row from the tournamentActors table, joined with the role data from sportCategoryRoles. This gives us the info required to get the actual actor
		$tournamentActor = $this->db->select('*')
									->from('tournamentActors')
									->where('actorID',$actorID)
									->where('roleID',$roleID)
									->get()->row_array();
		if($tournamentActor===FALSE) return FALSE;
		$tournamentActor = $this->get($tournamentActor['
	}
	
	/**
	 * Returns all data about all actors in specified tournament
	 * 
	 * @return array
	 **/
	public function get_all($tournamentID) {
		// Fetch the IDs for everything at the current sports centre
		$this->db->where( array('tournamentID' => $tournamentID) );
		// Select all info about actors for this specific tournament
		$IDRows = $this->db->get($this->relationTableName)->result_array();
		// Create empty array to output if there are no results
		$all = array();
		// Loop through all result rows, get the ID and use that to put all the data into the output array 
		foreach($IDRows as $IDRow) {
			$tournamentActor = $this->get($IDRow[$this->objectIDKey]);
			$all[$tournamentActor['sportCategoryRoleName']][$IDRow[$this->objectIDKey]] = $tournamentActor;
		}
		return $all;
	}

	// Check if a specific user or team is already an actor for a specific tournament
	public function check_if_actor($tournamentID,$actorID,$roleID) {
		return ( $this->db->get_where($this->relationTableName, array('tournamentID'=>$tournamentID,'actorID'=>$actorID,'roleID'=>$roleID))->row_array() ? TRUE : FALSE );
	}

	/**
	 * Creates a new tournament actor with data, using the tournament ID as specified.
	 * Returns the ID of the new object if it was successful.
	 * Returns FALSE on any error or insertion failure (including foreign key restraints).
	 *  
	 * @return int
	 **/
	public function insert($data, $relationIDs=array()) {
		return $this->insert_object($data, $this->objectIDKey, $this->dataTableName, $this->relationTableName, $relationIDs);
	}

	/**
	 * Updates data for a specific tournament.
	 * Returns TRUE on success.
	 * Returns FALSE on any error or insertion failure (including foreign key restraints).
	 *
	 * @return boolean
	 **/
	public function update($ID, $data) {
		return $this->update_object($ID, $data, $this->objectIDKey, $this->dataTableName);
	}

	/**
	 * Deletes a tournamentActor with data.
	 * Also deletes all objects which depend on it. 
	 * If $testRun is TRUE, no deletion occurs. Instead, a string is returned showing all deletions which would occur otherwise.
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