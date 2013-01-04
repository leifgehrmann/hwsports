<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tms extends MY_Controller {

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
	public function index()
	{
		$this->data['title'] = "Home";
		$this->data['page'] = "tmshome";
		$this->load->view('tms/header',$this->data);
		$this->load->view('tms/home',$this->data);
		$this->load->view('tms/footer',$this->data);
	}
	public function tournaments()
	{
		$this->data['title'] = "Tournaments";
		$this->data['page'] = "tournaments";
		$this->load->view('tms/header',$this->data);
		$this->load->view('tms/tournaments',$this->data);
		$this->load->view('tms/footer',$this->data);
	}
	public function venues()
	{
		$this->data['title'] = "Venues";
		$this->data['page'] = "venues";
		$this->load->view('tms/header',$this->data);
		$this->load->view('tms/venues',$this->data);
		$this->load->view('tms/footer',$this->data);
	}
	public function sports()
	{
		$this->data['title'] = "Sports";
		$this->data['page'] = "sports";
		$this->load->view('tms/header',$this->data);
		$this->load->view('tms/sports',$this->data);
		$this->load->view('tms/footer',$this->data);
	}
	public function matches()
	{
		$this->data['title'] = "Matches";
		$this->data['page'] = "matches";
		$this->load->view('tms/header',$this->data);
		$this->load->view('tms/matches',$this->data);
		$this->load->view('tms/footer',$this->data);
	}
	public function groups()
	{
		$this->data['title'] = "Groups";
		$this->data['page'] = "groups";
		$this->load->view('tms/header',$this->data);
		$this->load->view('tms/groups',$this->data);
		$this->load->view('tms/footer',$this->data);
	}
	public function users()
	{
		$this->data['title'] = "Users";
		$this->data['page'] = "users";
		$this->load->view('tms/header',$this->data);
		$this->load->view('tms/users',$this->data);
		$this->load->view('tms/footer',$this->data);
	}
	public function news()
	{
		$this->data['title'] = "News";
		$this->data['page'] = "news";
		$this->load->view('tms/header',$this->data);
		$this->load->view('tms/news',$this->data);
		$this->load->view('tms/footer',$this->data);
	}
	public function tickets()
	{
		$this->data['title'] = "Tickets";
		$this->data['page'] = "tickets";
		$this->load->view('tms/header',$this->data);
		$this->load->view('tms/tickets',$this->data);
		$this->load->view('tms/footer',$this->data);
	}
	public function reports()
	{
		$this->data['title'] = "Reports";
		$this->data['page'] = "reports";
		$this->load->view('tms/header',$this->data);
		$this->load->view('tms/reports',$this->data);
		$this->load->view('tms/footer',$this->data);
	}

}