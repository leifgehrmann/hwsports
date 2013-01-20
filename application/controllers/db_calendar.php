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
		$output = $this->matches_model->get_matches($this->data['centre']['id']);
			
		$this->data['data'] = json_encode($output);
	
	
		// Should return registration periods

		$this->data['test'] = json_encode(array(
			array(
				'title' => 'Men\'s Hurdling - Preliminary Rounds',
				'start' => mktime(12, 0, 0, 1, 10-3, 2013),
				'end' => mktime(14, 0, 0, 1, 10-3, 2013),
				'allDay' => false,
				'color' => '#2966C7'
			),
			array(
				'title' => 'Heriot Hurdling Registration Period',
				'start' => mktime(0, 0, 0, 1, 10-30, 2013),
				'end' => mktime(0, 0, 0, 1, 10-7, 2013),
				'color' => '#EA472C'
			)
		));
		$this->load->view('data',$this->data);
	}
	public function getVenueMatches($venueID){

	}
	public function getTournamentMatches($tournamentID){
		// Should return registration periods
	}

}
?>