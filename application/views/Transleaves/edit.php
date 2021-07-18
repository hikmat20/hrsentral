<?php
$this->load->view('include/side_menu'); 
//echo"<pre>";print_r($data_companies);
?> 
<form action="#" method="POST" id="form_proses_bro">   
	<div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title"><?=$title;?></h3>		
		</div>
		<!-- /.box-header -->
		<div class="box-body">
		<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Employee ID <span class='text-red'>*</span></b></label> 
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>              
						<?php
							echo form_input(array('readonly'=>'readonly','id'=>'employee_id','name'=>'employee_id','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Employee Id'),$row[0]->employee_id);											
						?>
					</div>
							
				</div>
		</div>
		<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Transaction ID <span class='text-red'>*</span></b></label> 
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>              
						<?php
							echo form_input(array('readonly'=>'readonly','id'=>'id','name'=>'id','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Id'),$row[0]->id);											
						?>
					</div>
							
				</div>
			</div>
		<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Period Leave<span class='text-red'>*</span></b></label> 
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>   
						
						<select name="year" id="year" class="form-control input-sm">
							<option value="<?php echo $row[0]->year ?>"><?php echo $row[0]->year ?></option>
							<?php
							$thn_skr = date('Y');
							for ($x = $thn_skr; $x >= 2010; $x--) {
							?>
								<option value="<?php echo $x ?>"><?php echo $x ?></option>
							<?php
							}
							?>
						</select>
						
						
						<?php
							//echo form_input(array('id'=>'year','name'=>'year','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Year'));											
						?>
					</div>
							
				</div>
		</div>
		<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Date From<span class='text-red'>*</span></b></label> 
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>              
						
						<?php
							echo form_input(array('id'=>'from','name'=>'from','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Date From'),$row[0]->from);											
						?>
					</div>
							
				</div>
		</div>
		<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Date Until<span class='text-red'>*</span></b></label> 
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>              
						
						<?php
							echo form_input(array('id'=>'until','name'=>'until','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Until'),$row[0]->until);											
						?>
					</div>
							
				</div>
		</div>
		<div class='form-group row'>
			    <label class='label-control col-sm-2'><b>Leave Name<span class='text-red'>*</span></b></label>
					<div class='col-sm-4'>
						<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>              
						<?php
							$data_leaves[0]	= 'Select An Option';						
							echo form_dropdown('leave_id',$data_leaves,$row[0]->leave_id, array('id'=>'leave_id','class'=>'form-control input-sm'));											
						?>
					</div>
					</div>
		</div>		
		<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Total Days <span class='text-red'>*</span></b></label> 
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>              
						<?php
							echo form_input(array('id'=>'leave','name'=>'leave','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Total Days'),$row[0]->leave);											
						?>
					</div>
							
				</div>
		</div>
		<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Description <span class='text-red'>*</span></b></label> 
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>              
						<?php
							echo form_input(array('id'=>'descr','name'=>'descr','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Description'),$row[0]->descr);											
						?>
					</div>
							
				</div>
		</div>						
		</div>
		
		<div class='box-footer'>
			<?php
			echo form_button(array('type'=>'button','class'=>'btn btn-md btn-primary','value'=>'save','content'=>'Save','id'=>'simpan-bro')).' ';
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
		$('#simpan-bro').click(function(e){
			e.preventDefault();
			
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
		
		
		$('#from, #until').on('change textInput input', function () {
        if ( ($("#from").val() != "") && ($("#until").val() != "")) {
            var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
            var firstDate = new Date($("#from").val());
            var secondDate = new Date($("#until").val());
            var diffDays = Math.round(Math.round((secondDate.getTime() - firstDate.getTime()) / (oneDay)));
			
			if (diffDays==0){
            $("#leave").val(1);
			}
			else
			{
			 $("#leave").val(diffDays);	
			}	
        }
    });
	});
	
	$(function () {	
		// Daterange Picker
		$('#from').datepicker({
			dateFormat: 'yy-mm-dd',
				changeMonth:true,
				changeYear:true,
				yearRange: 'c-80:c+100',
			    
		});
		$('#until').datepicker({
			dateFormat: 'yy-mm-dd',
				changeMonth:true,
				changeYear:true,
				yearRange: 'c-80:c+100',
			    
		});
	});
</script>
