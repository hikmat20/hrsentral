   
<!--<div class="box box-primary">
	<div class="box-header">
		
			 
		
					<h3 class="box-title">
					 <?php //echo $title2; echo '&nbsp';    echo 'Periode :';  echo '&nbsp'; echo $tgl1; echo '&nbsp'; echo 's/d'; echo '&nbsp';echo $tgl2;?>
					</h3>
		
				
	
	</div>
</div>-->
	
	<style type="text/css">
	@page {
		margin-top: 0.5cm;
		margin-bottom: 0.5cm;
		margin-left: 1cm;
		margin-right: 1cm;
	}

	.font {
		font-family: verdana, arial, sans-serif, tahoma;
		font-size: 14px;
	}

	.fontheader {
		font-family: verdana, arial, sans-serif;
		font-size: 14px;
	}

	table.gridtable2 {
		font-family: verdana, arial, sans-serif;
		font-size: 11px;
		color: #333333;
		border-width: thin;
		border-color: #666666;
		border-collapse: collapse;
	}

	table.gridtable2 th {

		padding: 10px;
		border-style: solid;
		background-color: #ffffff;
		font-family: tahoma;
		font-size: 11px;
	}

	table.gridtable2 td {
		border-width: 1px;
		padding: 8px;
		border-style: solid;
		border-color: #666666;
		background-color: #ffffff;
		font-family: verdana, arial, sans-serif;
		font-size: 10px;
	}

	#kiri {
		width: 50%;
		float: left;
	}

	#kanan {
		width: 50%;
		float: right;
	}
</style>
	<?php
	         $karyawan =$data_karyawan;
			 $periode  = date('M');
			 
			 if($periode=='Sep'){
				$v_periode='September';
			 }
			  
			  $data = $this->db->query("SELECT a.employee_id, b.* FROM salary a  
			  INNER JOIN employees b on b.id=a.employee_id
			  WHERE a.employee_id ='$karyawan'
			  ")->result();
		
			
			if($data != ''){	
			
			$n=0;
			foreach ($data as $d){ 
			
	       
	?>
	
    <div class="box box-primary">
	<table border="0" class="bg-grey">

		<tbody>

			<tr>
			    <td width="1%"></td>
				<td  align="left" width="1%">
				NIK
				</td>
				
				<td width="5%">:&nbsp<?php echo $d->nik ?></td>
				<td  align="left" width="1%">
				BANK
				</td>			
				<td width="5%">:&nbsp<?php echo $d->bank_id ?></td>
			</tr>
            <tr>
			    <td width="1%"></td>
				<td align="left" width="1%">
				NAMA
				</td>
				<td width="5%">:&nbsp<?php echo $d->name ?></td>
				<td  align="left" width="1%">
				NO. REKENING
				</td>				
				<td width="5%">:&nbsp</td>
			</tr>
			<tr>
			    <td width="1%"></td>
				<td align="left" width="1%">
				JBT
				</td>
				<td width="5%">:&nbsp<?php echo"" ?></td>
				<td  align="left" width="1%">
				PERIODE GAJI
				</td>				
				<td width="5%">:&nbsp<?=$v_periode?></td>
			</tr>
			<tr>
			    <td width="1%"></td>
				<td align="left" width="1%">
				STATUS 
				</td>
				<td width="5%">:&nbsp<?php echo $d->marital_status ?></td>
				<td width="1%"></td>				
				<td width="5%"></td>
			</tr>
			<tr>
			    <td width="1%"></td>
				<td align="left" width="1%">
				TERTANGGUNG 
				</td>
				<td width="5%">:&nbsp<?php echo $d->childs ?></td>
				<td width="1%"></td>				
				<td width="5%"></td>
			</tr>
			

		</tbody>
		
	</table>
	
	


						 <div class="box box-primary">
						 
						<div id="kiri">

							<table class="gridtable2">

								<tbody>

									<tr>
										<td colspan="3" width="10%"><b>
											<center>PENDAPATAN</center></b>
										</td>
									
									</tr>
									
	

									
									<?php
									$row1 = $this->db->query("SELECT a.* FROM salary a WHERE a.employee_id = '$karyawan'")->result();
									
											
											echo"<tr>";	
											
											 if($row1){
												
													foreach($row1 as $datas1){ 
														 $pokok = $datas1->pokok;							
													
														 ?> 					
														<td align="right">Gaji Pokok</td>
														<td></td>
														<td align="right"><?=number_format($pokok, 0, ',', '.'); ?></td>
														
											<?php			
													}
													}
											?>
													
											
										
											</tr>
											
								
									<?php
									 $row2 = $this->db->query("SELECT a.jumlah as total, b.* FROM ms_salary_komponen a
									LEFT JOIN ms_allowance b ON b.id=a.id_tunjangan
									WHERE a.employee_id = '$karyawan' AND a.kategori='1' AND a.id_tunjangan!=''")->result();
									  
											 if($row2){
													
														$tottjhr=0;
													foreach($row2 as $datas2){
														$tottjhr += $datas2->total;
														echo"<tr>";	
											?>
														<td align="right"><?= $datas2->name; ?></td>
														<td align="right"><?=number_format($datas2->total, 0, ',', '.'); ?>X<?=number_format($datas2->total, 0, ',', '.'); ?></td>
														<td align="right"><?=number_format($datas2->total, 0, ',', '.'); ?></td>
														<tr>
														
											<?php			
													}
													}
											?>
											
									<?php
									 $row3 = $this->db->query("SELECT a.jumlah as total, b.* FROM ms_salary_komponen a
									LEFT JOIN ms_allowance b ON b.id=a.id_tunjangan
									WHERE a.employee_id = '$karyawan' AND a.kategori='2' AND a.id_tunjangan!=''")->result();
									  
											 if($row3){
													$tottjbl=0;
													foreach($row3 as $datas3){
														
														$tottjbl += $datas3->total;
														echo"<tr>";	
											?>
														<td align="right"><?= $datas3->name; ?></td>
														<td></td>
														<td align="right"><?=number_format($datas3->total, 0, ',', '.'); ?></td>
														<tr>
														
											<?php			
													}
													}
											?>
											
											
									<?php $pot1 = $this->db->query("SELECT a.* FROM ms_bpjs a")->result();
									
									echo"<tr>";	
											
											if($pot1){
												$thpbpjs=0;  
												$totbpjs=0;
											foreach($pot1 as $datap1){
														 $tjbpjs=$datap1->tunjangan*$pokok/100;
														 $totbpjs+=$tjbpjs;
														 $thpbpjs+=$datap1->potongan*$pokok/100; 
														 ?> 					
														<td  align="right"><?=$datap1->name?></td>
														<td align="right"><?=number_format($datap1->tunjangan, 2, ',', '.'); ?></td>
														<td align="right"><?=number_format($tjbpjs, 0, ',', '.'); ?></td>
														
														</tr>
														
											<?php			
													}
													}
									
									?>
									<?php
																		
											//echo"<tr>";	
											
											$periode1 = date('M');	
                                            $tahun1 = date('Y');	
											
											$pot3 = $this->db->query("SELECT a.* FROM tr_salary a
											
											WHERE a.employee_id = '$karyawan' AND a.periode_gaji='$periode1' AND a.tahun='$tahun1'")->result();
									  
											 if($pot3){
													//$totpotlain1=0;
													foreach($pot3 as $pt3){													
														$totpotlain = $pt3->pot_absensi+$pt3->pot_pinjaman+$pt3->pot_pph;
														

													}
											 }
														
									?>

								</tbody>
								<tfoot>
														<tr>
														<td align="right"><b>TOTAL PENDAPATAN</b></td>
														<td></td>
														<td align="right"><b><?=number_format($pokok+$tottjhr+$tottjbl+$totbpjs, 0, ',', '.'); ?></b></td>
														</tr>
								
														<tr>
														<td align="right"><b>TAKE HOME PAY</b></td>
														<td></td>
														<td align="right"><b><?=number_format($pokok+$tottjhr+$tottjbl+$totbpjs-$thpbpjs-$totpotlain, 0, ',', '.'); ?></b></td>
														</tr>
								</tfoot>
							</table>
						</div>
	<?php

	$n++;

	}
			
	}	


	?> 

						<div id="kanan">

							<table class="gridtable2">

								<tbody>

									<tr>
										<td colspan="3" width="10%"><b>
											<center>POTONGAN</center></b>
										</td>
									</tr>

									
									<?php
									$pot2 = $this->db->query("SELECT a.* FROM ms_bpjs a")->result();
											
											echo"<tr>";	
											
											if($pot2){
														 $tpot=0;
											foreach($pot2 as $datap2){
														 $potbpjs=$datap2->potongan*$pokok/100;
														 $tpot   += $potbpjs;
												
														 ?> 					
														<td  align="right"><?=$datap2->name?></td>
														<td align="right"><?=number_format($datap2->potongan, 2, ',', '.'); ?></td>
														<td align="right"><?=number_format($potbpjs, 0, ',', '.'); ?></td>
														
														</tr>
														
											<?php			
													}
													}
											?>
											
											<?php
											
											//echo"<tr>";
                                            $periode = date('M');	
                                            $tahun = date('Y');												
											
											$pot4 = $this->db->query("SELECT a.* FROM tr_salary a
											
											WHERE a.employee_id = '$karyawan' AND a.periode_gaji='$periode' AND a.tahun='$tahun'")->result();
									  
											 if($pot4){
													//$totpotlain1=0;
													foreach($pot4 as $pt4){													
														$totpotlain1 = $pt4->pot_absensi+$pt4->pot_pinjaman+$pt4->pot_pph;
														
														?>
														<tr>
														<td  align="right"><b>POTONGAN ABSENSI</b></td>
														<td align="right"></td>
														<td align="right"><?=number_format($pt4->pot_absensi, 0, ',', '.'); ?></td>
														
														</tr>
														
														<tr>
														<td  align="right"><b>POTONGAN PINJAMAN</b></td>
														<td align="right"></td>
														<td align="right"><?=number_format($pt4->pot_pinjaman, 0, ',', '.'); ?></td>
														
														</tr>
														<tr>
														<td  align="right"><b>POTONGAN PPH</b></td>
														<td align="right"></td>
														<td align="right"><?=number_format($pt4->pot_pph, 0, ',', '.'); ?></td>
														
														</tr>
											<?php			
													}
											 }
														
																			
											 $totalpotongan = $tpot+$totpotlain1;
														
											 ?>
											
                                            														
											
										
											

								</tbody>
								<tfoot>
														<tr>
														<td align="right"><b>TOTAL POTONGAN</b></td>
														<td></td>
														<td align="right"><b><?=number_format($totalpotongan, 0, ',', '.'); ?></b></td>
														</tr>
								</tfoot>
							</table>
						</div>



 

</div>
</div>

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
