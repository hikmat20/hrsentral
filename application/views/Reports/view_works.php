<?php if ($data) : ?>
	<table id="example1" class="table table-bordered table-striped">
		<thead>
			<tr class=''>
				<th class="text-center">No</th>
				<th class="text-center">Employee </th>
				<th class="text-center">Division </th>
				<th class="text-center">From Date </th>
				<th class="text-center">Until Date </th>
				<th class="text-center">Total Day(s) </th>
				<th class="text-center">Reason </th>
				<th class="text-center">Apv. D.Head </th>
				<th class="text-center">Apv. HR </th>
				<!-- <th class="text-center">Opsi</th> -->
			</tr>
		</thead>
		<tbody>
			<?php $n = 0;
			foreach ($data as $wfh) : $n++ ?>
				<tr>
					<td><?= $n; ?></td>
					<td><?= $wfh->name; ?></td>
					<td><?= $wfh->divisions_name; ?></td>
					<td><?= $wfh->from_date; ?></td>
					<td><?= $wfh->until_date; ?></td>
					<td><?= $wfh->total_days; ?></td>
					<td><?= $wfh->reason; ?></td>
					<td><?= $sts[$wfh->status]; ?></td>
					<td><?= $sts[$wfh->approved_hr]; ?></td>
					<!-- <td>
						<button type="button" data-id="<?= $wfh->id; ?>" class="btn btn-info btn-sm view_works"><i class="fa fa-search"></i> Rencana Kerja</button>
					</td> -->
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php else : ?>
	<div class="text-center">
		<h4 class="text-muted">--No data available--</h4>
	</div>
<?php endif; ?>