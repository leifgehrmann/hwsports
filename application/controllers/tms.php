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
			$query = $this->db->query("SELECT `key`,`value` FROM `userData` WHERE `userID` = '{$currentUser->id}'");
			foreach($query->result_array() as $userDataRow) {
				$currentUser->$userDataRow['key'] = $userDataRow['value'];
			}
		} else {
			//redirect them to the sis homepage
			redirect('/', 'refresh');
		}
	}
	public function index()
	{
		$this->data['title'] = "Home";
		$this->data['page'] = "tmshome";
		$this->load->view('tms/header',$this->data);
		$this->load->view('tms/home',$this->data);
		$this->load->view('tms/footer',$this->data);
	}
	public function tournaments()
	{
		$this->data['title'] = "Tournaments";
		$this->data['page'] = "tournaments";
		
		$this->load->model('tournaments_model');
		$this->load->model('sports_model');
		
		$this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
		$this->form_validation->set_rules('description', 'Description', 'required|xss_clean');
		$this->form_validation->set_rules('sport', 'Sport', 'required|xss_clean');
		$this->form_validation->set_rules('registrationStart', 'registrationStart', 'required|xss_clean|callback_datetime_check[registrationStart]');
		$this->form_validation->set_rules('registrationEnd', 'registrationEnd', 'required|xss_clean|callback_datetime_check[registrationEnd]');
		$this->form_validation->set_rules('tournamentStart', 'tournamentStart', 'required|xss_clean|callback_datetime_check[tournamentStart]');
		$this->form_validation->set_rules('tournamentEnd', 'tournamentEnd', 'required|xss_clean|callback_datetime_check[tournamentEnd]');
		
		// Change dates from public, timepicker-friendly format to database-friendly ISO format.
		if($this->input->post('registrationStart')) $_POST['registrationStart'] = $this->datetimestr_to_standard($this->input->post('registrationStart'));
		if($this->input->post('registrationEnd')) $_POST['registrationEnd'] = $this->datetimestr_to_standard($this->input->post('registrationEnd'));
		if($this->input->post('tournamentStart')) $_POST['tournamentStart'] = $this->datetimestr_to_standard($this->input->post('tournamentStart'));
		if($this->input->post('tournamentEnd')) $_POST['tournamentEnd'] = $this->datetimestr_to_standard($this->input->post('tournamentEnd'));
		
		if ($this->form_validation->run() == true) {
			$newdata = $_POST;
			unset($newdata['submit']);
			
			$tournamentID = $this->tournaments_model->insert_tournament($newdata);
			if($tournamentID > -1) {
				// Successful update, show success message
				$this->session->set_flashdata('message_success',  'Successfully Created Tournament.');
			} else {
				$this->session->set_flashdata('message_error',  'Failed. Please contact Infusion Systems.');
			}
			redirect("/tms/tournament/$tournamentID", 'refresh');
		} else {
			//display the create user form
			//set the flash data error message if there is one
			$this->data['message_error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message_error') );
		
			$this->data['tournaments'] = $this->tournaments_model->get_tournaments($this->data['centre']['centreID']);
		
			$this->data['sports'] = array();
			
			foreach( $this->sports_model->get_sports($this->data['centre']['centreID']) as $sport) {
				$this->data['sports'][$sport['sportCategory']['name']][$sport['sportID']] = $sport['name'];
			}
			ksort($this->data['sports']);
			
			
			$this->data['name'] = array(
				'name'  => 'name',
				'id'    => 'name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('name')
			);
			
			$this->data['description'] = array(
				'name'  => 'description',
				'id'    => 'description',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('description')
			);
			$this->data['registrationStart'] = array(
				'name'  => 'registrationStart',
				'id'    => 'registrationStart',
				'type'  => 'text',
				'class' => 'date',
				'value' => $this->datetimestr_to_public( $this->form_validation->set_value('registrationStart') )
			);
			$this->data['registrationEnd'] = array(
				'name'  => 'registrationEnd',
				'id'    => 'registrationEnd',
				'type'  => 'text',
				'class' => 'date',
				'value' => $this->datetimestr_to_public( $this->form_validation->set_value('registrationEnd') )
			);
			$this->data['tournamentStart'] = array(
				'name'  => 'tournamentStart',
				'id'    => 'tournamentStart',
				'type'  => 'text',
				'class' => 'date',
				'value' => $this->datetimestr_to_public( $this->form_validation->set_value('tournamentStart') )
			);
			$this->data['tournamentEnd'] = array(
				'name'  => 'tournamentEnd',
				'id'    => 'tournamentEnd',
				'type'  => 'text',
				'class' => 'date',
				'value' => $this->datetimestr_to_public( $this->form_validation->set_value('tournamentEnd') )
			);
			
		}
		
		$this->load->view('tms/header',$this->data);
		$this->load->view('tms/tournaments',$this->data);
		$this->load->view('tms/footer',$this->data);
	}
	
	public function tournament($tournamentID)
	{
		$this->data['title'] = "Tournament";
		$this->data['page'] = "tournament";
		
		$this->load->model('tournaments_model');
		$this->load->model('sports_model');
		
		if( $this->tournaments_model->tournament_exists($tournamentID) ) {
			$this->data['tournament'] = $tournament = $this->tournaments_model->get_tournament($tournamentID);
			$tournament['status'] = $this->tournaments_model->get_tournament_status($tournamentID);
			$this->data['tournamentID'] = $tournamentID;
						
			$this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'required|xss_clean');		
			
			switch($tournament['status']) { 
				case "preRegistration": 
					$this->form_validation->set_rules('registrationStart', 'registrationStart', 'required|xss_clean|callback_datetime_check[registrationStart]');
					$this->form_validation->set_rules('registrationEnd', 'registrationEnd', 'required|xss_clean|callback_datetime_check[registrationEnd]');
					$this->form_validation->set_rules('tournamentStart', 'tournamentStart', 'required|xss_clean|callback_datetime_check[tournamentStart]');
					$this->form_validation->set_rules('tournamentEnd', 'tournamentEnd', 'required|xss_clean|callback_datetime_check[tournamentEnd]');	
				break; 
				case "inRegistration": 
					$this->form_validation->set_rules('registrationEnd', 'registrationEnd', 'required|xss_clean|callback_datetime_check[registrationEnd]');
					$this->form_validation->set_rules('tournamentStart', 'tournamentStart', 'required|xss_clean|callback_datetime_check[tournamentStart]');
					$this->form_validation->set_rules('tournamentEnd', 'tournamentEnd', 'required|xss_clean|callback_datetime_check[tournamentEnd]');	
				break; 
				case "postRegistration": 
					$this->form_validation->set_rules('tournamentStart', 'tournamentStart', 'required|xss_clean|callback_datetime_check[tournamentStart]');
					$this->form_validation->set_rules('tournamentEnd', 'tournamentEnd', 'required|xss_clean|callback_datetime_check[tournamentEnd]');	
				break; 
				case "preTournament": 
					$this->form_validation->set_rules('tournamentStart', 'tournamentStart', 'required|xss_clean|callback_datetime_check[tournamentStart]');
					$this->form_validation->set_rules('tournamentEnd', 'tournamentEnd', 'required|xss_clean|callback_datetime_check[tournamentEnd]');	
				break; 
				case "inTournament": 
					$this->form_validation->set_rules('tournamentEnd', 'tournamentEnd', 'required|xss_clean|callback_datetime_check[tournamentEnd]');	
				break; 
				case "postTournament": 
				break;
				default: 
					$this->form_validation->set_rules('registrationStart', 'registrationStart', 'required|xss_clean|callback_datetime_check[registrationStart]');
					$this->form_validation->set_rules('registrationEnd', 'registrationEnd', 'required|xss_clean|callback_datetime_check[registrationEnd]');
					$this->form_validation->set_rules('tournamentStart', 'tournamentStart', 'required|xss_clean|callback_datetime_check[tournamentStart]');
					$this->form_validation->set_rules('tournamentEnd', 'tournamentEnd', 'required|xss_clean|callback_datetime_check[tournamentEnd]');	
				break; 	
			} 
			
			// Change dates from public, timepicker-friendly format to database-friendly ISO format.
			if($this->input->post('registrationStart')) $_POST['registrationStart'] = $this->datetimestr_to_standard($this->input->post('registrationStart'));
			if($this->input->post('registrationEnd')) $_POST['registrationEnd'] = $this->datetimestr_to_standard($this->input->post('registrationEnd'));
			if($this->input->post('tournamentStart')) $_POST['tournamentStart'] = $this->datetimestr_to_standard($this->input->post('tournamentStart'));
			if($this->input->post('tournamentEnd')) $_POST['tournamentEnd'] = $this->datetimestr_to_standard($this->input->post('tournamentEnd'));
			
			if ($this->form_validation->run() == true) {
				$newdata = $_POST;
				
				$this->tournaments_model->update_tournament($tournamentID, $newdata);
				if($tournamentID > -1) {
					// Successful update, show success message
					$this->session->set_flashdata('message_success',  'Successfully Updated Tournament.');
				} else {
					$this->session->set_flashdata('message_error',  'Failed. Please contact Infusion Systems.');
				}
				redirect("/tms/tournament/$tournamentID", 'refresh');
			} else {
				//set the flash data error message if there is one
				$this->data['message_error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message_error') );
				
				$this->data['tournament']['status'] = $this->tournaments_model->get_tournament_status($tournamentID);
				$sport = $this->sports_model->get_sport( $tournament['sportID'] );
				$this->data['tournament']['sportName'] = $sport['name'];
			
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
					'value' => $this->form_validation->set_value('description',(isset($tournament['description']) ? $tournament['description'] : '') )
				);
				$this->data['registrationStart'] = array(
					'name'  => 'registrationStart',
					'id'    => 'registrationStart',
					'type'  => 'text',
					'class' => 'date',
					'value' => $this->datetimestr_to_public( $this->form_validation->set_value('registrationStart',(isset($tournament['registrationStart']) ? $tournament['registrationStart'] : '') ) )
				);
				$this->data['registrationEnd'] = array(
					'name'  => 'registrationEnd',
					'id'    => 'registrationEnd',
					'type'  => 'text',
					'class' => 'date',
					'value' => $this->datetimestr_to_public( $this->form_validation->set_value('registrationEnd',(isset($tournament['registrationEnd']) ? $tournament['registrationEnd'] : '') ) )
				);
				$this->data['tournamentStart'] = array(
					'name'  => 'tournamentStart',
					'id'    => 'tournamentStart',
					'type'  => 'text',
					'class' => 'date',
					'value' => $this->datetimestr_to_public( $this->form_validation->set_value('tournamentStart',(isset($tournament['tournamentStart']) ? $tournament['tournamentStart'] : '') ) )
				);
				$this->data['tournamentEnd'] = array(
					'name'  => 'tournamentEnd',
					'id'    => 'tournamentEnd',
					'type'  => 'text',
					'class' => 'date',
					'value' => $this->datetimestr_to_public( $this->form_validation->set_value('tournamentEnd',(isset($tournament['tournamentEnd']) ? $tournament['tournamentEnd'] : '') ) )
				);
				
			}
			
			$this->load->view('tms/header',$this->data);
			$this->load->view('tms/tournament',$this->data);
			$this->load->view('tms/footer',$this->data);
				
		} else {
			$this->session->set_flashdata('message_error',  "Tournament ID $id does not exist.");
			redirect("/tms/tournaments", 'refresh');
		}
	}
	
	
	public function delete_tournament($tournamentID)
	{
		$this->load->model('tournaments_model');

		if($this->tournaments_model->delete_tournament($tournamentID) ) {
			// Successful delete, show success message
			$this->session->set_flashdata('message_success',  'Successfully Deleted Tournament.');
		} else {
			$this->session->set_flashdata('message_error',  'Failed. Please contact Infusion Systems.');
		}
		redirect("/tms/tournaments", 'refresh');
	}

	public function venues($action='portal')
	{
		$this->data['title'] = "Venues";
		$this->data['page'] = "venues";
	
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
		
		$this->load->view('tms/header',$this->data);
		$this->load->view('tms/venues',$this->data);
		$this->load->view('tms/footer',$this->data);
	}

	public function venue($venueID)
	{
		$this->load->library('table');
		$this->load->model('venues_model');

		// Get data for this venue
		$this->data['venue'] = $this->venues_model->get_venue($venueID);

		$this->data['title'] = $this->data['venue']['name']+" venue";
		$this->data['page']  = "venue"; 
		$this->load->view('tms/header',$this->data);
		$this->load->view('tms/venue',$this->data);
		$this->load->view('tms/footer',$this->data);
	}

	public function sports()
	{
		$this->data['title'] = "Sports";
		$this->data['page'] = "sports";
		$this->load->view('tms/header',$this->data);
		$this->load->view('tms/sports',$this->data);
		$this->load->view('tms/footer',$this->data);
	}
	public function match($matchID)
	{
		$this->load->library('table');
		$this->load->model('matches_model');

		// Get data for this venue
		$this->data['match'] = $this->matches_model->get_match($matchID);

		$this->data['title'] = $this->data['match']['name']." match";
		$this->data['page']  = "match"; 
		$this->load->view('tms/header',$this->data);
		$this->load->view('tms/match',$this->data);
		$this->load->view('tms/footer',$this->data);
	}
	public function matches()
	{
		$this->data['title'] = "Matches";
		$this->data['page'] = "matches";
		$this->load->view('tms/header',$this->data);
		$this->load->view('tms/matches',$this->data);
		$this->load->view('tms/footer',$this->data);
	}
	public function calendar()
	{
		$this->data['title'] = "Calendar";
		$this->data['page'] = "calendar";
		$this->load->view('tms/header',$this->data);
		$this->load->view('tms/calendar',$this->data);
		$this->load->view('tms/footer',$this->data);
	}
	public function groups()
	{
		$this->data['title'] = "Groups";
		$this->data['page'] = "groups";
		
		$this->data['groups'] = $this->ion_auth->groups()->result();
		
		$this->load->view('tms/header',$this->data);
		$this->load->view('tms/groups',$this->data);
		$this->load->view('tms/footer',$this->data);
	}
	public function users()
	{
		$this->data['title'] = "Users";
		$this->data['page'] = "users";
		
		$users = obj2arr( $this->ion_auth->users()->result() );
		foreach($users as $userkey => $user) {
			$query = $this->db->query("SELECT `key`,`value` FROM `userData` WHERE `userID` = '{$user['id']}'");
			foreach($query->result_array() as $userDataRow) {
				$users[$userkey][$userDataRow['key']] = $userDataRow['value'];
				if($userDataRow['key'] == 'centreID') {
					$query = $this->db->query("SELECT `value` FROM `centreData` WHERE `key` = 'shortName' AND `centreID` = {$userDataRow['value']}");
					$nameResult = $query->result_array();
					$users[$userkey]['centreName'] = $nameResult[0]['value'];
				}
			}
		}
		$this->data['users'] = $users;
		
		$this->load->view('tms/header',$this->data);
		$this->load->view('tms/users',$this->data);
		$this->load->view('tms/footer',$this->data);
	}
	public function news()
	{
		$this->data['title'] = "News";
		$this->data['page'] = "news";
		$this->load->view('tms/header',$this->data);
		$this->load->view('tms/news',$this->data);
		$this->load->view('tms/footer',$this->data);
	}
	public function reports()
	{
		$this->data['title'] = "Reports";
		$this->data['page'] = "reports";
		$this->load->view('tms/header',$this->data);
		$this->load->view('tms/reports',$this->data);
		$this->load->view('tms/footer',$this->data);
	}
	public function playground() {
		$this->data['title'] = "Branding Playground";
		$this->data['page'] = "playground";
		$this->load->view('tms/header',$this->data);
		$this->load->view('tms/playground',$this->data);
		$this->load->view('tms/footer',$this->data);
	}
	public function settings()
	{
		$this->data['title'] = "Settings";
		$this->data['page'] = "settings";
			
		$this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
		$this->form_validation->set_rules('shortName', 'Short Name', 'required|xss_clean');
		$this->form_validation->set_rules('address', 'Address', 'required|xss_clean');
		$this->form_validation->set_rules('headerColour', 'Header Colour', 'required|xss_clean');
		$this->form_validation->set_rules('backgroundColour', 'Background Colour', 'required|xss_clean');
		$this->form_validation->set_rules('footerText', 'Footer Text', 'required|xss_clean');
		
		$this->form_validation->set_rules('monOpenTime', 'monday Open Time', 'required|xss_clean');
		$this->form_validation->set_rules('monCloseTime', 'monday Close Time', 'required|xss_clean');
		
		$this->form_validation->set_rules('tueOpenTime', 'tueday Open Time', 'required|xss_clean');
		$this->form_validation->set_rules('tueCloseTime', 'tueday Close Time', 'required|xss_clean');
		
		$this->form_validation->set_rules('wedOpenTime', 'wedday Open Time', 'required|xss_clean');
		$this->form_validation->set_rules('wedCloseTime', 'wedday Close Time', 'required|xss_clean');
		
		$this->form_validation->set_rules('thuOpenTime', 'thuday Open Time', 'required|xss_clean');
		$this->form_validation->set_rules('thuCloseTime', 'thuday Close Time', 'required|xss_clean');
		
		$this->form_validation->set_rules('friOpenTime', 'friday Open Time', 'required|xss_clean');
		$this->form_validation->set_rules('friCloseTime', 'friday Close Time', 'required|xss_clean');
		
		$this->form_validation->set_rules('satOpenTime', 'satday Open Time', 'required|xss_clean');
		$this->form_validation->set_rules('satCloseTime', 'satday Close Time', 'required|xss_clean');
		
		$this->form_validation->set_rules('sunOpenTime', 'sunday Open Time', 'required|xss_clean');
		$this->form_validation->set_rules('sunCloseTime', 'sunday Close Time', 'required|xss_clean');
		
		if ($this->form_validation->run() == true) {
			$newdata = $_POST;
			// If checkbox is unticked, it returns no value - this means FALSE
			if(!isset($newdata['monOpen'])) $newdata['monOpen'] = 0;
			if(!isset($newdata['tueOpen'])) $newdata['tueOpen'] = 0;
			if(!isset($newdata['wedOpen'])) $newdata['wedOpen'] = 0;
			if(!isset($newdata['thuOpen'])) $newdata['thuOpen'] = 0;
			if(!isset($newdata['friOpen'])) $newdata['friOpen'] = 0;
			if(!isset($newdata['satOpen'])) $newdata['satOpen'] = 0;
			if(!isset($newdata['sunOpen'])) $newdata['sunOpen'] = 0;
			
			if($this->centre_model->update_centre($this->data['centre']['centreID'],$newdata ) ) {
				// Successful update, show success message
				$this->session->set_flashdata('message_success',  'Successfully Updated');
			} else {
				$this->session->set_flashdata('message_error',  'Failed. Please contact Infusion Systems.');
			}
			redirect("/tms/settings", 'refresh');
		} else {
			//display the create user form
			//set the flash data error message if there is one
			$this->data['message_error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message_error') );
			
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
			$this->data['headerColour'] = array(
				'name'  => 'headerColour',
				'id'    => 'headerColour',
				'type'  => 'text',
				'style' => 'background-color: #'.(isset($this->data['centre']['headerColour']) ? $this->data['centre']['headerColour'] : 'FFFFFF'),
				'class' => 'colorpickerinput',
				'value' => $this->form_validation->set_value('headerColour',(isset($this->data['centre']['headerColour']) ? $this->data['centre']['headerColour'] : '') )
			);
			$this->data['backgroundColour'] = array(
				'name'  => 'backgroundColour',
				'id'    => 'backgroundColour',
				'type'  => 'text',
				'style' => 'background-color: #'.(isset($this->data['centre']['backgroundColour']) ? $this->data['centre']['backgroundColour'] : 'FFFFFF'),
				'class' => 'colorpickerinput',
				'value' => $this->form_validation->set_value('backgroundColour',(isset($this->data['centre']['backgroundColour']) ? $this->data['centre']['backgroundColour'] : '') )
			);
			$this->data['footerText'] = array(
				'name'  => 'footerText',
				'id'    => 'footerText',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('footerText',(isset($this->data['centre']['footerText']) ? $this->data['centre']['footerText'] : '') )
			);
			
			
			$this->data['monOpen'] = array(
				'name'  => 'monOpen',
				'id'    => 'monOpen',
				'type'  => 'checkbox',
				'value' => '1',
				($this->data['centre']['monOpen'] ? 'checked' : 'notchecked') => 'checked'
			);
			$this->data['monOpenTime'] = array(
				'name'  => 'monOpenTime',
				'id'    => 'monOpenTime',
				'type'  => 'text',
				'class'  => 'time',
				'value' => $this->form_validation->set_value('monOpenTime',(isset($this->data['centre']['monOpenTime']) ? $this->data['centre']['monOpenTime'] : '') )
			);
			$this->data['monCloseTime'] = array(
				'name'  => 'monCloseTime',
				'id'    => 'monCloseTime',
				'type'  => 'text',
				'class'  => 'time',
				'value' => $this->form_validation->set_value('monCloseTime',(isset($this->data['centre']['monCloseTime']) ? $this->data['centre']['monCloseTime'] : '') )
			);

			$this->data['tueOpen'] = array(
				'name'  => 'tueOpen',
				'id'    => 'tueOpen',
				'type'  => 'checkbox',
				'value' => '1',
				($this->data['centre']['tueOpen'] ? 'checked' : 'notchecked') => 'checked'
			);
			$this->data['tueOpenTime'] = array(
				'name'  => 'tueOpenTime',
				'id'    => 'tueOpenTime',
				'type'  => 'text',
				'class'  => 'time',
				'value' => $this->form_validation->set_value('tueOpenTime',(isset($this->data['centre']['tueOpenTime']) ? $this->data['centre']['tueOpenTime'] : '') )
			);
			$this->data['tueCloseTime'] = array(
				'name'  => 'tueCloseTime',
				'id'    => 'tueCloseTime',
				'type'  => 'text',
				'class'  => 'time',
				'value' => $this->form_validation->set_value('tueCloseTime',(isset($this->data['centre']['tueCloseTime']) ? $this->data['centre']['tueCloseTime'] : '') )
			);

			$this->data['wedOpen'] = array(
				'name'  => 'wedOpen',
				'id'    => 'wedOpen',
				'type'  => 'checkbox',
				'value' => '1',
				($this->data['centre']['wedOpen'] ? 'checked' : 'notchecked') => 'checked'
			);
			$this->data['wedOpenTime'] = array(
				'name'  => 'wedOpenTime',
				'id'    => 'wedOpenTime',
				'type'  => 'text',
				'class'  => 'time',
				'value' => $this->form_validation->set_value('wedOpenTime',(isset($this->data['centre']['wedOpenTime']) ? $this->data['centre']['wedOpenTime'] : '') )
			);
			$this->data['wedCloseTime'] = array(
				'name'  => 'wedCloseTime',
				'id'    => 'wedCloseTime',
				'type'  => 'text',
				'class'  => 'time',
				'value' => $this->form_validation->set_value('wedCloseTime',(isset($this->data['centre']['wedCloseTime']) ? $this->data['centre']['wedCloseTime'] : '') )
			);

			$this->data['thuOpen'] = array(
				'name'  => 'thuOpen',
				'id'    => 'thuOpen',
				'type'  => 'checkbox',
				'value' => '1',
				($this->data['centre']['thuOpen'] ? 'checked' : 'notchecked') => 'checked'
			);
			$this->data['thuOpenTime'] = array(
				'name'  => 'thuOpenTime',
				'id'    => 'thuOpenTime',
				'type'  => 'text',
				'class'  => 'time',
				'value' => $this->form_validation->set_value('thuOpenTime',(isset($this->data['centre']['thuOpenTime']) ? $this->data['centre']['thuOpenTime'] : '') )
			);
			$this->data['thuCloseTime'] = array(
				'name'  => 'thuCloseTime',
				'id'    => 'thuCloseTime',
				'type'  => 'text',
				'class'  => 'time',
				'value' => $this->form_validation->set_value('thuCloseTime',(isset($this->data['centre']['thuCloseTime']) ? $this->data['centre']['thuCloseTime'] : '') )
			);

			$this->data['friOpen'] = array(
				'name'  => 'friOpen',
				'id'    => 'friOpen',
				'type'  => 'checkbox',
				'value' => '1',
				($this->data['centre']['friOpen'] ? 'checked' : 'notchecked') => 'checked'
			);
			$this->data['friOpenTime'] = array(
				'name'  => 'friOpenTime',
				'id'    => 'friOpenTime',
				'type'  => 'text',
				'class'  => 'time',
				'value' => $this->form_validation->set_value('friOpenTime',(isset($this->data['centre']['friOpenTime']) ? $this->data['centre']['friOpenTime'] : '') )
			);
			$this->data['friCloseTime'] = array(
				'name'  => 'friCloseTime',
				'id'    => 'friCloseTime',
				'type'  => 'text',
				'class'  => 'time',
				'value' => $this->form_validation->set_value('friCloseTime',(isset($this->data['centre']['friCloseTime']) ? $this->data['centre']['friCloseTime'] : '') )
			);

			$this->data['satOpen'] = array(
				'name'  => 'satOpen',
				'id'    => 'satOpen',
				'type'  => 'checkbox',
				'value' => '1',
				($this->data['centre']['satOpen'] ? 'checked' : 'notchecked') => 'checked'
			);
			$this->data['satOpenTime'] = array(
				'name'  => 'satOpenTime',
				'id'    => 'satOpenTime',
				'type'  => 'text',
				'class'  => 'time',
				'value' => $this->form_validation->set_value('satOpenTime',(isset($this->data['centre']['satOpenTime']) ? $this->data['centre']['satOpenTime'] : '') )
			);
			$this->data['satCloseTime'] = array(
				'name'  => 'satCloseTime',
				'id'    => 'satCloseTime',
				'type'  => 'text',
				'class'  => 'time',
				'value' => $this->form_validation->set_value('satCloseTime',(isset($this->data['centre']['satCloseTime']) ? $this->data['centre']['satCloseTime'] : '') )
			);

			$this->data['sunOpen'] = array(
				'name'  => 'sunOpen',
				'id'    => 'sunOpen',
				'type'  => 'checkbox',
				'value' => '1',
				($this->data['centre']['sunOpen'] ? 'checked' : 'notchecked') => 'checked'
			);
			$this->data['sunOpenTime'] = array(
				'name'  => 'sunOpenTime',
				'id'    => 'sunOpenTime',
				'type'  => 'text',
				'class'  => 'time',
				'value' => $this->form_validation->set_value('sunOpenTime',(isset($this->data['centre']['sunOpenTime']) ? $this->data['centre']['sunOpenTime'] : '') )
			);
			$this->data['sunCloseTime'] = array(
				'name'  => 'sunCloseTime',
				'id'    => 'sunCloseTime',
				'type'  => 'text',
				'class'  => 'time',
				'value' => $this->form_validation->set_value('sunCloseTime',(isset($this->data['centre']['sunCloseTime']) ? $this->data['centre']['sunCloseTime'] : '') )
			);

			$this->load->view('tms/header',$this->data);
			$this->load->view('tms/settings', $this->data);
			$this->load->view('tms/footer',$this->data);
		}
	}

	// Callback function for form validation - checks sanity and validity of POST date strings
	public function datetime_check($strDateTime,$field) {
		try {
			// If date string is invalid, this should throw an exception. We're only calling it endDate because of the checking of date ranges 
			$endDate = new DateTime($strDateTime);
			// If the field has "End" at the end, we're assuming there's a corresponding "Start" field. 
			if(substr($field, -3)=="End") {
				$endDateField = $field;
				$startDateField = substr($field, 0, -3)."Start";
				// Create a new DateTime object from the start date string, or today's date if there is no start string
				$startDate = ( ($this->input->post($startDateField)===FALSE) ? new DateTime() : new DateTime($this->input->post($startDateField)) );
				// If start datetime is equal to or after end datetime 
				if( $startDate >= $endDate ) {
					$this->form_validation->set_message('datetime_check', "Invalid date range specified: $startDateField -> $endDateField. Please ensure start dates are before end dates, and end dates are in the future.");
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
			$this->form_validation->set_message('datetime_check', 'The %s field must contain a valid date in the ISO 8601 format: YYYY-MM-DDThh:mm:ssTZD (eg 1997-07-16T19:20:30+01:00) Provided: '.print_r($strDateTime,1) );
			//$this->form_validation->set_message('datetime_check', 'Exception: '.$e->getMessage().' DateTime string provided: '.var_export($strDateTime,1) );
			return FALSE;
		}
	}
	
	public function datetimestr_to_standard($strDateTime) {
		$dateTime = new DateTime($strDateTime);
		return $dateTime->format(DATE_TIME_FORMAT);
	}
	public function datetimestr_to_unix($strDateTime) {
		$dateTime = new DateTime($strDateTime);
		return $dateTime->format(DATE_TIME_UNIX_FORMAT);
	}
	public function datetimestr_to_public($strDateTime) {
		$dateTime = new DateTime($strDateTime);
		return $dateTime->format(PUBLIC_DATE_TIME_FORMAT);
	}

}
