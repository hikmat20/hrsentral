<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller {
  function __construct(){
  parent::__construct();
  
			$this->load->model('master_model');
			$this->load->database();
		
			if(!$this->session->userdata('isLogin')){
			redirect('login');
		}
          //$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
    }

 public function index() {
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if($Arr_Akses['read'] !='1'){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}
		
		
	    $get_Data			= $this->master_model->getData('fingerprint_data_temp');
		
		$data = array(
			'title'			=> 'Index Data Fingerprint',
			'action'		=> 'index',
			'row'			=> $get_Data,
			'akses_menu'	=> $Arr_Akses
		);
		$this->load->view('Upload/index',$data);
 }

 public function form() {
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
			$Arr_Akses			= getAcccesmenu($controller);
			if($Arr_Akses['create'] !='1'){
				$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
				redirect(site_url('menu'));
			}
		
		
	    $get_Data			= $this->master_model->getData('fingerprint_data');
		
		$data = array(
			'title'			=> 'Upload Data Fingerprint',
			'action'		=> 'upload',
			'row'			=> $get_Data,
			'akses_menu'	=> $Arr_Akses
		);
		$this->load->view('Upload/add',$data);
 }
 
 public function upload(){
	 
	$data_session	= $this->session->userdata;
	$username		= $data_session['User']['username']; 
	$datetime		= date('Y-m-d H:i:s');
			
			
	 set_time_limit(0);
	ini_set('memory_limit','2048M');
	if($_FILES['excel_file']['name']){
		$exts	= getExtension($_FILES['excel_file']['name']);					
		if(!in_array($exts,array(1=>'xls','xlsx','csv','ods','ots'))){
			$Arr_Kembali	= array(
				'pesan'			=>'Incorrect file type, Please upload excel file type..........',
				'status'		=> 2
			);						
		}else{
			$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
			PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
			//$this->load->library(array('PHPExcel')); 
			$fileName 					= $_FILES['excel_file']['name'];						
			$config['upload_path'] 		= './assets/upload/'; 
			$config['file_name'] 		= $fileName;
			$config['allowed_types'] 	= 'xls|xlsx|csv|ods|ots';
			$config['max_size'] 		= 100000;

			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('excel_file')) {
				$Arr_Kembali	= array(
					'pesan'			=>'An Error occured, please try again later...........',
					'status'		=> 2
				);						
				//$error = array('error' => $this->upload->display_errors());							
			}else{
				$media 				= $this->upload->data();
				$inputFileName 		= './assets/upload/'.$media['file_name'];
				//echo"<pre>";print_r($inputFileName);exit;
				try{
					$inputFileType 	= IOFactory::identify($inputFileName);
					$objReader 		= IOFactory::createReader($inputFileType);	
					$objReader->setReadDataOnly(true);								
					$objPHPExcel 	= $objReader->load($inputFileName);
					
				}catch(Exception $e){
					die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());								
				}
				
				$sheet 			= $objPHPExcel->getSheet(0);
				$highestRow 	= $sheet->getHighestRow();
				$highestColumn 	= $sheet->getHighestColumn();
				$Error			= 0;
				$Loop			= 0;
				$Message		= "";
				$Urut			= 0;							
				$Arr_Detail		= array();
				
				
				for ($row = 2; $row <= $highestRow; $row++){								
					$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL,TRUE,FALSE);
					echo "<pre>";
					print_r($rowData);
					exit;
					$Urut++;
					 $data = array(
						 "name"=> $rowData[0][0],
						 "date"=> $rowData[0][1],
						 "timetable"=>$rowData[0][2],
						 "clock_in"	=> $rowData[0][3],
						 "clock_out"=> $rowData[0][4],
						 "created"	=> $datetime,
						 "created_by"=> $username
						);
					
					$Arr_Detail[$Urut]	= $data;
				} //penutup data array
				//exit;	
				
				$this->db->trans_start();
				$this->db->insert_batch('fingerprint_data_temp',$Arr_Detail);
				$this->db->truncate('fingerprint_data');					
				$this->db->trans_complete();
				if ($this->db->trans_status() === FALSE){
					$this->db->trans_rollback();
					
					$Arr_Kembali	= array(
						'pesan'			=>'Upload process failed. Please try again later......',
						'status'		=> 2
					);
				}else{
					$this->db->trans_commit();
					$Arr_Kembali	= array(
						'pesan'			=>'Upload process Success. Thank You & Have A Nice Day......',
						'status'		=> 1
					);
					//history('Import Data Vehicle Realitation '.$Kode_Budget.' At Month '.$Bulan_Proses);
				}
				
			}
		}
	}else{
		$Arr_Kembali	= array(
			'pesan'			=>'No file was uploaded. Please upload file first...',
			'status'		=> 2
		);
		
	}
	echo json_encode($Arr_Kembali);
	
 } 
}