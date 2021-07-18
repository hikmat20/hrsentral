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
					<!--<th class="text-center">Foto</th> -->
					<th class="text-center">Id</th>
					<th class="text-center">History Name</th>
					<th class="text-center">NIK</th>
					<th class="text-center">Employee Name</th>
					<th class="text-center">Description</th>
					<th class="text-center">Start Date</th>
					<th class="text-center">Latest Date</th>
					
					
				</tr>
			</thead>
			<tbody>
			  <?php 
			  if($row){
					$int	=0;
					foreach($row as $datas){
						$int++;
							echo"<td align='left'>".$datas->id."</td>";
							echo"<td align='left'>".$datas->name."</td>";
							echo"<td align='left'>".$datas->change_desc."</td>";
							echo"<td align='left'>".$datas->employee_name."</td>";
							echo"<td align='left'>".$datas->descr."</td>";
							echo"<td align='left'>".tgl_indo($datas->start_date)."</td>";
							echo"<td align='left'>".$datas->latest_date."</td>";
							
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
