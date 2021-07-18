<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Departements extends CI_Controller {
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
		
		$get_Data			= $this->master_model->getDatadept();
		$departements		= $this->master_model->getDepartments();
		
		$data = array(
			'title'			=> 'Indeks Of Departements',
			'action'		=> 'index',
			'row'			=> $get_Data,
			'data_menu'		=> $departements,
			'akses_menu'	=> $Arr_Akses
		);
		history('View Data Departements');
		$this->load->view('Departements/index',$data);
	}
	public function add(){		
		if($this->input->post()){
			$Arr_Kembali			= array();			
			$data					= $this->input->post();
			$data['id']				= $this->master_model->code_otomatis('departments','DEP');
			$data_session			= $this->session->userdata;
			$data['created_by']		= $data_session['User']['username']; 
			$data['created']		= date('Y-m-d H:i:s');
			if($this->master_model->simpan('departments',$data)){
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Add Departements Success. Thank you & have a nice day.......'
				);
				history('Add Data Departement'.$data['name']);
			}else{
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Add Departements failed. Please try again later......'
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
			$arr_Where2			= $this->input->post('company_id');
			$get_Data			= $this->master_model->getCompanies($arr_Where);
			$get_Data2			= $this->master_model->optionDivisions($arr_Where2);
			$data = array(
				'title'			=> 'Add Departements',
				'action'		=> 'add',
				'data_companies'=> $get_Data,
				'data_divisions'=> $get_Data2,
				
			);
			
			$this->load->view('Departements/add',$data);
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
			if($this->master_model->getUpdate('departments',$data,'id',$this->input->post('id'))){
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Edit Departement Success. Thank you & have a nice day.......'
				);
				history('Edit Data Departement'.$data['name']);
				
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
				redirect(site_url('departements'));
			}
			$arr_Where			= '';
			$arr_Where2			= '';
			$get_Data			= $this->master_model->getCompanies($arr_Where);
			$get_Data2			= $this->master_model->getDivisions($arr_Where);
			$detail				= $this->master_model->getData('departments','id',$id); 
			$data = array(
				'title'			=> 'Edit Departements',
				'action'		=> 'edit',
				'data_companies'=> $get_Data,
				'data_divisions'=> $get_Data2,
				'row'			=> $detail
			);
			
			$this->load->view('Departements/edit',$data);
		}
	}

	function delete($id){
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if($Arr_Akses['delete'] !='1'){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('departements'));
		}
		
		$this->db->where('id', $id);
		$this->db->delete("departments");
		if($this->db->affected_rows()>0){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-success\" id=\"flash-message\">Data has been successfully deleted...........!!</div>");
			history('Delete Data Departments id'.$id);
			redirect(site_url('departements'));
		}
	}
	
	function getDetail($kode=''){
		$Data_Array		= $this->master_model->getArray('divisions',array('company_id'=>$kode),'id','name');
		echo json_encode($Data_Array);
	}
 
    
		
	

    
}