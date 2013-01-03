<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller {

	public function index()
	{
		$data = Array(
			'title' => "Infusion Sports"
		);
		$this->load->view('product/header',$data);
		$this->load->view('product/home',$data);
		$this->load->view('product/footer',$data);
	}

}