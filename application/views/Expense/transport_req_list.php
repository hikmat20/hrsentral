<?php
$action='';
$this->load->view('include/side_menu');
?>
<div id="alert_edit" class="alert alert-success alert-dismissable" style="padding: 15px; display: none;"></div>
<div class="box">
	<div class="box-header">
		<?php if ($akses_menu['create'] == '1') : ?>
			<div class="dropdown">
			  <a class="btn btn-success btn-sm" href="<?=base_url('expense/transport_req_create');?>">
				<i class="fa fa-plus">&nbsp;</i> Tambah
			  </a>
			</div>
		<?php endif; ?>
	</div>
	<!-- /.box-header -->
	<div class="box-body"><div class="table-responsive">
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
				<a class="btn btn-warning btn-sm view" href="<?=base_url('expense/transport_req_view/'.$record->id)?>" title="View"><i class="fa fa-eye"></i></a>
			<?php endif;
			if($akses_menu['update'] == '1') :
				if ($record->status==0) {?>
				<a class="btn btn-success btn-sm edit" href="<?=base_url('expense/transport_req_edit/'.$record->id)?>" title="Edit" ><i class="fa fa-edit"></i></a>
				<?php }
				endif;
			if($akses_menu['delete'] == '1') :
				if ($record->status==0) {?>
				<a class="btn btn-danger btn-sm delete" href="javascript:void(0)" title="Hapus" onclick="data_delete('<?=$record->id?>')"><i class="fa fa-trash"></i></a>
				<?php }
				endif; ?>
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
<script type="text/javascript">
	var url_delete = siteurl+'expense/transport_req_delete/';
	//Delete
	function data_delete(id){
		swal({
		  title: "Anda Yakin?",
		  text: "Data Akan Dihapus!",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonText: "Ya, hapus!",
		  cancelButtonText: "Tidak!",
		  closeOnConfirm: false,
		  closeOnCancel: true
		},
		function(isConfirm){
		  if (isConfirm) {
		  	$.ajax({
		            url: url_delete+id,
		            dataType : "json",
		            type: 'POST',
		            success: function(msg){
		                if(msg['delete']=='1'){
		                    swal({
		                      title: "Terhapus!",
		                      text: "Data berhasil dihapus",
		                      type: "success",
		                      timer: 1500,
		                      showConfirmButton: false
		                    });
		                    window.location.reload();
		                } else {
		                    swal({
		                      title: "Gagal!",
		                      text: "Data gagal dihapus",
		                      type: "error",
		                      timer: 1500,
		                      showConfirmButton: false
		                    });
		                };
						console.log(msg);
		            },
		            error: function(msg){
		                swal({
	                      title: "Gagal!",
	                      text: "Gagal Eksekusi Ajax",
	                      type: "error",
	                      timer: 1500,
	                      showConfirmButton: false
	                    });
						console.log(msg);
		            }
		        });
		  }
		});
	}
</script>
