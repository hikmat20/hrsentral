<?php
// 
// Created by Hikmat A. R
// =====================================

class LeavesModel extends CI_Model
{
    private $_table = 'view_leave_applications';

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code

    }

    public function getAll()
    {
        return $this->db->get($this->_table)->result();
    }

    public function getFind($data)
    {
        return $this->db->get_where($this->_table, $data)->result();
    }

    public function getAllEmployees()
    {
        return $this->db->get('employees')->result();
    }

    public function getSumWhere($field, $table, $data)
    {
        $this->db->select_sum($field);
        $this->db->from($table);
        $this->db->where($data);
        return  $this->db->get()->row();
    }

    public function getWhereOr($where = [], $orWhere = [])
    {
        $this->db->select('*');
        $this->db->from($this->_table);
        $this->db->where($where);
        $this->db->or_where($orWhere);
        return $this->db->get()->result();
    }
}
