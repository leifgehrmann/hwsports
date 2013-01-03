<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sis extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}
	public function index($slug)
	{
		// Page title
		$this->data['title'] = "Homepage";
		
		$this->session->set_userdata('slug', $slug);
		$query = $this->db->query("SELECT `centreID` FROM `centreData` WHERE `key` = 'slug' AND `value` = '$slug' LIMIT 1");
		$row = $query->row_array(); $centreID = $row['centreID'];
		$this->session->set_userdata('centreID', $centreID);
		
		$query = $this->db->query("SELECT `value` FROM `centreData` WHERE `centreID` = '$centreID' AND `key` = 'name' LIMIT 1");
		$row = $query->row_array();
		$this->session->set_userdata('centreName', $row['value']);
		$query = $this->db->query("SELECT `value` FROM `centreData` WHERE `centreID` = '$centreID' AND `key` = 'shortName' LIMIT 1");
		$row = $query->row_array();
		$this->session->set_userdata('centreShortName', $row['value']);
		
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

	public function whatson($slug)
	{
		// Page title
		$this->data['title'] = "What's On";
		$this->load->view('sis/header',$this->data);
		$this->load->view('sis/whatson',$this->data);
		$this->load->view('sis/footer',$this->data);
	}

}