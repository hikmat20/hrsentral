<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 * @author Harboens
 * @copyright Copyright (c) 2021
 *
 * This is controller for absensi
 */
class Absensi extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model(array('Absensi_model'));
		$this->load->model('employees_model');
        date_default_timezone_set('Asia/Bangkok');
    }
	// list
    public function index() {
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if ($Arr_Akses['read'] != '1') {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}
		$data = array(
			'title'			=> 'Absensi',
			'action'		=> 'index',
			'akses_menu'	=> $Arr_Akses
		);
		$this->load->view('Absensi/index',$data);
    }

	// load ajax
	public function getDataJSON(){
	 $controller = ucfirst(strtolower($this->uri->segment(1)));
	 $Arr_Akses = getAcccesmenu($controller);
     $postData = $this->input->post();
	 $userlist=$this->session->userdata['User']['username'];
	 if($Arr_Akses['update']=='1') $userlist='';
		 $data = $this->Absensi_model->GetListAbsensiJSON($postData,$userlist);
		 echo json_encode($data);
	 }
	 
	function report(){
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if ($Arr_Akses['read'] != '1') {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}
		$get_Data			= $this->employees_model->getCompanies();
		$get_Data2			= $this->employees_model->getDivisions();
		$get_Data3			= $this->employees_model->getDepartments();
		$data = array(
			'title'			=> 'Absensi',
			'action'		=> 'index',
			'akses_menu'	=> $Arr_Akses,
			'data_companies'	=> $get_Data,
			'data_divisions'	=> $get_Data2,
			'data_department'  	=> $get_Data3,
		);
		$this->load->view('Absensi/form',$data);
	}
	function preview(){
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if ($Arr_Akses['read'] != '1') {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}
		$postData	= $this->input->post();
		$results	= $this->Absensi_model->GetReportAbsensi($postData);
		$data = array(
			'title'		=> 'Report Absensi',
			'action'	=> 'index',
			'akses_menu'=> $Arr_Akses,
			'tgl_awal'	=> $postData['tgl_awal'],
			'tgl_akhir'	=> $postData['tgl_akhir'],
			'results'  	=> $results,
		);
		$this->load->view('Absensi/report',$data);
	}
	
	function form_absen(){
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if ($Arr_Akses['read'] != '1') {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}
		$userlist=$this->session->userdata();
		$userlist=$this->session->userdata['User'];
		$data = array(
			'title'		=> 'Form Absens',
			'action'	=> 'index',
			'akses_menu'=> $Arr_Akses,
			'userlist'	=>$userlist
		);
		$this->load->view('Absensi/form_absen',$data);
	}
	 
}
