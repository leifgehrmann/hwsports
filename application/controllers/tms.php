<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tms extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if ( $this->ion_auth->in_group('admin') || $this->ion_auth->in_group('centreadmin') ) {
			$this->data['currentUser'] = $currentUser = $this->ion_auth->user()->row();
			$query = $this->db->query("SELECT `key`,`value` FROM `userData` WHERE `userID` = '{$currentUser->id}'");
			foreach($query->result_array() as $userDataRow) {
				$currentUser->$userDataRow['key'] = $userDataRow['value'];
			}
		} else {
			//redirect them to the sms homepage
			redirect('/', 'refresh');
		}
	}
	public function index($slug)
	{
		$this->data['slug'] = $slug;
		$this->data['title'] = "Home";
		$this->load->view('tms/header',$this->data);
		$this->load->view('tms/home',$this->data);
		$this->load->view('tms/footer',$this->data);
	}

}