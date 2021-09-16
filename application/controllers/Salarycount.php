<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salarycount extends CI_Controller {
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
		
		$get_Data			= $this->employees_model->getDataEmpl();
		$Employees			= $this->employees_model->getEmployees();
		$get_Data2			= $this->employees_model->getEmpfamily();
		
		$data = array(
			'title'			=> 'Salary Count',
			'action'		=> 'Count',
			'religi'		=> '0',
			'row'			=> $get_Data,
			'data_menu'		=> $Employees,
			'akses_menu'	=> $Arr_Akses
		);
		history('View Data Count Salary');
		$this->load->view('Salarycount/index',$data);
	}

	
	public function search(){
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if($Arr_Akses['read'] !='1'){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}
				
		$data					= $this->input->post();
		$tgl1					= $this->input->post('first_date');
		$tgl2					= $this->input->post('second_date');
		$tgl1indo				= tgl_indo($this->input->post('first_date'));
		$tgl2indo				= tgl_indo($this->input->post('second_date'));
		
		$data_session			= $this->session->userdata;
		$data['created_by']		= $data_session['User']['username']; 
		$data['created']		= date('Y-m-d H:i:s');
		
		$get_Data			= $this->employees_model->getDataEmpl();
		$Employees			= $this->employees_model->getEmployees();
		$get_Data2			= $this->employees_model->getEmpfamily();
		$get_Data3			= $this->employees_model->getSalarycount($tgl1,$tgl2);
		
		$data = array(
			'title2'		=> 'Salary Count',
			'tgl1'          => $tgl1indo,
			'tgl2'          => $tgl2indo,
			'action'		=> 'Count',
			'title'		    => 'Salary Count ',
			'religi'		=> '0',
			'row'			=> $get_Data,
			'row2'			=> $get_Data3,
			'data_menu'		=> $Employees,
			'akses_menu'	=> $Arr_Akses
		);
		history('View Data Employees');
		$this->load->view('Salarycount/salaryrpt',$data);
	}
	public function excel(){
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if($Arr_Akses['read'] !='1'){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}
				
		$data					= $this->input->post();
		$tgl1					= $this->input->post('first_date');
		$tgl2					= $this->input->post('second_date');
		$tgl1indo				= tgl_indo($this->input->post('first_date'));
		$tgl2indo				= tgl_indo($this->input->post('second_date'));
		
		$data_session			= $this->session->userdata;
		$data['created_by']		= $data_session['User']['username']; 
		$data['created']		= date('Y-m-d H:i:s');
		
		$get_Data			= $this->employees_model->getDataEmpl();
		$Employees			= $this->employees_model->getEmployees();
		$get_Data2			= $this->employees_model->getEmpfamily();
		$get_Data3			= $this->employees_model->getSalarycount($tgl1,$tgl2);
		
		$data = array(
			'title2'		=> 'Report Absensi Tanggal',
			'tgl1'          => $tgl1indo,
			'tgl2'          => $tgl2indo,
			'action'		=> 'Search',
			'action'		=> 'Report Absensi',
			'religi'		=> '0',
			'row'			=> $get_Data,
			'row2'			=> $get_Data3,
			'data_menu'		=> $Employees,
			'akses_menu'	=> $Arr_Akses
		);
		history('View Data Employees');
		$this->load->view('Salarycount/absensi_excel',$data);
	}
}