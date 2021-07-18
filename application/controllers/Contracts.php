<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contracts extends CI_Controller {
	public function __construct(){
        parent::__construct();
		$this->load->model('master_model');
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
		
		$get_Data			= $this->master_model->getData('contracts');
		$contracts			= $this->master_model->getContracts();
		
		$data = array(
			'title'			=> 'Indeks Of Contracts',
			'action'		=> 'index',
			'row'			=> $get_Data,
			'akses_menu'	=> $Arr_Akses
		);
		history('View Data Contracts');
		$this->load->view('Contracts/index',$data);
	}
	public function add(){		
		if($this->input->post()){
			$Arr_Kembali			= array();			
			$data					= $this->input->post();
			$data['id']				= $this->master_model->code_otomatis('contracts','CTR');
			$data_session			= $this->session->userdata;
			$data['created_by']		= $data_session['User']['username']; 
			$data['created']		= date('Y-m-d H:i:s');
			if($this->master_model->simpan('contracts',$data)){
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Add Contracts Success. Thank you & have a nice day.......'
				);
				history('Add Data Contracts'.$data['name']);
			}else{
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Add Contracts failed. Please try again later......'
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
			$get_Data			= $this->master_model->getContracts($arr_Where);
			$data = array(
				'title'			=> 'Add Contracts',
				'action'		=> 'add',
				'data_companies'=> $get_Data
			);
			$this->load->view('Contracts/add',$data);
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
			if($this->master_model->getUpdate('contracts',$data,'id',$this->input->post('id'))){
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Edit Contracts Success. Thank you & have a nice day.......'
				);
				history('Edit Data Contracts'.$data['name']);
				
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
				redirect(site_url('Contracts'));
			}
			$arr_Where			= '';
			
			$detail				= $this->master_model->getData('contracts','id',$id); 
			$data = array(
				'title'			=> 'Edit Contracts',
				'action'		=> 'edit',
				'row'			=> $detail
			);
			
			$this->load->view('Contracts/edit',$data);
		}
	}

	function delete($id){
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if($Arr_Akses['delete'] !='1'){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('Contracts'));
		}
		
		$this->db->where('id', $id);
		$this->db->delete("contracts");
		if($this->db->affected_rows()>0){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-success\" id=\"flash-message\">Data has been successfully deleted...........!!</div>");
			history('Delete Data Contracts id'.$id);
			redirect(site_url('Contracts'));
		}
	}
}