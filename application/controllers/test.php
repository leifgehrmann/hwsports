<?php
class Test extends MY_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->load->model('sports_model');
	    $this->load->model('tournaments_model');
	    $this->load->model('matches_model');
	}
	public function get_sport_category_roles($sportID){
		$output = $this->sports_model->get_sport_category_roles($sportID);
		$this->data['data'] =  print_r($output,1);
		header('Content-Type: application/json');
		$this->load->view('data', $this->data);
	}

	public function get_sport_category($sportID){
		$output = $this->sports_model->get_sport_categories();
		$this->data['data'] =  print_r($output,1);
		header('Content-Type: application/json');
		$this->load->view('data', $this->data);
	}

	public function get_sport($sportID){
		$output = $this->sports_model->get_sport($sportID);
		$this->data['data'] =  print_r($output,1);
		header('Content-Type: application/json');
		$this->load->view('data', $this->data);
	}

	public function get_tournament($tID){
		$output = $this->tournaments_model->get_tournament($tID);
		$this->data['data'] =  print_r($output,1);
		header('Content-Type: application/json');
		$this->load->view('data', $this->data);
	}
	public function get_tournaments($centreID){
		$output = $this->tournaments_model->get_tournaments($centreID);
		$this->data['data'] =  print_r($output,1);
		header('Content-Type: application/json');
		$this->load->view('data', $this->data);
	}

	public function get_matches($centreID){
		$output = $this->matches_model->get_matches($centreID);
		$this->data['data'] =  print_r($output,1);
		header('Content-Type: application/json');
		$this->load->view('data', $this->data);
	}

	public function test_constants(){
		$output = array(APPPATH,SYSDIR,BASEPATH,ENVIRONMENT,SELF,FCPATH,EXT);
		$this->data['data'] =  print_r($output,1);
		header('Content-Type: text/plain');
		$this->load->view('data', $this->data);
	}
}