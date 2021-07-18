<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empleaves extends CI_Controller {
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
		
		$get_Data			= $this->employees_model->getDataEmpleave();
		$Empleaves			= $this->employees_model->getEmployees();
		$data = array(
			'title'			=> 'Indeks Of Empleaves',
			'action'		=> 'index',
			'religi'		=> '0',
			'row'			=> $get_Data,
			'data_menu'		=> $Empleaves,
			'akses_menu'	=> $Arr_Akses
		);
		history('View Data Empleaves');
		$this->load->view('Empleaves/index',$data);
	}

	
	public function add($id=''){
	
		if($this->input->post()){
			
			$Arr_Kembali			= array();			
			$data					= $this->input->post();
			$data_session			= $this->session->userdata;
			$data['id']				= $this->employees_model->code_otomatis('employees_leave','EL');
			$data['created_by']		= $data_session['User']['username']; 
			$data['created']		= date('Y-m-d H:i:s');
			
			if($this->employees_model->simpan('employees_leave',$data)){
				
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Add Employees leave Success. Thank you & have a nice day.......'
				);
				history('Add Data Employees leave'.$data['employee_id']);
			}else{
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Add Employees leave failed. Please try again later......'
				);
				
			}
			echo json_encode($Arr_Kembali);
		}else{		
			$controller			= ucfirst(strtolower($this->uri->segment(1)));
			$Arr_Akses			= getAcccesmenu($controller);
			if($Arr_Akses['update'] !='1'){
				$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
				redirect(site_url('Empleaves'));
			}
			$arr_Where			='';
			$get_Data7			= $this->employees_model->getLeaves($arr_Where);
			$get_Data			= $this->employees_model->getEmployees();
			$Family_Type		= $this->master_model->getArray('family_category',array(),'kode','category');
			$Education_Type		= $this->master_model->getArray('education_level',array(),'kode','category');
			$detail				= $this->employees_model->getData('employees','id',$id); 
			$detail_family		= $this->master_model->getArray('family',array('employee_id'=>$id));
			$detail_education	= $this->master_model->getArray('educational',array('employee_id'=>$id));
			$data = array(
				'title'			=> 'Add Employee leave',
				'action'		=> 'add',
				'data_Empleaves'=> $get_Data,
				'data_leaves'	=> $get_Data7,
				'row'			=> $detail
				
			);
			
			$this->load->view('Empleaves/add',$data);
		}
	}
	
	
	public function edit($id=''){
		if($this->input->post()){
			//echo"<pre>";print_r($this->input->post());exit;
			$data					= $this->input->post();
			$Arr_Kembali			= array();
			unset($data['employee_id']);
			$data_session			= $this->session->userdata;			
			$data['modified_by']	= $data_session['User']['username'];  
			$data['modified']		= date('Y-m-d H:i:s');
			if($this->master_model->getUpdate('employees_leave',$data,'id',$this->input->post('id'))){
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Edit Empleaves Success. Thank you & have a nice day.......'
				);
				history('Edit Data Empleaves');
				
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
				redirect(site_url('Empleaves'));
			}
			$arr_Where			= '';
			$get_Data7			= $this->employees_model->getLeaves($arr_Where);
			$detail				= $this->master_model->getData('employees_leave','id',$id); 
			$data = array(
				'title'			=> 'Edit Empleaves',
				'action'		=> 'edit',
				'data_leaves'	=> $get_Data7,
				'row'			=> $detail
			);
			
			$this->load->view('Empleaves/edit',$data);
		}
	}
	
	
	

	
	
	
	function delete($id){
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if($Arr_Akses['delete'] !='1'){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('Empleaves'));
		}
		
		$this->db->where('id', $id);
		$this->db->delete("employees_leave");
		if($this->db->affected_rows()>0){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-success\" id=\"flash-message\">Data has been successfully deleted...........!!</div>");
			history('Delete Data Empleaves id'.$id);
			redirect(site_url('Empleaves'));
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