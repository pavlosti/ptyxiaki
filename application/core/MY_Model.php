<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This Class extends CI_Model class and is used in our Model classes for common tasks accross all application models.
 */
class MY_Model extends CI_Model {

	protected $table_name = 'undefined';

	public $id;
	public $inserted_at;
	public $updated_at;
	public $deleted_at;

	public function __construct($properties = [])
	{
		parent::__construct();
		$this->set_properties($properties);
		$this->load->database();

		
	}
	
	public function set_properties($properties = [])
	{
		foreach ($properties as $property => $value)
		{
			$this->$property = $value;
		}
	}
	
	private function nullify_empty_properties()
	{
		foreach (get_object_vars($this) as $property => $value)
		{
			if (strlen(trim($this->$property)) == 0)
			{
				$this->$property = NULL;
			}
		}
	}
	
	public function getRow($where = [])
	{
		if (!$where) return NULL;

		$called_class = get_called_class();

		return $this->db->get_where($this->table_name, $where)->custom_row_object(0, $called_class);
	}
	
	public function getRows($where = [], $order_by = NULL, $dir = 'ASC', $limit = NULL, $start = NULL)
	{
		$called_class = get_called_class();
		$where = array_merge($where, ['deleted_at' => NULL]);

		if ($order_by)
			$this->db->order_by($order_by, $dir);

		if (isset($limit) && isset($start))
			$this->db->limit($limit, $start);
		
		return $this->db->get_where($this->table_name, $where)->custom_result_object($called_class);
	}
	
	public function countRows($where = [], $order_by = NULL, $dir = 'ASC', $limit = NULL, $start = NULL)
	{
		$where = array_merge($where, ['deleted_at' => NULL]);

		if ($order_by)
			$this->db->order_by($order_by, $dir);

		if (isset($limit) && isset($start))
			$this->db->limit($limit, $start);
			
		$this->db->where($where);
		$this->db->from($this->table_name);
		
		return $this->db->count_all_results();
	}
	
	public function save()
	{
		if ((int)$this->id > 0)
		{
			$this->un_delete();
			$this->update();
			$result = $this->id;
		}
		else
		{
			$this->insert();
			$result = $this->db->insert_id();
		}

		return $result;
	}
	
	public function update()
	{
		$this->nullify_empty_properties();

		$called_class = get_called_class();

		$datetime_now = new DateTime('now', new DateTimeZone('Europe/Athens'));
		$this->updated_at = $datetime_now->format('Y-m-d H:i:s');

		$this->db->update($this->table_name, $this, ['id' => $this->id]);
	}

	public function insert()
	{
		$this->nullify_empty_properties();

		$called_class = get_called_class();

		$datetime_now = new DateTime('now', new DateTimeZone('Europe/Athens'));
		if (!$this->inserted_at)
			$this->inserted_at = $datetime_now->format('Y-m-d H:i:s');
		$this->updated_at = $datetime_now->format('Y-m-d H:i:s');

		$this->db->insert($this->table_name, $this);

		$this->id = $this->db->insert_id();
	}
	
	public function delete($where = null)
	{
		$called_class = get_called_class();

		if (!$where)
			$where = ['id' => $this->id];

		return $this->db->delete($this->table_name, $where);
	}

	public function soft_delete()
	{
		$called_class = get_called_class();
		$datetime_now = new DateTime('now', new DateTimeZone('Europe/Athens'));
		$this->deleted_at_at = $datetime_now->format('Y-m-d H:i:s');

		return $this->db->update($this->table_name, $this, ['id' => $this->id]);
	}
	
	public function un_delete()
	{
		$called_class = get_called_class();
		$this->deleted_at = NULL;

		return $this->db->update($this->table_name, $this, ['id' => $this->id]);
	}
	
}