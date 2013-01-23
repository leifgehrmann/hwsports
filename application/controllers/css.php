<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Css extends MY_Controller {

	public function index($file)
	{
		$this->output->set_header("Content-Type: text/css"); 
		$this->load->view("css/{$this->data['slug']}/$file",$this->data);
	}
}