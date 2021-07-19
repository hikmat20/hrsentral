<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('employees_model');
		$this->load->database();

		// Your own constructor code
		if (!$this->session->userdata('isLogin')) {
			redirect('login');
		}
	}

	public function index()
	{

		//$this->load->view('include/header', array('title'=>'Dashboard'));
		// history('View Dashboard');
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if ($Arr_Akses['read'] != '1') {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}

		$get_Data			= $this->employees_model->getDataEmpl();
		$Employees			= $this->employees_model->getEmployees();

		$jumlah				= $this->employees_model->prismaempNumrows();
		$jumlahtetap		= $this->employees_model->prismatetapNumrows();
		$jumlahkontrak1		= $this->employees_model->prismakontrak1Numrows();
		$jumlahkontrak2		= $this->employees_model->prismakontrak2Numrows();
		$jumlahkontrak3		= $this->employees_model->prismakontrak3Numrows();

		$danest				= $this->employees_model->danestempNumrows();
		$danesttetap		= $this->employees_model->danesttetapNumrows();
		$danestkontrak1		= $this->employees_model->danestkontrak1Numrows();
		$danestkontrak2		= $this->employees_model->danestkontrak2Numrows();
		$danestkontrak3		= $this->employees_model->danestkontrak3Numrows();

		$prismalatest1		= $this->employees_model->getnumDataLatestContract1('COM003');
		$prismalatest2		= $this->employees_model->getnumDataLatestContract2('COM003');
		$prismalatest3		= $this->employees_model->getnumDataLatestContract3('COM003');

		$danestlatest1		= $this->employees_model->getnumDataLatestContract1('COM004');
		$danestlatest2		= $this->employees_model->getnumDataLatestContract2('COM004');
		$danestlatest3		= $this->employees_model->getnumDataLatestContract3('COM004');

		$all			     = $this->employees_model->empNumrows();
		$userLogin			 = $this->session->User['employee_id'];

		if ($userLogin) {
			$this->load->model('leavesModel');
			$leaveCount = $this->leavesModel->getCountLeave(['employee_id' => $userLogin], ['status']);
		} else {
			$leaveCount = '';
		}
		// echo '<pre>';
		// print_r($leaveCount);
		// echo '<pre>';
		// exit;

		$data = array(
			'title'			=> 'Dashboard',
			'action'		=> 'index',
			'row'			=> $get_Data,
			'jumlah'		=> $jumlah,
			'jumlahtetap'	=> $jumlahtetap,
			'jumlahkontrak1' => $jumlahkontrak1,
			'jumlahkontrak2' => $jumlahkontrak2,
			'jumlahkontrak3' => $jumlahkontrak3,
			'danest'		=> $danest,
			'danesttetap'	=> $danesttetap,
			'danestkontrak1' => $danestkontrak1,
			'danestkontrak2' => $danestkontrak2,
			'danestkontrak3' => $danestkontrak3,
			'prismalatest1' => $prismalatest1,
			'prismalatest2' => $prismalatest2,
			'prismalatest3' => $prismalatest3,
			'danestlatest1' => $danestlatest1,
			'danestlatest2' => $danestlatest2,
			'danestlatest3' => $danestlatest3,
			'semua'			=> $all,
			'leaveApp'			=> (isset($leaveCount)) ? array_sum($leaveCount) : 0,
			'leaveOPN'			=> (isset($leaveCount['OPN'])) ? $leaveCount['OPN'] : 0,
			'leaveAPV'			=> (isset($leaveCount['APV'])) ? $leaveCount['APV'] : 0,
			'leaveCNLREJ'	    => (isset($leaveCount['CNL']) || isset($leaveCount['REJ'])) ? $leaveCount['CNL'] + $leaveCount['REJ'] : 0,
			'data_menu'		=> $Employees,
			'akses_menu'	=> $Arr_Akses
		);
		history('View Data Employees');
		$this->load->view('Dashboard/index', $data);
	}

	public function logout()
	{
		$this->session->sess_destroy();
		history('Logout');
		$this->session->set_userdata(array());
		redirect('login');
	}
}
