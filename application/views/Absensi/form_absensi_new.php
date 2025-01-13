<?php
$this->load->view('include/side_menu');
?>
<div id="blackout" style="background: rgba(219, 219, 219, .5); width:100%; height:100%; position: absolute; left:0; top:0; z-index:10; display:none;"></div>
<div class="box">
		<form method="POST" action="<?=base_url('absen_sign.php')?>" id="form_proses" name="form_proses" class="form-inline" enctype="multipart/form-data">
		<div id="tab_tipe">
			<div class="row text-center">
			<div class="col-md-6 col-sm-6">
				<a class="btn btn-app"><i class="fa fa-play"></i> Play</a>
			</div>
			<div class="col-md-6 col-sm-6">
				<a class="btn btn-app"><i class="fa fa-play"></i> Play</a>
			</div>
			<div class="col-md-6 col-sm-6">
				<a class="btn btn-app"><i class="fa fa-play"></i> Play</a>
			</div>
			<div class="col-md-6 col-sm-6">
				<a class="btn btn-app"><i class="fa fa-play"></i> Play</a>
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
