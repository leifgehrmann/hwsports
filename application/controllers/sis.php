<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sis extends MY_Controller {

	public function index() {
		// Page title
		$this->data['title'] = "Home";
		$this->data['page'] = "sishome";
		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		
		$this->data['currentUser'] = $currentUser = $this->ion_auth->user()->row();
		if(!empty($currentUser)) {
			$query = $this->db->query("SELECT `key`,`value` FROM `userData` WHERE `userID` = '{$currentUser->id}'");
			foreach($query->result_array() as $userDataRow) {
				$currentUser->$userDataRow['key'] = $userDataRow['value'];
			}
		}
		
		$this->load->view('sis/header',$this->data);
		$this->load->view('sis/home',$this->data);
		$this->load->view('sis/footer',$this->data);
	}

	public function calendar()
	{
		// Page title
		$this->data['title'] = "Calendar";
		$this->data['page'] = "calendar";
		$this->load->view('sis/header',$this->data);
		$this->load->view('sis/calendar',$this->data);
		$this->load->view('sis/footer',$this->data);
	}

	public function matches()
	{
		// Page title
		$this->data['title'] = "Matches";
		$this->data['page'] = "matches";
				
		$this->load->model('tournaments_model');
		$this->load->model('sports_model');
		$this->load->model('matches_model');
		$this->load->model('venues_model');
		
		$matches = $this->matches_model->get_matches($this->data['centre']['centreID']);
		foreach($matches as $key => $match) {
			$sport = $this->sports_model->get_sport( $match['sportID'] );
			$matches[$key]['sport'] = $sport['name'];
			
			$venue = $this->venues_model->get_venue( $match['venueID'] );
			$matches[$key]['venue'] = $venue['name'];
			
			if($this->tournaments_model->tournament_exists( $match['tournamentID'] )) {
				$tournament = $this->tournaments_model->get_tournament( $match['tournamentID'] );
				$matches[$key]['tournament'] = $tournament['name'];
			} else {
				$matches[$key]['tournament'] = "None";
			}
			
			$matches[$key]['date'] = date("Y/m/d",$match['startTime']);
			
			$matches[$key]['startTime'] = date("H:i",$match['startTime']);
			$matches[$key]['endTime'] = date("H:i",$match['endTime']);
		}

		$this->data['matches'] = $matches;
		
		$this->load->view('sis/header',$this->data);
		$this->load->view('sis/matches',$this->data);
		$this->load->view('sis/footer',$this->data);
	}

	public function match($matchID)
	{
		$this->load->library('table');
		
		$this->load->model('tournaments_model');
		$this->load->model('sports_model');
		$this->load->model('venues_model');
		$this->load->model('matches_model');
		
		if( $this->matches_model->match_exists($matchID) ) {
			$match = $this->matches_model->get_match($matchID);
			
			$sport = $this->sports_model->get_sport( $match['sportID'] );
			$match['sport'] = $sport['name'];
			
			$venue = $this->venues_model->get_venue( $match['venueID'] );
			$match['venue'] = $venue['name'];
			
			if($this->tournaments_model->tournament_exists( $match['tournamentID'] )) {
				$tournament = $this->tournaments_model->get_tournament( $match['tournamentID'] );
				$match['tournament'] = $tournament['name'];
			} else {
				$match['tournament'] = "None";
			}
			
			$match['date'] = date("F jS, Y",$match['startTime']);
			$match['startTime'] = date("H:i",$match['startTime']);
			$match['endTime'] = date("H:i",$match['endTime']);
			
			$this->data['match'] = $match;
			
			$this->data['matchTable'] = array(
				array('<span class="bold">Name:</span>',$match['name']),
				array('<span class="bold">Description:</span>',$match['description']),
				array('<span class="bold">Sport:</span>',$match['sport']),
				array('<span class="bold">Venue:</span>',$match['venue']),
				array('<span class="bold">Tournament:</span>',$match['tournament']),
				array('<span class="bold">Date:</span>',$match['date']),
				array('<span class="bold">Start Time:</span>',$match['startTime']),
				array('<span class="bold">End Time:</span>',$match['endTime']),
			);
			
			$this->data['title'] = $match['name'];
			$this->data['page'] = "match";
			
			$this->load->view('sis/header',$this->data);
			$this->load->view('sis/match',$this->data);
			$this->load->view('sis/footer',$this->data);
		} else {
			$this->session->set_flashdata('message',  "Match ID $id does not exist.");
			redirect("/sis/tournaments", 'refresh');
		}
	}

	public function tournaments()
	{
		// Page title
		$this->data['title'] = "Tournaments";
		$this->data['page'] = "tournaments";
		
		$this->load->model('tournaments_model');
		
		$this->data['tournaments'] = $this->tournaments_model->get_tournaments($this->data['centre']['centreID']);
		
		$this->load->view('sis/header',$this->data);
		$this->load->view('sis/tournaments',$this->data);
		$this->load->view('sis/footer',$this->data);
	}

	public function tournament($tournamentID)
	{
		$this->load->library('table');
		$this->load->model('tournaments_model');
		$this->load->model('sports_model');
		
		if( $this->tournaments_model->tournament_exists($tournamentID) ) {
			$tournament = $this->tournaments_model->get_tournament($tournamentID);
			$this->data['tournamentID'] = $tournamentID;
			$this->data['tournament'] = $tournament;
			$sport = $this->sports_model->get_sport( $tournament['sportID'] );

			$registrationStartDate = DateTime::createFromFormat('d/m/Y', $tournament['registrationStart']);
			$registrationEndDate = DateTime::createFromFormat('d/m/Y', $tournament['registrationEnd']);
			$today = new DateTime();
			$this->data['registrationOpen'] = ( ($registrationStartDate < $today) && ($today < $registrationEndDate) );
			
			$this->data['tournamentTable'] = array(
				array('<span class="bold">Name:</span>',$tournament['name']),
				array('<span class="bold">Description:</span>',$tournament['description']),
				array('<span class="bold">Sport:</span>',$sport['name']),
				array('<span class="bold">Start Date:</span>',$tournament['tournamentStart']),
				array('<span class="bold">End Date:</span>',$tournament['tournamentEnd']),
			);
			
			// Page title
			$this->data['title'] = $tournament['name'];
			$this->data['page'] = "tournament";
			$this->load->view('sis/header',$this->data);
			$this->load->view('sis/tournament',$this->data);
			$this->load->view('sis/footer',$this->data);
		} else {
			$this->session->set_flashdata('message',  "Tournament ID $id does not exist.");
			redirect("/sis/tournaments", 'refresh');
		}
	}
	public function ticketsinfo()
	{
		// Page title
		$this->data['title'] = "Tickets";
		$this->data['page'] = "ticketsinfo";
		$this->load->view('sis/header',$this->data);
		$this->load->view('sis/ticketsinfo',$this->data);
		$this->load->view('sis/footer',$this->data);
	}
	public function account()
	{
		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		
		$this->data['currentUser'] = $currentUser = $this->ion_auth->user()->row();
		if(!empty($currentUser)) {
			$query = $this->db->query("SELECT `key`,`value` FROM `userData` WHERE `userID` = '{$currentUser->id}'");
			foreach($query->result_array() as $userDataRow) {
				$currentUser->$userDataRow['key'] = $userDataRow['value'];
			}
		}
		
		$this->data['title'] = "Account";
		$this->data['page'] = "account";
		$this->load->view('sis/header',$this->data);
		$this->load->view('sis/account',$this->data);
		$this->load->view('sis/footer',$this->data);
	}
	
	// sign up for tournament
	public function signup($tournamentID)
	{
		if( !$this->ion_auth->logged_in() ){
			$this->session->set_flashdata('message_warning',  "You must be logged in to sign up for a tournament: Please log in below:");
			redirect('/auth/login','refresh'); 
		}
	
		
		$this->load->model('tournaments_model');
		$this->load->model('sports_model');
		
		if( $this->input->post() ) {
			echo "<pre>".print_r($_POST,1)."</pre>"; die();
		}
		
		if( $this->tournaments_model->tournament_exists($tournamentID) ) {
			$this->data['tournamentID'] = $tournamentID;
			$this->data['tournament'] = $tournament = $this->tournaments_model->get_tournament($tournamentID);
			$this->data['roles'] = $this->sports_model->get_sport_category_roles($tournament['sportCategoryID']);
						
			$this->data['title'] = "Signup";
			$this->data['page'] = "signup";
			$this->load->view('sis/header',$this->data);
			$this->load->view('sis/signup',$this->data);
			$this->load->view('sis/footer',$this->data);
		} else {
			$this->session->set_flashdata('message',  "Tournament ID $id does not exist.");
			redirect("/sis/tournaments", 'refresh');
		}
	}
	
	
	//create a new team member user account
	function addTeamMember()
	{
		// Set up form validation rules 
		$this->form_validation->set_rules('first_name', 'First Name', 'required|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required|xss_clean');
		$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
		$this->form_validation->set_rules('phone', 'Phone', 'required|xss_clean|min_length[8]|max_length[13]');
		$this->form_validation->set_rules('adress', 'Address', 'required|xss_clean');
		
		$id = false;
		
		// Set up input data
		if ( $this->form_validation->run() ) {
			$username = $email = $this->input->post('email');
			$centreID = $this->data['centre']['centreID'];

			$additional_data = array(
				'centreID' => $centreID,
				'firstName' => $this->input->post('first_name'),
				'lastName'  => $this->input->post('last_name'),
				'phone'      => $this->input->post('phone'),
				'adress'      => $this->input->post('address')
			);
			
			$password = $this->generatePassword();
			
			$id = $this->ion_auth->register($username, $password, $email, $additional_data);
			$this->data['user'] = $additional_data;
			$this->data['user']['id'] = $id;
		}
		
		// Registration success
		if ($id != false) {
			// Successful team member creation, show success message
			$this->data['success'] = $this->ion_auth->messages()." Generated Password: $password";
			$this->load->view('sis/addTeamMember',$this->data);
		} else {
			//display the add team member form
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['first_name'] = array(
				'name'  => 'first_name',
				'id'    => 'first_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('first_name'),
			);
			$this->data['last_name'] = array(
				'name'  => 'last_name',
				'id'    => 'last_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('last_name'),
			);
			$this->data['email'] = array(
				'name'  => 'email',
				'id'    => 'email',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('email'),
			);
			$this->data['phone'] = array(
				'name'  => 'phone',
				'id'    => 'phone',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('phone'),
			);
			$this->data['address'] = array(
				'name'  => 'address',
				'id'    => 'address',
				'type'  => 'text',
				'col'   => '20',
				'row'   => '5',
				'value' => $this->form_validation->set_value('address'),
			);

			$this->load->view('sis/addTeamMember',$this->data);
		}
	}	
	
	public function info() {
		$this->data['title'] = "About Us";
		$this->data['page'] = "info";
		$this->load->view('sis/header',$this->data);
		$this->load->view('sis/info',$this->data);
		$this->load->view('sis/footer',$this->data);
	}
	public function help() {
		$this->data['title'] = "Help";
		$this->data['page'] = "help";
		$this->load->view('sis/header',$this->data);
		$this->load->view('sis/help',$this->data);
		$this->load->view('sis/footer',$this->data);
	}
	public function playground() {
		$this->data['title'] = "Branding Playground";
		$this->data['page'] = "playground";
		$this->load->view('sis/header',$this->data);
		$this->load->view('sis/playground',$this->data);
		$this->load->view('sis/footer',$this->data);
	}

	private function generatePassword($length = 9, $available_sets = 'lud')
	{
		$sets = array();
		if(strpos($available_sets, 'l') !== false)
			$sets[] = 'abcdefghjkmnpqrstuvwxyz';
		if(strpos($available_sets, 'u') !== false)
			$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
		if(strpos($available_sets, 'd') !== false)
			$sets[] = '23456789';
		if(strpos($available_sets, 's') !== false)
			$sets[] = '!@#$%&*?';

		$all = '';
		$password = '';
		foreach($sets as $set)
		{
			$password .= $set[array_rand(str_split($set))];
			$all .= $set;
		}

		$all = str_split($all);
		for($i = 0; $i < $length - count($sets); $i++)
			$password .= $all[array_rand($all)];

		$password = str_shuffle($password);

		return $password;
	}
}
?>