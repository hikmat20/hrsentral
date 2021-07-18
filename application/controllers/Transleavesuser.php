<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transleaves extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('master_model');
        $this->load->model('employees_model');
        $this->load->database();
        if (!$this->session->userdata('isLogin')) {
            redirect('login');
        }
    }

    public function index()
    {
        $controller            = ucfirst(strtolower($this->uri->segment(1)));
        $Arr_Akses            = getAcccesmenu($controller);
        if ($Arr_Akses['read'] != '1') {
            $this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
            redirect(site_url('dashboard'));
        }

        $get_Data            = $this->employees_model->getDataTransleave();
        $Transleaves            = $this->employees_model->getEmployees();
        $data = array(
            'title'            => 'Indeks Of Transleaves',
            'action'        => 'index',
            'religi'        => '0',
            'row'            => $get_Data,
            'data_menu'        => $Transleaves,
            'akses_menu'    => $Arr_Akses
        );
        history('View Data Transleaves');
        $this->load->view('Transleaves/index', $data);
    }
}
