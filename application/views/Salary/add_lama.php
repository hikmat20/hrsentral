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
							echo form_input(array('readonly'=>'readonly','id'=>'employee_id','name'=>'employee_id','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Employee Id'),$row[0]->id);											
						?>
					</div>
							
				</div>
			</div>
		<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Basic Salary<span class='text-red'>*</span></b></label> 
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>              
						
						<?php
							echo form_input(array('id'=>'pokok','name'=>'pokok','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Basic Salary'));											
						?>
					</div>
							
				</div>
		</div>
		<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Transport Allowance<span class='text-red'>*</span></b></label> 
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>              
						
						<?php
							echo form_input(array('id'=>'transport','name'=>'transport','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Transport Allowance'));											
						?>
					</div>
							
				</div>
		</div>
		
		<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Meal Allowance<span class='text-red'>*</span></b></label> 
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>              
						<?php
							echo form_input(array('id'=>'makan','name'=>'makan','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Meal Allowance'));											
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
