<?php
include_once('application/libraries/simple_html_dom.php');


class Articles extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->library('session');
        $this->load->database();
        $this->load->model('article_model');
        $this->load->model('professors_model');
        $this->load->model('references_model');
        $this->load->library('mylib');
        $this->getMenu();
    }

    public function index()
    {
      if(isset($_SESSION['userid'])){
        $this->viewData['title'] = 'Scientific Publications';
        //$viewData['articles'] = $this->article_model->get_articles();
        $prof = $this->professors_model->getRows();
        $this->viewData['prof'] = $prof;


        $this->load->view('template/header', $this->viewData);
        $this->load->view('article/index', $this->viewData);
        $this->load->view('template/footer');
      }else{
           redirect('../login', 'location');
      }  
    }

    public function articles_page($prof = null)
    {
          // Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));
          $search= $this->input->get("search");
          // if($prof != 'all'){
          //   $search = 'asd';
          // }else if($prof == 'all'){
          if($prof == 'all'){
            $search = $search['value'];
          }else{
            $search = $prof;
          }
          //}
        

          $order = $this->input->get("order");

          $col = 0;
          $dir = "";
          if(!empty($order)) {
               foreach($order as $o) {
                    $col = $o['column'];
                    $dir= $o['dir'];
               }
          }

          if($dir != "asc" && $dir != "desc") {
               $dir = "asc";
          }

          $columns_valid = array(
               "articles.title",
               "articles.publication_date",
               "articles.type",
               "articles.type_name",
               "articles.citation",
               "articles.scholarid_professor",
               "articles.scholarid_article",
               "articles.references_id"
          );

          if(!isset($columns_valid[$col])) {
               $order = null;
          } else {
               $order = $columns_valid[$col];
          }

          if(!empty($search))
          {
              $x=0;
              foreach($columns_valid as $sterm)
              {
                  if($x==0)
                  {
                      $this->db->like($sterm,$search);
                  }
                  else
                  {
                      $this->db->or_like($sterm,$search);
                  }
                  $x++;
              }                 
          }

          $articles = $this->article_model->get_articles($start, $length, $order, $dir);

          $data = array();

          foreach($articles->result() as $r) {
            $prof_name = $this->professors_model->getRow(['scholarid' => $r->scholarid_professor ]);

             $data[] = array(
                  $r->title,
                  $r->publication_date,
                  $r->type,
                  $r->type_name,
                  $r->citation,
                  $prof_name->firstname.' '.$prof_name->lastname,
                  $r->scholarid_article,
                  $r->references_id    
             );
          }

          $total_articles = $this->article_model->get_total_articles();

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $total_articles,
                 "recordsFiltered" => $total_articles,
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }

     public function view_reference_modal($refid_artid)
    {
        $this->viewData['title'] = 'Πληροφορίες Άρθρου';
        $id = explode('ids', $refid_artid);
        $refid = $id[0];
        $scolid = $id[1];

        $ref_list = $this->references_model->getRows(['scholarid_article' =>  $refid, 'ref_id' => $scolid]);

        $this->viewData['ref_list'] = $ref_list;

        $this->load->view('reference/view_references_modal', $this->viewData);
    }



    public function fetchByYearsAnalytics()
    { 
      $query = $this->db->query('SELECT year, count(*) as unique_years FROM articles GROUP BY year ORDER BY year');
      $res = $query->result();
      foreach ($res as $row) 
      {
        $data[] = $row;
      }
      echo json_encode($data);
    }


    public function fetchByCurrentYear($year)
    {   
      $year1 = $year + 1; 
      $query = $this->db->query("
        SELECT articles.scholarid_professor,
                COUNT(*) AS 'num'
         FROM   articles,
                (
                    SELECT articles.scholarid_professor,
                           COUNT(*) AS total
                    FROM   articles
                    GROUP BY articles.scholarid_professor
                ) AS totals
         WHERE  articles.scholarid_professor = totals.scholarid_professor
         AND ((year = ".$year." AND month>=9) OR (year = ".$year1." AND month<=8) OR (publication_date = ".$year." AND month IS NULL))
         
         GROUP BY articles.scholarid_professor

      ");

      $res = $query->result();

      foreach ($res as $row) 
      {
        
        $res1 = $this->professors_model->getRow(['scholarid' =>  $row->scholarid_professor]);

        $data['scholarid_professor'] = $res1->firstname." ".$res1->lastname;
        $data['num'] = $row->num;
        
        $data1[] = $data;
      }
      if(!isset($data1)){
        $data1=0;
      }
      echo json_encode($data1);
    }

    public function fetchByMonth()
    {
      
        
    }

}
