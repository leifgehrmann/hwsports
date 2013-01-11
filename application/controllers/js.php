<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Js extends MY_Controller {

	public function index($file)
	{				
		if ( ! file_exists('app/views/scripts/'.$file.'.js'))
		{
			// Whoops, we don't have a page for that!
			show_404();
		}
		
		$this->output->set_header("Content-Type: text/javascript"); 
		$this->load->view('scripts/'.$file.'.js');
	}
}