<?php

class Activity_model extends CI_MODEL
{

    public function __construct()
    {
        parent::__construct();
        $this->table = 'activities';
    }

    public function get_list()
    {
        $query = $this->$this->db->get($this->table);
        return $query->result();
    }

    public function add()
    {
        $this->db->insert($this->table, $data);
    }
}
