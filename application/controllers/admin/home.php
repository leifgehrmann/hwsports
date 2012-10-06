<?php
class Home extends MY_Admin_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
		$this->load->view('admin_view');
    }

}
?>