<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tms extends MY_Controller {

	function __construct()
	{
		parent::__construct();

		// If user is an admin, we grant full permission

		// If user is centreadmin, we need to check if they are actually part of
		// the centre, and not of another centre.

		// If the user is staff, we need to check if they are actually part of
		// the centre, and not of another centre.

		// If user is regular user, then redirect to sis

		/*$authorized = False;
		if ( $this->ion_auth->in_group('admin') ){
			$authorized = True;
		} else if ( $this->ion_auth->in_group('centreadmin') && $this->data['centre']['centreID'])*/

		if ( $this->ion_auth->in_group('admin') || $this->ion_auth->in_group('centreadmin') ) {
			$this->data['currentUser'] = $currentUser = $this->ion_auth->user()->row();
			$query = $this->db->query("SELECT `key`,`value` FROM `userData` WHERE `userID` = '{$currentUser->userID}'");
			foreach($query->result_array() as $userDataRow) {
				$currentUser->$userDataRow['key'] = $userDataRow['value'];
			}
		} else {
			//redirect them to the sis homepage
			redirect('/', 'refresh');
		}
		
		$this->data['message'] = $this->session->flashdata('message');
		$this->data['message_information'] = $this->session->flashdata('message_information');
		$this->data['message_success'] = $this->session->flashdata('message_success');
		$this->data['message_warning'] = $this->session->flashdata('message_warning');
		$this->data['message_error'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message_error')));
	}

	/**
	 * A short hand method to basically print out the page with a certain pageid and title
	 *
	 * @param view 		The view to load
	 * @param page 		The page ID it will have
	 * @param title 	
	 * @param data 		passed in data
	 */
	public function view($view,$page,$title,$data){
		$data['title'] = $title;
		$data['page'] = $page;
		$this->load->view('tms/header',$data);
		$this->load->view('tms/'.$view,$data);
		$this->load->view('tms/footer',$data);
	}

	/**
	 * A short hand method to redirect user with message
	 *
	 * @param status 	Type of flash message to display (error, success)
	 * @param page 		The page to redirect to
	 * @param message	Message to display 	
	 */
	public function flash_redirect($status,$page,$message){
		$this->session->set_flashdata($status, $message);
		redirect($page, 'refresh');
	}

	public function index()
	{



		// Get todays date as a string
		// Note we want to say that today is everything until this afternoon.
		$today = new DateTime();
		$today->setTime ( 23, 59, 59 );

		// Get all the tournaments and matches from the database.
		$latestMatches = $this->matches_model->get_all(FALSE,$today); // Get all matches that have occured and today's matches
		$upcomingMatches = $this->matches_model->get_all($today,FALSE); // Get all tournaments that occur after today
		$latestTournaments = $this->tournaments_model->get_all(FALSE, $today); // Get all matches that have occured and today's matches
		$upcomingTournaments  = $this->tournaments_model->get_all($today,FALSE); // Get all tournaments that occur after today

		// We want to remove the matches that already exist in the latest matches
		foreach($upcomingMatches as $u=>$uMatch){
			if($today<new DateTime($uMatch['startTime']))
				continue;
			foreach($latestMatches as $i=>$lMatch){
				if($uMatch['matchID']==$lMatch['matchID']){
					unset($upcomingMatches[$u]);
					break;
				}
			}
		}
		// We want to remove the tournaments that already exist in the latest tournaments
		foreach($upcomingTournaments as $u=>$uTournament){
			if($today<new DateTime($uTournament['tournamentStart']))
				continue;
			foreach($latestTournaments as $i=>$lTournament){
				if($uTournament['tournamentID']==$lTournament['tournamentID']){
					unset($upcomingTournaments[$u]);
					break;
				}
			}
		}
		function cmpMatches($a, $b){
			$a = new DateTime($a['endTime']);
			$b = new DateTime($b['endTime']);
			if ($a == $b) { return 0; }
			return ($a < $b) ? -1 : 1;
		}
		function cmpTournaments($a, $b){
			$a = new DateTime($a['tournamentEnd']);
			$b = new DateTime($b['tournamentEnd']);
			if ($a == $b) { return 0; }
			return ($a < $b) ? -1 : 1;
		}

		usort($latestMatches, "cmpMatches");
		usort($upcomingMatches, "cmpMatches");
		usort($latestTournaments, "cmpTournaments");
		usort($upcomingTournaments, "cmpTournaments");
		$latestMatches 			= array_slice($latestMatches, -0, 5);
		$upcomingMatches 		= array_slice($upcomingMatches, -0, 5);
		$latestTournaments 		= array_slice($latestTournaments, -0, 5);
		$upcomingTournaments 	= array_slice($upcomingTournaments, -0, 5);
		$this->data['latestMatches'] 		= $latestMatches;
		$this->data['upcomingMatches'] 		= $upcomingMatches;
		$this->data['latestTournaments'] 	= $latestTournaments;
		$this->data['upcomingTournaments'] 	= $upcomingTournaments;

		$this->view('home',"tmshome","Home",$this->data);
	}
	public function tournaments()
	{	
		$tournamentDetailsForm = array(
			'name' => array(
				'name'=>'name',
				'label'=>'Name',
				'restrict'=>'required|xss_clean',
				'type'=>'text'
			),
			'description' => array(
				'name'=>'description',
				'label'=>'Description',
				'restrict'=>'required|xss_clean',
				'type'=>'text'
			),
			array(
				'name'=>'sport',
				'label'=>'Sport',
				'restrict'=>'required|xss_clean',
			),
			'registrationStart' => array(
				'name'=>'registrationStart',
				'label'=>'Registration Start Date',
				'restrict'=>'required|xss_clean|callback_datetime_check[registrationStart]',
				'type'=>'date'
			),
			'registrationEnd' => array(
				'name'=>'registrationEnd',
				'label'=>'Registration End Date',
				'restrict'=>'required|xss_clean|callback_datetime_check[registrationEnd]',
				'type'=>'date'
			),
			'tournamentStart' => array(
				'name'=>'tournamentStart',
				'label'=>'Tournament Start Date',
				'restrict'=>'required|xss_clean|callback_datetime_check[tournamentStart]',
				'type'=>'date'
			),
			'tournamentEnd' => array(
				'name'=>'tournamentEnd',
				'label'=>'Tournament End Date',
				'restrict'=>'required|xss_clean|callback_datetime_check[tournamentEnd]',
				'type'=>'date'
			)
		);
	
		foreach($tournamentDetailsForm as $input){
			$this->form_validation->set_rules($input['name'], $input['label'], $input['restrict']);
		}
		
		if ($this->form_validation->run() == true) {
			$newdata = array_intersect_key($_POST, $tournamentDetailsForm);
			$newdata['scheduled'] = 0;
			$relationIDs = array(
				'sportID' => $_POST['sport']
			);
			
			foreach($tournamentDetailsForm as $input){
				$this->form_validation->set_rules($input['name'], $input['label'], $input['restrict']);
				if($input['label']=='date'){
					// Change dates from public, timepicker-friendly format to database-friendly ISO format.
					if($this->input->post($input['name'])) $newdata[$input['name']] = $this->datetime_to_standard($this->input->post($input['name']));
				}
			}

			$tournamentID = $this->tournaments_model->insert($newdata,$relationIDs);
			if($tournamentID > -1) {
				// Successful update, show success message
				$this->session->set_flashdata('message_success',  'Successfully Created Tournament.');
			} else {
				$this->session->set_flashdata('message_error',  'Failed. Please contact Infusion Systems.');
			}
			redirect("/tms/tournament/$tournamentID", 'refresh');
		} else {
			//display the create user form		
			$this->data['tournaments'] = $this->tournaments_model->get_all();
		
			$this->data['sports'] = array();
			foreach( $this->sports_model->get_all() as $sport) {				
				$this->data['sports'][$sport['sportCategoryData']['name']][$sport['sportID']] = $sport['name'];
			}
			ksort($this->data['sports']);

			foreach($tournamentDetailsForm as $input){
				if(array_key_exists('type',$input)){
					if($input['name']=="description"){
						$this->data[$input['name']]['style'] = 'width:100%;';
						$this->data[$input['name']]['rows'] = '5';
					}
					if($input['type']=="date"){
						$this->data[$input['name']] = array(
							'name'  => $input['name'],
							'id'    => $input['name'],
							'type'  => 'text',
							'class' => 'date',
							'value' => $this->datetime_to_public( $this->form_validation->set_value($input['name']) )
						);
					} else {
						$this->data[$input['name']] = array(
							'name'  => $input['name'],
							'id'    => $input['name'],
							'type'  => $input['type'],
							'value' => $this->form_validation->set_value($input['type'])
						);
					}
				}
			}
		}
		$this->view('tournaments',"tournaments","Tournaments",$this->data);
	}
	
	public function tournament($tournamentID) {
		$weekdays = array('monday','tuesday','wednesday','thursday','friday','saturday','sunday');

		// These are all the possible form fields that will be displayed
		$tournamentDetailsForm = array(
			array(
				'name'=>'name',
				'label'=>'Name',
				'restrict'=>'required|xss_clean',
				'type'=>'text'
			),
			array(
				'name'=>'description',
				'label'=>'Description',
				'restrict'=>'required|xss_clean',
				'type'=>'text'
			),
			array(
				'name'=>'registrationStart',
				'label'=>'Registration Start Date',
				'restrict'=>'required|xss_clean|callback_datetime_check[registrationStart]',
				'type'=>'date'
			),
			array(
				'name'=>'registrationEnd',
				'label'=>'Registration End Date',
				'restrict'=>'required|xss_clean|callback_datetime_check[registrationEnd]',
				'type'=>'date'
			),
			array(
				'name'=>'tournamentStart',
				'label'=>'Tournament Start Date',
				'restrict'=>'required|xss_clean|callback_datetime_check[tournamentStart]',
				'type'=>'date'
			),
			array(
				'name'=>'tournamentEnd',
				'label'=>'Tournament End Date',
				'restrict'=>'required|xss_clean|callback_datetime_check[tournamentEnd]',
				'type'=>'date'
			)
		);
		$scheduleMatchesForm = array(
			array(
				'name'=>'matchDuration',
				'label'=>'Match Duration',
				'restrict'=>'required|xss_clean|is_natural_no_zero',
				'type'=>'text'
			)
		);


		// Does the tournament even exist?
		$this->data['tournamentID'] = $tournamentID;
		$this->data['tournament'] = $tournament = $this->tournaments_model->get($tournamentID);
		if($tournament===FALSE) {
			$this->session->set_flashdata('message_error',  "Tournament ID $tournamentID does not exist.");
			redirect("/tms/tournaments", 'refresh');
		}

		$formID = $this->input->post('form');
		$formAction = $this->input->post('action');
		//var_dump($this->input->post('form'));
		//var_dump($this->input->post('action'));
		if($formID=="tournamentDetailsForm"){
			$newdata = $_POST;
			// For each of the input types we will validate it.
			foreach($tournamentDetailsForm as $input){
				$this->form_validation->set_rules($input['name'], $input['label'], $input['restrict']);
				if($input['type']=='date'){
					// Change dates from public, timepicker-friendly format to database-friendly ISO format.
					if($this->input->post($input['name'])) $newdata[$input['name']] = $this->datetime_to_standard($this->input->post($input['name']));
				}
			}
			if ($this->form_validation->run() == true) {
				if($this->tournaments_model->update($tournamentID, $newdata)) {
					// Successful update, show success message
					$this->session->set_flashdata('message_success',  'Successfully updated tournament.');
				} else {
					$this->session->set_flashdata('message_error',  'Failed to update tournament. Please contact Infusion Systems.');
				}
				redirect("/tms/tournament/$tournamentID", 'refresh');
			}
		} else if($formID=="scheduleMatchesForm") {
			// We need to validate the scheduling details stuff.
			// For each of the input types we will validate it.
			foreach($scheduleMatchesForm as $input)
				$this->form_validation->set_rules($input['name'], $input['label'], $input['restrict']);
			if ($this->form_validation->run() == true) {
				// Create the update array
				$tournamentUpdate = array(
					'matchDuration' => $this->input->post('matchDuration')
				);
				// Update the starttime for each weekday
				foreach($weekdays as $weekday){
					if($this->input->post('startTimes'.ucfirst($weekday)))
						$tournamentUpdate['startTimes'.ucfirst($weekday)] = implode(",",$this->input->post('startTimes'.ucfirst($weekday)));
					else
						$tournamentUpdate['startTimes'.ucfirst($weekday)] = "";
				}
				// Venues have been selected, try to update them
				if($this->input->post('venues')) {
					if($this->tournaments_model->update_venues($tournamentID,$this->input->post('venues'))===FALSE) {
						$this->session->set_flashdata('message_error', 'Failed to update venues. Please contact Infusion Systems.');
						redirect("/tms/tournament/$tournamentID", 'refresh');
					}
				}
				// Now update the tournament
				if($this->tournaments_model->update($tournamentID, $tournamentUpdate)===FALSE) {
					$this->session->set_flashdata('message_error', 'Failed to update scheduling details. Please contact Infusion Systems.');
					redirect("/tms/tournament/$tournamentID", 'refresh');
				}
			
				// Probably use the scheduling model based on what we want to execute.
				if($tournament['sportData']['sportCategoryID']==18){
					// We would like to get an array of roleIDs so that we can insert them into the actors table.
					$roleIDs = $this->sports_model->get_sport_category_roles_simple($tournament['sportData']['sportCategoryID'],FALSE);
					// This execute the football family scheduler
					$scheduledMatches = $this->scheduling_model->schedule_football_family($tournamentID);
					if(!is_array($scheduledMatches)) {
						$this->session->set_flashdata('message_error', $scheduledMatches);
						redirect("/tms/tournament/$tournamentID", 'refresh');
					}
					foreach($scheduledMatches as $match){
						$matchData = array(
							'startTime' => $match['startTime'],
							'endTime' => $match['endTime'],
							'name' => $match['name']
						);
						$matchRelations = array(
							'tournamentID' => $tournamentID,
							'venueID' => $match['venueID'],
							'sportID' => $tournament['sportID']
						);
						// Insert the match
						$matchID = $this->matches_model->insert($matchData,$matchRelations);
						if($matchID===FALSE) {
							$this->session->set_flashdata('message_error', 'Failed to insert match. Please contact Infusion Systems.');
							redirect("/tms/tournament/$tournamentID", 'refresh');
						}
						// Insert the teams for the match
						foreach($match['matchActors']['teamIDs'] as $teamID) {
							$matchRelations = array('matchID'=>$matchID,'roleID'=>$roleIDs['team'],'actorID'=>$teamID);
							if($this->match_actors_model->insert($matchRelations)===FALSE) {
								$this->session->set_flashdata('message_error', 'Failed to insert match actor. Please contact Infusion Systems.');
								redirect("/tms/tournament/$tournamentID", 'refresh');
							}
						}
						// Insert the umpires for the match
						foreach($match['matchActors']['umpireIDs'] as $umpireID) {
							$matchRelations = array('matchID'=>$matchID,'roleID'=>$roleIDs['umpire'],'actorID'=>$umpireID);
							if($this->match_actors_model->insert($matchRelations)===FALSE) {
								$this->session->set_flashdata('message_error', 'Failed to insert match actor. Please contact Infusion Systems.');
								redirect("/tms/tournament/$tournamentID", 'refresh');
							}
						}
					}
					if($this->tournaments_model->update($tournamentID,array('scheduled'=>'1'))===FALSE) {
						$this->session->set_flashdata('message_error', 'Failed to set tournament to scheduled. Please contact Infusion Systems.');
						redirect("/tms/tournament/$tournamentID", 'refresh');
					}
					// Wow, we finally got here.
					$this->session->set_flashdata('message_success', 'Successfully scheduled tournament!');
					redirect("/tms/tournament/$tournamentID", 'refresh');
				} else if($tournament['sportData']['sportCategoryID']==46){
					// We would like to get an array of roleIDs so that we can insert them into the actors table.
					$roleIDs = $this->sports_model->get_sport_category_roles_simple($tournament['sportData']['sportCategoryID'],FALSE);
					// This execute the running scheduler
					$scheduledMatches = $this->scheduling_model->schedule_running($tournamentID);
					if(!is_array($scheduledMatches)) {
						$this->session->set_flashdata('message_error', $scheduledMatches);
						redirect("/tms/tournament/$tournamentID", 'refresh');
					}
					foreach($scheduledMatches as $match){
						$matchData = array(
							'startTime' => $match['startTime'],
							'endTime' => $match['endTime'],
							'name' => $match['name']
						);
						$matchRelations = array(
							'tournamentID' => $tournamentID,
							'venueID' => $match['venueID'],
							'sportID' => $tournament['sportID']
						);
						// Insert the match
						$matchID = $this->matches_model->insert($matchData,$matchRelations);
						if($matchID===FALSE) {
							$this->session->set_flashdata('message_error', 'Failed to insert match. Please contact Infusion Systems.');
							redirect("/tms/tournament/$tournamentID", 'refresh');
						}
						
						/*// Insert the teams for the match
						foreach($match['matchActors']['teamIDs'] as $teamID) {
							$matchRelations = array('matchID'=>$matchID,'roleID'=>$roleIDs['team'],'actorID'=>$teamID);
							if($this->match_actors_model->insert($matchRelations)===FALSE) {
								$this->session->set_flashdata('message_error', 'Failed to insert match actor. Please contact Infusion Systems.');
								redirect("/tms/tournament/$tournamentID", 'refresh');
							}
						}*/
					}
					if($this->tournaments_model->update($tournamentID,array('scheduled'=>'1'))===FALSE) {
						$this->session->set_flashdata('message_error', 'Failed to set tournament to scheduled. Please contact Infusion Systems.');
						redirect("/tms/tournament/$tournamentID", 'refresh');
					}
					// Wow, we finally got here.
					$this->session->set_flashdata('message_success', 'Successfully scheduled tournament!');
					redirect("/tms/tournament/$tournamentID", 'refresh');
				}
			}
		}

		$this->data['roles'] = $this->sports_model->get_sport_category_roles_simple($tournament['sportData']['sportCategoryID']);
		$this->data['matches'] = $this->matches_model->get_tournament_matches($tournamentID);

		// Set the values for the tournament details form
		$this->data['name'] = array(
			'name'  => 'name',
			'id'    => 'name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('name',(isset($tournament['name']) ? $tournament['name'] : '') )
		);
		$this->data['description'] = array(
			'name'  => 'description',
			'id'    => 'description',
			'type'  => 'text',
			'style' => 'width:100%;',
			'rows'  => '5',
			'value' => $this->form_validation->set_value('description',(isset($tournament['description']) ? $tournament['description'] : '') )
		);
		$this->data['registrationStart'] = array(
			'name'  => 'registrationStart',
			'id'    => 'registrationStart',
			'type'  => 'text',
			'class' => 'date',
			'value' => $this->datetime_to_public( $this->form_validation->set_value('registrationStart',(isset($tournament['registrationStart']) ? $tournament['registrationStart'] : '') ) )
		);
		$this->data['registrationEnd'] = array(
			'name'  => 'registrationEnd',
			'id'    => 'registrationEnd',
			'type'  => 'text',
			'class' => 'date',
			'value' => $this->datetime_to_public( $this->form_validation->set_value('registrationEnd',(isset($tournament['registrationEnd']) ? $tournament['registrationEnd'] : '') ) )
		);
		$this->data['tournamentStart'] = array(
			'name'  => 'tournamentStart',
			'id'    => 'tournamentStart',
			'type'  => 'text',
			'class' => 'date',
			'value' => $this->datetime_to_public( $this->form_validation->set_value('tournamentStart',(isset($tournament['tournamentStart']) ? $tournament['tournamentStart'] : '') ) )
		);
		$this->data['tournamentEnd'] = array(
			'name'  => 'tournamentEnd',
			'id'    => 'tournamentEnd',
			'type'  => 'text',
			'class' => 'date',
			'value' => $this->datetime_to_public( $this->form_validation->set_value('tournamentEnd',(isset($tournament['tournamentEnd']) ? $tournament['tournamentEnd'] : '') ) )
		);
		// Set the values for the schedule matches form
		$this->data['matchDuration'] = array(
			'name'  => 'matchDuration',
			'id'    => 'matchDuration',
			'value' => $this->form_validation->set_value('matchDuration',(isset($tournament['matchDuration']) ? $tournament['matchDuration'] : '') )
		);
		foreach($weekdays as $weekday)
			$this->data[$weekday.'StartTimes'] = $this->form_validation->set_value('matchDuration',(isset($tournament[$weekday.'StartTimes']) ? explode(',',$tournament[$weekday.'StartTimes']) : '') );

		// Get all tournament venues
		$venues = $this->tournaments_model->get_venues($tournamentID);
		$venueSelections = array();
		foreach($venues as $venue)
			$venueSelections[] = $venue['venueID'];

		// Get all venues
		$venues = $this->venues_model->get_all();
		$venueOptions = array();
		$venueOptions[''] = ''; // Empty Selection
		foreach($venues as $venue)
			$venueOptions[$venue['venueID']] = $venue['name'];

		// Get the startTimes for the tournament
		$startTimes = array();
		foreach($weekdays as $day)
		{	
			$startTimes[$day] = array();
			if(array_key_exists('startTimes'.ucfirst($day),$tournament))
			{
				$times = explode(",",$tournament['startTimes'.ucfirst($day)]);
				foreach($times as $time)
				{
					$startTimes[$day][] = $time;
				}
			}
		}

		// Send the venue data
		$this->data['venueOptions'] = $venueOptions;
		$this->data['venueSelections'] = $venueSelections;

		// Send the start times
		$this->data['startTimes'] = $startTimes;
		
		$this->view('tournament',"tournament","Tournament",$this->data);
	}
	
	public function delete_tournament($tournamentID) {


		if($this->tournaments_model->delete($tournamentID) ) {
			// Successful delete, show success message
			$this->session->set_flashdata('message_success',  'Successfully Deleted Tournament.');
		} else {
			$this->session->set_flashdata('message_error',  'Failed. Please contact Infusion Systems.');
		}
		redirect("/tms/tournaments", 'refresh');
	}

	public function venues($action='portal')
	{
	
		// query google maps api for lat / lng of sports centre
		$address = urlencode($this->data['centre']['address']);
		$url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=uk";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$json = curl_exec($ch);
		curl_close($ch);
		$apiData = json_decode($json);
		
		//$this->data['apiData'] = $json;
		$lat = $apiData->results[0]->geometry->location->lat;
		$lng = $apiData->results[0]->geometry->location->lng;

		$this->data['centreLat'] = $lat;
		$this->data['centreLng'] = $lng;
		
		$this->view('venues',"venues","Tournament",$this->data);
	}

	public function venue($venueID)
	{
		$venueDetailsForm = array(
			array(
				'name'=>'name',
				'label'=>'Name',
				'restrict'=>'required|xss_clean',
				'type'=>'text'
			),
			array(
				'name'=>'description',
				'label'=>'Description',
				'restrict'=>'required|xss_clean',
				'type'=>'text'
			),
			array(
				'name'=>'directions',
				'label'=>'Directions',
				'restrict'=>'required|xss_clean',
				'type'=>'text'
			)
		);
		// Does the match even exist?
		$this->data['venueID'] = $venueID;
		$this->data['venue'] = $venue = $this->venues_model->get($venueID);
		if($venue===FALSE) {
			$this->session->set_flashdata('message_error',  "Venue ID $venueID does not exist.");
			redirect("/tms/venues", 'refresh');
		}

		// We validate the data from the form
		$newdata = $_POST;
		// For each of the input types we will validate it.
		foreach($venueDetailsForm as $input){
			$this->form_validation->set_rules($input['name'], $input['label'], $input['restrict']);
		}
		if ($this->form_validation->run() == true) {
			if($this->venues_model->update($venueID, $newdata)) {
				// Successful update, show success message
				$this->session->set_flashdata('message_success',  'Successfully updated venue.');
			} else {
				$this->session->set_flashdata('message_error',  'Failed to update venue. Please contact Infusion Systems.');
			}
			redirect("/tms/venue/$venueID", 'refresh');
		}

		foreach($venueDetailsForm as $input){
			if(array_key_exists('type',$input)){
				$this->data[$input['name']] = array(
					'name'  => $input['name'],
					'id'    => $input['name'],
					'type'  => $input['type'],
					'value' => $this->form_validation->set_value($input['type'], (isset($venue[$input['name']]) ? $venue[$input['name']] : ''))
				);
				if($input['name']=="description"||$input['name']=="directions"){
					$this->data[$input['name']]['style'] = 'width:100%;';
					$this->data[$input['name']]['rows'] = '5';
				}
			}
		}

		$this->view('venue',"venue",$this->data['venue']['name']." | Venue",$this->data);
	}
	public function sports()
	{
		$this->view('sports',"sports","Sports",$this->data);
	}
	public function sport($sportID)
	{
		$sportDetailsForm = array(
			array(
				'name'=>'name',
				'label'=>'Name',
				'restrict'=>'required|xss_clean',
				'type'=>'text'
			),
			array(
				'name'=>'description',
				'label'=>'Description',
				'restrict'=>'required|xss_clean',
				'type'=>'text'
			)
		);
		// Does the match even exist?
		$this->data['sportID'] = $sportID;
		$this->data['sport'] = $sport = $this->sports_model->get($sportID);
		if($sport===FALSE) {
			$this->session->set_flashdata('message_error',  "Sport ID $sportID does not exist.");
			redirect("/tms/sports", 'refresh');
		}

		// We validate the data from the form
		$newdata = $_POST;
		// For each of the input types we will validate it.
		foreach($sportDetailsForm as $input){
			$this->form_validation->set_rules($input['name'], $input['label'], $input['restrict']);
		}
		if ($this->form_validation->run() == true) {
			if($this->sports_model->update($sportID, $newdata)) {
				// Successful update, show success message
				$this->session->set_flashdata('message_success',  'Successfully updated sport.');
			} else {
				$this->session->set_flashdata('message_error',  'Failed to update sport. Please contact Infusion Systems.');
			}
			redirect("/tms/sport/$sportID", 'refresh');
		}

		foreach($sportDetailsForm as $input){
			if(array_key_exists('type',$input)){
				$this->data[$input['name']] = array(
					'name'  => $input['name'],
					'id'    => $input['name'],
					'type'  => $input['type'],
					'value' => $this->form_validation->set_value($input['type'], (isset($sport[$input['name']]) ? $sport[$input['name']] : ''))
				);
				if($input['name']=="description"){
					$this->data[$input['name']]['style'] = 'width:100%;';
					$this->data[$input['name']]['rows'] = '5';
				}
			}
		}
		$this->view('sport',"sport",$this->data['sport']['name']." | Sport",$this->data);
	}
	public function match($matchID)
	{	
		$matchDetailsForm = array(
			array(
				'name'=>'name',
				'label'=>'Name',
				'restrict'=>'required|xss_clean',
				'type'=>'text'
			),
			array(
				'name'=>'description',
				'label'=>'Description',
				'restrict'=>'required|xss_clean',
				'type'=>'text'
			),
			array(
				'name'=>'startTime',
				'label'=>'Start Time',
				'restrict'=>'required|xss_clean|callback_datetime_check[startTime]',
				'type'=>'date'
			),
			array(
				'name'=>'endTime',
				'label'=>'End Time',
				'restrict'=>'required|xss_clean|callback_datetime_check[endTime]',
				'type'=>'date'
			)
		);
		// Does the match even exist?
		$this->data['matchID'] = $matchID;
		$this->data['match'] = $match = $this->matches_model->get($matchID);
		if($match===FALSE) {
			$this->session->set_flashdata('message_error',  "Match ID $matchID does not exist.");
			redirect("/tms/matches", 'refresh');
		}

		// We validate the data from the form
		$newdata = $_POST;
		// For each of the input types we will validate it.
		foreach($matchDetailsForm as $input){
			$this->form_validation->set_rules($input['name'], $input['label'], $input['restrict']);
			if($input['type']=='date'){
				// Change dates from public, timepicker-friendly format to database-friendly ISO format.
				if($this->input->post($input['name'])) $newdata[$input['name']] = $this->datetime_to_standard($this->input->post($input['name']));
			}
		}
		if ($this->form_validation->run() == true) {
			if($this->matches_model->update($matchID, $newdata)) {
				// Successful update, show success message
				$this->session->set_flashdata('message_success',  'Successfully updated match.');
			} else {
				$this->session->set_flashdata('message_error',  'Failed to update match. Please contact Infusion Systems.');
			}
			redirect("/tms/match/$matchID", 'refresh');
		}

		foreach($matchDetailsForm as $input){
			if(array_key_exists('type',$input)){
				if($input['name']=="description"){
					$this->data[$input['name']]['style'] = 'width:100%;';
					$this->data[$input['name']]['rows'] = '5';
				}
				if($input['type']=="date"){
					$this->data[$input['name']] = array(
						'name'  => $input['name'],
						'id'    => $input['name'],
						'type'  => 'text',
						'class' => 'date',
						'value' => $this->datetime_to_public( $this->form_validation->set_value($input['name'], (isset($match[$input['name']]) ? $match[$input['name']] : '')))
					);
				} else {
					$this->data[$input['name']] = array(
						'name'  => $input['name'],
						'id'    => $input['name'],
						'type'  => $input['type'],
						'value' => $this->form_validation->set_value($input['type'], (isset($match[$input['name']]) ? $match[$input['name']] : ''))
					);
				}
			}
		}
		
		//$this->data['match']['startTime'] = $this->datetime_to_public($this->data['match']['startTime']); 
		//$this->data['match']['endTime'] = $this->datetime_to_public($this->data['match']['endTime']); 

		$this->view('match',"match",$this->data['match']['name']." | Match",$this->data);
	}
	public function matches()
	{
		$this->view('matches',"matches","Matches",$this->data);
	}
	public function calendar()
	{
		// If stuff has been submitted via the form...
		$viewSelection 			= $this->input->post('viewSelection');
		$sportSelection 		= $this->input->post('sportSelection');
		$tournamentSelection 	= $this->input->post('tournamentSelection');
		$venueSelection 		= $this->input->post('venueSelection');

		// fall back values in case form was not loaded.
		if(!$viewSelection) 		$viewSelection 			= "all";
		if(!$sportSelection) 		$sportSelection 		= "all";
		if(!$tournamentSelection) 	$tournamentSelection 	= "all";
		if(!$venueSelection) 		$venueSelection 		= "all";

		$viewOptions['all'] = "All Events";
		$sportOptions['all'] = "All";
		$tournamentOptions['all'] = "All";
		$venueOptions['all'] = "All";

		$sports = $this->sports_model->get_all();
		$tournaments = $this->tournaments_model->get_all();
		$venues = $this->venues_model->get_all();

		foreach($sports as $sport){
			$sportOptions[$sport['sportCategoryData']['name']][$sport['sportID']] = $sport['name'];
		}
		foreach($tournaments as $tournament) {
			$start = new DateTime($tournament['tournamentStart']);
			$year = $start->format('Y');
			$tournamentOptions[$year][$tournament['tournamentID']] = $tournament['name'];
		}
		foreach($venues as $venue) $venueOptions[$venue['venueID']] = $venue['name'];

		$viewOptions = array(
			'all'  => 'All Events',	
			'tournaments'    => 'Tournament Events'
		);

		$this->data['viewOptions'] = $viewOptions;
		$this->data['viewSelection'] = $viewSelection;
		$this->data['sportOptions'] = $sportOptions;
		$this->data['sportSelection'] = $sportSelection;
		$this->data['tournamentOptions'] = $tournamentOptions;
		$this->data['tournamentSelection'] = $tournamentSelection;
		$this->data['venueOptions'] = $venueOptions;
		$this->data['venueSelection'] = $venueSelection;

		$this->view('calendar',"calendar","Calendar",$this->data);
	}
	public function groups()
	{
		$this->data['groups'] = $this->ion_auth->groups()->result();
		$this->view('groups',"groups","Groups",$this->data);
	}
	public function group($groupID)
	{
		$group = $this->groups_model->get($groupID);
		$this->data['group'] = $group;
		$this->view('group',"group",$group['name']." | group",$this->data);
	}
	public function fixGroups($groupID) {
		$users = $this->users_model->get_all();
		$counter = 0;
		foreach($users as $user) {
			if($user['groups']===FALSE) {
				if($this->db->insert('usersGroups', array('groupID'=>$groupID, 'userID'=>$user['userID']) )) {
					$counter++;
				} else { 
					$this->flash_redirect("message_error","/tms/groups","Adding userID {$user['userID']} to group $groupID failed");
				}
			}
		}
		$this->flash_redirect("message_success","/tms/group/$groupID","Successfully added $counter orphaned users to group");
	}
	public function users()
	{	

		$users = $this->users_model->get_all();
		$this->data['users'] = $users;
		
		$this->view('users',"users","Users",$this->data);
	}
	public function user($userID)
	{
		$userDetailsForm = array(
			array(
				'name'=>'firstName',
				'label'=>'First Name',
				'restrict'=>'required|xss_clean',
				'type'=>'text'
			),
			array(
				'name'=>'lastName',
				'label'=>'Last Name',
				'restrict'=>'required|xss_clean',
				'type'=>'text'
			),
			array(
				'name'=>'phone',
				'label'=>'Phone',
				'restrict'=>'xss_clean',
				'type'=>'text'
			),
			array(
				'name'=>'address',
				'label'=>'Address',
				'restrict'=>'xss_clean',
				'type'=>'text'
			),
			array(
				'name'=>'aboutMe',
				'label'=>'Bio',
				'restrict'=>'xss_clean',
				'type'=>'text'
			)
		);
		$emergencyDetailsForm = array(
			array(
				'name'=>'emergencyName',
				'label'=>'Name',
				'restrict'=>'required|xss_clean',
				'type'=>'text'
			),
			array(
				'name'=>'emergencyEmail',
				'label'=>'Email',
				'restrict'=>'required|valid_email',
				'type'=>'text'
			),
			array(
				'name'=>'emergencyPhone',
				'label'=>'Phone',
				'restrict'=>'required|xss_clean',
				'type'=>'text'
			),
			array(
				'name'=>'emergencyAddress',
				'label'=>'Address',
				'restrict'=>'required|xss_clean',
				'type'=>'text'
			)
		);
		// Does the match even exist?
		$this->data['userID'] = $userID;
		$this->data['user'] = $user = $this->users_model->get($userID);
		if($user===FALSE) {
			$this->session->set_flashdata('message_error',  "User ID $userID does not exist.");
			redirect("/tms/users", 'refresh');
		}
		// Get all information about this user
		$this->data['user']['teamIDs'] = array();
		$this->data['user']['team']    = array();
		
		$this->data['user']['teamIDs'] = $this->users_model->team_memberships($userID);
		foreach($this->data['user']['teamIDs'] as $teamID) {
			$this->data['user']['team'][] = $this->teams_model->get($teamID);
		}

		// We validate the data from the form
		$newdata = $_POST;
		// For each of the input types we will validate it.
		$submitValue = $this->input->post('submit');
		if($submitValue == 'Update User'){
			foreach($userDetailsForm as $input){
				$this->form_validation->set_rules($input['name'], $input['label'], $input['restrict']);
			}
		} else if ($submitValue == 'Update Emergency Contact'){
			foreach($emergencyDetailsForm as $input){
				$this->form_validation->set_rules($input['name'], $input['label'], $input['restrict']);
			}
		}
		if ($submitValue!=FALSE && $this->form_validation->run() == true) {
			if($this->users_model->update($userID, $newdata)) {
				// Successful update, show success message
				$this->session->set_flashdata('message_success',  'Successfully updated user.');
			} else {
				$this->session->set_flashdata('message_error',  'Failed to update user. Please contact Infusion Systems.');
			}
			redirect("/tms/user/$userID", 'refresh');
		}

		foreach(array($userDetailsForm, $emergencyDetailsForm) as $form){
			foreach($form as $input){
				if(array_key_exists('type',$input)){
					$this->data[$input['name']] = array(
						'name'  => $input['name'],
						'id'    => $input['name'],
						'type'  => $input['type'],
						'value' => $this->form_validation->set_value($input['type'], (isset($user[$input['name']]) ? $user[$input['name']] : ''))
					);
					if($input['name']=="description"){
						$this->data[$input['name']]['style'] = 'width:100%;';
						$this->data[$input['name']]['rows'] = '5';
					}
				}
			}
		}
		$this->view('user',"user",$user['firstName']." ".$user['lastName']." | User",$this->data);
	}
	public function teams()
	{	

		$teams = $this->teams_model->get_all();
		$this->data['teams'] = $teams;
		
		$this->view('teams',"teams","Teams",$this->data);
	}
	public function team($teamID)
	{
		$teamDetailsForm = array(
			array(
				'name'=>'name',
				'label'=>'Name',
				'restrict'=>'required|xss_clean',
				'type'=>'text'
			),
			array(
				'name'=>'associationNumber',
				'label'=>'Association Number',
				'restrict'=>'xss_clean',
				'type'=>'text'
			),
			array(
				'name'=>'description',
				'label'=>'Description',
				'restrict'=>'required|xss_clean',
				'type'=>'text'
			)
		);
		// Does the match even exist?
		$this->data['teamID'] = $teamID;
		$this->data['team'] = $team = $this->teams_model->get($teamID);
		if($team===FALSE) {
			$this->session->set_flashdata('message_error',  "Team ID $teamID does not exist.");
			redirect("/tms/teams", 'refresh');
		}

		// We validate the data from the form
		$newdata = $_POST;
		// For each of the input types we will validate it.
		foreach($teamDetailsForm as $input){
			$this->form_validation->set_rules($input['name'], $input['label'], $input['restrict']);
		}
		if ($this->form_validation->run() == true) {
			if($this->teams_model->update($teamID, $newdata)) {
				// Successful update, show success message
				$this->session->set_flashdata('message_success',  'Successfully updated team.');
			} else {
				$this->session->set_flashdata('message_error',  'Failed to update team. Please contact Infusion Systems.');
			}
			redirect("/tms/team/$teamID", 'refresh');
		}

		foreach($teamDetailsForm as $input){
			if(array_key_exists('type',$input)){
				$this->data[$input['name']] = array(
					'name'  => $input['name'],
					'id'    => $input['name'],
					'type'  => $input['type'],
					'value' => $this->form_validation->set_value($input['type'], (isset($team[$input['name']]) ? $team[$input['name']] : ''))
				);
				if($input['name']=="description"){
					$this->data[$input['name']]['style'] = 'width:100%;';
					$this->data[$input['name']]['rows'] = '5';
				}
			}
		}
		$this->data['team'] = $team;
		$this->view('team',"team",$team['name']." | Team",$this->data);
	}
	public function announcements()
	{

		$announcements = $this->announcements_model->get_all();
		$this->data['announcements'] = $announcements;

		$this->view('announcements',"announcements","Announcements",$this->data);
	}
	public function announcement($announcementID)
	{

		$announcement = $this->announcements_model->get($announcementID);
		$this->data['announcement'] = $announcement;

		$this->view('annoucement',"annoucement",$announcement['title']." | Announcement",$this->data);
	}
	public function reports()
	{
		$this->view('reports',"reports","Reports",$this->data);
	}
	public function playground() {
		$this->view('playground',"playground","Branding Playground",$this->data);
	}
	public function settings()
	{
		
		$weekdaysShort = array('mon','tue','wed','thu','fri','sat','sun');

		for($i=0;$i<7;$i++)
		{
			$this->form_validation->set_rules($weekdaysShort[$i].'OpenTime', $weekdaysShort[$i].'day Open Time', 'required|xss_clean');
			$this->form_validation->set_rules($weekdaysShort[$i].'CloseTime', $weekdaysShort[$i].'day Close Time', 'required|xss_clean');
		}
		
		if ($this->form_validation->run() == true) {
			$newdata = array(
				
			);
			// If checkbox is unticked, it returns no value - this means FALSE
			for($i=0;$i<7;$i++)
				if(!isset($newdata[$weekdaysShort[$i].'Open'])) $newdata[$weekdaysShort[$i].'Open'] = 0;
			
			if($this->centre_model->update($this->data['centre']['centreID'],$newdata ) ) {
				// Successful update, show success message
				$this->session->set_flashdata('message_success',  'Successfully Updated');
			} else {
				$this->session->set_flashdata('message_error',  'Failed. Please contact Infusion Systems.');
			}
			redirect("/tms/settings", 'refresh');
		} else {
			//display the create user form
			
			for($i=0;$i<7;$i++){
				$this->data[$weekdaysShort[$i].'Open'] = array(
					'name'  => $weekdaysShort[$i].'Open',
					'id'    => $weekdaysShort[$i].'Open',
					'type'  => 'checkbox',
					'value' => '1',
					($this->data['centre'][$weekdaysShort[$i].'Open'] ? 'checked' : 'notchecked') => 'checked'
				);
				$this->data[$weekdaysShort[$i].'OpenTime'] = array(
					'name'  => $weekdaysShort[$i].'OpenTime',
					'id'    => $weekdaysShort[$i].'OpenTime',
					'type'  => 'text',
					'class'  => 'time',
					'value' => $this->form_validation->set_value($weekdaysShort[$i].'OpenTime',(isset($this->data['centre'][$weekdaysShort[$i].'OpenTime']) ? $this->data['centre'][$weekdaysShort[$i].'OpenTime'] : '') )
				);
				$this->data[$weekdaysShort[$i].'CloseTime'] = array(
					'name'  => $weekdaysShort[$i].'CloseTime',
					'id'    => $weekdaysShort[$i].'CloseTime',
					'type'  => 'text',
					'class'  => 'time',
					'value' => $this->form_validation->set_value($weekdaysShort[$i].'CloseTime',(isset($this->data['centre'][$weekdaysShort[$i].'CloseTime']) ? $this->data['centre'][$weekdaysShort[$i].'CloseTime'] : '') )
				);
			}

			$this->view('settings',"settings","Centre Settings",$this->data);
		}
	}

	public function appearance()
	{		
		$this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
		$this->form_validation->set_rules('shortName', 'Short Name', 'required|xss_clean');
		$this->form_validation->set_rules('address', 'Address', 'required|xss_clean');
		$this->form_validation->set_rules('headerColour', 'Header Colour', 'required|xss_clean');
		$this->form_validation->set_rules('backgroundColour', 'Background Colour', 'required|xss_clean');
		$this->form_validation->set_rules('footerText', 'Footer Text', 'required|xss_clean');
		
		if ($this->form_validation->run() == true) {
			$newdata = $_POST;
			
			if($this->centre_model->update($newdata)) {
				// Successful update, show success message
				$this->session->set_flashdata('message_success',  'Successfully Updated');
			} else {
				$this->session->set_flashdata('message_error',  'Failed. Please contact Infusion Systems.');
			}
			redirect("/tms/appearance", 'refresh');
		} else {
			//display the create user form
			
			$this->data['name'] = array(
				'name'  => 'name',
				'id'    => 'name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('name',(isset($this->data['centre']['name']) ? $this->data['centre']['name'] : '') )
			);
			$this->data['shortName'] = array(
				'name'  => 'shortName',
				'id'    => 'shortName',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('shortName',(isset($this->data['centre']['shortName']) ? $this->data['centre']['shortName'] : '') )
			);
			$this->data['address'] = array(
				'name'  => 'address',
				'id'    => 'address',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('address',(isset($this->data['centre']['address']) ? $this->data['centre']['address'] : '') )
			);
			$this->data['footerText'] = array(
				'name'  => 'footerText',
				'id'    => 'footerText',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('footerText',(isset($this->data['centre']['footerText']) ? $this->data['centre']['footerText'] : '') )
			);
			$this->data['headerColour'] = array(
				'name'  => 'headerColour',
				'id'    => 'headerColour',
				'type'  => 'text',
				'style' => 'background-color: #'.(isset($this->data['centre']['headerColour']) ? $this->data['centre']['headerColour'] : 'FFFFFF'),
				'class' => 'color',
				'value' => $this->form_validation->set_value('headerColour',(isset($this->data['centre']['headerColour']) ? $this->data['centre']['headerColour'] : '') )
			);
			$this->data['backgroundColour'] = array(
				'name'  => 'backgroundColour',
				'id'    => 'backgroundColour',
				'type'  => 'text',
				'style' => 'background-color: #'.(isset($this->data['centre']['backgroundColour']) ? $this->data['centre']['backgroundColour'] : 'FFFFFF'),
				'class' => 'color',
				'value' => $this->form_validation->set_value('backgroundColour',(isset($this->data['centre']['backgroundColour']) ? $this->data['centre']['backgroundColour'] : '') )
			);
			$this->view('appearance',"appearance","Apprearance",$this->data);
		}
	}

	// Callback function for form validation - checks sanity and validity of POST date strings
	public function datetime_check($strDateTime,$field) {
		try {
			// If date string is invalid, this should throw an exception. We're only calling it endDate because of the checking of date ranges 
			$endDate = new DateTime($strDateTime);
			// If the field has "end" at the start, we're assuming there's a corresponding "start" field.
			if(substr($field, 0, 3)=="end") {
				$endDateField = $field;
				$startDateField = "start".substr($field, 3);
				// Create a new DateTime object from the start date string, or today's date if there is no start string
				$startDate = ( ($this->input->post($startDateField)===FALSE) ? new DateTime() : new DateTime($this->input->post($startDateField)) );
				// If start datetime is equal to or after end datetime 
				if( $startDate >= $endDate ) {
					if($this->input->post($startDateField)) {
						$error = "Date '$startDateField': ".$this->datetime_to_public($startDate)." is not before end date: ".$this->datetime_to_public($endDate);
					} else {
						$error = "Date '$endDateField': ".$this->datetime_to_public($endDate)." is before current time: ".$this->datetime_to_public($startDate);
					}						
					$this->form_validation->set_message('datetime_check', "Invalid date range specified: $error");
					return FALSE;
				}
			}
			// If the field has "End" at the end, we're assuming there's a corresponding "Start" field. 
			if(substr($field, -3)=="End") {
				$endDateField = $field;
				$startDateField = substr($field, 0, -3)."Start";
				// Create a new DateTime object from the start date string, or today's date if there is no start string
				$startDate = ( ($this->input->post($startDateField)===FALSE) ? new DateTime() : new DateTime($this->input->post($startDateField)) );
				// If start datetime is equal to or after end datetime 
				if( $startDate >= $endDate ) {
					if($this->input->post($startDateField)) {
						$error = "Date '$startDateField': ".$this->datetime_to_public($startDate)." is not before end date: ".$this->datetime_to_public($endDate);
					} else {
						$error = "Date '$endDateField': ".$this->datetime_to_public($endDate)." is before current time: ".$this->datetime_to_public($startDate);
					}						
					$this->form_validation->set_message('datetime_check', "Invalid date range specified: $error");
					return FALSE;
				}
			}
			// SPECIFIC CASE: tournament creation | If we have a registration end date and a tournament start date, check tournament is starting after registration period
			if( $field=="registrationEnd" && ($this->input->post("tournamentStart")!==FALSE) ) {
				$tournamentStart = new DateTime($this->input->post("tournamentStart"));
				$registrationEnd = $endDate;
				if( $tournamentStart < $registrationEnd ) {
					$this->form_validation->set_message('datetime_check', "Tournament must start after registration period has ended. Please correct the tournament start date.");
					return FALSE;
				}
			}
			// Sanity checks passed, assume valid date
			return TRUE;	
		} catch (Exception $e) {
			$this->form_validation->set_message('datetime_check', 'The %s field must contain a valid date in the ISO 8601 format: YYYY-MM-DDThh:mm:ssTZD (e.g. 1997-07-16T19:20:30+0100) Provided: '.var_export($strDateTime,1).' Debug Exception: '.$e->getMessage() );
			return FALSE;
		}
	}
	public function startTimes_check($startTimes){
		foreach($startTimes as $time) {
			if(!preg_match("/(2[0-3]|[01][0-9]):[0-5][0-9]/", $time)){
				$this->form_validation->set_message('datetime_check', 'The %s field must contain a valid time of day in the format: hh:mm (e.g. 19:20) Provided: '.var_export($time,1) );
				return FALSE;
			}
		}
		return TRUE;
	}
}
