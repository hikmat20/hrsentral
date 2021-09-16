<?php
$this->load->view('include/side_menu'); 
?>    
<div class="box box-primary">
	<div class="box-header">
		
			 
		
					<h3 class="box-title">
					 <?php echo $title2; echo '&nbsp';    echo 'Periode :';  echo '&nbsp'; echo $tgl1; echo '&nbsp'; echo 's/d'; echo '&nbsp';echo $tgl2;?>
					</h3>
		
				
	
	</div>
	
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
	
			  
			  $data = $this->db->query("SELECT a.employee_id, b.* FROM salary a  
			  INNER JOIN employees b on b.id=a.employee_id
			  ")->result();
		
			
			if($data != ''){	
			
			$n=0;
			foreach ($data as $d){ 
			$n++;
	
	?>
	

	<table border="0">

		<tbody>

			<tr>
			    <td width="1%"></td>
				<td  align="left" width="1%">
				NIK
				</td>
				
				<td width="5%"><?php echo $d->nik ?></td>
				<td width="1%">	</td>				
				<td width="5%"></td>
			</tr>
            <tr>
			    <td width="1%"></td>
				<td align="left" width="1%">
				NAME
				</td>
				<td width="5%"><?php echo $d->name ?></td>
				<td width="1%"></td>				
				<td width="5%"></td>
			</tr>

		</tbody>
	</table>
	<br></br>
	
<div id="kiri">

	<table class="gridtable2">

		<tbody>

			<tr>
				<td colspan="3" width="10%">
					<center>PENDAPATAN</center>
				</td>
			
			</tr>

			
			<?php
			$row1 = $this->db->query("SELECT a.* FROM salary a WHERE a.employee_id = '$d->employee_id'")->result();
			
					
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
			WHERE a.employee_id = '$d->employee_id'")->result();
			  
			         if($row2){
							
							foreach($row2 as $datas2){
								echo"<tr>";	
					?>
								<td align="right"><?= $datas2->name; ?></td>
								<td></td>
								<td align="right"><?=number_format($datas2->total, 0, ',', '.'); ?></td>
								<tr>
								
					<?php			
							}
					        }
					?>
					
			<?php $pot1 = $this->db->query("SELECT a.* FROM ms_bpjs a")->result();
			
			echo"<tr>";	
					
					if($pot1){
					foreach($pot1 as $datap1){
						         $tjbpjs=$datap1->tunjangan*$pokok/100;
							     ?> 					
								<td  align="right"><?=$datap1->name?></td>
								<td align="right"><?=number_format($datap1->tunjangan, 2, ',', '.'); ?></td>
								<td align="right"><?=number_format($tjbpjs, 0, ',', '.'); ?></td>
								
								</tr>
								
					<?php			
							}
					        }
			
			?>

		</tbody>
	</table>
</div>

<div id="kanan">

	<table class="gridtable2">

		<tbody>

			<tr>
				<td colspan="3" width="10%">
					<center>POTONGAN</center>
				</td>
			</tr>

			
			<?php
			$pot2 = $this->db->query("SELECT a.* FROM ms_bpjs a")->result();
					
					echo"<tr>";	
					
					if($pot2){
					foreach($pot2 as $datap2){
						         $potbpjs=$datap2->potongan*$pokok/100;
						
							     ?> 					
								<td  align="right"><?=$datap2->name?></td>
								<td align="right"><?=number_format($datap2->potongan, 2, ',', '.'); ?></td>
								<td align="right"><?=number_format($potbpjs, 0, ',', '.'); ?></td>
								
								</tr>
								
					<?php			
							}
					        }
					?>
							
					
				
					

		</tbody>
	</table>
</div>

<?php
}
			
}
?>

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
