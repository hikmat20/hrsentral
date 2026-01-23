<?php
$this->load->view('include/side_menu');
?>
<style>
	.nopadding {
		[class*="col-"] {
			padding-left: 0 !important;
			padding-right: 0 !important;
		}
	}
</style>
<div id="blackout" style="background: rgba(219, 219, 219, .5); width:100%; height:100%; position: absolute; left:0; top:0; z-index:10; display:none;"></div>
<div class="box">
	<form method="POST" action="<?= base_url('absen_sign.php') ?>" id="form_proses" name="form_proses" class="form-inline" enctype="multipart/form-data"><br />
		<input type='hidden' id='tipe' name='tipe' value=''>
		<input type='hidden' id='standar' name='standar' value=''>
		<input type="hidden" name="image" class="image-tag">
		<input type="hidden" id="username" name="username" value="<?= $userlist['username'] ?>">
		<input type="hidden" id="password" name="password" value="*AUTOHRIS*">
		<input type="hidden" id="employee_id" name="employee_id" value="<?= $userlist['employee_id'] ?>">
		<input type="hidden" id="latitude" name="latitude">
		<input type="hidden" id="longitude" name="longitude">
		<div id="tab_tipe">
			<div class="panel-heading">
				<div class="row">

					<?php
					$sqlquery = "select kode_1,kode_2 from ms_generate where tipe='tipe_absen' and kode_1<>'9' order by kode_3";
					$query = $this->db->query($sqlquery);
					if ($query->num_rows() != 0) {
						$results = $query->result();
						foreach ($results as $record) {
							echo '
                        <div class="col-lg-4 col-xs-6">
                            <div class="small-box bg-aqua rounded-1 box-shadow" style="cursor:pointer;background-image:linear-gradient(hsl(243deg 70% 50%),hsl(243deg 70% 50%));" onclick="ctipe(\'' . $record->kode_1 . '\',\'' . $record->kode_2 . '\')">
                                <div class="inner" style="padding: 9px;">
                                    <h3 class="font-nunito hidden-xs hidden-sm">' . $record->kode_2 . '</h3>
                                    <p class="hidden-md hidden-lg">' . $record->kode_2 . '</p>
                                </div>
                                <div class="icon text-white-600">
                                    <i class="fa fa-check"></i>
                                </div>
                                <a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>';
						}
					}
					?>
				</div>
			</div>
		</div>
		<div id="tab_standar" class="hidden">
			<div class="row text-center">
				<?php
				$sqlquery = "select id,name from at_shifts where id like 'KERJA%' order by clock_in";
				$query = $this->db->query($sqlquery);
				if ($query->num_rows() != 0) {
					$results = $query->result();
					foreach ($results as $record) {
						if ($record->id == 'KERJA10') {
							echo 'Lab Cikarang <br />
                        <div class="col-lg-4 col-lg-offset-2 col-xs-5">
                            <div class="small-box bg-black rounded-1 box-shadow" style="cursor:pointer;background-image:linear-gradient(hsl(210deg, 69%, 61%),hsl(210deg, 69%, 61%));" onclick="cstandar(\'' . $record->id . '\',\'' . $record->name . '\')">
                                <div class="inner" style="padding: 9px;">
                                    <h4 class="font-nunito">' . $record->name . '</h4>
                                    <p>&nbsp;</p>
                                </div>
                                <div class="icon text-white-600">
                                    <i class="fa fa-check"></i>
                                </div>
                                <a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
						';
						} else {
							if ($record->id == 'KERJA20') {
								echo '
								<div class="col-lg-4  col-xs-5">
									<div class="small-box bg-black rounded-1 box-shadow" style="cursor:pointer;background-image:linear-gradient(hsl(210deg, 69%, 61%),hsl(210deg, 69%, 61%));" onclick="cstandar(\'' . $record->id . '\',\'' . $record->name . '\')">
										<div class="inner" style="padding: 9px;">
											<h4 class="font-nunito">' . $record->name . '</h4>
											<p>&nbsp;</p>
										</div>
										<div class="icon text-white-600">
											<i class="fa fa-clock-o"></i>
										</div>
										<a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
									</div>
								</div>								
							</div>
							<div class="row text-center">
							Kantor Cawang <br />
								<div class="col-lg-4 col-lg-offset-2 col-xs-5">
									<div class="small-box bg-yellow rounded-1 box-shadow" style="cursor:pointer;background-image:linear-gradient(hsl(160deg 99% 40%),hsl(160deg 99% 40%));" onclick="cstandar(\'' . $record->id . '\',\'' . $record->name . '\')">
										<div class="inner" style="padding: 9px;">
											<h4 class="font-nunito">' . $record->name . '</h4>
											<p>&nbsp;</p>
										</div>
										<div class="icon text-white-600">
											<i class="fa fa-clock-o"></i>
										</div>
										<a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
									</div>
								</div>
								';
							} else {
								if ($record->id == 'KERJA30') {
									echo '
								<div class="col-lg-4 col-xs-5">
									<div class="small-box bg-yellow rounded-1 box-shadow" style="cursor:pointer;background-image:linear-gradient(hsl(160deg 99% 40%),hsl(160deg 99% 40%));" onclick="cstandar(\'' . $record->id . '\',\'' . $record->name . '\')">
										<div class="inner" style="padding: 9px;">
											<h4 class="font-nunito">' . $record->name . '</h4>
											<p>&nbsp;</p>
										</div>
										<div class="icon text-white-600">
											<i class="fa fa-clock-o"></i>
										</div>
										<a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
									</div>
								</div>
								';
								}
							}
						}
					}
				}
				?>
			</div>
		</div>
		<div id="tab_capture" class="hidden">
			<div class="row text-center">
				<div class="col-md-12">
					<div class="panel-heading">
						<center>
							<div id="my_camera" class="img-responsive text-center"></div>
							<div id="results"></div>
							<br />
							<button type="button" id="btn_take" name="btn_take" value="Ambil Gambar" onClick="take_snapshot()" class="btn btn-danger"><i class="fa fa-camera"></i> Ambil Gambar</button>
							<div id="divlokasi" class="hidden">
								<br />
								<label class="control-label">Nama Perusahaan</label>
								<input type="text" name="lokasi" id="lokasi" class="form-control" placeholder="Nama Perusahaan" autocomplete="off">
								<br /><br />
							</div>
							<button type="button" id="btn_retake" name="btn_retake" value="Ulang" onClick="retake()" class="btn btn-warning hidden"><i class="fa fa-undo"></i> Ulang</button>
							<input class="btn btn-primary hidden" name="submit" type="submit" id="simpan" value="Absen">
						</center>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
</div>
<?php $this->load->view('include/footer'); ?>
<script src="<?= base_url() ?>assets/js/webcam.min.js"></script>
<!-- Configure a few settings and attach camera -->
<script language="JavaScript">
	function ctipe(id, keterangan) {
		$("#tipe").val(id);
		$("#tab_tipe").addClass("hidden");
		if (id == '1' || id == '4') {
			$("#tab_standar").removeClass("hidden");
		} else {
			$("#tab_capture").removeClass("hidden");
		}

		if (id == '2' || id == '3') {
			$("#divlokasi").removeClass("hidden");
			$("input").prop('required', true);
		} else {
			$("#divlokasi").addClass("hidden");
			$("#lokasi").val("");
			$("input").prop('required', false);
		}

	}

	function cstandar(id, keterangan) {
		$("#standar").val(id);
		$("#tab_standar").addClass("hidden");
		$("#tab_capture").removeClass("hidden");
	}

	function retake() {
		$("#btn_retake").addClass("hidden");
		$("#btn_take").removeClass("hidden");
		$("#my_camera").removeClass("hidden");
		$("#simpan").addClass("hidden");
		document.getElementById("results").innerHTML = "";
	}
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
			$("#my_camera").addClass("hidden");
			$("#btn_take").addClass("hidden");
			$("#btn_retake").removeClass("hidden");
			$("#simpan").removeClass("hidden");
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
			var xtipe = $('#tipe').val();
			if (xtipe == '2' || xtipe == '3') {
				if ($("#lokasi").val() == '') {
					alert("Nama perusahaan harus diisi");
					return false;
				}
			}
			$('#simpan').val('Proses .....');
			$('#simpan').prop('disabled', true);
			document.getElementById('blackout').style.display = 'block';
			var formData = new FormData($('#form_proses')[0]);
			var baseurl = '<?= base_url('absen_sign.php') ?>';
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
						swal({
							title: "Absen Berhasil!",
							text: "Perhatian",
							type: "success",
							timer: 10000,
							showCancelButton: false,
							showConfirmButton: false,
							allowOutsideClick: false
						});
						location.href = "<?= base_url("dashboard") ?>";
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