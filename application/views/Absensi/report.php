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
//					echo '<th class="text-red text-center" colspan=2>'.date("y-n-j",strtotime($key)).'</th>';
					echo '<th class="text-red text-center" colspan=2>'.date("d-m-Y",strtotime($key)).'</th>';
				}else{
//					echo '<th class="text-center" colspan=2>'.date("y-n-j",strtotime($key)).'</th>';
					echo '<th class="text-center" colspan=2>'.date("d-m-Y",strtotime($key)).'</th>';
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
		$nama='';$urutan=0;$numb=0; $colkdt=0;$jam_pulang='';$employee_id='';
		$tgl_loop=''; $nama_loop=''; $total_kerja=0;
		if(!empty($results)){			
			foreach($results AS $record){ $numb++; 
			  if($numb>1){
				if($nama!=$record->name){
					$urutan++;
					echo '<tr><td>'.$urutan.'</td><td style="cursor:pointer;" class="userid" data-key="'.$employee_id.'">'.$nama.'</td><td>'.$ndept.'</td><td align=right>'.($colkdt==0?'':number_format($colkdt)).'</td><td align=right>'.($colkdt==0?'':$colfk).'</td><td align=right>'.($colkdt==0?'':number_format($colkdt/$colfk)).'</td><td>'.conHoursMins($total_kerja).'</td>';
					foreach ($range_of_dates as $key) {
						if($colstatus[$key]=='1'){
							echo '<td class="text-center text-orange">'.$coltanggal[$key].'</td>';
						}else{
							if($coltanggal[$key]==''){
								echo '<td class="text-center text-orange">X</td>';
							}else{
								echo '<td class="text-center">'.$coltanggal[$key].'</td>';
							}
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
					echo '</tr>';
					$colkdt=0;
					$colfk=0;
					$total_kerja=0;
				}
			  }
			  $nama=$record->name;
			  $employee_id=$record->employee_id;
			  $ndept=$record->ndept;
			  $jam_pulang=$record->jam_pulang;
			  $tanggal=$record->tanggal;
			  if($record->tipe!=''){
				  if($record->waktu!=''){
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
			  }
			  if($record->flag_cuti!=''){
				  $coltanggal[$tanggal]='CUTI';
				  $colpulang[$tanggal]='CUTI';
			  }
			  $tgl_loop=$tanggal;$nama_loop=$nama;
			}
			echo '<tr><td>'.$urutan.'</td><td style="cursor:pointer;" class="userid" data-key="'.$employee_id.'">'.$nama.'</td><td>'.$ndept.'</td>
			<td align=right>'.($colkdt==0?'':number_format($colkdt)).'</td>
			<td align=right>'.($colkdt==0?'':$colfk).'</td>
			<td align=right>'.($colkdt==0?'':number_format($colkdt/$colfk)).'</td><td>'.conHoursMins($total_kerja).'</td>';
			foreach ($range_of_dates as $key) {
				if($colstatus[$key]=='1'){
					echo '<td class="text-center text-orange">'.$coltanggal[$key].'</td>';
				}else{
					if($coltanggal[$key]==''){
						echo '<td class="text-center text-orange">X</td>';
					}else{
						echo '<td class="text-center">'.$coltanggal[$key].'</td>';
					}
				}
				if($colstatuspulang[$key]=='1'){
					echo '<td class="text-center text-orange">'.$colpulang[$key].'</td>';
				}else{
					echo '<td class="text-center">'.$colpulang[$key].'</td>';
				}
			}
			echo '</tr>';
		}  ?>
		</tbody>
		</table>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" id="myModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body" id="modalbody">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<button id="buttonxls" class="btn btn-primary">Excel</button>
<?= form_open(base_url('absensi'),array('id'=>'frm_data','name'=>'frm_data','target'=>'_blank')) ?>
<input type="hidden" name="tgl_awal" value="<?=$tgl_awal?>" />
<input type="hidden" name="tgl_akhir" value="<?=$tgl_akhir?>" />
<input type="hidden" name="user_id" value="" id="user_id" />
</form>
<?php $this->load->view('include/footer'); ?>
<script src="<?=base_url('assets/js/')?>jquery.table2excel.js"></script>
<script>
$(document).on('click', '.userid', function(){
	$("#user_id").val($(this).data('key'));	
	$("form#frm_data").submit();
});
$("#buttonxls").click(function(){
  $("#mytabledata").table2excel({
    name: "Absensi",
    filename: "Absensi_<?=time()?>.xls"
  }); 
});
</script>
