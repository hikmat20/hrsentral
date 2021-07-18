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
							echo form_input(array('readonly'=>'readonly','id'=>'id','name'=>'id','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Automatic'),$row[0]->id);											
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
							echo form_dropdown('position_id',$data_position, $row[0]->position_id, array('id'=>'position_id','class'=>'form-control input-sm'));											
						?>
					</div>
				</div>
			</div>
			<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Late 5 Minute<span class='text-red'></span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<?php
						    $active		= ($row[0]->late5 =='Y')?TRUE:FALSE;
						  	$data = array(
									'name'          => 'late5',
									'id'            => 'late5',
									'checked'       => $active,
									'value'         => 'Y',
									'class'         => 'input-sm'
							);
			
							echo form_radio($data).'&nbsp;&nbsp;Yes';
							
						?>				
						<?php
							 $active		= ($row[0]->late5 =='N')?TRUE:FALSE;
						  	$data = array(
									'name'          => 'late5',
									'id'            => 'late5',
									'checked'       => $active,
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
						  
							$active		= ($row[0]->late15 =='Y')?TRUE:FALSE;
						  	$data = array(
									'name'          => 'late15',
									'id'            => 'late15',
									'checked'       => $active,
									'value'         => 'Y',
									'class'         => 'input-sm'
							);
			
							echo form_radio($data).'&nbsp;&nbsp;Yes';
							
						?>				
						<?php
							$active		= ($row[0]->late15 =='N')?TRUE:FALSE;
						  	$data = array(
									'name'          => 'late15',
									'id'            => 'late15',
									'checked'       => $active,
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
						  
							$active		= ($row[0]->late30 =='Y')?TRUE:FALSE;
						  	$data = array(
									'name'          => 'late30',
									'id'            => 'late30',
									'checked'       => $active,
									'value'         => 'Y',
									'class'         => 'input-sm'
							);
			
							echo form_radio($data).'&nbsp;&nbsp;Yes';
							
						?>				
						<?php
							$active		= ($row[0]->late30 =='N')?TRUE:FALSE;
						  	$data = array(
									'name'          => 'late30',
									'id'            => 'late30',
									'checked'       => $active,
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
						  
							$active		= ($row[0]->late60 =='Y')?TRUE:FALSE;
						  	$data = array(
									'name'          => 'late60',
									'id'            => 'late60',
									'checked'       => $active,
									'value'         => 'Y',
									'class'         => 'input-sm'
							);
			
							echo form_radio($data).'&nbsp;&nbsp;Yes';
							
						?>				
						<?php
							$active		= ($row[0]->late60 =='N')?TRUE:FALSE;
						  	$data = array(
									'name'          => 'late60',
									'id'            => 'late60',
									'checked'       => $active,
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
						  
							$active		= ($row[0]->late240 =='Y')?TRUE:FALSE;
						  	$data = array(
									'name'          => 'late240',
									'id'            => 'late240',
									'checked'       => $active,
									'value'         => 'Y',
									'class'         => 'input-sm'
							);
			
							echo form_radio($data).'&nbsp;&nbsp;Yes';
							
						?>				
						<?php
							$active		= ($row[0]->late240 =='N')?TRUE:FALSE;
						  	$data = array(
									'name'          => 'late240',
									'id'            => 'late240',
									'checked'       => $active,
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
						  
							$active		= ($row[0]->izinpagi =='Y')?TRUE:FALSE;
						  	$data = array(
									'name'          => 'izinpagi',
									'id'            => 'izinpagi',
									'checked'       => $active,
									'value'         => 'Y',
									'class'         => 'input-sm'
							);
			
							echo form_radio($data).'&nbsp;&nbsp;Yes';
							
						?>				
						<?php
							$active		= ($row[0]->izinpagi =='N')?TRUE:FALSE;
						  	$data = array(
									'name'          => 'izinpagi',
									'id'            => 'izinpagi',
									'checked'       => $active,
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
						  
							$active		= ($row[0]->izinsore =='Y')?TRUE:FALSE;
						  	$data = array(
									'name'          => 'izinsore',
									'id'            => 'izinsore',
									'checked'       => $active,
									'value'         => 'Y',
									'class'         => 'input-sm'
							);
			
							echo form_radio($data).'&nbsp;&nbsp;Yes';
							
						?>				
						<?php
							$active		= ($row[0]->izinsore =='N')?TRUE:FALSE;
						  	$data = array(
									'name'          => 'izinsore',
									'id'            => 'izinsore',
									'checked'       => $active,
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
						  
							$active		= ($row[0]->transport =='Y')?TRUE:FALSE;
						  	$data = array(
									'name'          => 'transport',
									'id'            => 'transport',
									'checked'       => $active,
									'value'         => 'Y',
									'class'         => 'input-sm'
							);
			
							echo form_radio($data).'&nbsp;&nbsp;Yes';
							
						?>				
						<?php
							$active		= ($row[0]->transport =='N')?TRUE:FALSE;
						  	$data = array(
									'name'          => 'transport',
									'id'            => 'transport',
									'checked'       => $active,
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
						  
							$active		= ($row[0]->insentif =='Y')?TRUE:FALSE;
						  	$data = array(
									'name'          => 'insentif',
									'id'            => 'insentif',
									'checked'       => $active,
									'value'         => 'Y',
									'class'         => 'input-sm'
							);
			
							echo form_radio($data).'&nbsp;&nbsp;Yes';
							
						?>				
						<?php
							$active		= ($row[0]->insentif =='N')?TRUE:FALSE;
						  	$data = array(
									'name'          => 'insentif',
									'id'            => 'insentif',
									'checked'       => $active,
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
						var baseurl=base_url + active_controller +'/edit';
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
