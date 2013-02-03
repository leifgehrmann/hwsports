<?php
class Test extends MY_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->load->model('sports_model');
	}
	public function sport_exists($sportID){
		$output = $this->sports_model->sport_exists($sportID);
		$this->data['data'] =  json_encode($output);
		header('Content-Type: application/json');
		$this->load->view('data', $this->data);
	}
}