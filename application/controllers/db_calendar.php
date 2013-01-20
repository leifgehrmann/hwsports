<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Db_Calendar extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->library('table');
		$this->load->model('matches_model');
	}

	// Input:
	//	* 
	public function getAllMatches() {
		$matches = $this->matches_model->get_matches($this->data['centre']['id']);
		$this->data['data'] = array();		
		foreach($matches as $match) {
			$this->data['data'][] = array(
				'data' => array(
					'id' => $match['matchID']
				),
				'title' => $match['name'],
				'start' => $match['startTime'],
				'end' => $match['endTime'],
				'url' => "/tms/match/".$match['matchID'],
				'allDay' => false,
				'color' => '#2966C7'
			);
		}
		$this->data['data'] = json_encode($this->data['data']);
		$this->load->view('data',$this->data);
	}
	public function getVenueMatches($venueID){

	}
	public function getTournamentMatches($tournamentID){
		// Should return registration periods
	}

	public function changeMatchStart() {
		$this->data['data'] = json_encode(  $_POST  );
		$this->load->view('data',$this->data);
	}
	
}
?>