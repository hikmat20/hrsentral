<?php
$action='';
$this->load->view('include/side_menu');
?>
<div id="alert_edit" class="alert alert-success alert-dismissable" style="padding: 15px; display: none;"></div>
<div class="box">
	<div class="box-header">
		<?php if ($akses_menu['create'] == '1') : ?>
			<div class="dropdown">
			  <a class="btn btn-success btn-sm" href="<?=base_url('expense/create');?>">
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
			<th>No Dokumen</th>
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
			<?php if ($akses_menu['read'] == '1') : ?>
				<a class="btn btn-warning btn-sm view" href="<?=base_url('expense/view/'.$record->id)?>" title="View"><i class="fa fa-eye"></i> </a>
			<?php endif;
			if ($akses_menu['update'] == '1') :
				if ($record->status==0) {?>
				<a class="btn btn-success btn-sm approve" href="<?=base_url('expense/approval/'.$record->id)?>" title="Approve"><i class="fa fa-check-square-o"></i></a>
				<?php }
				endif;
				?>
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
<!-- page script -->
<script type="text/javascript">
	var url_add = siteurl+'expense/create/';
	var url_edit = siteurl+'expense/edit/';
	var url_delete = siteurl+'expense/delete/';
	var url_view = siteurl+'expense/view/';

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

