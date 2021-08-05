<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('master_model');
		$this->load->model('employees_model');
		// Your own constructor code
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

		$data_Group			= $this->master_model->getArray('groups', array(), 'id', 'name');
		$data = array(
			'title'			=> 'Indeks Of Users',
			'action'		=> 'index',
			'row_group'		=> $data_Group,
			'akses_menu'	=> $Arr_Akses
		);
		history('View Data User');
		$this->load->view('Users/index', $data);
	}

	function display_data()
	{
		$this->autoRender = FALSE;
		$table = 'users';
		$primaryKey = 'id';
		$columns = array(
			array('db' => 'id', 'dt' => 'id'),
			array(
				'db' => 'id',
				'dt' => 'DT_RowId'
			),
			array('db' => 'username', 'dt' => 'username'),
			array('db' => 'group_id', 'dt' => 'group_id'),
			array('db' => 'flag_active', 'dt' => 'flag_active'),
			array(
				'db' => 'id',
				'dt' => 'action',
				'formatter' => function ($d, $row) {
					return '';
				}
			),
			array(
				'db' => 'flag_active',
				'dt' => 'status',
				'formatter' => function ($d, $row) {
					return '';
				}
			),
			array(
				'db' => 'group_id',
				'dt' => 'group_name',
				'formatter' => function ($d, $row) {
					return '';
				}
			),
		);
		$sql_details = array(
			'user' => 'root',
			'pass' => 'Annabell2018',
			'db'   => 'hr_sentral',
			'host' => '103.228.117.98'
		);
		require('ssp.class.php');

		echo json_encode(
			SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
		);
		//echo "<pre>";print_r($data);exit;

	}

	public function register_user()
	{
		if ($this->input->post()) {
			$Arr_Kembali			= array();
			$data					= $this->input->post();
			$UserCek				= $this->input->post('username');
			$Password				= cryptSHA1($this->input->post('password'));
			$data['password']		= $Password;
			$data['flag_active']	= 1;
			$data_session			= $this->session->userdata;
			$data['created_by']		= $data_session['User']['username'];
			$data['created']		= date('Y-m-d H:i:s');
			// CEK user
			$countUser				= $this->master_model->getCount('users', 'username', $UserCek);
			if ($countUser > 0) {
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Username Already Exists. Please input different username......'
				);
			} else {
				if ($this->master_model->simpan('users', $data)) {
					$Arr_Kembali		= array(
						'status'		=> 1,
						'pesan'			=> 'Register User Success. Thank you & have a nice day.......'
					);
					history('Add Data User ' . $data['username']);
				} else {
					$Arr_Kembali		= array(
						'status'		=> 2,
						'pesan'			=> 'Register User failed. Please try again later......'
					);
				}
			}
			echo json_encode($Arr_Kembali);
		} else {
			$controller			= ucfirst(strtolower($this->uri->segment(1)));
			$Arr_Akses			= getAcccesmenu($controller);
			if ($Arr_Akses['create'] != '1') {
				$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
				redirect(site_url('users'));
			}

			$data_Group			= $this->master_model->getArray('groups', array(), 'id', 'name');
			$data_employees			= $this->employees_model->getEmployees();

			$data = array(
				'title'			=> 'Add Users',
				'action'		=> 'register_user',
				'data_group'	=> $data_Group,
				'data_employees'	=> $data_employees
			);
			$this->load->view('Users/add', $data);
		}
	}

	public function edit_user($id = '')
	{
		if ($this->input->post()) {
			$Arr_Kembali			= array();
			$data					= $this->input->post();
			unset($data['id']);
			$UserCek				= $this->input->post('username');
			$Password				= cryptSHA1($this->input->post('password'));
			$data['password']		= $Password;
			$data_session			= $this->session->userdata;
			$data['modified_by']	= $data_session['User']['username'];
			$data['modified']		= date('Y-m-d H:i:s');

			if ($this->master_model->getUpdate('users', $data, 'id', $this->input->post('id'))) {
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Edit User Success. Thank you & have a nice day.......'
				);
				history('Add Data Menu' . $data['username']);
			} else {
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Edit User failed. Please try again later......'
				);
			}

			echo json_encode($Arr_Kembali);
		} else {
			$controller			= ucfirst(strtolower($this->uri->segment(1)));
			$Arr_Akses			= getAcccesmenu($controller);
			if ($Arr_Akses['update'] != '1') {
				$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
				redirect(site_url('users'));
			}

			$data_Group			= $this->master_model->getArray('groups', array(), 'id', 'name');
			$rows_data			= $this->master_model->getData('users', 'id', $id);
			$data_employees			= $this->employees_model->getEmployees();
			$data = array(
				'title'			=> 'Edit Users',
				'action'		=> 'edit_user',
				'data_group'	=> $data_Group,
				'rows_data'		=> $rows_data,
				'data_employees'	=> $data_employees
			);
			$this->load->view('Users/edit', $data);
		}
	}

	function delete_user($id = '')
	{
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if ($Arr_Akses['delete'] != '1') {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('users'));
		}
		$rows_data			= $this->master_model->getData('users', 'id', $id);
		if ($rows_data[0]->username == 'admin') {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-danger\" id=\"flash-message\">This Account Can't Be Deleted...........!!</div>");
		} else {
			$this->db->where('id', $id);
			$this->db->delete("users");
			if ($this->db->affected_rows() > 0) {
				$this->session->set_flashdata("alert_data", "<div class=\"alert alert-success\" id=\"flash-message\">Data has been successfully deleted...........!!</div>");
				history('Delete Data User Username : ' . $rows_data[0]->username);
			}
		}
		redirect(site_url('users'));
	}

	public function view_user($id = '')
	{
		$data_Group			= $this->master_model->getArray('groups', array(), 'id', 'name');
		$rows_data			= $this->master_model->getData('users', 'id', $id);
		$data = array(
			'title'			=> 'View Users',
			'action'		=> 'view_user',
			'data_group'	=> $data_Group,
			'rows_data'		=> $rows_data
		);
		$this->load->view('Users/view', $data);
	}
}
