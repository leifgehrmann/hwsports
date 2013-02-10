<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Css extends MY_Controller {

	public function index()
	{
		// get path segments as interpreted by CI routing
		$segments = $this->uri->segment_array();
		
		// get rid of "css" from path
		$key = array_search("css",$segments);
		unset( $segments[$key] );
		$path = implode("/",$segments);
		
		if( strpos($path,".css" !== false) ) {
			$this->output->set_header("Content-Type: text/css");
			$this->load->view("css/{$this->data['slug']}/$path",$this->data);
		} else {
			echo $path;
			readfile("css/{$this->data['slug']}/$path");
		}
	}
}