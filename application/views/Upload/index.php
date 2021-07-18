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
		  <a href="<?php echo site_url('Upload/form') ?>" class="btn btn-sm btn-success" id='btn-add'>
			<i class="fa fa-plus"></i> Upload Data Fingerprint
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
					<th class="text-center">No</th>
					<th class="text-center">Finger Id</th>
					<th class="text-center">Name</th>
					<th class="text-center">Date</th>
					<th class="text-center">Timetable</th>
					<th class="text-center">Clock In</th>
					<th class="text-center">Clock Out</th>
										
				</tr>
			</thead>
			<tbody>
			 <?php 
			  if($row){
					$int	=0;
					foreach($row as $datas){
						$int++;
							echo"<tr>";
							echo"<td align='left'>".$int."</td>";
							echo"<td align='left'>".$datas->finger_id."</td>";
							echo"<td align='left'>".$datas->name."</td>";
							echo"<td align='left'>".$datas->date."</td>";
							echo"<td align='left'>".$datas->timetable."</td>";
							echo"<td align='left'>".$datas->clock_in."</td>";
							echo"<td align='left'>".$datas->clock_out."</td>";
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
