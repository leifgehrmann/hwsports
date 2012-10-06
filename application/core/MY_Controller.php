<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    protected $the_user;

    public function __construct() {

        parent::__construct();

        if($this->ion_auth->is_admin()) {
            $this->the_user = $this->ion_auth->user()->row();
            $data->the_user = $this->the_user;
            $this->load->vars($data);
        }
        elseif($this->ion_auth->is_group('user')) {
            $this->the_user = $this->ion_auth->user()->row();
            $data->the_user = $this->the_user;
            $this->load->vars($data);
        } else {
            redirect('/');
        }
    }
}

?>