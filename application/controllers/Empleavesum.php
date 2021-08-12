<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Empleavesum extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('master_model');
        $this->load->model('employees_model');
        $this->load->model('leavesModel');
        $this->load->database();
        if (!$this->session->userdata('isLogin')) {
            redirect('login');
        }
        $this->controller       = ucfirst(strtolower($this->uri->segment(1)));
    }

    public function index()
    {

        $Arr_Akses            = getAcccesmenu($this->controller);
        $employee_id          = $this->session->User['employee_id'];
        if ($Arr_Akses['read'] != '1') {
            $this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
            redirect(site_url('dashboard'));
        }

        $get_Data          = $this->db->get('view_employee_leave_summary')->result();
        $employees         = $this->employees_model->getEmployees();
        $id             = $this->session->userdata['Employee']['id'];
        $empLeave       = $this->db->get_where('employees_leave', ['employee_id' => $id])->result();
        $empLeaveApps   = $this->db->get_where('view_leave_applications', ['employee_id' => $id, 'periode_year' => date('Y'), 'status' => 'APV'])->result();

        $data = array(
            'title'            => 'Index Employee Leave Summary',
            'action'        => 'index',
            'religi'        => '0',
            'row'           => $get_Data,
            'employees'     => $employees,
            'empLeave' => $empLeave,
            'empLeaveApps' => $empLeaveApps,
            'access'        => $Arr_Akses
        );
        $group = $this->session->userdata['Group']['id'];
        if ($group != '1' && $group != '40') {
        }


        history('View Leave Applications');
        $this->load->view('Empleavesum/index', $data);
    }

    public function details()
    {
        $id             = $this->input->post('id');
        $empLeave       = $this->db->get_where('employees_leave', ['employee_id' => $id])->result();
        $empLeaveApps   = $this->db->get_where('view_leave_applications', ['employee_id' => $id, 'periode_year' => date('Y'), 'status' => 'APV'])->result();

        $data = [
            'empLeave' => $empLeave,
            'empLeaveApps' => $empLeaveApps,
        ];

        $this->load->view('Empleavesum/details', $data);
    }
}
