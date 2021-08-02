<?php
$action='';
$this->load->view('include/side_menu');
?>
<div id="alert_edit" class="alert alert-success alert-dismissable" style="padding: 15px; display: none;"></div>
<div class="box">
	<div class="box-body"><div class="table-responsive">
		<table id="mytabledata" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th>ID</th>
			<th>User ID</th>
			<th>Nama</th>
			<th>Waktu</th>
			<th>Tipe</th>
			<th>File</th>
			<th>Lokasi</th>
			<th>Detail</th>
		</tr>
		</thead>
		<tbody>
		</tbody>
		</table>
		</div>
	</div>
	<!-- /.box-body -->
</div>
<!-- Modal -->
<div class="modal modal-primary" id="dialog-popup" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Absensi Detail</h4>
      </div>
      <div class="modal-body" id="MyModalBody">
          <div class="box">
            <div class="box-body text-center text-black">
              <img id="idfoto" width="300" class="img-responsive img-thumbnail" src="<?=base_url("assets/img/karyawan/noimage.jpg")?>" alt="User Picture"><br />
              <h1 id="idnm_lengkap"></h1>
              <p id="idwaktu"></p>
              <p id="idtipe"></p>
            </div>
            <div class="box-footer hidden">
				<div id="map" style="height: 300px;width: 100%;"></div>
            </div>
            <!-- /.box-body -->
          </div>	  
	  <div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- page script -->
<?php $this->load->view('include/footer'); ?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyChx6yzXk2oKz95Qdon_jZzVJKmqBdlVDA"></script>
<script type="text/javascript">
	var siteurl			= '<?php echo base_url(); ?>';
	var active_controller	= 'absensi/';
     $(document).ready(function(){
        $('#mytabledata').DataTable({
          'processing': true,
          'serverSide': true,
          'serverMethod': 'post',
          'ajax': {
             'url': siteurl + active_controller + 'getDataJSON',
          },
          'columns': [
             { data: 'id' },
             { data: 'user_id' },
             { data: 'employee_id' },
             { data: 'waktu' },
             { data: 'tipe' },
             { data: 'foto' },
             { data: 'lokasi' },
             { data: 'detail' },
          ],
		  "order": [[3, 'desc']],
		  columnDefs: [ { orderable: false, targets: [7] }, { visible: false, targets: [0] },{"className": "text-center",targets: [5,6,7]} ],
        });
     });

  	function view_data(nm_lengkap,waktu,foto,latitude,longitude,tipe){
		$("#idnm_lengkap").html(nm_lengkap);
		$("#idwaktu").html(waktu);
		$("#idtipe").html(tipe);
		$("#idfoto").attr("src", "<?=base_url("data_absen/")?>"+foto);
		$("#idwaktu").html(waktu);
/*
        var panPoint = new google.maps.LatLng(latitude, longitude);
        map.panTo(panPoint);
		marker.setTitle("Nama :"+nm_lengkap+" | Absen :"+waktu);
		marker.setPosition(panPoint);
*/
		$("#dialog-popup").modal('show');
	}
</script>
<script>

/*var map;
function initialize(){
	var myCenter = new google.maps.LatLng(-6.243928791536213, 106.86912452203919);
	var mapProp = {
		center:myCenter,
		zoom:14,
		mapTypeId:google.maps.MapTypeId.ROADMAP
	};
	map = new google.maps.Map(document.getElementById("map"),mapProp);
	marker = new google.maps.Marker({
		position:myCenter,
//		animation:google.maps.Animation.BOUNCE
	});
	marker.setMap(map);
}
google.maps.event.addDomListener(window, 'load', initialize);
*/
</script>