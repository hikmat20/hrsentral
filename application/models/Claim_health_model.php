<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @author Harboens
 * @copyright Copyright (c) 2022
 *
 * This is model class for table "Claim Health Model"
 */

class Claim_health_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

   function GetListDataJSON($postData=null,$userlist=''){
     $response = array();
     $draw = $postData['draw'];
     $start = $postData['start'];
     $rowperpage = $postData['length']; // Rows display per page
     $columnIndex = $postData['order'][0]['column']; // Column index
     $columnName = $postData['columns'][$columnIndex]['data']; // Column name
     $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
     $searchValue = $postData['search']['value']; // Search value
     $searchQuery = "";
	 $sqluser="";
	 if($userlist!='') $sqluser=" and a.employee_id='".$userlist."'";
     if($searchValue != '') {
        $searchQuery = " (a.no_claim like '%".$searchValue."%' or nama_tertanggung like '%".$searchValue."%' or a.tgl_claim like '%".$searchValue."%' or a.jenis_claim like '%".$searchValue."%' or a.status like '%".$searchValue."%') ";
     }
	 $fields = "SELECT a.*, ifnull(d.name,b.name) nama_tertanggung ";
	 $sql = " FROM claim_health a
	 left join employees b on a.employee_id=b.id
	 left join family d on a.tertanggung=d.id and a.employee_id=d.employee_id
	 where 1 ".(($searchQuery=="")? "" :" and ".$searchQuery)." ".$sqluser;
	 $records=$this->db->query("select count(*) as allcount ".$sql)->result();
	 $totalRecords = $records[0]->allcount;
	 $totalRecordwithFilter = $records[0]->allcount;
	 $records=$this->db->query($fields.$sql." order by ".$columnName." ".$columnSortOrder." limit ".$start." , ".$rowperpage)->result();
	 $data = array();
     foreach($records as $record ){
		$detail='<a class="btn btn-warning  btn-xs" href="'.base_url('claim_health/view/'.$record->id).'" title="View"><i class="fa fa-eye"></i></a> ';
		if($record->status=='PENGAJUAN'){
			$detail.=' <a class="btn btn-success btn-xs" href="'.base_url('claim_health/edit/'.$record->id).'" title="Edit"><i class="fa fa-edit"></i></a> ';
			$detail.=' <a class="btn btn-danger btn-xs" href="'.base_url('claim_health/del/'.$record->id).'" title="Delete"><i class="fa fa-trash"></i></a> ';
		}
        $data[] = array( 
		   "no_claim"=>$record->no_claim,
		   "tgl_claim"=>$record->tgl_claim,
           "nama_tertanggung"=>$record->nama_tertanggung,
           "jenis_claim"=>$record->jenis_claim,
           "biaya_claim"=>number_format($record->biaya_claim),
           "status"=>$record->status,
           "detail"=>$detail,
        ); 
     }
     $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $data
     );
     return $response; 
   }

}
