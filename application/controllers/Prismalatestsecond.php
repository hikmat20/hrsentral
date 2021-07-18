<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prismalatestsecond extends CI_Controller {
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
		
		$get_Data			= $this->employees_model->getDataLatestContract2('COM003');
		$Employees			= $this->employees_model->getEmployees();
		
		$data = array(
			'title'			=> 'Indeks Of Prisma Latest Second Contract Employees',
			'action'		=> 'index',
			'status'		=> 'Belum Kontrak',
			'religi'		=> '0',
			'sisakontrakbln'=> '',
			'sisakontrakth'	=> '',
			'row'			=> $get_Data,
			'data_menu'		=> $Employees,
			'akses_menu'	=> $Arr_Akses
		);
		history('View Data Employees');
		$this->load->view('Employeelist/prismalatestsecond',$data);
	}
	
	public function excel(){
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if($Arr_Akses['read'] !='1'){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}
		
		$get_Data			= $this->employees_model->getDataLatestContract2('COM003');
		$Employees			= $this->employees_model->getEmployees();
		
		$data = array(
			'title'			=> 'Indeks Of Employees',
			'action'		=> 'index',
			'status'		=> 'Belum Kontrak',
			'religi'		=> '0',
			'sisakontrakbln'=> '',
			'sisakontrakth'	=> '',
			'row'			=> $get_Data,
			'data_menu'		=> $Employees,
			'akses_menu'	=> $Arr_Akses
		);
		history('View Data Employees');
		$this->load->view('Reports/prismalatestsecond_excel',$data);
	}
	
	
	
}