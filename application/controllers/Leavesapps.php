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

        $get_Data          = $this->leavesModel->getFind(['flag_leave_type' => 'CT', 'status' => 'OPN', 'employee_id' => $employee_id]);
        $employees         = $this->employees_model->getData('employees');
        $phone = [];
        foreach ($employees as $emp) {
            $phone[$emp->id] = preg_replace('/0/', '62', $emp->hp, 1);
        }

        $data = array(
            'title'            => 'Index Leave Applications',
            'action'        => 'index',
            'religi'        => '0',
            'row'           => $get_Data,
            'phone'         => $phone,
            'access'        => $Arr_Akses
        );
        history('View Leave Applications');
        $this->load->view('Leaveapplications/index', $data);
    }

    public function approved()
    {

        $Arr_Akses            = getAcccesmenu($this->controller);
        if ($Arr_Akses['read'] != '1') {
            $this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
            redirect(site_url('dashboard'));
        }
        $id = $this->session->userdata['Employee']['id'];

        $get_Data            = $this->db->query("SELECT * FROM `view_leave_applications` WHERE `status` = 'APV' AND employee_id = '$id'")->result();
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
        $id = $this->session->userdata['Employee']['id'];

        $get_Data            = $this->db->query("SELECT * FROM `view_leave_applications` WHERE `status` = 'HIS' AND employee_id = '$id'")->result();
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


        if ($this->session->userdata('Group')['id'] == 40) {
            $get_Data          = $this->leavesModel->getFind(['status' => 'APV', 'approved_hr' => 'N']);
        } else {
            $get_Data          = $this->leavesModel->getFind(['status' => 'OPN', 'approval_employee_id' => $employee_id, 'flag_leave_type' => 'CT']);
        }

        $employees         = $this->employees_model->getEmployees();
        $data = array(
            'title'         => 'Index Leave Applications',
            'action'        => 'index',
            'religi'        => '0',
            'row'           => $get_Data,
            'employees'     => $employees,
            'access'        => $Arr_Akses
        );

        history('View Leave Applications');
        $this->load->view('Leaveapplications/index', $data);
    }

    public function approvalLeave($id)
    {
        $Arr_Akses            = getAcccesmenu($this->controller . '/approval');
        if ($Arr_Akses['read'] != '1') {
            $this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
            redirect(site_url('dashboard'));
        }

        $leaveApp           = $this->leavesModel->getFind(['id' => $id])[0];
        $employees          = $this->leavesModel->getAllEmployees();
        $totalLeave         = $this->leavesModel->getSumWhere('leave', 'employees_leave', ['employee_id' => $leaveApp->employee_id]);
        // $getLeaveYear       = $this->leavesModel->getSumWhere('get_year_leave', 'leave_applications', ['employee_id' => $employee['id'], 'periode_year' => date('Y'), 'status' => 'APV']);
        // $massLeave          = $this->leavesModel->getMassLeave('at_mass_leaves', $employee['hiredate']);
        $division           = $this->employees_model->getData('divisions', 'id', $leaveApp->division_id)[0];

        $leaveCategory      = $this->db->get('at_leaves')->result();
        $divisionHead       = $this->db->get_where('divisions_head', ['id' => $leaveApp->division_id])->row();
        $freq               = $this->leavesModel->getFreqLeave($leaveApp->id, 'LV001', 'APV');
        $ly                 = ($totalLeave->leave) ? $totalLeave->leave : 0;
        // $gly                = ($getLeaveYear->get_year_leave) ? $getLeaveYear->get_year_leave : 0;
        // $msl                = ($massLeave->count) ? $massLeave->count : 0;
        $data = array(
            'title'         => 'Approval Leave Applications',
            'action'        => 'approvalLeave',
            'religi'        => '0',
            'leaveApp'      => $leaveApp,
            'totalLeave'    => ($ly),
            'employee'      => $leaveApp,
            'employees'     => $employees,
            'leaveCategory' => $leaveCategory,
            'divisionHead'  => $divisionHead,
            'division'      => $division,
            'access'        => $Arr_Akses,
            'freq'          => $freq,
        );
        history('Approval Applications by HR');
        $this->load->view('Leaveapplications/approval_hr', $data);
    }

    public function approveHR()
    {
        $session        = $this->session->userdata;
        $data           = $this->input->post();
        $emp            = $this->db->get_where('leave_applications', ['id' => $data['id']])->row();
        $axis_data      = $this->db->get_where('employees_leave', ['employee_id' => $emp->employee_id])->row();

        $dataEmpLeave   = [
            'id'            => $this->employees_model->code_otomatis('employees_leave', 'EL'),
            'date'          => date('Y-m-d'),
            'employee_id'   => $emp->employee_id,
            'year'          => date('Y'),
            'leave'         => $emp->total_days,
            'description'   => 'Updated by system ##Abil Cuti@' . $emp->from_date,
            'created_by'    => $session['User']['username'],
            'created'       => date('Y-m-d H:i:s')
        ];



        if ($data) {
            $ArrData = [
                'approved_hr'        => 'Y',
                'approved_hr_by'     => $this->session->userdata('User')['id'],
                'approved_hr_at'     => date('Y-m-d H:i:s'),
                'alpha_value'        => $data['alpha'],
                'actual_leave'       => $data['actual_leave'],
                'flag_alpha'         => ($data['alpha']) ? 'Y' : 'N',
                'modified_by'        => $this->session->userdata('User')['id'],
                'modified_at'        => date('Y-m-d H:i:s')
            ];

            $this->db->trans_begin();
            $this->db->update('leave_applications', $ArrData, array('id' => $data['id']));
            if ($axis_data) {
                unset($dataEmpLeave['id']);
                $dataEmpLeave['leave'] = $axis_data->leave - $data['actual_leave'];
                $this->db->where('employee_id', $emp->employee_id)->update('employees_leave', $dataEmpLeave);
            } else {
                $this->db->insert('employees_leave', $dataEmpLeave);
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $ArrCollback        = array(
                    'status'        => 0,
                    'msg'           => 'Proses Approve Cuti gagal diproses. Mohon ulangi kembali.'
                );
            } else {
                $this->db->trans_commit();
                $ArrCollback        = array(
                    'status'        => 1,
                    'msg'           => 'Proses Approve Cuti berhasil.'
                );
                history('Save Leave Applications' . $data['id']);
            }
        }

        echo json_encode($ArrCollback);
    }

    public function cancel_reject()
    {

        $Arr_Akses            = getAcccesmenu($this->controller);
        if ($Arr_Akses['read'] != '1') {
            $this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
            redirect(site_url('dashboard'));
        }

        $get_Data            = $this->db->query("SELECT * FROM `view_leave_applications` WHERE (`status` = 'CNL' or `status` = 'REJ') and employee_id = '" . $this->session->User['employee_id'] . "'")->result();
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

    public function revision()
    {

        $Arr_Akses            = getAcccesmenu($this->controller);
        if ($Arr_Akses['read'] != '1') {
            $this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
            redirect(site_url('dashboard'));
        }

        $get_Data            = $this->db->query("SELECT * FROM `view_leave_applications` WHERE (`status`= 'REV') and employee_id = '" . $this->session->User['employee_id'] . "'")->result();
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

        $getHoliday = $this->db->get('at_holidays')->result_array();
        $holiday = [];
        foreach ($getHoliday as $hday) {
            $dates = date('Ymd', strtotime($hday['date']));
            $holiday[$dates] = $hday['name'];
        }
        // $holidays = $holiday;

        // $holiday = json_decode(file_get_contents('https://raw.githubusercontent.com/guangrei/Json-Indonesia-holidays/master/calendar.json', true));

        $days = 0;
        $holiDay = [];
        foreach ($datePeriod as $dperiod) {
            $date = $dperiod->format('Ymd');
            if (isset($holiday[$date])) {
                $holiDay = [
                    'holiday'   => date("Y-m-d", strtotime($date)),
                    'deskripsi' => $holiday[$date]
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
        // echo '<pre>';
        // print_r($days);
        // echo '<pre>';
        // exit;

        $ArrCollback = [
            'days'      => $days,
            'holiDay'   => $holiDay,
        ];

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
        if (!$employee) {
            $this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Login as Employee....</div>");
            redirect(site_url($this->controller));
        }
        $freq               = $this->leavesModel->getFreqLeave($employee['id'], 'LV001', 'APV');
        $Arr_Akses          = getAcccesmenu($this->controller);
        $totalLeave         = $this->leavesModel->getSumWhere('leave', 'employees_leave', ['employee_id' => $employee['id']]);
        // $getLeaveYear       = $this->leavesModel->getSumWhere('get_year_leave', 'leave_applications', ['employee_id' => $employee['id'], 'periode_year' => date('Y'), 'status' => 'APV']);
        // $massLeave          = $this->leavesModel->getMassLeave('at_mass_leaves', $employee['hiredate']);
        $division           = $this->employees_model->getData('divisions', 'id', $employee['division_id']);
        $leaveCategory      = $this->db->order_by('id', 'ASC')->get('at_leaves')->result();
        $divisionHead       = $this->db->get_where('divisions_head', ['id' => $employee['division_head']])->row();
        $ly                 = ($totalLeave->leave) ? $totalLeave->leave : 0;
        // $gly                = ($getLeaveYear->get_year_leave) ? $getLeaveYear->get_year_leave : 0;
        // $msl                = ($massLeave->count) ? $massLeave->count : 0;

        $data = array(
            'title'         => 'Add Leave Applications',
            'action'        => 'add',
            'religi'        => '0',
            // 'totalLeave'    => ($ly) - ($gly) - ($msl),
            'totalLeave'    => ($ly),
            'employee'      => $employee,
            'divisionHead'  => $divisionHead,
            'leaveCategory' => $leaveCategory,
            'division'      => $division[0],
            'access'        => $Arr_Akses,
            'freq'          => $freq,
        );
        $this->load->view('Leaveapplications/add', $data);
    }

    public function update($id)
    {
        $leaveApp           = $this->leavesModel->getFind(['id' => $id]);
        $employee           = $this->session->userdata('Employee');
        $employees          = $this->leavesModel->getAllEmployees();
        $Arr_Akses          = getAcccesmenu($this->controller);
        $totalLeave         = $this->leavesModel->getSumWhere('leave', 'employees_leave', ['employee_id' => $employee['id']]);
        // $getLeaveYear       = $this->leavesModel->getSumWhere('get_year_leave', 'leave_applications', ['employee_id' => $employee['id'], 'periode_year' => date('Y'), 'status' => 'APV']);
        // $massLeave          = $this->leavesModel->getMassLeave('at_mass_leaves', $employee['hiredate']);
        $division           = $this->employees_model->getData('divisions', 'id', $employee['division_id']);
        $leaveCategory      = $this->db->get('at_leaves')->result();
        $divisionHead       = $this->db->get_where('divisions_head', ['id' => $employee['division_head']])->row();
        $freq               = $this->leavesModel->getFreqLeave($employee['id'], 'LV001', 'APV');
        $ly                 = ($totalLeave->leave) ? $totalLeave->leave : 0;
        // $gly                = ($getLeaveYear->get_year_leave) ? $getLeaveYear->get_year_leave : 0;
        // $msl                = ($massLeave->count) ? $massLeave->count : 0;
        $data = array(
            'title'         => 'Add Leave Applications',
            'action'        => 'add',
            'religi'        => '0',
            'leaveApp'      => $leaveApp[0],
            // 'totalLeave'    => ($ly) - ($gly) - ($msl),
            'totalLeave'    => ($ly),
            'employee'      => $employee,
            'employees'     => $employees,
            'leaveCategory' => $leaveCategory,
            'divisionHead'  => $divisionHead,
            'division'      => $division[0],
            'access'        => $Arr_Akses,
            'freq'          => $freq,
        );


        $this->load->view('Leaveapplications/update', $data);
    }

    public function update_revision($id)
    {
        $leaveApp           = $this->leavesModel->getFind(['id' => $id]);
        $employee           = $this->session->userdata('Employee');
        $employees          = $this->leavesModel->getAllEmployees();
        $Arr_Akses          = getAcccesmenu($this->controller);
        $totalLeave         = $this->leavesModel->getSumWhere('leave', 'employees_leave', ['employee_id' => $employee['id']]);
        // $getLeaveYear       = $this->leavesModel->getSumWhere('get_year_leave', 'leave_applications', ['employee_id' => $employee['id'], 'periode_year' => date('Y'), 'status' => 'APV']);
        // $massLeave          = $this->leavesModel->getMassLeave('at_mass_leaves', $employee['hiredate']);
        $division           = $this->employees_model->getData('divisions', 'id', $employee['division_id']);
        $leaveCategory      = $this->db->get('at_leaves')->result();
        $divisionHead       = $this->db->get_where('divisions_head', ['id' => $employee['division_head']])->row();
        $freq               = $this->leavesModel->getFreqLeave($employee['id'], 'LV001', 'APV');
        $ly                 = ($totalLeave->leave) ? $totalLeave->leave : 0;
        // $gly                = ($getLeaveYear->get_year_leave) ? $getLeaveYear->get_year_leave : 0;
        // $msl                = ($massLeave->count) ? $massLeave->count : 0;
        $data = array(
            'title'         => 'Add Leave Applications',
            'action'        => 'add',
            'religi'        => '0',
            'leaveApp'      => $leaveApp[0],
            // 'totalLeave'    => ($ly) - ($gly) - ($msl),
            'totalLeave'    => ($ly),
            'employee'      => $employee,
            'employees'     => $employees,
            'leaveCategory' => $leaveCategory,
            'divisionHead'  => $divisionHead,
            'division'      => $division[0],
            'access'        => $Arr_Akses,
            'freq'          => $freq,
        );

        $this->load->view('Leaveapplications/update', $data);
    }

    public function save()
    {
        $leaveApp_id                    = $this->input->post('id');
        $flag_revision                  = $this->input->post('flag_revision');
        $no_rev                         = $this->input->post('no_revision');
        $data                           = $this->input->post();

        $data['id']                     = ($leaveApp_id != '' && $flag_revision == 'N') ? $leaveApp_id : $this->autoNumber();
        $data_session                   = $this->session->userdata;
        $data['flag_leave_type']        = 'CT';
        $data['name']                   = $data_session['Employee']['name'];
        $data['employee_id']            = $data_session['Employee']['id'];
        $data['division_id']            = $data_session['Employee']['division_id'];
        $data['company_id']             = $data_session['Company']->company_id;
        $data['branch_id']              = $data_session['Company']->branch_id;
        $data['created_by']             = $data_session['User']['username'];
        $data['created_at']             = date('Y-m-d H:i:s');
        $data['modified_by']            = $data_session['User']['username'];
        $data['modified_at']            = date('Y-m-d H:i:s');

        $config['upload_path']          = './assets/documents';
        $config['allowed_types']        = 'gif|jpg|png|pdf|jpeg';
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
                if ($data['doc_special_old']) {
                    unlink($upload['file_path'] . $data['doc_special_old']);
                }
                $data['doc_special_leave'] =  $upload['file_name'];
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
                if ($data['doc_notpay_old']) {
                    unlink($upload['file_path'] . $data['doc_notpay_old']);
                }
                $data['doc_notpay_leave'] =  $upload['file_name'];
            }
        }

        if ($_FILES['doc_sick_leave']['name']) {
            if (!$this->upload->do_upload('doc_sick_leave')) {
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
                if ($data['doc_sick_old']) {
                    unlink($upload['file_path'] . $data['doc_sick_old']);
                }
                $data['doc_sick_leave'] = $upload['file_name'];
            }
        }

        unset($data['doc_notpay_old']);
        unset($data['doc_sick_old']);
        unset($data['doc_special_old']);

        $this->db->trans_begin();
        if (!$leaveApp_id) {
            $this->db->insert('leave_applications', $data);
        } elseif ($flag_revision == 'Y') {
            $data['flag_revision'] = 'N';
            $data['no_revision'] = ($no_rev == '' || $no_rev == null || $no_rev = '0') ? '1' : $no_rev + 1;
            $this->db->insert('leave_applications', $data);
            $this->db->update('leave_applications', ['status' => 'HIS'], array('id' => $leaveApp_id));
        } else {
            $data['status']                 = 'OPN';
            $data['modified_by']            = $data_session['User']['username'];
            $data['modified_at']            = date('Y-m-d H:i:s');
            $this->db->update('leave_applications', $data, array('id' => $leaveApp_id));
        }

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
            history('Save Leave Applications' . $data['employee_id']);
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

    public function process_approval()
    {
        $id = $this->input->post('id');
        $act = $this->input->post('act');
        $note = $this->input->post('note');
        $leave      = $this->db->get_where('view_leave_applications', ['id' => $id])->row();
        $absen = $this->db->get_where('users', ['employee_id' => $leave->employee_id])->row();
        $data = [];
        $dataAbsen = [];
        if ($act == 'approve') {
            $msg_stat = 'Approval';
            $status = 'APV';
            $data['approved_at'] = date('Y-m-d H:i:s');
            $dataAbsen = [
                'employee_id' => $leave->employee_id,
                'user_id' => $absen->username,
                'flag_cuti' => 'C',
                'waktu' => date('Y-m-d H:i:s', strtotime($leave->from_date))
            ];

            // if ($leave->get_year_leave) {
            //     $data['flag_leave_type'] = 'CT';
            // }
            // $this->_updateSummary($id, $leave);
        } elseif ($act == 'reject') {
            $msg_stat = 'Reject';
            $status = 'REJ';
        } elseif ($act == 'revisi') {
            $msg_stat = 'Revision';
            $status = 'REV';
            $data['flag_revision'] = 'Y';
        } elseif ($act == 'aplha') {
            $msg_stat = 'Alpha';
            $status = 'APV';
            $data['aplha_value'] = $leave->applied_leave;
            $data['get_year_leave'] = $leave->applied_leave;
            $data['remaining_leave'] = ($leave->unused_leave) - ($leave->applied_leave);
        } else {
            $msg_stat = 'Process';
            $status = 'OPN';
        }

        $data += [
            'status' => $status,
            'note' => $note
        ];

        $fromUser       = $this->session->userdata['Employee'];
        // $head        = $this->db->get_where('divisions_head', ['id' => $leave->approval_by])->row();
        $toUser         = $this->db->get_where('employees', ['id' => $leave->employee_id])->row();

        $this->db->trans_begin();
        if ($data) {
            $this->db->update('leave_applications', $data, array('id' => $id));
        }
        if ($dataAbsen) {
            $this->db->insert('absensi_log', $dataAbsen);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $ArrCollback        = array(
                'status'        => 0,
                'msg'           => $msg_stat . ' Leave Application failed. Please try again later.'
            );
        } else {
            $this->db->trans_commit();
            // $sendEmail = $this->_sendToEmail($leave, $fromUser, $toUser);
            $ArrCollback        = array(
                'status'        => 1,
                'msg'           => $msg_stat . ' Application leave Success.'
            );

            // if ($sendEmail == true) {
            //     $ArrCollback        = array(
            //         'status'        => 1,
            //         'msg'           => $msg_stat . ' Application leave Success and Send Email Success.'
            //     );
            // } else {
            //     $ArrCollback        = array(
            //         'status'        => 1,
            //         'msg'           => $msg_stat . ' Application leave Success but Send Email Failed.',
            //         'email_error'   =>  $this->email->print_debugger()
            //     );
            // }
            history($msg_stat . ' Leave Applications');
        }
        echo json_encode($ArrCollback);
    }

    public function view_approval($id)
    {
        // $employee           = $this->session->userdata('Employee');
        $employee          = $this->leavesModel->getFind(['id' => $id])[0];
        $Arr_Akses          = getAcccesmenu($this->controller);
        // $division           = $this->employees_model->getData('divisions', 'id', $employee['division_id']);
        // echo '<pre>';
        // print_r($employee);
        // echo '<pre>';
        // exit;
        $leaveCategory      = $this->db->get('at_leaves')->result();
        $data = array(
            'title'         => 'View Leave Applications',
            'action'        => 'add',
            'religi'        => '0',
            'employee'      => $employee,
            'leaveCategory' => $leaveCategory,
            'access'        => $Arr_Akses,
        );
        $this->load->view('Leaveapplications/approve', $data);
    }

    public function view($id)
    {
        // $employee           = $this->session->userdata('Employee');
        $employee          = $this->leavesModel->getFind(['id' => $id]);
        $Arr_Akses          = getAcccesmenu($this->controller);
        $employees          = $this->employees_model->getEmployees();
        // $division           = $this->employees_model->getData('divisions', 'id', $employee['division_id']);
        $leaveCategory      = $this->db->get('at_leaves')->result();

        $data = array(
            'title'         => 'View Leave Applications',
            'action'        => 'add',
            'religi'        => '0',
            'employee'      => $employee[0],
            'employees'      => $employees,
            'leaveCategory' => $leaveCategory,
            'access'        => $Arr_Akses,
        );

        $this->load->view('Leaveapplications/view', $data);
    }

    public function sendEmail()
    {
        $id         = $this->input->post('id');
        if ($id) {
            $leave      = $this->db->get_where('view_leave_applications', ['id' => $id])->row();
            $fromUser  = $this->session->userdata['Employee'];
            $head       = $this->db->get_where('divisions_head', ['id' => $leave->approval_by])->row();
            $toUser    = $this->db->get_where('employees', ['id' => $head->employee_id])->row();

            if ($this->_sendToEmail($leave, $fromUser, $toUser)) {
                $collback = [
                    'status' => 1,
                    'msg' => 'Data berhasil terkirim'
                ];
            } else {
                $collback = [
                    'status' => 0,
                    'msg' => 'Data gagal terkirim',
                    'error' => $this->email->print_debugger(),
                ];
            }
        } else {
            $collback = [
                'status' => 0,
                'msg' => 'Data gagal terkirim',
                'error' => '',
            ];
        }
        echo json_encode($collback);
    }

    protected function _sendToEmail($leave = null, $fromUser = null, $toUser = null)
    {

        $EmployeName = $leave->name;
        $dateCreated = date('D, d M Y', strtotime($leave->created_at));
        $mail = $this->db->get('config_email')->row();
        if ($leave->status == 'OPN') :
            $status = '<label class="label-info label">Waiting Approval</label>';
        elseif ($leave->status == 'APV') :
            $status = '<label class="label-success label">Approved</label>';
        elseif ($leave->status == 'CNL') :
            $status = '<label class="label-default label">Cancel</label>';
        elseif ($leave->status == 'REJ') :
            $status = '<label class="label-danger label">Rejected</label>';
        endif;

        if ($mail) {
            $config = array(
                'protocol'  => $mail->protocol,
                'smtp_host' => $mail->smtp_host,
                'smtp_port' => $mail->smtp_port,
                'smtp_user' => $mail->email_user,
                'smtp_pass' => $mail->password,
                'mailtype'  => $mail->mail_type,
                'SMTPCrypto'  => 'tls',
                'charset'   => 'iso-8859-1',
                'SMTPTimeout'  => 30
            );

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->set_mailtype('html');
            $this->email->from($mail->email_user, 'HARIS Sentral Sistem');
            $this->email->to($toUser->email);
            $this->email->subject("PENGAJUAN CUTI -  $EmployeName");
            $this->email->message('
            <html>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
            <body style="width:100%;background:#fefefe;padding:10px">
                <p style="margin:auto;text-align:center">Berikut Form pepngajuan cuti atas nama <strong>' . $EmployeName . '</strong></p>
                <hr>
                <div style="text-align:center;margin:auto;">
                    <h3><strong>PENGAJUAN CUTI KARYAWAN</strong></h3>
                    <h4><strong>PT SENTAL TEHNOLOGI MANAGEMEN</strong></h4>
                </div>
                <hr>
                <div style="text-align:center;padding:20px">
                <a href="' . base_url('login') . '" style="margin:20px auto;padding:10px;background:blue;color:#fff">Login</a>
                </div>
            </body>
            </html>
            ');

            if ($this->email->send()) {
                $result = true;
            } else {
                $result = false;
            }
            return $result;
        }
    }
}
