<div class="box">
	<div class="box-body"><div class="table-responsive">
		<table id="mytabledata" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th>Piece code</th>
			<th>LOT</th>
			<th>Length</th>
			<th>Deformity</th>
			<th>Unconformity</th>
			<th>High Unconformity</th>
			<th>Jumlah Unconformity</th>
			<th>Rata-rata</th>
			<th>Location</th>
			<th>Warehouse</th>
			<th>Shelf</th>
		</tr>
		</thead>
		<tbody>
		<?php
		if(!empty($results)){
			$numb=0; foreach($results AS $record){ $numb++; ?>
		<tr>
			<td><?= $record->piece_code ?></td>
			<td><?= $record->lot ?></td>
			<td><?= $record->length ?></td>
			<td><?= $record->deformity ?></td>
			<td><?= $record->unconformity ?></td>
			<td><?= $record->high_unconformity ?></td>
			<td><?= $record->total_unconformity ?></td>
			<td><?= $record->avg_unconformity ?></td>
			<td><?= $record->location ?></td>
			<td><?= $record->warehouse ?></td>
			<td><?= $record->shelf ?></td>
		</tr>
		<?php
			}
		}  ?>
		</tbody>
		</table>
		</div>
	</div>
</div>
