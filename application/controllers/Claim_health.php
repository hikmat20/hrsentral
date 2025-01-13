<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 * @author Harboens
 * @copyright Copyright (c) 2022
 *
 * This is controller for Claim_health
 */
class Claim_health extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model(array('Claim_health_model','All_model'));
		$this->load->model('employees_model');
        date_default_timezone_set('Asia/Bangkok');
    }
	// list
    public function index() {
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if ($Arr_Akses['read'] != '1') {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}
		$data = array(
			'title'			=> 'Claim Health',
			'action'		=> 'index',
            'access'        => $Arr_Akses
		);
		$this->load->view('Claim_health/index',$data);
    }

	// load ajax
	public function getDataJSON(){
		$controller = ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses = getAcccesmenu($controller);
		$postData = $this->input->post();
		$userlist=$this->session->userdata['User']['employee_id'];
		if($Arr_Akses['update']=='1') $userlist='';
		$data = $this->Claim_health_model->GetListDataJSON($postData,$userlist);
		echo json_encode($data);
	}
	
	// add form
    public function add() {
        $userlist=$this->session->userdata['User']['employee_id'];
        if (!$userlist) {
            $this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Login as Employee....</div>");
            redirect("dashboard");
        }
		$Arr_Akses	= getAcccesmenu('claim_health');
        $family		= $this->db->get_where('family', ['employee_id' => $userlist])->result();
        $jc			= $this->db->get_where('ms_generate', ['tipe' => 'jenis_claim'])->result();

        $data = array(
            'title'         => 'Pengajuan Claim',
            'action'        => 'add',
            'family'        => $family,
            'access'        => $Arr_Akses,
            'jc'			=> $jc,
        );
		$this->load->view('Claim_health/form',$data);
    }

	// edit form
    public function edit($id) {
        $userlist=$this->session->userdata['User']['employee_id'];
        if (!$userlist) {
            $this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Login as Employee....</div>");
            redirect("dashboard");
        }
		$Arr_Akses	= getAcccesmenu('claim_health');
        $record		= $this->db->get_where('claim_health', ['employee_id' => $userlist,'id'=>$id,'status'=>'PENGAJUAN'])->row();
        $family		= $this->db->get_where('family', ['employee_id' => $userlist])->result();
        $jc			= $this->db->get_where('ms_generate', ['tipe' => 'jenis_claim'])->result();

        $data = array(
            'title'         => 'Pengajuan Claim',
            'action'        => 'edit',
            'family'        => $family,
            'access'        => $Arr_Akses,
            'jc'			=> $jc,
            'record'		=> $record,
        );
		$this->load->view('Claim_health/form',$data);
    }

	// view form
    public function view($id) {
		$Arr_Akses	= getAcccesmenu('claim_health');
        $record		= $this->db->get_where('claim_health', ['id'=>$id])->row();
        $family		= $this->db->get_where('family', ['employee_id' => $record->employee_id])->result();
        $jc			= $this->db->get_where('ms_generate', ['tipe' => 'jenis_claim'])->result();

        $data = array(
            'title'         => 'Pengajuan Claim',
            'action'        => 'view',
            'family'        => $family,
            'access'        => $Arr_Akses,
            'jc'			=> $jc,
            'record'		=> $record,
        );
		$this->load->view('Claim_health/form',$data);
    }

	// save form
   public function save()
    {
		$data_session	= $this->session->userdata;
		$employee_id=$this->session->userdata['User']['employee_id'];
        $id        	= $this->input->post("id");
        $no_claim	= $this->input->post("no_claim");
        $tgl_claim	= $this->input->post("tgl_claim");
        $employee_id	= $employee_id;
        $company_id	= $data_session['Company']->company_id;
		$dokumen_claim=$this->input->post("dokumen_claim_old");
		$dokumen_claim_old=$this->input->post("dokumen_claim_old");

        $date_treat		= $this->input->post("date_treat");
        $tertanggung	= $this->input->post("tertanggung");
        $jenis_claim	= $this->input->post("jenis_claim");
        $provider		= $this->input->post("provider");
        $biaya_claim	= $this->input->post("biaya_claim");
        $insurance		= $this->input->post("insurance");
        $provider		= $this->input->post("provider");
        $config['upload_path']          = './assets/documents';
        $config['allowed_types']        = 'gif|jpg|png|pdf|jpeg';
        $config['max_size']             = 2000;
        $config['max_width']            = 5024;
        $config['max_height']           = 5224;
        $config['encrypt_name']         = TRUE;

        $this->upload->initialize($config);
        if ($_FILES['dokumen_claim']['name']) {
            if (!$this->upload->do_upload('dokumen_claim')) {
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
                if ($dokumen_claim_old) {
                    unlink($upload['file_path'] . $dokumen_claim_old);
                }
                $dokumen_claim =  $upload['file_name'];
            }
        }

		$this->db->trans_begin();
		if($no_claim=='') {
			$no_claim=$this->All_model->GetAutoGenerate('format_claim');
			$data =  array(
				'status'=>'PENGAJUAN',
				'no_claim'=>$no_claim,
				'tgl_claim'=>$tgl_claim,
				'employee_id'=>$employee_id,
				'company_id'=>$company_id,
				'date_treat'=>$date_treat,
				'tertanggung'=>$tertanggung,
				'jenis_claim'=>$jenis_claim,
				'provider'=>$provider,
				'biaya_claim'=>$biaya_claim,
				'insurance'=>$insurance,
				'dokumen_claim'=>$dokumen_claim,
				'created_by'=> $data_session['User']['username'],
				'created_at'=>date("Y-m-d h:i:s")
			);
			$this->All_model->dataSave('claim_health',$data);
		}else{
			$data =  array(
				'tgl_claim'=>$tgl_claim,
				'employee_id'=>$employee_id,
				'company_id'=>$company_id,
				'date_treat'=>$date_treat,
				'tertanggung'=>$tertanggung,
				'jenis_claim'=>$jenis_claim,
				'provider'=>$provider,
				'biaya_claim'=>$biaya_claim,
				'dokumen_claim'=>$dokumen_claim,
				'insurance'=>$insurance,
				'modified_by'=> $data_session['User']['username'],
				'modified_at'=>date("Y-m-d h:i:s")
			);
			$this->All_model->dataUpdate('claim_health',$data,array('id'=>$id));
		}

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $ArrCollback        = array(
                'status'        => 0,
                'msg'           => 'Data Pengajuan Claim gagal disimpan. Mohon ulangi kembali.'
            );
        } else {
            $this->db->trans_commit();
            $ArrCollback        = array(
                'status'        => 1,
                'msg'           => 'Data Pengajuan Claim berhasil disimpan.'
            );
            history('Save Claim Health' . $employee_id);
        }
        echo json_encode($ArrCollback);
    }
	
	// delete data
    public function del($id) {
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if ($Arr_Akses['delete'] == '1') {
			$this->All_model->dataDelete('claim_health',array('id'=>$id,'status'=>'PENGAJUAN'));
		}
		redirect(site_url('claim_health'));
    }	
}
