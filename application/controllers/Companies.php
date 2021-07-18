<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Companies extends CI_Controller {
	public function __construct(){
        parent::__construct();
		$this->load->model('master_model');
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
		
		$get_Data			= $this->master_model->getData('companies');
		$companies		= $this->master_model->getCompanies();
		
		$data = array(
			'title'			=> 'Indeks Of Companies',
			'action'		=> 'index',
			'row'			=> $get_Data,
			'data_menu'		=> $companies,
			'akses_menu'	=> $Arr_Akses
		);
		history('View Data Companies');
		$this->load->view('Companies/index',$data);
	}
	public function add(){	

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
			
		        
	 
			
			$Arr_Kembali			= array();			
			$data					= $this->input->post();
			$data['id']				= $this->master_model->code_otomatis('companies','COM');
			$data['image']			= $gambar;
			$data_session			= $this->session->userdata;
			$data['created_by']		= $data_session['User']['username']; 
			$data['created']		= date('Y-m-d H:i:s');
			
			if($this->master_model->simpan('companies',$data)){
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Add Companies Success. Thank you & have a nice day.......'
				);
				history('Add Data Companies'.$data['name']);
			}else{
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Add Companies failed. Please try again later......'
				);
				
			}
			echo json_encode($Arr_Kembali);
		}else{		
			$controller			= ucfirst(strtolower($this->uri->segment(1)));
			$Arr_Akses			= getAcccesmenu($controller);
			if($Arr_Akses['create'] !='1'){
				$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
				redirect(site_url('menu'));
			}
			$arr_Where			= array('flag_active'=>'1');
			$get_Data			= $this->master_model->getMenu($arr_Where);
			$data = array(
				'title'			=> 'Add Companies',
				'action'		=> 'add',
				'data_menu'		=> $get_Data
			);
			$this->load->view('Companies/add',$data);
		}
	}
	
	
					
	
	
	
	public function edit($id=''){
		
		/*$config['upload_path'] = './assets/img/'; //path folder
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
		*/
		if($this->input->post()){
			//echo"<pre>";print_r($this->input->post());exit;
			$data					= $this->input->post();
			$Arr_Kembali			= array();
			unset($data['id']);
			$data_session			= $this->session->userdata;
			//$data['image']			= $gambar;			
			$data['modified_by']	= $data_session['User']['username'];  
			$data['modified']		= date('Y-m-d H:i:s');
			if($this->master_model->getUpdate('companies',$data,'id',$this->input->post('id'))){
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Edit Companies Success. Thank you & have a nice day.......'
				);
				history('Edit Data Companies'.$data['name']);
				
			}else{
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Add Companies failed. Please try again later......'
				);
			}
			echo json_encode($Arr_Kembali);
		}else{		
			$controller			= ucfirst(strtolower($this->uri->segment(1)));
			$Arr_Akses			= getAcccesmenu($controller);
			if($Arr_Akses['update'] !='1'){
				$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
				redirect(site_url('companies'));
			}
			$get_Data			= $this->master_model->getCompanies();
			
			$detail				= $this->master_model->getData('companies','id',$id); 
			$data = array(
				'title'			=> 'Edit Companies',
				'action'		=> 'edit',
				'data_companies'=> $get_Data,
				'row'			=> $detail
			);
			
			$this->load->view('Companies/edit',$data);
		}
	}

	function delete($id){
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if($Arr_Akses['delete'] !='1'){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('Companies'));
		}
		
		$this->db->where('id', $id);
		$this->db->delete("companies");
		if($this->db->affected_rows()>0){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-success\" id=\"flash-message\">Data has been successfully deleted...........!!</div>");
			history('Delete Data companies id'.$id);
			redirect(site_url('Companies'));
		}
	}
}