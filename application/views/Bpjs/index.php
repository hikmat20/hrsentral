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
		  <a href="<?php echo site_url('bpjs/add') ?>" class="btn btn-sm btn-success" id='btn-add'>
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
					<th class="text-center">Id</th>
					<th class="text-center">Name</th>
					<th class="text-center">Pot Company</th>
					<th class="text-center">Pot Employee</th>
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
							//echo"<td align='left'><img  src='".site_url('./assets/img/'.$datas->image)."'></td>";							
							echo"<td align='left'>".$datas->id."</td>";
							echo"<td align='left'>".$datas->name."</td>";
							echo"<td align='left'>".$datas->tunjangan."</td>";
							echo"<td align='left'>".$datas->potongan."</td>";
							echo"<td align='center'>";
							    if($akses_menu['update']=='1'){
									echo"<a href='".site_url('bpjs/edit/'.$datas->id)."' class='btn btn-sm btn-primary' title='Edit BPJS' data-role='qtip'><i class='fa fa-edit'></i></a>";
								}									
								if($akses_menu['delete']=='1'){
									echo"&nbsp;<a href='#' onClick='return deleteData(\"{$datas->id}\");' class='btn btn-sm btn-danger' title='Delete Data' data-role='qtip'><i class='fa fa-trash'></i></a>";
								}
								//if($akses_menu['read']=='1'){
								//	echo"<a href='#' class='btn btn-sm btn-primary' data-toggle='collapse' data-target='#collapseExample' aria-expanded='false' aria-controls='collapseExample' title='Detail Family' data-role='qtip'><i class='fa fa-plus'></i></a>";
								//}
							echo"</td>";
							echo"</tr>";
					}
			  }
			  ?>
			  
			 </tbody>
			 <tfoot>
				<tr class='bg-blue'>
				    <th class="text-center">Id</th>
					<th class="text-center">Name</th>
					<th class="text-center">Pot Company</th>
					<th class="text-center">Pot Employee</th>
					<th class="text-center">Option</th>							
				</tr>
			</tfoot>
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
