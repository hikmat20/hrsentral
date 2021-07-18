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
				<label class='label-control col-sm-2' readonly><b>Title Code <span class='text-red'>*</span></b> </label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>              
						<?php
							echo form_input(array('readonly'=>'readonly','id'=>'id','name'=>'id','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Departement Code'),$row[0]->id);											
						?>
					</div>
							
				</div>
			</div>
			<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Company Name<span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>              
						<?php
							$data_companies[0]	= 'Select An Option';						
							echo form_dropdown('company_id',$data_companies, $row[0]->company_id, array('id'=>'company_id','class'=>'form-control input-sm'));											
						?>
					</div>
				</div>
			</div>
			<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Division Name<span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>              
						<?php
							$data_div[0]	= 'Select An Option';						
							echo form_dropdown('division_id',$data_div, $row[0]->division_id, array('id'=>'division_id','class'=>'form-control input-sm'));											
						?>
					</div>
				</div>
			</div>
			<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Department Name<span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>              
						<?php
							$data_depart[0]	= 'Select An Option';						
							echo form_dropdown('department_id',$data_depart, $row[0]->department_id, array('id'=>'department_id','class'=>'form-control input-sm'));											
						?>
					</div>
				</div>
			</div>
			<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Title Name<span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>              
						<?php
							echo form_input(array('id'=>'name','name'=>'name','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Departement Name'),$row[0]->name);											
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
		$('#simpan-bro').click(function(){
			var id		= $('#id').val();
			var nama	= $('#name').val();
			if(nama=='' || nama==null){
				swal({
				  title	: "Error Message!",
				  text	: 'Empty Departement Name, please input Departement name first.....',
				  type	: "warning"
				});
				return false;
			}
			
			if(id=='' || id==null){
				swal({
				  title	: "Error Message!",
				  text	: 'Empty Departement Code, please input Departement Code first.....',
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
	});
</script>
