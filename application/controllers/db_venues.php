<?php
class Db_venues extends MY_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->load->model('venues_model');
	}

	/*

		Andrew is probably going to read this and go... WTF is Leif
		DOING??? Well Andrew, I'm creating a controller than can be
		used via jQuery. This will hopefully make interactions much
		easier to handle by offering JSON I/O with client/server.

		Perhaps we won't need this in the end, but I'd like to use
		ajax for updating venue data from a venue page, instead of 
		using a form to update each individual detail.

	*/
	
	public function get_venues()
	{
		$output = $this->venues_model->get_venues($this->data['centre']['centreID']);
		$this->data['data'] =  json_encode($output);
		header('Content-Type: application/json');
		$this->load->view('data', $this->data);
	}

	/**
	 *	This method takes in form data which is going to be sent into
	 * 	the database. If it works, it will return JSON file with the value:
	 *
	 * 	var data = {"success": true, "message": "The venue was created."}
	 *
	 * 	If not, that means either the database is messed up, or more
	 *  likely, the validation was incorrect. In the case of DB errors:
	 *
	 *	var data = {"success": false, "message": "There was a database error."}
	 *
	 *	And in the case of incorrect form details:
	 *
	 *	var data = {
	 *				"success": false,
	 *				"message": "There was an error in your form.", 
	 * 				"errors":[{
	 *					"name":"the input element name", 
	 *					"message":"Why it is wrong" 
	 *				} ] 
	 *	}
	 *
	 *	NOTE: FOR NOW IT WILL SIMPLE PRINT OUT THE validation_errors(); NOT THE
	 *  INDIVIDUAL ERRORS FOR EACH ELEMENT. SO THEREFORE:
	 *
	 *	var data = {
	 *				"success": false, 
	 *				"message": "There was an error in your form.", 
	 * 				"errors": "messages" 
	 *	}
	 * 	
	 *
	 */
	public function insert_venue()
	{
		// Create the output variable that will be converted
		// into JSON in the end.
		$output = array();
		$output['success'] = false;

		// Is the use authorized? We might want to make this into a shortcut later
		// because we need to make sure that the staff of one centre cannot
		// access the controls of another centre.

		if ( $this->ion_auth->in_group('admin') || $this->ion_auth->in_group('centreadmin') ) {

			// Which data parameters are we expecting form the post data?
			$formNames = array('name','description','directions','lat','lng');
			$formLabels = array('Name','Description','Directions','Latitude','longitude');
			$formRules = array('required','required','required','required','required');
			$formLength = min(count($formNames),count($formLabels),count($formRules));
			for ($i = 0; $i < $formLength; $i++) {
				$this->form_validation->set_rules($formNames[$i], $formLabels[$i], $formRules[$i]);
			}

			// Does the form validate?
			if ($this->form_validation->run() == true) {

				$data = array();
				for ($i = 0; $i < $formLength; $i++) {
					$data[$formNames[$i]] = $_POST[$formNames[$i]];
				}

				if($this->venues_model->insert_venue($this->data['centre']['centreID'],$data)>=0){
					$output['success'] = true;
					$output['message'] = 'The venue was created.';
				} else {
					$output['message'] = 'There was a database error.';
				}
				
			} else {
				$output['message'] = 'There was an error in your form.';
				$output['errors'] = validation_errors();
			}
		} else {
			$output['message'] = 'You are not authorized to view this page.';
		}

		// data should go out here
		$this->data['data'] = json_encode($output);
		header('Content-Type: application/json');
		$this->load->view('data', $this->data);
	}

	/**
	 *	This method takes in form data which is going to be sent into
	 * 	the database. If it works, it will return JSON file with the value:
	 *
	 * 	var data = {"success": true, "message": "The venue was updated."}
	 *
	 * 	If not, that means either the database is messed up, or more
	 *  likely, the validation was incorrect. In the case of DB errors:
	 *
	 *	var data = {"success": false, "message": "There was a database error."}
	 *
	 *	And in the case of incorrect form details:
	 *
	 *	var data = {
	 *				"success": false,
	 *				"message": "There was an error in your form.", 
	 * 				"errors":[{
	 *					"name":"the input element name", 
	 *					"message":"Why it is wrong" 
	 *				} ] 
	 *	}
	 *
	 *	NOTE: FOR NOW IT WILL SIMPLE PRINT OUT THE validation_errors(); NOT THE
	 *  INDIVIDUAL ERRORS FOR EACH ELEMENT. SO THEREFORE:
	 *
	 *	var data = {
	 *				"success": false, 
	 *				"message": "There was an error in your form.", 
	 * 				"errors": "messages" 
	 *	}
	 * 	
	 *
	 */
	public function update_venue($venueID)
	{
		// Create the output variable that will be converted
		// into JSON in the end.
		$output = array();
		$output['success'] = false;

		// Is the use authorized? We might want to make this into a shortcut later
		// because we need to make sure that the staff of one centre cannot
		// access the controls of another centre.

		if ( $this->ion_auth->in_group('admin') || $this->ion_auth->in_group('centreadmin') ) {

			// Which data parameters are we expecting form the post data?
			$formNames = array('name','description','directions','lat','lng');
			$formLabels = array('Name','Description','Directions','Latitude','longitude');
			$formRules = array('required','required','required','required','required');
			$formLength = min(count($formNames),count($formLabels),count($formRules));
			for ($i = 0; $i < $formLength; $i++) {
				if(isset($_POST[$formNames[$i]])){
					$this->form_validation->set_rules($formNames[$i], $formLabels[$i], $formRules[$i]);
				}
			}

			// Does the form validate?
			if ($this->form_validation->run() == true) {

				$data = array();
				for ($i = 0; $i < $formLength; $i++) {
					if(isset($_POST[$formNames[$i]])){
						$data[$formNames[$i]] = $_POST[$formNames[$i]];
					}
				}

				if($this->venues_model->update_venue($venueID,$data)){
					$output['success'] = true;
					$output['message'] = 'The venue was updated.';
				} else {
					$output['message'] = 'There was a database error.';
				}
				
			} else {
				$output['message'] = 'There was an error in your form.';
				$output['errors'] = validation_errors();
			}
		} else {
			$output['message'] = 'You are not authorized to view this page.';
		}
		// data should go out here
		$this->data['data'] = json_encode($output);
		header('Content-Type: application/json');
		$this->load->view('data', $this->data);
	}
}