<?php
// 
// Created by Hikmat A. R
// =====================================

class Request_payment_model extends CI_Model
{
    /**
     * @var string  User Table Name
     */
    protected $table_name = 'request_payment';
    protected $key        = 'id';

    protected $created_field = 'created_on';
    protected $date_format = 'datetime';
    public function __construct()
    {
        parent::__construct();
    }

	// list data request
	public function GetListDataRequest(){
		$data	= $this->db->query("SELECT id as ids,no_doc,nama,tgl_doc,'Transportasi' as keperluan, 'transportasi' as tipe,jumlah_expense as jumlah,null as tanggal,no_doc as id, bank_id, accnumber, accname FROM ".DBERP.".tr_transport_req WHERE status=1
		union
		SELECT id as ids,no_doc,nama,tgl_doc,keperluan, 'kasbon' as tipe,jumlah_kasbon as jumlah,null as tanggal,no_doc as id, bank_id, accnumber, accname FROM ".DBERP.".tr_kasbon WHERE status=1
		union
		SELECT a.id as ids,a.no_doc,a.nama,a.tgl_doc,a.informasi as keperluan, 'expense' as tipe,a.jumlah,null as tanggal,a.no_doc as id, bank_id, accnumber, accname FROM ".DBERP.".tr_expense a left join ".DBACC.".coa_master as b on a.coa=b.no_perkiraan WHERE status=1
		")->result();
		return $data;
	}

	// list data payment
	public function GetListDataPayment($where='') {
		$data	= $this->db->query("SELECT * FROM ".DBERP.".request_payment WHERE ".$where." order by id desc")->result();
		return $data;
	}
	public function GetListDataJurnal() {
		$data	= $this->db->query("SELECT nomor,tanggal,tipe,no_reff,stspos,sum(kredit) as total FROM ".DBERP.".jurnal group by nomor order by nomor desc")->result();
		return $data;
	}

}
