<?php
$this->load->view('include/side_menu');
?>
<div id="blackout" style="background: rgba(219, 219, 219, .5); width:100%; height:100%; position: absolute; left:0; top:0; z-index:10; display:none;"></div>
<div class="box">
		<form method="POST" action="<?=base_url('absen_sign.php')?>" id="form_proses" name="form_proses" class="form-inline" enctype="multipart/form-data">
			<div class="row text-center">
				<div class="col-md-6 col-md-offset-3 col-sm-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<center>
							<div id="my_camera" class="img-responsive text-center"></div>
							<input type=button value="Ambil Gambar" onClick="take_snapshot()" class="btn btn-danger">
							<br />
							<div id="results"></div>
							</center>
						</div>
						<div class="panel-body" style="background:#b3c4cb">
							<input type="hidden" name="image" class="image-tag">
							<input type="hidden" id="username" name="username" value="<?=$userlist['username']?>">
							<input type="hidden" id="password" name="password" value="*AUTOHRIS*">
							<input type="hidden" id="employee_id" name="employee_id" value="<?=$userlist['employee_id']?>">
							<input type="hidden" id="latitude" name="latitude">
							<input type="hidden" id="longitude" name="longitude">
							<div class="form-group" style="padding-top:10px;" id="ctipe">
								<?php
								$sqlquery = "select kode_1,kode_2 from ms_generate where tipe='tipe_absen' and kode_1<>'9' order by kode_1";
								$query=$this->db->query($sqlquery);
								if($query->num_rows() != 0) {
									$results=$query->result();
									foreach($results AS $record){ 
										echo " <label><input id='tipe_".$record->kode_1."' name='tipe' type='radio' value='".$record->kode_1."' required> ".$record->kode_2." </label> ";
									}
								}
								?>
							</div>
							<div class="form-group text-left" style="padding-top:10px;" id="cjam">
								<?php
								$sqlquery = "select id,name from at_shifts where id like 'KERJA%' order by clock_in";
								$query=$this->db->query($sqlquery);
								if($query->num_rows() != 0) {
									$results=$query->result();
									foreach($results AS $record){ 
										if($record->id=='KERJA10'){
											echo "<div>Lab Cikarang  &nbsp; : <label><input id='standar_".$record->id."' name='standar' type='radio' value='".$record->id."' required> ".$record->name." </label>";
										}else{
											if($record->id=='KERJA20'){
												echo " 
												<label><input id='standar_".$record->id."' name='standar' type='radio' value='".$record->id."' required> ".$record->name." </label></div>
												<div>Kantor Cawang :  <input id='standar_".$record->id."' name='standar' type='radio' value='".$record->id."' required> ".$record->name." </label>";
											}else{
												echo " <label><input id='standar_".$record->id."' name='standar' type='radio' value='".$record->id."' required> ".$record->name." </label> ";
											}
										}
									}
								}
								?></div>
							</div>
						</div>
						<div class="panel-footer" style="background:#5d7b89">
							<input class="btn btn-primary" name="submit" type="submit" id="simpan" value="Absen">
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<?php $this->load->view('include/footer'); ?>
<script src="<?=base_url()?>assets/js/webcam.min.js"></script>
	<!-- Configure a few settings and attach camera -->
	<script language="JavaScript">
		Webcam.set({
			width: 300,
			height: 300,
			image_format: 'jpg',
			jpeg_quality: 50
		});
		Webcam.attach('#my_camera');

		function take_snapshot() {
			showPosition();
			Webcam.snap(function(data_uri) {
				$(".image-tag").val(data_uri);
				document.getElementById('results').innerHTML = '<img src="' + data_uri + '" height="300" class="img-responsive" />';
			});
		}

		function showPosition() {
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(function(position) {
					$("#latitude").val(position.coords.latitude);
					$("#longitude").val(position.coords.longitude);
				});
			} else {
				alert("Sorry, your browser does not support HTML5 geolocation.");
			}
		}

		$(function() {
			$('#simpan').click(function(e) {
				e.preventDefault();
				var koordinat = $("#latitude").val();
				if (koordinat == '') {
					alert("Harap GPS dihidupkan dan Ambil gambar lagi");
					return false;
				}
				if ($('#ctipe input:radio:checked').size() < 1) {
					alert("Pilihan harus diisi.");
					return false;
				}
				var tipeabsen=$('input[name=tipe]:checked', '#form_proses').val();
				if(tipeabsen== '1' || tipeabsen=='4') {
					if ($('#cjam input:radio:checked').size() < 1) {
						alert("Pilihan jam kerja harus diisi.");
						return false;
					}
				}
				$('#simpan').val('Proses .....');
				$('#simpan').prop('disabled', true);
				document.getElementById('blackout').style.display = 'block';
				var formData = new FormData($('#form_proses')[0]);
				var baseurl = '<?=base_url('absen_sign.php')?>';
				$.ajax({
					url: baseurl,
					type: "POST",
					data: formData,
					cache: false,
					dataType: 'json',
					processData: false,
					contentType: false,
					success: function(data) {
						if (data.status == 1) {
							document.getElementById('blackout').style.display = 'none';
							alert('Absen Berhasil');
							location.reload();
						} else {
							document.getElementById('blackout').style.display = 'none';
							alert("Absen Gagal!\n" + data.pesan);
							$('#simpan').prop('disabled', false);
							$('#simpan').val('Absen');
							return false;
						}
					},
					error: function(data) {
						document.getElementById('blackout').style.display = 'none';
						alert("Proses error, coba lagi.");
						$('#simpan').prop('disabled', false);
						$('#simpan').val('Absen');
						return false;
					}
				});
			});
		});
	</script>
