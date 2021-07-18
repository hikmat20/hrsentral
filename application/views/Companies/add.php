<?php
$this->load->view('include/side_menu'); 
//echo"<pre>";print_r($data_menu);
?> 
<form action="#" method="POST" id="form_proses_bro">   
	<div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title"><?=$title;?></h3>		
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Companies ID <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>              
						<?php
							echo form_input(array('readonly'=>'readonly','id'=>'id','name'=>'id','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Automatic'));											
						?>
					</div>
							
				</div>
				<label class='label-control col-sm-2'><b>Companies Name <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>              
						<?php
							echo form_input(array('id'=>'name','name'=>'name','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Companies Name'));											
						?>
					</div>
							
				</div>
			</div>
			<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Tax Id<span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-calculator"></i></span>              
						<?php
							echo form_input(array('id'=>'taxid','name'=>'taxid','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Tax Id'));											
						?>
					</div>
							
				</div>
				<label class='label-control col-sm-2'><b>Image <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-image"></i></span>              
						<?php
							echo form_input(array('type'=>'file','id'=>'image','name'=>'image','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Image'));											
						?>
					</div>
							
				</div>
			</div>
			
				<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Address<span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-book"></i></span>              
						<?php
							echo form_textarea(array('cols'=>'40','rows'=>'3','id'=>'address','name'=>'address','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Address'));											
						?>
					</div>
							
				</div>
				<label class='label-control col-sm-2'><b>City <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>              
						<?php
							echo form_input(array('id'=>'city','name'=>'city','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'City'));											
						?>
					</div>
							
				</div>
			</div>
			
			<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Province<span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>              
						<?php
							echo form_input(array('id'=>'province','name'=>'province','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Province'));											
						?>
					</div>
							
				</div>
				<label class='label-control col-sm-2'><b>Country <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>              
						<?php
							echo form_input(array('id'=>'country','name'=>'country','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Country'));											
						?>
					</div>	
				</div>
			</div>
			
			<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Phone<span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-phone"></i></span>              
						<?php
							echo form_input(array('id'=>'phone','name'=>'phone','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Phone'));											
						?>
					</div>	
				</div>
				<label class='label-control col-sm-2'><b>Fax <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-fax"></i></span>              
						<?php
							echo form_input(array('id'=>'fax','name'=>'fax','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Fax'));											
						?>
					</div>	
				</div>
			</div>
			<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Homepage<span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-home"></i></span>              
						<?php
							echo form_input(array('id'=>'homepage','name'=>'homepage','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Homepage'));											
						?>
					</div>
				</div>
				<label class='label-control col-sm-2'><b>Email</b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-at"></i></span>              
						<?php
							echo form_input(array('id'=>'email','name'=>'email','class'=>'form-control input-sm','value'=>'','placeholder'=>'Email'));										
						?>
					</div>
				
				</div>
					
				</div>
			</div>			
		</div>
		<div class='box-footer'>
			<?php
			echo form_button(array('type'=>'button','class'=>'btn btn-md btn-primary','value'=>'save','content'=>'Save','id'=>'simpan-com')).' ';
			echo form_button(array('type'=>'button','class'=>'btn btn-md btn-danger','value'=>'back','content'=>'Back','onClick'=>'javascript:back()'));
			?>
		</div>
		<!-- /.box-body -->
	 </div>
  <!-- /.box -->
</form>

<?php $this->load->view('include/footer'); ?>
<script>
	$(document).ready(function(){
		$('#simpan-com').click(function(e){
			e.preventDefault();
			var nama	= $('#name').val();
			var taxid	= $('#taxid').val();
			var image	= $('#image').val();
			var address	= $('#address').val();
			var city	= $('#city').val();
			var province= $('#province').val();
			var country	= $('#country').val();
			var phone	= $('#phone').val();
			var fax		= $('#fax').val();
			var homepage= $('#homepage').val();
			var email	= $('#email').val();
			
			
			if(nama=='' || nama==null){
				swal({
				  title	: "Error Message!",
				  text	: 'Empty Menu Name, please input Companies name first.....',
				  type	: "warning"
				});
				
				return false;
				
			}
			
			if(taxid=='' || taxid==null){
				swal({
				  title	: "Error Message!",
				  text	: 'Empty Tax Id, please input Tax Id  first.....',
				  type	: "warning"
				});
				
				return false;
			}
			if(address=='' || address==null){
				swal({
				  title	: "Error Message!",
				  text	: 'Empty Address, please input Address  first.....',
				  type	: "warning"
				});
				
				return false;
			}
			swal({
				  title: "Are you sure?",
				  text: "You will not be able to process again this data!",
				  type: "warning",
				  showCancelButton: true,
				  confirmButtonClass: "btn-danger",
				  confirmButtonText: "Yes, Process it!",
				  cancelButtonText: "No, cancel process!",
				  closeOnConfirm: true,
				  closeOnCancel: false
				},
				function(isConfirm) {
				  if (isConfirm) {
						loading_spinner();
						var formData 	=new FormData($('#form_proses_bro')[0]);
						var baseurl=base_url + active_controller +'/add';
						$.ajax({
							url			: baseurl,
							type		: "POST",
							data		: formData,
							cache		: false,
							dataType	: 'json',
							processData	: false, 
							contentType	: false,				
							success		: function(data){								
								if(data.status == 1){											
									swal({
										  title	: "Save Success!",
										  text	: data.pesan,
										  type	: "success",
										  timer	: 7000,
										  showCancelButton	: false,
										  showConfirmButton	: false,
										  allowOutsideClick	: false
										});
									window.location.href = base_url + active_controller;
								}else{
									
									if(data.status == 2){
										swal({
										  title	: "Save Failed!",
										  text	: data.pesan,
										  type	: "warning",
										  timer	: 7000,
										  showCancelButton	: false,
										  showConfirmButton	: false,
										  allowOutsideClick	: false
										});
									}else{
										swal({
										  title	: "Save Failed!",
										  text	: data.pesan,
										  type	: "warning",
										  timer	: 7000,
										  showCancelButton	: false,
										  showConfirmButton	: false,
										  allowOutsideClick	: false
										});
									}
									
								}
							},
							error: function() {
								
								swal({
								  title				: "Error Message !",
								  text				: 'An Error Occured During Process. Please try again..',						
								  type				: "warning",								  
								  timer				: 7000,
								  showCancelButton	: false,
								  showConfirmButton	: false,
								  allowOutsideClick	: false
								});
							}
						});
				  } else {
					swal("Cancelled", "Data can be process again :)", "error");
					return false;
				  }
			});
		});
	});
</script>
