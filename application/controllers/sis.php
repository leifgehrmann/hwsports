<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sis extends CI_Controller {

	public function index()
	{
		$user = $this->ion_auth->user();
		$data = Array(
			'title' => "Home",
			'currentUser' => $user
		);
		$this->load->view('sis/header',$data);
		$this->load->view('sis/home',$data);
		$this->load->view('sis/footer',$data);
	}

}