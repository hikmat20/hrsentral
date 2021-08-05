<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>HR SYSTEM | Log in</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.6 -->
	<link rel="stylesheet" href="<?php echo base_url() ?>adminlte/bootstrap/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo base_url() ?>adminlte/dist/css/AdminLTE.min.css">
	<!-- iCheck -->
	<link rel="stylesheet" href="<?php echo base_url() ?>adminlte/plugins/iCheck/square/blue.css">
	<link rel="stylesheet" href="<?php echo base_url('sweetalert/dist/sweetalert.css'); ?>">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
	<style>
		.form-box {
			width: 360px;
			margin: 40px auto 0 auto;
		}

		.form-box .header {
			-webkit-border-top-left-radius: 4px;
			-webkit-border-top-right-radius: 4px;
			-webkit-border-bottom-right-radius: 0;
			-webkit-border-bottom-left-radius: 0;
			-moz-border-radius-topleft: 4px;
			-moz-border-radius-topright: 4px;
			-moz-border-radius-bottomright: 0;
			-moz-border-radius-bottomleft: 0;
			border-top-left-radius: 4px;
			border-top-right-radius: 4px;
			border-bottom-right-radius: 0;
			border-bottom-left-radius: 0;
			background: #3c8cbd;
			box-shadow: inset 0px -3px 0px rgba(0, 0, 0, 0.2);
			padding: 20px 10px;
			text-align: center;
			font-size: 26px;
			font-weight: 300;
			color: #fff;
		}

		.form-box .body,
		.form-box .footer {
			padding: 10px 20px;
			background: #5d7b89;
			color: #fff;
		}

		.form-box .body>.form-group,
		.form-box .footer>.form-group {
			margin-top: 20px;
		}

		.form-box .body>.form-group>input,
		.form-box .footer>.form-group>input {
			border: #fff;
		}

		.form-box .body>.btn,
		.form-box .footer>.btn {
			margin-bottom: 10px;
		}

		.form-box .footer {
			-webkit-border-top-left-radius: 0;
			-webkit-border-top-right-radius: 0;
			-webkit-border-bottom-right-radius: 4px;
			-webkit-border-bottom-left-radius: 4px;
			-moz-border-radius-topleft: 0;
			-moz-border-radius-topright: 0;
			-moz-border-radius-bottomright: 4px;
			-moz-border-radius-bottomleft: 4px;
			border-top-left-radius: 0;
			border-top-right-radius: 0;
			border-bottom-right-radius: 4px;
			border-bottom-left-radius: 4px;
		}

		@media (max-width: 767px) {
			.form-box {
				width: 90%;
			}
		}
	</style>
</head>

<body class="hold-transition login-page">
	<form action="<?php echo base_url('index.php/login') ?>" method="post" id="form_proses">
		<div class='form-box'>

			<div class='header'>
				<h3 class='box-title'>HRIS</h3>
				<img src="<?php echo base_url('assets/img/logo.png') ?>" class="img-circle" alt="Logo">
			</div>
			<div class="body" style="background:#b3c4cb">
				<div class="form-group row">
					<label class="control-label text-blue">Username</label>
					<div class="col-sm-12">
						<input type="text" name="username" id="username" class="form-control input-sm" placeholder="Username" autocomplete="off">

					</div>
				</div>
				<div class="form-group row">
					<label class="control-label text-blue">Password</label>
					<div class="col-sm-12">
						<input type="password" name="password" id="password" class="form-control" placeholder="Password" autocomplete="off">
					</div>
				</div>
			</div>
			<div class="footer">
				<button type="button" class="btn btn-lg btn-primary" value="Submit" id="simpan_bro">Sign In</button>
				<a href="<?= base_url("absen.php"); ?>" class="pull-right btn btn-default btn-lg">Form Absen</a>
			</div>
		</div>
	</form>

	<!-- jQuery 2.2.3 -->
	<script src="<?php echo base_url() ?>adminlte/plugins/jQuery/jquery-2.2.3.min.js"></script>
	<!-- Bootstrap 3.3.6 -->
	<script src="<?php echo base_url() ?>adminlte/bootstrap/js/bootstrap.min.js"></script>
	<!-- iCheck -->
	<script src="<?php echo base_url() ?>adminlte/plugins/iCheck/icheck.min.js"></script>
	<script src="<?php echo base_url('sweetalert/dist/sweetalert.min.js'); ?>"></script>
	<script>
		var base_url = '<?php echo base_url(); ?>';
		var active_controller = '<?php echo ($this->uri->segment(1)); ?>';
		$(function() {
			$('#simpan_bro').click(function(e) {
				e.preventDefault();
				var users = $('#username').val();
				var password = $('#password').val();
				if (users == '' || users == null) {
					swal({
						title: "Error Message!",
						text: 'Empty Username. Please Input Username First.....',
						type: "warning"
					});
					return false;
				}

				if (password == '' || password == null) {
					swal({
						title: "Error Message!",
						text: 'Empty Password. Please Input Password First.....',
						type: "warning"
					});
					return false;
				}
				swal({
					title: "Loading!",
					text: "Please Wait..........",
					imageUrl: base_url + 'assets/img/loading.gif',
					showConfirmButton: false,
					showCancelButton: false
				});
				var formData = new FormData($('#form_proses')[0]);
				var baseurl = base_url + active_controller + '/index';
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

							window.location.href = base_url + 'dashboard';
						} else {
							if (data.status == 2) {
								swal({
									title: "Login Failed!",
									text: data.pesan,
									type: "warning",
									showConfirmButton: true,
									showCancelButton: false
								});
							} else {
								swal({
									title: "Login Failed!",
									text: data.pesan,
									type: "warning",
									showConfirmButton: true,
									showCancelButton: false
								});
							}

						}
					},
					error: function() {
						swal({
							title: "Error Message !",
							text: 'An Error Occured During Process. Please try again..',
							type: "warning",
							timer: 7000,
							showCancelButton: false,
							showConfirmButton: false,
							allowOutsideClick: false
						});
					}
				});

			});

			$('#password').keypress(function(e) {
				if (e.which == 13) { // e.which == 13 merupakan kode yang mendeteksi ketika anda   // menekan tombol enter di keyboard
					e.preventDefault();
					var users = $('#username').val();
					var password = $('#password').val();
					if (users == '' || users == null) {
						swal({
							title: "Error Message!",
							text: 'Empty Username. Please Input Username First.....',
							type: "warning"
						});
						return false;
					}

					if (password == '' || password == null) {
						swal({
							title: "Error Message!",
							text: 'Empty Password. Please Input Password First.....',
							type: "warning"
						});
						return false;
					}
					swal({
						title: "Loading!",
						text: "Please Wait..........",
						imageUrl: base_url + 'assets/img/loading.gif',
						showConfirmButton: false,
						showCancelButton: false
					});
					var formData = new FormData($('#form_proses')[0]);
					var baseurl = base_url + active_controller + '/index';
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

								window.location.href = base_url + 'dashboard';
							} else {
								if (data.status == 2) {
									swal({
										title: "Login Failed!",
										text: data.pesan,
										type: "warning",
										showConfirmButton: true,
										showCancelButton: false
									});
								} else {
									swal({
										title: "Login Failed!",
										text: data.pesan,
										type: "warning",
										showConfirmButton: true,
										showCancelButton: false
									});
								}

							}
						},
						error: function() {
							swal({
								title: "Error Message !",
								text: 'An Error Occured During Process. Please try again..',
								type: "warning",
								timer: 7000,
								showCancelButton: false,
								showConfirmButton: false,
								allowOutsideClick: false
							});
						}
					});
				}

			});

		});
	</script>
</body>

</html>