<?php
$action='';
$this->load->view('include/side_menu');

$dept='';$app='';
if(!isset($data->departement)){
		$data_user = $this->db->get_where('users', ['username' => $this->session->userdata['User']['username']])->row();
		$data_employee = $this->db->get_where('employees', ['id' => $data_user->employee_id])->row();
		$data_head = $this->db->get_where('divisions_head', ['id' => $data_employee->division_head])->row();
		$app=$data_head->employee_id;
}
?>
<?=form_open($this->uri->uri_string(),array('id'=>'frm_data','name'=>'frm_data','role'=>'form','class'=>'form-horizontal','enctype'=>'multipart/form-data'));?>
<input type="hidden" id="id" name="id" value="<?php echo set_value('id', isset($data->id) ? $data->id : ''); ?>">
<input type="hidden" id="departement" name="departement" value="<?php echo (isset($data->departement) ? $data->departement: $dept); ?>">
<input type="hidden" id="nama" name="nama" value="<?php echo (isset($data->nama) ? $data->nama: $this->session->userdata['User']['username'] ); ?>">
<input type="hidden" id="approval" name="approval" value="<?php echo (isset($data->approval) ? $data->approval: $app ); ?>">

<div class="tab-content">
	<div class="tab-pane active">
		<div class="box box-primary">
			<div class="box-body">
				<div class="form-group ">
					<label class="col-sm-2 control-label">No Dokumen</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="no_doc" name="no_doc" value="<?php echo (isset($data->no_doc) ? $data->no_doc: ""); ?>" placeholder="Automatic" readonly>
					</div>
					<label class="col-sm-2 control-label">Tanggal <b class="text-red">*</b></label>
					<div class="col-sm-4">
						<input type="text" class="form-control tanggal" id="tgl_doc" name="tgl_doc" value="<?php echo (isset($data->tgl_doc) ? $data->tgl_doc: date("Y-m-d")); ?>" placeholder="Tanggal Dokumen" required>
					</div>
				</div>
				<div class="form-group ">
					<label for="coa" class="col-sm-2 control-label">Expense Report<b class="text-red">*</b></label>
					<div class="col-sm-4">
						<?php
						echo form_dropdown('coa',$data_budget,  (isset($data->coa)?$data->coa:''),array('id'=>'coa','required'=>'required','class'=>'form-control select2','onblur'=>'cekbudget()'));
						?>
					</div>
				</div>
			</div>
			<div class="table-responsive">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
					<th width="5">#</th>
					<th>Tanggal</th>
					<th>Keterangan</th>
					<th>Qty</th>
					<th>Harga Satuan</th>
					<th>Expense</th>
					<th>Kasbon</th>
					<th>Keterangan</th>
					<th width="50">Bon Bukti</th>
					<th><div class="pull-right">
						<a class="btn btn-info btn-xs stsview" href="javascript:void(0)" title="Kasbon" onclick="add_kasbon()" id="add-kasbon"><i class="fa fa-user"></i> Cek Kasbon</a>
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
						<td>
						<input type='hidden' name='id_kasbon[]' id=id_kasbon_<?=$idd?>' value='<?=$record->id_kasbon;?>'>
						<input type="hidden" name="filename[]" id="filename_<?=$idd?>" value="<?=$record->doc_file;?>">
						<input type="hidden" name="detail_id[]" id="raw_id_<?=$idd?>" value="<?=$idd;?>"><?=$idd;?></td>
						<td><input type="text" class="form-control tanggal" name="tanggal[]" id="tanggal<?=$idd;?>" value="<?=$record->tanggal;?>" <?=$tekskasbon?> ></td>
						<td><input type="text" class="form-control" name="deskripsi[]" id="deskripsi_<?=$idd;?>" value="<?=$record->deskripsi;?>" <?=$tekskasbon?> ></td>
						<td><input type="text" class="form-control divide" name="qty[]" id="qty_<?=$idd;?>" value="<?=$record->qty;?>" onblur="cektotal(<?=$idd;?>)" <?=$tekskasbon?> ></td>
						<td><input type="text" class="form-control divide" name="harga[]" id="harga_<?=$idd;?>" value="<?=$record->harga;?>" onblur="cektotal(<?=$idd;?>)" <?=$tekskasbon?> ></td>
						<td><input type="text" class="form-control divide subtotal" name="expense[]" id="expense_<?=$idd;?>" value="<?=($record->expense);?>" tabindex="-1" readonly></td>
						<td><input type="text" class="form-control divide subkasbon" name="kasbon[]" id="kasbon_<?=$idd;?>" value="<?=($record->kasbon);?>" tabindex="-1" readonly></td>
						<td><input type="text" class="form-control" name="keterangan[]" id="keterangan_<?=$idd;?>" value="<?=$record->keterangan;?>"></td>
						<td><input type="file" name="doc_file_<?=$idd?>" id="doc_file<?=$idd?>"  <?=($tekskasbon!=''?'class="hidden"':'')?> >
						<span class="pull-right"><?=($record->doc_file!=''?'<a href="'.base_url('assets/expense/'.$record->doc_file).'" download target="_blank"><i class="fa fa-download"></i></a>':'')?></span>
						</td>
						<td align='center'><button type='button' class='btn btn-danger btn-xs stsview' data-toggle='tooltip' onClick='delDetail(<?=$idd?>)' title='Hapus data'><i class='fa fa-close'></i> Hapus</button></td>
					</tr>
					<?php 
						$total_expense=($total_expense+($record->expense));
						$total_kasbon=($total_kasbon+($record->kasbon));
						$idd++;
					}
					$grand_total=($grand_total+($total_expense+$total_kasbon));
				}?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="5" align=right>TOTAL</td>
						<td><input type="text" class="form-control divide" id="total_expense" name="total_expense" value="<?=$total_expense?>" placeholder="Total Expense" tabindex="-1" readonly></td>
						<td><input type="text" class="form-control divide" id="total_kasbon" name="total_kasbon" value="<?=$total_kasbon?>" placeholder="Total Ksbon" tabindex="-1" readonly></td>
						<td align=right>Saldo</td>
						<td><input type="text" class="form-control divide" id="grand_total" name="grand_total" value="<?=$grand_total?>" placeholder="Grand Total" tabindex="-1" readonly></td>
						<td></td>
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
								if($data->approval==$this->auth->user_id()){
								echo '<button type="button" name="Approve" class="btn btn-primary btn-sm stsview" id="approve" onclick="data_approve()"><i class="fa fa-save">&nbsp;</i>Approve</button>';
								}
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
<?php $this->load->view('include/footer'); ?>
<script src="<?= base_url('assets/js/number-divider.min.js')?>"></script>
<script type="text/javascript">
	var url_save = siteurl+'expense/save/';
	var url_approve = siteurl+'expense/approve/';
	var nomor=<?=$idd?>;
	$('.divide').divide();
	$('.select2').select2();
    $('#frm_data').on('submit', function(e){
        e.preventDefault();
		var errors="";
		if($("#coa").val()=="0") errors="COA tidak boleh kosong";
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
						cancel();
						window.location.reload();
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
	}?>
	$(function () {
		$(".tanggal").datepicker({
			todayHighlight: true,
			format : "yyyy-mm-dd",
			showInputs: true,
			autoclose:true
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
		$("#grand_total").val(Number(sum)+Number(sumkasbon));
	}
	function add_kasbon(){
		$('.kasbonrow').remove();		
		var nama = $("#nama").val();
		var departement = $("#departement").val();
		$.ajax({
			url: siteurl +'expense/get_kasbon/'+nama+'/'+departement,
			cache: false,
			type: "POST",
			dataType: "json",
			success: function(data){
				var i;
				for(i=0; i<data.length; i++){
					var Rows	 = 	"<tr id='tr1_"+nomor+"' class='delAll kasbonrow'>";
						Rows	+= 		"<td><input type='hidden' name='id_kasbon[]' id='id_kasbon_"+nomor+"' value='"+data[i].no_doc+"'>";
						Rows	+=			"<input type='hidden' name='detail_id[]' id='raw_id_"+nomor+"' value='"+nomor+"'>";
						Rows	+= 		"<input type='hidden' name='filename[]' id='filename_"+nomor+"' value='"+data[i].doc_file+"'></td>";
						Rows	+= 		"<td>";
						Rows	+=			"<input type='text' class='form-control tanggal' name='tanggal[]' id='tanggal_"+nomor+"' tabindex='-1' readonly value='"+data[i].tgl_doc+"' />";
						Rows	+= 		"</td>";
						Rows	+= 		"<td>";
						Rows	+=			"<input type='text' class='form-control' name='deskripsi[]' id='deskripsi_"+nomor+"' value='"+data[i].keperluan+"' tabindex='-1' readonly />";
						Rows	+= 		"</td>";
						Rows	+= 		"<td>";
						Rows	+=			"<input type='text' class='form-control divide' name='qty[]' value='0' id='qty_"+nomor+"' tabindex='-1' readonly />";
						Rows	+= 		"</td>";
						Rows	+= 		"<td>";
						Rows	+=			"<input type='text' class='form-control divide' name='harga[]' value='0' id='harga_"+nomor+"' tabindex='-1' readonly />";
						Rows	+= 		"</td>";
						Rows	+= 		"<td>";
						Rows	+=			"<input type='text' class='form-control divide subtotal' name='expense[]' value='0' id='expense_"+nomor+"' tabindex='-1' readonly />";
						Rows	+= 		"</td>";
						Rows	+= 		"<td>";
						Rows	+=			"<input type='text' class='form-control divide subkasbon' name='kasbon[]' value='"+data[i].jumlah_kasbon+"' id='kasbon_"+nomor+"' tabindex='-1' readonly />";
						Rows	+= 		"</td>";
						Rows	+= 		"<td>";
						Rows	+=			"<input type='text' class='form-control' name='keterangan[]' id='keterangan_"+nomor+"' />";
						Rows	+= 		"</td>";
						Rows	+= 		"<td>";
						Rows	+=			"<input type='file'  name='doc_file_"+nomor+"' id='doc_file_"+nomor+"' class='hidden' />";
						Rows	+=		"<span class='pull-right'>";
						if(data[i].doc_file!=''){
							Rows	+=		"<a href='<?=base_url('assets/expense/')?>"+data[i].doc_file+"' download target='_blank'><i class='fa fa-download'></i></a></span>";
						}
						Rows	+= 		"</td>";
						Rows	+= 		"<td align='center'>";
						Rows 	+=			"<button type='button' class='btn btn-danger btn-xs' data-toggle='tooltip' onClick='delDetail("+nomor+")' title='Hapus data'><i class='fa fa-close'></i> Hapus</button>";
						Rows	+= 		"</td>";
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
			Rows	+= 		"<td><input type='hidden' name='id_kasbon[]' id='id_kasbon_"+nomor+"' value=''>";
			Rows	+=			"<input type='hidden' name='detail_id[]' id='raw_id_"+nomor+"' value='"+nomor+"'>";
			Rows	+= 		"<input type='hidden' name='filename[]' id='filename_"+nomor+"' value=''></td>";
			Rows	+= 		"<td>";
			Rows	+=			"<input type='text' class='form-control tanggal' name='tanggal[]' id='tanggal_"+nomor+"' />";
			Rows	+= 		"</td>";
			Rows	+= 		"<td>";
			Rows	+=			"<input type='text' class='form-control' name='deskripsi[]' id='deskripsi_"+nomor+"' />";
			Rows	+= 		"</td>";
			Rows	+= 		"<td>";
			Rows	+=			"<input type='text' class='form-control divide' name='qty[]' value='0' id='qty_"+nomor+"' onblur='cektotal("+nomor+")' />";
			Rows	+= 		"</td>";
			Rows	+= 		"<td>";
			Rows	+=			"<input type='text' class='form-control divide' name='harga[]' value='0' id='harga_"+nomor+"' onblur='cektotal("+nomor+")' />";
			Rows	+= 		"</td>";
			Rows	+= 		"<td>";
			Rows	+=			"<input type='text' class='form-control divide subtotal' name='expense[]' value='0' id='expense_"+nomor+"' tabindex='-1' readonly />";
			Rows	+= 		"</td>";
			Rows	+= 		"<td>";
			Rows	+=			"<input type='text' class='form-control divide subkasbon' name='kasbon[]' value='0' id='kasbon_"+nomor+"' tabindex='-1' readonly />";
			Rows	+= 		"</td>";
			Rows	+= 		"<td>";
			Rows	+=			"<input type='text' class='form-control' name='keterangan[]' id='keterangan_"+nomor+"' />";
			Rows	+= 		"</td>";
			Rows	+= 		"<td>";
			Rows	+=			"<input type='file'  name='doc_file_"+nomor+"' id='doc_file_"+nomor+"' />";
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
