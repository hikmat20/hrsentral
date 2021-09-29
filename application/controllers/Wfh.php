<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Wfh extends CI_Controller
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
        $this->status = [
            'OPN' => '<span class="label font-light label-warning">Waiting Approval</span>',
            'APV' => '<span class="label font-light label-success">Approved</span>',
            'REJ' => '<span class="label font-light label-danger">Reject</span>',
            'CNL' => '<span class="label font-light label-default">Cancel</span>n>',
            'HIS' => '<span class="label font-light bg-purple">History</span>',
            'REV' => '<span class="label font-light label-info">Revision</span>',
            'N'   => '<span class="label font-light label-warning">Waiting Approval</span>',
            'Y'   => '<span class="label font-light label-success">Approved</span>',
            '' => '<span class="label label-default">Unknow Status</span>',
        ];
    }

    public function index()
    {

        $Arr_Akses            = getAcccesmenu($this->controller);
        $employee_id          = $this->session->User['employee_id'];
        if ($Arr_Akses['read'] != '1') {
            $this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
            redirect(site_url('dashboard'));
        }

        $get_Data          = $this->db->get_where('view_wfh', ['approved_hr' => 'N', 'employee_id' => $employee_id])->result();
        $employees         = $this->employees_model->getData('employees');

        $phone = [];
        foreach ($employees as $emp) {
            $phone[$emp->id] = preg_replace('/0/', '62', $emp->hp, 1);
        }

        $data = array(
            'title'            => 'Index Work From Home',
            'action'        => 'index',
            'religi'        => '0',
            'row'           => $get_Data,
            'phone'         => $phone,
            'access'        => $Arr_Akses,
            'status'        => $this->status
        );
        history('View Wfh Applications');
        $this->load->view('Wfh/index', $data);
    }

    public function autoNumber($table = '', $code = '')
    {

        $sql = "SELECT MAX(RIGHT(id,4)) maxId FROM work_from_home WHERE SUBSTR(id,3, 2) = '" . date('y') . "' ORDER by id DESC";
        $idMax = $this->db->query($sql)->row();
        if ($idMax->maxId == '') {
            $count = '1';
        } else {
            $count = $idMax->maxId + 1;
        }

        return 'WH' . date('y') . str_pad($count, 4, "0", STR_PAD_LEFT);
    }

    public function add()
    {
        $Arr_Akses          = getAcccesmenu($this->controller);
        if (!$Arr_Akses) {
            $this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Login as Employee....</div>");
            redirect(site_url($this->controller));
        }

        $employee           = $this->session->userdata('Employee');
        $division           = $this->employees_model->getData('divisions', 'id', $employee['division_id']);
        $divisionHead       = $this->db->get_where('divisions_head', ['id' => $employee['division_head']])->row();
        $data = array(
            'title'         => 'Add WFH Applications',
            'action'        => 'add',
            'employee'      => $employee,
            'divisionHead'  => $divisionHead,
            'division'      => $division[0],
            'access'        => $Arr_Akses,
        );
        $this->load->view('Wfh/add', $data);
    }

    public function edit($id)
    {
        $Arr_Akses          = getAcccesmenu($this->controller);
        $employee           = $this->session->userdata('Employee');
        $wfh                = $this->db->get_where('view_wfh', ['id' => $id])->row();
        $employees          = $this->leavesModel->getAllEmployees();
        $division           = $this->employees_model->getData('divisions', 'id', $employee['division_id']);
        $divisionHead       = $this->db->get_where('divisions_head', ['id' => $employee['division_head']])->row();
        $works              = $this->db->get_where('works', ['leave_id' => $id])->result();
        $data = array(
            'title'         => 'Edit WFH Applications',
            'action'        => 'Edit',
            'religi'        => '0',
            'wfh'           => $wfh,
            'works'         => $works,
            'employee'      => $employee,
            'employees'     => $employees,
            'divisionHead'  => $divisionHead,
            'division'      => $division[0],
            'access'        => $Arr_Akses,
        );

        $this->load->view('Wfh/edit', $data);
    }

    public function save()
    {

        $id                             = $this->input->post('id');
        $flag_revision                  = $this->input->post('flag_revision');
        $no_rev                         = $this->input->post('no_revision');
        $data                           = $this->input->post();
        $data_session                   = $this->session->userdata;
        $data['id']                     = ($id != '' && $flag_revision == 'N') ? $id : $this->autoNumber();
        $data['company_id']             = $data_session['Company']->company_id;
        $data['branch_id']              = $data_session['Company']->branch_id;

        $this->db->trans_begin();
        if (!$id) {
            $data['created_by']             = $data_session['User']['username'];
            $data['created_at']             = date('Y-m-d H:i:s');
            if ($data['works']) {
                foreach ($data['works'] as $key => $works) {
                    $data['works'][$key]['employee_id']   = $data['employee_id'];
                    $data['works'][$key]['leave_id']      = $data['id'];
                }
                $this->db->insert_batch('works', $data['works']);
            }
            unset($data['works']);
            $this->db->insert('work_from_home', $data);
        } elseif ($flag_revision == 'Y') {
            $data['flag_revision']      = 'N';
            $data['no_revision']        = ($no_rev == '' || $no_rev == null || $no_rev = '0') ? '1' : $no_rev + 1;
            $data['created_by']         = $data_session['User']['username'];
            $data['created_at']         = date('Y-m-d H:i:s');
            if ($data['works']) {
                foreach ($data['works'] as $key => $works) {
                    $data['works'][$key]['employee_id']   = $data['employee_id'];
                    $data['works'][$key]['leave_id']      = $data['id'];
                }
                $this->db->insert_batch('works', $data['works']);
            }
            unset($data['works']);
            $this->db->insert('work_from_home', $data);
            $his['modified_by']         = $data_session['User']['username'];
            $his['modified_at']         = date('Y-m-d H:i:s');
            $his['status']              = 'HIS';
            $this->db->update('work_from_home', $his, array('id' => $id));
        } else {
            $data['status']                 = 'OPN';
            $data['modified_by']            = $data_session['User']['username'];
            $data['modified_at']            = date('Y-m-d H:i:s');
            if ($data['works']) {
                foreach ($data['works'] as $key => $works) {
                    $data['works'][$key]['employee_id']   = $data['employee_id'];
                    $data['works'][$key]['leave_id']      = $data['id'];
                    $data['works'][$key]['type']          = 'WFH';
                }
                $this->db->delete('works', ['leave_id' => $data['id']]);
                $this->db->insert_batch('works', $data['works']);
            };
            unset($data['works']);
            $this->db->update('work_from_home', $data, array('id' => $id));
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $ArrCollback        = array(
                'status'        => 0,
                'msg'           => 'Data Pengajuan WFH gagal disimpan. Mohon ulangi kembali.'
            );
        } else {
            $this->db->trans_commit();
            $ArrCollback        = array(
                'status'        => 1,
                'msg'           => 'Data WFH berhasil disimpan.'
            );
            history('Save WFH Applications' . $data['employee_id']);
        }
        echo json_encode($ArrCollback);
    }

    public function delete_work()
    {
        $id = $this->input->post('id');

        if ($id) {
            $this->db->trans_begin();
            $this->db->where('id', $id)->delete('works');

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $return = [
                    'status' => 0,
                    'msg'   => 'Data gagal dihapus. Mohon coba beberapsa saat lagi.'
                ];
            } else {
                $this->db->trans_commit();
                $return = [
                    'status' => 1,
                    'msg'   => 'Data berhasil dihapus.'
                ];
            }
        } else {
            $return = [
                'status' => 0,
                'msg'   => 'Data tidak terkirim. Mohon coba beberapsa saat lagi.'
            ];
        }

        echo json_encode($return);
    }

    public function approved()
    {

        $Arr_Akses            = getAcccesmenu($this->controller);
        if ($Arr_Akses['read'] != '1') {
            $this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
            redirect(site_url('dashboard'));
        }
        $id = $this->session->userdata['Employee']['id'];

        $get_Data            = $this->db->query("SELECT * FROM `view_leave_applicationswfhRE `status` = 'APV' AND employee_id = '$id'")->result();
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

        $get_Data            = $this->db->query("SELECT * FROM `view_leave_applicationswfhRE `status` = 'HIS' AND employee_id = '$id'")->result();
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

    public function approval($id = '')
    {
        $Arr_Akses            = getAcccesmenu($this->controller . '/approval');
        $employee_id          = $this->session->User['employee_id'];

        if ($Arr_Akses['read'] != '1') {
            $this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
            redirect(site_url('dashboard'));
        }

        if (!$id) {
            if ($this->session->Group['id'] == 40) {
                $data          = $this->db->where(['status' => 'APV', 'approved_hr' => 'N'])->get('view_wfh')->result();
            } else {
                $data          = $this->db->where(['status' => 'OPN', 'approval_employee_id' => $employee_id])->or_where(['employee_id' => $employee_id])->get('view_wfh')->result();
            }

            $employees         = $this->employees_model->getData('employees');
            $phone = [];
            foreach ($employees as $emp) {
                $phone[$emp->id] = preg_replace('/0/', '62', $emp->hp, 1);
            }

            $data = array(
                'title'         => 'Index WFH Applications',
                'action'        => 'Approval',
                'status'        => $this->status,
                'row'           => $data,
                'phone'         => $phone,
                'access'        => $Arr_Akses
            );
            history('Index WFH Applications');
            $this->load->view('Wfh/index', $data);
        } else {
            $employee           = $this->db->get_where('view_wfh', ['id' => $id])->row();
            $works              = $this->db->get_where('works', ['leave_id' => $id])->result();

            $data = array(
                'title'         => 'Index WFH Applications',
                'action'        => 'Approval',
                'sts'           => $this->status,
                'data'          => $employee,
                'works'         => $works,
                'access'        => $Arr_Akses
            );

            history('View Cuti Pengganti');
            $this->load->view('Wfh/approval', $data);
        }
    }

    public function update($id = '')
    {
        $Arr_Akses            = getAcccesmenu($this->controller);
        if (!$Arr_Akses) {
            $this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Login as Employee....</div>");
            redirect(site_url($this->controller));
        }

        $wfh                = $this->db->get_where('view_wfh', ['id' => $id])->row();
        $works              = $this->db->get_where('works', ['leave_id' => $id])->result();

        $data = array(
            'title'         => 'Update WFH Applications',
            'action'        => 'update',
            'wfh'           => $wfh,
            'works'         => $works,
            'update'        => true,
            'access'        => $Arr_Akses
        );
        $this->load->view('Wfh/edit', $data);
    }

    public function cancel_reject()
    {

        $Arr_Akses            = getAcccesmenu($this->controller);
        if ($Arr_Akses['read'] != '1') {
            $this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
            redirect(site_url('dashboard'));
        }

        $get_Data            = $this->db->query("SELECT * FROM `view_leave_applicationswfhRE (`status` = 'CNL' or `status` = 'REJ') and employee_id = '" . $this->session->User['employee_id'] . "'")->result();
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

        $get_Data            = $this->db->query("SELECT * FROM `view_leave_applicationswfhRE (`status`= 'REV') and employee_id = '" . $this->session->User['employee_id'] . "'")->result();
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

    public function cancel()
    {
        $id = $this->input->post('id');
        $this->db->trans_begin();
        $this->db->update('work_from_home', ['status' => 'CNL'], array('id' => $id));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $ArrCollback        = array(
                'status'        => 0,
                'msg'           => 'Cancel WFH Applications failed. Please try again later.'
            );
        } else {
            $this->db->trans_commit();
            $ArrCollback        = array(
                'status'        => 1,
                'msg'           => 'Cancel WFH Application leave Success.'
            );
            history('Cancel WFH Applications');
        }
        echo json_encode($ArrCollback);
    }

    public function save_approve()
    {
        $session        = $this->session->userdata;
        $id             = $this->input->post('id');
        $employee_id    = $this->input->post('employee_id');
        $works          = $this->input->post('works');

        $this->db->trans_begin();
        if ($id) {
            $data['modified_by']             = $session['User']['username'];
            $data['modified_at']             = date('Y-m-d H:i:s');
            $data['approved_at']             = date('Y-m-d H:i:s');
            $data['status']                  = 'APV';
            $this->db->where('id', $id)->update('work_from_home', $data);
            if ($works) {
                foreach ($works as $key => $wr) {
                    $data['works'][$key]['employee_id']     = $employee_id;
                    $data['works'][$key]['leave_id']        = $id;
                    $data['works'][$key]['work_planning']   = $wr['work_planning'];
                    $data['works'][$key]['qty_planning']    = $wr['qty_planning'];
                }
                // $this->db->delete('works', ['leave_id' => $id]);
                $this->db->insert_batch('works', $data['works']);
            };
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $ArrCollback        = array(
                'status'        => 0,
                'msg'           => 'Data WFH gagal disetujui. Mohon ulangi kembali.'
            );
        } else {
            $this->db->trans_commit();
            $ArrCollback        = array(
                'status'        => 1,
                'msg'           => 'Data WFH berhasil disetujui.'
            );
            history('Persetujuan WFH' . $id);
        }

        echo json_encode($ArrCollback);
    }

    public function save_approve_hr()
    {
        $session        = $this->session->userdata;
        $id             = $this->input->post('id');
        $emp            = $this->db->get_where('view_wfh', ['id' => $id])->row();

        $this->db->trans_begin();

        if ($id) {
            $data['modified_by']             = $session['User']['username'];
            $data['modified_at']             = date('Y-m-d H:i:s');
            $data['approved_hr_at']          = date('Y-m-d H:i:s');
            $data['approved_hr_by']          = $session['User']['username'];
            $data['approved_hr']             = 'Y';
            $this->db->where('id', $id)->update('work_from_home', $data);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $ArrCollback        = array(
                'status'        => 0,
                'msg'           => 'Data Pengajuan WFH gagal disetujui. Mohon ulangi kembali.'
            );
        } else {
            $this->db->trans_commit();
            $ArrCollback        = array(
                'status'        => 1,
                'msg'           => 'Data Pengajuan WFH berhasil disetujui.'
            );
            history('Persetujuan WFH ' . $id);
        }
        echo json_encode($ArrCollback);
    }

    public function view($id)
    {
        $Arr_Akses          = getAcccesmenu($this->controller);
        $wfh                = $this->db->get_where('view_wfh', ['id' => $id])->row();
        $works              = $this->db->get_where('works', ['leave_id' => $id])->result();

        $data = array(
            'title'         => 'View Leave Applications',
            'action'        => 'View',
            'religi'        => '0',
            'wfh'           => $wfh,
            'works'         => $works,
            'sts'           => $this->status,
            'access'        => $Arr_Akses,
        );

        $this->load->view('Wfh/view', $data);
    }

    public function sendEmail()
    {
        $id         = $this->input->post('id');
        if ($id) {
            $leave      = $this->db->get_where('view_wfh', ['id' => $id])->row();
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
