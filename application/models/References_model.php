<?php
class References_model extends MY_Model
{
	protected $table_name = 'references';
    public $title;
    public $publishers;
    public $year;
    public $bibtex_id;
    public $ref_id;
    // public $author;
    // public $journal;
    // public $volume;
    // public $number;
    // public $pages;
    // public $publisher;
    // public $year;
    // public $citation;
    public $scholarid_article;
    
	function __construct($properties = [])
	{
		parent::__construct($properties);
	}

}