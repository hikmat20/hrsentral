<?php
$this->load->view('include/side_menu');
function conHoursMins($time, $format = '%02d jam %02d menit') {
    if ($time < 1) {
        return;
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    return sprintf($format, $hours, $minutes);
}
?>
<style>

</style>
<div class="box">
	<div class="box-body"><div class="table-responsive">
		<table id="mytabledata" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th rowspan=2>No</th>
			<th rowspan=2>Nama</th>
			<th rowspan=2>Departemen</th>
			<th rowspan=2 width=80>Kumulatif<br/>Datang<br/>Terlambat</th>
			<th rowspan=2 width=80>Frekuensi<br/>Keterlambatan</th>
			<th rowspan=2 width=80>Rata-rata<br/>Keterlambatan</th>
			<th rowspan=2 width=80>Total<br/>Jam Kerja</th>
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
					echo '<th class="text-red text-center" colspan=2>'.date("y-n-j",strtotime($key)).'</th>';
				}else{
					echo '<th class="text-center" colspan=2>'.date("y-n-j",strtotime($key)).'</th>';
				}
				$coltanggal[$key]='';
				$colstatus[$key]='';
			}
			?>
		</tr>
		<tr>
		<?php
			foreach ($range_of_dates as $key) {
				if (date("w",strtotime($key)) == '0' || date("w",strtotime($key)) == '6') {
					echo '<th colspan=2></th>';
				}else{
					echo '<th class="text-center">Jam Masuk</th>';
					echo '<th class="text-center">Jam Pulang</th>';
				}
				$coltanggal[$key]='';
				$colstatus[$key]='';
				$colpulang[$key]='';
				$colstatuspulang[$key]='';
			}		
		?>
		</tr>
		</thead>
		<tbody>
		<?php
		$nama='';$urutan=0;$numb=0; $colkdt=0;$jam_pulang='';
		$tgl_loop=''; $nama_loop=''; $total_kerja=0;
		if(!empty($results)){			
			foreach($results AS $record){ $numb++; 
			  if($numb>1){
				if($nama!=$record->name){
					$urutan++;
					echo '<tr><td>'.$urutan.'</td><td>'.$nama.'</td><td>'.$ndept.'</td><td align=right>'.($colkdt==0?'':number_format($colkdt)).'</td><td align=right>'.($colkdt==0?'':$colfk).'</td><td align=right>'.($colkdt==0?'':number_format($colkdt/$colfk)).'</td><td>'.conHoursMins($total_kerja).'</td>';
					foreach ($range_of_dates as $key) {
						if($colstatus[$key]=='1'){
							echo '<td class="text-center text-orange">'.$coltanggal[$key].'</td>';
						}else{
							echo '<td class="text-center">'.$coltanggal[$key].'</td>';
						}
						if($colstatuspulang[$key]=='1'){
							echo '<td class="text-center text-orange">'.$colpulang[$key].'</td>';
						}else{
							echo '<td class="text-center">'.$colpulang[$key].'</td>';
						}
						$coltanggal[$key]='';
						$colpulang[$key]='';
						$colstatus[$key]='';
						$colstatuspulang[$key]='';
					}
					$colkdt=0;
					$colfk=0;
					$total_kerja=0;
				}
			  }
			  $nama=$record->name;
			  $ndept=$record->ndept;
			  $jam_pulang=$record->jam_pulang;
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
				  if($record->jam_pulang!=''){
					  $colpulang[$tanggal]=date("H:i",strtotime($record->jam_pulang));
					  $datetime1 = strtotime($tanggal.' '.$record->standar_pulang);
					  $datetime2 = strtotime($record->jam_pulang);
					  $interval  = ($datetime1 - $datetime2);
					  $minutes   = round(abs($interval) / 60);
					  if($interval>0){
						  $colstatuspulang[$tanggal]='1';
					  }
				  }else{
					  $colpulang[$tanggal]='X';
					  $colstatuspulang[$tanggal]='1';
				  }
				  if($record->jam_pulang!='' && $record->waktu!=''){
					  $hourdiff = round((strtotime($record->jam_pulang) - strtotime($record->waktu))/60);
					  $total_kerja=($total_kerja+$hourdiff);
				  }
			  }else{
				  $coltanggal[$tanggal]='CUTI';
				  $colpulang[$tanggal]='CUTI';
			  }
			  $tgl_loop=$tanggal;$nama_loop=$nama;
			}
			echo '<tr><td>'.$urutan.'</td><td>'.$nama.'</td><td>'.$ndept.'</td>
			<td align=right>'.($colkdt==0?'':number_format($colkdt)).'</td>
			<td align=right>'.($colkdt==0?'':$colfk).'</td>
			<td align=right>'.($colkdt==0?'':number_format($colkdt/$colfk)).'</td><td>'.conHoursMins($total_kerja).'</td>';
			foreach ($range_of_dates as $key) {
				if($colstatus[$key]=='1'){
					echo '<td class="text-center text-orange">'.$coltanggal[$key].'</td>';
				}else{
					echo '<td class="text-center">'.$coltanggal[$key].'</td>';
				}
				if($colstatuspulang[$key]=='1'){
					echo '<td class="text-center text-orange">'.$colpulang[$key].'</td>';
				}else{
					echo '<td class="text-center">'.$colpulang[$key].'</td>';
				}
			}			
		}  ?>
		</tbody>
		</table>
		</div>
	</div>
</div>
<button id="button" class="btn btn-primary">Excel</p>
<?php $this->load->view('include/footer'); ?>
<script src="<?=base_url('assets/js/')?>jquery.table2excel.js"></script>
<script>
$("#button").click(function(){
  $("#mytabledata").table2excel({
    name: "Absensi",
    filename: "Absensi", //do not include extension
    fileext: ".xls" // file extension
  }); 
});
</script>
