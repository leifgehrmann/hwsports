<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->helper('url');

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
	}

	/**
	 * A short hand method to basically print out the page with a certain pageid and title
	 *
	 * @param view 		The view to load
	 * @param page 		The page ID it will have
	 * @param title 	
	 * @param data 		passed in data
	 */
	public function view($view,$page,$title,$data){
		$data['title'] = $title;
		$data['page'] = $page;
		$this->load->view('sis/header',$data);
		$this->load->view($view,$data);
		$this->load->view('sis/footer',$data);
	}
	
	//redirect if needed, otherwise display the user list
	function list_users()
	{
		// Page title
		$this->data['title'] = "User List";
		$this->data['page'] = "userlist";
		
		if(!$this->ion_auth->is_admin())
		{
			//redirect them to the home page because they must be an administrator to view this
			redirect('/', 'refresh');
		}
		else
		{
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			//list the users
			$this->data['users'] = $this->ion_auth->users()->result();
			foreach ($this->data['users'] as $k => $user)
			{
				$this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->userID)->result();
			}
					
			$this->load->view('sis/header',$this->data);
			$this->load->view('auth/index', $this->data);
			$this->load->view('sis/footer',$this->data);
		}
	}

	//log the user in
	function login()
	{
		$this->data['title'] = "Login";
		$this->data['page'] = "login";

		$this->load->library('user_agent');
		if ($this->agent->is_referral() && ($this->session->userdata('login_referrer') == FALSE) ) {
			$this->session->set_userdata('login_referrer', $this->agent->referrer());
		}
		
		//validate form input
		$this->form_validation->set_rules('identity', 'Identity', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == true)
		{
			//check to see if the user is logging in
			//check for "remember me"
			$remember = (bool) $this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				
				/*if($this->ion_auth->in_group('admin') || $this->ion_auth->in_group('centreadmin')){
					redirect('/tms', 'refresh');
				} else {*/
				
					// Login success, take them back to the page they were on before the login
					redirect($this->session->userdata('login_referrer'), 'refresh');
				//}
			}
			else
			{
				//if the login was un-successful
				//redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('/auth/login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		}
		else
		{
			//the user is not logging in so display the login page
			//set the flash data error message if there is one
			$this->data['message'] = $this->session->flashdata('message');
			$this->data['message_information'] = $this->session->flashdata('message_information');
			$this->data['message_success'] = $this->session->flashdata('message_success');
			$this->data['message_warning'] = $this->session->flashdata('message_warning');
			$this->data['message_error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message_error');

			$this->data['identity'] = array('name' => 'identity',
				'id' => 'identity',
				'type' => 'text',
				'value' => $this->form_validation->set_value('identity'),
			);
			$this->data['password'] = array('name' => 'password',
				'id' => 'password',
				'type' => 'password',
			);

			$this->load->view('sis/header',$this->data);
			$this->load->view('auth/login', $this->data);
			$this->load->view('sis/footer',$this->data);
		}
	}

	//log the user out
	function logout()
	{
		//log the user out
		$logout = $this->ion_auth->logout();

		//redirect them to the login page
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect('/', 'refresh');
	}

	//change password
	function change_password()
	{
		// Page title
		$this->data['title'] = "Change Password";
		$this->data['page'] = "changepassword";
		
		$this->form_validation->set_rules('old', 'Old password', 'required');
		$this->form_validation->set_rules('new', 'New Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
		$this->form_validation->set_rules('new_confirm', 'Confirm New Password', 'required');

		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}

		$user = $this->ion_auth->user()->row();

		if ($this->form_validation->run() == false)
		{
			//display the form
			//set the flash data error message if there is one
			$this->data['message_error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message_error');

			$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
			$this->data['old_password'] = array(
				'name' => 'old',
				'id'   => 'old',
				'type' => 'password',
			);
			$this->data['new_password'] = array(
				'name' => 'new',
				'id'   => 'new',
				'type' => 'password',
				'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
			);
			$this->data['new_password_confirm'] = array(
				'name' => 'new_confirm',
				'id'   => 'new_confirm',
				'type' => 'password',
				'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
			);
			$this->data['user_id'] = array(
				'name'  => 'user_id',
				'id'    => 'user_id',
				'type'  => 'hidden',
				'value' => $user->userID,
			);

			//render
			
			$this->load->view('sis/header',$this->data);
			$this->load->view('auth/change_password', $this->data);
			$this->load->view('sis/footer',$this->data);
		}
		else
		{
			$identity = $this->session->userdata($this->config->item('identity', 'ion_auth'));

			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

			if ($change)
			{
				//if the password was successfully changed
				$this->session->set_flashdata('message_success', $this->ion_auth->messages());
				redirect('sis/account', 'refresh');
			}
			else
			{
				$this->session->set_flashdata('message_error', $this->ion_auth->errors());
				redirect('auth/change_password', 'refresh');
			}
		}
	}

	//forgot password
	function forgot_password()
	{
		// Page title
		$this->data['title'] = "Forgotten Password";
		$this->data['page'] = "forgotpassword";
		
		$this->form_validation->set_rules('email', 'Email Address', 'required');
		if ($this->form_validation->run() == false)
		{
			//setup the input
			$this->data['email'] = array('name' => 'email',
				'id' => 'email',
			);

			if ( $this->config->item('identity', 'ion_auth') == 'username' ){
				$this->data['identity_label'] = 'Username';	
			}
			else
			{
				$this->data['identity_label'] = 'Email';	
			}
			
			//set any errors and display the form
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			
			$this->load->view('sis/header',$this->data);
			$this->load->view('auth/forgot_password', $this->data);
			$this->load->view('sis/footer',$this->data);
		}
		else
		{
			// get identity for that email
			$config_tables = $this->config->item('tables', 'ion_auth');
			if($this->users_model->find_by_email($this->input->post('email'))) {
				//run the forgotten password method to email an activation code to the user
				if( $this->ion_auth->forgotten_password($this->input->post('email')) ) {
					//if there were no errors
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					redirect("auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
				} else {
					$this->session->set_flashdata('message', $this->ion_auth->errors());
					redirect("auth/forgot_password", 'refresh');
				}
			} else {
				$this->session->set_flashdata('message', 'This email does not exist in the database. Please try again.');
				redirect("auth/forgot_password", 'refresh');
			}
		}
	}

	//reset password - final step for forgotten password
	public function reset_password($code = NULL)
	{
		// Page title
		$this->data['title'] = "Reset Password";
		$this->data['page'] = "resetpassword";
		
		if (!$code)
		{
			show_404();
		}

		$user = $this->ion_auth->forgotten_password_check($code);

		if ($user)
		{
			//if the code is valid then display the password reset form

			$this->form_validation->set_rules('new', 'New Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', 'Confirm New Password', 'required');

			if ($this->form_validation->run() == false)
			{
				//display the form

				//set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				$this->data['new_password'] = array(
					'name' => 'new',
					'id'   => 'new',
				'type' => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
				);
				$this->data['new_password_confirm'] = array(
					'name' => 'new_confirm',
					'id'   => 'new_confirm',
					'type' => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
				);
				$this->data['user_id'] = array(
					'name'  => 'user_id',
					'id'    => 'user_id',
					'type'  => 'hidden',
					'value' => $user->userID,
				);
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['code'] = $code;

				//render
				$data = Array(
					'title' => "Auth"
				);
				$this->load->view('sis/header',$this->data);				
				$this->load->view('auth/reset_password', $this->data);
				$this->load->view('sis/footer',$this->data);
			}
			else
			{
				// finally change the password
				$identity = $user->{$this->config->item('identity', 'ion_auth')};

				$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

				if ($change)
				{
					//if the password was successfully changed
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					$this->logout();
				}
				else
				{
					$this->session->set_flashdata('message', $this->ion_auth->errors());
					redirect('auth/reset_password/' . $code, 'refresh');
				}
			}
		}
		else
		{
			//if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/forgot_password", 'refresh');
		}
	}


	//activate the user
	function activate($id, $code=false)
	{
		if ($code !== false)
		{
			$activation = $this->ion_auth->activate($id, $code);
		}
		else if ($this->ion_auth->is_admin())
		{
			$activation = $this->ion_auth->activate($id);
		}

		if ($activation)
		{
			//redirect them to the auth page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("auth/login", 'refresh');
		}
		else
		{
			//redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/forgot_password", 'refresh');
		}
	}

	//deactivate the user
	function deactivate($id = NULL)
	{
		// Page title
		$this->data['title'] = "Deactivate User";
		$this->data['page'] = "deactivateuser";
		
		$id = $this->config->item('use_mongodb', 'ion_auth') ? (string) $id : (int) $id;

		$this->load->library('form_validation');
		$this->form_validation->set_rules('confirm', 'confirmation', 'required');
		$this->form_validation->set_rules('id', 'user ID', 'required|alpha_numeric');

		if ($this->form_validation->run() == FALSE)
		{
			// insert csrf check
			$this->data['csrf'] = $this->_get_csrf_nonce();
			$this->data['user'] = $this->ion_auth->user($id)->row();

			
			$this->load->view('sis/header',$this->data);
			$this->load->view('auth/deactivate_user', $this->data);
			$this->load->view('sis/footer',$this->data);
		}
		else
		{
			// do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes')
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
				{
					show_error('This form post did not pass our security checks.');
				}

				// do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->ion_auth->deactivate($id);
				}
			}

			//redirect them back to the auth page
			redirect('auth', 'refresh');
		}
	}

	//create a new user account
	function register() {
		//validate form input
		$this->form_validation->set_rules('firstName', 'First Name', 'required|xss_clean');
		$this->form_validation->set_rules('lastName', 'Last Name', 'required|xss_clean');
		$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');

		if ($this->form_validation->run() == true) {
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			$centreID = $this->data['centre']['centreID'];

			$userdata = array(
				'firstName' => $this->input->post('firstName'),
				'lastName'  => $this->input->post('lastName')
			);
			
			$userID = $this->users_model->register($email, $password, $userdata);
			if($userID) {
				// Successful creation, show success message
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("/auth/login", 'refresh');
			}
		}
	
		//display the create user form
		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		$this->data['firstName'] = array(
			'name'  => 'firstName',
			'id'    => 'firstName',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('firstName'),
		);
		$this->data['lastName'] = array(
			'name'  => 'lastName',
			'id'    => 'lastName',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('lastName'),
		);
		$this->data['email'] = array(
			'name'  => 'email',
			'id'    => 'email',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('email'),
		);
		$this->data['password'] = array(
			'name'  => 'password',
			'id'    => 'password',
			'type'  => 'password',
			'value' => $this->form_validation->set_value('password'),
		);
		$this->data['password_confirm'] = array(
			'name'  => 'password_confirm',
			'id'    => 'password_confirm',
			'type'  => 'password',
			'value' => $this->form_validation->set_value('password_confirm'),
		);

		$this->view('auth/register','register','Registration',$this->data);
	}

	//edit a user
	function edit_user()
	{	
		if (!$this->ion_auth->logged_in())
		{
			redirect('/', 'refresh');
		}

		$userDetailsForm = array(
			array(
				'name'=>'firstName',
				'label'=>'First Name',
				'restrict'=>'required|xss_clean',
				'type'=>'text'
			),
			array(
				'name'=>'lastName',
				'label'=>'Last Name',
				'restrict'=>'required|xss_clean',
				'type'=>'text'
			),
			array(
				'name'=>'phone',
				'label'=>'Phone',
				'restrict'=>'xss_clean|min_length[8]|max_length[12]',
				'type'=>'text'
			),
			array(
				'name'=>'address',
				'label'=>'Address',
				'restrict'=>'xss_clean',
				'type'=>'text'
			),
			array(
				'name'=>'aboutMe',
				'label'=>'Bio',
				'restrict'=>'xss_clean',
				'type'=>'text'
			)
		);
		$emergencyDetailsForm = array(
			array(
				'name'=>'emergencyName',
				'label'=>'Name',
				'restrict'=>'required|xss_clean',
				'type'=>'text'
			),
			array(
				'name'=>'emergencyEmail',
				'label'=>'Email',
				'restrict'=>'required|valid_email',
				'type'=>'text'
			),
			array(
				'name'=>'emergencyPhone',
				'label'=>'Phone',
				'restrict'=>'required|xss_clean|min_length[8]|max_length[12]',
				'type'=>'text'
			),
			array(
				'name'=>'emergencyAddress',
				'label'=>'Address',
				'restrict'=>'required|xss_clean',
				'type'=>'text'
			)
		);

		$this->data['user'] = $this->currentUser = $this->users_model->get_logged_in();
		if($user===FALSE) {
			$this->session->set_flashdata('message_error',  "User ID $userID does not exist.");
			redirect("/tms/users", 'refresh');
		}
		// We validate the data from the form
		$newdata = $_POST;
		// For each of the input types we will validate it.
		$submitValue = $this->input->post('submit');
		if($submitValue == 'Update User'){
			foreach($userDetailsForm as $input){
				$this->form_validation->set_rules($input['name'], $input['label'], $input['restrict']);
			}
		} else if ($submitValue == 'Update Emergency Contact'){
			foreach($emergencyDetailsForm as $input){
				$this->form_validation->set_rules($input['name'], $input['label'], $input['restrict']);
			}
		}
		if ($submitValue!=FALSE && $this->form_validation->run() == true) {
			if($this->users_model->update($userID, $newdata)) {
				// Successful update, show success message
				$this->session->set_flashdata('message_success',  'Successfully updated user.');
			} else {
				$this->session->set_flashdata('message_error',  'Failed to update user. Please contact Infusion Systems.');
			}
			redirect("/tms/user/$userID", 'refresh');
		}

		foreach(array($userDetailsForm, $emergencyDetailsForm) as $form){
			foreach($form as $input){
				if(array_key_exists('type',$input)){
					$this->data[$input['name']] = array(
						'name'  => $input['name'],
						'id'    => $input['name'],
						'type'  => $input['type'],
						'value' => $this->form_validation->set_value($input['type'], (isset($user[$input['name']]) ? $user[$input['name']] : ''))
					);
					if($input['name']=="description"){
						$this->data[$input['name']]['style'] = 'width:100%;';
						$this->data[$input['name']]['rows'] = '5';
					}
				}
			}
		}

		$this->data['title'] = "Edit Profie";
		$this->data['page'] = "edituser";

		//validate form input
		//$this->form_validation->set_rules('firstName', 'First Name', 'required|xss_clean');
		//$this->form_validation->set_rules('lastName', 'Last Name', 'required|xss_clean');
		//$this->form_validation->set_rules('phone', 'Third Part of Phone', 'required|xss_clean|min_length[8]|max_length[12]');
		
		/*if (isset($_POST) && !empty($_POST))
		{
			// do we have a valid request?
			if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
			{
				show_error('This form post did not pass our security checks.');
			}

			$data = array(
				'firstName' => $this->input->post('firstName'),
				'lastName'  => $this->input->post('lastName'),
				'phone'      => $this->input->post('phone')
			);
			
			//Update the groups user belongs to
			$groupData = $this->input->post('groups');
			
			if (isset($groupData) && !empty($groupData)) {
				 
				$this->ion_auth->remove_from_group('', $id);
				
				foreach ($groupData as $grp) {					
					$this->ion_auth->add_to_group($grp, $id);
				}
				
			}

			//update the password if it was posted
			if ($this->input->post('password'))
			{
				$this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');

				$data['password'] = $this->input->post('password');
			}

			if ($this->form_validation->run() === TRUE)
			{
				$this->ion_auth->update($user->userID, $data);

				//check to see if we are creating the user
				//redirect them back to the admin page
				$this->session->set_flashdata('message', "User Saved");
				redirect("auth", 'refresh');
			}
		}

		//display the edit user form
		$this->data['csrf'] = $this->_get_csrf_nonce();

		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		//pass the user to the view
		$this->data['user'] = $user;
		$this->data['groups'] = $groups;
		$this->data['currentGroups'] = $currentGroups;
		
		$this->data['firstName'] = array(
			'name'  => 'firstName',
			'id'    => 'firstName',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('firstName', $user->firstName),
		);
		$this->data['lastName'] = array(
			'name'  => 'lastName',
			'id'    => 'lastName',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('lastName', $user->lastName),
		);
		$this->data['phone'] = array(
			'name'  => 'phone',
			'id'    => 'phone',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('phone', $user->phone),
		);
		$this->data['password'] = array(
			'name' => 'password',
			'id'   => 'password',
			'type' => 'password'
		);
		$this->data['password_confirm'] = array(
			'name' => 'password_confirm',
			'id'   => 'password_confirm',
			'type' => 'password'
		);

		$data = Array(
			'title' => "Auth"
		);*/
		$this->load->view('sis/header',$this->data);		
		$this->load->view('auth/edit_user', $this->data);
		$this->load->view('sis/footer',$this->data);
	}

	// create a new group
	function create_group()
	{
		$this->data['title'] = "Create Group";

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}

		//validate form input
		$this->form_validation->set_rules('group_name', 'Group name', 'required|alpha_dash|xss_clean');
		$this->form_validation->set_rules('description', 'Description', 'xss_clean');

		if ($this->form_validation->run() == TRUE)
		{
			$new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
			if($new_group_id)
			{
				// check to see if we are creating the group
				// redirect them back to the admin page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("auth", 'refresh');
			}
		}
		else
		{
			//display the create group form
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['group_name'] = array(
				'name'  => 'group_name',
				'id'    => 'group_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('group_name'),
			);
			$this->data['description'] = array(
				'name'  => 'description',
				'id'    => 'description',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('description'),
			);

			
			$this->load->view('sis/header',$this->data);
			$this->load->view('auth/create_group', $this->data);
			$this->load->view('sis/footer',$this->data);
		}
	}

	//edit a group
	function edit_group($id)
	{
		// bail if no group id given
		if(!$id || empty($id))
		{
			redirect('auth', 'refresh');
		}

		$this->data['title'] = "Edit Group";

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}

		$group = $this->ion_auth->group($id)->row();

		//validate form input
		$this->form_validation->set_rules('group_name', 'Group name', 'required|alpha_dash|xss_clean');
		$this->form_validation->set_rules('group_description', 'Group Description', 'xss_clean');

		if (isset($_POST) && !empty($_POST))
		{
			if ($this->form_validation->run() === TRUE)
			{
				$group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);

				if($group_update)
				{
					$this->session->set_flashdata('message', "Group Saved");
				}
				else
				{
					$this->session->set_flashdata('message', $this->ion_auth->errors());
				}
				redirect("auth", 'refresh');
			}
		}

		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		//pass the user to the view
		$this->data['group'] = $group;

		$this->data['group_name'] = array(
			'name'  => 'group_name',
			'id'    => 'group_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('group_name', $group->name),
		);
		$this->data['group_description'] = array(
			'name'  => 'group_description',
			'id'    => 'group_description',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('group_description', $group->description),
		);

		$this->load->view('sis/header',$this->data);
		$this->load->view('auth/edit_group', $this->data);
		$this->load->view('sis/footer',$this->data);
	}

	function delete_user($deleteid)
	{
		$user = $this->ion_auth->user($deleteid)->row();

		if ($this->users_model->delete($deleteid)) {
			echo "Successfully deleted user: $deleteid.<br /><br /><a class='button blue' href='/tms/users'>Back</a>";
		} else {
			echo ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message'));
		}
	}

	function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	function _valid_csrf_nonce()
	{
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
			$this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

}

