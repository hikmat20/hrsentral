<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leaves extends CI_Controller {
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
		
		$get_Data			= $this->master_model->getData('at_leaves');
		$leaves				= $this->master_model->getLeaves();
		
		$data = array(
			'title'			=> 'Indeks Of Leaves',
			'action'		=> 'index',
			'descr'			=> 'No Description',
			'row'			=> $get_Data,
			'data_companies'=> $leaves,
			'akses_menu'	=> $Arr_Akses
		);
		history('View Data at_leaves');
		$this->load->view('Leaves/index',$data);
	}
	public function add(){		
		if($this->input->post()){
			$Arr_Kembali			= array();			
			$data					= $this->input->post();
			$data['id']				= $this->master_model->code_otomatis('at_leaves','LV');
			$data_session			= $this->session->userdata;
			$data['created_by']		= $data_session['User']['username']; 
			$data['created']		= date('Y-m-d H:i:s');
			if($this->master_model->simpan('at_leaves',$data)){
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Add at_leaves Success. Thank you & have a nice day.......'
				);
				history('Add Data at_leaves'.$data['name']);
			}else{
				$Arr_Kembali		= array( 
					'status'		=> 2,
					'pesan'			=> 'Add at_leaves failed. Please try again later......'
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
			$data = array(
				'title'			=> 'Add at_leaves',
				'action'		=> 'add',
				'data_companies'=> $get_Data
			);
			$this->load->view('Leaves/add',$data);
		}
	}
	public function edit($id=''){
		if($this->input->post()){
			$data					= $this->input->post();
			$Arr_Kembali			= array();
			unset($data['id']);
			$data_session			= $this->session->userdata;			
			$data['modified_by']	= $data_session['User']['username'];  
			$data['modified']		= date('Y-m-d H:i:s');
			if($this->master_model->getUpdate('at_leaves',$data,'id',$this->input->post('id'))){
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Edit leaves Success. Thank you & have a nice day.......'
				);
				history('Edit Data leaves'.$data['name']);
				
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
				redirect(site_url('leaves'));
			}
			$arr_Where			= '';
			$get_Data			= $this->master_model->getCompanies($arr_Where);
			
			$detail				= $this->master_model->getData('at_leaves','id',$id); 
			$data = array(
				'title'			=> 'Edit at_leaves',
				'action'		=> 'edit',
				'data_companies'=> $get_Data,
				'row'			=> $detail
			);
			
			$this->load->view('Leaves/edit',$data);
		}
	}

	function delete($id){
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if($Arr_Akses['delete'] !='1'){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('at_leaves'));
		}
		
		$this->db->where('id', $id);
		$this->db->delete("at_leaves");
		if($this->db->affected_rows()>0){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-success\" id=\"flash-message\">Data has been successfully deleted...........!!</div>");
			history('Delete Data at_leaves id'.$id);
			redirect(site_url('at_leaves'));
		}
	}
}