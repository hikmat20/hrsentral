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

		$App = ($leaveCount) ? array_sum($leaveCount) : 0;
		$CNL = (isset($leaveCount['CNL'])) ? $leaveCount['CNL'] : 0;
		$REJ = (isset($leaveCount['REJ'])) ? $leaveCount['REJ'] : 0;
		$REV = (isset($leaveCount['REV'])) ? $leaveCount['REV'] : 0;

		$absensi = $this->db->order_by('waktu', 'DESC')->get_where('absensi_log', ['employee_id' => $userLogin, "STR_TO_DATE(`waktu`, '%Y-%m-%d') =" => date('Y-m-d')])->result();
		$approvalCT = $this->db->select('count(*) as num')->get_where('view_leave_applications', ['approval_employee_id' => $userLogin, 'status' => 'OPN', 'flag_leave_type' => 'CT'])->row();
		$approvalCP = $this->db->select('count(*) as num')->get_where('view_leave_applications', ['approval_employee_id' => $userLogin, 'status' => 'OPN', 'flag_leave_type' => 'CP'])->row();

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
			'absensi' 		=> $absensi,
			'semua'			=> $all,
			'leaveApp'			=> $App,
			'leaveOPN'			=> (isset($leaveCount['OPN'])) ? $leaveCount['OPN'] : 0,
			'leaveAPV'			=> (isset($leaveCount['APV'])) ? $leaveCount['APV'] : 0,
			'leaveREV'			=> (isset($leaveCount['REV'])) ? $leaveCount['REV'] : 0,
			'leaveHIS'			=> (isset($leaveCount['HIS'])) ? $leaveCount['HIS'] : 0,
			'leaveCNLREJ'	    => $CNL + $REJ,
			'approvalCT'		=> ($approvalCT->num) ? $approvalCT->num : '',
			'approvalCP'		=> ($approvalCP->num) ? $approvalCP->num : '',
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
