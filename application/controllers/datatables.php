<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Datatables extends MY_Controller {

	function __construct() {
		parent::__construct();
		
		$this->load->model('tournaments_model');
		$this->load->model('matches_model');
		$this->load->model('sports_model');
		$this->load->model('venues_model');
		$this->load->model('users_model');
		$this->load->model('teams_model');
	}

	public function sports() {
		$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "load";
		$out = array (
				'id' => -1,
				'error' => '',
				'fieldErrors' => array (
								 ),
				'data' => array (
						  ),
			   );

		switch ($action) {
			case "load":
				$sports = $this->sports_model->get_all();
				$aaData = array();
				foreach($sports as $id => $sport) {
					$sport['DT_RowId'] = $id;
					$aaData[] = $sport;
				}
				$out['aaData'] = $aaData;
			break;
			case "create":
				$sports = $this->sports_model->get_all();
				$out['error'] = $sports;
			break;
			case "edit":
				$newdata = $_POST['data'];
				$out['error'] = $newdata;
			break;
			case "remove": 
				//src='/datatables/sports?action=jspredelete&id={$_POST['data'][0]['id']}
				$out['error'] = "<script type='text/javascript'>$.fancybox({content:'hello',beforeShow:func});</script>";
			break;
		}

		// Send it back to the client, via our plain data dump view
		$this->data['data'] = json_encode($out);
		$this->load->view('data', $this->data);
	}
	
	public function predelete($model_id) {
		$modelid = explode('_',$model_id);
		$model = $modelid[0];
		$ID = $modelid[1];
		eval("\$this->data['dependencies'] = \$this->{$model}_model'->delete({$ID});");
		$this->load->view('tms/datatables-predelete.php',$this->data);
	}
}