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
			
			$matches[$key]['date'] = date("F jS, Y",$match['startTime']);
			
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
	
	public function signup($tournamentID)
	{
		if(!empty($_POST) ) {
			print_r($_POST); die();
		}
		$this->load->model('tournaments_model');
		$this->load->model('sports_model');
		
		if( $this->tournaments_model->tournament_exists($tournamentID) ) {
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
	
	public function info()
	{
		// Page title
		$this->data['title'] = "About Us";
		$this->data['page'] = "info";
		$this->load->view('sis/header',$this->data);
		$this->load->view('sis/info',$this->data);
		$this->load->view('sis/footer',$this->data);
	}
	public function help()
	{
		// Page title
		$this->data['title'] = "Help";
		$this->data['page'] = "help";
		$this->load->view('sis/header',$this->data);
		$this->load->view('sis/help',$this->data);
		$this->load->view('sis/footer',$this->data);
	}

}