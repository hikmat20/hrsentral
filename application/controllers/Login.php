<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('master_model');
	}

	public function index()
	{
		if ($this->session->userdata('isLogin')) {
			redirect('Dashboard');
		}
		//echo $this->uri->segment(1);
		if ($this->input->post()) {
			$UserName			= $this->input->post('username');
			$Password			= $this->input->post('password');
			$PassData			= cryptSHA1($Password);
			$WHERE				= array(
				'username'			=> $UserName,
				'password'			=> $PassData
			);
			$Cek_Data			= $this->master_model->getArray('users', $WHERE);
			//echo "<pre>";print_r($Cek_Data);exit;
			if ($Cek_Data) {
				$Group_ID		= $Cek_Data[0]['group_id'];
				$Employee_ID	= $Cek_Data[0]['employee_id'];
				$Aktif			= $Cek_Data[0]['flag_active'];
				if ($Aktif == 1) {
					$Arr_Daftar	= array();
					$Arr_Daftar['isLogin']	= 1;
					$Arr_Daftar['User']		= $Cek_Data[0];
					if ($Group_ID) {
						$WHR_Group		= array(
							'id'			=> $Group_ID
						);
						$Cek_Group		= $this->master_model->getArray('groups', $WHR_Group);
						if ($Cek_Group) {
							$Arr_Daftar['Group']	= $Cek_Group[0];
							unset($Cek_Group);
						}
					}
					if ($Employee_ID) {
						$WHR_Emp		= array(
							'id'			=> $Employee_ID
						);
						$Cek_Employee	= $this->master_model->getArray('employees', $WHR_Emp);
						if ($Cek_Employee) {
							$Arr_Daftar['Employee']	= $Cek_Employee[0];
							unset($Cek_Employee);
						}
					}
					$this->session->set_userdata($Arr_Daftar);
					$Arr_Return		= array(
						'status'		=> 1,
						'pesan'			=> 'Login Process Success. Thank You & Have A Nice Day..'
					);
				} else {
					$Arr_Return		= array(
						'status'		=> 2,
						'pesan'			=> 'Inactive Account. Please Contact Your Administrator....'
					);
				}
			} else {
				$Arr_Return		= array(
					'status'		=> 2,
					'pesan'			=> 'Incorrect Username Or Password. Please Try Again....'
				);
			}
			echo json_encode($Arr_Return);
		} else {
			// redirect('dashboard');
			$this->load->view('login');
		}
	}
}
