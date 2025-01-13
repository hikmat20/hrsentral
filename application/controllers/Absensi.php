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
		$user_id=$this->input->post("user_id");
		$tgl_awal=$this->input->post("tgl_awal");
		$tgl_akhir=$this->input->post("tgl_akhir");
		$data = array(
			'title'			=> 'Absensi',
			'action'		=> 'index',
			'uid'			=> $user_id,
			'taw'			=> $tgl_awal,
			'tak'			=> $tgl_akhir,
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
		$user_id=$this->input->post("user_id");
		$tgl_awal=$this->input->post("tgl_awal");
		$tgl_akhir=$this->input->post("tgl_akhir");
		$addsql="";
		if($user_id!=''){
			$addsql=" a.employee_id='".$user_id."' and DATE_FORMAT(a.waktu, '%Y-%m-%d')>='".$tgl_awal."' and DATE_FORMAT(a.waktu, '%Y-%m-%d')<='".$tgl_akhir."' ";
		}
		$data = $this->Absensi_model->GetListAbsensiJSON($postData,$userlist,$addsql);
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
		if($postData){
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
		}else{
			redirect('absensi/report');
		}
	}
	function preview_detail(){
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if ($Arr_Akses['read'] != '1') {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}
		$postData	= $this->input->post();
		if($postData){
			$results	= $this->Absensi_model->GetReportAbsensi($postData);
			$data = array(
				'title'		=> 'Report Absensi',
				'action'	=> 'index',
				'akses_menu'=> $Arr_Akses,
				'tgl_awal'	=> $postData['tgl_awal'],
				'tgl_akhir'	=> $postData['tgl_akhir'],
				'results'  	=> $results,
			);
			$this->load->view('Absensi/report_detail',$data);
		}else{
			redirect('absensi/report');
		}
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
			'title'		=> 'Form Absensi',
			'action'	=> 'form_absen',
			'akses_menu'=> $Arr_Akses,
			'userlist'	=>$userlist
		);
		$this->load->view('Absensi/form_absen_new',$data);
	}	 
}
