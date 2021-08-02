<?= form_open($this->uri->uri_string(),array('id'=>'frm_data','name'=>'frm_data','role'=>'form','class'=>'form-horizontal')) ?>
<?php
$readonly=""; 
if (isset($data->id)) $readonly=" readonly"; ?>
<input type="hidden" id="id" name="id" value="<?php echo (isset($data->id) ? $data->id : ''); ?>">
<div class="tab-content">
	<div class="tab-pane active">
		<div class="box box-primary">
			<div class="box-body">
				<div class="form-group ">
					<label class="col-sm-2 control-label">Item Code</label>
					<div class="col-sm-4"><p class="form-control-static"><?php echo (isset($data->id_product) ? $data->id_product: ""); ?></p></div>
					<label class="col-sm-2 control-label">Collection</label>
					<div class="col-sm-4"><p class="form-control-static"><?php echo (isset($data->name_collection) ? $data->name_collection: ""); ?></p></div>
				</div>
				<div class="form-group ">
					<label class="col-sm-2 control-label">Warehouse</label>
					<div class="col-sm-4"><p class="form-control-static"><?php echo (isset($data->warehouse) ? $data->warehouse: ""); ?></p></div>
					<label class="col-sm-2 control-label">Location WH</label>
					<div class="col-sm-4"><p class="form-control-static"><?php echo (isset($data->location) ? $data->location: ""); ?></p></div>
				</div>
				<div class="form-group ">
					<label class="col-sm-2 control-label">Piece Code<b class="text-red">*</b></label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="piece_code" name="piece_code" value="<?php echo (isset($data->piece_code) ? $data->piece_code: ""); ?>" required <?php echo (($status=='A')?'':'readonly'); ?>>
					</div>
					<label class="col-sm-2 control-label">Shelf<b class="text-red">*</b></label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="shelf" name="shelf" value="<?php echo (isset($data->shelf) ? $data->shelf: ""); ?>" required>
					</div>
				</div>
				<div class="form-group ">
					<label class="col-sm-2 control-label">Lot No</label>
					<div class="col-sm-4"><p class="form-control-static"><?php echo (isset($data->lot) ? $data->lot: ""); ?></p></div>
					<label class="col-sm-2 control-label">Stock<b class="text-red">*</b></label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="length" name="length" value="<?php echo (isset($data->length) ? $data->length: "0"); ?>" required readonly tabindex="-1">
					</div>
				</div>
				<div class="form-group ">
					<label class="col-sm-2 control-label">Stock saat ini<b class="text-red">*</b></label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="aktual" name="aktual" value="<?php echo (isset($data->length) ? $data->length: "0"); ?>" required onblur="check_selisih()">
					</div>
					<label class="col-sm-2 control-label">Alasan selisih stock</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="alasan" name="alasan" value="<?php echo (isset($data->alasan) ? $data->alasan: ""); ?>">
					</div>
				</div>
				<div class="form-group ">
					<label class="col-sm-2 control-label">Selisih</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="selisih" name="selisih" value="<?php echo (isset($data->selisih) ? $data->selisih: "0"); ?>" readonly tabindex="-1">
					</div>
					<label class="col-sm-2 control-label">Deformity</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="deformity" name="deformity" value="<?php echo (isset($data->deformity) ? $data->deformity: ""); ?>">
					</div>
				</div>
				<div class="form-group ">
					<label class="col-sm-2 control-label">Remarks</label>
					<div class="col-sm-4">
						<textarea class="form-control" id="remarks" name="remarks" placeholder="Remarks"><?php echo (isset($data->remarks) ? $data->remarks: ""); ?></textarea>
					</div>
				</div>

				<div class="box-footer">
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" name="save" class="btn btn-success btn-sm" id="submit"><i class="fa fa-save">&nbsp;</i>Simpan</button>
							<a class="btn btn-warning btn-sm" onclick="cancel()"><i class="fa fa-reply">&nbsp;</i>Batal</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?= form_close() ?>
<script type="text/javascript">
	var url_save = siteurl+'adjusment_stock/save_stock/';
    $('#frm_data').on('submit', function(e){
        e.preventDefault();
		var errors="";
		if(errors==""){
			swal({
				  title: "Save Data?",type: "warning",showCancelButton: true,confirmButtonClass: "btn-danger",confirmButtonText: "Yes",cancelButtonText: "No",closeOnConfirm: true,closeOnCancel: true
				},
				function(isConfirm) {
				  if (isConfirm) {
					  var formData 	=new FormData($('#frm_data')[0]);
					  $.ajax({
							url         :url_save,
							type		: "POST",
							data		: formData,
							cache		: false,
							dataType	: 'json',
							processData	: false,
							contentType	: false,
						success: function(msg){
							if(msg['save']=='1'){
								swal({
									title: "Success!", text: "Data saved", type: "success", timer: 1500, showConfirmButton: false
								});
								location.reload();
								$("#ModalView").modal('hide');
							} else {
								swal({
									title: "Failed!", text: "Save Error", type: "error", timer: 1500, showConfirmButton: false
								});
							};
							console.log(msg);
						},
						error: function(msg){
						  swal({
							  title: "Error!",text: "Ajax Error",type: "error",timer: 1500, showConfirmButton: false
						  });
						  console.log(msg.responseText);
						}
					  });
				 }
		  });
		}else{
			swal(errors);
			return false;
		}
    });
function check_selisih(){
	var stock=$("#length").val();
	var aktual=$("#aktual").val();
	selisih=(parseFloat(stock)-parseFloat(aktual)).toFixed(2);
	$("#selisih").val(selisih);
}
</script>
