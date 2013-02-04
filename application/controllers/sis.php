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
		$this->load->view('sis/header',$this->data);
		$this->load->view('sis/matches',$this->data);
		$this->load->view('sis/footer',$this->data);
	}

	public function match($matchID)
	{

		/* We want to get:
			- match name
			- which game is it part of?
			- which tournament is it part of?
			- Where is it?
			- The results of this match?
			- When does the match begin
			- when long is the match?
			- who is playing in this match
			- what type of sport is this first of all?
		*/
		$this->load->library('table');
		// Page title
		$this->data['title'] = "$matchID value";
		$this->data['page'] = "match";
		$this->data['matchID'] = $matchID;

		$this->load->view('sis/header',$this->data);
		$this->load->view('sis/match',$this->data);
		$this->load->view('sis/footer',$this->data);
	}

	public function game($gameID)
	{

		/* We want to get:
			- match name
			- which game is it part of?
			- which tournament is it part of?
			- Where is it?
			- The results of this match?
			- When does the match begin
			- when long is the match?
			- who is playing in this match
			- what type of sport is this first of all?
		*/
		$this->load->library('table');
		// Page title
		$this->data['title'] = "$gameID value";
		$this->data['page'] = "game";
		$this->data['gameID'] = $gameID;

		$this->load->view('sis/header',$this->data);
		$this->load->view('sis/game',$this->data);
		$this->load->view('sis/footer',$this->data);
	}

	public function tournaments()
	{

		/* We want to get:
			- List of all the tournaments
				- tournament name
				- tournament start date (to get the year)
				- tournament description?
		*/
		
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
			$this->data['tournament'] = $tournament;
			$sport = $this->sports_model->get_sport( $tournament['sportID'] );
			
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
	
	public function signup()
	{
		$this->load->model('tournaments_model');
		$this->load->model('sports_model');
		
		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		
		$this->data['tournaments'] = $this->tournaments_model->get_tournaments($this->data['centre']['centreID']);
		
		$this->data['title'] = "Signup";
		$this->data['page'] = "signup";
		$this->load->view('sis/header',$this->data);
		$this->load->view('sis/signup',$this->data);
		$this->load->view('sis/footer',$this->data);
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