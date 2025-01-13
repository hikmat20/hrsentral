<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 * @author Harboens
 * @copyright Copyright (c) 2021
 *
 * This is controller for Trasaction Expense
 */

$status=array();
class Expense extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model(array('Expense_model','All_model'));
		$this->load->model('employees_model');
        date_default_timezone_set('Asia/Bangkok');
		$this->status=array("0"=>"Baru","1"=>"Disetujui","2"=>"Selesai");
    }

	// list expense
    public function index() {
		$results = $this->Expense_model->GetListData(array('nama'=>$this->session->userdata['User']['username']));
		$controller			= ucfirst(strtolower('expense'));
		$Arr_Akses			= getAcccesmenu($controller);
		if ($Arr_Akses['read'] != '1') {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}
		$data = array(
			'title'			=> 'Expense Report',
			'action'		=> 'index',
			'results'		=> $results,
			'status'		=> $this->status,
			'akses_menu'	=> $Arr_Akses
		);
		$this->load->view('Expense/index',$data);
    }
    public function list_expense_approval() {
		$results = $this->Expense_model->GetListData('status=0');
		$controller			= ucfirst(strtolower('expense'));
		$Arr_Akses			= getAcccesmenu($controller);
		if ($Arr_Akses['read'] != '1') {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}
		$data = array(
			'title'			=> 'Expense Approval',
			'action'		=> 'index',
			'results'		=> $results,
			'status'		=> $this->status,
			'akses_menu'	=> $Arr_Akses
		);
		$this->load->view('Expense/index_approval',$data);
    }
	// create
	public function create(){
		$data_budget = $this->All_model->GetComboBudget('','EXPENSE',date('Y'));
		$controller			= ucfirst(strtolower('expense'));
		$Arr_Akses			= getAcccesmenu($controller);
		if ($Arr_Akses['read'] != '1') {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}

		$data = array(
			'title'			=> 'Expense',
			'action'		=> 'index',
			'status'		=> $this->status,
			'action'		=> 'index',
			'data_budget'	=> $data_budget,
			'akses_menu'	=> $Arr_Akses
		);
		$this->load->view('Expense/form',$data);
	}

	// edit
	public function edit($id){
		$response = $this->Expense_model->GetDataHeader($id);
		$data_detail	= $this->Expense_model->GetDataDetail($response->no_doc);
		$data_budget = $this->All_model->GetComboBudget('','EXPENSE',date('Y'));

		$controller			= ucfirst(strtolower('expense'));
		$Arr_Akses			= getAcccesmenu($controller);
		if ($Arr_Akses['read'] != '1') {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}

		$data = array(
			'title'			=> 'Expense',
			'stsview'		=> '',
			'action'		=> 'index',
			'status'		=> $this->status,
			'data_budget'	=> $data_budget,
			'data_detail'	=> $data_detail,
			'data'			=> $response,
			'akses_menu'	=> $Arr_Akses
		);
		$this->load->view('Expense/form',$data);
	}

	// view
	public function approval($id){
		$response = $this->Expense_model->GetDataHeader($id);
		$data_detail	= $this->Expense_model->GetDataDetail($response->no_doc);
		$data_budget = $this->All_model->GetComboBudget('','EXPENSE',date('Y'));

		$controller			= ucfirst(strtolower('expense'));
		$Arr_Akses			= getAcccesmenu($controller);
		if ($Arr_Akses['read'] != '1') {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}

		$data = array(
			'title'			=> 'Expense',
			'stsview'		=> 'approval',
			'action'		=> 'index',
			'status'		=> $this->status,
			'data_budget'	=> $data_budget,
			'data_detail'	=> $data_detail,
			'data'			=> $response,
			'akses_menu'	=> $Arr_Akses
		);
		$this->load->view('Expense/form',$data);
	}
	// view
	public function view($id){
		$response = $this->Expense_model->GetDataHeader($id);
		$data_detail	= $this->Expense_model->GetDataDetail($response->no_doc);
		$data_budget = $this->All_model->GetComboBudget('','EXPENSE',date('Y'));

		$controller			= ucfirst(strtolower('expense'));
		$Arr_Akses			= getAcccesmenu($controller);
		if ($Arr_Akses['read'] != '1') {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}

		$data = array(
			'title'			=> 'Expense',
			'stsview'		=> 'view',
			'action'		=> 'index',
			'status'		=> $this->status,
			'data_budget'	=> $data_budget,
			'data_detail'	=> $data_detail,
			'data'			=> $response,
			'akses_menu'	=> $Arr_Akses
		);
		$this->load->view('Expense/form',$data);
	}

	// print	
	public function expense_print($id){
		$response = $this->Expense_model->GetDataHeader($id);
		$data_detail	= $this->Expense_model->GetDataDetail($response->no_doc);
		$controller			= ucfirst(strtolower('expense'));
		$Arr_Akses			= getAcccesmenu($controller);
		if ($Arr_Akses['read'] != '1') {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}
		$data = array(
			'title'			=> 'Print Expense',
			'action'		=> 'index',
			'stsview'		=> 'print',
			'status'		=> $this->status,
			'data_detail'	=> $data_detail,
			'data'			=> $response,
			'akses_menu'	=> $Arr_Akses
		);
		$this->load->view('Expense/expense_print',$data);
	}

	// approve
	public function approve($id=''){
		$result=false;
        if($id!="") {
			$data = array(
					'approved_by'=> $this->session->userdata['User']['username'],
					'approved_on'=>date("Y-m-d h:i:s"),
					'status'=>1,
					);
			$result=$this->All_model->dataUpdate(DBERP.'.tr_expense',$data,array('id'=>$id));
        }
        $param = array(
                'save' => $result, 'id'=>$id
                );
        echo json_encode($param);
	}

	// save
	public function save(){
        $id             = $this->input->post("id");
		$tgl_doc  		= $this->input->post("tgl_doc");
        $no_doc		    = $this->input->post("no_doc");
        $departement	= $this->input->post("departement");
        $nama			= $this->input->post("nama");
        $approval		= $this->input->post("approval");
        $informasi		= $this->input->post("informasi");		
        $bank_id		= $this->input->post("bank_id");
        $accnumber		= $this->input->post("accnumber");
        $accname		= $this->input->post("accname");
		
        $coa			= $this->input->post("coa");
        $detail_id		= $this->input->post("detail_id");
        $deskripsi		= $this->input->post("deskripsi");
        $spesifikasi	= $this->input->post("spesifikasi");
        $qty			= $this->input->post("qty");
        $harga			= $this->input->post("harga");
        $kasbon			= $this->input->post("kasbon");
        $expense		= $this->input->post("expense");
        $tanggal		= $this->input->post("tanggal");
        $keterangan		= $this->input->post("keterangan");
        $filename		= $this->input->post("filename");
        $id_kasbon		= $this->input->post("id_kasbon");
        $grand_total		= $this->input->post("grand_total");
		

		$this->db->trans_begin();
		$config['upload_path'] = './assets/expense/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|pdf|doc|docx|jfif';
		$config['remove_spaces'] = TRUE;
		$config['encrypt_name'] = TRUE;
        if($id!="") {
			$data = array(
						'tgl_doc'=>$tgl_doc,
//						'coa'=>$coa,
						'jumlah'=>$grand_total,
						'informasi'=>$informasi,
						'bank_id'=>$bank_id,
						'accnumber'=>$accnumber,
						'accname'=>$accname,
						
						'modified_by'=> $this->session->userdata['User']['username'],
						'modified_on'=>date("Y-m-d h:i:s")
					);
			$result = $this->All_model->dataUpdate(DBERP.'.tr_expense',$data,array('id'=>$id));

			$this->All_model->dataDelete(DBERP.'.tr_expense_detail',array('no_doc'=>$no_doc));
			if(!empty($detail_id)){
				foreach ($detail_id as $keys => $val){
					$no_doc = $no_doc;
					if($qty[$keys]>0) {
						$filenames=$filename[$keys];
						if(!empty($_FILES['doc_file_'.$val]['name'])){
							$_FILES['file']['name'] = $_FILES['doc_file_'.$val]['name'];
							$_FILES['file']['type'] = $_FILES['doc_file_'.$val]['type'];
							$_FILES['file']['tmp_name'] = $_FILES['doc_file_'.$val]['tmp_name'];
							$_FILES['file']['error'] = $_FILES['doc_file_'.$val]['error'];
							$_FILES['file']['size'] = $_FILES['doc_file_'.$val]['size'];
							$this->load->library('upload',$config);
							$this->upload->initialize($config);
							if($this->upload->do_upload('file')){
								$uploadData = $this->upload->data();
								$filenames = $uploadData['file_name'];
							}else{
							}
								
						}

						$data_detail =  array(
								'no_doc'=>$no_doc,
								'deskripsi'=>$deskripsi[$keys],
								'qty'=>$qty[$keys],
								'harga'=>$harga[$keys],
								'total_harga'=>($qty[$keys]*$harga[$keys]),
								'kasbon'=>$kasbon[$keys],
								'expense'=>$expense[$keys],
								'tanggal'=>$tanggal[$keys],
								'keterangan'=>$keterangan[$keys],
								'coa'=>$coa[$keys],
								'doc_file'=>$filenames,
								'id_kasbon'=>$id_kasbon[$keys],
								'created_by'=> $this->session->userdata['User']['username'],
								'created_on'=>date("Y-m-d h:i:s"),
								'modified_by'=> $this->session->userdata['User']['username'],
								'modified_on'=>date("Y-m-d h:i:s")
							);
						$this->All_model->dataSave(DBERP.'.tr_expense_detail',$data_detail);
					}
				}
			}
			$keterangan     = "SUKSES, Edit data ".$id;
			$status         = 1; $nm_hak_akses   = ""; $kode_universal = $id; $jumlah = 1;
			$sql            = $this->db->last_query();
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
			} else {
				$this->db->trans_commit();
			}
        } else {
			$no_doc=$this->All_model->GetAutoGenerate('format_expense');
            $data =  array(
						'no_doc'=>$no_doc,
						'tgl_doc'=>$tgl_doc,
						'departement'=>$departement,
//						'coa'=>$coa,
						'nama'=>$nama,
						'informasi'=>$informasi,
						'bank_id'=>$bank_id,
						'accnumber'=>$accnumber,
						'accname'=>$accname,

						'approval'=>$approval,
						'status'=>0,
						'jumlah'=>$grand_total,
						'created_by'=> $this->session->userdata['User']['username'],
						'created_on'=>date("Y-m-d h:i:s"),
					);
            $id = $this->All_model->dataSave(DBERP.'.tr_expense',$data);
			// update budget
//			$this->Expense_model->Update_budget($id_type,$tgl_doc,$total,$divisi);
			if(!empty($detail_id)){
				foreach ($detail_id as $keys => $val){
					$no_doc			= $no_doc;
					if($qty[$keys]>0) {
						$filenames="";
						if(!empty($_FILES['doc_file_'.$val]['name'])){
							$_FILES['file']['name'] = $_FILES['doc_file_'.$val]['name'];
							$_FILES['file']['type'] = $_FILES['doc_file_'.$val]['type'];
							$_FILES['file']['tmp_name'] = $_FILES['doc_file_'.$val]['tmp_name'];
							$_FILES['file']['error'] = $_FILES['doc_file_'.$val]['error'];
							$_FILES['file']['size'] = $_FILES['doc_file_'.$val]['size'];
							$this->load->library('upload',$config);
							$this->upload->initialize($config);
							if($this->upload->do_upload('file')){
								$uploadData = $this->upload->data();
								$filenames = $uploadData['file_name'];
							}
						}
						$data_detail =  array(
								'no_doc'=>$no_doc,
								'deskripsi'=>$deskripsi[$keys],
								'qty'=>$qty[$keys],
								'harga'=>$harga[$keys],
								'total_harga'=>($qty[$keys]*$harga[$keys]),
								'kasbon'=>$kasbon[$keys],
								'expense'=>$expense[$keys],
								'tanggal'=>$tanggal[$keys],
								'keterangan'=>$keterangan[$keys],
								'doc_file'=>$filenames,
								'id_kasbon'=>$id_kasbon[$keys],
								'coa'=>$coa[$keys],
								'created_by'=> $this->session->userdata['User']['username'],
								'created_on'=>date("Y-m-d h:i:s")
							);
						$this->All_model->dataSave(DBERP.'.tr_expense_detail',$data_detail);
					}
				}
			}
            if(is_numeric($id)) {
                $result	= TRUE;
            } else {
                $result = FALSE;
            }
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
			} else {
				$this->db->trans_commit();
			}
        }
        $param = array(
                'save' => $result, 'id'=>$id
                );
        echo json_encode($param);
	}

	// delete
	public function delete($id){
		$this->db->trans_begin();

		// update budget old
/*
		$data_old  = $this->Expense_model->find_by(array('id' => $id));
		if($data_old) {
			$this->Expense_model->Update_budget($data_old->id_type,$data_old->tgl_doc,($data_old->total*-1), $data_old->divisi);
		}
*/
		$data = $this->Expense_model->GetDataHeader($id);
        $this->All_model->dataDelete(DBERP.'.tr_expense_detail',array('no_doc'=>$data->no_doc));
        $this->All_model->dataDelete(DBERP.'.tr_expense',array('no_doc'=>$data->no_doc));
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$result=FALSE;
		} else {
			$this->db->trans_commit();
			$result=TRUE;
		}
        $param = array( 'delete' => $result );
        echo json_encode($param);
	}

	function cekbudget(){
        $dtl		= $this->input->post("dtl");
        $divisi		= $this->input->post("divisi");

		$tanggal	= $this->input->post("tgl_doc");
        $coa	= $this->input->post("coa");
		$tahun = date("Y",strtotime($tanggal));
        $data = $this->Expense_model->GetBudget($coa,$tahun);
		$param=array();
		if($data!==false){
			if($dtl==''){
				$bulan=date("n",strtotime($tanggal));
				$budget=0;
				$terpakai=0;
				for($i=1;$i<=$bulan;$i++){
					$budget=($budget+$data->{"bulan_".$i});
					$terpakai=($terpakai+$data->{"terpakai_bulan_".$i});
				}
				$sisa=($budget-$terpakai);
				$param = array(
						'budget' => $budget,
						'terpakai' => $terpakai,
						'sisa'=>$sisa,
						);
			}else{
				$param=$data;
			}
		}else{
			if($dtl==''){
				$param = array(
						'budget' =>0,
						'terpakai' =>0,
						'sisa'=>0,
						'tipe'=>'',
						);
			}
		}
		echo json_encode($param);
   }

	// list management transport
    public function transport_req_mgt() {
		$divhead="";		
		$datauser = $this->db->get_where('users', ['username' => $this->session->userdata['User']['username']])->row();
		$divisionshead = $this->db->get_where('divisions_head', ['employee_id' => $datauser->employee_id])->row();
		if($divisionshead) $divhead=$divisionshead->id;
//print_r($divisionshead);die();
		$datawhere=("a.status=1 and a.created_by in (select username from users where employee_id in (select id from employees where division_head='".$divhead."') )");
		$results = $this->Expense_model->GetListDataTransportRequest('',$datawhere);
		$controller			= ucfirst(strtolower('expense/transport_req_mgt'));
		$Arr_Akses			= getAcccesmenu($controller);
		if ($Arr_Akses['read'] != '1') {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}
		$data = array(
			'title'			=> 'Persetujuan Pengajuan Penggantian Transport',
			'action'		=> 'transport_req_mgt',
			'results'		=> $results,
			'status'		=> $this->status,
			'akses_menu'	=> $Arr_Akses
		);
		$this->load->view('Expense/transport_req_mgt_list',$data);
    }

	// list finance transport
    public function transport_req_fin() {
		$divhead="";
		$datauser = $this->db->get_where('users', ['username' => $this->session->userdata['User']['username']])->row();
		$divisionshead = $this->db->get_where('divisions_head', ['employee_id' => $datauser->employee_id])->row();
		if($divisionshead) $divhead=$divisionshead->id;
		$datawhere=("a.status=0 and a.created_by in (select username from users where employee_id in (select id from employees where division_head='".$divhead."') )");
		$datawhere='status=0';
		$results = $this->Expense_model->GetListDataTransportRequest('',$datawhere);
		$controller			= ucfirst(strtolower('expense/transport_req'));
		$Arr_Akses			= getAcccesmenu($controller);
		if ($Arr_Akses['read'] != '1') {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}
		$data = array(
			'title'			=> 'Persetujuan Pengajuan Penggantian Transport',
			'action'		=> 'transport_req_fin',
			'results'		=> $results,
			'status'		=> $this->status,
			'akses_menu'	=> $Arr_Akses
		);
		$this->load->view('Expense/transport_req_fin_list',$data);
    }

	// list pengajuan transport
    public function transport_req() {
		$results = $this->Expense_model->GetListDataTransportRequest($this->session->userdata['User']['username']);
		$controller			= ucfirst(strtolower('expense/transport_req'));
		$Arr_Akses			= getAcccesmenu($controller);
		if ($Arr_Akses['read'] != '1') {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}

		$data = array(
			'title'			=> 'Pengajuan Penggantian Transport',
			'action'		=> 'transport_req',
			'results'		=> $results,
			'status'		=> $this->status,
			'akses_menu'	=> $Arr_Akses
		);
		$this->load->view('Expense/transport_req_list',$data);
    }

	// transport pengajuan create
	public function transport_req_create(){
		$controller			= ucfirst(strtolower('expense/transport_req'));
		$Arr_Akses			= getAcccesmenu($controller);
		if ($Arr_Akses['read'] != '1') {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}

		$data = array(
			'title'			=> 'Pengajuan Penggantian Transport',
			'action'		=> 'transport_req',
			'status'		=> $this->status,
			'mod'			=> '',
			'akses_menu'	=> $Arr_Akses
		);
		$this->load->view('Expense/transport_req_form',$data);
	}

	// transport req save
	public function transport_req_save(){
        $id             = $this->input->post("id");
		$tgl_doc  		= $this->input->post("tgl_doc");
        $no_doc		    = $this->input->post("no_doc");
        $departement	= $this->input->post("departement");
        $nama			= $this->input->post("nama");
		$date1  		= $this->input->post("date1");
		$date2  		= $this->input->post("date2");
        $id_transport	= $this->input->post("id_transport");
        $jumlah_expense	= $this->input->post("jumlah_expense");
        $bank_id		= $this->input->post("bank_id");
        $accnumber		= $this->input->post("accnumber");
        $accname		= $this->input->post("accname");

		$this->db->trans_begin();
        if($id!="") {
			$data = array(
					'tgl_doc'=>$tgl_doc,
					'departement'=>$departement,
					'nama'=>$nama,
					'date1'=>$date1,
					'date2'=>$date2,
					'bank_id'=>$bank_id,
					'accnumber'=>$accnumber,
					'accname'=>$accname,
					'jumlah_expense'=>($jumlah_expense),
					'modified_by'=> $this->session->userdata['User']['username'],
					'modified_on'=>date("Y-m-d h:i:s")
				);
			$result=$this->All_model->dataUpdate(DBERP.'.tr_transport_req',$data,array('id'=>$id));
			$result=$this->All_model->dataUpdate(DBERP.'.tr_transport',array('no_req'=>'','status'=>'0'),array('no_req'=>$no_doc));
			if(!empty($id_transport)){
				foreach ($id_transport as $keys => $val){
					$result=$this->All_model->dataUpdate(DBERP.'.tr_transport',array('no_req'=>$no_doc,'status'=>'1'),array('id'=>$val));
				}
			}

			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
			} else {
				$this->db->trans_commit();
			}
        } else {
			$no_doc=$this->All_model->GetAutoGenerate('format_transport_req');
            $data =  array(
					'no_doc'=>$no_doc,
					'tgl_doc'=>$tgl_doc,
					'departement'=>$departement,
					'nama'=>$nama,
					'date1'=>$date1,
					'date2'=>$date2,
					'jumlah_expense'=>($jumlah_expense),
					'status'=>0,
					'bank_id'=>$bank_id,
					'accnumber'=>$accnumber,
					'accname'=>$accname,
					'created_by'=> $this->session->userdata['User']['username'],
					'created_on'=>date("Y-m-d h:i:s"),
				);
            $id = $this->All_model->dataSave(DBERP.'.tr_transport_req',$data);
			if(!empty($id_transport)){
				foreach ($id_transport as $keys => $val){
					$result=$this->All_model->dataUpdate(DBERP.'.tr_transport',array('no_req'=>$no_doc,'status'=>'1'),array('id'=>$val));
				}
			}
            if(is_numeric($id)) {
                $result         = TRUE;
            } else {
                $result = FALSE;
            }
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
			} else {
				$this->db->trans_commit();
			}
        }
        $param = array(
                'save' => $result, 'id'=>$id
                );
        echo json_encode($param);
	}

	// transport req edit	
	public function transport_req_edit($id,$mod=''){
		$results = $this->Expense_model->GetDataTransportReq($id);
		$data_detail = $this->Expense_model->GetDataTransportInReq($results->no_doc);
		$controller			= ucfirst(strtolower('expense/transport_req'));
		$Arr_Akses			= getAcccesmenu($controller);
		if ($Arr_Akses['read'] != '1') {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}
		$data = array(
			'title'			=> 'View Transportasi Request',
			'action'		=> 'transport_req',
			'stsview'		=> '',
			'data_detail'	=> $data_detail,
			'data'			=> $results,
			'mod'			=> $mod,
			'akses_menu'	=> $Arr_Akses
		);
		$this->load->view('Expense/transport_req_form',$data);

	}

	// transport req view	
	public function transport_req_view($id,$mod=''){
		$results = $this->Expense_model->GetDataTransportReq($id);
		$data_detail = $this->Expense_model->GetDataTransportInReq($results->no_doc);
		$controller			= ucfirst(strtolower('expense/transport_req'));
		$Arr_Akses			= getAcccesmenu($controller);
		if ($Arr_Akses['read'] != '1') {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}
		$data = array(
			'title'			=> 'View Transportasi Request',
			'action'		=> 'transport_req',
			'stsview'		=> 'view',
			'data_detail'	=> $data_detail,
			'data'			=> $results,
			'mod'			=> $mod,
			'akses_menu'	=> $Arr_Akses
		);
		$this->load->view('Expense/transport_req_form',$data);
	}

	// transport req print	
	public function transport_req_print($id){
		$results = $this->Expense_model->GetDataTransportReq($id);
		$data_detail = $this->Expense_model->GetDataTransportInReq($results->no_doc);
		$controller			= ucfirst(strtolower('expense/transport_req'));
		$Arr_Akses			= getAcccesmenu($controller);
		if ($Arr_Akses['read'] != '1') {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}
		$data = array(
			'title'			=> 'Print Transportasi Request',
			'action'		=> 'transport_req',
			'stsview'		=> 'print',
			'data_detail'	=> $data_detail,
			'data'			=> $results,
			'akses_menu'	=> $Arr_Akses
		);
		$this->load->view('Expense/transport_req_print',$data);
	}

	// list transport
    public function transport() {
		$results = $this->Expense_model->GetListDataTransport($this->session->userdata['User']['username']);
		$controller			= ucfirst(strtolower('expense/transport'));
		$Arr_Akses			= getAcccesmenu($controller);
		if ($Arr_Akses['read'] != '1') {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}

		$data = array(
			'title'			=> 'Transportasi',
			'action'		=> 'transport',
			'results'		=> $results,
			'status'		=> $this->status,
			'akses_menu'	=> $Arr_Akses
		);
		$this->load->view('Expense/transport_list',$data);
    }

	// transport create
	public function transport_create(){
		$controller			= ucfirst(strtolower('expense/transport'));
		$Arr_Akses			= getAcccesmenu($controller);
		if ($Arr_Akses['read'] != '1') {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}

		$data = array(
			'title'			=> 'Transportasi',
			'action'		=> 'transport',
			'akses_menu'	=> $Arr_Akses
		);
		$this->load->view('Expense/transport_form',$data);
	}

	// transport save
	public function transport_save(){
        $id             = $this->input->post("id");
		$tgl_doc  		= $this->input->post("tgl_doc");
        $no_doc		    = $this->input->post("no_doc");
        $departement	= $this->input->post("departement");
        $nama			= $this->input->post("nama");
        $keperluan		= $this->input->post("keperluan");
        $rute			= $this->input->post("rute");
        $nopol			= $this->input->post("nopol");
        $km_awal		= $this->input->post("km_awal");
        $km_akhir		= $this->input->post("km_akhir");
        $bensin			= $this->input->post("bensin");
        $tol			= $this->input->post("tol");
        $parkir			= $this->input->post("parkir");
        $filename		= $this->input->post("filename");
        $lainnya		= $this->input->post("lainnya");
        $keterangan		= $this->input->post("keterangan");

		$this->db->trans_begin();
		$config['upload_path'] = './assets/expense/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|pdf|doc|docx|jfif';
		$config['remove_spaces'] = TRUE;
		$config['encrypt_name'] = TRUE;
		$filenames=$filename;
		if(!empty($_FILES['doc_file']['name'])){
			$_FILES['file']['name'] = $_FILES['doc_file']['name'];
			$_FILES['file']['type'] = $_FILES['doc_file']['type'];
			$_FILES['file']['tmp_name'] = $_FILES['doc_file']['tmp_name'];
			$_FILES['file']['error'] = $_FILES['doc_file']['error'];
			$_FILES['file']['size'] = $_FILES['doc_file']['size'];
			$this->load->library('upload',$config);
			$this->upload->initialize($config);
			if($this->upload->do_upload('file')){
				$uploadData = $this->upload->data();
				$filenames = $uploadData['file_name'];
			}
		}
        if($id!="") {
			$data = array(
					'tgl_doc'=>$tgl_doc,
					'departement'=>$departement,
					'keperluan'=>$keperluan,
					'nama'=>$nama,
					'rute'=>$rute,
					'km_awal'=>$km_awal,
					'km_akhir'=>$km_akhir,
					'nopol'=>$nopol,
					'bensin'=>$bensin,
					'tol'=>$tol,
					'lainnya'=>$lainnya,
					'keterangan'=>$keterangan,
					'parkir'=>$parkir,
					'jumlah_kasbon'=>($bensin+$tol+$parkir+$lainnya),
					'doc_file'=>$filenames,
					'modified_by'=> $this->session->userdata['User']['username'],
					'modified_on'=>date("Y-m-d h:i:s")
				);
			$result=$this->All_model->dataUpdate(DBERP.'.tr_transport',$data,array('id'=>$id));
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
			} else {
				$this->db->trans_commit();
			}
        } else {
			$no_doc=$this->All_model->GetAutoGenerate('format_transport');
            $data =  array(
					'no_doc'=>$no_doc,
					'tgl_doc'=>$tgl_doc,
					'departement'=>$departement,
					'keperluan'=>$keperluan,
					'nama'=>$nama,
					'rute'=>$rute,
					'km_awal'=>$km_awal,
					'km_akhir'=>$km_akhir,
					'nopol'=>$nopol,
					'bensin'=>$bensin,
					'tol'=>$tol,
					'parkir'=>$parkir,
					'lainnya'=>$lainnya,
					'keterangan'=>$keterangan,
					'jumlah_kasbon'=>($bensin+$tol+$parkir+$lainnya),
					'doc_file'=>$filenames,
					'status'=>0,
					'created_by'=> $this->session->userdata['User']['username'],
					'created_on'=>date("Y-m-d h:i:s"),
				);
            $id = $this->All_model->dataSave(DBERP.'.tr_transport',$data);
            if(is_numeric($id)) {
                $result         = TRUE;
            } else {
                $result = FALSE;
            }
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
			} else {
				$this->db->trans_commit();
			}
        }
        $param = array(
                'save' => $result, 'id'=>$id
                );
        echo json_encode($param);
	}

	public function get_list_req_transport($nama,$departement,$date1,$date2){
		$data	= $this->db->query("SELECT * FROM ".DBERP.".tr_transport WHERE nama='".$nama."' and departement='".$departement."' and tgl_doc between '".$date1."' and '".$date2."' and (no_req ='' or no_req is null) order by tgl_doc")->result();
		echo json_encode($data);
		die();
	}
	public function get_transport($nama,$departement){
        $data = $this->All_model->GetOneTable(DBERP.'.tr_transport',array('nama'=>$nama,'departement'=>$departement,'status'=>'1'),'tgl_doc');
		echo json_encode($data);
		die();
	}

	// transport edit	
	public function transport_edit($id){
		$results = $this->Expense_model->GetDataTransport($id);
		$controller			= ucfirst(strtolower('expense/transport'));
		$Arr_Akses			= getAcccesmenu($controller);
		if ($Arr_Akses['read'] != '1') {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}
		$data = array(
			'title'			=> 'View Transportasi',
			'action'		=> 'transport',
			'stsview'		=> '',
			'data'			=> $results,			
			'akses_menu'	=> $Arr_Akses
		);
		$this->load->view('Expense/transport_form',$data);
	}

	// transport view
	public function transport_view($id){
		$results = $this->Expense_model->GetDataTransport($id);
		$controller			= ucfirst(strtolower('expense/transport'));
		$Arr_Akses			= getAcccesmenu($controller);
		if ($Arr_Akses['read'] != '1') {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}
		$data = array(
			'title'			=> 'View Transportasi',
			'action'		=> 'transport',
			'stsview'		=> 'view',
			'data'			=> $results,			
			'akses_menu'	=> $Arr_Akses
		);
		$this->load->view('Expense/transport_form',$data);
	}

	// transport fin approve
	public function transport_req_approve($id='',$status){
		$result=false;
        if($id!="") {
			$data = array(
						'id'=>$id,
						'status'=>$status,
					);
			if($status==1){
				$data['fin_check_by']=$this->session->userdata['User']['username'];
				$data['fin_check_on']=date("Y-m-d h:i:s");
			}
			if($status==2){
				$data['management_by']=$this->session->userdata['User']['username'];
				$data['management_on']=date("Y-m-d h:i:s");
			}
			$result=$this->All_model->dataUpdate(DBERP.'.tr_transport_req',$data,array('id'=>$id));
        }else{
			$result=false;
			$id=0;
		}
        $param = array(
                'save' => $result, 'id'=>$id
                );
        echo json_encode($param);
	}

	// transport approve
	public function transport_approve($id=''){
		$result=false;
        if($id!="") {
			$data = array(
					'id'=>$id,
					'status'=>1,
				);
			$result=$this->All_model->dataUpdate(DBERP.'.tr_transport',$data,array('id'=>$id));
        }
        $param = array(
                'save' => $result, 'id'=>$id
                );
        echo json_encode($param);
	}

	// transport delete
	public function transport_delete($id){
		$this->db->trans_begin();
        $result=$this->All_model->dataDelete(DBERP.'.tr_transport',array('id'=>$id));
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
        $param = array( 'delete' => $result );
        echo json_encode($param);
	}

	// transport delete
	public function transport_req_delete($id){
		$this->db->trans_begin();
		$data = $this->Expense_model->GetDataTransportReq($id);
		$this->All_model->dataUpdate(DBERP.'.tr_transport',array('status'=>0,'no_req'=>''),array('no_req'=>$data->no_doc));
        $result=$this->All_model->dataDelete(DBERP.'.tr_transport_req',array('id'=>$id));
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
        $param = array( 'delete' => $result );
        echo json_encode($param);
	}

	// list kasbon
    public function kasbon() {
		$where=array('a.nama'=>$this->session->userdata['User']['username']);
		$results = $this->Expense_model->GetListDataKasbon($where);
		$controller			= ucfirst(strtolower('expense/kasbon'));
		$Arr_Akses			= getAcccesmenu($controller);
		if ($Arr_Akses['read'] != '1') {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}

		$data = array(
			'title'			=> 'Kasbon',
			'action'		=> 'kasbon',
			'results'		=> $results,
			'status'		=> $this->status,
			'akses_menu'	=> $Arr_Akses
		);
		$this->load->view('Expense/kasbon_list',$data);
    }

	// list kasbon approval
    public function kasbon_fin() {
		$divhead="";
		$datawhere="";
		$datauser = $this->db->get_where('users', ['username' => $this->session->userdata['User']['username']])->row();
		$divisionshead = $this->db->get_where('divisions_head', ['employee_id' => $datauser->employee_id])->row();
		if($divisionshead) $divhead=$divisionshead->id;
//		$datawhere=("a.status=0 and a.created_by in (select username from users where employee_id in (select id from employees where division_head='".$divhead."') )");
//		$datawhere=("a.status=0 and a.created_by in ('".$this->session->userdata['User']['username']."') ");
		$datawhere=("a.status=0");
		$results = $this->Expense_model->GetListDataKasbon($datawhere);
		$controller			= ucfirst(strtolower('expense/kasbon_fin'));
		$Arr_Akses			= getAcccesmenu($controller);
		if ($Arr_Akses['read'] != '1') {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}

		$data = array(
			'title'			=> 'Persetujuan Kasbon',
			'action'		=> 'kasbon_fin',
			'results'		=> $results,
			'status'		=> $this->status,
			'akses_menu'	=> $Arr_Akses
		);
		$this->load->view('Expense/kasbon_list_fin',$data);

    }

	// kasbon create
	public function kasbon_create(){
		$controller			= ucfirst(strtolower('expense/kasbon'));
		$Arr_Akses			= getAcccesmenu($controller);
		if ($Arr_Akses['read'] != '1') {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}

		$data = array(
			'title'			=> 'Kasbon Form',
			'action'		=> 'kasbon',
			'mod'	=> '',
			'akses_menu'	=> $Arr_Akses
		);
		$this->load->view('Expense/kasbon_form',$data);
	}

	// kasbon save
	public function kasbon_save(){
        $id             = $this->input->post("id");
		$tgl_doc  		= $this->input->post("tgl_doc");
        $no_doc		    = $this->input->post("no_doc");
        $departement	= $this->input->post("departement");
        $nama			= $this->input->post("nama");
        $keperluan		= $this->input->post("keperluan");
        $jumlah_kasbon	= $this->input->post("jumlah_kasbon");
        $filename		= $this->input->post("filename");
        $bank_id		= $this->input->post("bank_id");
        $accnumber		= $this->input->post("accnumber");
        $accname		= $this->input->post("accname");
        $filename2		= $this->input->post("filename2");

		$this->db->trans_begin();
		$config['upload_path'] = './assets/expense/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|pdf|doc|docx|jfif';
		$config['remove_spaces'] = TRUE;
		$config['encrypt_name'] = TRUE;
		$filenames=$filename;
		if(!empty($_FILES['doc_file']['name'])){
			$_FILES['file']['name'] = $_FILES['doc_file']['name'];
			$_FILES['file']['type'] = $_FILES['doc_file']['type'];
			$_FILES['file']['tmp_name'] = $_FILES['doc_file']['tmp_name'];
			$_FILES['file']['error'] = $_FILES['doc_file']['error'];
			$_FILES['file']['size'] = $_FILES['doc_file']['size'];
			$this->load->library('upload',$config); 					
			$this->upload->initialize($config);
			if($this->upload->do_upload('file')){
				$uploadData = $this->upload->data();
				$filenames = $uploadData['file_name'];
			}
		}
		$filenames2=$filename2;
		if(!empty($_FILES['doc_file_2']['name'])){
			$_FILES['file']['name'] = $_FILES['doc_file_2']['name'];
			$_FILES['file']['type'] = $_FILES['doc_file_2']['type'];
			$_FILES['file']['tmp_name'] = $_FILES['doc_file_2']['tmp_name'];
			$_FILES['file']['error'] = $_FILES['doc_file_2']['error'];
			$_FILES['file']['size'] = $_FILES['doc_file_2']['size'];
			$this->load->library('upload',$config); 					
			$this->upload->initialize($config);
			if($this->upload->do_upload('file')){
				$uploadData2 = $this->upload->data();
				$filenames2 = $uploadData2['file_name'];
			}
		}
        if($id!="") {
			$data = array(
					'tgl_doc'=>$tgl_doc,
					'departement'=>$departement,
					'keperluan'=>$keperluan,
					'nama'=>$nama,
					'jumlah_kasbon'=>$jumlah_kasbon,
					'doc_file'=>$filenames,
					'doc_file_2'=>$filenames2,
					'bank_id'=>$bank_id,
					'accnumber'=>$accnumber,
					'accname'=>$accname,
					'modified_by'=> $this->session->userdata['User']['username'],
					'modified_on'=>date("Y-m-d h:i:s"),
				);
			$result=$this->All_model->dataUpdate(DBERP.'.tr_kasbon',$data,array('id'=>$id));
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
			} else {
				$this->db->trans_commit();
			}
        } else {
			$rec = $this->db->query("select no_perkiraan from ".DBACC.".master_oto_jurnal_detail where kode_master_jurnal='BUK030' and menu='kasbon'")->row();
			$no_doc=$this->All_model->GetAutoGenerate('format_kasbon');
            $data =  array(
						'no_doc'=>$no_doc,
						'tgl_doc'=>$tgl_doc,
						'departement'=>$departement,
						'keperluan'=>$keperluan,
						'nama'=>$nama,
						'jumlah_kasbon'=>$jumlah_kasbon,
						'doc_file'=>$filenames,
						'coa'=>$rec->no_perkiraan,
						'status'=>0,
						'doc_file_2'=>$filenames2,
						'bank_id'=>$bank_id,
						'accnumber'=>$accnumber,
						'accname'=>$accname,
						'created_by'=> $this->session->userdata['User']['username'],
						'created_on'=>date("Y-m-d h:i:s"),
					);
            $id = $this->All_model->dataSave(DBERP.'.tr_kasbon',$data);
            if(is_numeric($id)) {
                $result         = TRUE;
            } else {
                $result = FALSE;
            }
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
			} else {
				$this->db->trans_commit();
			}
        }
        $param = array(
                'save' => $result, 'id'=>$id
                );
        echo json_encode($param);
	}

	public function get_kasbon($nama="",$departement="",$no_doc=""){
        //$data = $this->All_model->GetOneTable(DBERP.'.tr_kasbon',array('nama'=>$nama,'departement'=>$departement,'status'=>'2'),'tgl_doc');
		$data = $this->db->query("select * from ".DBERP.".tr_kasbon where nama='".$nama."' and departement='".$departement."' and status=2 and no_doc not in (select id_kasbon from ".DBERP.".tr_expense_detail ".($no_doc!=""?" where no_doc!='".$no_doc."'":"").") order by tgl_doc")->result();
		echo json_encode($data);
		die();
	}

	// kasbon edit	
	public function kasbon_edit($id,$mod=''){
		$controller			= ucfirst(strtolower('expense/kasbon'));
		$Arr_Akses			= getAcccesmenu($controller);
		if ($Arr_Akses['update'] != '1') {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}

		$result = $this->Expense_model->GetDataKasbon($id);
		$data = array(
			'title' => 'Kasbon Form',
			'action' => 'kasbon',
			'data' => $result,
			'status' => $this->status,
			'stsview'=>'',
			'mod' => $mod,
			'akses_menu' => $Arr_Akses
		);
		$this->load->view('Expense/kasbon_form',$data);
	}

	// kasbon view
	public function kasbon_view($id,$mod=''){
		$controller			= ucfirst(strtolower('expense/kasbon'));
		$Arr_Akses			= getAcccesmenu($controller);
		if ($Arr_Akses['read'] != '1') {
			$this->session->set_flashdata("alert_data", "<div class=\"alert alert-warning\" id=\"flash-message\">You Don't Have Right To Access This Page, Please Contact Your Administrator....</div>");
			redirect(site_url('dashboard'));
		}

		$result = $this->Expense_model->GetDataKasbon($id);
		$data = array(
			'title' => 'Kasbon Form',
			'action' => 'kasbon',
			'data'	=> $result,
			'status' => $this->status,
			'stsview' => 'view',
			'mod' => $mod,
			'akses_menu' => $Arr_Akses
		);
		$this->load->view('Expense/kasbon_form',$data);
	}

	// kasbon approve
	public function kasbon_approve($id='',$mod=''){
		$result=false;
        if($id!="") {
			$data = array(
						'id'=>$id,
						'status'=>1,
					);
			$result=$this->All_model->dataUpdate(DBERP.'.tr_kasbon',$data,array('id'=>$id));
        }
        $param = array(
                'save' => $result, 'id'=>$id
                );
        echo json_encode($param);
	}

	// kasbon delete
	public function kasbon_delete($id){
        $result=$this->All_model->dataDelete(DBERP.'.tr_kasbon',array('id'=>$id));
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
        $param = array( 'delete' => $result );
        echo json_encode($param);
	}
}
