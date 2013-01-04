<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sis extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}
	public function index($slug) {
		// Set session variables based on domain name we are at (domain slug such as hwsports provides centre name etc)
		$this->session->set_userdata('slug', $slug);


		// Sports Centre ID
		$query = $this->db->query("SELECT `centreID` FROM `centreData` WHERE `key` = 'slug' AND `value` = '$slug' LIMIT 1");
		$row = $query->row_array(); $centreID = $row['centreID'];
		$this->session->set_userdata('centreID', $centreID);


		// Get sports centre data
		// Perhaps we should create a helper object

		$query = $this->db->query("SELECT " .
			"MAX(CASE WHEN `key`='name' THEN value END ) AS name, " .
			"MAX(CASE WHEN `key`='address' THEN value END ) AS address, " .
			"MAX(CASE WHEN `key`='legalText' THEN value END ) AS legalText, " .
			"MAX(CASE WHEN `key`='shortName' THEN value END ) AS shortName " .
			"FROM centreData WHERE centreID = $centreID"
		);
		$row = $query->row_array();
		$this->session->set_userdata('centreName', $row['name']);
		$this->session->set_userdata('centreAddress', $row['address']);
		$this->session->set_userdata('centreShortName', $row['shortName']);
		$this->session->set_userdata('centreLegalText', $row['legalText']);

		// Page title
		$this->data['title'] = "Home";
		$this->data['page'] = "home";
		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		
		$this->data['currentUser'] = $currentUser = $this->ion_auth->user()->row();
		if(!empty($currentUser)) {
			$query = $this->db->query("SELECT `key`,`value` FROM `userData` WHERE `userID` = '{$currentUser->id}'");
			foreach($query->result_array() as $userDataRow) {
				$currentUser->$userDataRow['key'] = $userDataRow['value'];
			}
		}
		
		$this->load->view('sis/header',$this->data);
		$this->load->view('sis/home',$this->data);
		$this->load->view('sis/footer',$this->data);
	}

	public function whatson()
	{
		// Page title
		$this->data['title'] = "What's On";
		$this->data['page'] = "whatson";
		$this->load->view('sis/header',$this->data);
		$this->load->view('sis/whatson',$this->data);
		$this->load->view('sis/footer',$this->data);
	}

	public function calendar()
	{
		// Page title
		$this->data['title'] = "Calendar";
		$this->data['page'] = "calendar";
		$this->load->view('sis/header',$this->data);
		$this->load->view('sis/calendar',$this->data);
		$this->load->view('sis/footer',$this->data);
	}
	public function tournaments()
	{
		// Page title
		$this->data['title'] = "Tournaments";
		$this->data['page'] = "tournaments";
		$this->load->view('sis/header',$this->data);
		$this->load->view('sis/tournaments',$this->data);
		$this->load->view('sis/footer',$this->data);
	}
	public function help()
	{
		// Page title
		$this->data['title'] = "Help";
		$this->data['page'] = "help";
		$this->load->view('sis/header',$this->data);
		$this->load->view('sis/help',$this->data);
		$this->load->view('sis/footer',$this->data);
	}

}