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
				<label class='label-control col-sm-2' readonly><b>Leave ID <span class='text-red'>*</span></b> </label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>
						<?php
						echo form_input(array('readonly' => 'readonly', 'id' => 'id', 'name' => 'id', 'class' => 'form-control input-sm', 'autocomplete' => 'off', 'placeholder' => 'Grade ID'), $row[0]->id);
						?>
					</div>

				</div>
			</div>

			<div class='form-group row'>
				<label class='label-control col-sm-2'><b>Leave Name<span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>
						<?php
						echo form_input(array('id' => 'name', 'name' => 'name', 'class' => 'form-control input-sm', 'autocomplete' => 'off', 'placeholder' => 'Position Name'), $row[0]->name);
						?>
					</div>

				</div>
			</div>
			<div class='form-group row'>
				<label class='label-control col-sm-2'><b>Days Value<span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>
						<?php
						echo form_input(array('id' => 'values', 'name' => 'values', 'class' => 'form-control input-sm', 'autocomplete' => 'off', 'Days Value' => 'Position Name'), $row[0]->values);
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
						echo form_input(array('id' => 'descr', 'name' => 'descr', 'class' => 'form-control input-sm', 'autocomplete' => 'off', 'placeholder' => 'Description'), $row[0]->descr);
						?>
					</div>

				</div>
			</div>

		</div>
		<div class='box-footer'>
			<?php
			echo form_button(array('type' => 'button', 'class' => 'btn btn-md btn-primary', 'value' => 'save', 'content' => 'Save', 'id' => 'simpan-bro')) . ' ';
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
		$('#simpan-bro').click(function() {
			var id = $('#id').val();
			var nama = $('#name').val();
			if (nama == '' || nama == null) {
				swal({
					title: "Error Message!",
					text: 'Empty Grade Name, please input Grade name first.....',
					type: "warning"
				});
				return false;
			}

			if (id == '' || id == null) {
				swal({
					title: "Error Message!",
					text: 'Empty Grade ID, please input Grade ID first.....',
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
</script>