<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengganti extends CI_Controller
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
        $this->controller            = ucfirst(strtolower($this->uri->segment(1)));
    }

    public function index()
    {

        $Arr_Akses            = getAcccesmenu($this->controller);
        $employee_id          = $this->session->User['employee_id'];

        if ($Arr_Akses['read'] != '1') {
            $this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
            redirect(site_url('dashboard'));
        }

        $get_Data          = $this->db->get_where('pengganti', ['status' => 'OPN', 'employee_id' => $employee_id])->result();
        $employees         = $this->employees_model->getData('employees');
        $phone = [];
        foreach ($employees as $emp) {
            $phone[$emp->id] = preg_replace('/0/', '62', $emp->hp, 1);
        }

        $data = array(
            'title'         => 'Index Cuti Pengganti',
            'action'        => 'index',
            'religi'        => '0',
            'row'           => $get_Data,
            'phone'         => $phone,
            'access'        => $Arr_Akses
        );
        history('Index Cuti Pengganti');
        $this->load->view('Pengganti/index', $data);
    }

    public function add()
    {
        $Arr_Akses            = getAcccesmenu($this->controller);
        if (!$Arr_Akses) {
            $this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Login as Employee....</div>");
            redirect(site_url($this->controller));
        }

        $employee           = $this->session->Employee;
        $division           = $this->employees_model->getData('divisions', 'id', $employee['division_id'])[0];
        $divisionHead       = $this->db->get_where('divisions_head', ['id' => $employee['division_head']])->row();

        $data = array(
            'title'         => 'Pengajuan Cuti Pengganti',
            'action'        => 'add',
            'employee'      => $employee,
            'divisionHead'  => $divisionHead,
            'division'      => $division,
            'access'        => $Arr_Akses
        );
        $this->load->view('Pengganti/add', $data);
    }
}
