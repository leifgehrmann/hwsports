<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Front extends CI_Controller {

	public function index()
	{
		$data = Array(
			'title' => "Home"
		);
		$this->load->view('templates/header',$data);
		$this->load->view('landingPage',$data);
		$this->load->view('templates/footer',$data);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
