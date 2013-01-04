<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Css extends MY_Controller {

	public function load($slug)
	{
		$this->output->set_header("Content-Type: text/css"); 
		$this->load->view("css/$slug/".$this->uri->rsegment(5));
	}
}