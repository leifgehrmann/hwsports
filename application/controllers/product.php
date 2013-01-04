<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller {

	public function index() {
		$this->data['title'] = "Infusion Sports";
		$this->session->set_userdata('slug', 'product');
		
		$this->load->view('product/header',$this->data);
		$this->load->view('product/home',$this->data);
		$this->load->view('product/footer',$this->data);
	}

}