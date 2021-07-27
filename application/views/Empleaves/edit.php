<?php
$this->load->view('include/side_menu');
//echo"<pre>";print_r($data_companies);
?>
<form action="#" method="POST" id="form_proses_bro">
	<div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title"><?= $title; ?></h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<input type="hidden" name="id" id="id" value="<?= $emp_leave->id; ?>">
			<div class='form-group row'>
				<label class='label-control col-sm-2'><b>Employee<span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>
						<select class="form-control" name="employee_id" id="employee_id">
							<option value=""></option>
							<?php foreach ($employees as $emp) : ?>
								<option value="<?= $emp->id; ?>" <?= ($emp_leave->employee_id ==  $emp->id) ? 'selected' : ''; ?>><?= $emp->name; ?></option>
							<?php endforeach; ?>
						</select>
					</div>

				</div>
			</div>
			<div class='form-group row'>
				<label class='label-control col-sm-2'><b>Year Period <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>

						<select name="year" id="year" class="form-control input-sm">
							<option value="">Please Select</option>
							<?php
							$thn_skr = date('Y');
							for ($x = $thn_skr; $x >= 2010; $x--) : ?>
								<option value="<?php echo $x ?>" <?= ($emp_leave->year == $x) ? 'selected' : ''; ?>><?php echo $x ?></option>
							<?php endfor; ?>
						</select>
					</div>
				</div>
			</div>
			<div class='form-group row'>
				<label class='label-control col-sm-2'><b>Leave Value <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>
						<input type="number" min="0" name="leave" id="leave" value="<?= $emp_leave->leave; ?>" class="form-control text-right" placeholder="0">
					</div>
				</div>
			</div>
			<div class='form-group row'>
				<label class='label-control col-sm-2'><b>Description<span class='text-red'></span></b></label>
				<div class='col-sm-4'>
					<textarea name="description" id="desc" class="form-control" placeholder="Description"><?= $emp_leave->description; ?></textarea>
				</div>
			</div>
		</div>

		<div class='box-footer'>
			<div class="row">
				<div class="col-md-6">
					<div class="text-center">
						<?php
						echo form_button(array('type' => 'button', 'class' => 'btn btn-md btn-primary', 'value' => 'save', 'content' => '<i class="fa fa-save"></i> Save', 'id' => 'simpan-bro')) . ' ';
						echo form_button(array('type' => 'button', 'class' => 'btn btn-md btn-danger', 'value' => 'back', 'content' => '<i class="fa fa-times"></i> Cancel', 'onClick' => 'javascript:back()'));
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

<?php $this->load->view('include/footer'); ?>
<script>
	$(document).ready(function() {
		$('#simpan-bro').click(function(e) {
			e.preventDefault();
			let employee_id = $('#employee_id').val();
			let year = $('#year').val();
			let leave = $('#leave').val() || 0;

			if (employee_id == '' || employee_id == null) {
				swal({
					title: 'Warning',
					text: 'Employee not be empty, pleace choose employee first!',
					type: 'warning'
				})
				return false;
			} else if (year == '' || year == null) {
				swal({
					title: 'Warning',
					text: 'Year not be empty, pleace choose year first!',
					type: 'warning',
				})
				return false;
			} else if (leave == '' || leave == null) {
				swal({
					title: 'Warning',
					text: 'Value Leave not be empty, pleace choose value leave first!',
					type: 'warning'
				})
				return false;
			} else {
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
							var baseurl = base_url + active_controller + '/edit';
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
											timer: 3000,
											showCancelButton: false,
											showConfirmButton: false,
											allowOutsideClick: false
										})
										setTimeout(() => {
											window.location.href = base_url + active_controller;
										}, 1300);
									} else {
										swal({
											title: "Save Failed!",
											text: data.pesan,
											type: "error",
											timer: 3000,
											showCancelButton: false,
											showConfirmButton: false,
											allowOutsideClick: false
										});
									}
								},
								error: function() {
									swal({
										title: "Error Message !",
										text: 'An Error Occured During Process. Please try again..',
										type: "error",
										timer: 3000,
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
			}

		});
	});

	$(function() {
		// Daterange Picker
		$('#year').datepicker({
			dateFormat: 'yy',
			changeMonth: true,
			changeYear: true,
			yearRange: 'c-80:c+100',

		});
	});
</script>