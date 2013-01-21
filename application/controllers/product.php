<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends MY_Controller {

	public function index() {
		$this->data['title'] = "Infusion Sports";
		$this->data['page'] = "product";
		
		$this->load->view('product/header',$this->data);
		$this->load->view('product/home',$this->data);
		$this->load->view('product/footer',$this->data);
	}
	public function screenshots() {
		$this->data['title'] = "Screenshots | Infusion Sports";
		$this->data['page'] = "screenshots";
		
		$this->load->view('product/header',$this->data);
		$this->load->view('product/screenshots',$this->data);
		$this->load->view('product/footer',$this->data);
	}
}