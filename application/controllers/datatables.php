<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Datatables extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('matches_model');
		$this->load->model('sports_model');
		$this->load->model('venues_model');
		$this->load->model('teams_model');
		$this->load->model('users_model');
		$this->load->model('groups_model');
		
		$this->singulars = array(
			"matches" => "match",
			"sports" => "sport",
			"venues" => "venue",
			"users" => "user",
			"teams" => "team",
			"groups" => "group"
		);
		
		$this->relations = array(
			"matches" => array("matchID" => NULL,"sportID" => NULL,"venueID" => NULL,"tournamentID" => 0),
			"sports" => array("sportID" => NULL,"sportCategoryID" => NULL),
			"venues" => array("venueID" => NULL),
			"users" => array("userID" => NULL),
			"teams" => array("teamID" => NULL),
			"groups" => array("groupID" => NULL)
		);
		
		$this->types_models = array(
			"matches" => $this->matches_model,
			"sports" => $this->sports_model,
			"venues" => $this->venues_model,
			"users" => $this->users_model,
			"teams" => $this->teams_model,
			"groups" => $this->groups_model
		);
		
		// Define action even if the use has just loaded the page
		$this->action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "load";
	}

	// $type should be the plural model name; eg sports, venues, matches
	public function data($type) {
		// Initialise the output array which will be jsonified to pass to datatables.
		$out = array (
			'id' => -1,
			'error' => '',
			'fieldErrors' => array (),
			'data' => array ()
		);
		// Different actions based on different ajax requests
		switch ($this->action) {
			case "load":
				// Load all objects of type from the correct model. Assume model named based on type exists.
				$allObjects = $this->types_models[$type]->get_all();
				// Loop through all objects, process them if required and add them to the output array as datatables rows
				$aaData = array();
				foreach($allObjects as $ID => $object) {
					// The DataTables row ID; eg. sports-8 or matches-332
					$object['DT_RowId'] = "$type-$ID";
					// Format date/time objects for the public
					if(isset($object['startTime']) && isset($object['endTime'])) {
						$object['startTime'] = datetime_to_public($object['endTime']);
						$object['endTime'] = datetime_to_public($object['endTime']);
					}
					$object['detailsLink'] = "<a href='/tms/{$this->singulars[$type]}/$ID' class='button'>Details</a>";
					// Create / add to the aaData rows array, ready to be jsonified
					$aaData[] = $object;
				}
				// Finally add the aaData array to the output array
				$out['aaData'] = $aaData;
			break;
			case "create":
				// Copy the input data so we feel better about modifying it directly
				$newData = $_POST['data'];
				// For each input ID which is defined as a relational field for this type, remove from input and put into relations
				$newRelations = array();
				foreach($this->relations[$type] as $relation => $default) {
					if(strlen(trim($newData[$relation]))) {
						// If this input field has a value, add it to the relations array. Otherwise just unset it
						// This allows for empty primary IDs to be submitted by dataTables (such as no-tournament matches etc)
						// Since the database will just give them the default value, or auto_increment which is usually what we want
						$newRelations[$relation] = $newData[$relation];
					} elseif($default!==NULL) {
						// Set relation ID to a default if none was provided - this covers the issue of tournamentID in matches
						$newRelations[$relation] = $default;
					}
					unset($newData[$relation]);
				}
				// Do the insert, with an empty $newRelations array if there are no dependents
				$newID = $this->types_models[$type]->insert($newData,$newRelations);
				if($newID!==FALSE) {
					$newObject = $this->types_models[$type]->get($newID);
					$newObject['detailsLink'] = "<a href='/tms/{$this->singulars[$type]}/$newID' class='button'>Details</a>";
					$out = array('id' => "$type-$newID", 'row' => $newObject);
				} else {
					$out = array('error' => "An error occurred. Please contact Infusion Systems.");
				}
			break;
			case "edit":
				// Get the ID of the object we are editing
				$edit_type_id = explode('-',$_POST['id']);
				$ID = $edit_type_id[1];
				// Data to update
				$updateData = $_POST['data'];
				// For each input ID which is defined as a relational field for this type, remove from input and put into relations
				$updateRelations = array();
				foreach($this->relations[$type] as $relation => $default) {
					if(strlen(trim($updateData[$relation]))) {
						// If this input field has a value, add it to the relations array. Otherwise just unset it
						// This allows for empty primary IDs to be submitted by dataTables (such as no-tournament matches etc)
						// Since the database will just give them the default value, or auto_increment which is usually what we want
						$updateRelations[$relation] = $updateData[$relation];
					} elseif($default!==NULL) {
						// Set relation ID to a default if none was provided - this covers the issue of tournamentID in matches
						$updateRelations[$relation] = $default;
					}
					unset($updateData[$relation]);
				}
				// Perform the update, catch the result
				$updateSuccess = $this->types_models[$type]->update($ID, $updateData, $updateRelations);
				if($updateSuccess!==FALSE) {
					$updatedObject = $this->types_models[$type]->get($ID);
					$updatedObject['detailsLink'] = "<a href='/tms/{$this->singulars[$type]}/$ID' class='button'>Details</a>";
					$out = array('id' => "$type-$ID", 'row' => $updatedObject);
				} else {
					$out = array('error' => "An error occurred. Please contact Infusion Systems.");
				}
			break;
			case "remove":
				// We should only ever have one row selected when delete is pressed, 
				// so data[0] from the input the type-ID string of the row which is being deleted
				$delete_type_id = explode('-',$_POST['data'][0]);
				$ID = $delete_type_id[1];
				// Execute the delete function of the correct model with the second parameter set to false to confirm deletion
				$deleteOutput = $this->types_models[$type]->delete($ID, false); 
				// Define the return value based on deletion success
				$out = $deleteOutput ? array('id' => -1) : array('error' => "An error occurred. Please contact Infusion Systems.");
			break;
		}
		
		// Add value => label data to output to allow dropdown select boxes to work in create/edit dialogs 
		foreach($this->sports_model->get_sport_categories() as $ID => $sportCategory) {
			$out['sportCategories'][] = array(
				'value' => $ID,
				'label' => $sportCategory['name']
			);
		}
		foreach($this->venues_model->get_all() as $ID => $venue) {
			$out['venues'][] = array(
				'value' => $ID,
				'label' => $venue['name']
			);
		}
		foreach($this->sports_model->get_all() as $ID => $sport) {
			$out['sports'][] = array(
				'value' => $ID,
				'label' => $sport['name']
			);
		}
		
		// Send it back to the client, via our plain data dump view
		$this->load->view('data', array('data' => json_encode($out)) );
	}
	
	// Show the user what *exactly* will happen when they click delete
	public function teamUsers($teamID) {
		switch ($this->action) {
			case "load":
				// Query the teamsUsers table for all users in this team, then add a where clause for each
				$teamUsersRows = $this->db->get_where('teamsUsers',array('teamID' => $teamID))->result_array();
				$teamUserCount = count($teamUsersRows);
				if($teamUserCount) {
					for($i=0; $i<$teamUserCount; $i++) {
						if($i==0) $this->db->where(array('userID' => $teamUsersRows[0]['userID']));
						else $this->db->or_where(array('userID' => $teamUsersRows[$i]['userID']));
					}
				} else {
					$this->db->where(array('userID' => -1));
				}
				$this->data('users');
			break;
			case "create":
				$user = $this->users_model->find_by_email($_POST['data']['email']);
				if($user===FALSE) {
					$out = array('error' => "Email could not be found in database. Please try again or contact Infusion Systems.");
					$this->load->view('data', array('data' => json_encode($out)) );
					return;
				}
					
				if($this->db->insert('teamsUsers', array('teamID'=>$teamID, 'userID'=>$user['userID']) )) {
					$user['detailsLink'] = "<a href='/tms/user/{$user['userID']}' class='button'>Details</a>";
					$out = array('id' => "users-{$user['userID']}", 'row' => $user);
				} else {
					$out = array('error' => "User could not be added to team. Please try again or contact Infusion Systems.");
				}
				$this->load->view('data', array('data' => json_encode($out)) );
			break;
			case "edit":
				$this->data('users');
			break;
			case "remove":
				// Get the userID to delete from the teamsUsers table
				$delete_type_id = explode('-',$_POST['data']['id']);
				$ID = $delete_type_id[1];
				$deleteOutput = $this->db->delete('teamsUsers', array('teamID' => $teamID, 'userID' => $ID));
				// Define the return value based on deletion success
				$out = $deleteOutput ? array('id' => -1) : array('error' => "An error occurred. Please contact Infusion Systems.");// Send it back to the client, via our plain data dump view
				$this->load->view('data', array('data' => json_encode($out)) );
			break;
		}
	}
	
	// Show the user what *exactly* will happen when they click delete
	public function predelete($rowID) {
		// Get type/model and object ID from type-ID input string
		$type_id = explode('-',$rowID);
		$type = $type_id[0];
		$ID = $type_id[1];
		// Execute the delete function of the model for this input, which just does a trial run when the second parameter is omitted.
		$deleteOutput = $this->types_models[$type]->delete($ID);
		$this->data['dependencies'] = $deleteOutput;
		$this->load->view('tms/delete-confirm.php',$this->data);
	}
}