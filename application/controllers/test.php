<?php
class Test extends MY_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->load->model('sports_model');
	}
	public function get_sport_category($sportID){
		$output = $this->sports_model->get_sport_categories();
		$this->data['data'] =  json_encode($output);
		header('Content-Type: application/json');
		$this->load->view('data', $this->data);
	}

	public function get_sport($sportID){
		$output = $this->sports_model->get_sport($sportID);
		$this->data['data'] =  json_encode($output);
		$this->data['data'] =  print_r($output,1);
		header('Content-Type: application/json');
		$this->load->view('data', $this->data);
	}
}