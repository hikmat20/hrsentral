<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller {
  function __construct(){
  parent::__construct();
  
			$this->load->database();
			if(!$this->session->userdata('isLogin')){
			redirect('login');
		}
          $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
    }

 public function index() {
		$controller			= ucfirst(strtolower($this->uri->segment(1)));
		$Arr_Akses			= getAcccesmenu($controller);
		if($Arr_Akses['read'] !='1'){
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}
		$this->load->view('Upload/add');
 }

 public function upload(){
  $fileName = $this->input->post('file', TRUE);

  $config['upload_path'] = './assets/upload/'; 
  $config['file_name'] = $fileName;
  $config['allowed_types'] = 'xls|xlsx|csv|ods|ots';
  $config['max_size'] = 10000;

  $this->load->library('upload', $config);
  $this->upload->initialize($config);  
  
  if (!$this->upload->do_upload('file')) {
   $error = array('error' => $this->upload->display_errors());
   $this->session->set_flashdata('msg','Ada kesalah dalam upload'); 
    redirect(site_url('upload'));
  } else {
   $media = $this->upload->data();
   $inputFileName = 'assets/upload/'.$media['file_name'];
   
   try {
    $inputFileType = IOFactory::identify($inputFileName);
    $objReader = IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($inputFileName);
   } catch(Exception $e) {
    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
   }

   $sheet = $objPHPExcel->getSheet(0);
   $highestRow = $sheet->getHighestRow();
   $highestColumn = $sheet->getHighestColumn();

   for ($row = 2; $row <= $highestRow; $row++){  
     $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
       NULL,
       TRUE,
       FALSE);
     $data = array(
     "finger_id"=> $rowData[0][0],
     "name"=> $rowData[0][1],
     "date"=> $rowData[0][2],
     "timetable"=> $rowData[0][3],
     "on_duty"=> $rowData[0][4],
	 "off_duty"=> $rowData[0][5]
    );
    $this->db->insert("fingerprint_data",$data);
   } 
   $this->session->set_flashdata('msg','Berhasil upload ...!!'); 
   
   redirect(site_url('upload'));
  }  
 } 
}