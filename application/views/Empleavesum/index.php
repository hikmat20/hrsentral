<?php
$this->load->view('include/side_menu');
?>
<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title"><?= $title; ?></h3>
		<div class="box-tool pull-right"></div>
	</div>
	<!-- /.box-header -->
	<div class="box-body">
		<table id="example1" class="table table-bordered table-striped">
			<thead>
				<tr class=''>
					<th class="text-center">No</th>
					<th class="text-center">Nama Karyawan</th>
					<th class="text-center">Total Hak Cuti</th>
					<th class="text-center">Total Ambil</th>
					<th class="text-center">Sisa Cuti</th>
					<th class="text-center">Cuti Khusus</th>
					<th class="text-center">Cuti Urgent</th>
					<th class="text-center">Opsi</th>
				</tr>
			</thead>
			<tbody>
				<?php $n = 0;
				foreach ($row as $data) : $n++; ?>
					<tr>
						<td><?= $n; ?></td>
						<td><?= $data->name; ?></td>
						<td><?= $data->leave; ?></td>
						<td><?= $data->get_year_leave; ?></td>
						<td><?= $data->remaining_leave; ?></td>
						<td><?= $data->special_leave; ?></td>
						<td><?= $data->notpay_leave; ?></td>
						<td>
							<button type="button" data-name="<?= $data->name; ?>" data-id="<?= $data->id; ?>" class="btn btn-info btn-sm details"><i class="fa fa-eye"></i> Detail</button>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<!-- /.box-body -->
</div>
<!-- /.box -->

<div class="modal fade" id="modalDetail">
	<div class="modal-dialog" style="width:90%">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="modal-title"></h4>
			</div>
			<div class="modal-body" id="detailView">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
			</div>
		</div>
	</div>
</div>


<?php $this->load->view('include/footer'); ?>
<script>
	$(document).ready(function() {
		$('#btn-add').click(function() {
			loading_spinner();
		});
	});

	$(document).on('click', '.details', function() {
		let id = $(this).data('id');
		let name = $(this).data('name');
		$('#modal-title').html("<strong>" + id + " - " + name + "</strong>");
		$.ajax({
			url: base_url + active_controller + '/details',
			type: 'POST',
			// dataType: 'JSON',
			data: {
				id
			},
			success: function(result) {
				console.log(result);
				$('#modalDetail').modal('show');
				$('#detailView').html(result)
			},
			error: function(result) {
				swal({
					title: "Error!",
					text: "Internal server Error.",
					type: "error",
				})
			}
		})
	})
</script>