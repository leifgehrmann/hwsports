<?php
class Match_actors_model extends MY_Model {
	
	public function __construct() {
        parent::__construct();
		// Load models we might be referencing
		
		// Basic variables which apply to all table operations
		$this->objectIDKey = "matchActorID";
		$this->dataTableName = "matchActorData";
		$this->relationTableName = "matchActors";
    }

	/**
	 * Returns all data about a specific tournament actor, including user or team data if relevant
	 *  
	 * @return array
	 **/
	public function get($ID) {
		// Get the matchActor row from the matchActors table, joined with the role data from sportCategoryRoles. This gives us the info required to get the actual actor
		$matchActor = $this->db->select('*')
									->from('matchActors')
									->join('sportCategoryRoles', 'sportCategoryRoles.sportCategoryRoleID = matchActors.roleID')
									->where('matchActorID',$ID)
									->get()->row_array();
		if($matchActor===FALSE) return FALSE;
		// For each actor, get the actual actor data, using the model as defined by the global array in the constructor 
		$actor = $this->objects_models[$matchActor['actorTable']]->get($matchActor['actorID']);
		$actor['sportCategoryRoleName'] = $matchActor['sportCategoryRoleName'];
		if(!$actor) return FALSE;
		// Now get the matchActorData using our lovely dry code
		$actorData = $this->get_object($ID, $this->objectIDKey, $this->dataTableName);
		if(!is_array($actorData)) return FALSE;
		// Append matchActorData to data retrieved from user->get or team->get etc
		return $matchActor + $actor + $actorData;
	}

	// Allows us to find a matchActor (including ID) when we know the user or team ID and the roleID
	public function find($actorID,$roleID) {
		// Get the matchActor row from the matchActors table, joined with the role data from sportCategoryRoles. This gives us the info required to get the actual actor
		$matchActor = $this->db->select('*')
									->from('matchActors')
									->where('actorID',$actorID)
									->where('roleID',$roleID)
									->get();
		if($matchActor->num_rows() == 0) return FALSE;
		$matchActor = $matchActor->row_array();
		return $this->get($matchActor['matchActorID']);
	}
	
	/**
	 * Returns all data about all actors in specified match
	 * 
	 * @return array
	 **/
	public function get_all($matchID) {
		// Fetch the IDs for everything at the current sports centre
		$this->db->where( array('matchID' => $matchID) );
		// Select all info about actors for this specific match
		$IDRows = $this->db->get($this->relationTableName)->result_array();
		// Create empty array to output if there are no results
		$all = array();
		// Loop through all result rows, get the ID and use that to put all the data into the output array 
		foreach($IDRows as $IDRow) {
			$matchActor = $this->get($IDRow[$this->objectIDKey]);
			$all[$matchActor['sportCategoryRoleName']][$IDRow[$this->objectIDKey]] = $matchActor;
		}
		return $all;
	}

	// Check if a specific user or team is already an actor for a specific match
	public function check_if_actor($matchID,$actorID,$roleID) {
		return ( $this->db->get_where($this->relationTableName, array('matchID'=>$matchID,'actorID'=>$actorID,'roleID'=>$roleID))->row_array() ? TRUE : FALSE );
	}

	/**
	 * Creates a new match actor with data, using the match ID as specified.
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
	public function update($ID, $data) {
		return $this->update_object($ID, $data, $this->objectIDKey, $this->dataTableName);
	}

	/**
	 * Deletes a matchActor with data.
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