<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sis extends MY_Controller {

	function __construct()
	{
		parent::__construct();

		$this->data['currentUser'] = $currentUser = $this->users_model->get_logged_in();
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
		$this->load->view('sis/header',$data);
		$this->load->view('sis/'.$view,$data);
		$this->load->view('sis/footer',$data);
	}

	public function index() {
		
		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		$this->view('home','sishome','Home',$this->data);
	}

	public function calendar()
	{
		$this->view('calendar','calendar','Calendar',$this->data);
	}

	public function matches() {			
		$matches = $this->matches_model->get_all();
		foreach($matches as $key => $match) {
			$matches[$key]['date'] = datetime_to_public_date($match['startTime']);
			$matches[$key]['startTime'] = datetime_to_public_time($match['startTime']);
			$matches[$key]['endTime'] = datetime_to_public_time($match['endTime']);
		}
		$this->data['matches'] = $matches;

		$this->view('matches','matches','Matches',$this->data);
	} 

	public function match($matchID)
	{
		$this->load->library('table');
		

		
		$match = $this->matches_model->get($matchID);
		if($match==FALSE) {
			$this->session->set_flashdata('message',  "Match ID $id does not exist.");
			redirect("/sis/matches", 'refresh');
		}
		
		$match['tournamentData']['name'] = ($match['tournamentData'] ? $match['tournamentData']['name'] : "None");
		$match['date'] = datetime_to_public_date($match['startTime']);
		$match['startTime'] = datetime_to_public_time($match['startTime']);
		$match['endTime'] = datetime_to_public_time($match['endTime']);
		
		$this->data['match'] = $match;
		
		$this->data['matchTable'] = array(
			array('<span class="bold">Name:</span>',$match['name']),
			array('<span class="bold">Description:</span>',$match['description']),
			array('<span class="bold">Sport:</span>',$match['sportData']['name']),
			array('<span class="bold">Venue:</span>',$match['venueData']['name']),
			array('<span class="bold">Tournament:</span>',$match['tournamentData']['name']),
			array('<span class="bold">Date:</span>',		$match['date']),
			array('<span class="bold">Start Time:</span>',	$match['startTime']),
			array('<span class="bold">End Time:</span>',	$match['endTime'])
		);
		$this->view('match','match',$match['name'].' | Match',$this->data);
	}

	public function tournaments()
	{	

		$this->data['tournaments'] = $this->tournaments_model->get_all();
		
		$this->view('tournaments','tournaments','Tournaments',$this->data);
	}

	public function tournament($tournamentID)
	{
		$this->load->library('table');

		
		$tournament = $this->tournaments_model->get($tournamentID);
		if($tournament==FALSE) {
			$this->session->set_flashdata('message',  "Tournament ID $id does not exist.");
			redirect("/sis/tournaments", 'refresh');
		}
		
		$this->data['tournament'] = $tournament;
		
		$this->data['tournamentTable'] = array(
			array('<span class="bold">Name:</span>',$tournament['name']),
			array('<span class="bold">Description:</span>',$tournament['description']),
			array('<span class="bold">Sport:</span>',$tournament['sportData']['name']),
			array('<span class="bold">Start Date:</span>',$tournament['tournamentStart']),
			array('<span class="bold">End Date:</span>',$tournament['tournamentEnd']),
		);
		
		$this->view('tournament','tournament',$tournament['name'].' | Tournament',$this->data);
	}
	public function ticketsinfo()
	{
		$this->view('ticketsinfo','ticketsinfo','Tickets',$this->data);
	}
	public function account()
	{
		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		$this->view('account','account','Account',$this->data);
	}
	
	// sign up for tournament
	public function signup($tournamentID)
	{
		if( !$this->ion_auth->logged_in() ){
			$this->session->set_flashdata('message_warning',  "You must be logged in to sign up for a tournament: Please log in below:");
			redirect('/auth/login','refresh'); 
		}
		
		$this->data['tournament'] = $tournament = $this->tournaments_model->get($tournamentID);
		if($tournament==FALSE) {
			$this->session->set_flashdata('message',  "Tournament ID $tournamentID does not exist.");
			redirect("/sis/tournaments", 'refresh');
		}
		
		// Get all role info, includng all sections and descendent inputs
		$this->data['roles'] = $roles = $this->sports_model->get_sport_category_roles($tournament['sportData']['sportCategoryID']);

		if( $this->input->post() ) {
			var_dump($_POST); die();
			$roleID = $this->input->post('role');
			$roleInputs = $this->sports_model->get_sport_category_role_inputs($roleID);
			
			// Loop through each input and handle it
			foreach($roleInputs as $key => $roleInput) {
				// Skip these inputs, they are processed by the addTeamMember method
				if(strpos($roleInput['inputType'],'tm-') === 0) unset($roleInputs[$key]);
				if($roleInput['inputType']=='teamMembers') {
					$teamMembersIDs = array_map("intval", explode(",", $this->input->post('teamMemberIDs') ));
				}
			}
			
			$this->session->set_flashdata('message',  "Signup successful!");
			redirect("/sis/tournaments", 'refresh');
		} else {
			$this->view('signup','signup','Signup',$this->data);
		}
	}
	
	
	//create a new team member user account
	function addTeamMember($tournamentID,$sectionID)
	{
		$this->data['tournamentID'] = $tournamentID;
		$this->data['sectionID'] = $sectionID;
		
		$this->data['tournament'] = $tournament = $this->tournaments_model->get($tournamentID);
		$sectionInputs = $this->sports_model->get_sport_category_role_input_section_inputs($sectionID);
		$teamMemberInputs = array(); 
		foreach($sectionInputs as $inputID => $input) {
			if(strpos($input['inputType'],'tm-') === 0) {
				$input['inputType'] = substr($input['inputType'],3);
				$teamMemberInputs[] = $input;
			}
		}
		
		// Set up form validation rules for any input type
		foreach($teamMemberInputs as $tminput) {
			switch($tminput['inputType']) {
				case "phone":
					$this->form_validation->set_rules($tminput['objectName'].':'.$tminput['tableKeyName'], $tminput['formLabel'], 'required|xss_clean|min_length[8]|max_length[13]');
				break;
				case "email":
					$this->form_validation->set_rules($tminput['objectName'].':'.$tminput['tableKeyName'], $tminput['formLabel'], 'required|valid_email');
				break;
				default: 
					$this->form_validation->set_rules($tminput['objectName'].':'.$tminput['tableKeyName'], $tminput['formLabel'], 'required|xss_clean');
			}
		}
		
		// Set up validation for standard inputs
		$this->form_validation->set_rules('first_name', 'First Name', 'required|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required|xss_clean');
		$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
		$this->form_validation->set_rules('phone', 'Phone', 'required|xss_clean|min_length[8]|max_length[13]');
		
		// This variable will contain ID of newly created user if this function succeeds
		$newUserID = false;
		$updateUserResponse = false;
		
		// Set up input data
		if ( $this->form_validation->run() ) {
			$username = $email = $this->input->post('email');
			$centreID = $this->data['centre']['centreID'];
			$userIDtoUpdate = $this->input->post('updateUser');

			$additional_data = array(
				'centreID' => $centreID,
				'firstName' => $this->input->post('first_name'),
				'lastName'  => $this->input->post('last_name'),
				'phone'      => $this->input->post('phone'),
				'address'      => $this->input->post('address')
			);
				
			// Grab input data for dynamic inputs
			foreach($teamMemberInputs as $tminput) {
				$additional_data[$tminput['objectName'].':'.$tminput['tableKeyName']] = $this->input->post($tminput['objectName'].':'.$tminput['tableKeyName']);
			}
			
			if( $userIDtoUpdate ) {
				$updateUserResponse = $this->users_model->update($userIDtoUpdate,$additional_data);
				$this->data['user'] = $additional_data;
				$this->data['user']['id'] = $userIDtoUpdate;
				$this->data['user']['email'] = $email;
				$this->data['user']['password'] = "[user specified]";
			} else {
				$password = generatePassword();
				$newUserID = $this->ion_auth->register($username, $password, $email, $additional_data);
				$this->data['user'] = $additional_data;
				$this->data['user']['id'] = $newUserID;
				$this->data['user']['email'] = $email;
				$this->data['user']['password'] = $password;
			}
		}
		
		// Registration success
		if ($newUserID != false) {
			// Successful team member creation, show success message
			$this->data['success'] = $this->ion_auth->messages();
			$this->data['updateUser'] = false;
			$this->load->view('sis/addTeamMember',$this->data);
		} elseif ($updateUserResponse != false) {
			// Successful team member creation, show success message
			$this->data['success'] = "Updated user: ".$updateUserResponse;
			$this->data['updateUser'] = false;
			$this->load->view('sis/addTeamMember',$this->data);
		} else {
			//display the add team member form
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['first_name'] = array(
				'name'  => 'first_name',
				'id'    => 'first_name',
				'type'  => 'text',
				'required' => '',
				'value' => $this->form_validation->set_value('first_name'),
			);
			$this->data['last_name'] = array(
				'name'  => 'last_name',
				'id'    => 'last_name',
				'type'  => 'text',
				'required' => '',
				'value' => $this->form_validation->set_value('last_name'),
			);
			$this->data['email'] = array(
				'name'  => 'email',
				'id'    => 'email',
				'type'  => 'email',
				'required' => '',
				'value' => $this->form_validation->set_value('email'),
			);
			$this->data['phone'] = array(
				'name'  => 'phone',
				'id'    => 'phone',
				'type'  => 'tel',
				'required' => '',
				'value' => $this->form_validation->set_value('phone'),
			);
			
			// Add extra inputs as required by sport category
			foreach($teamMemberInputs as $tminput) {				
				switch($tminput['inputType']) {
					case "phone": $type = 'tel'; break;
					default: $type = $tminput['inputType'];
				}
			
				$this->data['extraInputs'][ $tminput['objectName'].':'.$tminput['tableKeyName'] ] = array(
					'name'  => $tminput['objectName'].':'.$tminput['tableKeyName'],
					'id'    => $tminput['objectName'].':'.$tminput['tableKeyName'],
					'type'  => $type,
					'required' => '',
					'inputType'  => $tminput['inputType'],
					'formLabel'  => $tminput['formLabel'],
					'value' => $this->form_validation->set_value($tminput['objectName'].':'.$tminput['tableKeyName']),
				);
			}

			$this->data['updateUser'] = $newUserID;
			$this->load->view('sis/addTeamMember',$this->data);
		}
	}	
	
	//create a new team member user account
	function addLoginTeamMember($tournamentID,$sectionID)
	{	



		$this->data['tournamentID'] = $tournamentID;
		$this->data['sectionID'] = $sectionID;
		
		$this->data['tournament'] = $tournament = $this->tournaments_model->get($tournamentID);
		$sectionInputs = $this->sports_model->get_sport_category_role_input_section_inputs($sectionID);
		$teamMemberInputs = array(); 
		foreach($sectionInputs as $inputID => $input) {
			if(strpos($input['inputType'],'tm-') === 0) {
				$input['inputType'] = substr($input['inputType'],3);
				$teamMemberInputs[] = $input;
			}
		}
		
		//validate form input
		$this->form_validation->set_rules('identity', 'Identity', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		if ($this->form_validation->run() == true) {
			$userID = $this->ion_auth->account_check($this->input->post('identity'), $this->input->post('password'));
			if ( $userID !== false ) {
				// log in details valid, get user data
				$user = $this->users_model->get($userID);
				$this->data['first_name'] = array(
					'name'  => 'first_name',
					'id'    => 'first_name',
					'type'  => 'text',
					'required' => '',
					'value' => (isset($user['firstName']) ? $user['firstName'] : '')
				);
				$this->data['last_name'] = array(
					'name'  => 'last_name',
					'id'    => 'last_name',
					'type'  => 'text',
					'required' => '',
					'value' => (isset($user['lastName']) ? $user['lastName'] : '')
				);
				$this->data['email'] = array(
					'name'  => 'email',
					'id'    => 'email',
					'type'  => 'email',
					'required' => '',
					'value' => $this->input->post('identity')
				);
				$this->data['phone'] = array(
					'name'  => 'phone',
					'id'    => 'phone',
					'type'  => 'tel',
					'required' => '',
					'value' => (isset($user['phone']) ? $user['phone'] : '')
				);
								
				// Add extra inputs as required by sport category
				foreach($teamMemberInputs as $tminput) {
					switch($tminput['inputType']) {
						case "phone": $type = 'tel'; break;
						default: $type = $tminput['inputType'];
					}
				
					$this->data['extraInputs'][ $tminput['objectName'].':'.$tminput['tableKeyName'] ] = array(
						'name'  => $tminput['objectName'].':'.$tminput['tableKeyName'],
						'id'    => $tminput['objectName'].':'.$tminput['tableKeyName'],
						'type'  => $type,
						'required' => '',
						'inputType'  => $tminput['inputType'],
						'formLabel'  => $tminput['formLabel'],
						'value' => (isset($user[$tminput['objectName'].':'.$tminput['tableKeyName']]) ? $user[$tminput['objectName'].':'.$tminput['tableKeyName']] : '')
					);
				}
				
				$this->data['updateUser'] = $userID;
				
				$this->load->view('sis/addTeamMember', $this->data);
			} else {
				// Do the equivalent of redirecting, but from within a fancyform
				$this->session->set_flashdata('message_error','Incorrect login details, please try again!');
				$this->data['data'] = "<script type='text/javascript'>
					$('a.addLoginTeamMember').click();
				</script>";
				$this->load->view('data',$this->data);
			}
		} else {
			//the user is not logging in so display the login page
			$this->data['message'] = $this->session->flashdata('message');
			$this->data['message_information'] = $this->session->flashdata('message_information');
			$this->data['message_success'] = $this->session->flashdata('message_success');
			$this->data['message_warning'] = $this->session->flashdata('message_warning');
			$this->data['message_error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message_error');
			
			$this->data['identity'] = array('name' => 'identity',
				'id' => 'identity',
				'type' => 'text'
			);
			$this->data['password'] = array('name' => 'password',
				'id' => 'password',
				'type' => 'password'
			);

			$this->load->view('sis/teamMemberLogin', $this->data);
		}
	}
	
	public function info() {
		$this->view('info','info','About Us',$this->data);
	}
	public function help() {
		$this->view('help','help','Help',$this->data);
	}
	public function playground() {
		$this->view('playground','playground','Branding Playground',$this->data);
	}
}
?>