<?php
$this->load->view('include/side_menu'); 
?>    
<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title"><?php echo $title;?></h3>
		<div class="box-tool pull-right">
		<?php
			if($akses_menu['create']=='1'){
		?>
		  <a href="<?php echo site_url('groups/add') ?>" class="btn btn-sm btn-success" id='btn-add'>
			<i class="fa fa-user"></i> ADD GROUP
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
					<th class="text-center">No.</th>
					<th class="text-center">Group</th>
					<th class="text-center">Keterangan</th>
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
							echo"<td align='center'>$int</td>";
							echo"<td align='left'>".$datas->name."</td>";
							echo"<td align='center'>".$datas->descr."</td>";
							echo"<td align='center'>";
								if($akses_menu['update']=='1'){
									echo"<a href='".site_url('groups/edit_group/'.$datas->id)."' class='btn btn-sm btn-warning' title='Edit Data' data-role='qtip'><i class='fa fa-edit'></i></a>";
									echo"&nbsp;<a href='".site_url('groups/access_menu/'.$datas->id)."' class='btn btn-sm btn-primary' title='Menu Access' data-role='qtip'><i class='fa fa-check'></i></a>";
									echo"&nbsp;<a href='".site_url('groups/access_company/'.$datas->id)."' class='btn btn-sm btn-info' title='Company Access' data-role='qtip'><i class='fa fa-home'></i></a>";
								}									
								if($akses_menu['delete']=='1' && !in_array($datas->id,array(1=>'1','2'))){
									echo"&nbsp;<a href='#' onClick='return delData(".$datas->id.");' class='btn btn-sm btn-danger' title='Delete Data' data-role='qtip'><i class='fa fa-trash'></i></a>";
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
	function delData(id){
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
