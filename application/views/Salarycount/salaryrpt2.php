<?php
$this->load->view('include/side_menu'); 
?>    
<div class="box box-primary">
	<div class="box-header">
		
			 
		
					<h3 class="box-title">
					 <?php echo $title2; echo '&nbsp';    echo 'Periode :';  echo '&nbsp'; echo $tgl1; echo '&nbsp'; echo 's/d'; echo '&nbsp';echo $tgl2;?>
					</h3>
		
				
	
	</div>
	
	<?php
	
			  
			  $data = $this->db->query("SELECT a.employee_id, b.* FROM salary a  
			  INNER JOIN employees b on b.id=a.employee_id
			  ")->result();
		
			
			if($data != ''){	
			
			$n=0;
			foreach ($data as $d){ 
			$n++;
	
	?>
	
	<!-- /.box-header -->
	
	<div class="box-header">
	<table width="100%">
			<thead>
				<tr class='bg-blue'>
					<th class="text-left">NIK :</th>	
                    <th class="text-left"><?php echo $d->nik ?></th>
					<th></th>
					<th></th>	
				</tr>
				<tr class='bg-blue'>
				    <th class="text-left">Nama :</th>	
					<th class="text-left"><?php echo $d->name ?></th>
					<th></th>	
					<th></th>	
				</tr>
			</thead>
	</table>
	</div>
	<div class="box-body">
		<table width="100%" border="1">
			<thead>
				<tr>
					<th width="50%" class="text-left">Pendapatan
					</th>
					<th width="50%" class="text-left">Potongan
					
					</th>						
				</tr>
			</thead>
			<tbody>
			 
			<?php
			$row1 = $this->db->query("SELECT a.* FROM salary a WHERE a.employee_id = '$d->employee_id'")->result();
			$pot1 = $this->db->query("SELECT a.* FROM ms_bpjs a")->result();
					
					echo"<tr>";	
					
					 if($row1){
						
							foreach($row1 as $datas1){   					
								echo"<td>";									
									echo"<table border='1' width='100%'>";
										echo"<tr>";
											echo"<td valign ='top' align='left'>Gaji Pokok";
											echo"</td>";
											echo"<td valign ='top' align='right'>".$datas1->pokok."";
											echo"</td>";
										echo"</tr>";
									echo"</table>";									
								echo"</td>";
									
								
							}
					        }
							
							
							   
					if($pot1){
					foreach($pot1 as $datap1){
								echo"<td>";									
									echo"<table border='1' width='100%'>";
										echo"<tr>";
											echo"<td valign ='top' align='left'>".$datap1->name."";
											echo"</td>";
											echo"<td valign ='top' align='right'>".$datap1->potongan."";
											echo"</td>";
										echo"</tr>";
									echo"</table>";									
								echo"</td>";
						       
								}
							}
							echo"</tr>";
							 
							
							
					  
					   
		    $row2 = $this->db->query("SELECT a.jumlah as total, b.* FROM ms_salary_komponen a
            LEFT JOIN ms_allowance b ON b.id=a.id_tunjangan
			WHERE a.employee_id = '$d->employee_id'")->result();
			  
			         if($row2){
							
							foreach($row2 as $datas2){
								echo"<tr>";
								echo"<td>";									
									echo"<table border='1' width='100%'>";
										echo"<tr>";
											echo"<td valign ='top' align='left'>".$datas2->name."";
											echo"</td>";
											echo"<td valign ='top' align='right'>".$datas2->total."";
											echo"</td>";
										echo"</tr>";
									echo"</table>";									
								echo"</td>";
								
								echo"</tr>";
							}
					  }
			  ?>
			</tbody>
		</table>
	</div>
	<?php }
			} ?>
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
