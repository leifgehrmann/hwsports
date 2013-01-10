<?php
class Venues extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->load->model('venues');
	}

	public function getVenues($centreID)
	{
		$output = $this->venues->getVenues();
		echo print_r($output);
		
	}