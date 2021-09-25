<?php
$this->load->view('include/side_menu'); 
//echo"<pre>";print_r($data_companies);
?> 
<form action="#" method="POST" id="form_proses_bro">   

<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title">Input Allowances</h3>
	</div>
	<div class="box-body">
		<table class="table" width='100%'>
			<tr>
				
				<th width='20%'>Category</th>
				<th width='30%'>Allowances Name</th>
				
			</tr>
			<tr valign="top"  class='baris_1'>
				<td rowspan='1' class='id_1'>
				
						<?php
							$data_category[0]	= 'Select An Option';
                            $data_category[1]	= 'Harian';				
                            $data_category[2]	= 'Bulanan';											
							echo form_dropdown('kategori',$data_category, 0, array('id'=>'kategori','class'=>'form-control input-sm'));											
						?>
				</td>
				<td>
					<?php
							echo form_input(array('id'=>'name','name'=>'name','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Potongan Name'));											
						?>
				</td>
				
			</tr>
		</table>
	</div>
	<div class="box-footer">
		<?php
			echo form_button(array('type'=>'button','class'=>'btn btn-md btn-primary','value'=>'save','content'=>'Save','id'=>'simpan-bro')).' ';
			echo form_button(array('type'=>'button','class'=>'btn btn-md btn-danger','value'=>'back','content'=>'Back','onClick'=>'javascript:back()'));
		?>
	</div>
</div>


</form>

    <div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title"></h3>
		</div>
		<div class="box-body">
			<div id="data"></div>
		</div>
	</div>

<?php $this->load->view('include/footer'); ?>
<script>
	$(document).ready(function(){
		
		DataDetail();
		
		
		
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
									window.location.href = base_url + active_controller+'/add';
						            DataDetail();
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
	
	$(function () {	
		// Daterange Picker
		$('#year').datepicker({
			dateFormat: 'yy',
				changeMonth:true,
				changeYear:true,
				yearRange: 'c-80:c+100',
			    
		});
	});
	
	function DataDetail(){
			
		var	cari		= '';		
		 
		$.ajax({
			type	: "POST",
			url		: base_url + active_controller +'/load_detail',
			data	: "cari="+cari,
			success	: function(data){
				$("#data").html(data);
				$("#loading").fadeOut(100);	
		   		$("#data").fadeIn(500);	
				$('.select2').select2();
				$('.tanggal').datepicker({
					format: 'dd-M-yyyy',
					startDate: '0',
					autoclose: true,
					todayHighlight: true
				});
               					
			}
		});
	}
</script>
