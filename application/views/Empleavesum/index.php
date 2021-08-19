<?php
$this->load->view('include/side_menu');
?>
<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title"><?= $title; ?></h3>
		<div class="box-tool pull-right"></div>
	</div>

	<div class="box-body">
		<?php
		$group = $this->session->userdata['Group']['id'];
		if ($group != '1' && $group != '40') : ?>
			<h4 for=""><strong>Rekap Cuti Tahunan</strong></h4>
			<table class="table table-condensed table-bordered">
				<thead class="bg-info">
					<tr>
						<th width="50px">No.</th>
						<th>Tgl.</th>
						<th class="text-center">Jml. Cuti</th>
						<th>Deskripsi</th>
					</tr>
				</thead>
				<tbody>
					<?php $n = 0;
					$total = 0;
					foreach ($empLeave as $row) : $n++;
						$total += $row->leave;
					?>
						<tr>
							<td><?= $n; ?></td>
							<td><?= date("D, m d Y", strtotime($row->date)); ?></td>
							<td class="text-center">
								<span class="badge bg-aqua"><?= $row->leave; ?> hari</span>
							</td>
							<td><?= $row->description; ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
				<tfoot>
					<tr>
						<th colspan="2" class="text-right">Total Cuti Tahunan</th>
						<th class="text-center"><?= $total; ?> Hari</th>
					</tr>
				</tfoot>
			</table>
			<br>
			<h4><strong>Rekap Pengambilan Cuti</strong></h4>
			<table class="table table-condensed table-bordered">
				<thead class="bg-success">
					<tr>
						<th rowspan="2" width="50px"><small>No.</small></th>
						<th rowspan="2" width="200px"><small>Tgl.</small></th>
						<th colspan="3" class="text-center"><small>Cuti Tahunan</small></th>
						<th rowspan="3" class="text-center"><small>Cuti Sakit</small></th>
						<th colspan="2" class="text-center"><small>Cuti Pemerintah</small></th>
						<th colspan="2" class="text-center"><small>Cuti Tdk. Dibayar</small></th>
						<th rowspan="2" class="text-center"><small>Alpha</small></th>
						<th rowspan="2" class="text-center"><small>Keterangan</small></th>
						<th rowspan="2" class="text-center"><small>Catatan</small></th>
					</tr>
					<tr>
						<th width="100px" class="text-center"><small>Jml. Hak Cuti</small></th>
						<th width="100px" class="text-center"><small>Jml. Ambil</small></th>
						<th width="100px" class="text-center"><small>Sisa Cuti</small></th>
						<th width="100px" class="text-center"><small>Jml. Hari</small></th>
						<th width="" class="text-center"><small>Keterangan</small></th>
						<th width="100px" class="text-center"><small>Jml. Hari</small></th>
						<th width="" class="text-center"><small>Keterangan</small></th>
					</tr>
				</thead>
				<tbody>
					<?php $n = 0;
					$flag_leave_type = [
						'ALP' => 'Alpha',
						'AMC' => 'Ambil Cuti',
						'CBS' => 'Cuti Bersama',
						'TMC' => 'Tambah Cuti',
					];
					foreach ($empLeaveApps as $la) : $n++; ?>
						<tr>
							<td><?= $n; ?></td>
							<td><?= date("D, m d Y", strtotime($la->created_at)); ?></td>
							<td class="text-center">
								<span class="badge bg-aqua"><?= ($la->unused_leave) ? $la->unused_leave : ''; ?></span>
							</td>
							<td class="text-center">
								<span class="badge bg-blue"><?= ($la->get_year_leave) ? $la->get_year_leave : ''; ?></span>
							</td>
							<td class="text-center">
								<span class="badge bg-green"><?= ($la->remaining_leave) ? $la->remaining_leave : ''; ?></span>
							</td>
							<td class="text-center">
								<span class="badge bg-maroon"><?= ($la->sick_leave) ? $la->sick_leave : ''; ?></span>
							</td>
							<td class="text-center">
								<span class="badge bg-yellow"><?= ($la->special_leave) ? $la->special_leave : ''; ?></span>
							</td>
							<td><?= ($la->category_name) ? $la->category_name : ''; ?></td>
							<td class="text-center"><span class="badge bg-red"><?= $la->notpay_leave; ?></span></td>
							<td><?= ($la->notpay_leave_desc) ? $la->notpay_leave_desc : ''; ?></td>
							<td><span class="badge bg-default"><?= ($la->aplha_value) ? $la->aplha_value : ''; ?></span></td>
							<td><?= ($la->descriptions) ? $la->descriptions : ''; ?></td>
							<td><?= ($la->note) ? $la->note : ''; ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<br>
			<!-- <h4><strong>Rekap Alpha</strong></h4>
			<table class="table table-condensed table-bordered">
				<thead class="bg-danger">
					<tr>
						<th rowspan="" width="50px"><small>No.</small></th>
						<th rowspan="" width="200px"><small>Tgl.</small></th>
						<th colspan="" class="text-center"><small>Alpha</small></th>
						<th colspan="" class="text-center"><small>Keterangan</small></th>
						<th colspan="" class="text-center"><small>Catatan</small></th>
					</tr>
				</thead>
				<tbody>
					<?php $n = 0;
					foreach ($empLeaveApps as $la) : $n++; ?>
						<tr>
							<td><?= $n; ?></td>
							<td><?= date("D, m d Y", strtotime($la->created_at)); ?></td>
							<td class="text-center">
								<span class="badge bg-red"><?= $la->aplha_value; ?> hari</span>
							</td>
							<td><?= $la->descriptions; ?></td>
							<td><?= $la->note; ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table> -->
		<?php else : ?>
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
		<?php endif; ?>
	</div>
</div>


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