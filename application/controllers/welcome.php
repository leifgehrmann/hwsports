<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$this->load->view('welcome_message');
	}

    /**
     * Global Login function to log user in and direct to proper area
     *
     * @return void
     * @author Jonathan Johnson
     **/
    function login() {

        if($_POST) {   //clean public facing app input
            $identity = $this->input->post('identity', true);
            $password = $this->input->post('password', true);

            if($this->ion_auth->login($identity,$password)) {

                $user = $this->ion_auth->user()->row();
				$user_groups = $this->ion_auth->get_users_groups($user->id)->result();
				if (in_array("admin", $user_groups)) {
					redirect('admin/home');
				} else {
					redirect('user/home');
				}
				
            }
            else {

                // set error flashdata
                $this->session->set_flashdata(
                    'error',
                    'Your login attempt failed.'
                );

                redirect('/');
            }
        }
        $this->load->view('login_form');
    }

    /**
     * Global logout function to destroy user session
     *
     * @return void
     * @author Jonathan Johnson
     **/
    function logout() {   //Basic Ion_Auth Logout function
        $this->ion_auth->logout();
        redirect('/');
    }
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
