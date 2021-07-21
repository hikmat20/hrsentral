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
        return $this->db->get('employees')->row();
    }

    public function getSumWhere($field, $table, $data = [])
    {
        $this->db->select_sum($field);
        $this->db->from($table);
        $this->db->where($data);
        return  $this->db->get()->row();
    }

    public function getCount($data = [])
    {

        if (!empty($data)) {
            $this->db->count_all_results($this->_table);
            $this->db->where($data);
            $this->db->from($this->_table);
            $result =  $this->db->count_all_results();
        } else {
            $result = $this->db->count_all_results($this->_table);
        }
        return  $result;
    }

    public function getCountLeave($where = [], $field = [])
    {

        $this->db->select('COUNT(*) as value, status');
        $this->db->from($this->_table);
        $this->db->where($where);
        $this->db->group_by($field);
        $result = $this->db->get()->result_array();
        $dt = [];
        if ($result) {
            foreach ($result as $res) {
                $dt[$res['status']] = $res['value'];
            }
        }
        return  $dt;
    }

    public function getWhereOr($where = [], $orWhere = [])
    {
        $this->db->select('*');
        $this->db->from($this->_table);
        $this->db->where($where);
        $this->db->or_where($orWhere);
        return $this->db->get()->result();
    }

    public function getFreqLeave($emp_id = '', $leaveCat = '', $status = '')
    {
        $this->db->select(
            'periode_year, MONTH(from_date) AS bulan,count(*) AS total_pengajuan, sum(special_leave) AS total_hari'
        );
        $this->db->from($this->_table);
        $this->db->where([
            'employee_id' => $emp_id,
            'special_leave_category' => $leaveCat,
            'status' => $status
        ]);
        $this->db->group_by('periode_year, MONTH(from_date), MONTH(until_date)');
        $this->db->order_by('periode_year');
        $result = $this->db->get()->result();
        return $result;
    }
}
