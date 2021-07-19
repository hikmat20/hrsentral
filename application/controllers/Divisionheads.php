<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Divisionheads extends CI_Controller
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

		// $get_Data			= $this->master_model->getDatadiv();
		$get_Data		= $this->master_model->getData('divisions_head');

		$data = array(
			'title'			=> 'Indeks Of Divisions Head',
			'action'		=> 'index',
			'row'			=> $get_Data,
			'akses_menu'	=> $Arr_Akses
		);
		history('View Data Divisions');
		$this->load->view('Divisionheads/index', $data);
	}
	public function add()
	{
		if ($this->input->post()) {
			$Arr_Kembali			= array();
			$data					= $this->input->post();
			$expl                   = explode("-", $data['employee_id']);
			$data['employee_id']			    = $expl[0];
			$data['name']			= $expl[1];
			$data['description']			    = $data['description'];
			$data['id']				= $this->master_model->code_otomatis('divisions_head', 'DH');
			$data_session			= $this->session->userdata;
			$data['created_by']		= $data_session['User']['username'];
			$data['created_at']		= date('Y-m-d H:i:s');

			if ($this->master_model->simpan('divisions_head', $data)) {
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Add Divisions Success. Thank you & have a nice day.......'
				);
				history('Add Data Divisions' . $data['name']);
			} else {
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Add Divisions failed. Please try again later......'
				);
			}
			echo json_encode($Arr_Kembali);
		} else {
			$controller			= ucfirst(strtolower($this->uri->segment(1)));
			$Arr_Akses			= getAcccesmenu($controller);
			if ($Arr_Akses['create'] != '1') {
				$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
				redirect(site_url('menu'));
			}
			$arr_Where			= '';
			$get_Data			= $this->db->get('employees')->result_array();
			$emp = [];
			foreach ($get_Data as $get) {
				$emp[$get['id'] . "-" . $get['name']] = $get['name'];
			}

			$data = array(
				'title'			=> 'Add Divisions',
				'action'		=> 'add',
				'employee' => $emp
			);
			$this->load->view('Divisionheads/add', $data);
		}
	}
	public function edit($id = '')
	{
		if ($this->input->post()) {
			//echo"<pre>";print_r($this->input->post());exit;
			$data					= $this->input->post();
			$Arr_Kembali			= array();
			unset($data['id']);
			$expl                   = explode("-", $data['employee_id']);
			$data['employee_id']	= $expl[0];
			$data['name']			= $expl[1];
			$data['description']	= $data['description'];
			$data_session			= $this->session->userdata;
			$data['modified_by']	= $data_session['User']['username'];
			$data['modified_at']		= date('Y-m-d H:i:s');
			if ($this->master_model->getUpdate('divisions_head', $data, 'id', $this->input->post('id'))) {
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Edit Divisions Head Success. Thank you & have a nice day.......'
				);
				history('Edit Data Divisions' . $data['name']);
			} else {
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Update Divisions Head failed. Please try again later......'
				);
			}
			echo json_encode($Arr_Kembali);
		} else {
			$controller			= ucfirst(strtolower($this->uri->segment(1)));
			$Arr_Akses			= getAcccesmenu($controller);
			if ($Arr_Akses['update'] != '1') {
				$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
				redirect(site_url('divisions'));
			}
			$arr_Where			= '';
			$get_Data			= $this->db->get('employees')->result_array();
			$emp = [];
			foreach ($get_Data as $get) {
				$emp[$get['id'] . "-" . $get['name']] = $get['name'];
			}

			$detail				= $this->master_model->getData('divisions_head', 'id', $id);
			$data = array(
				'title'			=> 'Edit Divisions',
				'action'		=> 'edit',
				'employee' 		=> $emp,
				'row'			=> $detail
			);

			$this->load->view('Divisionheads/edit', $data);
		}
	}

	function delete($id)
	{
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if ($Arr_Akses['delete'] != '1') {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('divisionheads'));
		}

		$this->db->where('id', $id);
		$this->db->delete("divisions_head");
		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-success\" id=\"flash-message\">Data has been successfully deleted...........!!</div>");
			history('Delete Data divisions head id' . $id);
			redirect(site_url('divisionheads'));
		}
	}
}
