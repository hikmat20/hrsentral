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
				<label class='label-control col-sm-2'><b>Position ID <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>              
						<?php
							echo form_input(array('readonly'=>'readonly','id'=>'id','name'=>'id','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Automatic'));											
						?>
					</div>
							
				</div>
				
			</div>
			<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Position Name<span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>              
						<?php
							$data_position[0]	= 'Select An Option';						
							echo form_dropdown('position_id',$data_position, '0', array('id'=>'position_id','class'=>'form-control input-sm'));											
						?>
					</div>
				</div>
			</div>
			<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Late 5 Minute<span class='text-red'></span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<?php
						  
							$data = array(
									'name'          => 'late5',
									'id'            => 'late5',
									'checked'       => 'checked',
									'value'         => 'Y',
									'class'         => 'input-sm'
							);
			
							echo form_radio($data).'&nbsp;&nbsp;Yes';
							
						?>				
						<?php
							$data = array(
									'name'          => 'late5',
									'id'            => 'late5',
									'value'         => 'N',
									'class'         => 'input-sm'
							);
			
							echo form_radio($data).'&nbsp;&nbsp;No';
							
						?>	
						
					</div>
				</div>
			</div>
			<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Late 15 Minute<span class='text-red'></span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<?php
						  
							$data = array(
									'name'          => 'late15',
									'id'            => 'late15',
									'checked'       => 'checked',
									'value'         => 'Y',
									'class'         => 'input-sm'
							);
			
							echo form_radio($data).'&nbsp;&nbsp;Yes';
							
						?>				
						<?php
							$data = array(
									'name'          => 'late15',
									'id'            => 'late15',
									'value'         => 'N',
									'class'         => 'input-sm'
							);
			
							echo form_radio($data).'&nbsp;&nbsp;No';
							
						?>	
						
					</div>
				</div>
			</div>
			<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Late 30 Minute<span class='text-red'></span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<?php
						  
							$data = array(
									'name'          => 'late30',
									'id'            => 'late30',
									'checked'       => 'checked',
									'value'         => 'Y',
									'class'         => 'input-sm'
							);
			
							echo form_radio($data).'&nbsp;&nbsp;Yes';
							
						?>				
						<?php
							$data = array(
									'name'          => 'late30',
									'id'            => 'late30',
									'value'         => 'N',
									'class'         => 'input-sm'
							);
			
							echo form_radio($data).'&nbsp;&nbsp;No';
							
						?>	
						
					</div>
				</div>
			</div>
			<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Late 60 Minute<span class='text-red'></span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<?php
						  
							$data = array(
									'name'          => 'late60',
									'id'            => 'late60',
									'checked'       => 'checked',
									'value'         => 'Y',
									'class'         => 'input-sm'
							);
			
							echo form_radio($data).'&nbsp;&nbsp;Yes';
							
						?>				
						<?php
							$data = array(
									'name'          => 'late60',
									'id'            => 'late60',
									'value'         => 'N',
									'class'         => 'input-sm'
							);
			
							echo form_radio($data).'&nbsp;&nbsp;No';
							
						?>	
						
					</div>
				</div>
			</div>
			<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Late 240 Minute<span class='text-red'></span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<?php
						  
							$data = array(
									'name'          => 'late240',
									'id'            => 'late240',
									'checked'       => 'checked',
									'value'         => 'Y',
									'class'         => 'input-sm'
							);
			
							echo form_radio($data).'&nbsp;&nbsp;Yes';
							
						?>				
						<?php
							$data = array(
									'name'          => 'late240',
									'id'            => 'late240',
									'value'         => 'N',
									'class'         => 'input-sm'
							);
			
							echo form_radio($data).'&nbsp;&nbsp;No';
							
						?>	
						
					</div>
				</div>
			</div>
			<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Izin Pagi<span class='text-red'></span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<?php
						  
							$data = array(
									'name'          => 'izinpagi',
									'id'            => 'izinpagi',
									'checked'       => 'checked',
									'value'         => 'Y',
									'class'         => 'input-sm'
							);
			
							echo form_radio($data).'&nbsp;&nbsp;Yes';
							
						?>				
						<?php
							$data = array(
									'name'          => 'izinpagi',
									'id'            => 'izinpagi',
									'value'         => 'N',
									'class'         => 'input-sm'
							);
			
							echo form_radio($data).'&nbsp;&nbsp;No';
							
						?>	
						
					</div>
				</div>
			</div>
			<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Izin Sore<span class='text-red'></span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<?php
						  
							$data = array(
									'name'          => 'izinsore',
									'id'            => 'izinsore',
									'checked'       => 'checked',
									'value'         => 'Y',
									'class'         => 'input-sm'
							);
			
							echo form_radio($data).'&nbsp;&nbsp;Yes';
							
						?>				
						<?php
							$data = array(
									'name'          => 'izinsore',
									'id'            => 'izinsore',
									'value'         => 'N',
									'class'         => 'input-sm'
							);
			
							echo form_radio($data).'&nbsp;&nbsp;No';
							
						?>	
						
					</div>
				</div>
			</div>
			<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Transport<span class='text-red'></span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<?php
						  
							$data = array(
									'name'          => 'transport',
									'id'            => 'transport',
									'checked'       => 'checked',
									'value'         => 'Y',
									'class'         => 'input-sm'
							);
			
							echo form_radio($data).'&nbsp;&nbsp;Yes';
							
						?>				
						<?php
							$data = array(
									'name'          => 'transport',
									'id'            => 'transport',
									'value'         => 'N',
									'class'         => 'input-sm'
							);
			
							echo form_radio($data).'&nbsp;&nbsp;No';
							
						?>	
						
					</div>
				</div>
			</div>
			<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Insentif<span class='text-red'></span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<?php
						  
							$data = array(
									'name'          => 'insentif',
									'id'            => 'insentif',
									'checked'       => 'checked',
									'value'         => 'Y',
									'class'         => 'input-sm'
							);
			
							echo form_radio($data).'&nbsp;&nbsp;Yes';
							
						?>				
						<?php
							$data = array(
									'name'          => 'insentif',
									'id'            => 'insentif',
									'value'         => 'N',
									'class'         => 'input-sm'
							);
			
							echo form_radio($data).'&nbsp;&nbsp;No';
							
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
			var id		= $('#id').val();
			var nama	= $('#position_id').val();
			
			
			if(nama=='' || nama==null){
				swal({
				  title	: "Error Message!",
				  text	: 'Empty Position Name, please input Position name first.....',
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
