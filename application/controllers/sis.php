<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sis extends CI_Controller {

	public function index()
	{
		// Page title
		$this->data['title'] = "Home";
		
		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		
		$this->data['currentUser'] = $this->ion_auth->user();
		
		$this->load->view('sis/header',$this->data);
		$this->load->view('sis/home',$this->data);
		$this->load->view('sis/footer',$this->data);
	}

}