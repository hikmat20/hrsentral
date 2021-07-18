<?php
$this->load->view('include/side_menu'); 
//echo"<pre>";print_r($data_menu);
?> 
<form action="#" method="POST" id="form_proses_bro"> 
	<div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title"><?php echo $title;?></h3>		
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Group Name <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>              
						<?php
							echo form_hidden('id',$rows[0]->id);
							echo form_input(array('id'=>'name','name'=>'name','class'=>'form-control input-sm','autocomplete'=>'off','readOnly'=>true),$rows[0]->name);											
						?>
					</div>
							
				</div>
				<label class='label-control col-sm-2'><b>Description <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-list"></i></span>              
						<?php
							echo form_textarea(array('id'=>'descr','name'=>'descr','class'=>'form-control input-sm','cols'=>'75','rows'=>'1','autocomplete'=>'off','readOnly'=>true),$rows[0]->descr);
																	
						?>
					</div>
							
				</div>
			</div>			 
			<div class="box box-danger">
				<div class="box-header">
					<h3 class="box-title"><i class="fa fa-plus"></i> <span class="important">Access Company</span></h3>
				</div>
				<div class="box-body">					
					<table class="table table-bordered">
						<thead>
							<tr class='bg-blue'>
								
								<th class="text-center">Section</th>
								<th class="text-center">Name</th>
								<th class="text-center">
									<?php
										$data = array(
												'name'          => 'chk_all',
												'id'            => 'chk_all',
												'checked'       => false,
												'class'         => 'input-sm'
										);
						
										echo form_checkbox($data);
									?>
								</th>
							</tr>
						</thead>
						<tbody id="listDetail">
							<?php
							if(isset($rows_tree['sectionstatus']) && $rows_tree['sectionstatus']){
								$Count_Data		= count($rows_tree['sectionstatus']);
								for($x=1;$x<=$Count_Data;$x++){
									$det_Status		= $rows_tree['sectionstatus'][$x];
									$det_Name		= $rows_tree['sectionname'][$x];
									$det_ID			= $rows_tree['sectionid'][$x];
									$checked		= false;
									if($rows[0]->id == '1'){
										$checked		= true;
									}
									if($det_Status=='company'){
										echo'<tr style="background-color:#A2B5CD">';
										echo form_hidden('detail_akses['.$x.'][company_id]',$rows_tree['grppt'][$x]);
										
										$margin=0;
										if(isset($rows_akses['ArrComp']) && $rows_akses['ArrComp']){
											if(in_array($det_ID,$rows_akses['ArrComp'])){
												$checked=true;	
											}
										}
									}else if($det_Status=='division'){
										echo'<tr style="background-color:#BCD2EE">';
										echo form_hidden('detail_akses['.$x.'][company_id]',$rows_tree['grppt'][$x]);
										echo form_hidden('detail_akses['.$x.'][division_id]',$rows_tree['grpdiv'][$x]);
										
										$margin=50;
										if(isset($rows_akses['ArrDiv']) && $rows_akses['ArrDiv']){
											if(in_array($det_ID,$rows_akses['ArrDiv'])){
												$checked=true;	
											}
										}
									}else if($det_Status=='department'){
										echo'<tr style="background-color:#CAE1FF">';
										echo form_hidden('detail_akses['.$x.'][company_id]',$rows_tree['grppt'][$x]);
										echo form_hidden('detail_akses['.$x.'][division_id]',$rows_tree['grpdiv'][$x]);
										echo form_hidden('detail_akses['.$x.'][department_id]',$rows_tree['grpdept'][$x]);
										
										$margin=100;
										if(isset($rows_akses['ArrDept']) && $rows_akses['ArrDept']){
											if(in_array($det_ID,$rows_akses['ArrDept'])){
												$checked=true;	
											}
										}
									}else if($det_Status=='title'){
										echo'<tr style="background-color:#F1F1FE">';
										echo form_hidden('detail_akses['.$x.'][company_id]',$rows_tree['grppt'][$x]);
										echo form_hidden('detail_akses['.$x.'][division_id]',$rows_tree['grpdiv'][$x]);
										echo form_hidden('detail_akses['.$x.'][department_id]',$rows_tree['grpdept'][$x]);
										echo form_hidden('detail_akses['.$x.'][title_id]',$det_ID);
										
										$margin=150;
										if(isset($rows_akses['ArrTitle']) && $rows_akses['ArrTitle']){
											if(in_array($det_ID,$rows_akses['ArrTitle'])){
												$checked=true;	
											}
										}
									}
									
									//echo'<td class="text-center">'.$x.'</td>';
									echo'<td class="text-left text-bold">'.ucwords(strtolower($det_Status)).'</td>';
									echo'<td class="text-bold"><div style="margin-left:'.$margin.'px !important">'.$det_Name.'</div></td>';
									echo'<td class="text-center">';
										$data_opt = array(
												'name'          => 'detail_akses['.$x.'][flag_active]',
												'id'            => 'flag_active_'.$x,
												'value'         => '1',
												'checked'       => $checked,
												'class'         => 'input-sm'
										);
						
										echo form_checkbox($data_opt);
									echo'</td>';
									
								}
							}
								
							?>
						</tbody>
					</table>
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
		$('#chk_all').click(function(){
			if($('#chk_all').is(':checked')){
				$('#listDetail').find('input[type="checkbox"]').each(function(){
					$(this).prop('checked',true);
				});
			}else{
				$('#listDetail').find('input[type="checkbox"]').each(function(){
					$(this).prop('checked',false);
				});
			}
		});
		$('#simpan-bro').click(function(e){
			e.preventDefault();
			var int=0;
			$('#listDetail input[type=checkbox]').each(function(){
				if($(this).is(":checked")){
					int=1;
				}
				
			});
			if(int==0){
				swal({
				  title	: "Error Message!",
				  text	: 'No Access Company was selected, Please select access company first.........',
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
						var baseurl=base_url + active_controller +'/access_company';
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
