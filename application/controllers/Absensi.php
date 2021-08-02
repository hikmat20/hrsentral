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
	}
