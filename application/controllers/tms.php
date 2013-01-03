<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tms extends CI_Controller {

	public function index()
	{
		$data = Array(
			'title' => "Home"
		);
		$this->load->view('tms/header',$data);
		$this->load->view('tms/home',$data);
		$this->load->view('tms/footer',$data);
	}

}