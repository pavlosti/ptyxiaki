<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public $viewData = array();

    public function __construct()
    {
        parent::__construct();
        $this->viewData = [];
        //$this->getMenu();
        $this->load->library('session');
        $this->load->helper('url_helper');
        $this->viewData['baseUrl'] = $this->config->item('base_url');
    }

    public function getMenu()
    {
        if(isset($_SESSION['userid']))
        {
            $logged = true;
        }
        else
        {
            $logged = false;
        }

        $this->viewData['menu'] = [
            ['href' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'wb-dashboard', 'modal' => false],
            ['href' => 'professors', 'label' => 'Professors', 'icon' => 'wb-user', 'modal' => false],
            ['href' => 'articles', 'label' => 'Ερευνητικό Έργο', 'icon' => 'wb-book', 'modal' => false]
        ];

        $this->viewData['tags'] = ['url' => '', 'type'=>'' , 'title' => '', 'description' => '', 'image' => ''];

        $this->viewData['nav'] = [['href' => 'blog', 'label' => 'Home']];
    }
}
