<?php
error_reporting(0);
define('BASEPATH', 'system');
$datanya = file_get_contents('php://input');
$urls='https://sentral.dutastudy.com/hrsentral/';
$folderPathCuti='assets/documents/';
$json_data = json_decode($datanya);
$Arr_Return=array();
$folderPath = "data_absen/";
$data=array();
function cryptSHA1($fields){
	$key			='-chaemoo173';
	$Encrpt_Kata	= sha1($fields.$key);
	return $Encrpt_Kata;
}
function show_message($msg){
	echo json_encode($msg);
	die();
}
include 'application/config/development/database.php';
$con = mysqli_connect($db['default']['hostname'],$db['default']['username'],$db['default']['password'],$db['default']['database']);
if (mysqli_connect_errno()) {
	$Arr_Return = array('status' => 0, 'pesan' => 'Failed to connect to Database !');
	show_message($Arr_Return);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
/*
api log
	$sql = "insert api_log (info, waktu) values ('".$datanya."','".date("Y-m-d H:i:s")."')";
	mysqli_query($con, $sql);
*/
	$nav= $json_data->nav;
	switch ($nav){
// cuti
		case 'sisa_cuti':
			$employee_id='';
			$userid = $json_data->username;
			$userpass = $json_data->password;
			if($userid!='' && $userpass!='') {
				$sql = "select employee_id,username from users where md5(username)='".($userid)."' and password='".cryptSHA1($userpass)."' and flag_active='1' limit 1";
				if ($result = mysqli_query($con, $sql)) {
					while ($row = mysqli_fetch_row($result)) {
						$employee_id=$row[0];
						$username=$row[1];
					}
					mysqli_free_result($result);
				}
			}
			if($employee_id==''){
				$Arr_Return = array('status' => 0, 'pesan' => 'User Name tidak ditemukan');
			}else{
				$leave=0;
				$sql = "select `leave` from employees_leave where employee_id='".$employee_id."' limit 1";
				if ($result = mysqli_query($con, $sql)) {
					while ($row = mysqli_fetch_row($result)) {
						$leave=$row[0];
					}
					mysqli_free_result($result);
				}
				$Arr_Return = array('status' => 1, 'pesan' => $leave);
			}
			break;
		case 'jenis_cuti':
			$sql = "select id,`name`,`values` from at_leaves order by id";
			if ($result = mysqli_query($con, $sql)) {
				while ($row = mysqli_fetch_row($result)) {
					$data[]=array('id'=>$row[0],'nama'=>$row[1],'nilai'=>$row[2],);
				}
				mysqli_free_result($result);
			}
			$Arr_Return = $data;
			break;
		case 'status_cuti':
			$sql = "select kode_1,info from ms_generate where tipe='status_cuti' order by id";
			if ($result = mysqli_query($con, $sql)) {
				while ($row = mysqli_fetch_row($result)) {
					$data[]=array('id'=>$row[0],'nama'=>$row[1]);
				}
				mysqli_free_result($result);
			}
			$Arr_Return = $data;
			break;
		case 'view_cuti':
			$employee_id='';
			$userid = $json_data->username;
			$userpass = $json_data->password;
			$id = $json_data->id;
			if($userid!='' && $userpass!='') {
				$sql = "select employee_id, username, id from users where md5(username)='".($userid)."' and password='".cryptSHA1($userpass)."' and flag_active='1' limit 1";
				if ($result = mysqli_query($con, $sql)) {
					while ($row = mysqli_fetch_row($result)) {
						$employee_id=$row[0];
						$username=$row[1];
						$usrid=$row[2];
					}
					mysqli_free_result($result);
				}
			}
			if($employee_id=='') {
				$Arr_Return = array('status' => 0, 'pesan' => 'User Name tidak ditemukan');
			} else {
				$sql = "select a.id, a.periode_year, a.unused_leave, a.get_year_leave, a.remaining_leave, a.sick_leave, a.doc_sick_leave, a.doc_sick_leave_2, a.doc_sick_leave_3, a.special_leave_category, a.special_leave, a.doc_special_leave, a.notpay_leave_desc, a.notpay_leave, a.doc_notpay_leave, a.applied_leave, a.from_date, a.until_date, a.total_days, a.descriptions, a.holiday_info, a.status, a.flag_leave_type, a.mass_leave_id, a.actual_leave, a.flag_alpha, a.alpha_value, a.alpha_date, a.note, a.approved_hr, b.name as special_leave_name from leave_applications a left join at_leaves b on a.special_leave_category=b.id where a.employee_id='".$employee_id."' and a.id='".$id."' limit 1";
				if ($result = mysqli_query($con, $sql)) {
					while ($row = mysqli_fetch_row($result)) {
						$data[]=array('id'=>$row[0],'periode_year'=>$row[1],'unused_leave'=>$row[2],'get_year_leave'=>$row[3],'remaining_leave'=>$row[4],'sick_leave'=>$row[5],'doc_sick_leave'=>$row[6],'doc_sick_leave_2'=>$row[7],'doc_sick_leave_3'=>$row[8],'special_leave_category'=>$row[9],'special_leave'=>$row[10],'doc_special_leave'=>$row[11],'notpay_leave_desc'=>$row[12],'notpay_leave'=>$row[13],'doc_notpay_leave'=>$row[14],'applied_leave'=>$row[15],'from_date'=>$row[16],'until_date'=>$row[17],'total_days'=>$row[18],'descriptions'=>$row[19],'holiday_info'=>$row[20],'status'=>$row[21],'flag_leave_type'=>$row[22],'mass_leave_id'=>$row[23],'actual_leave'=>$row[24],'flag_alpha'=>$row[25],'alpha_value'=>$row[26],'alpha_date'=>$row[27],'note'=>$row[28],'approved_hr'=>$row[29],'special_leave_name'=>$row[30],'url_doc'=>$urls.$folderPathCuti);
					}
					mysqli_free_result($result);
				}
				$Arr_Return = $data;
			}
			break;
		case 'list_cuti':
			$employee_id='';
			$userid = $json_data->username;
			$userpass = $json_data->password;
			$page= $json_data->page;
			if($page=='') $page=1;
			$halaman = 10;
			$mulai = ($page>1) ? ($page * $halaman) - $halaman : 0;
			if($userid!='' && $userpass!='') {
				$sql = "select employee_id, username, id from users where md5(username)='".($userid)."' and password='".cryptSHA1($userpass)."' and flag_active='1' limit 1";
				if ($result = mysqli_query($con, $sql)) {
					while ($row = mysqli_fetch_row($result)) {
						$employee_id=$row[0];
						$username=$row[1];
						$usrid=$row[2];
					}
					mysqli_free_result($result);
				}
			}
			if($employee_id=='') {
				$Arr_Return = array('status' => 0, 'pesan' => 'User Name tidak ditemukan');
			} else {
				$phones='';
				$sql = "select a.id, a.from_date, a.until_date, a.total_days, a.descriptions, a.status, a.approved_hr, a.name, a.category_name, a.divisions_name, a.approval_employee_id, b.info as ket_status, c.info as ket_approve_hr from view_leave_applications a left join (select kode_1,info from ms_generate where tipe='status_cuti') b on a.status=b.kode_1 left join (select kode_1,info from ms_generate where tipe='status_cuti') c on a.approved_hr=c.kode_1 where a.employee_id='".$employee_id."' order by a.id desc";//echo $sql ;
				if ($result = mysqli_query($con, $sql)) {
					$total=mysqli_num_rows($result);
					$pages = ceil($total/$halaman);
					mysqli_free_result($result);
					if ($result = mysqli_query($con, $sql." LIMIT ".$mulai.", ".$halaman ." ")) {
					  while ($row = mysqli_fetch_row($result)) {
						if($phones==''){
							$sql = "select hp from employees where id='".($row[10])."'";
							if ($rphonex = mysqli_query($con, $sql)) {
								while ($dtphone= mysqli_fetch_row($rphonex)) {
									$phones=$dtphone[0];
								}
								mysqli_free_result($rphonex);
							}else{
								$phones='error';
							}
						}
						$divisi = str_replace("&","%26",$row[9]);
						$text = "Dengan Hormat,%0aSaya yang bertanda tangan dibawah ini :%0a%0aNama : " . $row[7] . "%0aDivisi : " . $divisi . "%0a%0aBermaksud untuk mengajukan izin cuti " .  $row[8] . "pada tanggal " . $row[1]. " s/d " . $row[2] . " selama " . $row[3] . " hari.%0a%0aUntuk lebih detailnya bisa klik link dibawah ini:%0a" . $urls. "leavesapps/view/" . $row[0] . "%0a%0aDemikian surat izin cuti ini saya sampaikan. Atas perhatiannya saya ucapkan terima kasih.%0a%0aHormat Saya,%0a" . $row[7] ;

						$data[]=array('id'=>$row[0],'from_date'=>$row[1],'until_date'=>$row[2], 'total_days'=>$row[3], 'description'=>$row[4], 'status'=>$row[5], 'approved_hr'=>$row[6], 'ket_status'=>$row[11], 'ket_approve_hr'=>$row[12], 'wa_phone'=>$phones, 'wa_text'=>$text, 'page'=>$page, 'total_page'=>$pages );
					  }
					}
					mysqli_free_result($result);
				}
			}
			$Arr_Return = $data;
			break;
		case 'hari_libur':
			$start	= $json_data->from_date;
			$end	= $json_data->until_date;
			$datePeriod = new DatePeriod(
				new DateTime(date('Y-m-d', strtotime("0 day", strtotime($start)))),
				new DateInterval('P1D'),
				new DateTime(date('Y-m-d', strtotime("+1 day", strtotime($end))))
			);
			$holiday = [];
			$sql = "select date,`name` from at_holidays ";
			if ($result = mysqli_query($con, $sql)) {
				while ($row = mysqli_fetch_row($result)) {
					$dates = date('Ymd', strtotime($row[0]));
					$holiday[$dates] = $row[1];
				}
				mysqli_free_result($result);
			}
			$days = 0;
			$holiDay = [];
			foreach ($datePeriod as $dperiod) {
				$date = $dperiod->format('Ymd');
				if (isset($holiday[$date])) {
					$holiDay = [
						'holiday'   => date("Y-m-d", strtotime($date)),
						'deskripsi' => $holiday[$date]
					];
					// jika ada hari libur
				} elseif (date('D', strtotime($date)) === 'Sat') {
					// jika ada hari sabtu
				} elseif (date('D', strtotime($date)) === 'Sun') {
					// jika ada hari minggu
				} else {
					$days++;
				}
			}
			$Arr_Return = [
				'days'      => $days,
				'holiDay'   => $holiDay,
			];
			break;
		case 'simpan_cuti':
			$employee_id='';
			$userid = $json_data->username;
			$userpass = $json_data->password;
			if($userid!='' && $userpass!='') {
				$sql = "select employee_id, username, id from users where md5(username)='".($userid)."' and password='".cryptSHA1($userpass)."' and flag_active='1' limit 1";
				if ($result = mysqli_query($con, $sql)) {
					while ($row = mysqli_fetch_row($result)) {
						$employee_id=$row[0];
						$username=$row[1];
						$usrid=$row[2];
					}
					mysqli_free_result($result);
				}
			}
			if($employee_id=='') {
				$Arr_Return = array('status' => 0, 'pesan' => 'User Name tidak ditemukan');
			} else {
				$branch_id='';
				$periode_year=$json_data->periode_year;
				$unused_leave=$json_data->unused_leave;
				$get_year_leave=$json_data->get_year_leave;
				$remaining_leave=$json_data->remaining_leave;
				$sick_leave=$json_data->sick_leave;
				$doc_sick_leave=$json_data->doc_sick_leave;
				$special_leave_category=$json_data->special_leave_category;
				$special_leave=$json_data->special_leave;
				$doc_special_leave=$json_data->doc_special_leave;
				$notpay_leave_desc=$json_data->notpay_leave_desc;
				$notpay_leave=$json_data->notpay_leave;
				$doc_notpay_leave=$json_data->doc_notpay_leave;
				$applied_leave=$json_data->applied_leave;
				$from_date=$json_data->from_date;
				$until_date=$json_data->until_date;
				$total_days=$json_data->total_days;
				$descriptions=$json_data->descriptions;
				$holiday_info=$json_data->holiday_info;
				$status=$json_data->status;
				$no_revision=$json_data->no_revision;
				$flag_leave_type=$json_data->flag_leave_type;
				$created_by=$json_data->created_by;
				$created_at=$json_data->created_at;
				$doc_sick_leave_2=$json_data->doc_sick_leave_2;
				$doc_sick_leave_3=$json_data->doc_sick_leave_3;

				$doc_sick_leave_ext=$json_data->doc_sick_leave_ext;
				$doc_sick_leave_2_ext=$json_data->doc_sick_leave_2_ext;
				$doc_sick_leave_3_ext=$json_data->doc_sick_leave_3_ext;
				$doc_special_leave_ext=$json_data->doc_special_leave_ext;
				$doc_notpay_leave_ext=$json_data->doc_notpay_leave_ext;

				//file
				if($doc_sick_leave!='') {
					$fileName = $username.'_s1_'.time().''.uniqid().'.'.$doc_sick_leave_ext;
					$file = $folderPathCuti . $fileName;
					file_put_contents($file, base64_decode($doc_sick_leave));
					$doc_sick_leave=$fileName;
				}
				if($doc_sick_leave_2!='') {
					$fileName = $username.'_s2_'.time().''.uniqid().'.'.$doc_sick_leave_2_ext;
					$file = $folderPathCuti . $fileName;
					file_put_contents($file, base64_decode($doc_sick_leave_2));
					$doc_sick_leave_2=$fileName;
				}
				if($doc_sick_leave_3!='') {
					$fileName = $username.'_s3_'.time().''.uniqid().'.'.$doc_sick_leave_3_ext;
					$file = $folderPathCuti . $fileName;
					file_put_contents($file, base64_decode($doc_sick_leave_3));
					$doc_sick_leave_3=$fileName;
				}
				if($doc_special_leave!='') {
					$fileName = $username.'_sp_'.time().''.uniqid().'.'.$doc_special_leave_ext;
					$file = $folderPathCuti . $fileName;
					file_put_contents($file, base64_decode($doc_special_leave));
					$doc_special_leave=$fileName;
				}
				if($doc_notpay_leave!='') {
					$fileName = $username.'_np_'.time().''.uniqid().'.'.$doc_notpay_leave_ext;
					$file = $folderPathCuti . $fileName;
					file_put_contents($file, base64_decode($doc_notpay_leave));
					$doc_notpay_leave=$fileName;
				}
				$sql = "select `name`, division_id, company_id, division_head from employees where id='".$employee_id."' limit 1";
				if ($result = mysqli_query($con, $sql)) {
					while ($row = mysqli_fetch_row($result)) {
						$name=$row[0];
						$division_id=$row[1];
						$company_id=$row[2];
						$division_head=$row[3];
					}
					mysqli_free_result($result);
					$sql = "select branch_id from assign_user_company where user_id='".$usrid."' limit 1";
					if ($result = mysqli_query($con, $sql)) {
						while ($row = mysqli_fetch_row($result)) {
							$branch_id=$row[0];
						}
						mysqli_free_result($result);
					}
					$idMax=1;
					$sql = "SELECT MAX(RIGHT(id,4)) maxId FROM leave_applications WHERE SUBSTR(id,3, 2) = '" . date('y') . "' ORDER by id DESC";
					if ($result = mysqli_query($con, $sql)) {
						while ($row = mysqli_fetch_row($result)) {
							$idMax=($row[0]+1);
						}
						mysqli_free_result($result);
					}
					$docid='LA'.date('y').str_pad($idMax,4,"0",STR_PAD_LEFT);
					$sql = "insert into leave_applications (id, `name`, employee_id, division_id, company_id, branch_id, periode_year, unused_leave, get_year_leave, remaining_leave, sick_leave, doc_sick_leave, doc_sick_leave_2, doc_sick_leave_3, special_leave_category, special_leave, notpay_leave_desc, notpay_leave, applied_leave, from_date, until_date, total_days, descriptions, holiday_info, `status`, flag_leave_type, created_by, created_at, approval_by,doc_special_leave,doc_notpay_leave) values ('".$docid."', '".$name."', '".$employee_id."', '".$division_id."', '".$company_id."', '".$branch_id."', '".$periode_year."', '".$unused_leave."', '".$get_year_leave."', '".$remaining_leave."', '".$sick_leave."', '".$doc_sick_leave."', '".$doc_sick_leave_2."', '".$doc_sick_leave_3."', '".$special_leave_category."', '".$special_leave."', '".$notpay_leave_desc."', '".$notpay_leave."', '".$applied_leave."', '".$from_date."', '".$until_date."', '".$total_days."', '".$descriptions."', '".$holiday_info."', 'OPN', '".$flag_leave_type."','".$username."','".date('Y-m-d H:i:s')."','".$division_head."','".$doc_special_leave."','".$doc_notpay_leave."')";
//					echo  $sql;
					mysqli_query($con, $sql);
					$Arr_Return = array('status' => 1, 'pesan' => 'OK');
				} else {
					$Arr_Return = array('status' => 0, 'pesan' => 'NIK tidak ditemukan');
				}
			}
			break;
// absen
		case 'login':
			$name='';
			$userid = $json_data->username;
			$userpass = $json_data->password;
			if($userid!='' && $userpass!='') {
				$sql = "select employee_id,username from users where md5(username)='".($userid)."' and password='".cryptSHA1($userpass)."' and flag_active='1' limit 1";
				if ($result = mysqli_query($con, $sql)) {
					while ($row = mysqli_fetch_row($result)) {
						$name=$row[0];
						$username=$row[1];
					}
					mysqli_free_result($result);
				}
			}
			if($name==''){
				$Arr_Return = array('status' => 0, 'pesan' => 'User Name atau Password salah !');
			}else{
				$Arr_Return = array('status' => 1, 'pesan' => 'Login berhasil', 'id'=>$name, 'nama'=>$username);
			}
			break;
		case 'ctipe':
			$sql = "select kode_1,kode_2 from ms_generate where tipe='tipe_absen' and kode_1<>'9' order by kode_3";
			if ($result = mysqli_query($con, $sql)) {
				while ($row = mysqli_fetch_row($result)) {
					$data[]=array('id'=>$row[0],'nama'=>$row[1],);
				}
				mysqli_free_result($result);
			}
			$Arr_Return = $data;
			break;
		case 'standar':
			$sql = "select id,name from at_shifts where id like 'KERJA%' order by clock_in";
			if ($result = mysqli_query($con, $sql)) {
				$lokasi='Lab Cikarang';
				while ($row = mysqli_fetch_row($result)) {
					$data[]=array('id'=>$row[0],'waktu'=>$row[1],'nama'=>$lokasi);
					$lokasi='Kantor Cawang';
				}
				mysqli_free_result($result);
			}
			$Arr_Return = $data;
			break;
		case 'absensi':
			$userid = $json_data->username;
			$userpass = $json_data->password;
			$img = $json_data->image;
			$latitude = $json_data->latitude;
			$longitude = $json_data->longitude;
			$tipe = $json_data->ctipe;
			$standar = $json_data->standar;
			if($userid!='' && $userpass!='' && $latitude!='' && $longitude!='' && $tipe!='' && $img !=''){
				$sql = "select employee_id,username from users where md5(username)='".($userid)."' and password='".cryptSHA1($userpass)."' and flag_active='1' limit 1";
				if ($result = mysqli_query($con, $sql)) {
					while ($row = mysqli_fetch_row($result)) {
						$name=$row[0];
						$username=$row[1];
					}
					mysqli_free_result($result);
				}
				if($name==''){
					$Arr_Return = array('status' => 0, 'pesan' => 'User ID tidak ditemukan !');
				}else{
					if(($tipe== '1' && $standar=='') || ($tipe== '4' && $standar=='')){
						$Arr_Return = array('status' => 0, 'pesan' => 'Waktu absen kosong!');
					}else{
						$ceksingleabsen="";
/*
						$sql = "select waktu from absensi_log where (user_id)='".($username)."' and DATE(waktu)='".date("Y-m-d")."' and tipe='".$tipe."' limit 1";
						if ($result = mysqli_query($con, $sql)) {
							while ($row = mysqli_fetch_row($result)) {
								$ceksingleabsen=$row[0];
							}
							mysqli_free_result($result);
						}
*/
					  if($ceksingleabsen!=""){
						  $Arr_Return = array('status' => 0, 'pesan' => 'Anda sudah pernah absen pada jam '.$ceksingleabsen);
					  }else{
						$fileName = $username.''.time().''.uniqid().'.jpg';
						$file = $folderPath . $fileName;
						file_put_contents($file, base64_decode($img));
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
						$sql = "insert into absensi_log (employee_id,user_id,foto,waktu,latitude,longitude,tipe,jam_standar) values ('".$name."','".$username."','".$fileName."','".date("Y-m-d H:i:s")."','".$latitude."','".$longitude."','".$tipe."','".$jam_standar."')";
						mysqli_query($con, $sql);
						$Arr_Return = array('status' => 1, 'pesan' => date("d-m-Y H:i:s"));
					  }
					}
				}
			}else{
				if($img=='') $msgerror="Foto kosong";
				if($latitude=='') $msgerror="GPS tidak aktif";
				if($longitude=='') $msgerror="GPS tidak aktif";
				if($tipe=='') $msgerror="Absen tidak dipilih";
				if($userpass=='') $msgerror="Password kosong";
				if($userid=='') $msgerror="User ID kosong";
				$Arr_Return = array('status' => 0, 'pesan' => 'Data tidak lengkap! '. $msgerror);
			}
//			$sql = "insert api_log (info, waktu) values ('".$json_data."','".date("Y-m-d H:i:s")."')";
//			mysqli_query($con, $sql);
			break;
		default:
			$Arr_Return = array(
				'status'	=> 0,
				'pesan'		=> 'Access Denied !'
			);
	}
}else{
	$nav=$_GET['nav'];
	$datanya=json_encode($_GET);
	switch ($nav){
		case 'aplikasi':
			$name='';
			$userid = $_GET['username'];
			$userpass = $_GET['password'];
			if($userid!='' && $userpass!='') {
				$sql = "select username from users where md5(username)='".($userid)."' and password='".cryptSHA1($userpass)."' and flag_active='1' limit 1";
				if ($result = mysqli_query($con, $sql)) {
					while ($row = mysqli_fetch_row($result)) {
						$name=$row[0];
					}
					mysqli_free_result($result);
				}
			}
			if($name=='') {
				echo 'Access Denied !';
				die();
			} else {
				?>
				<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				 <head>
				  <title> Check Access </title>
				  <script src="https://sentral.dutastudy.com/hrsentral/adminlte/plugins/jQuery/jquery-2.2.3.min.js"></script>
					<style>
					html, body
					{
						height: 100%;
						margin:0;
						padding:0;
					}

					div {
						position:relative;
						height: 100%;
						width:100%;
					}

					div img {
						position:absolute;
						top:0;
						left:0;
						right:0;
						bottom:0;
						margin:auto;
					}
					</style>
				 </head>
				 <body>
					<div>
					  <img src="https://sentralsistem.com/assets/images/logo.jpg" border="0" alt="Sentral Sistem" />
					</div>
				  <form method="post" action="" id="form_proses" name="form_proses">
				  <input type="hidden" name="username" value="<?=$name?>" />
				  <input type="hidden" name="password" value="<?=$userpass?>" />  
				  </form>
				<script type="text/javascript">
				<!--
				$.ajax({
					url: 'dashboard/logout',
					type: "POST",
					cache: false,
					dataType: 'json',
					processData: false,
					contentType: false,
					success: function(data) {
						login();
					}
				});
				function login() {
					var formData = new FormData($('#form_proses')[0]);
					$.ajax({
						url: 'login',
						type: "POST",
						data: formData,
						cache: false,
						dataType: 'json',
						processData: false,
						contentType: false,
						success: function(data) {
							if (data.status == 1) {
								window.location.href = 'dashboard';
							}else{
								window.location.href = 'dashboard';
							}
						}
					});
				}
				login();
				//-->
				</script>
				 </body>
				</html>
				<?php
				die();
			}
			break;
		default:
			echo 'Access Denied !';
			die();
	}
}
show_message($Arr_Return);
?>