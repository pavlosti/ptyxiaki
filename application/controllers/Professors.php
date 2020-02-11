<?php
include_once('application/libraries/simple_html_dom.php');

@ini_set('max_execution_time', 0);
@ini_set('set_time_limit', 0);

class Professors extends MY_Controller {

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

    public function index()
    {
        if(isset($_SESSION['userid'])){
            $this->viewData['title'] = 'Professors';

            $this->viewData['professors'] = $this->professors_model->getRows();

            $this->load->view('template/header', $this->viewData);
            $this->load->view('professor/index', $this->viewData);
            $this->load->view('template/footer');
        }else{
           redirect('../login', 'location');
      }  
    }

    public function insert_professor_modal()
    {
        $this->viewData['title'] = 'Add professor';

        $this->load->view('professor/add_professor_modal', $this->viewData);
    }

    public function insert_scholar_account_modal()
    {
        $firstname = $_GET['firstname'];
        $lastname = $_GET['lastname'];
        $id = $_GET['id'];

        $url = 'https://scholar.google.gr/citations?hl=el&view_op=search_authors&mauthors=';
        $name = $firstname.'+'.$lastname;
        $stripped_name = preg_replace('/\s+/', '+', $name);
        $name = mb_convert_encoding(urldecode($stripped_name),'HTML-ENTITIES','UTF-8');

        $url = $url.$stripped_name;

        $this->viewData['title'] = 'Insert Scholar Id';

        $this->load->library('mylib');

        $this->viewData['profScholarId'] = $this->mylib->prof_list_scraping($url);

        $this->viewData['id'] = $id;



        $this->load->view('professor/view_scholar_account_modal', $this->viewData);
    }


    public function saveProf()
    {

        // https://scholar.google.gr/citations?hl=el&view_op=search_authors&mauthors=%CE%A7%CF%81%CE%B7%CF%83%CF%84%CE%BF%CF%82+%CE%93%CE%BA%CE%BF%CE%B3%CE%BA%CE%BF%CF%82

        $prof = new $this->professors_model();


        $prof->firstname = $this->input->post('firstname');
        $prof->lastname = $this->input->post('lastname');
        $prof->email = $this->input->post('email');

        // afou ginei web scrapping tote kanw eisagvgh sthn vash
         if($prof->save())
         {
            echo json_encode($prof);
         }
         else
         {
            echo json_encode(['error' => 'save failed']);
         }
         exit();
    }

    public function updateProfessor()
    {

        $profId = $this->input->post('id');
        $scholarid = $this->input->post('field');
        $citation = $this->input->post('field1');
        $value = $this->input->post('value');
        $value1 = $this->input->post('value1');


        if ($profId && intval($profId))
        {
            $prof = $this->professors_model->getRow(['id' => (int) $profId]);
        }

        $prof->$scholarid = $value;  
        $prof->citation_on_web = $value1;
        if ($prof->save())
        {
            // if($scholarid == 'scholarid')
            // {
            //     $this->article_list($value);
            // }

            // if($citation_on_web == 'citation')
            // {
            //     $this->article_list($value1);
            // }

            echo json_encode($prof);
        }else
        {
            echo json_encode(['error' => 'save failed']);
        }
        exit;
    }

    public function deleteProfessor($id)
    {

        if ($this->professors_model->delete(['id' => $id]))
            echo json_encode(['flag' => true]);
        else
            echo json_encode(['flag' => false]);
    }

    public function reference_list($profScholarId){
        $count = 0;
        $i=0;
        $j=0;
        echo "<pre>";
        $article_list = $this->article_model->getRows(['scholarid_professor' => $profScholarId ]);
        if($article_list == null){
            var_dump("den uparxoun arthra sthn vash!");
        }else{
            $prof = $this->professors_model->getRow(['scholarid' => $profScholarId ]);

            $prof_cit_db = $prof->citation_on_db;
            $prof_cit_web = $this->mylib->scraping_professor_citation($profScholarId);
            if($prof_cit_web != $prof_cit_db){
                var_dump('citation on db is different from citation on web');

                foreach ($article_list as $article) {
                    if($article->citation != 0){
                        var_dump("arthro me citation");
                        var_dump($article->references_id);

                        $reference_list_count_from_web = $this->mylib->reference_list_count($article->references_id);
                        $reference_list_count_from_db = $this->references_model->getRows(['ref_id' => $article->references_id]);
                     
                        if($reference_list_count_from_web == count($reference_list_count_from_db))
                        {
                            var_dump("to sygkekrimeno arthro exei oles tis anafores perasmenes sthn vasei opote den tha ginei peretairw scraping");
                        }
                        else
                        {
                            // fere ola ta ref toy arthrou
                        $reference_list_from_web = $this->mylib->reference_list($article->references_id);
                        var_dump("after scraping RESULTS");
                        var_dump($reference_list_from_web);
                        foreach($reference_list_from_web as $ref_item_web){
                            $reference_list_from_db = $this->references_model->getRows(['bibtex_id' => $ref_item_web['bibtex_id'] ]);
                            if($reference_list_from_db != null){
                                var_dump('uparxei sthn vash');
                            }else{
                                var_dump("den uparxei ara kane apothikeush");
                                $reference = new $this->references_model();
                                $reference->bibtex_id = $ref_item_web['bibtex_id'];
                                if($ref_item_web['bibtex_id'] == "0000"){
                                    $reference->bibtex_id = $ref_item_web['bibtex_id'].$article->references_id;
                                }else{
                                    $reference->bibtex_id = $ref_item_web['bibtex_id'];
                                }
                                $reference->ref_id = $article->references_id;
                                $reference->scholarid_article = $article->scholarid_article;
                                var_dump("New reference inserted");
                                var_dump($reference);
                                $reference->save();
                                //sleep(120);
                                $count++;
                            }
                            $j++;
                        }
                    }   
                    }else{
                        var_dump("den uparxei citation");
                    }
                    var_dump("next article");
                }
                $prof = $this->professors_model->getRow(['scholarid' => $profScholarId]);
                $prof->citation_on_db = $prof->citation_on_db + $count;
                $prof->last_ref_update_at = date("Y-m-d");
         
                $prof->save();
                
            }else{
                var_dump('to citation einai idio vashs kai web. Den uparxei enhmerwsh');
            }
        }
        var_dump("END FUNCTION");
    }

    public function reference_single($profScholarId)
    {
        $query = $this->db->get_where('articles', array('citation !=' => 0,'scholarid_professor' => $profScholarId));
        foreach ($query->result() as $row)
        {
            echo "<pre>";
            $ref_list = $this->references_model->getRows(['ref_id' => $row->references_id]);
            foreach ($ref_list as $key) {
                $expl = explode('0000', $key->ref_id);
                echo "<pre>";
                // var_dump($expl);
                var_dump($key->ref_id);
                // die();
                if($key->title == '' && $key->publishers == '' && $key->year == '' && $expl[0] != "")
                {
                    $res = $this->mylib->bibtex_url($key->bibtex_id);
                    $res1 = $this->references_model->getRow(['bibtex_id' => $key->bibtex_id]);
                    $ref = new $this->references_model();
                    $ref = $res1;
                    //var_dump($ref);
                    $ref->year = $res['year'];
                    $ref->publishers = $res['publishers'];
                    $ref->title = $res['title'];
                    var_dump("new ref inserted");
                    $ref->save();
                }else{
                    var_dump('uparxoun dedomena ara oxi scraping h den yparxei bibtexid gia to sygkekrimeno ref');
                }
            }        
        }
    }

     public function article_list($profScholarId)
     {
       $list = $this->mylib->scraping_article_list($profScholarId);
       $i=0;
        // query etsi wste otan den uparxei kanena arthro sthn vash gia enan sygkekrimeno kathigiti na mhn kanei scraping
        // ean uparxei tote tha kanei
       //$resArticle = $this->article_model->getRow(['scholarid_professor' => $profScholarId]);

       foreach ($list as $value)
       {
            $res = $this->article_model->getRow(['scholarid_professor' => $profScholarId, 'scholarid_article' => $value['articleId'] ]);
            
            if($res == null)
            {
                $article = new $this->article_model();
                $article->title = $value['title'];
                $article->scholarid_article = $value['articleId'];
                $article->scholarid_professor = $profScholarId;

                // MY LIBRARY
                $single_article = $this->single_article($profScholarId, $value['articleId']);
                //var_dump($single_article);

                if (isset($single_article['reference_id'])) 
                {
                    $article->references_id = $value['reference_id'];
                }

                if(isset($single_article['Journal']))
                {
                    $article->type = 'Journal';
                    $article->type_name = $single_article['Journal'];
                }
                else if(isset($single_article['Conference']))
                {
                    $article->type = 'Conference';
                    $article->type_name = $single_article['Conference'];
                }
                else
                {
                    $article->type = 'General';
                    $article->type_name = $single_article['General'];
                    if(strlen($article->type_name) <= 3)
                    {
                        $article->type_name = '';
                    }
                }

                if(isset($single_article['References']))
                    $article->references_id = $single_article['References'];

                if(isset($single_article['Pages']))
                    $article->pages = $single_article['Pages'];

                if(isset($single_article['Issue']))
                    $article->issue = $single_article['Issue'];

                if(isset($single_article['Volume']))
                    $article->volume = $single_article['Volume'];

                if(isset($single_article['month']))
                    $article->month = $single_article['month'];

                if(isset($single_article['Publication date'])){
                    if(strlen($single_article['Publication date']) == 4)
                    {
                        $article->publication_date = $single_article['Publication date'];
                        $article->year = $single_article['Publication date'];
                    }
                    else
                    {
                        $year = explode('/', $article->publication_date = $single_article['Publication date']);
                        $article->publication_date = $single_article['Publication date'];
                        $article->year = $year[0];
                    }
                }


                if(isset($single_article['Description']))
                    $article->description = $single_article['Description'];

                if(isset($single_article['Citation']))
                    $article->citation = $single_article['Citation'];
                else{
                    $article->citation = 0;
                }

                if(isset($single_article['Publisher']))
                    $article->publisher = $single_article['Publisher'];

                var_dump('kainourio arthro');
                var_dump($article);
                //die();
                $article->save();

            }else{
                var_dump("Uparxei to arthro sthn vash.");
            }
        }
        $prof = $this->professors_model->getRow(['scholarid' => $profScholarId]);
        $prof->id = $prof->id;
        $prof->last_article_update_at = date("Y-m-d");
        $prof->save();

    }

    public function single_article($profScholarId, $articleId)
    {
        //$profScholarId = '5UlGp3MAAAAJ';
        //$articleId = 'u5HHmVD_uO8C';
        $url = 'https://scholar.google.gr/citations?view_op=view_citation&hl=en&user='.$profScholarId.'&citation_for_view='.$profScholarId.':'.$articleId;
        $resutls = $this->mylib->scraping_single_article($url);
        return $resutls;
    }

}
