<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('employees_model');
		$this->load->database();
		if (!$this->session->userdata('isLogin')) {
			redirect('login');
		}

		$this->company 	= $this->session->Company->company_id;
		$this->branch 	= $this->session->Company->branch_id;
	}

	public function index()
	{
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if ($Arr_Akses['read'] != '1') {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}

		$get_Data			= $this->employees_model->getDataEmpl();
		$Employees			= $this->employees_model->getEmployees();

		$data = array(
			'title'			=> 'Indeks Of Employees',
			'action'		=> 'index',
			'row'			=> $get_Data,
			'data_menu'		=> $Employees,
			'akses_menu'	=> $Arr_Akses
		);
		history('View Data Employees');
		$this->load->view('index', $data);
	}

	public function getDateRange($start_date = "", $end_date = "")
	{
		$days = 0;
		if ($start_date && $end_date) {
			$start_date			= date($start_date, mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
			$end_date			= date($end_date);

			$datePeriod = new DatePeriod(
				new DateTime(date('Y-m-d', strtotime("0 day", strtotime($start_date)))),
				new DateInterval('P1D'),
				new DateTime(date('Y-m-d', strtotime("0 day", strtotime($end_date))))
			);

			$getHoliday = $this->db->get('at_holidays')->result_array();
			$holiday = [];
			foreach ($getHoliday as $hday) {
				$dates = date('Ymd', strtotime($hday['date']));
				$holiday[$dates] = $hday['name'];
			}

			$days = 0;
			$holiDay = [];
			foreach ($datePeriod as $dperiod) {
				$date = $dperiod->format('Ymd');
				if (isset($holiday[$date])) {
					$holiDay = [
						'holiday'   => date("Y-m-d", strtotime($date)),
						'deskripsi' => $holiday[$date]
					];
					// jika ada hari libur
				} elseif (date('D', strtotime($date)) === 'Sat') {
					// jika ada hari sabtu
				} elseif (date('D', strtotime($date)) === 'Sun') {
					// jika ada hari minggu
				} else {
					$days++;
				}
			}
		}
		return $days;
	}

	public function kehadiran()
	{
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller . '/kehadiran');
		if ($Arr_Akses['read'] != '1') {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}

		$periode = $this->db->get_where('date_periode', ['company_id' => $this->company, 'branch_id' => $this->branch])->row();
		$end = ($periode->date_end == date('d')) ? $periode->date_end : date('d');
		if ($periode->date_end <= date('d')) {
		}
		$start_date			= date("Y-m-$periode->date_start", mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
		$end_date			= date("Y-m-$end");

		$kehadiran			= $this->db->order_by('name', 'ASC')->where(['flag_active' => 'Y'])->get('view_report_kehadiran')->result();
		$hari_kerja 		= $this->getDateRange($start_date, $end_date);

		$data = array(
			'title'			=> 'Reports Kehadiran',
			'action'		=> 'index',
			'row'			=> $kehadiran,
			'hari_kerja'	=> $hari_kerja,
			'start_date'	=> $start_date,
			'end_date'		=> $end_date,
			'akses_menu'	=> $Arr_Akses
		);

		history('View Data Employees');
		$this->load->view('Reports/kehadiran', $data);
	}
}
