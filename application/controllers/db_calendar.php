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
		$matches = $this->matches_model->get_matches($this->data['centre']['centreID']);
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
		header('Content-Type: application/json');
		$this->load->view('data',$this->data);
	}
	public function getVenueMatches($venueID){
		$matches = $this->matches_model->get_venue_matches($venueID);
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
	public function getTournamentMatches($tournamentID){
		// Should return registration periods
	}

	public function changeMatchStart() {
		$matchData = $this->matches_model->get_match($_POST['id']);
		$oldStartTime = $matchData['startTime'];
		$newStartTime = $oldStartTime+$_POST['minutesDelta'];
		$updateResult = $this->matches_model->update_match($_POST['id'],array('startTime'=>$newStartTime));
		$this->data['data'] = ($updateResult ? "Success!" : "False!");
		$this->load->view('data',$this->data);
	}

	public function changeMatchEnd() {
		$matchData = $this->matches_model->get_match($_POST['id']);
		$oldEndTime = $matchData['endTime'];
		$newEndTime = $oldEndTime+$_POST['minutesDelta'];
		$updateResult = $this->matches_model->update_match($_POST['id'],array('endTime'=>$newEndTime));
		$this->data['data'] = ($updateResult ? "Success!" : "False!");
		$this->load->view('data',$this->data);
	}
	
}
?>