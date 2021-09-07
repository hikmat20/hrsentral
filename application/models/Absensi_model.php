<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @author Harboens
 * @copyright Copyright (c) 2020
 *
 * This is model class for table "Absensi Model"
 */

class Absensi_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

   function GetListAbsensiJSON($postData=null,$userlist=''){
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
	 if($userlist!='') $sqluser=" and a.user_id='".$userlist."'";
     if($searchValue != '') {
        $searchQuery = " (a.user_id like '%".$searchValue."%' or d.name like '%".$searchValue."%' or a.waktu like '%".$searchValue."%' or b.employee_id like '%".$searchValue."%' or c.kode_2 like '%".$searchValue."%') ";
     }
	 $fields = "SELECT a.id, a.user_id, a.foto, a.waktu, a.latitude, a.longitude, a.flag_cuti, b.employee_id, c.kode_2, d.name ";
	 $sql = " FROM absensi_log a LEFT JOIN users b ON a.user_id = b.username LEFT JOIN (select kode_1,kode_2 from ms_generate where tipe='tipe_absen') c ON a.tipe = c.kode_1 
	 left join employees d on b.employee_id=d.id
	 where 1 ".(($searchQuery=="")? "" :" and ".$searchQuery)." ".$sqluser;
	 $records=$this->db->query("select count(*) as allcount ".$sql)->result();
	 $totalRecords = $records[0]->allcount;
	 $totalRecordwithFilter = $records[0]->allcount;
	 $records=$this->db->query($fields.$sql." order by ".$columnName." ".$columnSortOrder." limit ".$start." , ".$rowperpage)->result();
	 $data = array();
     foreach($records as $record ){
		 if($record->flag_cuti!=''){
			$detail='CUTI';
		 }else{
			$detail='<a class="btn btn-info btn-sm" href="javascript:void(0)" title="View Detail" onclick="view_data(\''.$record->name.'\',\''.$record->waktu.'\',\''.$record->foto.'\','.$record->latitude.','.$record->longitude.',\''.$record->kode_2.'\',\''.$record->employee_id.'\')"><i class="fa fa-search"></i></a>';
		 }
        $data[] = array( 
		   "id"=>$record->id,
		   "user_id"=>$record->employee_id,
           "employee_id"=>$record->name,
           "waktu"=>$record->waktu,
           "tipe"=>$record->kode_2,
           "foto"=>($record->foto!=''?'<img src="'.base_url('data_absen/'.$record->foto).'" width="100">':'<i class="fa fa-close text-red"></i>'),
           "lokasi"=>($record->latitude!=''?'<i class="fa fa-check text-blue" title="'.$record->latitude.'"></i>':'<i class="fa fa-close text-red"></i>'),
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
   function GetReportAbsensi($postData=null){
		$sqlwhere='';
		if($postData['company_id']!='0') $sqlwhere.=" and e.company_id='".$postData['company_id']."'";
		if($postData['division_id']!='0') $sqlwhere.=" and e.division_id='".$postData['division_id']."'";
		if($postData['department_id']!='0') $sqlwhere.=" and e.department_id='".$postData['department_id']."'";
		$sqlquery="SELECT a.id, a.user_id, a.waktu, a.jam_standar, a.tipe, b.employee_id, d.name, d.ndiv, d.ndept, d.ncomp, h.waktu as jam_pulang, h.jam_standar as standar_pulang FROM 
		absensi_log a
		JOIN users b ON a.user_id = b.username
		join 
		(select e.id,e.name,e.nik, f.name as ndiv, g.name as ndept, i.name as ncomp from employees e 
		left join divisions f on e.division_id=f.id 
		left join departments g on e.department_id=g.id
		left join companies i on e.company_id=i.id ".($sqlwhere==''?'':" where 1=1 ".$sqlwhere)." ) d on b.employee_id=d.id 
		left join (select user_id, waktu, jam_standar from absensi_log where tipe='4' and DATE_FORMAT(waktu, '%Y-%m-%d')>='".$postData['tgl_awal']."' and DATE_FORMAT(waktu, '%Y-%m-%d')<='".$postData['tgl_akhir']."') h
		on a.user_id=h.user_id and DATE_FORMAT(a.waktu, '%Y-%m-%d')=DATE_FORMAT(h.waktu, '%Y-%m-%d')
		where DATE_FORMAT(a.waktu, '%Y-%m-%d')>='".$postData['tgl_awal']."' and DATE_FORMAT(a.waktu, '%Y-%m-%d')<='".$postData['tgl_akhir']."' and (tipe='1' or flag_cuti='C')
		ORDER BY d.ndept, d.name asc,a.waktu desc";
//		echo $sqlquery;
		$query=$this->db->query($sqlquery);
		if($query->num_rows() != 0) {
			return $query->result();
		} else {
			return false;
		}
   }
}
