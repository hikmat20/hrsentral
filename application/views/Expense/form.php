<?php
$action='';
$this->load->view('include/side_menu');

$gambar='';
$dept='';$app='';$bank_id='';$accnumber='';$accname='';
if(!isset($data->departement)){
		$data_user = $this->db->get_where('users', ['username' => $this->session->userdata['User']['username']])->row();
		$data_employee = $this->db->get_where('employees', ['id' => $data_user->employee_id])->row();
		$dept=$data_employee->department_id;$bank_id=$data_employee->bank_id;$accnumber=$data_employee->accnumber;$accname=$data_employee->accname;
		$data_head = $this->db->get_where('divisions_head', ['id' => $data_employee->division_head])->row();
		$app=$data_head->employee_id;
}
?>
<?=form_open($this->uri->uri_string(),array('id'=>'frm_data','name'=>'frm_data','role'=>'form','class'=>'form-horizontal','enctype'=>'multipart/form-data'));?>
<input type="hidden" id="id" name="id" value="<?php echo set_value('id', isset($data->id) ? $data->id : ''); ?>">
<input type="hidden" id="departement" name="departement" value="<?php echo (isset($data->departement) ? $data->departement: $dept); ?>">
<input type="hidden" id="nama" name="nama" value="<?php echo (isset($data->nama) ? $data->nama: $this->session->userdata['User']['username'] ); ?>">
<input type="hidden" id="approval" name="approval" value="<?php echo (isset($data->approval) ? $data->approval: $app ); ?>">
<style>
@media screen and (max-width: 520px) {
	table {
		width: 100%;
	}
	thead th.column-primary {
		width: 100%;
	}

	thead th:not(.column-primary) {
		display:none;
	}
	
	th[scope="row"] {
		vertical-align: top;
	}
	
	td {
		display: block;
		width: auto;
		text-align: right;
	}
	thead th::before {
		text-transform: uppercase;
		font-weight: bold;
		content: attr(data-header);
	}
	thead th:first-child span {
		display: none;
	}
	td::before {
		float: left;
		text-transform: uppercase;
		font-weight: bold;
		content: attr(data-header);
	}
}

</style>
<div class="tab-content">
	<div class="tab-pane active">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?= $title; ?></h3>
			</div>
			<div class="box-body">
				<div class="form-group ">
					<label class="col-sm-2 col-md-2 control-label">No Dokumen</label>
					<div class="col-sm-2">
						<input type="text" class="form-control" id="no_doc" name="no_doc" value="<?php echo (isset($data->no_doc) ? $data->no_doc: ""); ?>" placeholder="Automatic" readonly>
					</div>
					<label class="col-sm-2 col-md-1 control-label">Tanggal<b class="text-red">*</b></label>
					<div class="col-sm-2">
						<input type="text" class="form-control tanggal" id="tgl_doc" name="tgl_doc" value="<?php echo (isset($data->tgl_doc) ? $data->tgl_doc: date("Y-m-d")); ?>" placeholder="Tanggal Dokumen" required>
					</div>
					<label class="col-sm-2 col-md-1 control-label">Keterangan</label>
					<div class="col-sm-2 col-md-4">
						<input type="text" class="form-control" id="informasi" name="informasi" value="<?php echo (isset($data->informasi) ? $data->informasi: ""); ?>" placeholder="informasi">
					</div>
				</div>
				<h4>Transfer ke</h4>
				<div class="form-group ">
					<label class="col-md-1 control-label">Bank</label>
					<div class="col-md-2">
						<input type="text" class="form-control" id="bank_id" name="bank_id" value="<?php echo (isset($data->bank_id) ? $data->bank_id: $bank_id); ?>" placeholder="Bank">
					</div>
					<label class="col-md-2 control-label">Nomor Rekening</label>
					<div class="col-md-2">
						<input type="text" class="form-control" id="accnumber" name="accnumber" value="<?php echo (isset($data->accnumber) ? $data->accnumber: $accnumber); ?>" placeholder="Nomor Rekening">
					</div>
					<label class="col-md-2 control-label">Nama Rekening</label>
					<div class="col-md-3">
						<input type="text" class="form-control" id="accname" name="accname" value="<?php echo (isset($data->accname) ? $data->accname: $accname); ?>" placeholder="Nama Pemilik Rekening">
					</div>
				</div>
			</div>
			<div class="table-responsive">
			<table class="table table-bordered table-striped" width="100%">
				<thead>
					<tr>
					<th width="5" scope="col" class="column-primary">#</th>
					<th scope="col" width="250">Jenis dan<br /> Tanggal</th>
					<th scope="col" width="250">Barang / Jasa dan<br />Keterangan</th>
					<th scope="col" width=150 nowrap>Jumlah</th>
					<th scope="col" width=200 nowrap>Harga Satuan</th>
					<th scope="col" width="200">E x p e n s e</th>
					<th scope="col" width="200">K a s b o n</th>
					<th scope="col" width="50">Bon Bukti</th>
					<th scope="col" class="column-primary"><div class="pull-right">
						<a class="btn btn-info btn-xs stsview" href="javascript:void(0)" title="Kasbon" onclick="add_kasbon()" id="add-kasbon"><i class="fa fa-user"></i> Kasbon</a><br />
						<a class="btn btn-success btn-xs stsview" href="javascript:void(0)" title="Tambah" onclick="add_detail()" id="add-material"><i class="fa fa-plus"></i> Tambah</a></div></th>
					</tr>
				</thead>
				<tbody id="detail_body">
				<?php $total=0; $idd=1;$grand_total=0;$total_expense=0;$total_kasbon=0;
				if(!empty($data_detail)){
					foreach($data_detail AS $record){ 
					$tekskasbon="";
					if($record->id_kasbon!='') $tekskasbon=' readonly';?>
					<tr id='tr1_<?=$idd?>' class='delAll <?=($record->id_kasbon!=''?'kasbonrow':'')?>'>
						<td data-header="#">
						<input type='hidden' name='id_kasbon[]' id=id_kasbon_<?=$idd?>' value='<?=$record->id_kasbon;?>'>
						<input type="hidden" name="filename[]" id="filename_<?=$idd?>" value="<?=$record->doc_file;?>">
						<input type="hidden" name="detail_id[]" id="raw_id_<?=$idd?>" value="<?=$idd;?>"><?=$idd;?></td>
						<td data-header="Jenis & Tanggal">
						<?php
						if($tekskasbon=='') {
							echo form_dropdown('coa[]',$data_budget, (isset($record->coa)?$record->coa:''),array('id'=>'coa'.$idd,'required'=>'required','class'=>'form-control select2','style'=>'width:300px'));
						} else {
							echo '<input type="hidden" name="coa[]" id="coa'.$idd.'" value="'.$record->coa.'">';
						}
						?>
						<input type="text" class="form-control tanggal input-sm" name="tanggal[]" id="tanggal<?=$idd;?>" value="<?=$record->tanggal;?>" <?=$tekskasbon?> ></td>
						<td data-header="Barang / Jasa & Keterangan"><input type="text" class="form-control input-sm" name="deskripsi[]" id="deskripsi_<?=$idd;?>" value="<?=$record->deskripsi;?>" <?=$tekskasbon?> >
						<input type="text" class="form-control input-sm" name="keterangan[]" id="keterangan_<?=$idd;?>" value="<?=$record->keterangan;?>"></td>
						<td data-header="Qty"><input type="text" class="form-control divide input-sm" name="qty[]" id="qty_<?=$idd;?>" value="<?=$record->qty;?>" onblur="cektotal(<?=$idd;?>)" <?=$tekskasbon?> size="15"></td>
						<td data-header="Harga Satuan"><input type="text" class="form-control divide input-sm" name="harga[]" id="harga_<?=$idd;?>" value="<?=$record->harga;?>" onblur="cektotal(<?=$idd;?>)" <?=$tekskasbon?> ></td>
						<td data-header="Expense"><input type="text" class="form-control divide subtotal input-sm" name="expense[]" id="expense_<?=$idd;?>" value="<?=($record->expense);?>" tabindex="-1" readonly></td>
						<td data-header="Kasbon"><input type="text" class="form-control divide subkasbon input-sm" name="kasbon[]" id="kasbon_<?=$idd;?>" value="<?=($record->kasbon);?>" tabindex="-1" readonly></td>
						<td data-header="Bon Bukti" width="50">
							<div class="upload-btn-wrapper">
							  <!--<label for="doc_file<?=$idd?>" <?=($tekskasbon!=''?'class="hidden"':'')?> >Upload file</label>-->
							  <input type="file" name="doc_file_<?=$idd?>" id="doc_file<?=$idd?>" />
							</div>
						<span class="pull-right"><?=($record->doc_file!=''?'<a href="'.base_url('assets/expense/'.$record->doc_file).'" download target="_blank"><i class="fa fa-download"></i></a>':'')?></span>
						</td>
						<th scope="row" align='center'><button type='button' class='btn btn-danger btn-xs stsview' data-toggle='tooltip' onClick='delDetail(<?=$idd?>)' title='Hapus data'><i class='fa fa-close'></i> Hapus</button></th>
					</tr>
					<?php 
						if($record->doc_file!=''){
							 if(strpos($record->doc_file,'pdf',0)>1){
								$gambar.='<div class="col-md-12">
								<iframe src="'.base_url('assets/expense/'.$record->doc_file).'#toolbar=0&navpanes=0" title="PDF" style="width:600px; height:500px;" frameborder="0">
										 <a href="'.base_url('assets/expense/'.$record->doc_file).'">Download PDF</a>
								</iframe>
								<br />'.$record->no_doc.'</div>';
							 }else{
								$gambar.='<div class="col-md-4"><a href="'.base_url('assets/expense/'.$record->doc_file).'" target="_blank"><img src="'.base_url('assets/expense/'.$record->doc_file).'" class="img-responsive"></a><br />'.$record->no_doc.'</div>';
							 }
						}
						$total_expense=($total_expense+($record->expense));
						$total_kasbon=($total_kasbon+($record->kasbon));
						$idd++;
					}
					$grand_total=($grand_total+($total_expense-$total_kasbon));
				}?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="5" align=right>TOTAL</td>
						<td><input type="text" class="form-control divide input-sm" id="total_expense" name="total_expense" value="<?=$total_expense?>" placeholder="Total Expense" tabindex="-1" readonly></td>
						<td><input type="text" class="form-control divide input-sm" id="total_kasbon" name="total_kasbon" value="<?=$total_kasbon?>" placeholder="Total Kasbon" tabindex="-1" readonly></td>
						<td align=right colspan=2><div class="row"><div class="col-md-2">Saldo</div><div class="col-md-10"><input type="text" class="form-control divide input-sm" id="grand_total" name="grand_total" value="<?=$grand_total?>" placeholder="Grand Total" tabindex="-1" readonly></div></div></td>
					</tr>
				</tfoot>
			</table>
			</div>
			<div class="box-footer">
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<?php
						$urlback='';
						if(isset($data)){
							if($data->status==0){
								if($stsview=='approval'){
									$urlback='list_expense_approval';
									echo '<a class="btn btn-warning btn-sm" onclick="data_approve()"><i class="fa fa-save">&nbsp;</i>Approve</a>';
								}
							}
						}
						?>
						<button type="submit" name="save" class="btn btn-success btn-sm stsview" id="submit"><i class="fa fa-save">&nbsp;</i>Simpan</button>
						<a class="btn btn-default btn-sm" onclick="window.location=siteurl+'expense/<?=$urlback?>';return false;"><i class="fa fa-reply">&nbsp;</i>Batal</a>
					</div>
				</div>
				<div class="row">
				<?=$gambar?>
				</div>
			</div>
		</div>
	</div>
</div>
<?= form_close() ?>
<?php
$datacombocoa="";
foreach($data_budget as $keys=>$val){
	$datacombocoa.="<option value='".$keys."'>".$val."</option>";
}
?>
<?php $this->load->view('include/footer'); ?>
<script src="<?= base_url('assets/js/number-divider.min.js')?>"></script>
<script type="text/javascript">
	var url_save = siteurl+'expense/save/';
	var url_approve = siteurl+'expense/approve/';
	var nomor=<?=$idd?>;
	$('.divide').divide();
//	$('.select2').select2();
    $('#frm_data').on('submit', function(e){
        e.preventDefault();
		var errors="";
		if($("#coa").val()=="0") errors="Jenis Expense tidak boleh kosong";
		if($("#tgl_doc").val()=="") errors="Tanggal Transaksi tidak boleh kosong";
		if(errors==""){

		swal({
		  title: "Anda Yakin?",
		  text: "Data Akan Disimpan!",
		  type: "info",
		  showCancelButton: true,
		  confirmButtonText: "Ya, simpan!",
		  cancelButtonText: "Tidak!",
		  closeOnConfirm: false,
		  closeOnCancel: true
		},
		function(isConfirm){
		  if (isConfirm) {
			var formdata = new FormData($('#frm_data')[0]);
			$.ajax({
				url: url_save,
				dataType : "json",
				type: 'POST',
				data: formdata,
				processData	: false,
				contentType	: false,
				success: function(msg){
					if(msg['save']=='1'){
						swal({
							title: "Sukses!",
							text: "Data Berhasil Di Simpan",
							type: "success",
							timer: 1500,
							showConfirmButton: false
						});
						window.location=siteurl+'expense/<?=$urlback?>';
					} else {
						swal({
							title: "Gagal!",
							text: "Data Gagal Di Simpan",
							type: "error",
							timer: 1500,
							showConfirmButton: false
						});
					};
					console.log(msg);
				},
				error: function(msg){
					swal({
						title: "Gagal!",
						text: "Ajax Data Gagal Di Proses",
						type: "error",
						timer: 1500,
						showConfirmButton: false
					});
					console.log(msg);
				}
			});
		  }
		});

//			data_save();
		}else{
			swal(errors);
			return false;
		}
    });
	<?php if(isset($stsview)){
		if($stsview=='view'){
			?>
			$(".stsview").addClass("hidden");
			$("#frm_data :input").prop("disabled", true);
			<?
		}
		if($stsview=='approval'){
			?>
			$(".stsview").addClass("hidden");
			$("#frm_data :input").prop("disabled", true);
			<?
		}
	}?>
	$(function () {
		$(".tanggal").datepicker({
			dateFormat : "yy-mm-dd",
		});
	});

	function cektotal(id){
		var sqty = $("#qty_"+id).val();
		var pref = $("#harga_"+id).val();
		var subtotal = (parseFloat(sqty)*parseFloat(pref));
		$("#expense_"+id).val(subtotal);
		var sum = 0;
		$('.subtotal').each(function() {
			sum += Number($(this).val());
		});
		$("#total_expense").val(sum);
		var sumkasbon = 0;
		$('.subkasbon').each(function() {
			sumkasbon += Number($(this).val());
		});
		$("#total_kasbon").val(sumkasbon);
		$("#grand_total").val(Number(sum)-Number(sumkasbon));
	}
	function add_kasbon(){
		$('.kasbonrow').remove();
		var nama = $("#nama").val();
		var departement = $("#departement").val();		$.ajax({
			url: siteurl +'expense/get_kasbon/'+nama+'/'+departement+'/<?= (isset($data->no_doc) ? $data->no_doc: ""); ?>',
			cache: false,
			type: "POST",
			dataType: "json",
			success: function(data){
				var i;
				for(i=0; i<data.length; i++){
					var Rows	 = 	"<tr id='tr1_"+nomor+"' class='delAll kasbonrow'>";
						Rows	+= 		"<td data-header='#'><input type='hidden' name='id_kasbon[]' id='id_kasbon_"+nomor+"' value='"+data[i].no_doc+"'>";
						Rows	+=			"<input type='hidden' name='detail_id[]' id='raw_id_"+nomor+"' value='"+nomor+"'>";
						Rows	+= 		"<input type='hidden' name='filename[]' id='filename_"+nomor+"' value='"+data[i].doc_file+"'></td>";
						Rows	+= 		"<td data-header='Tanggal'>";
						Rows	+=			"<input type='text' class='form-control tanggal input-sm' name='tanggal[]' id='tanggal_"+nomor+"' tabindex='-1' readonly value='"+data[i].tgl_doc+"' />";
						Rows	+= 		"<input type='hidden' name='coa[]' id='coa_"+nomor+"' value='"+data[i].coa+"' />";
						Rows	+= 		"</td>";
						Rows	+= 		"<td data-header='Barang / Jasa & Keteranga'>";
						Rows	+=			"<input type='text' class='form-control input-sm' name='deskripsi[]' id='deskripsi_"+nomor+"' value='"+data[i].keperluan+"' tabindex='-1' readonly />";
						Rows	+=			"<input type='text' class='form-control input-sm' name='keterangan[]' id='keterangan_"+nomor+"' />";
						Rows	+= 		"</td>";
						Rows	+= 		"<td data-header='Qty'>";
						Rows	+=			"<input type='text' class='form-control divide input-sm' name='qty[]' value='0' id='qty_"+nomor+"' tabindex='-1' readonly />";
						Rows	+= 		"</td>";
						Rows	+= 		"<td data-header='Harga Satuan'>";
						Rows	+=			"<input type='text' class='form-control divide input-sm' name='harga[]' value='0' id='harga_"+nomor+"' tabindex='-1' readonly />";
						Rows	+= 		"</td>";
						Rows	+= 		"<td data-header='Expense'>";
						Rows	+=			"<input type='text' class='form-control divide input-sm subtotal hidden' name='expense[]' value='0' id='expense_"+nomor+"' tabindex='-1' readonly />";
						Rows	+= 		"</td>";
						Rows	+= 		"<td data-header='Kasbon'>";
						Rows	+=			"<input type='text' class='form-control divide input-sm subkasbon' name='kasbon[]' value='"+data[i].jumlah_kasbon+"' id='kasbon_"+nomor+"' tabindex='-1' readonly />";
						Rows	+= 		"</td>";
						Rows	+= 		"<td data-header='Bon Bukti'>";
						Rows	+=			"<input type='file'  name='doc_file_"+nomor+"' id='doc_file_"+nomor+"' class='hidden' />";
						Rows	+=		"<span class='pull-right'>";
						if(data[i].doc_file!=''){
							Rows	+=		"<a href='<?=base_url('assets/expense/')?>"+data[i].doc_file+"' download target='_blank'><i class='fa fa-download'></i></a></span>";
						}
						Rows	+= 		"</td>";
						Rows	+= 		"< th scope='row' align='center'>";
						Rows 	+=			"<button type='button' class='btn btn-danger btn-xs' data-toggle='tooltip' onClick='delDetail("+nomor+")' title='Hapus data'><i class='fa fa-close'></i> Hapus</button>";
						Rows	+= 		"</th>";
						Rows	+= 	"</tr>";
						nomor++;
					$('#detail_body').append(Rows);
					cektotal(nomor-1);
				}
				$(".divide").divide();
			},
			error: function() {
				swal({
					title				: "Error Message !",
					text				: 'Connection Time Out. Please try again..',
					type				: "warning",
					timer				: 3000,
					showCancelButton	: false,
					showConfirmButton	: false,
					allowOutsideClick	: false
				});
			}
		});
	}
	function add_detail(){
		var Rows	 = 	"<tr id='tr1_"+nomor+"' class='delAll'>";
			Rows	+= 		"<td data-header='#'><input type='hidden' name='id_kasbon[]' id='id_kasbon_"+nomor+"' value=''>";
			Rows	+=			"<input type='hidden' name='detail_id[]' id='raw_id_"+nomor+"' value='"+nomor+"'>";
			Rows	+= 		"<input type='hidden' name='filename[]' id='filename_"+nomor+"' value=''></td>";
			Rows	+= 		"<td data-header='Jenis & Tanggal'>";			
			Rows	+= 		"<select name='coa[]' id='coa_"+nomor+"' required='required' class='form-control select2' style='width:300px'><?=$datacombocoa?></select>";
			Rows	+=			"<input type='text' class='form-control tanggal input-sm' name='tanggal[]' id='tanggal_"+nomor+"' />";
			Rows	+= 		"</td>";
			Rows	+= 		"<td data-header='Barang / Jasa & Keterangan'>";
			Rows	+=			"<input type='text' class='form-control input-sm' name='deskripsi[]' id='deskripsi_"+nomor+"' />";
			Rows	+=			"<input type='text' class='form-control input-sm' name='keterangan[]' id='keterangan_"+nomor+"' />";
			Rows	+= 		"</td>";
			Rows	+= 		"<td data-header='Qty'>";
			Rows	+=			"<input type='text' class='form-control divide input-sm' name='qty[]' value='0' id='qty_"+nomor+"' onblur='cektotal("+nomor+")' />";
			Rows	+= 		"</td>";
			Rows	+= 		"<td data-header='Harga Satuan'>";
			Rows	+=			"<input type='text' class='form-control divide input-sm' name='harga[]' value='0' id='harga_"+nomor+"' onblur='cektotal("+nomor+")' />";
			Rows	+= 		"</td>";
			Rows	+= 		"<td data-header='Expense'>";
			Rows	+=			"<input type='text' class='form-control divide input-sm subtotal' name='expense[]' value='0' id='expense_"+nomor+"' tabindex='-1' readonly />";
			Rows	+= 		"</td>";
			Rows	+= 		"<td data-header='Kasbon'>";
			Rows	+=			"<input type='text' class='form-control divide input-sm subkasbon hidden' name='kasbon[]' value='0' id='kasbon_"+nomor+"' tabindex='-1' readonly />";
			Rows	+= 		"</td>";
			Rows	+= 		"<td data-header='Bon Bukti'>";
			Rows	+=			"<input type='file'  name='doc_file_"+nomor+"' id='doc_file_"+nomor+"' />";
			Rows	+= 		"</td>";
			Rows	+= 		"<th align='center' th scope='row'>";
			Rows 	+=			"<button type='button' class='btn btn-danger btn-xs' data-toggle='tooltip' onClick='delDetail("+nomor+")' title='Hapus data'><i class='fa fa-close'></i> Hapus</button>";
			Rows	+= 		"</th>";
			Rows	+= 	"</tr>";
			$("#tanggal_"+nomor).focus();
			nomor++;
		$('#detail_body').append(Rows);
		$(".tanggal").datepicker({
			dateFormat : "yy-mm-dd",
		});
		$(".divide").divide();
	}

	function delDetail(row){
		$('#tr1_'+row).remove();
		cektotal(row);
	}

	function data_approve(){
		swal({
		  title: "Anda Yakin?",
		  text: "Data Akan Disetujui!",
		  type: "info",
		  showCancelButton: true,
		  confirmButtonText: "Ya, setuju!",
		  cancelButtonText: "Tidak!",
		  closeOnConfirm: false,
		  closeOnCancel: true
		},
		function(isConfirm){
		  if (isConfirm) {
			id=$("#id").val();
			$.ajax({
				url: url_approve+id,
				dataType : "json",
				type: 'POST',
				success: function(msg){
					if(msg['save']=='1'){
						swal({
							title: "Sukses!",
							text: "Data Berhasil Di Setujui",
							type: "success",
							timer: 1500,
							showConfirmButton: false
						});
						window.location=siteurl+'expense/<?=$urlback?>';
					} else {
						swal({
							title: "Gagal!",
							text: "Data Gagal Di Setujui",
							type: "error",
							timer: 1500,
							showConfirmButton: false
						});
					};
					console.log(msg);
				},
				error: function(msg){
					swal({
						title: "Gagal!",
						text: "Ajax Data Gagal Di Proses",
						type: "error",
						timer: 1500,
						showConfirmButton: false
					});
					console.log(msg);
				}
			});
		  }
		});
	}
</script>
