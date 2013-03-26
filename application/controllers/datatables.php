<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Datatables extends MY_Controller {

	function __construct() {
		parent::__construct();
		
		$this->singulars = array(
			"tournaments" => "tournament",
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
			"tournaments" => array("tournamentID" => NULL),
			"venues" => array("venueID" => NULL),
			"users" => array("userID" => NULL),
			"teams" => array("teamID" => NULL),
			"groups" => array("groupID" => NULL)
		);
		
		$this->types_models = array(
			"tournaments" => $this->tournaments_model,
			"matches" => $this->matches_model,
			"sports" => $this->sports_model,
			"venues" => $this->venues_model,
			"users" => $this->users_model,
			"teams" => $this->teams_model,
			"groups" => $this->groups_model,
			"tournamentActors" => $this->tournament_actors_model,
			"matchActors" => $this->match_actors_model
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
						$object['startTime'] = $this->datetime_to_public($object['startTime']);
						$object['endTime'] = $this->datetime_to_public($object['endTime']);
					} else if(isset($object['tournamentStart']) && isset($object['tournamentEnd']) && isset($object['registrationStart']) && isset($object['registrationEnd'])) {
						$object['tournamentStart'] = $this->datetime_to_public($object['tournamentStart']);
						$object['tournamentEnd'] = $this->datetime_to_public($object['tournamentEnd']);
						$object['registrationStart'] = $this->datetime_to_public($object['registrationStart']);
						$object['registrationEnd'] = $this->datetime_to_public($object['registrationEnd']);
					}
					if(isset($object['sportData'])) {
						$object['sportIcon'] = "<div class='icon sportCategoryID-".$object['sportData']['sportCategoryID']." sportID-".$object['sportData']['sportID']."'></div>";
						$object['className'] = "sportCategoryID-".$object['sportData']['sportCategoryID']." sportID-".$object['sportData']['sportID'];
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
					if(isset($newObject['sportData'])) {
						$newObject['sportIcon'] = "<div class='icon sportCategoryID-".$newObject['sportData']['sportCategoryID']." sportID-".$newObject['sportData']['sportID']."'></div>";
					}
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
					if(isset($updatedObject['sportData'])) {
						$updatedObject['sportIcon'] = "<div class='icon sportCategoryID-".$updatedObject['sportData']['sportCategoryID']." sportID-".$updatedObject['sportData']['sportID']."'></div>";
					}
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
	
	// Handle filtered user tables slightly differently as we're only showing a subset of the users based on a where clause, and we only want to add new users by email search 
	public function filtered_data($filtered_IDs,$relationTable,$relations,$loadIDKey,$updateIDKey,$object) {
		switch ($this->action) {
			case "load":
				if(count($filtered_IDs)) {
					// Only output data with IDs which were in the supplied ID array
					$this->db->where_in($loadIDKey, $filtered_IDs);
				} else {
					// No IDs were provided, set impossible where clause so data function returns empty data set to datatables
					$this->db->where(array($loadIDKey => -1));
				}
				$this->data($object);
			break;
			case "create":
				// This input array should already have whatever other IDs are required in the many-to-many table (such as groupID=>1)
				$insertData = $relations;
				// Get ID of user object to add to relations table if relevant
				if($object == "users") {
					$user = $this->users_model->find_by_email($_POST['data']['email']);
					if($user===FALSE) {
						$out = array('error' => "Email could not be found in database. Please try again or contact Infusion Systems.");
						$this->load->view('data', array('data' => json_encode($out)) );
						return;
					}
					// Add the user ID to the insert data
					$insertData[$updateIDKey] = $user['userID'];
					// Insert user
					if($this->db->insert($relationTable, $insertData)) {
						$user['detailsLink'] = "<a href='/tms/user/{$user['userID']}' class='button'>Details</a>";
						$out = array('id' => "users-{$user['userID']}", 'row' => $user);
					} else {
						$out = array('error' => "User could not be added. Please try again or contact Infusion Systems.");
					}
					// Add availability data
					if(isset($_POST['data']['availableMonday'])) {
						$tournamentActorID = $this->db->insert_id();
						$this->tournament_actors_model->update($tournamentActorID, 
							array(
								'availableMonday'=>$_POST['data']['availableMonday'],
								'availableTuesday'=>$_POST['data']['availableTuesday'],
								'availableWednesday'=>$_POST['data']['availableWednesday'],
								'availableThursday'=>$_POST['data']['availableThursday'],
								'availableFriday'=>$_POST['data']['availableFriday'],
								'availableSaturday'=>$_POST['data']['availableSaturday'],
								'availableSunday'=>$_POST['data']['availableSunday']
							)
						);
					}
					$this->load->view('data', array('data' => json_encode($out)) );
				} else if($object == "teams") {
					$tournament = $this->tournaments_model->get($insertData['tournamentID']);
					$roleIDs = $this->sports_model->get_sport_category_roles_simple($tournament['sportData']['sportCategoryID'],false);
					$roleID = $roleIDs['team'];
					$team = $this->teams_model->get($_POST['data']['teamID']);
					// Check if team ID exists
					if($team===FALSE) {
						$out = array('error' => "Team ID {$_POST['data']['teamID']} does not exist. Please try again or contact Infusion Systems.");
						$this->load->view('data', array('data' => json_encode($out)) );
						return;
					}
					// Check if team ID is already in this tournament
					if($this->objects_models['tournament_actors']->check_if_actor($insertData['tournamentID'],$_POST['data']['teamID'],$roleID)) {
						$out = array('error' => "Team ID {$_POST['data']['teamID']} is already in this tournment. Please try again or contact Infusion Systems.");
						$this->load->view('data', array('data' => json_encode($out)) );
						return;
					}
					// Set up tournamentActor row to add team ID as team role to this tournament
					$tournamentActorRelations = array(
						'tournamentID' => $insertData['tournamentID'],
						'actorID' => $_POST['data']['teamID'],
						'roleID' => $roleID
					);
					// Create the tournamentActor with relations but no data
					$tournamentActorID = $this->objects_models['tournament_actors']->insert(array(), $tournamentActorRelations);
					// Check if tournamentActorID was created
					if($tournamentActorID===FALSE) {
						$out = array('error' => "Team ID {$_POST['data']['teamID']} could not be created. Please try again or contact Infusion Systems.");
						$this->load->view('data', array('data' => json_encode($out)) );
						return;
					}
					// Add the team details link to the output row
					$team['detailsLink'] = "<a href='/tms/user/{$_POST['data']['teamID']}' class='button'>Details</a>";
					$out = array('id' => "teams-{$_POST['data']['teamID']}", 'row' => $team);
					$this->load->view('data', array('data' => json_encode($out)) );
				} else {
					$this->data($object);
				}
			break;
			case "edit":
				$this->data($object);
			break;
			case "remove":
				$this->data($object);
			break;
		}
	}
	
	// Handle datatables requests for the groupUsers table, which displays users in a specific group, using the many to many table "usersGroups" with fields "groupID" and "userID"
	// The idea here is to use the main data method above as much as possible, as if we were simply dealing with the users table,
	// but filter the initial output by groupID from usersGroups first. The create function should also be vetoed, and act only as a simple insert into "usersGroups". Same for delete.
	public function groupUsers($groupID) {
		$loadIDKey = $updateIDKey = 'userID';
		$relationTable = 'usersGroups';
		$relations = array('groupID' => $groupID);
		$filteredRows = $this->db->get_where($relationTable,$relations)->result_array();
		$filtered_IDs = array();
		foreach($filteredRows as $filteredRow) {
			$filtered_IDs[] = $filteredRow[$updateIDKey];
		}
		
		if($this->action == "remove") {
			// Get the userID to delete from the many-to-many table
			$delete_type_id = explode('-',$_POST['data'][0]);
			$ID = $delete_type_id[1];
			// This input array should already have whatever other IDs are required in the many-to-many table (such as groupID=>1)
			$deleteData = $relations;
			// Add the user ID to the insert data
			$deleteData[$updateIDKey] = $ID;
			$deleteOutput = $this->db->delete($relationTable, $deleteData);
			// Define the return value based on deletion success
			$out = $deleteOutput ? array('id' => -1) : array('error' => "An error occurred. Please contact Infusion Systems.");// Send it back to the client, via our plain data dump view
			$this->load->view('data', array('data' => json_encode($out)) );
			return;
		}
		$this->filtered_data($filtered_IDs,$relationTable,$relations,$loadIDKey,$updateIDKey,'users');
	}
	
	// Handle datatables requests for the teamsUsers table, which displays users in a specific team, using the many to many table "teamsUsers" with fields "teamID" and "userID"
	// The idea here is to use the main data method above as much as possible, as if we were simply dealing with the users table,
	// but filter the initial output by teamID from teamsUsers first. The create function should also be vetoed, and act only as a simple insert into "teamsUsers". Same for delete.
	public function teamUsers($teamID) {
		$loadIDKey = $updateIDKey = 'userID';
		$relationTable = 'teamsUsers';
		$relations = array('teamID' => $teamID);
		$filteredRows = $this->db->get_where($relationTable,$relations)->result_array();
		$filtered_IDs = array();
		foreach($filteredRows as $filteredRow) {
			$filtered_IDs[] = $filteredRow[$updateIDKey];
		}
		
		if($this->action == "remove") {
			// Get the userID to delete from the many-to-many table
			$delete_type_id = explode('-',$_POST['data'][0]);
			$ID = $delete_type_id[1];
			// This input array should already have whatever other IDs are required in the many-to-many table (such as groupID=>1)
			$deleteData = $relations;
			// Add the user ID to the insert data
			$deleteData[$updateIDKey] = $ID;
			$deleteOutput = $this->db->delete($relationTable, $deleteData);
			// Define the return value based on deletion success
			$out = $deleteOutput ? array('id' => -1) : array('error' => "An error occurred. Please contact Infusion Systems.");// Send it back to the client, via our plain data dump view
			$this->load->view('data', array('data' => json_encode($out)) );
			return;
		}
		
		$this->filtered_data($filtered_IDs,$relationTable,$relations,$loadIDKey,$updateIDKey,'users');
	}
	
	// Handle datatables requests for the tournamentActors table, referencing the umpire role for this tournament which displays umpires in a specific tournament, with cool tournamentActor relations.
	public function tournamentUmpires($tournamentID) {
		if($this->action == "remove") {
			$this->deleteTournamentUmpire($tournamentID.'-'.$_POST['data'][0],false);
			return;
		}
		$tournament = $this->tournaments_model->get($tournamentID);
		$roleIDs = $this->sports_model->get_sport_category_roles_simple($tournament['sportData']['sportCategoryID'],FALSE);
		$loadIDKey = 'userID';
		$updateIDKey = 'actorID';
		$relationTable = 'tournamentActors';
		$relations = array('tournamentID' => $tournamentID, 'roleID' => $roleIDs['umpire']);
		$filteredRows = $this->db->get_where($relationTable,$relations)->result_array();
		$filtered_IDs = array();
		foreach($filteredRows as $filteredRow) {
			$filtered_IDs[] = $filteredRow[$updateIDKey];
		}
		$this->filtered_data($filtered_IDs,$relationTable,$relations,$loadIDKey,$updateIDKey,'users');
	}
	
	// Handle datatables requests for the tournamentActors table, referencing the athlete role for this tournament which displays umpires in a specific tournament, with cool tournamentActor relations.
	public function tournamentAthletes($tournamentID) {
		if($this->action == "remove") {
			$this->deleteTournamentAthlete($tournamentID.'-'.$_POST['data'][0],false);
			return;
		}
		$tournament = $this->tournaments_model->get($tournamentID);
		$roleIDs = $this->sports_model->get_sport_category_roles_simple($tournament['sportData']['sportCategoryID'],FALSE);
		$loadIDKey = 'userID';
		$updateIDKey = 'actorID';
		$relationTable = 'tournamentActors';
		$relations = array('tournamentID' => $tournamentID, 'roleID' => $roleIDs['athlete']);
		$filteredRows = $this->db->get_where($relationTable,$relations)->result_array();
		$filtered_IDs = array();
		foreach($filteredRows as $filteredRow) {
			$filtered_IDs[] = $filteredRow[$updateIDKey];
		}
		$this->filtered_data($filtered_IDs,$relationTable,$relations,$loadIDKey,$updateIDKey,'users');
	}
	
	// Handle datatables requests for the tournamentActors table, referencing the team role (roleID 2) which displays teams in a specific tournament, with cool tournamentActor relations.
	public function tournamentTeams($tournamentID) {
		if($this->action == "remove") {
			$this->deleteTournamentTeam($tournamentID.'-'.$_POST['data'][0],false);
			return;
		}
		$tournament = $this->tournaments_model->get($tournamentID);
		$roleIDs = $this->sports_model->get_sport_category_roles_simple($tournament['sportData']['sportCategoryID'],FALSE);
		$loadIDKey = 'teamID';
		$updateIDKey = 'actorID';
		$relationTable = 'tournamentActors';
		$relations = array('tournamentID' => $tournamentID, 'roleID' => $roleIDs['team']);
		$filteredRows = $this->db->get_where($relationTable,$relations)->result_array();
		$filtered_IDs = array();
		foreach($filteredRows as $filteredRow) {
			$filtered_IDs[] = $filteredRow[$updateIDKey];
		}
		$this->filtered_data($filtered_IDs,$relationTable,$relations,$loadIDKey,$updateIDKey,'teams');
	}
	
	// Handle datatables requests for the tournamentActors table, referencing the team role (roleID 2) which displays teams in a specific tournament, with cool tournamentActor relations.
	public function tournamentMatches($tournamentID) {
		$loadIDKey = $updateIDKey = 'matchID';
		$relationTable = 'matches';
		$relations = array('tournamentID' => $tournamentID);
		$filteredRows = $this->db->get_where($relationTable,$relations)->result_array();
		$filtered_IDs = array();
		foreach($filteredRows as $filteredRow) {
			$filtered_IDs[] = $filteredRow[$updateIDKey];
		}
		$this->filtered_data($filtered_IDs,$relationTable,$relations,$loadIDKey,$updateIDKey,'matches');
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
	
	// Show the user what *exactly* will happen when they remove team from tournament
	public function deleteTournamentTeam($rowID,$test=true) {
		// Get type/model and object ID from type-ID input string
		$tournament_type_id = explode('-',$rowID);
		$tournamentID = $tournament_type_id[0];
		$actorID = $tournament_type_id[2];
		// Get role ID
		$tournament = $this->tournaments_model->get($tournamentID);
		$roleIDs = $this->sports_model->get_sport_category_roles_simple($tournament['sportData']['sportCategoryID'],FALSE);
		$roleID = $roleIDs['team'];
		// Get tournamentActorID from actorID and roleID
		$actor = $this->tournament_actors_model->find($actorID,$roleID);
		$tournamentActorID = $actor['tournamentActorID'];
		// Execute the delete function of the model for this input, which just does a trial run when the second parameter is omitted.
		$deleteOutput = $this->types_models['tournamentActors']->delete($tournamentActorID,$test);
		$this->data['dependencies'] = $deleteOutput;
		if($test) {
			$this->load->view('tms/delete-confirm.php',$this->data);
		} else {
			// Define the return value based on deletion success
			$out = $deleteOutput ? array('id' => -1) : array('error' => "An error occurred. Please contact Infusion Systems.");// Send it back to the client, via our plain data dump view
			$this->load->view('data', array('data' => json_encode($out)) );
		}
	}
	// Show the user what *exactly* will happen when they remove team from tournament
	public function deleteTournamentAthlete($rowID,$test=true) {
		// Get type/model and object ID from type-ID input string
		$tournament_type_id = explode('-',$rowID);
		$tournamentID = $tournament_type_id[0];
		$actorID = $tournament_type_id[2];
		// Get role ID
		$tournament = $this->tournaments_model->get($tournamentID);
		$roleIDs = $this->sports_model->get_sport_category_roles_simple($tournament['sportData']['sportCategoryID'],FALSE);
		$roleID = $roleIDs['athlete'];
		// Get tournamentActorID from actorID and roleID
		$actor = $this->tournament_actors_model->find($actorID,$roleID);
		$tournamentActorID = $actor['tournamentActorID'];
		// Execute the delete function of the model for this input, which just does a trial run when the second parameter is omitted.
		$deleteOutput = $this->types_models['tournamentActors']->delete($tournamentActorID,$test);
		$this->data['dependencies'] = $deleteOutput;
		if($test) {
			$this->load->view('tms/delete-confirm.php',$this->data);
		} else {
			// Define the return value based on deletion success
			$out = $deleteOutput ? array('id' => -1) : array('error' => "An error occurred. Please contact Infusion Systems.");// Send it back to the client, via our plain data dump view
			$this->load->view('data', array('data' => json_encode($out)) );
		}
	}
	// Show the user what *exactly* will happen when they remove team from tournament
	public function deleteTournamentUmpire($rowID,$test=true) {
		// Get type/model and object ID from type-ID input string
		$tournament_type_id = explode('-',$rowID);
		$tournamentID = $tournament_type_id[0];
		$actorID = $tournament_type_id[2];
		// Get role ID
		$tournament = $this->tournaments_model->get($tournamentID);
		$roleIDs = $this->sports_model->get_sport_category_roles_simple($tournament['sportData']['sportCategoryID'],FALSE);
		$roleID = $roleIDs['umpire'];
		// Get tournamentActorID from actorID and roleID
		$actor = $this->tournament_actors_model->find($actorID,$roleID);
		$tournamentActorID = $actor['tournamentActorID'];
		// Execute the delete function of the model for this input, which just does a trial run when the second parameter is omitted.
		$deleteOutput = $this->types_models['tournamentActors']->delete($tournamentActorID,$test);
		$this->data['dependencies'] = $deleteOutput;
		if($test) {
			$this->load->view('tms/delete-confirm.php',$this->data);
		} else {
			// Define the return value based on deletion success
			$out = $deleteOutput ? array('id' => -1) : array('error' => "An error occurred. Please contact Infusion Systems.");// Send it back to the client, via our plain data dump view
			$this->load->view('data', array('data' => json_encode($out)) );
		}
	}
}