<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Policy extends CI_Controller {
	public function __construct(){
        parent::__construct();
		$this->load->model('master_model');
		$this->load->model('employees_model');
		$this->load->database();
        if(!$this->session->userdata('isLogin')){
			redirect('login');
		}
    }

	public function index(){
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if($Arr_Akses['read'] !='1'){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}
		
		$get_Data		= $this->employees_model->getdataPolicy();
		$policy			= $this->master_model->getpolicy();
		
		$data = array(
			'title'			=> 'Indeks Of policy',
			'action'		=> 'index',
			'row'			=> $get_Data,
			'data_companies'=> $policy,
			'akses_menu'	=> $Arr_Akses
		);
		history('View Data policy');
		$this->load->view('Policy/index',$data);
	}
	public function add(){		
		if($this->input->post()){
			$Arr_Kembali			= array();			
			$data					= $this->input->post();
			$data['id']				= $this->master_model->code_otomatis('ms_policy','POL');
			$data_session			= $this->session->userdata;
			$data['created_by']		= $data_session['User']['username']; 
			$data['created']		= date('Y-m-d H:i:s');
			if($this->master_model->simpan('ms_policy',$data)){
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Add policy Success. Thank you & have a nice day.......'
				);
				history('Add Data policy'.$data['id']);
			}else{
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Add policy failed. Please try again later......'
				);
				
			}
			echo json_encode($Arr_Kembali);
		}else{		
			$controller			= ucfirst(strtolower($this->uri->segment(1)));
			$Arr_Akses			= getAcccesmenu($controller);
			if($Arr_Akses['create'] !='1'){
				$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
				redirect(site_url('menu'));
			}
			$arr_Where			= '';
			$get_Data			= $this->master_model->getCompanies($arr_Where);
			$get_Data5			= $this->employees_model->getPositions($arr_Where);
			$data = array(
				'title'			=> 'Add policy',
				'action'		=> 'add',
				'data_position'  	=> $get_Data5,
				'data_companies'=> $get_Data
			);
			$this->load->view('Policy/add',$data);
		}
	}
	public function edit($id=''){
		if($this->input->post()){
			//echo"<pre>";print_r($this->input->post());exit;
			$data					= $this->input->post();
			$Arr_Kembali			= array();
			unset($data['id']);
			$data_session			= $this->session->userdata;			
			$data['modified_by']	= $data_session['User']['username'];  
			$data['modified']		= date('Y-m-d H:i:s');
			if($this->master_model->getUpdate('ms_policy',$data,'id',$this->input->post('id'))){
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Edit policy Success. Thank you & have a nice day.......'
				);
				history('Edit Data policy');
				
			}else{
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Add Departement failed. Please try again later......'
				);
			}
			echo json_encode($Arr_Kembali);
		}else{		
			$controller			= ucfirst(strtolower($this->uri->segment(1)));
			$Arr_Akses			= getAcccesmenu($controller);
			if($Arr_Akses['update'] !='1'){
				$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
				redirect(site_url('policy'));
			}
			$arr_Where			= '';
			$get_Data			= $this->master_model->getCompanies($arr_Where);
			$get_Data5			= $this->employees_model->getPositions($arr_Where);
			$detail				= $this->master_model->getData('ms_policy','id',$id); 
			$data = array(
				'title'			=> 'Edit policy',
				'action'		=> 'edit',
				'data_companies'=> $get_Data,
				'data_position'  => $get_Data5,
				'row'			=> $detail
			);
			
			$this->load->view('Policy/edit',$data);
		}
	}

	function delete($id){
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if($Arr_Akses['delete'] !='1'){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('policy'));
		}
		
		$this->db->where('id', $id);
		$this->db->delete("ms_policy");
		if($this->db->affected_rows()>0){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-success\" id=\"flash-message\">Data has been successfully deleted...........!!</div>");
			history('Delete Data policy id'.$id);
			redirect(site_url('policy'));
		}
	}
}