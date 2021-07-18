<?php
$this->load->view('include/side_menu'); 
?>    
<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title"><?=$title;?></h3>
			 
		
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
			if($akses_menu['create']=='1'){
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
					<th class="text-center">Jumlah Hari</th>
					<th class="text-center">Jumlah Absensi</th>
					<th class="text-center">Tidak Absen</th>
					<th class="text-center">Cuti Tahunan</th>
					<th class="text-center">Cuti Besar</th>
					<th class="text-center">Cuti Hamil</th>
					<th class="text-center">Cuti Lain</th>
					<th class="text-center">Sakit</th>
					<th class="text-center">Tanpa Keterangan</th>
					<th class="text-center">Late 5-15 Minute</th>
					<th class="text-center">Late 16-30 Minute</th>
					<th class="text-center">Late 31-60 Minute</th>
					<th class="text-center">Late 61-220 Minute</th>
					<th class="text-center">Late > 220 Minute</th>
					<th class="text-center">Late Total (Qty)</th>
					<th class="text-center">Late Total (Minute)</th>
					<th class="text-center">Ijin Pagi < 240</th>
					<th class="text-center">Ijin Pagi > 240</th>
					<th class="text-center">Ijin Sore < 240</th>
					<th class="text-center">Ijin Sore > 240</th>
					
				</tr>
			</thead>
			<tbody>
			  <?php 
			  if($row2){
					$int	=0;
					foreach($row2 as $datas){
						
						$absen	= $datas->absensi;
						$noabsen= $datas->noabsen;
						$cuti1	= $datas->cutitahunan;
						$cuti2	= $datas->cutibesar;
					    $cuti3	= $datas->cutihamil;
						$cuti4	= $datas->cutilain;
						$cuti5  = $datas->sakit;
						
						$tanpaketerangan=$noabsen-$cuti1-$cuti2-$cuti3-$cuti4-$cuti5;
						$int++;
						
						echo"<tr>";
							echo"<td align='left'>".$int."</td>";
							echo"<td align='left'>".$datas->name."</td>";
							echo"<td align='left'>".$datas->jumlah."</td>";
							echo"<td align='left'>".$datas->absensi."</td>";
							echo"<td align='left'>".$datas->noabsen."</td>";
							echo"<td align='left'>".$datas->cutitahunan."</td>";
							echo"<td align='left'>".$datas->cutibesar."</td>";
							echo"<td align='left'>".$datas->cutihamil."</td>";
							echo"<td align='left'>".$datas->cutilain."</td>";
							echo"<td align='left'>".$datas->sakit."</td>";
							echo"<td align='left'>".$tanpaketerangan."</td>";
							echo"<td align='left'>".$datas->late5minute."</td>";
							echo"<td align='left'>".$datas->late15minute."</td>";
							echo"<td align='left'>".$datas->late30minute."</td>";
							echo"<td align='left'>".$datas->late60minute."</td>";
							echo"<td align='left'>".$datas->late220minute."</td>";
							echo"<td align='left'>".$datas->totallate."</td>";
							echo"<td align='left'>".$datas->lateminute."</td>";
							echo"<td align='left'>".$datas->izinpagi60."</td>";
							echo"<td align='left'>".$datas->izinpagi240."</td>";
							echo"<td align='left'>".$datas->izinsore60."</td>";
							echo"<td align='left'>".$datas->izinsore240."</td>";
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
