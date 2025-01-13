<?php
$this->load->view('include/side_menu');
$Data_Session = $this->session->userdata;
$user= $Data_Session['User']['momid'];
$query="SELECT pic FROM ".DBMOM.".tbl_meeting_detail WHERE (pic='$user' OR  (id_approval='$user' AND status=1)) AND status!=2";
$query = $this->db->query($query);
$open1= $query->num_rows();

$query="SELECT pic FROM ".DBMOM.".tbl_meeting_detail WHERE (pic='$user' OR  (id_approval='$user' AND status=1)) AND status!=2  AND due_date >=  NOW() ";
$query = $this->db->query($query);
$openontime1= $query->num_rows();

$query="SELECT pic FROM ".DBMOM.".tbl_meeting_detail WHERE (pic='$user' OR  (id_approval='$user' AND status=1) ) AND status!=2  AND due_date <  NOW() ";
$query = $this->db->query($query);
$openlate1= $query->num_rows();

$query="SELECT pic FROM ".DBMOM.".tbl_meeting_detail WHERE (pic='$user' OR  (id_approval='$user' AND status=1)) AND status=2 ";
$query = $this->db->query($query);
$close1= $query->num_rows();

$query="SELECT pic FROM ".DBMOM.".tbl_meeting_detail WHERE (pic='$user' OR (id_approval='$user' AND status=1)) AND status=2  AND due_date >=  done_date ";
$query = $this->db->query($query);
$closeontime1= $query->num_rows();

$query="SELECT pic FROM ".DBMOM.".tbl_meeting_detail WHERE (pic='$user' OR (id_approval='$user' AND status=1)) AND status =2  AND due_date <  done_date ";
$query = $this->db->query($query);
$closelate1= $query->num_rows();

$approval= $this->db->get_where(DBMOM.'.tbl_meeting_detail', array('id_approval'=>$user, 'status'=>1))->num_rows();
$appontime=$approval;
$applate = $this->db->get_where(DBMOM.'.tbl_meeting_detail', array('id_approval'=>$user, 'status'=>2))->num_rows();

?>
<div class="panel box-shadow" style="border-radius: 1em;">
	<section class="content">
	<h3>Action Plan</h3><hr />
	<table class="table">
	<tr class="info">
		<th colspan=2><b>OPEN</b></th>
	</tr>
	<tr>
		<td>&nbsp; &nbsp; ON PROGRESS</td>
		<td class="text-center"><?php echo $openontime1 ?></td>
	</tr>
	<tr>
		<td>&nbsp; &nbsp; LATE</td>
		<td class="text-center"><?php echo $openlate1 ?></td>
	</tr>

	<tr class="warning">
		<th colspan=2><b>CLOSE</b></th>
	</tr>
	<tr>
		<td>&nbsp; &nbsp; ON TIME</td>
		<td class="text-center"><?php echo $closeontime1 ?></td>
	</tr>
	<tr>
		<td>&nbsp; &nbsp; LATE</td>
		<td class="text-center"><?php echo $closelate1 ?></td>
	</tr>

	<tr class="success">
		<th colspan=2><b>APPROVAL</b></th>
	</tr>
	<tr>
		<td>&nbsp; &nbsp; WATING</td>
		<td class="text-center"><?php echo $appontime ?></td>
	</tr>
	<tr>
		<td>&nbsp; &nbsp; CLOSE</td>
		<td class="text-center"><?php echo $applate ?></td>
	</tr>
	</table>
	</section>
</div>
<?php $this->load->view('include/footer'); ?>
