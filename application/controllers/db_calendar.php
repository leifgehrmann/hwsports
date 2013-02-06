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
	private function getEvents($query) {

		$centreID					= $this->data['centre']['centreID'];
		$matchUrl					= null;
		$tournamentUrl				= null;
		$registrationUrl			= null;
		$matchIDs					= "all"; // array() of ids, "all" or "none"
		$tournamentIDs				= "all"; // array() of ids, "all" or "none"
		$sportIDs					= "all"; // array() of ids, "all" or "none"
		$venueIDs					= "all"; // array() of ids, "all" or "none"
		$showRegistration			= true;  // show registration fields?
		$showTournamentMatchesOnly	= false;
		$tournamentColour			= 'rgb(123, 209,  72)';
		$registrationColour			= 'rgb(250,  87,  60)';
		$matchColour				= '#2966C7';

		if(array_key_exists('centreID',$query))
			$centreID 					= $query['centreID'];
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

		$this->data['data'] = array();

		// We select all the tournaments with the appropriate sport.
		if($tournamentIDs=="all"){ // If we want all tournaments
			$tournamentsAll = $this->tournaments_model->get_tournaments($centreID);
			/*$this->data['data'][] = array(
				'tournamentsAll' => $tournamentsAll
			);*/
			foreach ($tournamentsAll as $tournament )
				if($sportIDs=="all") // If we want only a particular sport
					$tournaments[] = $tournament;
				else
					if(in_array($tournament['sportID'],$sportIDs))
						$tournaments[] = $tournament;
		} else if($tournamentIDs=="none") {

		} else { // If we want only particular tournaments
			foreach ($tournamentIDs as $tournamentID ){
				$tournament = $this->tournaments_model->get_tournament($tournamentID);
				if($sportIDs=="all") // If we want only a particular sport
					$tournaments[] = $tournament;
				else
					if(in_array($tournament['sportID'],$sportIDs))
						$tournaments[] = $tournament;
			}
		}

		// We select all the matches with the appropriate sport.
		if($matchIDs=="all"){ // If we want all matches
			$matchesAll = array();

			// Do we want tournament matches only?
			if($showTournamentMatchesOnly)
				$matchesAll = $this->matches_model->get_tournament_matches($centreID);
			else 
				$matchesAll = $this->matches_model->get_matches($centreID);
			foreach ($matchesAll as $match ){
				if($sportIDs=="all") // If we want only a particular sport
					if($venueIDs=="all") // If we want only a particular venue
						$matches[] = $match;
					else
						if(in_array($match['venueID'],$venueIDs))
							$matches[] = $match;
				else
					if(in_array($match['sportID'],$sportIDs))
						if($venueIDs=="all") // If we want only a particular venue
							$matches[] = $match;
						else
							if(in_array($match['venueID'],$venueIDs))
								$matches[] = $match;
			}
		} else if($matchIDs=="none") {

		} else { // If we only want particular matches
			foreach ($matchIDs as $matchID ){
				$match = $this->matches_model->get_match($matchID);
				if($sportIDs=="all") // If we want only a particular sport
					if($venueIDs=="all") // If we want only a particular venue
						$matches[] = $match;
					else
						if(in_array($match['venueID'],$venueIDs))
							$matches[] = $match;
				else
					if(in_array($match['sportID'],$sportIDs))
						if($venueIDs=="all") // If we want only a particular venue
							$matches[] = $match;
						else
							if(in_array($match['venueID'],$venueIDs))
								$matches[] = $match;
			}
		}

		// Inserting all the matches
		foreach($matches as $match) {
			$event = array(
				'data' => array(
					'id' => $match['matchID']
				),
				'title' => $match['name'],
				'start' => $match['startTime'],
				'end' => $match['endTime'],
				'allDay' => false,
				'color' => $matchColour
			);
			if(isset($matchUrl))
				$event['url'] = $matchUrl.$match['matchID'];
			$this->data['data'][] = $event;
		}
		// Inserting all the tournament periods
		foreach($tournaments as $tournament) {
			$tournamentStart	= DateTime::createFromFormat('d/m/Y', $tournament['tournamentStart']);
			$tournamentEnd		= DateTime::createFromFormat('d/m/Y', $tournament['tournamentEnd']);
			$event = array(
				'data' => array(
					'id' => "tournament-".$tournament['tournamentID']
				),
				'title' => $tournament['name'],
				'start' => $tournamentStart->format("U"),
				'end' => $tournamentEnd->format("U"),
				'allDay' => true,
				'color' => $tournamentColour
			);
			if(isset($tournamentUrl))
				$event['url'] = $tournamentUrl.$tournament['tournamentID'];
			$this->data['data'][] = $event;
		}
		// Inserting all the registration periods
		if($showRegistration){
			foreach($tournaments as $tournament) {
				$registrationStart	= DateTime::createFromFormat('d/m/Y', $tournament['registrationStart']);
				$registrationEnd	= DateTime::createFromFormat('d/m/Y', $tournament['registrationEnd']);
				$event = array(
					'data' => array(
						'id' => "registration-".$tournament['tournamentID']
					),
					'title' => $tournament['name']." Registration Period",
					'start' => $registrationStart->format("U"),
					'end' => $registrationEnd->format("U"),
					'allDay' => true,
					'color' => $registrationColour
				);
				if(isset($registrationUrl))
					$event['url'] = $registrationUrl.$tournament['tournamentID'];
				$this->data['data'][] = $event;
			}
		}
		$this->data['data'] = json_encode($this->data['data']);
		header('Content-Type: application/json');
		$this->load->view('data',$this->data);
	}

	private function getAllMatches($url) {
		$query = array();
		$query['tournamentIDs'] = "none";
		$query['tournamentUrl'] = $url;
		$this->getEvents($query);
	}
	public function getAllTournaments($matchUrl,$tournamentUrl,$registrationUrl,$showTournamentMatchesOnly) {
		$query = array();
		$query['tournamentUrl']				= $tournamentUrl;
		$query['matchUrl']					= $matchUrl;
		$query['registrationUrl']			= $registrationUrl;
		$query['showTournamentMatchesOnly']	= $showTournamentMatchesOnly;
		$this->getEvents($query);
	}
	public function getAllTournamentsTMS() {
		$this->getAllTournaments("/tms/match/","/tms/tournament/","/tms/tournament/",false);
	}
	public function getAllTournamentsSIS() {
		$this->getAllTournaments("/sis/match/","/sis/tournament/","/sis/signup/",true);
	}
	public function getAllMatchesTMS() {
		$this->getAllMatches("/tms/match/");
	}
	public function getAllMatchesSIS() {
		$this->getAllMatches("/sis/match/");
	}
	public function getVenueMatchesTMS($venueID){
		$query = array();
		$query['tournamentIDs']		= "none";
		$query['venueIDs']			= array($venueID);
		$query['matchUrl']			= "/tms/match/";
		$this->getEvents($query);
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