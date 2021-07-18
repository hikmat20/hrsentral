<?php
$this->load->view('include/side_menu'); 
?>    
<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title"><?=$title;?></h3>
		<div class="box-tool pull-right">
		<?php
			if($akses_menu['create']=='1'){
		?>
		  <a href="<?php echo site_url('policy/add') ?>" class="btn btn-sm btn-success" id='btn-add'>
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
					<th class="text-center">Id Position</th>
					<th class="text-center">Name Position</th>
					<th class="text-center">Terlambat 5</th>
					<th class="text-center">Terlambat 15</th>
					<th class="text-center">Terlambat 30</th>
					<th class="text-center">Terlambat 60</th>
					<th class="text-center">Terlambat 240</th>
					<th class="text-center">Izin Pagi</th>
					<th class="text-center">Izin Sore</th>
					<th class="text-center">Transport</th>
					<th class="text-center">Insentif</th>
					<th class="text-center">Option</th>
				</tr>
			</thead>
			<tbody>
			  <?php 
			  if($row){
					$int	=0;
					foreach($row as $datas){
						$int++;
						
						
							echo"<tr>";							
							echo"<td align='left'>".$datas->position_id."</td>";
							echo"<td align='left'>".$datas->name."</td>";
							echo"<td align='left'>".$datas->late5."</td>";
							echo"<td align='left'>".$datas->late15."</td>";
							echo"<td align='left'>".$datas->late30."</td>";
							echo"<td align='left'>".$datas->late60."</td>";
							echo"<td align='left'>".$datas->late240."</td>";
							echo"<td align='left'>".$datas->izinpagi."</td>";
							echo"<td align='left'>".$datas->izinsore."</td>";
							echo"<td align='left'>".$datas->transport."</td>";
							echo"<td align='left'>".$datas->insentif."</td>";
							echo"<td align='center'>";
								if($akses_menu['update']=='1'){
									echo"<a href='".site_url('policy/edit/'.$datas->id)."' class='btn btn-sm btn-primary' title='Edit Data' data-role='qtip'><i class='fa fa-edit'></i></a>";
								}									
								if($akses_menu['delete']=='1'){
									echo"&nbsp;<a href='#' onClick='return deleteData(\"{$datas->id}\");' class='btn btn-sm btn-danger' title='Delete Data' data-role='qtip'><i class='fa fa-trash'></i></a>";
								}
							echo"</td>";
						echo"</tr>";
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
	$(document).ready(function(){
		$('#btn-add').click(function(){
			loading_spinner();
		});		
	});
	function deleteData(id){
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
					window.location.href = base_url +'index.php/'+ active_controller+'/delete/'+id;
					
			  } else {
				swal("Cancelled", "Data can be process again :)", "error");
				return false;
			  }
		});
       
	} 
	
	
</script>
