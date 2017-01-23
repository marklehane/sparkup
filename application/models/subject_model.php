<?php

class Subject_model extends CI_MODEL {
	
	function __construct() {
		parent::__construct();
		$this->table = 'subjects';
	}

	public function get_list() {
		$query = $this->$this->db->get($this->table);
		return $query->result();
	}

	public function add() {
		$this->db->insert($this->table, $data);
	}
}