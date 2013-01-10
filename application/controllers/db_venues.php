<?php
class Db_venues extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->load->model('venues_model');
	}

	public function getVenues($centreID)
	{
		$output = $this->venues_model->get_venues($centreID);

		echo print_r($output);

	}
}