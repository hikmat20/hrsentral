<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @author Harboens
 * @copyright Copyright (c) 2020
 *
 * This is model class for table "All Model"
 */

class All_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

	// save data
	public function dataSave($table,$data) {
		$this->db->insert($table, $data);
		$last_id = $this->db->insert_id();
		return $last_id;
    }

	// update data
	public function dataUpdate($table,$data,$where) {
		$this->db->update($table,$data,$where);
		return $this->db->affected_rows();
    }

	// delete data
	public function dataDelete($table,$where) {
		$this->db->delete($table,$where);
		return $this->db->affected_rows();
    }

	// Get one data
    public function GetOneData($table,$where) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($where);
		$query = $this->db->get();
		if($query->num_rows() != 0)		{
			return $query->row();
		}		else		{
			return false;
		}
    }

	// Get data table
    public function GetOneTable($table,$where,$orderby='') {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($where);
		if($orderby!='') $this->db->order_by($orderby, 'asc');
		$query = $this->db->get();
		if($query->num_rows() != 0)		{
			return $query->result();
		}		else		{
			return false;
		}
    }
	// list data material
	public function GetListMaterial($where=''){
		$this->db->select('a.*');
		$this->db->from('ms_material a');
		if($where!=''){
			$this->db->where($where);
		}
		$this->db->order_by('a.nama', 'asc');
		$query = $this->db->get();
		if($query->num_rows() != 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	function GetComboBudget($divisi='',$kategori='',$tahun='') {
		$aMenu	= array();
		$aMenu[0] = 'Select An Option';
		$this->db->select('a.no_perkiraan, a.nama');
		$this->db->from(DBACC.'.coa_master a');
		if($divisi!='') $this->db->where('b.divisi',$divisi);
		if($kategori!='') $this->db->where('b.kategori',$kategori);
		if($tahun=='') $tahun=date("Y");
		$this->db->where('b.tahun',$tahun);
		$this->db->join(DBERP.'.ms_budget b','a.no_perkiraan=b.coa');
		$this->db->order_by('a.no_perkiraan', 'asc');
		$query = $this->db->get();
		$results	= $query->result_array();
		if($results){
			foreach($results as $key=>$vals){
				$aMenu[$vals['no_perkiraan']]	= $vals['no_perkiraan'].' - '.$vals['nama'];
			}
		}
		return $aMenu;
	}

	function GetDataBudget($divisi='',$kategori='',$tahun='') {
		$aMenu	= array();
		$aMenu[0] = 'Select An Option';
		$this->db->select('a.no_perkiraan, a.nama');
		$this->db->from(DBACC.'.coa_master a');
		if($divisi!='') $this->db->where('b.divisi',$divisi);
		if($kategori!='') $this->db->where('b.kategori',$kategori);
		if($tahun=='') $tahun=date("Y");
		$this->db->where('b.tahun',$tahun);
		$this->db->join('ms_budget b','a.no_perkiraan=b.coa');
		$this->db->order_by('a.no_perkiraan', 'asc');
		$query = $this->db->get();
		if($query->num_rows() != 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	function GetCoaCombo($level='5'){
		$aMenu	= array();
		$aMenu[0] = 'Select An Option';
		$this->db->select('a.no_perkiraan, a.nama');
		$this->db->from(DBACC.'.coa_master a');
		$this->db->where('a.level',$level);
		$this->db->order_by('a.no_perkiraan', 'asc');
		$query = $this->db->get();
		$results	= $query->result_array();
		if($results){
			foreach($results as $key=>$vals){
				$aMenu[$vals['no_perkiraan']]	= $vals['no_perkiraan'].' - '.$vals['nama'];
			}
		}
		return $aMenu;
	}

	function GetTypePaymentCombo(){
		$aMenu	= array(''=>'Select An option','CASH'=>'CASH','GIRO'=>'GIRO','TRANSFER'=>'TRANSFER');
		return $aMenu;
	}

	function GetCoaComboCategory(){
		$aMenu		= array();
		$this->db->select('a.id_type, a.nama');
		$this->db->from('ms_inventory_type a');
		$this->db->order_by('a.nama', 'asc');
		$query = $this->db->get();
		$results	= $query->result_array();
		if($results){
			foreach($results as $key=>$vals){
				$aMenu[$vals['id_type']]	= $vals['nama'];
			}
		}
		return $aMenu;
	}
	function GetDivisiCombo(){
		$aCombo		= array();
		$this->db->select('a.id_divisi, a.nm_divisi');
		$this->db->from('divisi a');
		$this->db->order_by('a.nm_divisi', 'asc');
		$query = $this->db->get();
		$results	= $query->result_array();
		$aCombo[]	= '';
		if($results){
			foreach($results as $key=>$vals){
				$aCombo[$vals['id_divisi']]	= $vals['nm_divisi'];
			}
		}
		return $aCombo;
	}

	function GetDeptCombo($id=''){
		$aCombo		= array();
		$this->db->select('a.id, a.nm_dept');
		$this->db->from('department a');
		if($id!=''){
			$this->db->where('a.id',$id);
		}
		$this->db->where('a.company_id','COM003');
		$this->db->order_by('a.nm_dept', 'asc');
		$query = $this->db->get();
		$results	= $query->result_array();
		if($results){
			foreach($results as $key=>$vals){
				$aCombo[$vals['id']]	= $vals['nm_dept'];
			}
		}
		return $aCombo;
	}

	function GetCostCenterCombo($dept=''){
		$aCombo		= array();
		$this->db->select('a.id, a.cost_center');
		$this->db->from('department_center a');
		$this->db->where('a.company_id','COM003');
		if($dept!='') $this->db->where('a.id_dept',$dept);
		$this->db->order_by('a.cost_center', 'asc');
		$query = $this->db->get();
		$results	= $query->result_array();
		$aCombo[]	= '';
		if($results){
			foreach($results as $key=>$vals){
				$aCombo[$vals['id']]	= $vals['cost_center'];
			}
		}
		return $aCombo;
	}

	function GetCostCenter($dept){
		$this->db->select('a.id, a.cost_center');
		$this->db->from('department_center a');
		$this->db->where('a.company_id','COM003');
		$this->db->where('a.id_dept',$dept);
		$this->db->order_by('a.cost_center', 'asc');
		$query = $this->db->get();
		if($query->num_rows() != 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	function GetKursCombo(){
		$aCombo		= array();
		$this->db->select('a.kode, a.mata_uang');
		$this->db->from('mata_uang a');
		$this->db->order_by('a.kode', 'asc');
		$query = $this->db->get();
		$results	= $query->result_array();
		if($results){
			foreach($results as $key=>$vals){
				$aCombo[$vals['kode']]	= $vals['kode'].' - '.$vals['mata_uang'];
			}
		}
		return $aCombo;
	}

	function GetSatuanMaterial($idmaterial=""){
		$this->db->select('a.name_uom as nama');
		$this->db->from('master_uom a');
		if($idmaterial!=''){
			$this->db->where("a.name_uom IN (select name_uom from ms_material_konversi where id_material='".$idmaterial."')",NULL,FALSE);
		}
		$this->db->order_by('a.name_uom', 'asc');
		$query = $this->db->get();
		if($query->num_rows() != 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	function GetLokasiWhCombo(){
		$aCombo		= array();
		$this->db->select('a.loc_code, a.loc_name');
		$this->db->from('ms_location a');
		$this->db->order_by('a.loc_name', 'asc');
		$query = $this->db->get();
		$results	= $query->result_array();
		if($results){
			foreach($results as $key=>$vals){
				$aCombo[$vals['loc_code']]	= $vals['loc_code'].' - '.$vals['loc_name'];
			}
		}
		return $aCombo;
	}

	function GetWhCombo(){
		$aCombo		= array();
		$this->db->select('a.wh_code, a.wh_name');
		$this->db->from('ms_warehouse a');
		$this->db->order_by('a.wh_name', 'asc');
		$query = $this->db->get();
		$results	= $query->result_array();
		if($results){
			foreach($results as $key=>$vals){
				$aCombo[$vals['wh_code']]	= $vals['wh_code'].' - '.$vals['wh_name'];
			}
		}
		return $aCombo;
	}

	function GetWhMaterial(){
		$aCombo		= array();
		$this->db->select('a.id_material, a.nama');
		$this->db->from('ms_material a');
		$this->db->order_by('a.nama', 'asc');
		$query = $this->db->get();
		$results	= $query->result_array();
		if($results){
			foreach($results as $key=>$vals){
				$aCombo[$vals['id_material']]	= $vals['id_material'].' - '.$vals['nama'];
			}
		}
		return $aCombo;
	}

	function GetInventoryTypeCombo($where=''){
		$aCombo = array();
		$this->db->select('a.id_type, a.nama');
		$this->db->from('ms_inventory_type a');
		if($where!=''){
			$this->db->where($where);
		}
		$this->db->where('aktif','aktif',FALSE);
		$this->db->order_by('a.nama', 'asc');
		$query = $this->db->get();
		$results	= $query->result_array();
		if($results){
			foreach($results as $key=>$vals){
				$aCombo[$vals['id_type']]	= $vals['nama'];
			}
		}
		return $aCombo;
	}

	function GetAutoGenerate($tipe){
		$newcode='';
		$data=$this->GetOneData('ms_generate',array('tipe'=>$tipe));
		if($data!==false) {
			if(stripos($data->info,'YEAR',0)!==false){
				if($data->kode_2!=date("Y")) {
					$years=date("Y");
					$number=1;
					$newnumber=sprintf('%0'.$data->kode_3.'d', $number);
				}else{
					$years=$data->kode_2;
					$number=($data->kode_1+1);
					$newnumber=sprintf('%0'.$data->kode_3.'d', $number);
				}
				$newcode=str_ireplace('XXXX',$newnumber,$data->info);
				$newcode=str_ireplace('YEAR',$years,$newcode);
				$newdata=array('kode_1'=>$number,'kode_2'=>$years);
			}else{
				$number=($data->kode_1+1);
				$newnumber=sprintf('%0'.$data->kode_3.'d', $number);
				$newcode=str_ireplace('XXXX',$newnumber,$data->info);
				$newdata=array('kode_1'=>$number);
			}
			$this->dataUpdate('ms_generate',$newdata,array('tipe'=>$tipe));
			return $newcode;
		}else{
			return false;
		}
	}

	function GetSupplierCombo($ids=''){
		$aCombo		= array();
		$this->db->select('a.id_supplier, a.nm_supplier_office');
		$this->db->from('master_supplier a');
		if($ids!=''){
			$this->db->where('id_supplier',$ids);
		}
		$this->db->order_by('a.nm_supplier_office', 'asc');
		$query = $this->db->get();
		$results	= $query->result_array();
		if($results){
			foreach($results as $key=>$vals){
				$aCombo[$vals['id_supplier']]	= $vals['nm_supplier_office'];
			}
		}
		return $aCombo;
	}

	public function GetMaterialStockList($where=''){
		$this->db->select('a.*, b.stock, (a.spec13-b.stock) as material_qty, c.nama_satuan satuan, d.element_cost as material_price_ref');
		$this->db->from('ms_material a');
		$this->db->join('ms_material_konversi c','a.id_material=c.id_material');
		$this->db->join('ms_price_ref_others d','a.id_material=d.element_id','left');
		$this->db->join('(select sum(stock)as stock ,id_material, satuan from ms_warehouse_stock group by id_material,satuan) b','a.id_material=b.id_material and b.satuan=c.nama_satuan','left');
		if($where!=''){
			$this->db->where($where);
		}
		$query = $this->db->get();
		if($query->num_rows() != 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function update_stock_in($data){
		$id_material=$data['material_id'];
		$qty_in=$data['material_qty'];
		$harga=$data['material_price'];
		$satuan=$data['material_unit'];
		$wh_code=$data['wh_code'];
		$code=$data['code'];
		$doc_no=$data['doc_no'];
		$tanggal=$data['tanggal'];
		$created_by=$data['created_by'];
		$created_on=$data['created_on'];
		$modified_by=$data['created_by'];
		$modified_on=$data['created_on'];

		//cek ms_warehouse_stock
		$where=array('id_material'=>$id_material,'wh_code'=>$wh_code,'satuan'=>$satuan);
		$data_stok=$this->GetOneData('ms_warehouse_stock',$where);
		if($data_stok!==false) {
			$harga_rata=((($data_stok->stock*$data_stok->harga)+($qty_in*$harga))/($data_stok->stock+$qty_in));
			$datatosave=array('stock'=>($data_stok->stock+$qty_in),'harga'=>$harga_rata,'modified_by'=>$modified_by,'modified_on'=>$modified_on);
			$this->dataUpdate('ms_warehouse_stock',$datatosave,$where);
		} else {
			$datatosave=array('stock'=>$qty_in,'harga'=>$harga,'id_material'=>$id_material,'wh_code'=>$wh_code,'satuan'=>$satuan,'created_by'=>$created_by,'created_on'=>$created_on);
			$this->dataSave('ms_warehouse_stock',$datatosave);
		}
		//cek ms_warehouse_stock_log
		$this->db->select('*');
		$this->db->from('ms_warehouse_stock_log');
		$this->db->where($where);
		$this->db->order_by('id', 'desc');
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() != 0)		{
			$data_stok=$query->row();
			$datatosave=array('stock_awal'=>$data_stok->stock_akhir,'stock_out'=>0,'stock_in'=>$qty_in,'stock_akhir'=>($data_stok->stock_akhir+$qty_in),'harga'=>$harga,'id_material'=>$id_material,'wh_code'=>$wh_code,'satuan'=>$satuan,'tanggal'=>$tanggal,'doc_no'=>$doc_no,'code'=>$code,'created_by'=>$created_by,'created_on'=>$created_on);
		} else {
			$datatosave=array('stock_awal'=>0,'stock_out'=>0,'stock_in'=>$qty_in,'stock_akhir'=>$qty_in,'harga'=>$harga,'id_material'=>$id_material,'wh_code'=>$wh_code,'satuan'=>$satuan,'tanggal'=>$tanggal,'doc_no'=>$doc_no,'code'=>$code,'created_by'=>$created_by,'created_on'=>$created_on);
		}
		$this->dataSave('ms_warehouse_stock_log',$datatosave);
	}

	function get_name($table, $field, $field_whare, $value){
		$query	= $this->db->query("SELECT $field FROM $table WHERE $field_whare='".$value."' LIMIT 1")->result();
		$data 	= (!empty($query))?$query[0]->$field:'-';
		return $data;
	}

	function warehouse_trans($data){
		// $data=array('id_material','wh_code','qty','tipe','tgl','harga','satuan','user',doc_no);
		// cek data stok di gudang
		$query	= $this->db->query("SELECT id,stock FROM ms_warehouse_stock WHERE id_material='".$data['id_material']."' and wh_code='".$data['wh_code']."'  LIMIT 1");
		$row = $query->row();
		$stock_qty=0;
		$qty_trans=$data['qty'];
		if($data['tipe']=='OUT') {
			$stock_in=0;
			$stock_out=$qty_trans;
			$qty_trans=($qty_trans*-1);
		}else{
			$stock_in=$qty_trans;
			$stock_out=0;
		}
		if (isset($row)) {
			$stock_qty=$row->stock;
			$this->dataUpdate('ms_warehouse_stock',array('stock'=>$stock_qty+$qty_trans,'modified_by'=>$data['user'],'modified_on'=>date("Y-m-d h:i:s")),array('id'=>$row->id));
		}else{
			$this->dataSave('ms_warehouse_stock',array('id_material'=>$data['id_material'],'wh_code'=>$data['wh_code'],'stock'=>$qty_trans,'created_by'=>$data['user'],'created_on'=>date("Y-m-d h:i:s")));
		}
		// stok log
		$this->dataSave('ms_warehouse_stock_log',array('id_material'=>$data['id_material'],'wh_code'=>$data['wh_code'],'stock_awal'=>$stock_qty,'stock_in'=>$stock_in,'stock_out'=>$stock_out,'stock_akhir'=>($stock_qty+$stock_in-$stock_out),'doc_no'=>$data['doc_no'],'created_by'=>$data['user'],'created_on'=>date("Y-m-d h:i:s")));
	}

	function Getcomboparamcoa($tipe){
		$aMenu	= array();
		$aMenu[0] = 'Select An Option';
		$this->db->select('a.no_perkiraan, a.nama');
		$this->db->from(DBACC.'.coa_master a');
		$this->db->join('ms_generate b','a.no_perkiraan=b.info');
		$this->db->where('b.tipe',$tipe);
		$this->db->order_by('a.no_perkiraan', 'asc');
		$query = $this->db->get();
		$results	= $query->result_array();
		if($results){
			foreach($results as $key=>$vals){
				$aMenu[$vals['no_perkiraan']]	= $vals['no_perkiraan'].' - '.$vals['nama'];
			}
		}
		return $aMenu;
	}
	function GetCategory(){
		$category=array(''=>'','EXPENSE'=>'EXPENSE','RUTIN'=>'RUTIN','NON RUTIN'=>'NON RUTIN','PEMBAYARAN PERIODIK'=>'PEMBAYARAN PERIODIK','UMUM'=>'UMUM');
		return $category;
	}
	function GetJenis(){
		$jenis=array(''=>'','VARIABLE'=>'VARIABLE','FIX COST BULANAN'=>'FIX COST BULANAN','FIX COST TAHUNAN'=>'FIX COST TAHUNAN');
		return $jenis;
	}

	function GetBudgetComboCategory($kategori,$tahun,$divisi){
		$aMenu		= array();
		$this->db->select('a.coa, b.no_perkiraan , b.nama as nama_perkiraan, c.nm_dept');
		$this->db->from('ms_budget a');
		$this->db->join(DBACC.'.coa_master b','a.coa=b.no_perkiraan');
		$this->db->join('department c','a.divisi=c.id','left');
		$this->db->where("a.kategori",$kategori);
		$this->db->where("a.tahun",$tahun);
		$this->db->where("a.divisi",$divisi);
		$this->db->where("b.level='5'");
		$this->db->order_by('b.no_perkiraan', 'asc');
		$query = $this->db->get();
		$results	= $query->result_array();
		if($results){
			foreach($results as $key=>$vals){
				$aMenu[$vals['coa']]	= $vals['coa'].' - '.$vals['nama_perkiraan'];
			}
		}
		return $aMenu;
	}

	public function get_coa_payment($modul='',$no_doc='')
	{
		$this->db->select('a.*');
		$this->db->from('tr_coa_payment a');
		$this->db->where('a.modul',$modul);
		$this->db->where('a.no_doc',$no_doc);
		$this->db->order_by('a.id', 'asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function insert_to_inventory_stock_price($data){
		$tanggal=$data['tanggal'];
		$id_product=$data['id_product'];
		$status=$data['status'];
		$harga=$data['harga'];
		$qty=$data['qty'];
		$total=$data['total'];
		$id_jendela=$data['id_jendela'];
		$no_quotation=$data['no_quotation'];
		$tipe=$data['tipe'];
		$created_by=$data['created_by'];
		$created_on=$data['created_on'];

		$datatosave=array('tanggal'=>$tanggal,'id_product'=>$id_product,'status'=>$status,'harga'=>$harga,'qty'=>$qty,
		'total'=>$total, 'id_jendela'=>$id_jendela, 'no_quotation'=>$no_quotation, 'tipe'=>$tipe,
		'created_by'=>$created_by,'created_on'=>$created_on);
		$this->dataSave('inventory_stock_price',$datatosave);
	}

	public function get_detail_data_quotation($where)
	{
		$this->db->select('a.*');
		$this->db->from('view_detail_data_quotation a');
		$this->db->where($where);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}

	function GetUserCombo(){
		$aCombo		= array();
		$this->db->select('a.id_user, a.nm_lengkap');
		$this->db->from('users a');
		$this->db->order_by('a.nm_lengkap', 'asc');
		$query = $this->db->get();
		$results	= $query->result_array();
		if($results){
			foreach($results as $key=>$vals){
				$aCombo[$vals['id_user']]	= $vals['nm_lengkap'];
			}
		}
		return $aCombo;
	}

}


// $this->db->last_query();