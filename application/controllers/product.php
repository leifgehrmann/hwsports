<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller {

	public function index($slug) {
		$this->data['title'] = "Infusion Sports";
		$this->data['slug'] = $slug;
		$this->session->set_userdata('slug', $slug);
		
		$this->load->view('product/header',$this->data);
		$this->load->view('product/home',$this->data);
		$this->load->view('product/footer',$this->data);
	}

}