<?=form_open($this->uri->uri_string(),array('id'=>'frm_data','name'=>'frm_data','role'=>'form','class'=>'form-horizontal'));?>
<input type="hidden" id="id" name="id" value="<?php echo set_value('id', isset($data->id) ? $data->id : ''); ?>">
<div class="tab-content">
	<div class="tab-pane active">
		<div class="box box-primary">
			<div class="box-body">
				<div class="form-group ">
					<label class="col-sm-2 control-label">No Purchase Request<b class="text-red">*</b></label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="no_pr" name="no_pr" value="<?php echo (isset($data->no_pr) ? $data->no_pr: ""); ?>" placeholder="Automatic" readonly>
					</div>
					<label class="col-sm-2 control-label">Tanggal Purchase Request<b class="text-red">*</b></label>
					<div class="col-sm-4">
						<input type="text" class="form-control tanggal" id="tgl_pr" name="tgl_pr" value="<?php echo (isset($data->trans_date) ? $data->tgl_pr: date("Y-m-d")); ?>" placeholder="Tanggal Purchase Request" required>
					</div>
				</div>
				<div class="form-group ">
					<label class="col-sm-2 control-label">Departement<b class="text-red">*</b></label>
					<div class="col-sm-4">
						<?php
						echo form_dropdown('departement',$data_departement, (isset($data->departement)?$data->departement:''),array('id'=>'departement','class'=>'form-control select2'));
						?>
					</div>
					<label for="coa" class="col-sm-2 control-label">COA<b class="text-red">*</b></label>
					<div class="col-sm-4">
						<?php
						echo form_dropdown('coa',$data_budget,  (isset($data->coa)?$data->coa:''),array('id'=>'coa','required'=>'required','class'=>'form-control select2','onblur'=>'cekbudget()'));
						?>
					</div>
				</div>
				<div class="form-group ">
					<label class="col-sm-2 control-label">Nilai Budget</label>
					<div class="col-sm-4">
						<input type="text" class="form-control divide" id="budget" name="budget" value="<?php echo (isset($data->budget) ? $data->budget: 0); ?>" placeholder="Budget" required readonly>
					</div>
					<label class="col-sm-2 control-label">Sisa Budget</label>
					<div class="col-sm-4">
						<input type="text" class="form-control divide" id="sisa_budget" name="sisa_budget" value="<?php echo (isset($data->sisa_budget) ? $data->sisa_budget: 0); ?>" placeholder="Grand Total" required readonly>
					</div>
				</div>
			</div>
			<div class="table-responsive">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
					<th width="5">#</th>
					<th>Nama Barang /Jasa</th>
					<th>Spesifikasi</th>
					<th>Qty</th>
					<th>Estimasi Harga Satuan</th>
					<th>Estimasi Harga</th>
					<th>Tanggal Dibutuhkan</th>
					<th>Keterangan</th>
					<th><div class="pull-right"><a class="btn btn-success btn-xs stsview" href="javascript:void(0)" title="Tambah" onclick="add_detail()" id="add-material"><i class="fa fa-plus"></i> Tambah</a></div></th>
					</tr>
				</thead>
				<tbody id="detail_body">
				<?php $total=0; $idd=1;
				if(!empty($data_detail)){
					foreach($data_detail AS $record){ ?>
					<tr id='tr1_<?=$idd?>' class='delAll'>
						<td><input type="hidden" name="detail_id[]" id="raw_id_<?=$idd?>" value="<?=$idd;?>"><?=$idd;?></td>
						<td><input type="text" class="form-control" name="deskripsi[]" id="deskripsi_<?=$idd;?>" value="<?=$record->deskripsi;?>"></td>
						<td><input type="text" class="form-control" name="spesifikasi[]" id="spesifikasi_<?=$idd;?>" value="<?=$record->spesifikasi;?>"></td>
						<td><input type="text" class="form-control divide" name="qty_pr[]" id="qty_pr_<?=$idd;?>" value="<?=$record->qty_pr;?>" onblur="cektotal(<?=$idd;?>)"></td>
						<td><input type="text" class="form-control divide" name="harga_pr[]" id="harga_pr_<?=$idd;?>" value="<?=$record->harga_pr;?>" onblur="cektotal(<?=$idd;?>)"></td>
						<td><input type="text" class="form-control divide subtotal" name="total_harga_pr[]" id="total_harga_pr_<?=$idd;?>" value="<?=($record->total_harga_pr);?>" tabindex="-1" readonly></td>
						<td><input type="text" class="form-control tanggal" name="tgl_dibutuhkan[]" id="tgl_dibutuhkan_<?=$idd;?>" value="<?=$record->tgl_dibutuhkan;?>"></td>
						<td><input type="text" class="form-control" name="keterangan[]" id="keterangan_<?=$idd;?>" value="<?=$record->keterangan;?>"></td>
						<td align='center'><button type='button' class='btn btn-danger btn-xs stsview' data-toggle='tooltip' onClick='delDetail(<?=$idd?>)' title='Hapus data'><i class='fa fa-close'></i> Hapus</button></td>
					</tr>
					<?php $total=($total+($record->total_harga_pr));
						$idd++;
					}
				}?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="5">TOTAL</td>
						<td><input type="text" class="form-control divide" id="total_pr" name="total_pr" value="<?=$total?>" placeholder="Grand Total" tabindex="-1" readonly></td>
					</tr>
				</tfoot>
			</table>
			</div>
			<div class="box-footer">
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<?php
						if(isset($data)){
							if($data->status==0){
								echo '<button type="button" name="Approve" class="btn btn-primary btn-sm stsview" id="approve" onclick="data_approve()"><i class="fa fa-save">&nbsp;</i>Approve</button>';
							}
						}
						?>
						<button type="submit" name="save" class="btn btn-success btn-sm stsview" id="submit"><i class="fa fa-save">&nbsp;</i>Simpan</button>
						<a class="btn btn-warning btn-sm" onclick="location.reload();return false;"><i class="fa fa-reply">&nbsp;</i>Batal</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?= form_close() ?>
<script src="<?= base_url('assets/js/number-divider.min.js')?>"></script>
<script type="text/javascript">
	var url_save = siteurl+'purchase_request/save/';
	var url_approve = siteurl+'purchase_request/approve/';
	var nomor=<?=$idd?>;
	$('.divide').divide();
	$('.select2').select2();
    $('#frm_data').on('submit', function(e){
        e.preventDefault();
		var errors="";
		if($("#coa").val()=="0") errors="COA tidak boleh kosong";
		if($("#tgl_pr").val()=="") errors="Tanggal Transaksi tidak boleh kosong";
/*
		var budget=$("#budget").val();
		var total=$("#total").val();
		if( (parseFloat(budget)-parseFloat(total)) < 0) {
			if($("#over_reason").val()=="") errors="Grand total melebihi budget. Alasan Over Budget harus diisi";
		}
*/
		if(errors==""){
			data_save();
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
	}?>
	function cekbudget(){
		var prdate=$("#tgl_pr").val();
		var iddepartemen=$("#departement").val();
		var idtype=$("#coa").val();
		$.ajax({
			url : siteurl+'purchase_request/cekbudget/', type : "POST", cache : false, dataType : "json",
			data: { departemen: iddepartemen, coa: idtype, tgl_pr: prdate },
			success : function(data){
				console.log(data);
				if(data!=''){
					$("#budget").val(data['budget']);
					$("#sisa_budget").val(data['sisa']);
				}else{
					$("#budget").val("0");
					$("#sisa_budget").val(0);
				}
			}
		});
	}

	$(function () {
		$(".tanggal").datepicker({
			todayHighlight: true,
			format : "yyyy-mm-dd",
			showInputs: true,
			autoclose:true
		});
	});

	function cektotal(id){
		var sqty = $("#qty_pr_"+id).val();
		var pref = $("#harga_pr_"+id).val();
		var subtotal = (parseFloat(sqty)*parseFloat(pref));
		$("#total_harga_pr_"+id).val(subtotal);
		var sum = 0;
		$('.subtotal').each(function() {
			sum += Number($(this).val());
		});
		$("#total_pr").val(sum);
	}

	function add_detail(){
		var Rows	 = 	"<tr id='tr1_"+nomor+"' class='delAll'>";
			Rows	+= 		"<td>";
			Rows	+=			"<input type='hidden' name='detail_id[]' id=raw_id_"+nomor+"' value=''>";
			Rows	+= 		"</td>";
			Rows	+= 		"<td>";
			Rows	+=			"<input type='text' class='form-control' name='deskripsi[]' id='deskripsi_"+nomor+"' />";
			Rows	+= 		"</td>";
			Rows	+= 		"<td>";
			Rows	+=			"<input type='text' class='form-control' name='spesifikasi[]' id='spesifikasi_"+nomor+"' />";
			Rows	+= 		"</td>";
			Rows	+= 		"<td>";
			Rows	+=			"<input type='text' class='form-control divide' name='qty_pr[]' value='0' id='qty_pr_"+nomor+"' onblur='cektotal("+nomor+")' />";
			Rows	+= 		"</td>";
			Rows	+= 		"<td>";
			Rows	+=			"<input type='text' class='form-control divide' name='harga_pr[]' value='0' id='harga_pr_"+nomor+"' onblur='cektotal("+nomor+")' />";
			Rows	+= 		"</td>";
			Rows	+= 		"<td>";
			Rows	+=			"<input type='text' class='form-control divide subtotal' name='total_harga_pr[]' value='0' id='total_harga_pr_"+nomor+"' tabindex='-1' readonly />";
			Rows	+= 		"</td>";
			Rows	+= 		"<td>";
			Rows	+=			"<input type='text' class='form-control tanggal' name='tgl_dibutuhkan[]' id='tgl_dibutuhkan_"+nomor+"' />";
			Rows	+= 		"</td>";
			Rows	+= 		"<td>";
			Rows	+=			"<input type='text' class='form-control' name='keterangan[]' id='keterangan_"+nomor+"' />";
			Rows	+= 		"</td>";
			Rows	+= 		"<td align='center'>";
			Rows 	+=			"<button type='button' class='btn btn-danger btn-xs' data-toggle='tooltip' onClick='delDetail("+nomor+")' title='Hapus data'><i class='fa fa-close'></i> Hapus</button>";
			Rows	+= 		"</td>";
			Rows	+= 	"</tr>";
			nomor++;
		$('#detail_body').append(Rows);
		$(".tanggal").datepicker({
			todayHighlight: true,
			format : "yyyy-mm-dd",
			showInputs: true,
			autoclose:true
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
						window.location.reload();
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
