<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lembur extends CI_Controller
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

        $get_Data          = $this->db->get_where('view_overtime', ['approved_hr' => 'N', 'employee_id' => $employee_id])->result();
        $employees         = $this->employees_model->getData('employees');

        $phone = [];
        foreach ($employees as $emp) {
            $phone[$emp->id] = preg_replace('/0/', '62', $emp->hp, 1);
        }

        $data = array(
            'title'            => 'Index Lembur',
            'action'        => 'index',
            'row'           => $get_Data,
            'phone'         => $phone,
            'access'        => $Arr_Akses,
            'status'        => $this->status
        );
        history('View Lembur Applications');
        $this->load->view('Lembur/index', $data);
    }

    public function autoNumber($table = '', $code = '')
    {

        $sql = "SELECT MAX(RIGHT(id,4)) maxId FROM overtime WHERE SUBSTR(id,3, 2) = '" . date('y') . "' ORDER by id DESC";
        $idMax = $this->db->query($sql)->row();
        if ($idMax->maxId == '') {
            $count = '1';
        } else {
            $count = $idMax->maxId + 1;
        }

        return 'OT' . date('y') . str_pad($count, 4, "0", STR_PAD_LEFT);
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
            'title'         => 'Add Lembur',
            'action'        => 'add',
            'employee'      => $employee,
            'divisionHead'  => $divisionHead,
            'division'      => $division[0],
            'access'        => $Arr_Akses,
        );
        $this->load->view('Lembur/add', $data);
    }

    public function edit($id)
    {
        $Arr_Akses          = getAcccesmenu($this->controller);
        $overtime           = $this->db->get_where('view_overtime', ['id' => $id])->row();
        $works              = $this->db->get_where('works', ['leave_id' => $id])->result();
        $data = array(
            'title'         => 'Edit Lembur Applications',
            'action'        => 'Edit',
            'ovt'           => $overtime,
            'works'         => $works,
            'access'        => $Arr_Akses,
        );

        $this->load->view('Lembur/edit', $data);
    }

    public function save()
    {
        $id                             = $this->input->post('id');
        $data                           = $this->input->post();
        $data['id']                     = ($id) ? $id : $this->autoNumber();
        $data_session                   = $this->session->userdata;
        $data['company_id']             = $data_session['Company']->company_id;
        $data['branch_id']              = $data_session['Company']->branch_id;
        // $flag_revision                  = $this->input->post('flag_revision');
        // $no_rev                         = $this->input->post('no_revision');

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
            $this->db->insert('overtime', $data);
        }
        // elseif ($flag_revision == 'Y') {
        //     $data['flag_revision']      = 'N';
        //     $data['no_revision']        = ($no_rev == '' || $no_rev == null || $no_rev = '0') ? '1' : $no_rev + 1;
        //     $data['created_by']         = $data_session['User']['username'];
        //     $data['created_at']         = date('Y-m-d H:i:s');
        //     if ($data['works']) {
        //         foreach ($data['works'] as $key => $works) {
        //             $data['works'][$key]['employee_id']   = $data['employee_id'];
        //             $data['works'][$key]['leave_id']      = $data['id'];
        //         }
        //         $this->db->insert_batch('works', $data['works']);
        //     }
        //     unset($data['works']);
        //     $this->db->insert('overtime', $data);
        //     $his['modified_by']         = $data_session['User']['username'];
        //     $his['modified_at']         = date('Y-m-d H:i:s');
        //     $his['status']              = 'HIS';
        //     $this->db->update('overtime', $his, array('id' => $id));
        // } 
        else {
            $data['status']                 = 'OPN';
            $data['modified_by']            = $data_session['User']['username'];
            $data['modified_at']            = date('Y-m-d H:i:s');
            if ($data['works']) {
                foreach ($data['works'] as $key => $works) {
                    $data['works'][$key]['employee_id']   = $data['employee_id'];
                    $data['works'][$key]['leave_id']      = $data['id'];
                    $data['works'][$key]['type']          = 'OT';
                }
                $this->db->delete('works', ['leave_id' => $data['id']]);
                $this->db->insert_batch('works', $data['works']);
            };
            unset($data['works']);
            $this->db->update('overtime', $data, array('id' => $id));
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $ArrCollback        = array(
                'status'        => 0,
                'msg'           => 'Data Pengajuan Lembur gagal disimpan. Mohon ulangi kembali.'
            );
        } else {
            $this->db->trans_commit();
            $ArrCollback        = array(
                'status'        => 1,
                'msg'           => 'Data Lembur berhasil disimpan.'
            );
            history('Save Lembur Applications' . $data['employee_id']);
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
                $data          = $this->db->where(['status' => 'APV', 'approved_hr' => 'N'])->get('view_overtime')->result();
            } else {
                $data          = $this->db->where(['status' => 'OPN', 'approval_employee_id' => $employee_id])->or_where(['employee_id' => $employee_id])->get('view_overtime')->result();
            }

            $employees         = $this->employees_model->getData('employees');
            $phone = [];
            foreach ($employees as $emp) {
                $phone[$emp->id] = preg_replace('/0/', '62', $emp->hp, 1);
            }

            $data = array(
                'title'         => 'Index Lembur Applications',
                'action'        => 'Approval',
                'status'        => $this->status,
                'row'           => $data,
                'phone'         => $phone,
                'access'        => $Arr_Akses
            );
            history('Index Lembur Applications');
            $this->load->view('Lembur/index', $data);
        } else {
            $employee           = $this->db->get_where('view_overtime', ['id' => $id])->row();
            $works              = $this->db->get_where('works', ['leave_id' => $id])->result();

            $data = array(
                'title'         => 'Index Lembur Applications',
                'action'        => 'Approval',
                'sts'           => $this->status,
                'data'          => $employee,
                'works'         => $works,
                'access'        => $Arr_Akses
            );

            history('View Approval Lembur');
            $this->load->view('Lembur/approval', $data);
        }
    }

    public function update($id = '')
    {
        $Arr_Akses            = getAcccesmenu($this->controller);
        if (!$Arr_Akses) {
            $this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Login as Employee....</div>");
            redirect(site_url($this->controller));
        }

        $ovt                = $this->db->get_where('view_overtime', ['id' => $id])->row();
        $works              = $this->db->get_where('works', ['leave_id' => $id])->result();

        $data = array(
            'title'         => 'Update Lembur Applications',
            'action'        => 'update',
            'ovt'           => $ovt,
            'works'         => $works,
            'update'        => true,
            'access'        => $Arr_Akses
        );
        $this->load->view('Lembur/edit', $data);
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

    public function cancel()
    {
        $id = $this->input->post('id');
        $this->db->trans_begin();
        $this->db->update('overtime', ['status' => 'CNL'], array('id' => $id));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $ArrCollback        = array(
                'status'        => 0,
                'msg'           => 'Cancel Lembur gagal.'
            );
        } else {
            $this->db->trans_commit();
            $ArrCollback        = array(
                'status'        => 1,
                'msg'           => 'Cancel Lembur berhasil.'
            );
            history('Cancel Lembur Applications');
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
            $this->db->where('id', $id)->update('overtime', $data);
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
                'msg'           => 'Data Lembur gagal disetujui. Mohon ulangi kembali.'
            );
        } else {
            $this->db->trans_commit();
            $ArrCollback        = array(
                'status'        => 1,
                'msg'           => 'Data Lembur berhasil disetujui.'
            );
            history('Persetujuan Lembur ' . $id);
        }

        echo json_encode($ArrCollback);
    }

    public function save_approve_hr()
    {
        $session        = $this->session->userdata;
        $id             = $this->input->post('id');
        $emp            = $this->db->get_where('view_overtime', ['id' => $id])->row();

        $this->db->trans_begin();

        if ($id) {
            $data['modified_by']             = $session['User']['username'];
            $data['modified_at']             = date('Y-m-d H:i:s');
            $data['approved_hr_at']          = date('Y-m-d H:i:s');
            $data['approved_hr_by']          = $session['User']['username'];
            $data['approved_hr']             = 'Y';
            $this->db->where('id', $id)->update('overtime', $data);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $ArrCollback        = array(
                'status'        => 0,
                'msg'           => 'Data Pengajuan Lembur gagal disetujui. Mohon ulangi kembali.'
            );
        } else {
            $this->db->trans_commit();
            $ArrCollback        = array(
                'status'        => 1,
                'msg'           => 'Data Pengajuan Lembur berhasil disetujui.'
            );
            history('Persetujuan Lembur ' . $id);
        }
        echo json_encode($ArrCollback);
    }

    public function view($id)
    {
        $Arr_Akses          = getAcccesmenu($this->controller);
        $wfh                = $this->db->get_where('view_overtime', ['id' => $id])->row();
        $works              = $this->db->get_where('works', ['leave_id' => $id])->result();

        $data = array(
            'title'         => 'View Lembur Applications',
            'action'        => 'View',
            'wfh'           => $wfh,
            'works'         => $works,
            'sts'           => $this->status,
            'access'        => $Arr_Akses,
        );

        $this->load->view('Lembur/view', $data);
    }
}
