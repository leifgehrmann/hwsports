<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Front extends CI_Controller {

	public function index()
	{
		$data = Array(
			'title' => "Home"
		);
		$this->load->view('sis/header',$data);
		$this->load->view('sis/home',$data);
		$this->load->view('sis/footer',$data);
	}

}