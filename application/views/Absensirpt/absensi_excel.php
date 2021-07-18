<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Data Absensi Karyawan</title>

</head>
<body>
<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan Absensi.xls");
?>
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

</body>
</html>




















