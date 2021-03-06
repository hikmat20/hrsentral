<?php
// define('BASEPATH', 'system');
// session_start();
$_SESSION["captcha"] = rand(100, 999);
// include 'application/config/development/database.php';
// $con = mysqli_connect($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database']);
// if (mysqli_connect_errno()) die('Error Connection');
// 
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>HR SYSTEM | Absensi</title>
    <link rel="stylesheet" href="/adminlte/bootstrap/css/bootstrap.min.css" />
    <script src="/adminlte/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script src="/assets/js/webcam.min.js"></script>
</head>

<body style="background:#d2d6de; margin: 20px auto 0 auto;">
    <div id="blackout" style="background: rgba(219, 219, 219, .5); width:100%; height:100%; position: absolute; left:0; top:0; z-index:10; display:none;"></div>
    <div class="container">
        <form method="POST" action="absen_sign.php" id="form_proses" name="form_proses" class="form-inline" enctype="multipart/form-data">
            <div class="row text-center">
                <div class="col-md-6 col-md-offset-3 col-sm-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div id="my_camera" width="490" height="390" class="hidden"></div>
                            <strong class="text-center">ABSENSI</strong><br />
                            <input type=button value="Ambil Gambar" onClick="take_snapshot()" class="btn btn-danger">
                            <br />
                            <div id="results" style="padding:10px ; min-height: 250px"></div>
                        </div>
                        <div class="panel-body" style="background:#b3c4cb">
                            <input type="hidden" name="captcha" value="<?= $_SESSION["captcha"] ?>">
                            <input type="hidden" name="image" class="image-tag">
                            <input type="hidden" id="latitude" name="latitude">
                            <input type="hidden" id="longitude" name="longitude">
                            <div class="form-group">
                                <label class="control-label text-blue">Username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Username" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label text-blue">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password" autocomplete="off" required>
                            </div>
                            <div class="form-group" style="padding-top:10px;">
                                <?php
                                foreach ($type as $tp) : ?>
                                    <label><input id='tipe_<?= $tp->id; ?>' name='tipe' type='radio' value='<?= $tp->id; ?>' required> <?= $tp->kode_2; ?></label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="panel-footer" style="background:#5d7b89">
                            <input class="btn btn-primary" name="submit" type="submit" id="simpan" value="Absen">
                            &nbsp; &nbsp; &nbsp;
                            <a href="<?= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']); ?>" class="btn btn-default btn-sm">Form Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Configure a few settings and attach camera -->
    <script language="JavaScript">
        Webcam.set({
            width: 490,
            height: 390,
            image_format: 'jpg',
            jpeg_quality: 50
        });
        Webcam.attach('#my_camera');

        function take_snapshot() {
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
        showPosition();

        $(function() {
            $('#simpan').click(function(e) {
                e.preventDefault();
                var users = $('#username').val();
                var password = $('#password').val();
                if (users == '' || users == null) {
                    alert("Username harus diisi.");
                    return false;
                }
                if (password == '' || password == null) {
                    alert("Password harus diisi.");
                    return false;
                }
                if ($('input[type=radio]:checked').size() < 1) {
                    alert("Pilihan harus diisi.");
                    return false;
                }
                $('#simpan').val('Proses .....');
                $('#simpan').prop('disabled', true);
                document.getElementById('blackout').style.display = 'block';
                var formData = new FormData($('#form_proses')[0]);
                var baseurl = 'absen_sign.php';
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
                            /*						
                            							$.ajax({
                            								url			: 'login/index',
                            								type		: "POST",
                            								data		: formData,
                            								cache		: false,
                            								dataType	: 'json',
                            								processData	: false, 
                            								contentType	: false,				
                            								success		: function(data){
                            									window.location.href = 'absensi';
                            								}
                            							});
                            */
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
</body>

</html>