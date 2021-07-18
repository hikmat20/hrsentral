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
					<th class="text-center">Option</th>
					<!--<th class="text-center">Foto</th> -->
					<th class="text-center">Id</th>
					<th class="text-center">NIK</th>
					<th class="text-center">Name</th>
					<th class="text-center">Company</th>
					<th class="text-center">Division</th>
					<th class="text-center">Departement</th>
					<th class="text-center">Title</th>
					<th class="text-center">Resign Status </th>
					<th class="text-center">Resign Start Date</th>
					<th class="text-center">Status Aktif</th>
					
				</tr>
			</thead>
			<tbody>
			  <?php 
			  if($row){
					$int	=0;
					foreach($row as $datas){
						$int++;
						 $agama = $datas->relid;
						 
						if ($agama=1){
						$religi='Islam';	
						}
						elseif($agama=2)
						{
							$religi='Katolik';
						}
						elseif($agama=3)
						{
							$religi='Kristen';
						}
						elseif($agama=4)
						{
							$religi='Hindu';
						}
						elseif($agama=5)
						{
							$religi='Budha';
						}
						elseif($agama=6)
						{
							$religi='Kong Hu Chu';
						}
						
						
						
						
						
						
							echo"<tr>";
							echo"<td align='center'>";
								if($akses_menu['update']=='1'){
									echo"<a href='".site_url('resign/edit/'.$datas->id)."' class='btn btn-sm btn-primary' title='Update Resign' data-role='qtip'><i class='fa fa-edit'></i></a>";
								}									
								//if($akses_menu['delete']=='1'){
								//	echo"&nbsp;<a href='#' onClick='return deleteData(\"{$datas->id}\");' class='btn btn-sm btn-danger' title='Delete Data' data-role='qtip'><i class='fa fa-trash'></i></a>";
								//}
							echo"</td>";	

							//echo"<td align='left'><img  src='".site_url('./assets/img/'.$datas->image)."'></td>";							
							echo"<td align='left'>".$datas->id."</td>";
							echo"<td align='left'>".$datas->nik."</td>";
							echo"<td align='left'>".$datas->name."</td>";
							echo"<td align='left'>".$datas->company_name."</td>";
							echo"<td align='left'>".$datas->division_name."</td>";
							echo"<td align='left'>".$datas->department_name."</td>";
							echo"<td align='left'>".$datas->title_name."</td>";
							echo"<td align='left'>".$datas->resign."</td>";
							echo"<td align='left'>".$datas->resign_date."</td>";
							echo"<td align='left'>".$datas->flag_active."</td>";
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
