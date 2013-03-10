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
		header('Content-Type: text/plain');
	}
	
	//
	// GENERIC testing function, can be used to execute any function in any model with either a single basic argument or a serialized array of arguments  
	// Basic example usage, get a single match with ID 18: 
	// 		http://hwsports.co.uk/test/model/matches_model/get/18
	// For complex examples, use the testing helper ;) http://hwsports.co.uk/test/helper
	// 	
	public function model($model,$action,$args="") {
		$args = json_decode(rawurldecode(html_entity_decode($args)),true);
		//$this->display($args);
		if(is_array($args)) {
			$argstring = implode(', ',$args);
			$eval = '$output = $this->'.$model.'->'.$action.'('.$argstring.');';
		} else {
			$eval = '$output = $this->'.$model.'->'.$action.'('.$args.');';
		}
		echo("Eval string: ".$eval."\n\n");
		eval($eval);
		$this->display($output);
	}
	
	public function helper() {
		header('Content-Type: text/html');
		$str = ( isset($_POST['str']) ? $_POST['str'] : '' );
		$model = ( isset($_POST['model']) ? $_POST['model'] : '' );
		$function = ( isset($_POST['function']) ? $_POST['function'] : '' );
		
		echo "<h1>Test Helper</h1>
				<form id='testhelperform' method='post' action='/test/helper'>
					Model: <input id='model' type='text' name='model' value='$model' /><br />
					Function: <input id='function' type='text' name='function' value='$function' /><br />
					Input: <br />
					<span style='text-decoration: italic'>To pass multiple arguments to the function, create an array() with multiple parameters. <br />
					To pass an array as one of the parameters, create the array but put that in single quotes. An example with two array parameters has been inserted into the textarea for you.</span><br />
					<textarea name='str' id='str' style='height: 100pt' rows='1' cols='50'>";
					if(isset($_POST['str'])) echo $str; 
					else echo 'array(
								\'array("hello"=>"world")\',
								\'array("sportID"=>8)\'
								)';
					echo "</textarea><br />
					<input type='submit' name='exec' value='Execute'></form><br />
				</form><br />";
					
		if(isset($_POST['str'])) {
			if($_POST['str']!=='') {
				eval("\$evalstr = $str;");
				$encoded = rawurlencode(json_encode($evalstr));
			} else {
				$encoded = '';
			}
			echo "Test Link: <br /><a id='link' target='_blank' href='/test/model/$model/$function/$encoded'>/test/model/$model/$function/$encoded</a><br />
				<script>document.getElementById('link').click()</script>";
		}
	}

	// Try: http://hwsports.co.uk/test/schedule_football_family/37
	public function schedule_football_family($tournamentID){
		$output = $this->scheduling_model->schedule_football_family($tournamentID);
		$this->display($output);
	}
	// Try: http://hwsports.co.uk/test/get_match_date_times/2013-03-14T10%3A30%3A00%2B0000/2013-03-20T10%3A30%3A00%2B0000
	public function get_match_date_times($tournamentStart,$tournamentEnd){
		$interval = new DateInterval('PT30M');
		$start = new DateTime(urldecode($tournamentStart));
		$end   = new DateTime(urldecode($tournamentEnd));
		$matchWeekdayStartTimes = array();
		$matchWeekdayStartTimes['Monday'] = array('10:00','10:00','16:00');
		$matchWeekdayStartTimes['Tuesday'] = array('12:00','10:00','16:00');
		$matchWeekdayStartTimes['Wednesday'] = array('10:00','13:00','16:00');
		$matchWeekdayStartTimes['Thursday'] = array('14:00','10:00','16:00');
		$matchWeekdayStartTimes['Sunday'] = array('19:00','10:00','10:00');
		$output = $this->scheduling_model->get_match_date_times($start,$end,$matchWeekdayStartTimes,$interval);
		$this->display($output);
	}
	// Try: http://hwsports.co.uk/test/get_dates/2013-03-14T10%3A30%3A00%2B0000/2013-03-20T10%3A30%3A00%2B0000
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
		$this->load->view('data', $this->data);
	}
}