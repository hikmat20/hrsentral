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

        $this->sts = [
            'N' => '<label class="label font-light bg-orange">Waiting Approval</label>',
            'Y' => '<label class="label font-light bg-green">Approved</label>',
            'OPN' => '<label class="label font-light bg-orange">Waiting Approval</label>',
            'APV' => '<label class="label font-light bg-green">Approved</label>',
            'REV' => '<label class="label font-light bg-orange">Revision</label>',
            'HIS' => '<label class="label font-light bg-maroon">History</label>',
            'CNL' => '<label class="label font-light bg-default">Cancel</label>',
            'REJ' => '<label class="label font-light bg-danger">Reject</label>',
        ];

        $this->company = $this->session->Company->company_id;
        $this->branch = $this->session->Company->branch_id;
    }

    public function index()
    {
        $Arr_Akses            = getAcccesmenu($this->controller);
        $employee_id          = $this->session->User['employee_id'];

        if ($Arr_Akses['read'] != '1') {
            $this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
            redirect(site_url('dashboard'));
        }

        $get_Data          = $this->db->where(['approved_hr' => 'N', 'employee_id' => $employee_id, 'company_id' => $this->company, 'branch_id' => $this->branch])->get('view_pengganti')->result();
        $employees         = $this->employees_model->getData('employees');
        $phone = [];
        foreach ($employees as $emp) {
            $phone[$emp->id] = preg_replace('/0/', '62', $emp->hp, 1);
        }

        $data = array(
            'title'         => 'Index Cuti Pengganti',
            'action'        => 'index',
            'religi'        => '0',
            'sts'           => $this->sts,
            'row'           => $get_Data,
            'phone'         => $phone,
            'access'        => $Arr_Akses
        );
        history('Index Cuti Pengganti');
        $this->load->view('Pengganti/index', $data);
    }

    public function autoNumber($table = '', $code = '')
    {

        $sql = "SELECT MAX(RIGHT(id,4)) maxId FROM $table WHERE SUBSTR(id,1,2) = '$code' AND SUBSTR(id,3, 2) = '" . date('y') . "' ORDER by id DESC";
        $idMax = $this->db->query($sql)->row();
        if ($idMax->maxId == '') {
            $count = '1';
        } else {
            $count = $idMax->maxId + 1;
        }

        return 'CP' . date('y') . str_pad($count, 4, "0", STR_PAD_LEFT);
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

    public function edit($id)
    {
        $Arr_Akses            = getAcccesmenu($this->controller);
        if (!$Arr_Akses) {
            $this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Login as Employee....</div>");
            redirect(site_url($this->controller));
        }

        $employee           = $this->db->get_where('leave_applications', ['id' => $id])->row();
        $works              = $this->db->get_where('works', ['leave_id' => $id])->result();

        $data = array(
            'title'         => 'Edit Cuti Pengganti',
            'action'        => 'edit',
            'employee'      => $employee,
            'works'         => $works,
            'access'        => $Arr_Akses
        );
        $this->load->view('Pengganti/edit', $data);
    }

    public function view($id)
    {
        $Arr_Akses            = getAcccesmenu($this->controller);
        if (!$Arr_Akses) {
            $this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Login as Employee....</div>");
            redirect(site_url($this->controller));
        }

        $employee           = $this->db->get_where('view_pengganti', ['id' => $id])->row();
        $works              = $this->db->get_where('works', ['leave_id' => $id])->result();

        $data = array(
            'title'         => 'View Cuti Pengganti',
            'action'        => 'edit',
            'sts'           => $this->sts,
            'employee'      => $employee,
            'works'         => $works,
            'access'        => $Arr_Akses
        );
        $this->load->view('Pengganti/view', $data);
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
                $get_Data          = $this->db->where(['status' => 'APV', 'approved_hr' => 'N'])->get('view_pengganti')->result();
            } else {
                $get_Data          = $this->db->where(['status' => 'OPN', 'approval_employee_id' => $employee_id, 'flag_leave_type' => 'CP'])->or_where(['employee_id' => $employee_id])->get('view_pengganti')->result();
            }

            $employees         = $this->employees_model->getData('employees');

            $phone = [];
            foreach ($employees as $emp) {
                $phone[$emp->id] = preg_replace('/0/', '62', $emp->hp, 1);
            }

            $data = array(
                'title'         => 'Index Cuti Pengganti',
                'action'        => 'approval',
                'religi'        => '0',
                'sts'           => $this->sts,
                'row'           => $get_Data,
                'phone'         => $phone,
                'access'        => $Arr_Akses
            );
            history('Index Cuti Pengganti');
            $this->load->view('Pengganti/index_approval', $data);
        } else {
            $employee           = $this->db->get_where('view_pengganti', ['id' => $id])->row();
            $works              = $this->db->get_where('works', ['leave_id' => $id])->result();

            $data = array(
                'title'         => 'View Cuti Pengganti',
                'action'        => 'edit',
                'sts'           => $this->sts,
                'employee'      => $employee,
                'works'         => $works,
                'access'        => $Arr_Akses
            );
            history('View Cuti Pengganti');
            $this->load->view('Pengganti/approval', $data);
        }
    }

    public function approve($id)
    {
        $Arr_Akses            = getAcccesmenu($this->controller);
        if (!$Arr_Akses) {
            $this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Login as Employee....</div>");
            redirect(site_url($this->controller));
        }

        $employee           = $this->db->get_where('view_pengganti', ['id' => $id])->row();

        $data = array(
            'title'         => 'View Cuti Pengganti',
            'action'        => 'edit',
            'sts'           => $this->sts,
            'employee'      => $employee,
            'access'        => $Arr_Akses
        );
        $this->load->view('Pengganti/approval', $data);
    }

    public function save()
    {
        $data_session                   = $this->session->userdata;
        $data                           = $this->input->post();
        $id                             = $this->input->post('id');
        // echo '<pre>';
        // print_r($data);
        // echo '<pre>';
        // exit;

        $data['id']                     = ($id) ? $id : $this->autoNumber('leave_applications', 'CP');
        $data['flag_leave_type']        = 'CP';
        $data['company_id']             = $data_session['Company']->company_id;
        $data['branch_id']              = $data_session['Company']->branch_id;

        // $config['upload_path']          = './assets/dokumen_pengajuan';
        // $config['allowed_types']        = 'gif|jpg|png|pdf|jpeg';
        // $config['max_size']             = 2000;
        // $config['max_width']            = 1024;
        // $config['max_height']           = 1224;
        // $config['encrypt_name']         = TRUE;

        // $this->upload->initialize($config);
        // if ($_FILES['doc']['name']) {
        //     if (!$this->upload->do_upload('doc')) {
        //         $error = $this->upload->display_errors('', '');
        //         $ArrCollback = [
        //             'msg' => $error,
        //             'status' => '0'
        //         ];
        //         echo json_encode($ArrCollback);
        //         return false;
        //     } else {
        //         $upload = $this->upload->data();
        //         $ArrCollback = [
        //             'msg' => 'Upload Berhasil',
        //             'status' => '1'
        //         ];
        //         $this->load->helper('file');
        //         if ($data['doc_old']) {
        //             unlink($upload['file_path'] . $data['doc_old']);
        //         }
        //         $data['doc'] =  $upload['file_name'];
        //     }
        // }
        // unset($data['doc_old']);

        $this->db->trans_begin();
        if ($id) {
            $data['modified_by']             = $data_session['User']['username'];
            $data['modified_at']             = date('Y-m-d H:i:s');
            if ($data['works']) {
                foreach ($data['works'] as $key => $works) {
                    $data['works'][$key]['employee_id']   = $data['employee_id'];
                    $data['works'][$key]['leave_id']      = $data['id'];
                }
                $this->db->delete('works', ['leave_id' => $data['id']]);
                $this->db->insert_batch('works', $data['works']);
            }
            unset($data['works']);
            $this->db->where('id', $id)->update('leave_applications', $data);
        } else {
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
            // echo '<pre>';
            // print_r($data);
            // echo '<pre>';
            // exit;
            $this->db->insert('leave_applications', $data);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $ArrCollback        = array(
                'status'        => 0,
                'msg'           => 'Data Pengajuan Cuti Pengganti gagal disimpan. Mohon ulangi kembali.'
            );
        } else {
            $this->db->trans_commit();
            $ArrCollback        = array(
                'status'        => 1,
                'msg'           => 'Data Pengajuan Cuti Pengganti berhasil disimpan.'
            );
            history('Save Cuti Pengganti' . $data['employee_id']);
        }

        echo json_encode($ArrCollback);
    }

    public function cancel()
    {
        $data_session                   = $this->session->userdata;
        $id                             = $this->input->post('id');

        $this->db->trans_begin();

        if ($id) {
            $data['modified_by']             = $data_session['User']['username'];
            $data['modified_at']             = date('Y-m-d H:i:s');
            $data['status']                  = 'CNL';
            $this->db->where('id', $id)->update('leave_applications', $data);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $ArrCollback        = array(
                'status'        => 0,
                'msg'           => 'Data Pengajuan Cuti Pengganti gagal dibatalkan. Mohon ulangi kembali.'
            );
        } else {
            $this->db->trans_commit();
            $ArrCollback        = array(
                'status'        => 1,
                'msg'           => 'Data Pengajuan Cuti Pengganti berhasil dibatalkan.'
            );
            history('Pembatalan Cuti Pengganti' . $id);
        }

        echo json_encode($ArrCollback);
    }

    public function save_approve()
    {
        $session   = $this->session->userdata;
        $id        = $this->input->post('id');

        $this->db->trans_begin();

        if ($id) {
            $data['modified_by']             = $session['User']['username'];
            $data['modified_at']             = date('Y-m-d H:i:s');
            $data['approved_at']             = date('Y-m-d H:i:s');
            $data['status']                  = 'APV';
            $this->db->where('id', $id)->update('leave_applications', $data);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $ArrCollback        = array(
                'status'        => 0,
                'msg'           => 'Data Pengajuan Cuti Pengganti gagal disetujui. Mohon ulangi kembali.'
            );
        } else {
            $this->db->trans_commit();
            $ArrCollback        = array(
                'status'        => 1,
                'msg'           => 'Data Pengajuan Cuti Pengganti berhasil disetujui.'
            );
            history('Persetujuan Cuti Pengganti' . $id);
        }

        echo json_encode($ArrCollback);
    }

    public function save_approve_hr()
    {
        $session        = $this->session->userdata;
        $id             = $this->input->post('id');
        $emp            = $this->db->get_where('leave_applications', ['id' => $id])->row();
        $axis_data      = $this->db->get_where('employees_leave', ['employee_id' => $emp->employee_id])->row();

        $dataEmpLeave   = [
            'id'            => $this->employees_model->code_otomatis('employees_leave', 'EL'),
            'date'          => date('Y-m-d'),
            'employee_id'   => $emp->employee_id,
            'year'          => date('Y'),
            'leave'         => $emp->total_days,
            'description'   => 'Updated by system ##Cuti Pengganti##',
            'created_by'    => $session['User']['username'],
            'created'       => date('Y-m-d H:i:s')
        ];

        $this->db->trans_begin();

        if ($id) {
            $data['modified_by']             = $session['User']['username'];
            $data['modified_at']             = date('Y-m-d H:i:s');
            $data['approved_hr_at']          = date('Y-m-d H:i:s');
            $data['approved_hr_by']          = $session['User']['username'];
            $data['approved_hr']             = 'Y';
            $data['unused_leave']            = $axis_data->leave;
            $data['substitute_leave']        = $emp->total_days;
            $data['remaining_leave']         = $axis_data->leave + $emp->total_days;


            $this->db->where('id', $id)->update('leave_applications', $data);
            // $this->db->insert('employees_leave', $dataEmpLeave);

            // $axis_data = $this->db->get_where('employees_leave_summary', ['employee_id' => $emp->employee_id])->row();
            // $dataSum = [
            //     'id' => $this->employees_model->code_otomatis('employees_leave_summary', 'ELS'),
            //     'employee_id' => $emp->employee_id,
            //     'date_update' => date('Y-m-d'),
            //     'total_leave' => $emp->total_days,
            //     'description' => 'Updated by system',
            //     'updated_at' => date('Y-m-d H:i:s'),
            // ];
            if ($axis_data) {
                unset($dataEmpLeave['id']);
                $dataEmpLeave['leave'] = $axis_data->leave + $emp->total_days;
                $this->db->where('employee_id', $emp->employee_id)->update('employees_leave', $dataEmpLeave);
            } else {
                $this->db->insert('employees_leave', $dataEmpLeave);
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $ArrCollback        = array(
                'status'        => 0,
                'msg'           => 'Data Pengajuan Cuti Pengganti gagal disetujui. Mohon ulangi kembali.'
            );
        } else {
            $this->db->trans_commit();
            $ArrCollback        = array(
                'status'        => 1,
                'msg'           => 'Data Pengajuan Cuti Pengganti berhasil disetujui.'
            );
            history('Persetujuan Cuti Pengganti' . $id);
        }
        echo json_encode($ArrCollback);
    }

    public function reject()
    {
        $session   = $this->session->userdata;
        $id        = $this->input->post('id');

        $this->db->trans_begin();

        if ($id) {
            $data['modified_by']             = $session['User']['username'];
            $data['modified_at']             = date('Y-m-d H:i:s');
            $data['status']                  = 'REJ';
            $this->db->where('id', $id)->update('leave_applications', $data);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $ArrCollback        = array(
                'status'        => 0,
                'msg'           => 'Data Pengajuan Cuti Pengganti gagal disetujui. Mohon ulangi kembali.'
            );
        } else {
            $this->db->trans_commit();
            $ArrCollback        = array(
                'status'        => 1,
                'msg'           => 'Data Pengajuan Cuti Pengganti berhasil disetujui.'
            );
            history('Persetujuan Cuti Pengganti' . $id);
        }

        echo json_encode($ArrCollback);
    }

    public function approve_hr()
    {
        $session   = $this->session->userdata;
        $id        = $this->input->post('id');

        $this->db->trans_begin();

        if ($id) {
            $data['modified_by']             = $session['User']['username'];
            $data['modified_at']             = date('Y-m-d H:i:s');
            $data['approved_hr']             = 'Y';
            $data['approved_hr_by']          = $session['User']['employee_id'];
            $data['approved_hr_at']          = date('Y-m-d H:i:s');
            $this->db->where('id', $id)->update('leave_applications', $data);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $ArrCollback        = array(
                'status'        => 0,
                'msg'           => 'Data Pengajuan Cuti Pengganti gagal disetujui. Mohon ulangi kembali.'
            );
        } else {
            $this->db->trans_commit();
            $ArrCollback        = array(
                'status'        => 1,
                'msg'           => 'Data Pengajuan Cuti Pengganti berhasil disetujui.'
            );
            history('Persetujuan Cuti Pengganti' . $id);
        }

        echo json_encode($ArrCollback);
    }
}
