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
				'title' => $match['name'],
				'start' => $match['timestamp'],
				'end' => $match['timestamp']+7200,
				'allDay' => false,
				'color' => '#2966C7'
			)
		}
		$this->load->view('data',$this->data);
	}
	public function getVenueMatches($venueID){

	}
	public function getTournamentMatches($tournamentID){
		// Should return registration periods
	}

}
?>