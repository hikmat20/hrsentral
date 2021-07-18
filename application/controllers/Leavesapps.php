<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Leavesapps extends CI_Controller
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

        $get_Data          = $this->leavesModel->getFind(['status' => 'OPN', 'employee_id' => $employee_id]);
        $employees         = $this->employees_model->getEmployees();
        $data = array(
            'title'            => 'Index Leave Applications',
            'action'        => 'index',
            'religi'        => '0',
            'row'           => $get_Data,
            'employees'     => $employees,
            'access'        => $Arr_Akses
        );
        history('View Leave Applications');
        $this->load->view('Leaveapplications/index', $data);
    }

    public function history()
    {

        $Arr_Akses            = getAcccesmenu($this->controller);
        if ($Arr_Akses['read'] != '1') {
            $this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
            redirect(site_url('dashboard'));
        }

        $get_Data            = $this->db->query("SELECT * FROM `view_leave_applications` WHERE `status` = 'APV'")->result();
        $employees         = $this->employees_model->getEmployees();
        $data = array(
            'title'            => 'Index Leave Applications',
            'action'        => 'index',
            'religi'        => '0',
            'row'           => $get_Data,
            'employees'     => $employees,
            'access'        => $Arr_Akses
        );
        history('View Leave Applications');
        $this->load->view('Leaveapplications/index', $data);
    }

    public function approval()
    {
        $Arr_Akses            = getAcccesmenu($this->controller . '/approval');
        $employee_id          = $this->session->User['employee_id'];
        if ($Arr_Akses['read'] != '1') {
            $this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
            redirect(site_url('dashboard'));
        }

        $get_Data          = $this->leavesModel->getFind(['status' => 'OPN', 'approval_employee_id' => $employee_id]);
        $employees         = $this->employees_model->getEmployees();
        $data = array(
            'title'            => 'Index Leave Applications',
            'action'        => 'index',
            'religi'        => '0',
            'row'           => $get_Data,
            'employees'     => $employees,
            'access'        => $Arr_Akses
        );
        history('View Leave Applications');
        $this->load->view('Leaveapplications/index', $data);
    }

    public function cancel_reject()
    {

        $Arr_Akses            = getAcccesmenu($this->controller);
        if ($Arr_Akses['read'] != '1') {
            $this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
            redirect(site_url('dashboard'));
        }

        $get_Data            = $this->db->query("SELECT * FROM `view_leave_applications` WHERE `status` = 'CNL' or `status` = 'REJ'")->result();
        $employees         = $this->employees_model->getEmployees();
        $data = array(
            'title'            => 'Index Leave Applications',
            'action'        => 'index',
            'religi'        => '0',
            'row'           => $get_Data,
            'employees'     => $employees,
            'access'        => $Arr_Akses
        );

        history('View Leave Applications');
        $this->load->view('Leaveapplications/index', $data);
    }

    public function getLeaveCategory()
    {
        $idCategory = $this->input->post('id_category');
        $category   = $this->db->get_where('at_leaves', ['id' => $idCategory])->row();

        echo json_encode($category);
    }

    public function getLeaveYear()
    {
        $year           = $this->input->post('year');

        $employee_id    = $this->session->userdata('User')['employee_id'];
        $leaveEmployee  = $this->db->get_where('employees_leave', ['employee_id' => $employee_id, 'year' => $year])->row();
        $collback = [
            'leaveEmployee' => $leaveEmployee
        ];
        echo json_encode(($collback) ? $collback : '');
    }

    public function getDateRange()
    {
        $data = $this->input->post();
        $start = $data['from_date'];
        $end = $data['until_date'];

        $datePeriod = new DatePeriod(
            new DateTime(date('Y-m-d', strtotime("0 day", strtotime($start)))),
            new DateInterval('P1D'),
            new DateTime(date('Y-m-d', strtotime("+1 day", strtotime($end))))
        );


        $holiday = json_decode(file_get_contents('https://raw.githubusercontent.com/guangrei/Json-Indonesia-holidays/master/calendar.json', true));

        $days = 0;
        $holiDay = [];
        foreach ($datePeriod as $dperiod) {
            $date = $dperiod->format('Ymd');

            if (isset($holiday->$date)) {
                $holiDay = [
                    'holiday'   => date("Y-m-d", strtotime($date)),
                    'deskripsi' => $holiday->$date->deskripsi
                ];
                // jika ada hari libur
            } elseif (date('D', strtotime($date)) === 'Sat') {
                // jika ada hari sabtu
            } elseif (date('D', strtotime($date)) === 'Sun') {
                // jika ada hari minggu
            } else {
                $days++;
            }
        }

        $ArrCollback = [
            'days'      => $days,
            'holiDay'   => $holiDay,
        ];
        // echo '<pre>';
        // print_r($holiDay);
        // echo '<pre>';
        // exit;
        echo json_encode($ArrCollback);
    }

    public function autoNumber($table = '', $code = '')
    {

        $sql = "SELECT MAX(RIGHT(id,4)) maxId FROM leave_applications WHERE SUBSTR(id,3, 2) = '" . date('y') . "' ORDER by id DESC";
        $idMax = $this->db->query($sql)->row();
        if ($idMax->maxId == '') {
            $count = '1';
        } else {
            $count = $idMax->maxId + 1;
        }

        return 'LA' . date('y') . str_pad($count, 4, "0", STR_PAD_LEFT);
    }

    public function add()
    {

        $employee           = $this->session->userdata('Employee');
        // $employees          = $this->leavesModel->getAllEmployees();
        $Arr_Akses          = getAcccesmenu($this->controller);
        $totalLeave         = $this->leavesModel->getSumWhere('leave', 'employees_leave', ['employee_id' => $employee['id']]);
        $division           = $this->employees_model->getData('divisions', 'id', $employee['division_id']);
        $leaveCategory      = $this->db->get('at_leaves')->result();
        $divisionHead       = $this->db->get_where('division_head', ['id' => $employee['division_head']])->row();

        // echo '<pre>';
        // print_r($divisionHead);
        // echo '<pre>';
        // exit;
        $data = array(
            'title'         => 'Add Leave Applications',
            'action'        => 'add',
            'religi'        => '0',
            'totalLeave'    => $totalLeave,
            'employee'      => $employee,
            'divisionHead'  => $divisionHead,
            'leaveCategory' => $leaveCategory,
            'division'      => $division[0],
            'access'        => $Arr_Akses,
        );

        $this->load->view('Leaveapplications/add', $data);
    }

    public function update($id)
    {
        $leaveApp           = $this->leavesModel->getFind(['id' => $id]);
        $employee           = $this->session->userdata('Employee');
        $employees          = $this->leavesModel->getAllEmployees();
        $Arr_Akses          = getAcccesmenu($this->controller);
        $division           = $this->employees_model->getData('divisions', 'id', $employee['division_id']);
        $leaveCategory      = $this->db->get('at_leaves')->result();

        // echo '<pre>';
        // print_r($division[0]);
        // echo '<pre>';
        // exit;
        $data = array(
            'title'         => 'Add Leave Applications',
            'action'        => 'add',
            'religi'        => '0',
            'leaveApp'      => $leaveApp[0],
            'employee'      => $employee,
            'employees'     => $employees,
            'leaveCategory' => $leaveCategory,
            'division'      => $division[0],
            'access'        => $Arr_Akses,
        );

        $this->load->view('Leaveapplications/update', $data);
    }

    public function save()
    {
        $leaveApp_id                           = $this->input->post('leaveApp_id');
        $data                           = $this->input->post();
        $data['id']                   = $leaveApp_id;
        $data['id']                     = $this->autoNumber();
        $data_session                   = $this->session->userdata;
        $data['name']                   = $data_session['Employee']['name'];
        $data['employee_id']            = $data_session['Employee']['id'];
        $data['division_id']            = $data_session['Employee']['division_id'];
        $data['created_by']             = $data_session['User']['id'];
        $data['created_at']             = date('Y-m-d H:i:s');
        $data['modified_by']            = $data_session['User']['id'];
        $data['modified_at']            = date('Y-m-d H:i:s');
        // $oldFile = $this->input->post('old_file');
        // $files = $_FILES;

        $config['upload_path']          = './assets/documents';
        $config['allowed_types']        = 'gif|jpg|png|pdf';
        $config['max_size']             = 2000;
        $config['max_width']            = 1024;
        $config['max_height']           = 1224;
        $config['encrypt_name']         = TRUE;
        $this->upload->initialize($config);
        if ($_FILES['doc_special_leave']['name']) {
            if (!$this->upload->do_upload('doc_special_leave')) {
                $error = $this->upload->display_errors('', '');
                $ArrCollback = [
                    'msg' => $error,
                    'status' => '0'
                ];
                echo json_encode($ArrCollback);
                return false;
            } else {
                $upload = $this->upload->data();
                $ArrCollback = [
                    'msg' => 'Upload Berhasil',
                    'status' => '1'
                ];
                $this->load->helper('file');
                // if ($oldFile) {
                //     unlink($upload['file_path'] . $oldFile);
                // }
                $data['doc_special_leave'] = $upload['file_name'];
            }
        }

        if ($_FILES['doc_notpay_leave']['name']) {
            if (!$this->upload->do_upload('doc_notpay_leave')) {
                $error = $this->upload->display_errors('', '');
                $ArrCollback = [
                    'msg' => $error,
                    'status' => '0'
                ];
                echo json_encode($ArrCollback);
                return false;
            } else {
                $upload = $this->upload->data();
                $ArrCollback = [
                    'msg' => 'Upload Berhasil',
                    'status' => '1'
                ];
                $this->load->helper('file');
                // if ($oldFile) {
                //     unlink($upload['file_path'] . $oldFile);
                // }
                $data['doc_notpay_leave'] = $upload['file_name'];
            }
        }

        $this->db->trans_begin();
        $this->db->insert('leave_applications', $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $ArrCollback        = array(
                'status'        => 0,
                'msg'           => 'Data Pengajuan Cuti gagal disimpan. Mohon ulangi kembali.'
            );
        } else {
            $this->db->trans_commit();
            $ArrCollback        = array(
                'status'        => 1,
                'msg'           => 'Data Pengajuan Cuti berhasil disimpan.'
            );
            history('Add Leave Applications' . $data['employee_id']);
        }

        echo json_encode($ArrCollback);
    }

    public function save_update()
    {
        $leaveApp_id                    = $this->input->post('id');
        $data                           = $this->input->post();
        $data_session                   = $this->session->userdata;
        $data['name']                   = $data_session['Employee']['name'];
        $data['employee_id']            = $data_session['Employee']['id'];
        $data['division_id']            = $data_session['Employee']['division_id'];
        $data['created_by']             = $data_session['User']['id'];
        $data['created_at']             = date('Y-m-d H:i:s');
        $data['modified_by']            = $data_session['User']['id'];
        $data['modified_at']            = date('Y-m-d H:i:s');


        $this->db->trans_begin();
        $this->db->update('leave_applications', $data, array('id' => $leaveApp_id));
        // if (!$leaveApp_id) {
        //     $this->db->insert('leave_applications', $data);
        // } else {
        // }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $ArrCollback        = array(
                'status'        => 0,
                'msg'           => 'Add Leave Application failed. Please try again later.'
            );
        } else {
            $this->db->trans_commit();
            $ArrCollback        = array(
                'status'        => 1,
                'msg'           => 'Add Application leave Success.'
            );
            history('Add Leave Applications' . $data['employee_id']);
        }
        echo json_encode($ArrCollback);
    }

    public function cancel()
    {


        $id = $this->input->post('id');
        $this->db->trans_begin();
        $this->db->update('leave_applications', ['status' => 'CNL'], array('id' => $id));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $ArrCollback        = array(
                'status'        => 0,
                'msg'           => 'Add Leave Application failed. Please try again later.'
            );
        } else {
            $this->db->trans_commit();
            $ArrCollback        = array(
                'status'        => 1,
                'msg'           => 'Add Application leave Success.'
            );
            history('Cancel Leave Applications');
        }
        echo json_encode($ArrCollback);
    }

    public function approve($id)
    {

        echo '<pre>';
        print_r($id);
        echo '<pre>';
        exit;
    }

    public function view($id)
    {


        // $employee           = $this->session->userdata('Employee');
        $employee          = $this->leavesModel->getFind(['id' => $id]);
        $Arr_Akses          = getAcccesmenu($this->controller);
        // $division           = $this->employees_model->getData('divisions', 'id', $employee['division_id']);
        $leaveCategory      = $this->db->get('at_leaves')->result();

        $data = array(
            'title'         => 'Add Leave Applications',
            'action'        => 'add',
            'religi'        => '0',
            'employee'      => $employee[0],
            // 'employees'     => $employees,
            'leaveCategory' => $leaveCategory,
            // 'division'      => $division[0],
            'access'        => $Arr_Akses,
        );
        $this->load->view('Leaveapplications/view', $data);
    }
}
