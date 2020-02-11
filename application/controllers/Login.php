<?php
class Login extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->library('session');
        $this->load->model('registered_model');
        $this->load->helper('form');
	    $this->load->library('form_validation');
	    $this->load->helper('email');
    }

    public function index()
    {
    	//$this->load->view('sign-in6');

    	$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
    	$this->form_validation->set_rules('username', 'Username', 'required');
    	$this->form_validation->set_rules('password', 'Password', 'required');

	    if ($this->form_validation->run() === FALSE)
	    {
            $this->load->view('login');
	    }
	    else
	    {
	    	$res = $this->registered_model->auth();
	        if($res != 0)
	        {
	        	redirect('../dashboard', 'location');
	        }
	        else
	        {
	        	echo "Password not matched";
	    	}
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('../login', 'location');
    }
}
