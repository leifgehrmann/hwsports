<?php
class Venues extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->load->model('venues');
	}

	public function getVenues($centreID)
	{
		$output = $this->venues->getVenues($centreID);

		$this->load->view('tms/header',$this->data);
		echo print_r($output);
		$this->load->view('tms/footer',$this->data);

	}
}