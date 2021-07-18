<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transleaves extends CI_Controller {
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
		
		$get_Data			= $this->employees_model->getDataTransleave();
		$Transleaves			= $this->employees_model->getEmployees();
		$data = array(
			'title'			=> 'Indeks Of Transleaves',
			'action'		=> 'index',
			'religi'		=> '0',
			'row'			=> $get_Data,
			'data_menu'		=> $Transleaves,
			'akses_menu'	=> $Arr_Akses
		);
		history('View Data Transleaves');
		$this->load->view('Transleaves/index',$data);
	}

	
	public function add($id=''){
	
		if($this->input->post()){
			
			$Arr_Kembali			= array();

			$employeeid		= $_POST['employee_id'];
			$year			= $_POST['year'];
			$leave			= $_POST['leave_id'];
			$jumlah			= $_POST['leave'];
			
			$data					= $this->input->post();
			$data_session			= $this->session->userdata;
			$data['id']				= $this->employees_model->code_otomatis('transaction_leave','TL');
			$data['created_by']		= $data_session['User']['username']; 
			$data['created']		= date('Y-m-d H:i:s');
			$countLeave				= $this->employees_model->getCountLeave();
			$countRowLeave			= $this->employees_model->getRowLeave();
			
			
			$hasil = array(
			'leave'	=> $countRowLeave
			);
			
			
			
			$where2 = array(
					'employee_id' => $employeeid,
					'year' 		  => $year,
					'leave_id' 	  => $leave
					);
			
			
					
			
			if($this->employees_model->simpan('transaction_leave',$data)){
				
				if($countLeave > 0){
					
					/*$Qry_Delete		= "UPDATE employees_leave SET leave ='$jumlah'
					WHERE employee_id='$employeeid' AND year='$year' AND leave_id='$leave' ";
					$Hasil_Del		= $this->db->query($Qry_Delete);
					
					  // $update = "update employees_leave set leave=leave-'$jumlah'
                      //  where employee_id='$employeeid' AND year='$year' AND leave_id='$leave' ";
						
						//	$Hasil_Del	= $this->db->query($update);*/
					
					$this->employees_model->update_data($where2,$jumlah,'employees_leave');
				}
				
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Add Transaction leave Success. Thank you & have a nice day.......'
				);
				history('Add Data Employees leave'.$data['employee_id']);
			}else{
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Add Transaction leave failed. Please try again later......'
				);
				
			}
			echo json_encode($Arr_Kembali);
		}else{		
			$controller			= ucfirst(strtolower($this->uri->segment(1)));
			$Arr_Akses			= getAcccesmenu($controller);
			if($Arr_Akses['update'] !='1'){
				$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
				redirect(site_url('Transleaves'));
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
				'data_Transleaves'=> $get_Data,
				'data_leaves'	=> $get_Data7,
				'row'			=> $detail
				
			);
			
			$this->load->view('Transleaves/add',$data);
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
			if($this->master_model->getUpdate('transaction_leave',$data,'employee_id',$this->input->post('employee_id'))){
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Edit Transleaves Success. Thank you & have a nice day.......'
				);
				history('Edit Data Transleaves');
				
			}else{
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Edit Transleaves failed. Please try again later......'
				);
			}
			echo json_encode($Arr_Kembali);
		}else{		
			$controller			= ucfirst(strtolower($this->uri->segment(1)));
			$Arr_Akses			= getAcccesmenu($controller);
			if($Arr_Akses['update'] !='1'){
				$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
				redirect(site_url('Transleaves'));
			}
			$arr_Where			= '';
			$get_Data7			= $this->employees_model->getLeaves($arr_Where);
			$detail				= $this->master_model->getData('transaction_leave','employee_id',$id); 
			$data = array(
				'title'			=> 'Edit Transleaves',
				'action'		=> 'edit',
				'data_leaves'	=> $get_Data7,
				'row'			=> $detail
			);
			
			$this->load->view('Transleaves/edit',$data);
		}
	}
	
	
	

	
	
	
	function delete($id){
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if($Arr_Akses['delete'] !='1'){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('Transleaves'));
		}
		
		$this->db->where('id', $id);
		$this->db->delete("employees_leave");
		if($this->db->affected_rows()>0){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-success\" id=\"flash-message\">Data has been successfully deleted...........!!</div>");
			history('Delete Data Transleaves id'.$id);
			redirect(site_url('Transleaves'));
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