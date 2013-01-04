<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Css extends CI_Controller {

	public function load($file)
	{
		$this->output->set_header("Content-Type: text/css"); 
		$this->load->view("css/{$this->session->userdata('slug')}/$file");
	}
}