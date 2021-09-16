<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salary extends CI_Controller {
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
		
		$get_Data			= $this->employees_model->getMasterSalary();
		$Salary				= $this->employees_model->getEmployees();
		$data = array(
			'title'			=> 'Indeks Of Salary',
			'action'		=> 'index',
			'religi'		=> '0',
			'row'			=> $get_Data,
			'data_menu'		=> $Salary,
			'akses_menu'	=> $Arr_Akses
		);
		history('View Data Salary');
		$this->load->view('Salary/index',$data);
	}

	
	public function add($id=''){
	
		if($this->input->post()){
			
			$Arr_Kembali			= array();

				
			$data					= $this->input->post();
			$data_session			= $this->session->userdata;
			$data['id']				= $this->employees_model->code_otomatis('salary','SLR');
			$data['created_by']		= $data_session['User']['username']; 
			$data['created']		= date('Y-m-d H:i:s');
			
				
					
			
			if($this->employees_model->simpan('salary',$data)){
				
						
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Add Transaction leave Success. Thank you & have a nice day.......'
				);
				history('Add Data Employees leave'.$data['employee_id']);
			}else{
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Add Transaction leave failed. Please try again later......'
				);
				
			}
			echo json_encode($Arr_Kembali);
		}else{		
			$controller			= ucfirst(strtolower($this->uri->segment(1)));
			$Arr_Akses			= getAcccesmenu($controller);
			if($Arr_Akses['update'] !='1'){
				$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
				redirect(site_url('Salary'));
			}
			$arr_Where			='';
			$get_Data7			= $this->employees_model->getLeaves($arr_Where);
			$get_Data			= $this->employees_model->getEmployees();
			$Family_Type		= $this->master_model->getArray('family_category',array(),'kode','category');
			$Education_Type		= $this->master_model->getArray('education_level',array(),'kode','category');
			$detail				= $this->employees_model->getData('employees','id',$id); 
			$detail_family		= $this->master_model->getArray('family',array('employee_id'=>$id));
			$detail_education	= $this->master_model->getArray('educational',array('employee_id'=>$id));
			$data = array(
				'title'			=> 'Add Employee Salary',
				'action'		=> 'add',
				'data_employee' => $get_Data,
				'data_leaves'	=> $get_Data7,
				'row'			=> $detail
				
			);
			
			$this->load->view('Salary/add',$data);
		}
	}
	
	
	public function edit($id=''){
		if($this->input->post()){
			//echo"<pre>";print_r($this->input->post());exit;
			$data					= $this->input->post();
			$Arr_Kembali			= array();
			unset($data['employee_id']);
			$data_session			= $this->session->userdata;			
			$data['modified_by']	= $data_session['User']['username'];  
			$data['modified']		= date('Y-m-d H:i:s');
			if($this->master_model->getUpdate('transaction_leave',$data,'employee_id',$this->input->post('employee_id'))){
				$Arr_Kembali		= array(
					'status'		=> 1,
					'pesan'			=> 'Edit Salary Success. Thank you & have a nice day.......'
				);
				history('Edit Data Salary');
				
			}else{
				$Arr_Kembali		= array(
					'status'		=> 2,
					'pesan'			=> 'Edit Salary failed. Please try again later......'
				);
			}
			echo json_encode($Arr_Kembali);
		}else{		
			$controller			= ucfirst(strtolower($this->uri->segment(1)));
			$Arr_Akses			= getAcccesmenu($controller);
			if($Arr_Akses['update'] !='1'){
				$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
				redirect(site_url('Salary'));
			}
			$arr_Where			= '';
			$get_Data7			= $this->employees_model->getSalary($arr_Where);
			$detail				= $this->master_model->getData('salary','employee_id',$id); 
			$data = array(
				'title'			=> 'Edit Salary',
				'action'		=> 'edit',
				'data_leaves'	=> $get_Data7,
				'row'			=> $detail
			);
			
			$this->load->view('Salary/edit',$data);
		}
	}
	
	
	

	
	
	
	function delete($id){
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if($Arr_Akses['delete'] !='1'){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('salary'));
		}
		
		$this->db->where('id', $id);
		$this->db->delete("salary");
		if($this->db->affected_rows()>0){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-success\" id=\"flash-message\">Data has been successfully deleted...........!!</div>");
			history('Delete Data Salary id'.$id);
			redirect(site_url('salary'));
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
	
	
	function get_tunjangan()
    {
     
		$kategori   = $this->input->post('kategori');
		$subsubject	= $this->db->query("SELECT * FROM ms_allowance WHERE kategori='$kategori' ")->result();
		
		echo "<select id='id_tunjangan' name='id_tunjangan' class='form-control'>
				<option value=''>Select An Option</option>";
		foreach($subsubject as $sbj){
		echo "<option value='$sbj->id'>".$sbj->name."</option>";
				}
		echo "</select>";
	}
	
	
	public function add_komponen(){
	
	    // print_r($this->input->post());
		// exit();
		if($this->input->post()){
			
			$Arr_Kembali			= array();			
			$data					= $this->input->post();
			$data_session			= $this->session->userdata;
			$data['id']				= $this->employees_model->code_otomatis('ms_salary_komponen','KOMP');
			$data['created_by']		= $data_session['User']['username']; 
			$data['created']		= date('Y-m-d H:i:s');
			
			if($this->employees_model->simpan('ms_salary_komponen',$data)){
				
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
		}
	}

public function load_detail()
    {
		
		
		$employee	= $_POST['cari'];
        // $session = $this->session->userdata('app_session');
        // $divisi  = $session['id_div']; 
        // $where   =array('kd_meeting'=> $kd_meeting, 'id_perusahaan'=>$prsh, 'id_cabang'=>$cbg );
        $numb = 1;
        // $data = $this->employees_model->getData('ms_salary_komponen'); 
		
		$data = $this->db->query("SELECT a.*, b.name as nama_tunjangan, b.kategori FROM ms_salary_komponen a
                                  inner join ms_allowance b ON b.id = a.id_tunjangan
							      WHERE employee_id='$employee' ")->result();
		
		// print_r ($data);
		// exit;
        if($data != ''){
		
		echo "	<table id='example1' class='table table-bordered table-striped'>
					<tr>
						<td align='center' width='4%'><b>No</td>
						<td align='left' width='25%'><b>Allowances</td>
						<td align='left' width='25%'><b>Category</td>
						<td align='right' width='25%'><b>Total</td>
						
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
				<td align='left'>".$d->nama_tunjangan."</td>
				<td align='left'>".$kategori."</td>
				<td align='right'>".$d->jumlah."</td>";
				
						
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
	
	
	public function cariGapok()
    {
		
		
		$employee	= $_POST['cari'];
        // $session = $this->session->userdata('app_session');
        // $divisi  = $session['id_div']; 
        // $where   =array('kd_meeting'=> $kd_meeting, 'id_perusahaan'=>$prsh, 'id_cabang'=>$cbg );
        $numb = 1;
        // $data = $this->employees_model->getData('ms_salary_komponen'); 
		
		$data = $this->db->query("SELECT a.pokok FROM salary a
                                 
							      WHERE employee_id='$employee' ")->result();
		
		// print_r ($data);
		// exit;
        if($data != ''){	
		
	    $n=0;
		foreach ($data as $d){ 
		$n++;
			
		
    	echo "$d->pokok";
		
		 		   
		}
		
		
		
        }
        else
        {
        echo"0";
        }
		
	}	
}