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
		$this->print($output);
	}
	public function get_all_teams($centreID){
		$output = $this->teams_model->get_teams($centreID);
		$this->print($output);
	}
	public function get_sport_category_roles($sportID){
		$output = $this->sports_model->get_sport_category_roles($sportID);
		$this->print($output);
	}

	public function get_sport_category($sportID){
		$output = $this->sports_model->get_sport_categories();
		$this->print($output);
	}

	public function get_sport($sportID){
		$output = $this->sports_model->get_sport($sportID);
		$this->print($output);
	}

	public function get_tournament($tID){
		$output = $this->tournaments_model->get_tournament($tID);
		$this->print($output);
	}
	public function get_tournaments($centreID){
		$output = $this->tournaments_model->get_tournaments($centreID);
		$this->print($output);
	}

	public function get_matches($centreID){
		$output = $this->matches_model->get_matches($centreID);
		$this->print($output);
	}

	public function test_constants(){
		$output = array(APPPATH,SYSDIR,BASEPATH,ENVIRONMENT,SELF,FCPATH,EXT);
		$this->print($output);
	}

	private function print($output){
		$this->data['data'] =  print_r($output,1);
		header('Content-Type: text/plain');
		$this->load->view('data', $this->data);
	}
}