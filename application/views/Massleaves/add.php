<?php
$this->load->view('include/side_menu');
//echo"<pre>";print_r($data_menu);
?>
<form action="#" method="POST" id="form_proses_bro">
	<div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title"><?= $title; ?></h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<div class='form-group row'>
				<label class='label-control col-sm-2'><b>Mass Leave ID <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>
						<?php
						echo form_input(array('readonly' => 'readonly', 'id' => 'id', 'name' => 'id', 'class' => 'form-control input-sm', 'autocomplete' => 'off', 'placeholder' => 'Automatic'));
						?>
					</div>
				</div>
			</div>
			<div class='form-group row'>
				<label class='label-control col-sm-2'><b>From Date <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>
						<?php
						echo form_input(array('id' => 'from_date', 'name' => 'from_date', 'class' => 'form-control input-sm', 'autocomplete' => 'off', 'placeholder' => 'From Date'));
						?>
					</div>

				</div>
			</div>
			<div class='form-group row'>
				<label class='label-control col-sm-2'><b>To Date <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>
						<?php
						echo form_input(array('id' => 'to_date', 'name' => 'to_date', 'class' => 'form-control input-sm', 'autocomplete' => 'off', 'placeholder' => 'To Date'));
						?>
					</div>

				</div>
			</div>
			<div class='form-group row'>
				<label class='label-control col-sm-2'><b>Value Day(s) <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>
						<?php
						echo form_input(array('id' => 'value_day', 'name' => 'value_day', 'class' => 'form-control input-sm', 'autocomplete' => 'off', 'placeholder' => 'Value Day', 'readonly' => 'readonly'));
						?>
						<span class="input-group-addon">Day(s)</span>
					</div>
				</div>
			</div>
			<div class='form-group row'>
				<label class='label-control col-sm-2'><b>Mass Leave Name <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>
						<?php
						echo form_input(array('id' => 'name', 'name' => 'name', 'class' => 'form-control input-sm', 'autocomplete' => 'off', 'placeholder' => 'Mass Leave Name'));
						?>
					</div>

				</div>
			</div>
			<div class='form-group row'>
				<label class='label-control col-sm-2'><b>Description<span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>
						<?php
						echo form_input(array('id' => 'descr', 'name' => 'descr', 'class' => 'form-control input-sm', 'autocomplete' => 'off', 'placeholder' => 'Description'));
						?>
					</div>

				</div>
			</div>

		</div>
	</div>
	<div class='box-footer'>
		<?php
		echo form_button(array('type' => 'button', 'class' => 'btn btn-md btn-primary', 'value' => 'save', 'content' => 'Save', 'id' => 'simpan-com')) . ' ';
		echo form_button(array('type' => 'button', 'class' => 'btn btn-md btn-danger', 'value' => 'back', 'content' => 'Back', 'onClick' => 'javascript:back()'));
		?>
	</div>
	<!-- /.box-body -->
	</div>
	<!-- /.box -->
</form>

<?php $this->load->view('include/footer'); ?>
<script>
	$(document).ready(function() {
		$('#simpan-com').click(function(e) {
			e.preventDefault();
			var id = $('#id').val();
			var nama = $('#name').val();
			if (nama == '' || nama == null) {
				swal({
					title: "Error Message!",
					text: 'Empty Position Name, please input Position name first.....',
					type: "warning"
				});

				return false;

			}



			swal({
					title: "Are you sure?",
					text: "You will not be able to process again this data!",
					type: "warning",
					showCancelButton: true,
					confirmButtonClass: "btn-danger",
					confirmButtonText: "Yes, Process it!",
					cancelButtonText: "No, cancel process!",
					closeOnConfirm: true,
					closeOnCancel: false
				},
				function(isConfirm) {
					if (isConfirm) {
						loading_spinner();
						var formData = new FormData($('#form_proses_bro')[0]);
						var baseurl = base_url + active_controller + '/add';
						$.ajax({
							url: baseurl,
							type: "POST",
							data: formData,
							cache: false,
							dataType: 'json',
							processData: false,
							contentType: false,
							success: function(data) {
								if (data.status == 1) {
									swal({
										title: "Save Success!",
										text: data.pesan,
										type: "success",
										timer: 7000,
										showCancelButton: false,
										showConfirmButton: false,
										allowOutsideClick: false
									});
									window.location.href = base_url + active_controller;
								} else {

									if (data.status == 2) {
										swal({
											title: "Save Failed!",
											text: data.pesan,
											type: "warning",
											timer: 7000,
											showCancelButton: false,
											showConfirmButton: false,
											allowOutsideClick: false
										});
									} else {
										swal({
											title: "Save Failed!",
											text: data.pesan,
											type: "warning",
											timer: 7000,
											showCancelButton: false,
											showConfirmButton: false,
											allowOutsideClick: false
										});
									}

								}
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
					} else {
						swal("Cancelled", "Data can be process again :)", "error");
						return false;
					}
				});
		});
	});
	$(function() {
		// Daterange Picker
		$('#from_date,#to_date').datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			yearRange: 'c-10:c+1',
		});
	});

	$(document).on('change', '#from_date,#to_date', function() {
		let from_date = new Date($('#from_date').val());
		let to_date = new Date($('#to_date').val());
		if (from_date < to_date) {
			calc = parseInt(to_date.getTime() || 0) - parseInt(from_date.getTime() || 0);
			days = parseInt(calc) / parseInt(1000 * 3600 * 24) + 1;
			// days = dateDifference(from_date, to_date);
			$('#value_day').val(days)
		} else {
			$('#value_day').val(0)
		}
	})
</script>