<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calibrasichange extends CI_Controller {
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
		
		$get_Data			= $this->employees_model->getDataEmplcalibrasi();
		$Employees			= $this->employees_model->getEmployees();
		
		$data = array(
			'title'			=> 'Indeks Of Employees',
			'action'		=> 'index',
			'religi'		=> '0',
			'row'			=> $get_Data,
			'data_menu'		=> $Employees,
			'akses_menu'	=> $Arr_Akses
		);
		history('View Data Employees');
		$this->load->view('Calibrasichange/index',$data);
	}
	
	public function addHistory(){
		
			if($this->employees_model->insert_history()){
				
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Add Employees History Success. Thank you & have a nice day.......'
				);
				history('Add Data Histories Employees');
			}else{
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Add Employees History failed. Please try again later......'
				);
				
			}
			echo json_encode($Arr_Kembali);
		
	}
	
	
	
    
	public function ubahstatus($id=''){
		
			
		if($this->input->post()){
			//echo"<pre>";print_r($this->input->post());exit;
			$Arr_Kembali2			= array();
			//unset($data['id']);
			$data_session	= $this->session->userdata;	
			$emp_id			= $this->input->post('id');
			$change 		= $this->input->post('change');
			$name 			= $this->input->post('name');
			$contract 		= $this->input->post('contract_id');
			$startdate 		= $this->input->post('startcontract_date');
            $latestdate 	= $this->input->post('latestcontract_date');
			$flag		 	= $this->input->post('flag_active');
			$modified_by	= $data_session['User']['username'];  
			$modified		= date('Y-m-d H:i:s');
			
			
			
			if($change === 'CTR001'){
				
				$data = array(
					'change' => $change,
					'firstcontract_id' => $contract,
					'firstcontractstart_date' => $startdate,
					'firstcontractlatest_date' => $latestdate,
					'modified_by' => $modified_by,
					'modified' => $modified
				);	
				if($this->employees_model->getUpdateEmp('employees',$data,'id',$emp_id)){
					
				$this->employees_model->insert_history();
				
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Edit Employees Success. Thank you & have a nice day.......'
				);
				history('Update Status Data Employees'.$name);
				
				}else{
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Add Employees failed. Please try again later......'
					);
				}
				echo json_encode($Arr_Kembali);	
			
			}else if($change === 'CTR002'){
				$data = array(
					'change' => $change,
					'secondcontract_id' => $contract,
					'secondcontractstart_date' => $startdate,
					'secondcontractlatest_date' => $latestdate,
					'modified_by' => $modified_by,
					'modified' => $modified
				);
				if($this->employees_model->getUpdateEmp('employees',$data,'id',$emp_id)){
					
				$this->employees_model->insert_history();
				
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Edit Employees Success. Thank you & have a nice day.......'
					);
				history('Update Status Data Employees'.$name);
				
				}else{
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Add Employees failed. Please try again later......'
					);
				}
			   echo json_encode($Arr_Kembali);	
			}
			else if($change === 'CTR003'){
			$data = array(
					'change' => $change,
					'thirdcontract_id' => $contract,
					'thirdcontractstart_date' => $startdate,
					'thirdcontractlatest_date' => $latestdate,
					'modified_by' => $modified_by,
					'modified' => $modified
				);
				if($this->employees_model->getUpdateEmp('employees',$data,'id',$emp_id)){
					
				$this->employees_model->insert_history();
				
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Edit Employees Success. Thank you & have a nice day.......'
				);
				history('Update Status Data Employees'.$name);
				
				}else{
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Add Employees failed. Please try again later......'
				);
				}
				
				echo json_encode($Arr_Kembali);	 
			}

			else if($change === 'CTR004'){
			$data = array(
					'change' => $change,
					'permanent_id' => $contract,
					'permanentstart_date' => $startdate,
					'permanentlatest_date' => $latestdate,
					'modified_by' => $modified_by,
					'modified' => $modified
				);
				if($this->employees_model->getUpdateEmp('employees',$data,'id',$emp_id)){
					
				$this->employees_model->insert_history();
					
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Edit Employees Success. Thank you & have a nice day.......'
				);
				history('Update Status Data Employees'.$name);
				
				}else{
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Add Employees failed. Please try again later......'
				);
				}
				
				echo json_encode($Arr_Kembali);	
			}
			
			else if($change === 'CTR005'){
			$data = array(
					'change' => $change,
					'resign' => $contract,
					'resign_date' => $startdate,
					'flag_active' => $flag,
					'modified_by' => $modified_by,
					'modified' => $modified
				);
				if($this->employees_model->getUpdateEmp('employees',$data,'id',$emp_id)){
					
				$this->employees_model->insert_history();
				
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Edit Employees Success. Thank you & have a nice day.......'
				);
				history('Update Status Data Employees'.$name);
				
				}else{
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Add Employees failed. Please try again later......'
				);
				}
				
				echo json_encode($Arr_Kembali);	
			}	
			
		}else{		
			$controller			= ucfirst(strtolower($this->uri->segment(1)));
			$Arr_Akses			= getAcccesmenu($controller);
			if($Arr_Akses['update'] !='1'){
				$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
				redirect(site_url('Empchanges'));
			}
			$arr_Where			='';
			$get_Data7			= $this->employees_model->getContract($arr_Where);
			$get_Data			= $this->employees_model->getEmployees(); 
			
			$detail				= $this->employees_model->getData('employees','id',$id); 
			$data = array(
				'title'			=> 'Edit Employees',
				'action'		=> 'edit',
				'data_Employees'=> $get_Data,
				'contract_id' 	 	=> $get_Data7,
				'row'				=> $detail
			);
			
			$this->load->view('Calibrasichange/edit',$data); 
		}
	}
	
	public function division($id=''){
		
		if($this->input->post()){
					
			$data					= $this->input->post();
			$Arr_Kembali			= array();
			$data_session			= $this->session->userdata;	
			$data['modified_by']	= $data_session['User']['username'];  
			$data['modified']		= date('Y-m-d H:i:s');
			
			if($this->employees_model->getUpdate('employees',$data,'id',$this->input->post('id'))){
				$this->employees_model->division_history();
				
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Edit Employees Success. Thank you & have a nice day.......'
				);
				
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
				redirect(site_url('Calibrasichange'));
			}
			$arr_Where			='';
			$get_Data1			= $this->employees_model->getCompanies($arr_Where);
			$get_Data2			= $this->employees_model->getDivisions($arr_Where);
			$get_Data3			= $this->employees_model->getDepartments($arr_Where);
			$get_Data4			= $this->employees_model->getTitles($arr_Where);
			$get_Data5			= $this->employees_model->getPositions($arr_Where);
			$get_Data6			= $this->employees_model->getMarital($arr_Where);
			$get_Data			= $this->employees_model->getEmployees();
			$detail				= $this->employees_model->getData('employees','id',$id); 
			$data = array(
				'title'				=> 'Edit Empchanges',
				'action'			=> 'edit',
				'data_Employees'	=> $get_Data,
				'data_companies'	=> $get_Data1,
				'data_divisions'	=> $get_Data2,
				'data_department'  	=> $get_Data3,
				'data_title'  		=> $get_Data4,
				'data_position'  	=> $get_Data5,
				'data_marital'  	=> $get_Data6,
				'row'				=> $detail,
				);
			
			$this->load->view('Calibrasichange/division',$data);
		}
	}

	
	public function grade($id=''){
		
		if($this->input->post()){
			$data					= $this->input->post();
			$Arr_Kembali			= array();
			unset($data['id']);
			$data_session			= $this->session->userdata;	
				
			$data['modified_by']	= $data_session['User']['username'];  
			$data['modified']		= date('Y-m-d H:i:s');
			
			if($this->employees_model->getUpdate('employees',$data,'id',$this->input->post('id'))){
				$this->employees_model->grade_history();				
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Edit Employees Success. Thank you & have a nice day.......'
				);
			
				
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
				redirect(site_url('Empchanges'));
			}
			$arr_Where			='';
			$get_Data1			= $this->employees_model->getGrades($arr_Where);
			$get_Data			= $this->employees_model->getEmployees();
			$detail				= $this->employees_model->getData('employees','id',$id); 
			$data = array(
				'title'			=> 'Edit Employees',
				'action'		=> 'edit',
				'data_Employees'=> $get_Data,
				'data_grade'	=> $get_Data1,
				'row'			=> $detail,
			);
			
			$this->load->view('Calibrasichange/grade',$data);
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