<?php
error_reporting(0);
define('BASEPATH', 'system');
session_start();
$latitude='';
$longitude='';
$userid='';
$userpass='';
$name='';
$folderPath = "data_absen/";
$session_captcha=$_SESSION["captcha"];
$_SESSION["captcha"] = rand(100,999);
if(isset($_POST["username"])) {
	function show_message($msg){
		echo json_encode($msg);
		die();
	}
	function cryptSHA1($fields){
		$key			='-chaemoo173';
		$Encrpt_Kata	= sha1($fields.$key);
		return $Encrpt_Kata;
	}
	$captcha = $_POST['captcha'];
	if($captcha!=$session_captcha){
//		displayhtml('danger','Session sudah berakhir');
//		die();
	}
	$img = $_POST['image'];
	$latitude = $_POST['latitude'];
	$longitude = $_POST['longitude'];
	$userid = $_POST['username'];
	$userpass = $_POST['password'];
	$tipe = $_POST['tipe'];
	$lokasi = $_POST['lokasi'];
	$standar = $_POST['standar'];
	if($userid=='' || $img=='') {
		$Arr_Return = array(
			'status'	=> 2,
			'pesan'		=> 'User ID, Password dan Gambar Tidak boleh kosong !.'
		);
		show_message($Arr_Return);
	}
	include 'application/config/development/database.php';
	$con = mysqli_connect($db['default']['hostname'],$db['default']['username'],$db['default']['password'],$db['default']['database']);
	if (mysqli_connect_errno()) {
		$Arr_Return = array(
			'status'	=> 2,
			'pesan'		=> 'Failed to connect to MySQL !.'
		);
		show_message($Arr_Return);
	}
	if($userpass=='*AUTOHRIS*'){
		$name=$_POST['employee_id'];
		if($name==''){
			$Arr_Return = array(
				'status'	=> 2,
				'pesan'	 	=> 'User ID tidak terdaftar !'
			);
			show_message($Arr_Return);
		}
	}else{
		$sql = "select employee_id from users where md5(username)='".md5($userid)."' and password='".cryptSHA1($userpass)."' and flag_active='1' limit 1";
		if ($result = mysqli_query($con, $sql)) {
			while ($row = mysqli_fetch_row($result)) {
				$name=$row[0];
			}
			mysqli_free_result($result);
		}
		if($name==''){
			$Arr_Return = array(
				'status'	=> 2,
				'pesan'	 	=> 'User ID atau Password salah !'
			);
			show_message($Arr_Return);
		}
	}
	$image_parts = explode(";base64,", $img);
	$image_type_aux = explode("image/", $image_parts[0]);
	$image_type = $image_type_aux[1];
	$image_base64 = base64_decode($image_parts[1]);
	$fileName = $userid.'_'.time().'_'.uniqid().'.jpg';
	$file = $folderPath . $fileName;
	file_put_contents($file, $image_base64);

	$clock_in='';
	$clock_out='';
	$jam_standar='';
	$sql = "select clock_in,clock_out from at_shifts where id='".$standar."' limit 1";
	if ($result = mysqli_query($con, $sql)) {
		while ($row = mysqli_fetch_row($result)) {
			$clock_in=date("H:i",strtotime(date("Y-m-d ").$row[0]));
			$clock_out=date("H:i",strtotime(date("Y-m-d ").$row[1]));
		}
		mysqli_free_result($result);
	}
	if($tipe=='1') $jam_standar=$clock_in;
	if($tipe=='4') $jam_standar=$clock_out;
	if($tipe=='5') $jam_standar=$clock_out;
	$sql = "insert into absensi_log (employee_id,user_id,foto,waktu,latitude,longitude,tipe,jam_standar,lokasi) values ('".$name."','".$userid."','".$fileName."','".date("Y-m-d H:i:s")."','".$latitude."','".$longitude."','".$tipe."','".$jam_standar."','".$lokasi."')";
	mysqli_query($con, $sql);
	mysqli_close($con);
	$Arr_Return		= array(
		'status'	=> 1,
		'pesan'		=> 'Absensi berhasil.'
	);
	show_message($Arr_Return);
}else{
	$Arr_Return		= array(
		'status'	=> 2,
		'pesan'		=> 'Isi form denga benar !.'
	);
	echo json_encode($Arr_Return);
	die();
}