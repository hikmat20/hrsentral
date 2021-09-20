<?php
$this->load->view('include/side_menu'); 
?>    
<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title"><?=$title;?></h3>
		
	</div>
	<!-- /.box-header -->
	<div class="box-body">
		
			<?php
			
			   $bulan = date('M');
	        
			  
			  $data = $this->db->query("SELECT a.employee_id, b.* FROM salary a  
			  INNER JOIN employees b on b.id=a.employee_id
			  ")->result();
		
			
				if($data != ''){	
			
				$n=0;
				foreach ($data as $d){ 
			    $n++;
	               
				$karyawan =$d->employee_id;
				?>
	
				<?php
						$row1 = $this->db->query("SELECT a.* FROM salary a WHERE a.employee_id = '$karyawan'")->result();
						
								
								echo"<tr>";	
								
								 if($row1){
									
										foreach($row1 as $datas1){ 
											 $pokok = $datas1->pokok;
											 $v_pokok= number_format($pokok,0, ',', '.');

                        

                        
									 $row2 = $this->db->query("SELECT a.jumlah as total, b.* FROM ms_salary_komponen a
									LEFT JOIN ms_allowance b ON b.id=a.id_tunjangan
									WHERE a.employee_id = '$d->employee_id' AND a.kategori='1'")->result();
									  
											 if($row2){
													
														$tottjhr=0;
													foreach($row2 as $datas2){
														$tottjhr += $datas2->total;
														$v_tottjhr= number_format($tottjhr,0, ',', '.');
													
														
											
											
									
									 $row3 = $this->db->query("SELECT a.jumlah as total, b.* FROM ms_salary_komponen a
									LEFT JOIN ms_allowance b ON b.id=a.id_tunjangan
									WHERE a.employee_id = '$d->employee_id' AND a.kategori='2'")->result();
									  
											 if($row3){
													$tottjbl=0;
													foreach($row3 as $datas3){
														
														$tottjbl += $datas3->total;
														$v_tottjbl= number_format($tottjbl,0, ',', '.');
											
											
											
									        $pot1 = $this->db->query("SELECT a.* FROM ms_bpjs a")->result();
									
								
											
											if($pot1){
												$thpbpjs=0;  
												$totbpjs=0;
											foreach($pot1 as $datap1){
														 $tjbpjs=$datap1->tunjangan*$pokok/100;
														 $totbpjs+=$tjbpjs;
														 $thpbpjs+=$datap1->potongan*$pokok/100; 
														 $v_totbpjs= number_format($totbpjs,0, ',', '.');
														 $v_thpbpjs= number_format($thpbpjs,0, ',', '.');
														
																}
																}
												
											
														
														
																
													
														 				
													
						   
							
							$total = $pokok+$tottjhr+$tottjbl+$totbpjs+$thpbpjs;
							
							$dataInsert['id']				= $this->employees_model->code_otomatis('tr_salary','TRS');
							$dataInsert['employee_id']	= $karyawan;
							$dataInsert['periode_awal']   = '2021-08-21';
							$dataInsert['periode_akhir']   = '2021-09-20';
							$dataInsert['periode_gaji']   =$bulan;
							$dataInsert['pokok']			= $pokok;
							$dataInsert['tj_harian']	= $tottjhr;
							$dataInsert['tj_bulanan']	= $tottjbl;
							$dataInsert['tj_bpjs']	= $totbpjs;
							$dataInsert['pot_bpjs']	= $thpbpjs;
							$dataInsert['total']	    = $total;							
							$data_session			= $this->session->userdata;							
							$dataInsert['created_by']		= $data_session['User']['username']; 
							$dataInsert['created']		= date('Y-m-d H:i:s');				
								
									
							
							$this->employees_model->simpan('tr_salary',$dataInsert);
							
					}
			  }
			  ?>
			  
			  
				
				<?php			
								}
								}
						?>
						
				<?php			
								}
								}
						?>
			  
			  
	<!--ENDING FOREACH KARYAWAN	 -->
	<?php

	
	}
			
	}	


	?>
	
	    <table id="example1" class="table table-bordered table-striped">
			<thead>
				<tr class='bg-blue'>
                    <th class="text-center">No</th>				
					<th class="text-center">Name</th>
					<th class="text-center">Basic Salary</th>
					<th class="text-center">Tunjangan Harian</th>
					<th class="text-center">Tunjangan Bulanan</th>
					<th class="text-center">Tunjangan BPJS</th>
					<th class="text-center">Potongan BPJS</th>
					<th class="text-center">Potongan Lain-lain</th>
					<th class="text-center">Total</th>
					<th class="text-center">Option</th>						
				</tr>
			</thead>
			<tbody>
			
		 <?php
		 
		 $bulan = date('M');
		 // print_r($bulan);
		 // exit;
		 
							 $tr_salary = $this->db->query("SELECT a.*, b.* FROM tr_salary a  
							 INNER JOIN employees b on b.id=a.employee_id WHERE a.periode_gaji='$bulan'")->result();
						
								
							
								 
							if($tr_salary){
									 $nomor=0;
									
							foreach($tr_salary as $tr){ 
							$nomor++;
		 
		                    echo"<tr>";							
						    echo"<td align='left'>".$nomor."</td>";
							echo"<td align='left'>".$tr->name."</td>";
							echo"<td align='right'>".$tr->pokok."</td>";
							echo"<td align='right'>".$tr->tj_harian."</td>";
							echo"<td align='right'>".$tr->tj_bulanan."</td>";
							echo"<td align='right'>".$tr->tj_bpjs."</td>";
							echo"<td align='right'>".$tr->pot_bpjs."</td>";
							echo"<td align='right'>".$tr->pot_lain."</td>";
							echo"<td align='center'>".$tr->total."</td>";
							echo"<td align='center'>"; 
								echo"<a href='#' class='btn btn-sm btn-primary add_ptg' title='Add Potongan' data-role='qtip'><i class='fa fa-plus'></i></a>";							
							    if($akses_menu['update']=='1'){
									echo"<a href='".site_url('salary/print/'.$tr->employee_id)."' class='btn btn-sm btn-success' title='view Slip' data-role='qtip'><i class='fa fa-eye'></i></a>";
								}									
								
								
							echo"</td>";
							echo"</tr>";
							
						    }
								 }
		 
		 ?>
			  
			 </tbody>
			 <tfoot>
			    <tr class='bg-blue'>
                    <th class="text-center">No</th>				
					<th class="text-center">Name</th>
					<th class="text-center">Basic Salary</th>
					<th class="text-center">Tunjangan Harian</th>
					<th class="text-center">Tunjangan Bulanan</th>
					<th class="text-center">Tunjangan BPJS</th>
					<th class="text-center">Potongan BPJS</th>
					<th class="text-center">Potongan Lain-lain</th>
					<th class="text-center">Total</th>
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
