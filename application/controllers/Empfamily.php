<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empfamily extends CI_Controller {
	public function __construct(){
        parent::__construct();
		$this->load->model('Employees_model');
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
		
		$get_Data			= $this->Employees_model->getEmpfamily();
		$Empfamily			= $this->Employees_model->getEmpfamily();
		
		$data = array(
			'title'			=> 'Indeks Of Employee Family',
			'action'		=> 'index',
			'row'			=> $get_Data,
			'data_menu'		=> $Empfamily,
			'akses_menu'	=> $Arr_Akses
		);
		history('View Data Empfamily');
		$this->load->view('Empfamily/index',$data);
	}
	function delete($id){
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if($Arr_Akses['delete'] !='1'){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('Empfamily'));
		}
		
		$this->db->where('id', $id);
		$this->db->delete("family");
		if($this->db->affected_rows()>0){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-success\" id=\"flash-message\">Data has been successfully deleted...........!!</div>");
			history('Delete Data Family id'.$id);
			redirect(site_url('Empfamily'));
		}
	}
	
}