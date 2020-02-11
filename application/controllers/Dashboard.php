<?php
class Dashboard extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->library('session');
        $this->load->model('registered_model');
        $this->load->model('article_model');
        
        $this->getMenu();
    }

    

        public function index()
        {
            if(isset($_SESSION['userid'])){

                $query = $this->db->query("SELECT year FROM articles GROUP BY year");

                $res = $query->result();
            	//$this->load->view('sign-in6');
                $this->viewData['yearlist'] = $res;

                $this->load->view('template/header', $this->viewData);
                $this->load->view('dashboard');
                $this->load->view('template/footer');
            }else{
                 redirect('../login', 'location');
            }
        }
            
       
}
