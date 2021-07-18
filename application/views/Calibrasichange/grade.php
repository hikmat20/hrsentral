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
				<label class='label-control col-sm-2'><b>Employee ID <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>              
						<?php
							echo form_input(array('readonly'=>'readonly','id'=>'id','name'=>'id','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Automatic'),$row[0]->id);											
						?>
					</div>
							
				</div>
				<label class='label-control col-sm-2'><b>Employee Name <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>              
						<?php
							echo form_input(array('id'=>'name','name'=>'name','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Employee Name'),$row[0]->name);											
						?>
					</div>
							
				</div>
			</div>
			<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>NIK<span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>              
						<?php
							echo form_input(array('id'=>'nik','name'=>'nik','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Automatic'),$row[0]->nik);											
						?>
					</div>
							
				</div>
				<label class='label-control col-sm-2'><b>Grade Name<span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>              
						<?php
							$data_companies[0]	= 'Select An Option';						
							echo form_dropdown('grade',$data_grade, $row[0]->grade, array('id'=>'grade','class'=>'form-control input-sm'));											
						?>
					</div>
				</div>
			</div>
			<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Start Date <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>              
						<?php
							echo form_input(array('id'=>'startcontract_date','name'=>'startcontract_date','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Start Date'));											
						
						?>
					</div>	
				</div>
			</div>
			<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Description <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>              
						<?php
							echo form_textarea(array('cols'=>'40','rows'=>'3','id'=>'descr','name'=>'descr','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Description'));											
						?>
					</div>	
				</div>
			</div>
						
			<div class='form-group row'>
				<label class='label-control col-sm-2'><b>Tanda&nbsp (<span class='text-red'>*</span>)&nbsp Wajib Diisi</b></label>
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
<style>
.chosen-container{
  width: 100% !important;
}
</style>
<script>
	
	$(document).ready(function(){
		
		
		$("#taxid").mask("99.999.999.9-999-999");
		
		
		$('#simpan-com').click(function(e){
			e.preventDefault();
			var nama	= $('#name').val();
			
			
			
			
			
			if(nama=='' || nama==null || nama=='0'){
				swal({
				  title	: "Error Message!",
				  text	: 'Empty Employee Name, please input Employee Name first.....',
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
						var baseurl=base_url + active_controller +'/grade';
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
		$('#company_id').change(function(){
			var comp	= $('#company_id').val();
			if(comp=='' || comp=='0' || comp==null){
				var Template	='<option value="">Empty List</option>';
				$('#division_id').html(Template).trigger('chosen:updated');
			}else{
				var baseurl=base_url + active_controller +'/getDetail/'+comp;
				$.ajax({
					url			: baseurl,
					type		: "GET",
					success		: function(data){
						var datas	= $.parseJSON(data);
						if($.isEmptyObject(datas)==true){
							var Template	='<option value="">Empty List</option>';
						}else{
							var Template	='<option value="">Select An Option</option>';
							$.each(datas,function(kode,nilai){
								Template	+='<option value="'+kode+'">'+nilai+'</option>';
							});
						}
						$('#division_id').html(Template).trigger('chosen:updated');
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
			}
			
		});
		$('#division_id').change(function(){
			var comp	= $('#division_id').val();
			if(comp=='' || comp=='0' || comp==null){
				var Template	='<option value="">Empty List</option>';
				$('#division_id').html(Template).trigger('chosen:updated');
			}else{
				var baseurl=base_url + active_controller +'/getDept/'+comp;
				$.ajax({
					url			: baseurl,
					type		: "GET",
					success		: function(data){
						var datas	= $.parseJSON(data);
						if($.isEmptyObject(datas)==true){
							var Template	='<option value="">Empty List</option>';
						}else{
							var Template	='<option value="">Select An Option</option>';
							$.each(datas,function(kode,nilai){
								Template	+='<option value="'+kode+'">'+nilai+'</option>';
							});
						}
						$('#department_id').html(Template).trigger('chosen:updated');
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
			}
			
		});
		$('#department_id').change(function(){
			var comp	= $('#department_id').val();
			if(comp=='' || comp=='0' || comp==null){
				var Template	='<option value="">Empty List</option>';
				$('#department_id').html(Template).trigger('chosen:updated');
			}else{
				var baseurl=base_url + active_controller +'/getTitle/'+comp;
				$.ajax({
					url			: baseurl,
					type		: "GET",
					success		: function(data){
						var datas	= $.parseJSON(data);
						if($.isEmptyObject(datas)==true){
							var Template	='<option value="">Empty List</option>';
						}else{
							var Template	='<option value="">Select An Option</option>';
							$.each(datas,function(kode,nilai){
								Template	+='<option value="'+kode+'">'+nilai+'</option>';
							});
						}
						$('#title_id').html(Template).trigger('chosen:updated');
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
			}
			
		});
		$(function () {	
		// Daterange Picker
		$('#hiredate').datepicker({
			dateFormat: 'yy-mm-dd',
				changeMonth:true,
				changeYear:true,
			    yearRange: 'c-80:c+100',
		});
	});
		
	});
	
</script>
<script>
	$(function () {	
		// Daterange Picker
		$('#startcontract_date').datepicker({
			dateFormat: 'yy-mm-dd',
				changeMonth:true,
				changeYear:true,
				yearRange: 'c-80:c+100',
			    
		});
	});
</script>
	
