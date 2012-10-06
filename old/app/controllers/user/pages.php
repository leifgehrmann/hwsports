<?php
class Pages extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->load->model('web_model');
	}

	public function view($page = 'home')
	{				
		if ( ! file_exists('app/views/pages/'.$page.'.php'))
		{
			// Whoops, we don't have a page for that!
			show_404();
		}
		
		$data['title'] = "HWSports: ".ucfirst($page); // Capitalize the first letter
		$data['page'] = $page;
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer', $data);

	}
	
	
	public function print_session() 
	{
		$data['debug'] = $this->session->all_userdata();
		$this->load->view('pages/debug', $data);
	}
	
	public function get_session() 
	{
		$data['data'] = json_encode($this->session->all_userdata());
		$this->load->view('pages/data', $data);
	}
	
	public function set_session() 
	{
		if ($this->uri->segment(2) !== FALSE) {
			$json = urldecode($this->uri->segment(2));
			//$data['debug']['urlseg2'] = $json;
			$array = json_decode($json, true);
			//$data['debug']['jsondecoded'] = $array;
			$this->session->set_userdata($array);
			//$this->load->view('pages/debug', $data);
		}
	}
}

?>
