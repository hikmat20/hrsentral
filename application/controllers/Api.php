<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('master_model');
        $this->load->model('employees_model');
        $this->load->model('leavesModel');
        $this->load->database();
        // if (!$this->session->userdata('isLogin')) {
        //     redirect('login');
        // }
        $this->controller            = ucfirst(strtolower($this->uri->segment(1)));
    }

    public function index()
    {
        $arr = [
            'status' => false,
            'msg' => 'not file to load',
            'hint' => 'try to ' . base_url() . 'api/employees'
        ];

        echo json_encode($arr);
    }

    public function employees()
    {
        $employees['status'] = true;
        $employees = $this->db->get_where('employees', ['resign' => null, 'flag_active' => 'Y'])->result();
        echo json_encode($employees);
    }
}
