<?php if ($data) : ?>
	<table id="example1" class="table table-bordered table-striped">
		<thead>
			<tr class=''>
				<th class="text-center">No</th>
				<th class="text-center">Employee </th>
				<th class="text-center">Division </th>
				<th class="text-center">Date </th>
				<th class="text-center">Start Time </th>
				<th class="text-center">End Time </th>
				<th class="text-center">Total Time </th>
				<th class="text-center">No. SO/SPK </th>
				<th class="text-center">Reason </th>
				<th class="text-center">Apv. D.Head </th>
				<th class="text-center">Apv. HR </th>
				<!-- <th class="text-center">Opsi</th> -->
			</tr>
		</thead>
		<tbody>
			<?php $n = 0;
			foreach ($data as $ovt) : $n++ ?>
				<tr>
					<td><?= $n; ?></td>
					<td><?= $ovt->name; ?></td>
					<td><?= $ovt->divisions_name; ?></td>
					<td><?= $ovt->date; ?></td>
					<td><?= $ovt->start_time; ?></td>
					<td><?= $ovt->end_time; ?></td>
					<td><?= $ovt->total_time; ?></td>
					<td><?= $ovt->no_so; ?></td>
					<td><?= $ovt->reason; ?></td>
					<td><?= $sts[$ovt->status]; ?></td>
					<td><?= $sts[$ovt->approved_hr]; ?></td>
					<!-- <td>
						<button type="button" data-id="<?= $ovt->id; ?>" class="btn btn-info btn-sm view_works"><i class="fa fa-search"></i> Rencana Kerja</button>
					</td> -->
				</tr>
				<?php if ($detail == 'true') : ?>
					<tr>
						<td></td>
						<td colspan="8">
							<label for="">List Rencana Kerja</label>
							<table width="100%" class="table table-condensed table-bordered">
								<thead class="" style="background-color: #fafafa;">
									<tr>
										<th>No.</th>
										<th>Rencana Kerja</th>
										<th>Qty</th>
										<th>Aktual</th>
										<th>Qty</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$works 		= $this->db->get_where('works', ['leave_id' => $ovt->id])->result();
									$n = 0;
									foreach ($works as $wr) : $n++; ?>
										<tr>
											<td><?= $n; ?></td>
											<td><?= $wr->work_planning; ?></td>
											<td><?= $wr->qty_planning; ?></td>
											<td><?= $wr->work_actual; ?></td>
											<td><?= $wr->qty_actual; ?></td>
										</tr>
									<?php endforeach; ?>

								</tbody>
							</table>
							<br>
							<label for="">Problems</label><br>
							<?= $ovt->problems; ?>

						</td>
					</tr>
				<?php endif; ?>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php else : ?>
	<div class="text-center">
		<h4 class="text-muted">--No data available--</h4>
	</div>
<?php endif; ?>