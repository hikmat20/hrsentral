<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Potongan extends CI_Controller {
	public function __construct(){
        parent::__construct();
		$this->load->model('master_model');
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
		
		$get_Data			= $this->employees_model->getDataPotongan();
		$Potongan			= $this->employees_model->getEmployees();
		$data = array(
			'title'			=> 'Indeks Of Allowances',
			'action'		=> 'index',
			'religi'		=> '0',
			'row'			=> $get_Data,
			'data_menu'		=> $Potongan,
			'akses_menu'	=> $Arr_Akses
		);
		history('View Data Potongan');
		$this->load->view('Potongan/index',$data);
	}

	
	public function add($id=''){
	
	    // print_r($this->input->post());
		// exit();
		if($this->input->post()){
			
			$Arr_Kembali			= array();			
			$data					= $this->input->post();
			$data_session			= $this->session->userdata;
			$data['id']				= $this->employees_model->code_otomatis('ms_potongan','POT');
			$data['created_by']		= $data_session['User']['username']; 
			$data['created']		= date('Y-m-d H:i:s');
			
			if($this->employees_model->simpan('ms_potongan',$data)){
				
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Add Allowance Success. Thank you & have a nice day.......'
				);
				history('Add Data Employees leave'.$data['id']);
			}else{
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Add Allowance failed. Please try again later......'
				);
				
			}
			echo json_encode($Arr_Kembali);
		}else{		
			$controller			= ucfirst(strtolower($this->uri->segment(1)));
			$Arr_Akses			= getAcccesmenu($controller);
			if($Arr_Akses['update'] !='1'){
				$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
				redirect(site_url('Potongan'));
			}
			$arr_Where			='';
			$get_Data5			= $this->employees_model->getPositions($arr_Where);
			$get_Data7			= $this->employees_model->getLeaves($arr_Where);
			$get_Data			= $this->employees_model->getEmployees($arr_Where);
			$Family_Type		= $this->master_model->getArray('family_category',array(),'kode','category');
			$Education_Type		= $this->master_model->getArray('education_level',array(),'kode','category');
			$detail				= $this->employees_model->getData('employees','id',$id); 
			$detail_family		= $this->master_model->getArray('family',array('employee_id'=>$id));
			$detail_education	= $this->master_model->getArray('educational',array('employee_id'=>$id));
			$data = array(
				'title'			=> 'Add Employee Potongan',
				'action'		=> 'add',
				'data_employees'=> $get_Data,
				'data_position'  => $get_Data5,
				'data_leaves'	=> $get_Data7,
				'row'			=> $detail
				
			);
			
			$this->load->view('Potongan/add',$data);
		}
	}
	
	
	public function edit($id=''){
		if($this->input->post()){
			$data					= $this->input->post();
			$Arr_Kembali			= array();
			unset($data['id']);
			$data_session			= $this->session->userdata;			
			$data['modified_by']	= $data_session['User']['username'];  
			$data['modified']		= date('Y-m-d H:i:s');
			if($this->master_model->getUpdate('ms_potongan',$data,'id',$this->input->post('id'))){
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Edit Positions Success. Thank you & have a nice day.......'
				);
				history('Edit Data Positions'.$data['name']);
				
			}else{
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Add Departement failed. Please try again later......'
				);
			}
			echo json_encode($Arr_Kembali);
		}else{		
			$controller			= ucfirst(strtolower($this->uri->segment(1)));
			$Arr_Akses			= getAcccesmenu($controller);
			if($Arr_Akses['update'] !='1'){
				$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
				redirect(site_url('Potongan'));
			}
			$arr_Where			= '';
			$get_Data			= $this->master_model->getCompanies($arr_Where);
			$get_Data5			= $this->employees_model->getPositions($arr_Where);
			$detail				= $this->master_model->getData('ms_potongan','id',$id); 
			$data = array(
				'title'			=> 'Edit Potongan',
				'action'		=> 'edit',
				'data_position'  => $get_Data5,
				'data_companies'=> $get_Data,
				'row'			=> $detail
			);
			
			$this->load->view('Potongan/edit',$data);
		}
	}
	
	
	

	
	
	
	function delete($id){
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if($Arr_Akses['delete'] !='1'){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('Potongan'));
		}
		
		$this->db->where('id', $id);
		$this->db->delete("ms_potongan");
		if($this->db->affected_rows()>0){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-success\" id=\"flash-message\">Data has been successfully deleted...........!!</div>");
			history('Delete Data Potongan id'.$id);
			redirect(site_url('Potongan'));
		}
	}
	function getDetail($kode=''){
		$Data_Array		= $this->employees_model->getArray('divisions',array('company_id'=>$kode),'id','name');
		echo json_encode($Data_Array);
	}
		
	function getDept($kode=''){
		$Data_Array		= $this->employees_model->getArray('departments',array('division_id'=>$kode),'id','name');
		echo json_encode($Data_Array);
	}
	function getTitle($kode=''){
		$Data_Array		= $this->employees_model->getArray('titles',array('department_id'=>$kode),'id','name');
		echo json_encode($Data_Array);
	}
	
	
	public function load_detail()
    {
		
		
		// $kd_meeting	= $_POST['cari'];
        // $session = $this->session->userdata('app_session');
        // $divisi  = $session['id_div']; 
        // $where   =array('kd_meeting'=> $kd_meeting, 'id_perusahaan'=>$prsh, 'id_cabang'=>$cbg );
        $numb = 1;
        $data = $this->employees_model->getData('ms_potongan'); 
		
		// print_r ($data);
		// exit;
        if($data != ''){
		
		echo "	<table id='example1' class='table table-bordered table-striped'>
					<tr>
						<td align='center' width='4%'><b>No</td>
						<td align='left' width='25%'><b>Name</td>
						<td align='left' width='25%'><b>Category</td>
						
					</tr>";	
	    $n=0;
		foreach ($data as $d){     
		$n++;
		
        if ($d->kategori==1){
        $kategori ='Harian';
        }	
		elseif ($d->kategori==2){
        $kategori ='Bulanan';
        }	
      		
		
    	echo "<tr class='view$n'>
				<td align='center'>$n</td>
				<td align='left'>".$d->name."</td>
				<td align='left'>".$kategori."</td>";
				
						
		  echo "</td>
				</tr>";
		 
		
		 		   
		}
		
		echo "</table>";
		
        }
        else
        {
        echo"Belum Ada Data";
        }
		
	}
}