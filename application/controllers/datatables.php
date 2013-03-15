<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Datatables extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('matches_model');
		$this->load->model('sports_model');
		$this->load->model('venues_model');
	}

	public function data($type) {
		// Define $action even if the use has just loaded the page
		$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "load";
		// Initialise the output array which will be jsonified to pass to datatables.
		$out = array (
			'id' => -1,
			'error' => '',
			'fieldErrors' => array (),
			'data' => array ()
		);
		// Different actions based on different ajax requests
		switch ($action) {
			case "load":
				// Load all objects of type from the correct model. Assume model named based on type exists. Eval is scary.
				eval('$allObjects = $this->'.$type.'_model->get_all();');
				// Loop through all objects, process them if required and add them to the output array as datatables rows
				foreach($allObjects as $id => $object) {
					// The DataTables row ID; eg. sports-8 or matches-332
					$object['DT_RowId'] = "$type-$id";
					// Format date/time objects for the public
					if(isset($object['startTime']) && isset($object['endTime'])) {
						$object['startTime'] = datetime_to_public($object['endTime']);
						$object['endTime'] = datetime_to_public($object['endTime']);
					}
					// Create / add to the aaData rows array, ready to be jsonified
					$aaData[] = $object;
				}
				// Finally add the aaData array to the output array
				$out['aaData'] = $aaData;
			break;
			case "create":
				$deleteOutput = false;
				$out = $deleteOutput ? array('id' => -1) : array('error' => "An error occurred. Please contact Infusion Systems.");
			break;
			case "edit":
				$deleteOutput = false;
				$out = $deleteOutput ? array('id' => -1) : array('error' => "An error occurred. Please contact Infusion Systems.");
			break;
			case "remove":
				// We should only ever have one row selected when delete is pressed, 
				// so data[0] from the input the type-ID string of the row which is being deleted
				$delete_type_id = explode('-',$_POST['data'][0]);
				$type = $delete_type_id[0];
				$ID = $delete_type_id[1];
				// Execute the delete function of the correct model with the second parameter set to false to confirm deletion
				eval('$deleteOutput = $this->'.$type.'_model->delete('.$ID.', false);'); 
				// Define the return value based on deletion success
				$out = $deleteOutput ? array('id' => -1) : array('error' => "An error occurred. Please contact Infusion Systems.");
			break;
		}

		// Send it back to the client, via our plain data dump view
		$this->data['data'] = json_encode($out);
		$this->load->view('data', $this->data);
	}
	
	// Show the user what *exactly* will happen when they click delete
	public function predelete($rowID) {
		// Get type/model and object ID from type-ID input string
		$type_id = explode('-',$rowID);
		$type = $type_id[0];
		$ID = $type_id[1];
		// Execute the delete function of the model for this input, which just does a trial run when the second parameter is omitted.
		eval('$deleteOutput = $this->'.$type.'_model->delete('.$ID.');');
		$this->data['dependencies'] = $deleteOutput;
		$this->load->view('tms/datatables-predelete.php',$this->data);
	}
}