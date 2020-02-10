<?php
class Article_model extends MY_Model
{
	protected $table_name = 'articles';
    public $title;
    public $publication_date;
    public $month;
    public $year;
    public $type_name;
    public $type;
    public $issue;
    public $pages;
    public $volume;
    public $publisher;
    public $description;
    public $references_id;
    public $citation;
    public $scholarid_professor;
    public $scholarid_article;


    
	function __construct($properties = [])
	{
		parent::__construct($properties);
		
	}
	

    public function get_total_articles()
	{
	    $query = $this->db->select("COUNT(*) as num")->get("articles");
	    $result = $query->row();
	    if(isset($result)) return $result->num;
	    return 0;
	}

	public function get_articles($start, $length, $order, $dir)
     {
          if($order != null) {
               $this->db->order_by($order, $dir);
          }

          return $this->db
               ->limit($length,$start)
               ->get("articles");
     }

	
}

