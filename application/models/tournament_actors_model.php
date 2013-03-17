<?php
class Tournament_actors_model extends MY_Model {
	
	public function __construct() {
        parent::__construct();
		// Load models we might be referencing
		
		// Basic variables which apply to all table operations
		$this->objectIDKey = "actorID";
		$this->dataTableName = "tournamentActorData";
		$this->relationTableName = "tournamentActors";
		
		$this->load->model("users_model");
		$this->load->model("teams_model");
		$this->load->model("sports_model");
		
		$this->actor_tables_models = array(
			"users" => $this->users_model,
			"teams" => $this->teams_model
		);
    }

	/**
	 * Returns all data about a specific tournament actor, including user or team data if relevant
	 *  
	 * @return array
	 **/
	public function get($ID) {
		// For each actor, get the actual actor data, using the model as defined by the global array in the constructor 
		$actor = $this->actor_tables_models[$actorRow['actorTable']]->get($actorRow['actorID']);
		$actorData = $this->get_object($ID, $this->objectIDKey, $this->dataTableName);
		// This actor ID doesn't exist
		if(!$actor) return FALSE;
		
		return $actor + $actorData;
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
			$all[$IDRow[$this->objectIDKey]] = $this->get($IDRow[$this->objectIDKey]);
		}
		return $all;
	}


	/**
	 * Creates a new tournament with data, using the sport ID as specified.
	 * Returns the ID of the new object if it was successful.
	 * Returns FALSE on any error or insertion failure (including foreign key restraints).
	 *  
	 * @return int
	 **/
	public function insert($data, $relationIDs=array()) {
		$relationIDs['centreID']=$this->centreID;
		return $this->insert_object($data, $this->objectIDKey, $this->dataTableName, $this->relationTableName, $relationIDs);
	}

	/**
	 * Updates data for a specific tournament.
	 * Returns TRUE on success.
	 * Returns FALSE on any error or insertion failure (including foreign key restraints).
	 *
	 * @return boolean
	 **/
	public function update($ID, $data, $relationIDs=array()) {
		return $this->update_object($ID, $data, $this->objectIDKey, $this->dataTableName, $this->relationTableName, $relationIDs);
	}

	/**
	 * Deletes a tournament with data.
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