<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Db_Calendar extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->library('table');
		$this->load->model('tournaments_model');
		$this->load->model('matches_model');
		$this->load->model('sports_model');
	}


	/*
		A method which takes in the following query:
		* matchUrl
		* tournamentUrl
		* registrationUrl
		* tournamentIDs
		* matcheIDs
		* sportIDs
		* centreID
	*/
	private function getEvents($centreID,$query) {

		$matchUrl					= false;
		$tournamentUrl				= false;
		$registrationUrl			= false;
		$matchIDs					= "all";
		$tournamentIDs				= "all";
		$sportIDs					= "all";
		$venueIDs					= "all";
		$showRegistration			= true;
		$showTournamentMatchesOnly	= false;
		$tournamentColour			= '#FF00FF';
		$registrationColour			= '#00FF00';
		$matchColour				= '#2966C7';

		if(array_key_exists('matchUrl',$query))
			$matchUrl 					= $query['matchUrl'];
		if(array_key_exists('tournamentUrl',$query))
			$tournamentUrl 				= $query['tournamentUrl'];
		if(array_key_exists('registrationUrl',$query))
			$registrationUrl			= $query['registrationUrl'];
		if(array_key_exists('matchIDs',$query))
			$matchIDs 					= $query['matchIDs'];
		if(array_key_exists('tournamentIDs',$query))
			$tournamentIDs 				= $query['tournamentIDs'];
		if(array_key_exists('sportIDs',$query))
			$sportIDs 					= $query['sportIDs'];
		if(array_key_exists('showRegistration',$query))
			$showRegistration 			= $query['showRegistration'];
		if(array_key_exists('showTournamentMatchesOnly',$query))
			$showTournamentMatchesOnly 	= $query['showTournamentMatchesOnly'];

		$tournaments 		= array();
		$matches 			= array();

		// We select all the tournaments with the appropriate sport.
		if($tournamentIDs=="all"){ // If we want all tournaments
			$tournamentsAll = $this->tournaments_model->get_tournaments($centreID);
			foreach ($tournamentsAll as $tournament )
					if($sportIDs!="all") // If we want only a particular sport
						if(in_array($tournament['sportID'],$sportIDs))
							$tournaments[] = $tournament;
					else
						$tournaments[] = $tournament;
		} else if($tournamentIDs=="none") {

		} else { // If we want only particular tournaments
			foreach ($tournamentIDs as $tournamentID ){
				$tournament = $this->tournaments_model->get_tournament($tournamentID);
				if($sportIDs!="all") // If we want only a particular sport
					if(in_array($tournament['sportID'],$sportIDs))
						$tournaments[] = $tournament;
				else
					$tournaments[] = $tournament;
			}
		}

		// We select all the matches with the appropriate sport.
		if($matchIDs=="all"){ // If we want all matches
			$matchesAll = array();
			if($showTournamentMatchesOnly)
				$matchesAll = $this->matches_model->get_tournament_matches($centreID);
			else 
				$matchesAll = $this->matches_model->get_matches($centreID);
			foreach ($matchesAll as $match )
				if($sportIDs!="all") // If we want only a particular sport
					if(in_array($match['sportID'],$sportIDs))
						$matches[] = $match;
				else
					$matches[] = $match;
		} else if($matchIDs=="none") {

		} else { // If we only want particular matches
			foreach ($matchIDs as $matchID ){
				$match = $this->matches_model->get_match($matchID);
				if($sportIDs!="all") // If we want only a particular sport
					if(in_array($match['sportID'],$sportIDs))
						$matches[] = $match;
				else
					$matches[] = $match;
			}
		}

		$this->data['data'] = array();
		foreach($matches as $match) {
			$this->data['data'][] = array(
				'data' => array(
					'id' => $match['matchID']
				),
				'title' => $match['name'],
				'start' => $match['startTime'],
				'end' => $match['endTime'],
				'url' => $matchUrl.$match['matchID'],
				'allDay' => false,
				'color' => $matchColour
			);
		}
		// Inserting all the tournament periods
		foreach($tournaments as $tournament) {
			$this->data['data'][] = array(
				'data' => array(
					'id' => $tournament['matchID']
				),
				'title' => $tournament['name'],
				'start' => $tournament['tournamentStart'],
				'end' => $tournament['tournamentEnd'],
				'url' => $tournamentUrl.$tournament['tournamentID'],
				'allDay' => true,
				'color' => $tournamentColour
			);
		}
		// Inserting all the registration periods
		if($showRegistration)
			foreach($tournaments as $tournament) {
				$this->data['data'][] = array(
					'data' => array(
						'id' => $tournament['matchID']
					),
					'title' => $tournament['name']+" Registration Period",
					'start' => $tournament['registrationStart'],
					'end' => $tournament['registrationEnd'],
					'url' => $registrationtUrl.$tournament['tournamentID'],
					'allDay' => true,
					'color' => $registrationColour
				);
			}
		$this->data['data'][] = array(
			'query' => $query
			);
		$this->data['data'][] = array(
			'tournaments' => $tournaments
			);
		$this->data['data'][] = array(
			'matches' => $matches
			);

		$this->data['data'] = json_encode($this->data['data']);
		header('Content-Type: application/json');
		$this->load->view('data',$this->data);
	}

	private function getAllMatches($url) {
		//$matches = $this->matches_model->get_matches($this->data['centre']['centreID']);
		//$this->data['data'] = array();		
		/*foreach($matches as $match) {
			$this->data['data'][] = array(
				'data' => array(
					'id' => $match['matchID']
				),
				'title' => $match['name'],
				'start' => $match['startTime'],
				'end' => $match['endTime'],
				'url' => $url.$match['matchID'],
				'allDay' => false,
				'color' => '#2966C7'
			);
		}*/
		$query = array();
		$query['tournamentIDs'] = "none";
		$query['tournamentUrl'] = $url;
		$this->getEvents($this->data['centre']['centreID'],$query);
	}
	public function getAllMatchesTMS() {
		$this->getAllMatches("/tms/match/");
	}
	public function getAllMatchesSIS() {
		$this->getAllMatches("/sis/match/");
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
				'url' => "../match/".$match['matchID'],
				'allDay' => false,
				'color' => '#2966C7'
			);
		}
		$this->data['data'] = json_encode($this->data['data']);
		$this->load->view('data',$this->data);
	}
	public function getTournamentMatches($tournamentID){
		$matches = $this->matches_model->get_tournament_matches($tournamentID);
		$this->data['data'] = array();
		foreach($matches as $match) {
			$this->data['data'][] = array(
				'data' => array(
					'id' => $match['matchID']
				),
				'title' => $match['name'],
				'start' => $match['startTime'],
				'end' => $match['endTime'],
				'url' => "../match/".$match['matchID'],
				'allDay' => false,
				'color' => '#2966C7'
			);
		}
		$this->data['data'] = json_encode($this->data['data']);
		header('Content-Type: application/json');
		$this->load->view('data',$this->data);
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