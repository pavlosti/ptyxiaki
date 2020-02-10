<?php

class References extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->library('session');
        $this->load->model('professors_model');
        $this->load->model('article_model');
        $this->load->model('references_model');
        $this->load->helper('form');
        $this->load->library('mylib');
        $this->load->database();
	    //$this->load->library('form_validation');
	    //$this->load->helper('email');
        $this->getMenu();
    }



}
