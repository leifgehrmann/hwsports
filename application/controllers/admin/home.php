<?php
class Home extends Admin_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
		$this->load->view('admin_view');
    }

}
?>