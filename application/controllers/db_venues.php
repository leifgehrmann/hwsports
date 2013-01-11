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

		Example, if the user wants to change the name or any other 
		field, they would have to reload the page to see their updates.
		If we instead use jQuery, the database can be updated immedietly
		and not annoy the customer.
		
		
		We need to make sure that every function cannot be accessed
		from users who do not have to correct creditials. This can
		be done using ion-auth (checking if they are admin or staff
		and if they are at the correct centre).

		

	*/
	public function venue_exists($venueID){
		$output = $this->venues_model->venue_exists($venueID);
		$this->data['data'] =  "var data = ".json_encode($output);

		$this->load->view('data', $this->data);
	}

	// 
	public function get_venues()
	{
		$output = $this->venues_model->get_venues($this->data['centre']['id']);
		$this->data['data'] =  "var data = ".json_encode($output);

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
					$row = array(
						'key' => $formNames[$i],
						'value' => $this->input->post($formNames[$i])
					);
					$data[] = $row;
				}

				if($this->venues_model->insert_venues($this->data['centre']['id'],$data)>=0){
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
		$this->data['data'] = "var data = ".json_encode($output);
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
	public function update_venue()
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
					$row = array(
						'key' => $formNames[$i],
						'value' => $this->input->post($formNames[$i])
					);
					$data[] = $row;
				}

				if($this->venues_model->update_venues($this->data['centre']['id'],$data)>=0){
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
		$this->data['data'] = "var data = ".json_encode($output);
		$this->load->view('data', $this->data);
	}
}