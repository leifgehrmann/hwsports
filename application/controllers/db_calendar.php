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
		A method which takes in a series of parameters
		specified in $query. See the results in 
	*/
	private function getEvents($query) {

		$centreID					= $this->data['centre']['centreID'];
		$matchUrl					= null;		// If not specified, no url is given. Else, id of match is given
		$tournamentUrl				= null;		// If not specified, no url is given. Else, id of tournament is given
		$registrationUrl			= null;		// If not specified, no url is given. Else, id of tournament is given
		$matchIDs					= "all";	// array() of ids, "all" or "none"
		$tournamentIDs				= "all";	// array() of ids, "all" or "none"
		$sportIDs					= "all";	// array() of ids, "all" or "none"
		$venueIDs					= "all";	// array() of ids, "all" or "none"
		$showTournaments			= true;		// show tournament period?
		$showRegistrations			= true;		// show registration period?
		$showTournamentMatchesOnly	= false;	// show matches for tournaments only?
		$tournamentEditable			= null;		// Should the tournament period be editable?
		$registrationEditable		= null;		// Should the registration period be editable?
		$matchEditable				= null;		// Should the match be editable?
		/*$tournamentColour			= 'rgb(123, 209,  72)'; // Colour of tournament periods
		$registrationColour			= 'rgb(250,  87,  60)'; // Colour of registration periods
		$matchColour				= '#2966C7';			// Colour of matches.*/

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
		if(array_key_exists('venueIDs',$query))
			$venueIDs 					= $query['venueIDs'];
		if(array_key_exists('showTournament',$query))
			$showTournaments 			= $query['showTournaments'];
		if(array_key_exists('showRegistration',$query))
			$showRegistrations 			= $query['showRegistrations'];
		if(array_key_exists('showTournamentMatchesOnly',$query))
			$showTournamentMatchesOnly 	= $query['showTournamentMatchesOnly'];
		if(array_key_exists('tournamentEditable',$query))
			$tournamentEditable 		= $query['tournamentEditable'];
		if(array_key_exists('registrationEditable',$query))
			$registrationEditable 		= $query['registrationEditable'];
		if(array_key_exists('matchEditable',$query))
			$matchEditable 		= $query['matchEditable'];

		// These arrays contain the list of tournaments and matches.
		$tournaments 		= array();
		$matches 			= array();

		// We select all the tournaments with the appropriate sport.
		if($tournamentIDs=="all"){ // If we want all tournaments
			$tournamentsAll = $this->tournaments_model->get_tournaments($centreID);
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
			$startTime	= DateTime::createFromFormat(DATE_TIME_FORMAT, $tournament['startTime']);
			$endTime	= DateTime::createFromFormat(DATE_TIME_FORMAT, $tournament['endTime']);

			// If we encounter a syntax error in the dates...
			if(empty($startTime) || empty($endTime))
					continue;

			$event = array(
				'data' => array(
					'id' => "match-".$match['matchID']
				),
				'title' => $match['name'],
				'start' => $startTime->format("U"),
				'end' => $endTime->format("U"),
				'allDay' => false,
				'className' => 	'match'.
								' matchID-'.$match['matchID'].
								' venueID-'.$match['venueID'].
								' sportID-'.$match['sportID'].
								' tournamentID-'.$match['tournamentID'].
								' sportCategoryID-'.$match['sportCategoryID']
			);
			if(isset($matchUrl))
				$event['url'] = $matchUrl.$match['matchID'];
			if(isset($matchEditable))
				$event['editable'] = $matchEditable;
			$this->data['data'][] = $event;
		}




		// Inserting all the tournament periods
		if($showTournaments){
			foreach($tournaments as $tournament) {
				$tournamentStart	= DateTime::createFromFormat(DATE_FORMAT, $tournament['tournamentStart']);
				$tournamentEnd		= DateTime::createFromFormat(DATE_FORMAT, $tournament['tournamentEnd']);

				// If we encounter a syntax error in the dates...
				if(empty($tournamentStart) || empty($tournamentEnd))
					continue;

				$event = array(
					'data' => array(
						'id' => "tournament-".$tournament['tournamentID']
					),
					'title' => $tournament['name'],
					'start' => $tournamentStart->format("U"),
					'end' => $tournamentEnd->format("U"),
					'allDay' => true,
					'className' => 	'tournament'.
									' sportID-'.$tournament['sportID'].
									' tournamentID-'.$tournament['tournamentID'].
									' sportCategoryID-'.$tournament['sportCategoryID']
				);
				if(isset($tournamentUrl))
					$event['url'] = $tournamentUrl.$tournament['tournamentID'];
				if(isset($tournamentEditable))
					$event['editable'] = $tournamentEditable;
				$this->data['data'][] = $event;
			}
		}



		// Inserting all the registration periods
		if($showRegistrations){
			foreach($tournaments as $tournament) {
				$registrationStart	= DateTime::createFromFormat(DATE_FORMAT, $tournament['registrationStart']);
				$registrationEnd	= DateTime::createFromFormat(DATE_FORMAT, $tournament['registrationEnd']);

				// If we encounter a syntax error in the dates...
				if(empty($registrationStart) || empty($registrationEnd))
					continue;
				
				$event = array(
					'data' => array(
						'id' => "registration-".$tournament['tournamentID']
					),
					'title' => $tournament['name']." Registration Period",
					'start' => $registrationStart->format("U"),
					'end' => $registrationEnd->format("U"),
					'allDay' => true,
					'className' => 	'registration'.
									' sportID-'.$tournament['sportID'].
									' tournamentID-'.$tournament['tournamentID'].
									' sportCategoryID-'.$tournament['sportCategoryID']
				);
				if(isset($registrationUrl))
					$event['url'] = $registrationUrl.$tournament['tournamentID'];
				if(isset($registrationEditable))
					$event['editable'] = $registrationEditable;
				$this->data['data'][] = $event;
			}
		}





		// Return the data to output
		$this->data['data'] = json_encode($this->data['data']);
		header('Content-Type: application/json');
		$this->load->view('data',$this->data);
	}










	/**
	 *
	 *
	 *        Below are tailored methods to be used by fullcalendar
	 *
	 *
	 */

	// This is for /tms/calendar/
	// Returns all the matches, tournaments and registration periods
	public function getAllEventsTMS() {
		$query = array();
		// We specify where the urls go
		$query['tournamentUrl']		= "/tms/tournament/";
		$query['matchUrl']			= "/tms/match/";
		$query['registrationUrl']	= "/tms/tournament/";
		$this->getEvents($query);
	}

	// This is for /sis/calendar/
	// Return only tournament matches
	public function getAllTournamentEventsSIS() {
		$query = array();
		// We specify where the urls go
		$query['tournamentUrl']		= "/sis/tournament/";
		$query['matchUrl']			= "/sis/match/";
		$query['registrationUrl']	= "/sis/signup/";
		// We also only show tournament matches
		$query['showTournamentMatchesOnly']	= true;
		$this->getEvents($query);
	}

	// This is for /tms/venue/$venueID
	// Returns the matches for particular venue
	public function getVenueMatchesTMS($venueID){
		$query = array();
		$query['tournamentIDs']		= "none";
		$query['venueIDs']			= array($venueID);
		$query['matchUrl']			= "/tms/match/";
		$this->getEvents($query);
	}

	// This is for /tms/tournament/$tournamentID
	// Returns the matches and periods for the particular tournament
	public function getTournamentEventsTMS($tournamentID){
		$query = array();
		$query['tournamentIDs']		= array($tournamentID);
		$query['matchUrl']			= "/tms/match/";
		$this->getEvents($query);
	}

	// This is for /sis/tournament/$tournamentID
	// Returns the matches and periods for the particular tournament
	public function getTournamentEventsSIS($tournamentID){
		$query = array();
		$query['tournamentIDs']		= array($tournamentID);
		$query['registrationUrl']	= "/sis/signup/";
		$query['matchUrl']			= "/sis/match/";
		$this->getEvents($query);
	}

	// This is for /tms/sport/$sportID
	// returns the matches which are associated with this particular sport
	public function getSportMatchesTMS($sportID){
		$query = array();
		$query['showRegistrations']	= false;
		$query['showTournaments']	= false;
		$query['sportIDs']			= array($sportID);
		$query['matchUrl']			= "/tms/match/";
		$this->getEvents($query);
	}


















	/**
	 *
	 *
	 *        Method used by fullcalendar to edit between the database
	 *
	 *
	 */



	public function changeMatchStart() {

		$id 	= null;
		$type	= null;
		$updateResult;

		if(!isset($_POST['id'])){
			$this->data['data'] = "Error: id not defined";
		} else {
			$val = $_POST['id'];
			if(strrpos($val,"match-")!=-1)				list($type,$id) = explode("-",$val);
			else if(strrpos($val,"tournament-")!=-1)	list($type,$id) = explode("-",$val);
			else if(strrpos($val,"registration-")!=-1)	list($type,$id) = explode("-",$val);
			else $this->data['data'] = "Error: valid type and id not defined";

			switch ($type) {
				// In this case we deal with unix timestamps
				case "match":
					$matchData = $this->matches_model->get_match($id);
					$oldStartTime		= $matchData['startTime'];
					$oldEndTime			= $matchData['endTime'];
					$data = array();
					$data['startTime']	= $oldStartTime	+	$_POST['minutesDelta'];
					$data['endTime']	= $oldEndTime	+	$_POST['minutesDelta'];
					$updateResult = $this->matches_model->update_match($id,$data);
					break;
				// In this case we deal with d/m/Y
				case "tournament":
					
					break;
				// In this case we deal with d/m/Y
				case "registration":
					
					break;
				default:
					break;
			}
		}

		if(isset($updated))
			$this->data['data'] = (
				$updateResult ? 
				"Updated ".$type." ".$id : 
				"Error updating ".$type." ".$id
			);
		$this->load->view('data',$this->data);

		/*$matchData = $this->matches_model->get_match($_POST['id']);
		$oldStartTime = $matchData['startTime'];
		$newStartTime = $oldStartTime+$_POST['minutesDelta'];
		$updateResult = $this->matches_model->update_match($_POST['id'],array('startTime'=>$newStartTime));
		$this->data['data'] = ($updateResult ? "Success!" : "False!");
		$this->load->view('data',$this->data);*/
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