<?php
class Professors_model extends MY_Model
{
	protected $table_name = 'professors';
    public $firstname;
    public $lastname;
    public $email;
    public $scholarid;
    public $citation_on_db;
    public $citation_on_web;
    public $last_article_update_at;
    public $last_ref_update_at;
    
	function __construct($properties = [])
	{
		parent::__construct($properties);
	}

}