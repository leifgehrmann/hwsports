<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sis extends CI_Controller {

	public function index($slug)
	{
		// Page title
		$this->data['title'] = "Home";
		
		$this->session->set_userdata('slug', $slug);
		$query = $this->db->query("SELECT `centreID` FROM `centreData` WHERE `key` = 'slug' AND `value` = '$slug' LIMIT 1");
		$row = $query->row_array();
		$this->session->set_userdata('centreID', $row['centreID']);
		
		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		
		$this->data['currentUser'] = $this->ion_auth->user();
		
		$this->load->view('sis/header',$this->data);
		$this->load->view('sis/home',$this->data);
		$this->load->view('sis/footer',$this->data);
	}

}