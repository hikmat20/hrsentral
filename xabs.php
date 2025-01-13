<?php
error_reporting(0);
define('BASEPATH', 'system');
include 'application/config/development/database.php';
$con = mysqli_connect($db['default']['hostname'],$db['default']['username'],$db['default']['password'],$db['default']['database']);
if (mysqli_connect_errno()) {
	$Arr_Return = array('status' => 0, 'pesan' => 'Failed to connect to Database !');
	show_message($Arr_Return);
}
$sql = "SELECT a.id,a.name,a.nik,b.employee_id FROM hr_sentral.employees a left join hr_sentral.divisions_head b on a.division_head=b.id where a.company_id='COM003' and a.resign is null;";
if ($result = mysqli_query($con, $sql)) {
	while ($row = mysqli_fetch_row($result)) {
		$data[]=array('Id'=>$row[0],'Name'=>$row[1],'Designation'=>$row[2],'ImageUrl'=>'https://cdn0.iconfinder.com/data/icons/set-ui-app-android/32/8-512.png','IsExpand'=>true,'RatingColor'=>'#C34444','ReportingPerson'=>$row[3]);
	}
	mysqli_free_result($result);
}
$Arr_Return = $data;
echo json_encode($Arr_Return);
?>