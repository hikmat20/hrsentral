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
              <p id="idnik"></p>
              <p id="idwaktu"></p>
              <p id="idtipe"></p>

              <strong><i class="fa fa-map-marker margin-r-5"></i> Lokasi</strong>
              <p id="idalamat" class="text-muted"></p>
            </div>
            <div class="box-footer">
				<div id="map_canvas" style="height: 300px;width: 100%;"></div>
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


var geocoder;
var map;
var geoMarker;

function initialize() {
    map = new google.maps.Map(
    document.getElementById("map_canvas"), {
      center: new google.maps.LatLng(-6.243928791536213, 106.86912452203919),
      zoom: 15,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
  geoMarker = new google.maps.Marker();
  geoMarker.setPosition(map.getCenter());
  geoMarker.setMap(map);
}
google.maps.event.addDomListener(window, "load", initialize);

  	function view_data(nm_lengkap,waktu,foto,latitude,longitude,tipe,nik){
		$("#idnm_lengkap").html(nm_lengkap);
		$("#idnik").html(nik);
		$("#idwaktu").html(waktu);
		$("#idtipe").html('Absen : '+tipe);
		$("#idfoto").attr("src", "<?=base_url("data_absen/")?>"+foto);
		$("#idwaktu").html(waktu);		
		position = new google.maps.LatLng(latitude, longitude);
		geoMarker.setPosition(position);
		map.setCenter(position, 15); 
		if(latitude!=''){
			var alamat=GetAddress(latitude,longitude);
		}else{
			$("#idalamat").html('NOT FOUND');
		}
		
		//geoMarker.setMap(map);
		$("#dialog-popup").modal('show');
	}

         function GetAddress(latitude,longitude) {
            var latlng = new google.maps.LatLng(latitude, longitude);
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'latLng': latlng }, function (results, status) {
//				console.log(results);
                if (status == 'OK') {
					$("#idalamat").html(results[0].formatted_address);
                }
				return;
            });
        }
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