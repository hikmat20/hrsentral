<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rekapabsen extends CI_Controller
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

        $controller            = ucfirst(strtolower($this->uri->segment(1)));
        $Arr_Akses            = getAcccesmenu($controller);
        if ($Arr_Akses['read'] != '1') {
            $this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
            redirect(site_url('dashboard'));
        }

        $row = $this->db->get('view_rekapabsen')->result();

        $data = [
            'action'    => 'Rekap Absensi',
            'title'     => 'View Data Rekap Absensi',
            'row'       => $row
        ];

        history('View Data Rekap Absensi');
        $this->load->view('Absensi/list_rekap', $data);
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

    public function proses_rekap()
    {
        $controller            = ucfirst(strtolower($this->uri->segment(1)));
        $Arr_Akses            = getAcccesmenu($controller);
        if ($Arr_Akses['read'] != '1') {
            $this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
            redirect(site_url('dashboard'));
        }

        $month = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];

        $data = [
            'action'    => 'Rekap Absensi',
            'title'     => 'View Data Rekap Absensi',
            'month'     => $month
        ];

        history('View Data Rekap Absensi');
        $this->load->view('Absensi/proses_rekap', $data);
    }

    public function view_rekap()
    {
        $Arr_Akses          = getAcccesmenu($this->controller);
        $session            = $this->session->Company;
        $data               = $this->input->post();
        $sDate = $data['sDate'];
        $eDate = $data['eDate'];

        $sql = "SELECT `name`, waktu,YEAR(waktu) as `year`,
        count(CASE WHEN tipe = '1' THEN id END)  as 'absen', 
        count(CASE WHEN tipe = '2' THEN id END)  as 'onsite', 
        count(CASE WHEN tipe = '5' THEN id END)  as 'lembur',  
        (select count(*) from work_from_home as wfh WHERE date(`wfh`.`from_date`) >= date('$sDate') AND date(`wfh`.`until_date`) <= date('$eDate') AND wfh.employee_id = view_absensi_log.employee_id and wfh.status ='APV' and wfh.approved_hr = 'Y')  as 'wfh'  
        FROM view_absensi_log
        where date(waktu) >= date('$sDate') and date(waktu) <= date('$eDate')
        group by view_absensi_log.employee_id";

        $result                     = $this->db->query($sql)->result();
        $start_date       = $sDate;
        $end_date         = $eDate;
        $month            = $data['month'];
        $id_perusahaan    = $session->company_id;
        $id_cabang        = $session->branch_id;

        $data = [
            'data' => $result,
            'start_date'        => $start_date,
            'end_date'          => $end_date,
            'month'             => $month,
            'id_perusahaan'     => $id_perusahaan,
            'id_cabang'         => $id_cabang,
        ];
        $this->load->view('Absensi/view_rekap', $data);
    }

    public function save_rekap()
    {
        $Arr_Akses          = getAcccesmenu($this->controller);
        $session            = $this->session->Company;
        $data               = $this->input->post();
        $sDate              = $data['sDate'];
        $eDate              = $data['eDate'];
        $month              = $data['month'];
        $id_perusahaan      = $session->company_id;
        $id_cabang          = $session->branch_id;

        $sql = "SELECT employee_id, waktu,YEAR(waktu) as `year`,
        count(CASE WHEN tipe = '1' THEN id END)  as 'absen', 
        count(CASE WHEN tipe = '2' THEN id END)  as 'onsite', 
        count(CASE WHEN tipe = '5' THEN id END)  as 'lembur',  
        (select count(*) from work_from_home as wfh WHERE date(`wfh`.`from_date`) >= date('$sDate') AND date(`wfh`.`until_date`) <= date('$eDate') AND wfh.employee_id = view_absensi_log.employee_id and wfh.status ='APV' and wfh.approved_hr = 'Y')  as 'wfh'  
        FROM view_absensi_log
        where date(waktu) >= date('$sDate') and date(waktu) <= date('$eDate')
        group by view_absensi_log.employee_id";

        $result                     = $this->db->query($sql)->result();

        foreach ($result as $key => $rekap) {
            $dataInsert = [
                'employee_id'          => $rekap->employee_id,
                'start_date'    => $sDate,
                'end_date'      => $eDate,
                'year'          => $rekap->year,
                'month'         => $month,
                'id_perusahaan' => $id_perusahaan,
                'id_cabang'     => $id_cabang,
                'absen'         => $rekap->absen,
                'onsite'        => $rekap->onsite,
                'overtime'      => $rekap->lembur,
                'wfh'           => $rekap->wfh,
                'total'         => ($rekap->absen + $rekap->onsite) - ($rekap->wfh),
                'updated_by'    => $this->session->User['username'],
                'updated_at'    => date('Y-m-d H:i:s'),
            ];

            $cek = $this->db->get_where('rekapabsen', [
                'employee_id' => $rekap->employee_id,
                // 'start_date'    => $sDate,
                // 'end_date'      => $eDate,
                'month'         => $month,
                'id_perusahaan' => $id_perusahaan,
                'id_cabang'     => $id_cabang,
            ])->row();
            // $this->db->trans_begin();
            if (!$cek) {
                $this->db->insert('rekapabsen', $dataInsert);
            } else {
                $this->db->update('rekapabsen', $dataInsert, [
                    'employee_id' => $rekap->employee_id,
                    'start_date'    => $sDate,
                    'end_date'      => $eDate,
                    'month'         => $month,
                    'id_perusahaan' => $id_perusahaan,
                    'id_cabang'     => $id_cabang,
                ]);
            }
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $ArrCollback        = array(
                    'status'        => 0,
                    'msg'           => 'Data Rekap Absensi gagal disimpan. Mohon ulangi kembali.'
                );
            } else {
                $this->db->trans_commit();
                $ArrCollback        = array(
                    'status'        => 1,
                    'msg'           => 'Data Rekap Absensi berhasil disimpan.'
                );
                history('Save Rekap Absensi');
            }
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
}
