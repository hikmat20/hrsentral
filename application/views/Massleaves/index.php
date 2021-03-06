<?php
$this->load->view('include/side_menu');
?>
<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title"><?= $title; ?></h3>
		<div class="box-tool pull-right">
			<?php
			if ($akses_menu['create'] == '1') { ?>
				<a href="<?php echo site_url('massleaves/add') ?>" class="btn btn-sm btn-success" id='btn-add'>
					<i class="fa fa-plus"></i> Add
				</a>
			<?php
			}
			?>
		</div>
	</div>
	<!-- /.box-header -->
	<div class="box-body">
		<table id="example1" class="table table-bordered table-striped">
			<thead>
				<tr class='bg-blue'>
					<th class="text-center">Id</th>
					<th class="text-center">From Date</th>
					<th class="text-center">To Date</th>
					<th class="text-center">Day(s)</th>
					<th class="text-center">Name</th>
					<th class="text-center">Description</th>
					<th class="text-center">Status</th>
					<th class="text-center">Option</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if ($row) {
					$int	= 0;
					foreach ($row as $datas) {
						$int++;
						if ($datas->status == 'Y') {
							$status = '<span class="label font-light bg-green">Terpakai</span>';
						} else {
							$status = '<span class="label font-light bg-orange">Belum Terpakai</span>';
						}

						echo "<tr>";
						echo "<td align='left'>" . $datas->id . "</td>";
						echo "<td align='center'>" . $datas->from_date . "</td>";
						echo "<td align='center'>" . $datas->to_date . "</td>";
						echo "<td align='center'>" . $datas->value_day . " Day(s)</td>";
						echo "<td align='left'>" . $datas->name . "</td>";
						echo "<td align='left'>" . $datas->descr . "</td>";
						echo "<td align='center'>" . $status . "</td>";
						echo "<td align=''>";
						if ($datas->status == 'N') {
							echo "<a href='#'  onClick='return post(\"{$datas->id}\")' class='btn btn-sm btn-success' title='Posting' data-role='qtip'><i class='fa fa-check'></i></a>&nbsp;";
							if ($akses_menu['delete'] == '1') {
								echo "<a href='#' onClick='return deleteData(\"{$datas->id}\");' class='btn btn-sm btn-danger' title='Delete Data' data-role='qtip'><i class='fa fa-trash'></i></a>&nbsp;";
							}
							if ($akses_menu['update'] == '1') {
								echo "<a href='" . site_url('massleaves/edit/' . $datas->id) . "' class='btn btn-sm btn-primary' title='Edit Data' data-role='qtip'><i class='fa fa-edit'></i></a>";
							}
						} else {
							if ($akses_menu['update'] == '1') {
								echo "<a href='javascript:void(0)' onClick='return unpost(\"{$datas->id}\")' class='btn btn-sm btn-warning' title='Unposting' data-role='qtip'><i class='fa fa-times'></i></a>";
							}
						}
						echo "</td>";
						echo "</tr>";
					}
				}
				?>
			</tbody>
		</table>
	</div>
	<!-- /.box-body -->
</div>
<!-- /.box -->

<?php $this->load->view('include/footer'); ?>
<script>
	$.extend(true, $.fn.dataTable.defaults, {
		"searching": true,
		"ordering": false
	});
	$(document).ready(function() {
		$('#btn-add').click(function() {
			loading_spinner();
		});

		$('#example').DataTable();
	});

	function deleteData(id) {
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
					window.location.href = base_url + 'index.php/' + active_controller + '/delete/' + id;

				} else {
					swal("Cancelled", "Data can be process again :)", "error");
					return false;
				}
			});

	}

	function post(id) {
		console.log(id);
		swal({
				title: "Are you sure?",
				text: "You will not be able to process again this data!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes, Process it!",
				cancelButtonText: "No, cancel process!",
				closeOnConfirm: false,
			},
			function(isConfirm) {
				if (isConfirm) {
					loading_spinner();
					$.ajax({
						url: base_url + active_controller + '/post',
						type: 'POST',
						data: {
							id
						},
						success: function(result) {
							console.log(result);
						},
						error: function(result) {
							console.log(result);
							swal({
								title: "Error!",
								text: "Internal Server Error!!",
								type: "error",
								closeOnConfirm: true,
							})
						}
					})
					// window.location.href = base_url + active_controller + '/approve/' + id;

				}
			});

	}
</script>