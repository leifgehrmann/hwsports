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
	}
	public function get_all_users($centreID){
		$output = $this->users_model->get_users($centreID);
		$this->display($output);
	}
	public function get_all_teams($centreID){
		$output = $this->teams_model->get_teams($centreID);
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

	public function get_sport($sportID){
		$output = $this->sports_model->get_sport($sportID);
		$this->display($output);
	}

	public function get_tournament($tID){
		$output = $this->tournaments_model->get_tournament($tID);
		$this->display($output);
	}
	public function get_tournaments($centreID){
		$output = $this->tournaments_model->get_tournaments($centreID);
		$this->display($output);
	}

	public function get_matches($centreID){
		$output = $this->matches_model->get_matches($centreID);
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

	public function test_constants(){
		$output = array(APPPATH,SYSDIR,BASEPATH,ENVIRONMENT,SELF,FCPATH,EXT);
		$this->display($output);
	}
	
	// Eg. http://hwsports.co.uk/test/datetime_to_public/2013-03-04%2003%3A51
	// Should (in theory) output 2013-03-04 03:51 (which is basically just the exact same as the input
	// the idea here is to make sure it doesn't change the date or time in conversion to/from DateTime object	 
	public function datetime_to_public($dateInputStr){
		$dateInputStr = urldecode($dateInputStr);
		$output = datetime_to_public($dateInputStr);
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