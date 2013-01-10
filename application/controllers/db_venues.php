<?php
class Db_venues extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->load->model('venues_model');
	}

	public function getVenues($centreID)
	{
		$output = $this->venues_model->get_all_venues_data($centreID);
		foreach ($output as $data) {
			echo "\n<br/><br/>\n$venueID\n<br/>\n<br/>";
			foreach ($data as $key=>$value) {
        		echo "<br/>$key = $value\n<br/>";
    		}
		}
		//echo print_r($output);

	}
}