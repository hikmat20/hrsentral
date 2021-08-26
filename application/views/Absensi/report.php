<?php
$this->load->view('include/side_menu');
?>
<style>

</style>
<div class="box">
	<div class="box-body"><div class="table-responsive">
		<table id="mytabledata" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th>No</th>
			<th>Nama</th>
			<th>Departemen</th>
			<th width=80>Kumulatif<br/>Datang<br/>Terlambat</th>
			<th width=80>Frekuensi<br/>Keterlambatan</th>
			<th width=80>Rata-rata<br/>Keterlambatan</th>
			<?php
			$dates = range(strtotime($tgl_awal), strtotime($tgl_akhir),86400);
			$range_of_dates = array_map("toDate", $dates);
			function toDate($x){return date('Y-m-d', $x);}
			$coltanggal=array();
			$colkdt=0;
			$colfk=0;
			$colstatus=array();
			foreach ($range_of_dates as $key) {
				if (date("w",strtotime($key)) == '0' || date("w",strtotime($key)) == '6') {
					echo '<th class="text-red text-center">'.date("y-n-j",strtotime($key)).'</th>';
				}else{
					echo '<th class="text-center">'.date("y-n-j",strtotime($key)).'</th>';
				}
				$coltanggal[$key]='';
				$colstatus[$key]='';
			}
			?>
		</tr>
		</thead>
		<tbody>
		<?php
		$nama='';$urutan=0;$numb=0; $colkdt=0;
		$tgl_loop=''; $nama_loop='';
		if(!empty($results)){			
			foreach($results AS $record){ $numb++; 
			  if($numb>1){
				if($nama!=$record->name){
					$urutan++;
					echo '<tr><td>'.$urutan.'</td><td>'.$nama.'</td><td>'.$ndept.'</td><td align=right>'.($colkdt==0?'':number_format($colkdt)).'</td><td align=right>'.($colkdt==0?'':$colfk).'</td><td align=right>'.($colkdt==0?'':number_format($colkdt/$colfk)).'</td>';
					foreach ($range_of_dates as $key) {
						if($colstatus[$key]=='1'){
							echo '<td class="text-center text-orange">'.$coltanggal[$key].'</td>';
						}else{
							echo '<td class="text-center">'.$coltanggal[$key].'</td>';
						}
						$coltanggal[$key]='';
						$colstatus[$key]='';
					}
					$colkdt=0;
					$colfk=0;
				}
			  }
			  $nama=$record->name;
			  $ndept=$record->ndept;
			  $tanggal=date("Y-m-d",strtotime($record->waktu));
				  if($record->tipe=='1'){
					  $coltanggal[$tanggal]=date("H:i",strtotime($record->waktu));
					  $datetime1 = strtotime($tanggal.' '.$record->jam_standar);
					  $datetime2 = strtotime($record->waktu);
					  $interval  = ($datetime2 - $datetime1);
					  $minutes   = round(abs($interval) / 60);
					  if($interval>0){
						$colstatus[$tanggal]='1';
						$colkdt=($colkdt+$minutes);
						$colfk++;
					  }
				  }else{
					  $coltanggal[$tanggal]='CUTI';
				  }
			  $tgl_loop=$tanggal;$nama_loop=$nama;
			}
			echo '<tr><td>'.$urutan.'</td><td>'.$nama.'</td><td>'.$ndept.'</td>
			<td align=right>'.($colkdt==0?'':number_format($colkdt)).'</td>
			<td align=right>'.($colkdt==0?'':$colfk).'</td>
			<td align=right>'.($colkdt==0?'':number_format($colkdt/$colfk)).'</td>';
			foreach ($range_of_dates as $key) {
				if($colstatus[$key]=='1'){
					echo '<td class="text-center text-orange">'.$coltanggal[$key].'</td>';
				}else{
					echo '<td class="text-center">'.$coltanggal[$key].'</td>';
				}
			}			
		}  ?>
		</tbody>
		</table>
		</div>
	</div>
</div>
<?php $this->load->view('include/footer'); ?>
