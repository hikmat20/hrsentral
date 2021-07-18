<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prismafirstcontract extends CI_Controller {
	public function __construct(){
        parent::__construct();
		$this->load->model('employees_model');
		$this->load->database();
        if(!$this->session->userdata('isLogin')){
			redirect('login');
		}
    }

	public function index(){
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if($Arr_Akses['read'] !='1'){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}
		
		$get_Data			= $this->employees_model->prismakontrak1('COM003');
		//$Employees			= $this->employees_model->getEmployees();
		
		$data = array(
			'title'			=> 'Indeks Of Prisma First Contract Employees',
			'action'		=> 'index',
			'status'		=> 'Belum Kontrak',
			'religi'		=> '0',
			'sisakontrakbln'=> '',
			'sisakontrakth'	=> '',
			'row'			=> $get_Data,
			//'data_menu'		=> $Employees,
			'akses_menu'	=> $Arr_Akses
		);
		history('View Data Employees');
		$this->load->view('Employeelist/prismafirstcontract',$data);
	}
	
	public function excel(){
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if($Arr_Akses['read'] !='1'){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}
		
		$get_Data			= $this->employees_model->prismakontrak1('COM003');
		$Employees			= $this->employees_model->getEmployees();
		
		$data = array(
			'title'			=> 'Indeks Of Employees',
			'action'		=> 'index',
			'status'		=> 'Belum Kontrak',
			'religi'		=> '0',
			'sisakontrakbln'=> '',
			'sisakontrakth'	=> '',
			'row'			=> $get_Data,
			'data_menu'		=> $Employees,
			'akses_menu'	=> $Arr_Akses
		);
		history('View Data Employees');
		$this->load->view('Reports/prismafirstcontract_excel',$data);
	}
	
	public function view($id=''){
		
		$config['upload_path'] = './assets/img/'; //path folder
	    $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
	    $config['encrypt_name'] = TRUE; //Enkripsi nama yang terupload

	    $this->upload->initialize($config);
	   

	        if ($this->upload->do_upload('image')){
	            $gbr = $this->upload->data();
	            //Compress Image
	            $config['image_library']='gd2';
	            $config['source_image']='./assets/img/'.$gbr['file_name'];
	            $config['create_thumb']= FALSE;
	            $config['maintain_ratio']= FALSE;
	            $config['quality']= '50%';
	            $config['width']= 260;
	            $config['height']= 350;
	            $config['new_image']= './assets/img/'.$gbr['file_name'];
	            $this->load->library('image_lib', $config);
	            $this->image_lib->resize();

	            $gambar=$gbr['file_name'];
				
			}
		
		if($this->input->post()){
			//echo"<pre>";print_r($this->input->post());exit;
			$data					= $this->input->post();
			$Arr_Kembali			= array();
			unset($data['id']);
			$data_session			= $this->session->userdata;	
			$data['image']			= $gambar;			
			$data['modified_by']	= $data_session['User']['username'];  
			$data['modified']		= date('Y-m-d H:i:s');
			if($this->employees_model->getUpdate('employees',$data,'id',$this->input->post('id'))){
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Edit Employees Success. Thank you & have a nice day.......'
				);
				history('Edit Data Employees'.$data['name']);
				
			}else{
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Add Employees failed. Please try again later......'
				);
			}
			echo json_encode($Arr_Kembali);
		}else{		
			$controller			= ucfirst(strtolower($this->uri->segment(1)));
			$Arr_Akses			= getAcccesmenu($controller);
			if($Arr_Akses['update'] !='1'){
				$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
				redirect(site_url('Employees'));
			}
			$arr_Where			='';
			$get_Data1			= $this->employees_model->getCompanies($arr_Where);
			$get_Data2			= $this->employees_model->getDivisions($arr_Where);
			$get_Data3			= $this->employees_model->getDepartments($arr_Where);
			$get_Data4		= $this->employees_model->getTitles($arr_Where);
			$get_Data5		= $this->employees_model->getPositions($arr_Where);
			$get_Data6		= $this->employees_model->getMarital($arr_Where);
			$get_Data			= $this->employees_model->getEmployees();
			
			$detail				= $this->employees_model->getData('employees','id',$id); 
			$data = array(
				'title'			=> 'View Employees',
				'action'		=> 'edit',
				'data_Employees'=> $get_Data,
				'data_companies'=> $get_Data1,
				'data_divisions'=> $get_Data2,
				'data_department'  => $get_Data3,
				'data_title'  	=> $get_Data4,
				'data_position'  	=> $get_Data5,
				'data_marital'  	=> $get_Data6,
				'row'				=> $detail
			);
			
			$this->load->view('Employeelist/view',$data);
		}
	}
	
}