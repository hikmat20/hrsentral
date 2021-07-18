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
				<label class='label-control col-sm-2'><b>Username <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
						<?php
						echo form_hidden('id', $rows_data[0]->id);
						echo form_input(array('id' => 'username', 'name' => 'username', 'class' => 'form-control input-sm', 'autocomplete' => 'off', 'placeholder' => 'Username', 'readOnly' => true), $rows_data[0]->username);
						?>
					</div>

				</div>
				<label class='label-control col-sm-2'><b>Password <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-key"></i></span>
						<?php
						echo form_password(array('id' => 'password', 'name' => 'password', 'class' => 'form-control input-sm', 'autocomplete' => 'off', 'placeholder' => 'Password'));
						?>
					</div>

				</div>
			</div>

			<div class='form-group row'>
				<label class='label-control col-sm-2'><b>Group <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
						<?php
						$data_group[0]	= 'Select An Option';
						echo form_dropdown('group_id', $data_group, $rows_data[0]->group_id, array('id' => 'group_id', 'class' => 'form-control input-sm'));
						?>
					</div>

				</div>

				<label class='label-control col-sm-2'><b>View Salary</b></label>
				<div class='col-sm-4'>
					<?php
					$active		= ($rows_data[0]->flag_salary == '1') ? TRUE : FALSE;
					$data = array(
						'name'          => 'flag_salary',
						'id'            => 'flag_salary',
						'value'         => '1',
						'checked'       => $active,
						'class'         => 'input-sm'
					);

					echo form_checkbox($data) . '&nbsp;&nbsp;Yes';

					?>
				</div>
			</div>

			<div class='form-group row'>
				<label class='label-control col-sm-2'><b>Employee <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
						<?php
						$data_employees[0]	= 'Select An Option';
						echo form_dropdown('employee_id', $data_employees, $rows_data[0]->employee_id, array('id' => 'employee_id', 'class' => 'form-control input-sm'));
						?>
					</div>

				</div>
			</div>

			<div class='form-group row'>
				<label class='label-control col-sm-2'><b>Active</b></label>
				<div class='col-sm-4'>
					<?php
					$active		= ($rows_data[0]->flag_active == '1') ? TRUE : FALSE;
					$data = array(
						'name'          => 'flag_active',
						'id'            => 'flag_active',
						'value'         => '1',
						'checked'       => $active,
						'class'         => 'input-sm'
					);

					echo form_checkbox($data) . '&nbsp;&nbsp;Yes';

					?>
				</div>
				<label class='label-control col-sm-2'><b></b></label>
				<div class='col-sm-4'>
					<?php
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
		$('#simpan-bro').click(function(e) {
			e.preventDefault();
			var nama = $('#username').val();
			var group = $('#group_id').val();
			var password = $('#password').val();
			if (nama == '' || nama == null) {
				swal({
					title: "Error Message!",
					text: 'Empty Username, please input username first.....',
					type: "warning"
				});

				return false;

			}

			if (password == '' || password == null) {
				swal({
					title: "Error Message!",
					text: 'Empty Password, please input password first.....',
					type: "warning"
				});

				return false;
			}

			if (group == '' || group == null || group == '0') {
				swal({
					title: "Error Message!",
					text: 'Empty Group, please choose group first.....',
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
						var baseurl = base_url + active_controller + '/edit_user';
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