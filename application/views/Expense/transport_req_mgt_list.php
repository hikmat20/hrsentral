<?php
$action='';
$this->load->view('include/side_menu');
?>
<div id="alert_edit" class="alert alert-success alert-dismissable" style="padding: 15px; display: none;"></div>
<div class="box">
	<div class="box-body"><div class="table-responsivecol-md-12">
		<table id="mytabledata" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th width="5">#</th>
			<th>No</th>
			<th>Tanggal</th>
			<th>Nama</th>
			<th>Status</th>
			<th width="120">Action</th>
		</tr>
		</thead>
		<tbody>
		<?php
		if(!empty($results)){
			$numb=0; foreach($results AS $record){ $numb++; ?>
		<tr>
		    <td><?= $numb; ?></td>
			<td><?= $record->no_doc ?></td>
			<td><?= $record->tgl_doc ?></td>
			<td><?= $record->nmuser ?></td>
			<td><?= $status[$record->status] ?></td>
			<td>
			<a class="btn btn-default btn-sm print" href="<?=base_url('expense/transport_req_print/'.$record->id)?>" target="transport_req_print" title="Print"><i class="fa fa-print"></i> </a>
			<?php if($akses_menu['read'] == '1') : ?>
				<a class="btn btn-warning btn-sm view" href="<?=base_url('expense/transport_req_view/'.$record->id.'/_mgt')?>" title="View"><i class="fa fa-eye"></i></a>
			<?php endif;
			if($akses_menu['approve'] == '1') :
				if ($record->status==1) {?>
				<a class="btn btn-success btn-sm approve" href="<?=base_url('expense/transport_req_edit/'.$record->id.'/_mgt')?>" title="Approve"><i class="fa fa-check-square-o"></i></a>
				<?php }
				endif;?>
			</td>
		</tr>
		<?php
			}
		}  ?>
		</tbody>
		</table>
		</div>
	</div>
	<!-- /.box-body -->
</div>
<div id="form-data"></div>
<?php $this->load->view('include/footer'); ?>
