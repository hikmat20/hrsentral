<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Empleaves extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('master_model');
		$this->load->model('employees_model');
		$this->load->database();
		if (!$this->session->userdata('isLogin')) {
			redirect('login');
		}
	}

	public function index()
	{
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if ($Arr_Akses['read'] != '1') {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}

		// $get_Data			= $this->employees_model->get();
		$get_Data			= $this->db->get('view_emp_year_leave')->result();
		$data = array(
			'title'			=> 'Indeks Of Employee Anual Leave',
			'action'		=> 'index',
			'religi'		=> '0',
			'data_leave'	=> $get_Data,
			'akses_menu'	=> $Arr_Akses
		);
		history('View Data Empleaves');
		$this->load->view('Empleaves/index', $data);
	}


	public function add($id = '')
	{

		if ($this->input->post()) {

			$Arr_Kembali			= array();
			$data					= $this->input->post();
			$data_session			= $this->session->userdata;
			$data['id']				= $this->employees_model->code_otomatis('employees_leave', 'EL');
			$data['created_by']		= $data_session['User']['username'];
			$data['created']		= date('Y-m-d H:i:s');

			// $this->db->select('SUM(`leave`) as `leave`');
			// $this->db->from('employees_leave');
			// $this->db->where(['employee_id' => $data['employee_id'], 'year' => date('Y')]);
			// $leaveSum = $this->db->get()->row()->leave;

			$this->db->trans_begin();
			$row = $this->db->get_where('employees_leave_summary', ['employee_id' => $data['employee_id']])->row();
			$dataSum = [
				'id' 					=> $this->employees_model->code_otomatis('employees_leave_summary', 'ELS'),
				'employee_id' 			=> $data['employee_id'],
				'date_update' 			=> date('Y-m-d'),
				'total_leave' 			=> $data['leave'],
				'description' 			=> 'Updated by system #HRD',
				'updated_at' 			=> date('Y-m-d H:i:s')
			];

			if (!$row) {
				$this->db->insert('employees_leave_summary', $dataSum);
			} else {
				unset($dataSum['id']);
				$this->db->update('employees_leave_summary', $dataSum, ['id' => $row->id]);
			}

			$this->employees_model->simpan('employees_leave', $data);

			if ($this->db->trans_status() == TRUE) {
				$this->db->trans_commit();
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Add Employees leave Success. Thank you & have a nice day.......'
				);
				history('Add Data Employees leave' . $data['employee_id']);
			} else {
				$this->db->trans_rollback();
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Add Employees leave failed. Please try again later......'
				);
			}
			echo json_encode($Arr_Kembali);
		} else {
			$controller			= ucfirst(strtolower($this->uri->segment(1)));
			$Arr_Akses			= getAcccesmenu($controller);
			if ($Arr_Akses['update'] != '1') {
				$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
				redirect(site_url('Empleaves'));
			}
			$arr_Where			= '';
			$employees			= $this->employees_model->getData('employees');

			$data = array(
				'title'			=> 'Add Employee Anual leave',
				'action'		=> 'add',
				'employees' 	=> $employees,
			);

			$this->load->view('Empleaves/add', $data);
		}
	}


	public function edit($id = '')
	{
		if ($this->input->post()) {
			//echo"<pre>";print_r($this->input->post());exit;
			$data					= $this->input->post();
			$Arr_Kembali			= array();
			unset($data['employee_id']);
			$data_session			= $this->session->userdata;
			$data['modified_by']	= $data_session['User']['username'];
			$data['modified']		= date('Y-m-d H:i:s');
			if ($this->master_model->getUpdate('employees_leave', $data, 'id', $this->input->post('id'))) {
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Edit Empleaves Success. Thank you & have a nice day.......'
				);
				history('Edit Data Empleaves');
			} else {
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Add Departement failed. Please try again later......'
				);
			}
			echo json_encode($Arr_Kembali);
		} else {
			$controller			= ucfirst(strtolower($this->uri->segment(1)));
			$Arr_Akses			= getAcccesmenu($controller);
			if ($Arr_Akses['update'] != '1') {
				$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
				redirect(site_url('Empleaves'));
			}
			$employees			= $this->employees_model->getData('employees');
			$emp_leave			= $this->db->get_where('view_emp_year_leave', ['id' => $id])->row();

			$data = array(
				'title'			=> 'Edit Employee Anual leave',
				'action'		=> 'Edit',
				'employees' 	=> $employees,
				'emp_leave' 	=> $emp_leave,
			);

			$this->load->view('Empleaves/edit', $data);
		}
	}

	function delete($id)
	{
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if ($Arr_Akses['delete'] != '1') {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('Empleaves'));
		}

		$this->db->where('id', $id);
		$this->db->delete("employees_leave");
		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-success\" id=\"flash-message\">Data has been successfully deleted...........!!</div>");
			history('Delete Data Empleaves id' . $id);
			redirect(site_url('Empleaves'));
		}
	}
	function getDetail($kode = '')
	{
		$Data_Array		= $this->employees_model->getArray('divisions', array('company_id' => $kode), 'id', 'name');
		echo json_encode($Data_Array);
	}

	function getDept($kode = '')
	{
		$Data_Array		= $this->employees_model->getArray('departments', array('division_id' => $kode), 'id', 'name');
		echo json_encode($Data_Array);
	}
	function getTitle($kode = '')
	{
		$Data_Array		= $this->employees_model->getArray('titles', array('department_id' => $kode), 'id', 'name');
		echo json_encode($Data_Array);
	}
}
