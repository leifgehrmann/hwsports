<?php
class Test extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('sports_model');
		$this->load->model('tournaments_model');
		$this->load->model('matches_model');
		$this->load->model('teams_model');
		$this->load->model('users_model');
		$this->load->model('scheduling_model');
	}
	
	/*
		users_model
	*/
	public function get_all_users($centreID){
		$output = $this->users_model->get_users($centreID);
		$this->display($output);
	}
	public function user_exists($userID){
		$output = $this->users_model->user_exists($userID);
		$this->display($output);
	}

	// For example: http://hwsports.co.uk/test/update_user/34/%7B%22poop%22%3A%22smells%22%7D
	// that web address updates userData to add "poop" = "smells" to user ID 34
	public function update_user($userID,$dataJSON){
		$dataJSON = urldecode($dataJSON);
		$data = json_decode($dataJSON);
		$output = $this->users_model->update_user($userID,$data);
		$this->display($output);
	}
	/*
		centre_model
	*/
	/*
		matches_model
	*/
	public function get_matches($centreID){
		$output = $this->matches_model->get_matches($centreID);
		$this->display($output);
	}
	public function get_venue_matches($venueID,$start,$end){
		$output = $this->matches_model->get_venue_matches($userID,$start,$end);
		$this->display($output);
	}
	/*
		results_model
	*/

	/*
		scheduling_model
	*/
	public function get_match_date_times($tournamentStart,$tournamentEnd){
		$start;
		$start = new DateTime(urldecode($tournamentStart));
		$end   = new DateTime(urldecode($tournamentEnd));
		$matchWeekdayStartTimes = array();
		$matchWeekdayStartTimes['Monday'] = array('10:00'=>array(),'10:00'=>array(),'16:00'=>array());
		$matchWeekdayStartTimes['Tuesday'] = array('12:00'=>array(),'10:00'=>array(),'16:00'=>array());
		$matchWeekdayStartTimes['Wednesday'] = array('10:00'=>array(),'10:00'=>array(),'16:00'=>array());
		$matchWeekdayStartTimes['Thursday'] = array('14:00'=>array(),'10:00'=>array(),'16:00'=>array());
		$matchWeekdayStartTimes['Sunday'] = array('19:00'=>array(),'10:00'=>array(),'10:00'=>array());
		$output = $this->scheduling_model->get_dates($start,$end,$matchWeekdayStartTimes,$interval);
		$this->display($output);
	}
	public function get_dates($start,$end){
		$start = new DateTime(urldecode($start));
		$end   = new DateTime(urldecode($end));
		$output = $this->scheduling_model->get_dates($start,$end);
		$this->display($output);
	}
	public function round_robin(){
		$teams = array();
		$output = $this->scheduling_model->round_robin($teams);
		$this->display($output);
		$teams = array('1');
		$output = $this->scheduling_model->round_robin($teams);
		$this->display($output);
		$teams = array('1','2');
		$output = $this->scheduling_model->round_robin($teams);
		$this->display($output);
		$teams = array('1','2','3');
		$output = $this->scheduling_model->round_robin($teams);
		$this->display($output);
		$teams = array('1','2','3','4','5','6','7','8');
		$output = $this->scheduling_model->round_robin($teams);
		$this->display($output);
	}
	public function alternate_items(){
		$items = array();
		$output = $this->scheduling_model->alternate_items($items);
		$this->display($output);
		$items = array('1');
		$output = $this->scheduling_model->alternate_items($items);
		$this->display($output);
		$items = array('1','2');
		$output = $this->scheduling_model->alternate_items($items);
		$this->display($output);
		$items = array('1','2','3');
		$output = $this->scheduling_model->alternate_items($items);
		$this->display($output);
		$items = array('1','2','3','4','5','6','7','8');
		$output = $this->scheduling_model->alternate_items($items);
		$this->display($output);
	}
	public function is_overlapping( $startTimeA, $startTimeB ){
		$interval = new DateInterval('P30M');
		$startA = new DateTime($startTimeA);
		$startB   = new DateTime($startTimeB);
		$output = $this->scheduling_model->is_overlapping($startA,$interval,$startB,$interval);
		$this->display($output);
	}
	public function get_weekday_string(){
		$output = "";
		for($i=-10;$i<10;$i++){
			$output.= $i." ";
			$output.= $this->scheduling_model->get_weekday_string($i)." \n";
		}
		$this->display($output);
	}
	public function get_weekday_index(){
		$output = "";
		$output.= $this->scheduling_model->get_weekday_index("Monday")." \n";
		$output.= $this->scheduling_model->get_weekday_index("tuesday")." \n";
		$output.= $this->scheduling_model->get_weekday_index("wednesday")." \n";
		$output.= $this->scheduling_model->get_weekday_index("thu")." \n";
		$output.= $this->scheduling_model->get_weekday_index("f")." \n";
		$output.= $this->scheduling_model->get_weekday_index("saturday")." \n";
		$output.= $this->scheduling_model->get_weekday_index("Sunday")." \n";
		$output.= $this->scheduling_model->get_weekday_index("Mon")." \n";
		$output.= $this->scheduling_model->get_weekday_index("tue")." \n";
		$output.= $this->scheduling_model->get_weekday_index("Wed")." \n";
		$this->display($output);
	}
	/*
		sports_model
	*/
	public function get_sport($sportID){
		$output = $this->sports_model->get_sport($sportID);
		$this->display($output);
	}
	public function get_sport_category_roles($sportID){
		$output = $this->sports_model->get_sport_category_roles($sportID);
		$this->display($output);
	}
	public function get_sport_category($sportID){
		$output = $this->sports_model->get_sport_categories();
		$this->display($output);
	}
	/*
		teams_model
	*/
	public function get_all_teams($centreID){
		$output = $this->teams_model->get_teams($centreID);
		$this->display($output);
	}
	/*
		tournaments_model
	*/
	public function get_tournament($tID){
		$output = $this->tournaments_model->get_tournament($tID);
		$this->display($output);
	}
	public function get_tournaments($centreID){
		$output = $this->tournaments_model->get_tournaments($centreID);
		$this->display($output);
	}
	/*
		venues_model
	*/
	

	public function test_constants(){
		$output = array(APPPATH,SYSDIR,BASEPATH,ENVIRONMENT,SELF,FCPATH,EXT);
		$this->display($output);
	}
	
	// Eg. http://hwsports.co.uk/test/datetime_to_public/2013-03-04%2003%3A51
	// Should (in theory) output 2013-03-04 03:51 (which is basically just the exact same as the input
	// the idea here is to make sure it doesn't change the date or time in conversion to/from DateTime object	 
	public function test_datetime_to_public($dateInputStr){
		$dateInputStr = urldecode($dateInputStr);
		$output = datetime_to_public($dateInputStr);
		$this->display($output);
	}
	
	// Eg. http://hwsports.co.uk/test/test_datetime_to_standard/2013-03-04%2003%3A51
	// Should (in theory) output 2013-03-04 03:51 (which is basically just the exact same as the input
	// the idea here is to make sure it doesn't change the date or time in conversion to/from DateTime object	 
	public function test_datetime_to_standard($dateInputStr){
		$dateInputStr = urldecode($dateInputStr);
		$output = datetime_to_standard($dateInputStr);
		$this->display($output);
	}

	public function display($output){
		ob_start();
		var_dump($output);
		$this->data['data'] = ob_get_clean();
		header('Content-Type: text/plain');
		$this->load->view('data', $this->data);
	}
}