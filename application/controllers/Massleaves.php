<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Massleaves extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('master_model');
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

        $get_Data            = $this->master_model->getData('at_mass_leaves');


        $data = array(
            'title'            => 'Indeks Of Mass Leaves',
            'action'        => 'index',
            'descr'            => 'No Description',
            'row'            => $get_Data,
            'akses_menu'    => $Arr_Akses
        );
        history('View Data Mass Leaves');
        $this->load->view('Massleaves/index', $data);
    }
    public function add()
    {
        if ($this->input->post()) {
            $Arr_Kembali            = array();
            $data                    = $this->input->post();
            $data['id']                = $this->master_model->code_otomatis('at_mass_leaves', 'MSL');
            $data_session            = $this->session->userdata;
            $data['created_by']        = $data_session['User']['username'];
            $data['created']        = date('Y-m-d H:i:s');

            if ($this->master_model->simpan('at_mass_leaves', $data)) {
                $Arr_Kembali        = array(
                    'status'        => 1,
                    'pesan'            => 'Add Mass Leaves Success. Thank you & have a nice day.......'
                );
                history('Add Data Mass Leaves' . $data['name']);
            } else {
                $Arr_Kembali        = array(
                    'status'        => 2,
                    'pesan'            => 'Add Mass Leaves failed. Please try again later......'
                );
            }
            echo json_encode($Arr_Kembali);
        } else {
            $controller            = ucfirst(strtolower($this->uri->segment(1)));
            $Arr_Akses            = getAcccesmenu($controller);
            if ($Arr_Akses['create'] != '1') {
                $this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
                redirect(site_url('menu'));
            }
            $arr_Where            = '';
            $get_Data            = $this->master_model->getCompanies($arr_Where);
            $data = array(
                'title'            => 'Add Mass Leaves',
                'action'        => 'add',
                'data_companies' => $get_Data
            );
            $this->load->view('Massleaves/add', $data);
        }
    }
    public function edit($id = '')
    {
        if ($this->input->post()) {
            $data                    = $this->input->post();
            $data['status']          =  ($this->input->post('status')) ? $this->input->post('status') : 'N';
            $Arr_Kembali             = array();
            unset($data['id']);
            $data_session            = $this->session->userdata;
            $data['modified_by']    = $data_session['User']['username'];
            $data['modified']        = date('Y-m-d H:i:s');

            if ($this->master_model->getUpdate('at_mass_leaves', $data, 'id', $this->input->post('id'))) {
                $Arr_Kembali        = array(
                    'status'        => 1,
                    'pesan'            => 'Edit Mass Leaves Success. Thank you & have a nice day.......'
                );
                history('Edit Data Mass Leaves' . $data['name']);
            } else {
                $Arr_Kembali        = array(
                    'status'        => 2,
                    'pesan'            => 'Add Departement failed. Please try again later......'
                );
            }
            echo json_encode($Arr_Kembali);
        } else {
            $controller            = ucfirst(strtolower($this->uri->segment(1)));
            $Arr_Akses            = getAcccesmenu($controller);
            if ($Arr_Akses['update'] != '1') {
                $this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
                redirect(site_url('massleaves'));
            }
            $arr_Where            = '';
            $get_Data            = $this->master_model->getCompanies($arr_Where);
            $detail                = $this->master_model->getData('at_mass_leaves', 'id', $id);

            $data = array(
                'title'            => 'Edit Mass Leaves',
                'action'        => 'edit',
                'data_companies' => $get_Data,
                'row'            => $detail
            );

            $this->load->view('Massleaves/edit', $data);
        }
    }

    function delete($id)
    {
        $controller            = ucfirst(strtolower($this->uri->segment(1)));
        $Arr_Akses            = getAcccesmenu($controller);
        if ($Arr_Akses['delete'] != '1') {
            $this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
            redirect(site_url('massleaves'));
        }

        $this->db->where('id', $id);
        $this->db->delete("at_mass_leaves");
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata("alert_data", "<div class=\"alert alert-success\" id=\"flash-message\">Data has been successfully deleted...........!!</div>");
            history('Delete Data Mass Leaves id' . $id);
            redirect(site_url('massleaves'));
        }
    }

    function approve($id = '')
    {
        $controller            = ucfirst(strtolower($this->uri->segment(1)));
        $Arr_Akses            = getAcccesmenu($controller);
        if ($Arr_Akses['approve'] != '1') {
            $this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
            redirect(site_url('massleaves'));
        }
        // $id = $this->input->post('id');
        $this->db->where('id', $id);
        $this->db->update("at_mass_leaves", ['status' => 'Y']);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata("alert_data", "<div class=\"alert alert-success\" id=\"flash-message\">Data has been successfully Approved..!!</div>");
            history('Approve Data Mass Leaves id' . $id);
            redirect(site_url('massleaves'));
        }
    }
}
