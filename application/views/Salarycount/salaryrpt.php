<?php
$this->load->view('include/side_menu'); 
?>    
<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title"><?php=$title;?></h3>
			 
		
					<h3 class="box-title">
						<i class="fa fa-star"></i> <?php echo $title2; echo '&nbsp';  echo $tgl1; echo '&nbsp'; echo 's/d'; echo '&nbsp';echo $tgl2;?>
					</h3>
		
				
		<div class="box-tool pull-right">
		<?php
		/*if($akses_menu['download']=='1'){
		?>
		  <a href="<?php echo site_url('Absensirpt/excel') ?>" class="btn btn-sm btn-success" id='btn-excel'>
			<i class="fa fa-download">&nbsp Download Excel</i>
		  </a>
		  <?php
			}
		  ?>
		</div>
		<div class="box-tool pull-right">
		<?php
		/*	if($akses_menu['create']=='1'){
		?>
		  <a href="<?php echo site_url('Employeelist/pdf') ?>" class="btn btn-sm btn-primary" id='btn-pdf'>
			<i class="fa fa-print"></i>
		  </a>
		  <?php
			}*/
		  ?>
		</div>
	</div>
	<!-- /.box-header -->
	<div class="box-body">
		<table id="example1" class="table table-bordered table-striped">
			<thead>
				<tr class='bg-blue'>
					<th class="text-center">No</th>
					<th class="text-center">Nama</th>
					<th class="text-center">Salary</th>
					<th class="text-center">Total Potongan</th>
					<th class="text-center">Transport</th>
					<th class="text-center">Insentif</th>	
				</tr>
			</thead>
			<tbody>
			  <?php 
			  if($row2){
					$int	=0;
					foreach($row2 as $datas){
						
						$int++;
						
						echo"<tr>";
							echo"<td align='left'>".$int."</td>";
							echo"<td align='left'>".$datas->name."</td>";
							echo"<td align='left'>".Dekripsi($datas->salary)."</td>";
							echo"<td align='left'>".$datas->total_potongan."</td>";
							echo"<td align='left'>".$datas->transport."</td>";
							echo"<td align='left'>".$datas->insentif."</td>";
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
