<?php
$this->load->view('include/side_menu');
$Data_Session = $this->session->userdata;
$datauser=$this->db->select('*')->get_where('users', ['username' => $Data_Session['User']['username']])->row();
$profileimg=base_url('assets/img/avatar.png');
if($datauser->pict!='') $profileimg=base_url('assets/profile/'.$datauser->pict);
$ttd=base_url('assets/img/blank.png');
if($datauser->ttd!='') $ttd=base_url('assets/profile/'.$datauser->ttd);

?>
<link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet"/>
<script src="https://unpkg.com/cropperjs"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/4.0.0/css/jasny-bootstrap.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/4.0.0/js/jasny-bootstrap.min.js"></script>
<form method="post" action="<?=base_url('dashboard/profile_save')?>" class="form-horizontal" id="form-data" enctype="multipart/form-data" autocomplete="off">
<div class="panel box-shadow" style="border-radius: 1em;">
    <div class="panel-header">
        <h2 class="box-body"><?= $title; ?></h2>
    </div>
    <div class="panel-body">
		<input type="hidden" id="pict" name="pict" value="<?=($datauser->pict); ?>" />
		<input type="hidden" id="ttd" name="ttd" value="<?=($datauser->ttd); ?>" />
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="col-sm-5 control-label">User name</label>
					<div class="col-sm-7">
						<p class="form-control-static"><?=($Data_Session['User']['username']); ?></p>
					</div>
					<label class="col-sm-5 control-label">Password</label>
					<div class="col-sm-7">
						<input type="password" name="password" class="form-control" id="password" autocomplete="new-password" value="">
					</div>
				</div>
			</div>
			  <div class="col-md-4">
				<div class="fileinput fileinput-new" data-provides="fileinput">Profile
				  <div class="fileinput-new" style="width: 200px; height: 150px;" >
					<img src="<?php
					echo $profileimg;?>" alt="Profile Picture" width="200" height="150">
				  </div>
				  <div class="fileinput-preview fileinput-exists" style="max-width: 200px; max-height: 150px;"></div>
				  <div>
					<span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
					<input type="file" name="file_foto"></span>
					<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
				  </div>
				</div>
			  </div>
			  <div class="col-md-4">
				<div class="fileinput fileinput-new" data-provides="fileinput">Tanda tangan
				  <div class="fileinput-new" style="width: 200px; height: 150px;" >
					<img src="<?php echo $ttd;?>" alt="Profile Picture" width="200" height="150">
				  </div>
				  <div class="fileinput-preview fileinput-exists" style="max-width: 200px; max-height: 150px;"></div>
				  <div>
					<span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>
					<input type="file" name="file_ttd"></span>
					<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
				  </div>
				</div>
			  </div>
		</div>
	</div>
    <div class="panel-footer">
        <div class="row">
            <div class="col-md-6 text-center">
                <button type="submit" class="btn btn-primary" id="save"><i class="fa fa-save"></i> Save</button>
                <a href="<?=base_url('dashboard')?>" class="btn btn-default"><i class="fa fa-times"></i> Cancel</a>
            </div>
            <div class="col-md-6">
            </div>
        </div>
    </div>
</form>
</div>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">Crop Image</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="img-container">
					<div class="row">
						<div class="col-md-8">
							<img src="" id="sample_image" width="300"/>
						</div>
						<div class="col-md-4">
							<div class="preview"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-primary" id="crop">Crop</button>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('include/footer'); ?>
<script>
/*
$(document).ready(function(){	
	var $modal = $('#modal');
	var image = document.getElementById('sample_image');
	var cropper;
	$('#file_ttd').change(function(event){
    	var files = event.target.files;
    	var done = function (url) {
      		image.src = url;
      		$modal.modal('show');
    	};
    	if (files && files.length > 0)
    	{
			reader = new FileReader();
			reader.onload = function (event) {
				done(reader.result);
			};
			reader.readAsDataURL(files[0]);
    	}
	});
	$modal.on('shown.bs.modal', function() {
    	cropper = new Cropper(image, {
    		aspectRatio: 1,
    		viewMode: 3,
    		preview: '.preview'
    	});
	}).on('hidden.bs.modal', function() {
   		cropper.destroy();
   		cropper = null;
	});
	$("#crop").click(function(){
    	canvas = cropper.getCroppedCanvas({
      		width: 400,
      		height: 400,
    	});
    	canvas.toBlob(function(blob) {
        	var reader = new FileReader();
         	reader.readAsDataURL(blob); 
         	reader.onloadend = function() {
            	var base64data = reader.result;
---
            	$.ajax({
            		url: "upload.php",
                	method: "POST",                	
                	data: {image: base64data},
                	success: function(data){
                    	console.log(data);
                	}
              	});
---
				$modal.modal('hide');
//				alert(base64data);
				var img = document.getElementById('uploaded_image');
				img.src=base64data;
//				$('#uploaded_image').attr('src', base64data);
         	}
    	});
    });
	
});
*/
</script>