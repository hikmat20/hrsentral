<?php
$this->load->view('include/side_menu');
?>
<?= form_open(base_url('absensi/preview'),array('id'=>'frm_data','name'=>'frm_data','role'=>'form','class'=>'form-horizontal')) ?>
<div class="tab-content">
	<div class="tab-pane active">
		<div class="box box-primary">
			<div class="box-body">
				<div class="form-group ">
					<label class="col-sm-2 control-label">Tanggal Awal<b class="text-red">*</b></label>
					<div class="col-sm-4">
						<input type="text" id="tgl_awal" name="tgl_awal" value="<?=date("Y-m-d")?>" class="form-control tanggal" required>
					</div>
				</div>

				<div class="form-group ">
					<label class="col-sm-2 control-label">Tanggal Akhir<b class="text-red">*</b></label>
					<div class="col-sm-4">
						<input type="text" id="tgl_akhir" name="tgl_akhir" value="<?=date("Y-m-d")?>" class="form-control tanggal" required>
					</div>
				</div>

				<div class="form-group ">
					<label class='label-control col-sm-2'><b>Perusahaan</label>
					<div class='col-sm-4'>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-file"></i></span>
							<?php
							$data_companies[0]	= 'Select An Option';
							echo form_dropdown('company_id', $data_companies, '0', array('id' => 'company_id', 'class' => 'form-control input-sm'));
							?>
						</div>
					</div>
				</div>

				<div class="form-group ">
					<label class='label-control col-sm-2'><b>Divisi</label>
					<div class='col-sm-4'>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-file"></i></span>
							<?php
							$data_div[0]	= 'Select An Option';
							echo form_dropdown('division_id', $data_div, '0', array('id' => 'division_id', 'class' => 'form-control input-sm'));
							?>
						</div>
					</div>
				</div>

				<div class="form-group ">
					<label class='label-control col-sm-2'><b>Departemen</label>
					<div class='col-sm-4'>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-file"></i></span>
							<?php
							$data_depart[0]	= 'Select An Option';
							echo form_dropdown('department_id', $data_depart, '0', array('id' => 'department_id', 'class' => 'form-control input-sm'));
							?>
						</div>
					</div>
				</div>

			</div>			
			<div class='box-footer'>
				<?php
				echo form_button(array('type' => 'submit', 'class' => 'btn btn-md btn-primary', 'value' => 'Lihat', 'content' => 'Lihat')) . ' ';
				?>
			</div>
		</div>
	</div>
</div>
<?= form_close() ?>
<?php $this->load->view('include/footer'); ?>
<script>
$('#company_id').change(function() {
	var comp = $('#company_id').val();
	if (comp == '' || comp == '0' || comp == null) {
		var Template = '<option value="">Empty List</option>';
		$('#division_id').html(Template).trigger('chosen:updated');
	} else {
		var baseurl = base_url + 'Employees/getDetail/' + comp;
		$.ajax({
			url: baseurl,
			type: "GET",
			success: function(data) {
				var datas = $.parseJSON(data);
				if ($.isEmptyObject(datas) == true) {
					var Template = '<option value="">Empty List</option>';
				} else {
					var Template = '<option value="">Select An Option</option>';
					$.each(datas, function(kode, nilai) {
						Template += '<option value="' + kode + '">' + nilai + '</option>';
					});
				}
				$('#division_id').html(Template).trigger('chosen:updated');
			},
			error: function() {
				swal({
					title: "Error Message !",
					text: 'An Error Occured During Process. Please try again..',
					type: "warning",
					timer: 7000,
					showCancelButton: false,
					showConfirmButton: false,
					allowOutsideClick: false
				});
			}
		});
	}
});
$('#division_id').change(function() {
	var comp = $('#division_id').val();
	if (comp == '' || comp == '0' || comp == null) {
		var Template = '<option value="">Empty List</option>';
		$('#division_id').html(Template).trigger('chosen:updated');
	} else {
		var baseurl = base_url + 'Employees/getDept/' + comp;
		$.ajax({
			url: baseurl,
			type: "GET",
			success: function(data) {
				var datas = $.parseJSON(data);
				if ($.isEmptyObject(datas) == true) {
					var Template = '<option value="">Empty List</option>';
				} else {
					var Template = '<option value="">Select An Option</option>';
					$.each(datas, function(kode, nilai) {
						Template += '<option value="' + kode + '">' + nilai + '</option>';
					});
				}
				$('#department_id').html(Template).trigger('chosen:updated');
			},
			error: function() {
				swal({
					title: "Error Message !",
					text: 'An Error Occured During Process. Please try again..',
					type: "warning",
					timer: 7000,
					showCancelButton: false,
					showConfirmButton: false,
					allowOutsideClick: false
				});
			}
		});
	}
});
$(function() {
	// Daterange Picker
	$('.tanggal').datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		yearRange: 'c-80:c+100',

	});
});

</script>
