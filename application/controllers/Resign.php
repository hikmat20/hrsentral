<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resign extends CI_Controller {
	public function __construct(){
        parent::__construct();
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
		
		$get_Data			= $this->employees_model->getDataEmpl();
		$Employees			= $this->employees_model->getEmployees();
		
		$data = array(
			'title'			=> 'Indeks Of Employees',
			'action'		=> 'index',
			'row'			=> $get_Data,
			'data_menu'		=> $Employees,
			'akses_menu'	=> $Arr_Akses
		);
		history('View Data Employees');
		$this->load->view('Resign/index',$data);
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
			if($this->employees_model->getUpdate('employees',$data,'id',$this->input->post('id'))){
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Edit Employees Success. Thank you & have a nice day.......'
				);
				history('Update Resign Employees'.$data['name']);
				
			}else{
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Add Employees failed. Please try again later......'
				);
			}
			echo json_encode($Arr_Kembali);
		}else{		
			$controller			= ucfirst(strtolower($this->uri->segment(1)));
			$Arr_Akses			= getAcccesmenu($controller);
			if($Arr_Akses['update'] !='1'){
				$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
				redirect(site_url('Resign'));
			}
			$arr_Where			='';
			$get_Data1			= $this->employees_model->getCompanies($arr_Where);
			$get_Data2			= $this->employees_model->getDivisions($arr_Where);
			$get_Data3			= $this->employees_model->getDepartments($arr_Where);
			$get_Data4			= $this->employees_model->getTitles($arr_Where);
			$get_Data5			= $this->employees_model->getPositions($arr_Where);
			$get_Data6			= $this->employees_model->getMarital($arr_Where);
			$get_Data7			= $this->employees_model->getContract($arr_Where);
			$get_Data			= $this->employees_model->getEmployees(); 
			
			$detail				= $this->employees_model->getData('employees','id',$id); 
			$data = array(
				'title'			=> 'Edit Employees',
				'action'		=> 'edit',
				'data_Employees'=> $get_Data,
				'data_companies'=> $get_Data1,
				'data_divisions'=> $get_Data2,
				'data_department'  => $get_Data3,
				'data_title'  	=> $get_Data4,
				'data_position'  	=> $get_Data5,
				'data_marital'  	=> $get_Data6,
				'contract_id' 	 	=> $get_Data7,
				'row'				=> $detail
			);
			
			$this->load->view('Resign/edit',$data); 
		}
	}
    
	
	
	function delete($id){
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if($Arr_Akses['delete'] !='1'){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('Employees'));
		}
		
		$this->db->where('id', $id);
		$this->db->delete("employees");
		if($this->db->affected_rows()>0){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-success\" id=\"flash-message\">Data has been successfully deleted...........!!</div>");
			history('Delete Data Employees id'.$id);
			redirect(site_url('employees'));
		}
	}
	function getDetail($kode=''){
		$Data_Array		= $this->employees_model->getArray('divisions',array('company_id'=>$kode),'id','name');
		echo json_encode($Data_Array);
	}
		
	function getDept($kode=''){
		$Data_Array		= $this->employees_model->getArray('departments',array('division_id'=>$kode),'id','name');
		echo json_encode($Data_Array);
	}
	function getTitle($kode=''){
		$Data_Array		= $this->employees_model->getArray('titles',array('department_id'=>$kode),'id','name');
		echo json_encode($Data_Array);
	}
}