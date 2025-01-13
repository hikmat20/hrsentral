<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salarycount extends CI_Controller {
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
		
		$get_Data			= $this->employees_model->getDataEmpl();
		$Employees			= $this->employees_model->getEmployees();
		$get_Data2			= $this->employees_model->getEmpfamily();
		
		$data = array(
			'title'			=> 'Salary Count',
			'action'		=> 'Count',
			'religi'		=> '0',
			'row'			=> $get_Data,
			'data_menu'		=> $Employees,
			'akses_menu'	=> $Arr_Akses
		);
		history('View Data Count Salary');
		$this->load->view('Salarycount/index',$data);
	}

	
	public function search(){
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if($Arr_Akses['read'] !='1'){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}
		if($this->input->post()){
			
			$bulan=date('M');
			$tahun=date('Y');
			
			$bulan2=date('M');
			$tahun2=date('Y');
			
			$this->db->where('periode_gaji', $bulan);
			$this->db->where('tahun', $tahun);
			$this->db->delete("tr_salary");
			
			
			
			
			$this->db->where('periode_gaji', $bulan);
			$this->db->where('tahun', $tahun);
			$this->db->delete("ms_salary_komponen");
			 
	        
			  
			  $data = $this->db->query("SELECT a.employee_id, b.* FROM salary a  
			  INNER JOIN employees b on b.id=a.employee_id
			  ")->result();
		
			
				if($data != ''){	
			
				$n=0;
				foreach ($data as $d){ 
			    $n++;
	               
				$karyawan =$d->employee_id;
				
				
						$row1 = $this->db->query("SELECT a.* FROM salary a WHERE a.employee_id = '$karyawan'")->result();
						
								
								echo"<tr>";	
								
								 if($row1){
									
										foreach($row1 as $datas1){ 
											 $pokok = $datas1->pokok;
											 $v_pokok= number_format($pokok,0, ',', '.');

                        

                        
									 $row2 = $this->db->query("SELECT a.jumlah as total, b.* FROM ms_salary_komponen a
									LEFT JOIN ms_allowance b ON b.id=a.id_tunjangan
									WHERE a.employee_id = '$d->employee_id' AND a.kategori='1' AND a.id_tunjangan !=''")->result();
									  
											 if($row2){
													
														$tottjhr=0;
													foreach($row2 as $datas2){
														$tottjhr += $datas2->total;
														$v_tottjhr= number_format($tottjhr,0, ',', '.');
													
														
											
											
									
									 $row3 = $this->db->query("SELECT a.jumlah as total, b.* FROM ms_salary_komponen a
									LEFT JOIN ms_allowance b ON b.id=a.id_tunjangan
									WHERE a.employee_id = '$d->employee_id' AND a.kategori='2' AND a.id_tunjangan !='' ")->result();
									  
											 if($row3){
													$tottjbl=0;
													foreach($row3 as $datas3){
														
														$tottjbl += $datas3->total;
														$v_tottjbl= number_format($tottjbl,0, ',', '.');
											
											
											
									        $pot1 = $this->db->query("SELECT a.* FROM ms_bpjs a")->result();
									
								
											
											if($pot1){
												$thpbpjs=0;  
												$totbpjs=0;
											foreach($pot1 as $datap1){
														 $tjbpjs=$datap1->tunjangan*$pokok/100;
														 $totbpjs+=$tjbpjs;
														 $thpbpjs+=$datap1->potongan*$pokok/100; 
														 $v_totbpjs= number_format($totbpjs,0, ',', '.');
														 $v_thpbpjs= number_format($thpbpjs,0, ',', '.');
														
																}
																}
												
											
														
														
																
													
														 				
													
						   
							
							$total = $pokok+$tottjhr+$tottjbl+$totbpjs-$thpbpjs;
							
							$dataInsert['id']				= $this->employees_model->code_otomatis('tr_salary','TRS');
							$dataInsert['employee_id']	= $karyawan;
							$dataInsert['periode_awal']   = '2021-08-21';
							$dataInsert['periode_akhir']   = '2021-09-20';
							$dataInsert['periode_gaji']   =$bulan;
							$dataInsert['tahun']   =$tahun;
							$dataInsert['pokok']			= $pokok;
							$dataInsert['tj_harian']	= $tottjhr;
							$dataInsert['tj_bulanan']	= $tottjbl;
							$dataInsert['tj_bpjs']	= $totbpjs;
							$dataInsert['pot_bpjs']	= $thpbpjs;
							$dataInsert['total']	    = $total;							
							$data_session			= $this->session->userdata;							
							$dataInsert['created_by']		= $data_session['User']['username']; 
							$dataInsert['created']		= date('Y-m-d H:i:s');				
								
									
							
							$insert = $this->employees_model->simpan('tr_salary',$dataInsert);
							
							
							
					}
			  }
			  
			  
			  
				
							
								}
								}
						
						
							
								}
								}
						
			  
			  
	//ENDING FOREACH KARYAWAN	
	

	
	}
			
	}	


	
		$employee	            = $this->input->post('select_karyawan');
		$data					= $this->input->post();
		$tgl1					= $this->input->post('first_date');
		$tgl2					= $this->input->post('second_date');
		$tgl1indo				= tgl_indo($this->input->post('first_date'));
		$tgl2indo				= tgl_indo($this->input->post('second_date'));
		
		$data_session			= $this->session->userdata;
		$data['created_by']		= $data_session['User']['username']; 
		$data['created']		= date('Y-m-d H:i:s');
		
		$get_Data			= $this->employees_model->getDataEmpl();
		$Employees			= $this->employees_model->getEmployees();
		$get_Data2			= $this->employees_model->getEmpfamily();
		$get_Data3			= $this->employees_model->getSalarycount($tgl1,$tgl2);
		
		$data = array(
			'title2'		=> 'Salary Count',
			'tgl1'          => $tgl1indo,
			'tgl2'          => $tgl2indo,
			'action'		=> 'Count',
			'title'		    => 'Salary Count ',
			'religi'		=> '0',
			'row'			=> $get_Data,
			'row2'			=> $get_Data3,
			'data_menu'		=> $Employees,
			'akses_menu'	=> $Arr_Akses,
			'data_karyawan'	=> $employee	
		);
		history('View Data Employees');
		$this->load->view('Salarycount/check_salary',$data);
		
		
		}
		else{
		
		
		$employee	            = $this->input->post('select_karyawan');
		$data					= $this->input->post();
		$tgl1					= $this->input->post('first_date');
		$tgl2					= $this->input->post('second_date');
		$tgl1indo				= tgl_indo($this->input->post('first_date'));
		$tgl2indo				= tgl_indo($this->input->post('second_date'));
		
		$data_session			= $this->session->userdata;
		$data['created_by']		= $data_session['User']['username']; 
		$data['created']		= date('Y-m-d H:i:s');
		
		$get_Data			= $this->employees_model->getDataEmpl();
		$Employees			= $this->employees_model->getEmployees();
		$get_Data2			= $this->employees_model->getEmpfamily();
		$get_Data3			= $this->employees_model->getSalarycount($tgl1,$tgl2);
		
		$data = array(
			'title2'		=> 'Salary Count',
			'tgl1'          => $tgl1indo,
			'tgl2'          => $tgl2indo,
			'action'		=> 'Count',
			'title'		    => 'Salary Count ',
			'religi'		=> '0',
			'row'			=> $get_Data,
			'row2'			=> $get_Data3,
			'data_menu'		=> $Employees,
			'akses_menu'	=> $Arr_Akses,
			'data_karyawan'	=> $employee	
		);
		history('View Data Employees');
		$this->load->view('Salarycount/check_salary',$data);
	    }
	}
	
	
	
	
	public function search2(){
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if($Arr_Akses['read'] !='1'){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}
		
		
		$employee	            = $this->input->post('select_karyawan');
		$data					= $this->input->post();
		$tgl1					= $this->input->post('first_date');
		$tgl2					= $this->input->post('second_date');
		$tgl1indo				= tgl_indo($this->input->post('first_date'));
		$tgl2indo				= tgl_indo($this->input->post('second_date'));
		
		$data_session			= $this->session->userdata;
		$data['created_by']		= $data_session['User']['username']; 
		$data['created']		= date('Y-m-d H:i:s');
		
		$get_Data			= $this->employees_model->getDataEmpl();
		$Employees			= $this->employees_model->getEmployees();
		$get_Data2			= $this->employees_model->getEmpfamily();
		$get_Data3			= $this->employees_model->getSalarycount($tgl1,$tgl2);
		
		$data = array(
			'title2'		=> 'Salary Count',
			'tgl1'          => $tgl1indo,
			'tgl2'          => $tgl2indo,
			'action'		=> 'Count',
			'title'		    => 'Salary Count ',
			'religi'		=> '0',
			'row'			=> $get_Data,
			'row2'			=> $get_Data3,
			'data_menu'		=> $Employees,
			'akses_menu'	=> $Arr_Akses,
			'data_karyawan'	=> $employee	
		);
		history('View Data Employees');
		$this->load->view('Salarycount/check_salary',$data);
	    
	}

	public function excel_lama(){
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if($Arr_Akses['read'] !='1'){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}
				
		$data					= $this->input->post();
		$tgl1					= $this->input->post('first_date');
		$tgl2					= $this->input->post('second_date');
		$tgl1indo				= tgl_indo($this->input->post('first_date'));
		$tgl2indo				= tgl_indo($this->input->post('second_date'));
		
		$data_session			= $this->session->userdata;
		$data['created_by']		= $data_session['User']['username']; 
		$data['created']		= date('Y-m-d H:i:s');
		
		$get_Data			= $this->employees_model->getDataEmpl();
		$Employees			= $this->employees_model->getEmployees();
		$get_Data2			= $this->employees_model->getEmpfamily();
		$get_Data3			= $this->employees_model->getSalarycount($tgl1,$tgl2);
		
		$data = array(
			'title2'		=> 'Report Absensi Tanggal',
			'tgl1'          => $tgl1indo,
			'tgl2'          => $tgl2indo,
			'action'		=> 'Search',
			'action'		=> 'Report Absensi',
			'religi'		=> '0',
			'row'			=> $get_Data,
			'row2'			=> $get_Data3,
			'data_menu'		=> $Employees,
			'akses_menu'	=> $Arr_Akses
		);
		history('View Data Employees');
		$this->load->view('Salarycount/absensi_excel',$data);
	}
	
	public function slip(){
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if($Arr_Akses['read'] !='1'){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}
		
		;
		
		$employee	            = $this->input->post('id');
		//$periode	            = $this->uri->segment('4');
		$data					= $this->input->post();
		$tgl1					= $this->input->post('first_date');
		$tgl2					= $this->input->post('second_date');
		$tgl1indo				= tgl_indo($this->input->post('first_date'));
		$tgl2indo				= tgl_indo($this->input->post('second_date'));
		
		$data_session			= $this->session->userdata;
		$data['created_by']		= $data_session['User']['username']; 
		$data['created']		= date('Y-m-d H:i:s');
		
		$get_Data			= $this->employees_model->getDataEmpl();
		$Employees			= $this->employees_model->getEmployees();
		$get_Data2			= $this->employees_model->getEmpfamily();
		$get_Data3			= $this->employees_model->getSalarycount($tgl1,$tgl2);
		
		$data = array(
			'title2'		=> 'Salary Count',
			'tgl1'          => $tgl1indo,
			'tgl2'          => $tgl2indo,
			'action'		=> 'Count',
			'title'		    => 'Salary Count ',
			'religi'		=> '0',
			'row'			=> $get_Data,
			'row2'			=> $get_Data3,
			'data_menu'		=> $Employees,
			'akses_menu'	=> $Arr_Akses,
			'data_karyawan'	=> $employee
			
		);
		history('View Data Employees');
		$this->load->view('Salarycount/salaryrpt',$data);
	}
	
	public function addPotongan(){	
	    $controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		
		$id = $_POST['id'];
		$trsalary				= $this->employees_model->getData('tr_salary', 'id', $id);
		
		
		$potongan		    = $this->employees_model->getData('ms_potongan');
		
		$data = array(
			'title2'		=> 'Add Potongan',
			
			'action'		=> 'Count',
			'title'		    => 'Add Potongan ',
			'id'			=> $id,
			'row'			=> $trsalary,
			'potongan'		=> $potongan,
			'akses_menu'	=> $Arr_Akses
			
			
		);
		history('Add Data Potongan');
		$this->load->view('Salarycount/input_pot',$data);
		
	}  
	
	// PROSES SAVE BILLING RJ
	//-------------------------------------------------------------
	public function savePotongan(){
		
		$post = $this->input->post();
		// print_r($post);
		// exit;
		$session = $this->session->userdata('app_session');
      
		$bulan=date('M');
		$tahun=date('Y');
			
        $this->db->trans_begin();		
		## INSERT DT TRANSAKSI RJ ##
		
		    //$data					= $this->input->post();
			$data_session			= $this->session->userdata;
			$data['id']				= $this->employees_model->code_otomatis('ms_salary_komponen','KOMP');
			$data['employee_id']	= $this->input->post('employee_id');
			$data['kategori']	    = $this->input->post('potongan');
			$data['id_potongan']	= $this->input->post('id_potongan');
			$data['jumlah']     	= $this->input->post('jumlah');
			$data['periode_gaji']   = $bulan;
			$data['tahun']     	    = $tahun;
			$data['created_by']		= $data_session['User']['username']; 
			$data['created']		= date('Y-m-d H:i:s');
		
		    $insert = $this->db->insert("ms_salary_komponen",$data);
		
		
		    $id = $this->input->post('id');
		    $trsalary				= $this->employees_model->getData('tr_salary', 'id', $id);
			
			foreach($trsalary as $tr){
			$pokok 		= $tr->pokok;
			$tjharian 	= $tr->tj_harian;
			$tjbulanan 	= $tr->tj_bulanan;
			$tjbpjs		= $tr->tj_bpjs;
			$potbpjs	= $tr->pot_bpjs;
			$potlain  	= $tr->pot_lain + $this->input->post('jumlah');
			$total      = $pokok+$tjharian+$tjbulanan+$tjbpjs-$potbpjs-$potlain;
			
			// print_r($pokok);
			// exit;
			
			
			$data_session					= $this->session->userdata;	
			// $dataUpdate['pokok']				= $pokok;
            // $dataUpdate['tj_harian']			= $tjharian;
            // $dataUpdate['tj_bulanan']			= $tjbulanan;
            // $dataUpdate['tj_bpjs']				= $tjbpjs;  
            // $dataUpdate['pot_bpjs']				= $potbpjs; 
            $dataUpdate['pot_lain']				= $potlain;
            $dataUpdate['total']			    = $total;   			
			$dataUpdate['modified_by']	= $data_session['User']['username'];  
			$dataUpdate['modified']		= date('Y-m-d H:i:s');
			
			$update = $this->master_model->getUpdate('tr_salary',$dataUpdate,'id',$id);
			
			
			
		    }
		
		
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();			
			
			
			$status	= array(
			  'pesan'		=>'Success Save Item. Thanks ...',
			  'status'	=> 1
			);			
		}
		
  		echo json_encode($status);
	
	}
	
	
	function get_potongan()
    {
     
		$kategori   = $this->input->post('kategori');
		$subsubject	= $this->db->query("SELECT * FROM ms_potongan WHERE kategori='$kategori' ")->result();
		
		echo "<select id='id_potongan' name='id_potongan' class='form-control'>
				<option value=''>Select An Option</option>";
		foreach($subsubject as $sbj){
		echo "<option value='$sbj->id'>".$sbj->name."</option>";
				}
		echo "</select>";
	}
	
	
	public function load_potongan()
    {
		
		
		$employee	= $_POST['cari'];
        // $session = $this->session->userdata('app_session');
        // $divisi  = $session['id_div']; 
        // $where   =array('kd_meeting'=> $kd_meeting, 'id_perusahaan'=>$prsh, 'id_cabang'=>$cbg );
        $numb = 1;
        // $data = $this->employees_model->getData('ms_salary_komponen'); 
		
		$data = $this->db->query("SELECT a.*, b.name as nama_potongan, b.kategori FROM ms_salary_komponen a
                                  inner join ms_potongan b ON b.id = a.id_potongan
							      WHERE a.employee_id='$employee' ")->result();
		
		// print_r ($data);
		// exit;
        if($data != ''){
		
		echo "	<table id='example1' class='table table-bordered table-striped'>
					<tr>
						<td align='center' width='4%'><b>No</td>
						<td align='left' width='25%'><b>Potongan</td>
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
				<td align='left'>".$d->nama_potongan."</td>
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
	
	
	##UPDATE TR SALARY##
	
	public function update_absensi(){
		
		$post = $this->input->post();
		// print_r($post);
		// exit;
		$session = $this->session->userdata('app_session');
      
		$bulan=date('M');
		$tahun=date('Y');
			
        $this->db->trans_begin();		
		## INSERT DT TRANSAKSI RJ ##
		
		    //$data					= $this->input->post();
			$data_session			= $this->session->userdata;
					
		    $id = $this->input->post('id');
		    $trsalary				= $this->employees_model->getData('tr_salary', 'id', $id);
			
			foreach($trsalary as $tr){
			$pokok 		= $tr->pokok;
			$tjharian 	= $tr->tj_harian;
			$tjbulanan 	= $tr->tj_bulanan;
			$tjbpjs		= $tr->tj_bpjs;
			$potbpjs	= $tr->pot_bpjs;
			$potpinjaman  	= $tr->pot_pinjaman;
			$potpph  	= $tr->pot_pph;
			$potabsensi  	= $tr->pot_absensi + str_replace(".", "", $this->input->post('harga'));
				$total      = $pokok+$tjharian+$tjbulanan+$tjbpjs-$potbpjs-$potpph-$potpinjaman-$potabsensi;
			
			
			// print_r($pokok);
			// exit;
			
			
			$data_session					= $this->session->userdata;	
			// $dataUpdate['pokok']				= $pokok;
            // $dataUpdate['tj_harian']			= $tjharian;
            // $dataUpdate['tj_bulanan']			= $tjbulanan;
            // $dataUpdate['tj_bpjs']				= $tjbpjs;  
            // $dataUpdate['pot_bpjs']				= $potbpjs; 
            $dataUpdate['pot_absensi']				= $potabsensi;
            $dataUpdate['total']			    = $total;   			
			$dataUpdate['modified_by']	= $data_session['User']['username'];  
			$dataUpdate['modified']		= date('Y-m-d H:i:s');
			
			$update = $this->master_model->getUpdate('tr_salary',$dataUpdate,'id',$id);
			
			
			
		    }
		
		
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();			
			
			
			$status	= array(
			  'pesan'		=>'Success Save Item. Thanks ...',
			  'status'	=> 1
			);			
		}
		
  		echo json_encode($status);
	
	}
	
	##UPDATE TR SALARY##
	
	public function update_pinjaman(){
		
		$post = $this->input->post();
		// print_r($post);
		// exit;
		$session = $this->session->userdata('app_session');
      
		$bulan=date('M');
		$tahun=date('Y');
			
        $this->db->trans_begin();		
		## INSERT DT TRANSAKSI RJ ##
		
		    //$data					= $this->input->post();
			$data_session			= $this->session->userdata;
					
		    $id = $this->input->post('id');
		    $trsalary				= $this->employees_model->getData('tr_salary', 'id', $id);
			
			foreach($trsalary as $tr){
			$pokok 		= $tr->pokok;
			$tjharian 	= $tr->tj_harian;
			$tjbulanan 	= $tr->tj_bulanan;
			$tjbpjs		= $tr->tj_bpjs;
			$potbpjs	= $tr->pot_bpjs;
			$potabsensi	= $tr->pot_absensi;
			$potpph  	= $tr->pot_pph;
			$potpinjaman  	= $tr->pot_pinjaman + str_replace(".", "", $this->input->post('harga'));
			$total      = $pokok+$tjharian+$tjbulanan+$tjbpjs-$potbpjs-$potpph-$potpinjaman-$potabsensi;
			
			// print_r($pokok);
			// exit;
			
			
			$data_session					= $this->session->userdata;	
			// $dataUpdate['pokok']				= $pokok;
            // $dataUpdate['tj_harian']			= $tjharian;
            // $dataUpdate['tj_bulanan']			= $tjbulanan;
            // $dataUpdate['tj_bpjs']				= $tjbpjs;  
            // $dataUpdate['pot_bpjs']				= $potbpjs; 
            $dataUpdate['pot_pinjaman']				= $potpinjaman;
            $dataUpdate['total']			    = $total;   			
			$dataUpdate['modified_by']	= $data_session['User']['username'];  
			$dataUpdate['modified']		= date('Y-m-d H:i:s');
			
			$update = $this->master_model->getUpdate('tr_salary',$dataUpdate,'id',$id);
			
			
			
		    }
		
		
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();			
			
			
			$status	= array(
			  'pesan'		=>'Success Save Item. Thanks ...',
			  'status'	=> 1
			);			
		}
		
  		echo json_encode($status);
	
	}
	
	
	##UPDATE TR SALARY##
	
	public function update_pph(){
		
		$post = $this->input->post();
		// print_r($post);
		// exit;
		$session = $this->session->userdata('app_session');
      
		$bulan=date('M');
		$tahun=date('Y');
			
        $this->db->trans_begin();		
		## INSERT DT TRANSAKSI RJ ##
		
		    //$data					= $this->input->post();
			$data_session			= $this->session->userdata;
					
		    $id = $this->input->post('id');
		    $trsalary				= $this->employees_model->getData('tr_salary', 'id', $id);
			
			foreach($trsalary as $tr){
			$pokok 		= $tr->pokok;
			$tjharian 	= $tr->tj_harian;
			$tjbulanan 	= $tr->tj_bulanan;
			$tjbpjs		= $tr->tj_bpjs;
			$potbpjs	= $tr->pot_bpjs;
			$potabsensi	= $tr->pot_absensi;
			$potpinjaman	= $tr->pot_pinjaman;
			$potpph  	= $tr->pot_pph + str_replace(".", "", $this->input->post('harga'));
			$total      = $pokok+$tjharian+$tjbulanan+$tjbpjs-$potbpjs-$potpph-$potpinjaman-$potabsensi;
			
			// print_r($pokok);
			// exit;
			
			
			$data_session					= $this->session->userdata;	
			// $dataUpdate['pokok']				= $pokok;
            // $dataUpdate['tj_harian']			= $tjharian;
            // $dataUpdate['tj_bulanan']			= $tjbulanan;
            // $dataUpdate['tj_bpjs']				= $tjbpjs;  
            // $dataUpdate['pot_bpjs']				= $potbpjs; 
            $dataUpdate['pot_pph']				= $potpph;
            $dataUpdate['total']			    = $total;   			
			$dataUpdate['modified_by']	= $data_session['User']['username'];  
			$dataUpdate['modified']		= date('Y-m-d H:i:s');
			
			$update = $this->master_model->getUpdate('tr_salary',$dataUpdate,'id',$id);
			
			
			
		    }
		
		
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status	= array(
			  'pesan'		=>'Gagal Save Item. Thanks ...',
			  'status'	=> 0
			);
		} else {
			$this->db->trans_commit();			
			
			
			$status	= array(
			  'pesan'		=>'Success Save Item. Thanks ...',
			  'status'	=> 1
			);			
		}
		
  		echo json_encode($status);
	
	}
	
	public function excel(){
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if($Arr_Akses['read'] !='1'){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}
		
		$get_Data			= $this->employees_model->getDataCompEmpl('COM003');
		$Employees			= $this->employees_model->getEmployees();
		
		$data = array(
			'title'			=> 'Indeks Of Salarycount',
			'action'		=> 'index',
			'status'		=> 'Belum Kontrak',
			'religi'		=> '0',
			'sisakontrakbln'=> '',
			'sisakontrakth'	=> '',
			'row'			=> $get_Data,
			'data_menu'		=> $Employees,
			'akses_menu'	=> $Arr_Akses
		);
		history('View Data Salarycount');
		$this->load->view('Salarycount/salary_excel',$data);
	}
}