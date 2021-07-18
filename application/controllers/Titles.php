<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Titles extends CI_Controller {
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
		
		$get_Data			= $this->master_model->getDatatitle();
		$titles				= $this->master_model->getTitles();
		
		$data = array(
			'title'			=> 'Indeks Of Titles',
			'action'		=> 'index',
			'row'			=> $get_Data,
			'data_menu'		=> $titles,
			'akses_menu'	=> $Arr_Akses
		);
		history('View Data Titles');
		$this->load->view('Titles/index',$data);
	}
	public function add(){		
		if($this->input->post()){
			$Arr_Kembali			= array();			
			$data					= $this->input->post();
			$data['id']				= $this->master_model->code_otomatis('titles','TIT');
			$data_session			= $this->session->userdata;
			$data['created_by']		= $data_session['User']['username']; 
			$data['created']		= date('Y-m-d H:i:s');
			if($this->master_model->simpan('titles',$data)){
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Add Titles Success. Thank you & have a nice day.......'
				);
				history('Add Data Titles'.$data['name']);
			}else{
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Add Titles failed. Please try again later......'
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
			$arr_Where2			= '';
			$arr_Where3			= '';
			$get_Data			= $this->master_model->getCompanies($arr_Where);
			$get_Data2			= $this->master_model->getDivisions($arr_Where);
			$get_Data3			= $this->master_model->getDepartments($arr_Where);
			$data = array(
				'title'			=> 'Add Titles',
				'action'		=> 'add',
				'data_companies'=> $get_Data,
				'data_divisions'=> $get_Data2,
				'data_department'  => $get_Data3
			);
			
			$this->load->view('Titles/add',$data);
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
			if($this->master_model->getUpdate('titles',$data,'id',$this->input->post('id'))){
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Edit Titles Success. Thank you & have a nice day.......'
				);
				history('Edit Data Titles'.$data['name']);
				
			}else{
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Add Titles failed. Please try again later......'
				);
			}
			echo json_encode($Arr_Kembali);
		}else{		
			$controller			= ucfirst(strtolower($this->uri->segment(1)));
			$Arr_Akses			= getAcccesmenu($controller);
			if($Arr_Akses['update'] !='1'){
				$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
				redirect(site_url('Titles'));
			}
			$arr_Where			= '';
			$get_Data			= $this->master_model->getCompanies($arr_Where);
			$get_Data2			= $this->master_model->getDivisions($arr_Where);
			$get_Data3			= $this->master_model->getDepartments($arr_Where);
			$detail				= $this->master_model->getData('titles','id',$id); 
			$data = array(
				'title'			=> 'Edit Titles',
				'action'		=> 'edit',
				'data_companies'=> $get_Data,
				'data_divisions'=> $get_Data2,
				'data_department'=> $get_Data3,
				'row'			=> $detail
			);
			
			$this->load->view('Titles/edit',$data);
		}
	}

	function delete($id){
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if($Arr_Akses['delete'] !='1'){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('Titles'));
		}
		
		$this->db->where('id', $id);
		$this->db->delete("titles");
		if($this->db->affected_rows()>0){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-success\" id=\"flash-message\">Data has been successfully deleted...........!!</div>");
			history('Delete Data Titles id'.$id);
			redirect(site_url('Titles'));
		}
	}
	
 
    function getDetail($kode=''){
		$Data_Array		= $this->master_model->getArray('divisions',array('company_id'=>$kode),'id','name');
		echo json_encode($Data_Array);
	}
		
	function getDept($kode=''){
		$Data_Array		= $this->master_model->getArray('departments',array('division_id'=>$kode),'id','name');
		echo json_encode($Data_Array);
	}

    
}