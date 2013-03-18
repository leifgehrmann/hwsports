<?php
class Testmodelloading extends MY_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		echo "index loaded";
		var_dump($this->users_model->get_all());
	}
}