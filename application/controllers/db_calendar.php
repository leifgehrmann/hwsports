<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Db_Calendar extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->library('table');



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
			$tournamentsAll = $this->tournaments_model->get_all();
			foreach ($tournamentsAll as $tournament )
				if($sportIDs=="all") // If we want only a particular sport
					$tournaments[] = $tournament;
				else
					if(in_array($tournament['sportID'],$sportIDs))
						$tournaments[] = $tournament;
		} else if($tournamentIDs=="none") {

		} else { // If we want only particular tournaments
			foreach ($tournamentIDs as $tournamentID ){
				$tournament = $this->tournaments_model->get($tournamentID);
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
			if($showTournamentMatchesOnly){
				foreach($tournaments as $tournamentID=>$tournament){
					$tournamentMatches = $this->matches_model->get_tournament_matches($tournamentID);
					if(!$tournamentMatches)
						continue;
					$matchesAll = $matchesAll + $tournamentMatches;
				}
			} else {
				$matchesAll = $this->matches_model->get_all();
			}
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
				$match = $this->matches_model->get($matchID);
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

			if(!$match) continue;

			$startTime	= new DateTime( $match['startTime'] );
			$endTime	= new DateTime( $match['endTime'] );

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
								' sportCategoryID-'.$match['sportData']['sportCategoryID']
			);
			if(isset($matchUrl))
				$event['url'] = $matchUrl.$match['matchID'];
			if(isset($matchEditable))
				$event['editable'] = $matchEditable;
			$this->data['data'][] = $event;
		}




		// Inserting all the tournament periods
		if($showTournaments){
			//var_dump($tournaments); die();
			foreach($tournaments as $tournament) {

				if(!$tournament) continue;

				$tournamentStart	= new DateTime($tournament['tournamentStart']);
				$tournamentEnd		= new DateTime($tournament['tournamentEnd']);

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
									' sportCategoryID-'.$tournament['sportData']['sportCategoryID']
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

				if(!$tournament) continue;

				$registrationStart	= new DateTime($tournament['registrationStart']);
				$registrationEnd	= new DateTime($tournament['registrationEnd']);

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
									' sportCategoryID-'.$tournament['sportData']['sportCategoryID']
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
	public function getVenueEventsTMS($venueID){
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
	public function getSportEventsTMS($sportID){
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
	 *        Methods used by fullcalendar to edit between the database
	 *
	 *
	 */

	public function move_event() {
		$eventVariableNames = array(
			'match' => array(
				'startTime' => 'startTime',
				'endTime' => 'endTime'
			),
			'tournament' => array(
				'startTime' => 'tournamentStart',
				'endTime' => 'tournamentEnd'
			),
			'registration' => array(
				'startTime' => 'registrationStart',
				'endTime' => 'registrationEnd'
			),
		);
		
		// Fullcalendar's post data "id" is in the format "eventType-ID" where ID is numeric.
		$val = $this->input->post('id');
		$secondsDelta = $this->input->post('secondsDelta');
		// Check if everything has been defined.
		if( !is_string($val) ) $this->$this->badRequest("ID not defined");
		if( !($secondsDelta && is_numeric($secondsDelta)) ) $this->$this->badRequest("secondsDelta is invalid");
		if( preg_match('~(match|tournament|registration)-[0-9]+~',$val) !== 1 ) $this->$this->badRequest("valid type and id not defined");
		// We have a valid val string, parse it into type and id
		list($eventType,$id) = explode("-",$val);
		// Fetch stuff from the database
		switch ($eventType) {
			case "match":
				$eventData = $this->matches_model->get($id);
				if($eventData['tournamentID']!=0) {
					$tournamentData = $this->tournaments_model->get($eventData['tournamentID']);
				}
				break;
			case "tournament":
				$eventData = $this->tournaments_model->get($id); 
				break;
			case "registration":
				$eventData = $this->tournaments_model->get($id); 
				break;
		}

		// Convert the time variables to datetime
		try {
			$oldStart = new DateTime( $eventData[$eventVariableNames[$eventType]['startTime']] );
			$oldEnd = new DateTime( $eventData[$eventVariableNames[$eventType]['endTime']] );
		} catch (Exception $e) {
			// Errof if the values are valid
			$this->$this->badRequest("Invalid date was fetched from the database. Debug Exception: ".$e->getMessage());
		}
		
		// Add the delta to the old times
		$newStart 	= $oldStart->modify("$secondsDelta seconds");
		$newEnd 	= $oldEnd->modify("$secondsDelta seconds");

		// Validate date ranges for each of the three handled event types
		switch ($eventType) {
			case "match":
				if($eventData['tournamentID']!=0) {
					try {
						// Convert the time variables to datetime
						$tournamentStart = new DateTime( $tournamentData['tournamentStart'] );
						$tournamentEnd = new DateTime( $tournamentData['tournamentEnd'] );
					} catch (Exception $e) {
						// Errof if the values are valid
						$this->$this->badRequest("Invalid tournament date was fetched from the database. Debug Exception: ".$e->getMessage());
					}
					if( $newStart < $tournamentStart ) $this->badRequest("Match cannot start before tournament");
					if( $tournamentEnd < $newEnd ) $this->badRequest("Match cannot end after tournament end");	
				}
				if( $newEnd < $newStart ) $this->badRequest("Match has imploded. Everybody died.");
			break;
			case "tournament":
				// Convert the time variables to datetime
				try {
					$registrationEnd = new DateTime( $eventData['registrationEnd'] );
				} catch (Exception $e) {
					// Errof if the values are valid
					$this->$this->badRequest("Invalid registration date was fetched from the database. Debug Exception: ".$e->getMessage());
				}
				
				if( $newStart < $registrationEnd ) $this->badRequest("Tournament cannot start before registration period has finished");
				if( $newEnd < $newStart ) $this->badRequest("Tournament has imploded. Everyone died.");
			break;
			case "registration":
				// Convert the time variables to datetime
				try {
					$tournamentStart = new DateTime( $eventData['tournamentStart'] );
				} catch (Exception $e) {
					// Errof if the values are valid
					$this->$this->badRequest("Invalid tournament date was fetched from the database. Debug Exception: ".$e->getMessage());
				}
				
				if( $tournamentStart < $newEnd ) $this->badRequest("Tournament cannot start before registration period has finished");
				if( $newEnd < $newStart ) $this->badRequest("Registration period has imploded. Everyone died.");
			break;
		}
		
		// Put the new start and new end datetimes back into string format and prepare array of database elements to update
		$data = array(
			$eventVariableNames[$eventType]['startTime'] => $newStart->format(DateTime::ISO8601),
			$eventVariableNames[$eventType]['endTime'] => $newEnd->format(DateTime::ISO8601)
		);
		
		// Perform the update, 
		switch($eventType) {
			case "match": 
				$updateResult = $this->matches_model->update($id,$data); 
			break;
			case "tournament": 
				$updateResult = $this->tournaments_model->update($id,$data); 
			break;
			case "registration": 
				$updateResult = $this->tournaments_model->update($id,$data); 
			break;
		}
		
		// For some reason, the model update failed
		if($updateResult===FALSE) $this->badRequest("$eventType update failed.");
		
		$this->data['data'] = "Updated $eventType $id";
		$this->load->view('data',$this->data);
	}

	// Basically do all the same things as moveEvent
	public function change_event_end() {
		$eventVariableNames = array(
			'match' => array(
				'startTime' => 'startTime',
				'endTime' => 'endTime'
			),
			'tournament' => array(
				'startTime' => 'tournamentStart',
				'endTime' => 'tournamentEnd'
			),
			'registration' => array(
				'startTime' => 'registrationStart',
				'endTime' => 'registrationEnd'
			),
		);
		
		// Fullcalendar's post data "id" is in the format "eventType-ID" where ID is numeric.
		$val = $this->input->post('id');
		$secondsDelta = $this->input->post('secondsDelta');
		// Check if everything has been defined.
		if( !is_string($val) ) $this->$this->badRequest("ID not defined");
		if( !($secondsDelta && is_numeric($secondsDelta)) ) $this->$this->badRequest("secondsDelta is invalid");
		if( preg_match('~(match|tournament|registration)-[0-9]+~',$val) !== 1 ) $this->$this->badRequest("valid type and id not defined");
		// We have a valid val string, parse it into type and id
		list($eventType,$id) = explode("-",$val);
		// Fetch stuff from the database
		switch ($eventType) {
			case "match":
				$eventData = $this->matches_model->get($id);
				if($eventData['tournamentID']!=0) {
					$tournamentData = $this->tournaments_model->get($eventData['tournamentID']);
				}
				break;
			case "tournament":
				$eventData = $this->tournaments_model->get($id); 
				break;
			case "registration":
				$eventData = $this->tournaments_model->get($id); 
				break;
		}

		// Convert the time variables to datetime
		try {
			$start = new DateTime( $eventData[$eventVariableNames[$eventType]['startTime']] );
			$oldEnd = new DateTime( $eventData[$eventVariableNames[$eventType]['endTime']] );
		} catch (Exception $e) {
			// Errof if the values are valid
			$this->$this->badRequest("Invalid date was fetched from the database. Debug Exception: ".$e->getMessage());
		}
		
		// Add the delta to the old time
		$newEnd = $oldEnd->modify("$secondsDelta seconds");

		// Validate date ranges for each of the three handled event types
		switch ($eventType) {
			case "match":
				if($eventData['tournamentID']!=0) {
					try {
						// Convert the time variables to datetime
						$tournamentStart = new DateTime( $tournamentData['tournamentStart'] );
						$tournamentEnd = new DateTime( $tournamentData['tournamentEnd'] );
					} catch (Exception $e) {
						// Errof if the values are valid
						$this->$this->badRequest("Invalid tournament date was fetched from the database. Debug Exception: ".$e->getMessage());
					}
					if( $newStart < $tournamentStart ) $this->badRequest("Match cannot start before tournament");
					if( $tournamentEnd < $newEnd ) $this->badRequest("Match cannot end after tournament");	
				}	
				if( $newEnd < $start ) $this->badRequest("Match has imploded. Everybody died.");
			break;
			case "tournament":
				// Convert the time variables to datetime
				try {
					$registrationEnd = new DateTime( $eventData['registrationEnd'] );
				} catch (Exception $e) {
					// Errof if the values are valid
					$this->$this->badRequest("Invalid registration date was fetched from the database. Debug Exception: ".$e->getMessage());
				}
				
				if( $start < $registrationEnd ) $this->badRequest("Tournament cannot start before registration period has finished");
				if( $newEnd < $start ) $this->badRequest("Tournament has imploded. Everyone died.");
			break;
			case "registration":
				// Convert the time variables to datetime
				try {
					$tournamentStart = new DateTime( $eventData['tournamentStart'] );
				} catch (Exception $e) {
					// Errof if the values are valid
					$this->$this->badRequest("Invalid tournament date was fetched from the database. Debug Exception: ".$e->getMessage());
				}
				
				if( $tournamentStart < $newEnd ) $this->badRequest("Tournament cannot start before registration period has finished");
				if( $newEnd < $start ) $this->badRequest("Registration period has imploded. Everyone died.");
			break;
		}
		
		// Put the new start and new end datetimes back into string format and prepare array of database elements to update
		$data = array(
			$eventVariableNames[$eventType]['endTime'] => $newEnd->format(DateTime::ISO8601)
		);
		
		// Perform the update, 
		switch($eventType) {
			case "match": 
				$updateResult = $this->matches_model->update($id,$data); 
			break;
			case "tournament": 
				$updateResult = $this->tournaments_model->update($id,$data); 
			break;
			case "registration": 
				$updateResult = $this->tournaments_model->update($id,$data); 
			break;
		}
		
		// For some reason, the model update failed
		if($updateResult===FALSE) $this->badRequest("$eventType update failed.");
		
		$this->data['data'] = "Updated $eventType $id";
		$this->load->view('data',$this->data);
	}
	
	// Output error message to ajax and finish execution
	public function badRequest($errorString) {
		// All the header nonsense was unnecessary, we're just doing basic string checking in the javascript instead
		$errorString = "Error:\n\n$errorString\n";
		die($errorString);
	}
}
?>