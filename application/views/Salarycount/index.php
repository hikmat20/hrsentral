<?php
$this->load->view('include/side_menu'); 
//echo"<pre>";print_r($data_companies);
?> 
<?php echo form_open('salarycount/search') ?>
	<div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title"><?=$title;?></h3>		
		</div>
		<!-- /.box-header -->
		
		<div class="box-body">
			<div class="box box-danger">
				<div class="box-header">
					<!--<h3 class="box-title">
						<i class="fa fa-star"></i> <?php echo('<span class="important">Search Absensi Report </span>'); ?>
					</h3>-->
				</div>
				<div class="clearfix box-body">
					<div class='form-group row'>			
						<label class='label-control col-sm-2'><b>Periode <span class='text-red'>*</span></b></label> 
						<div class='col-sm-4'>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>              
								<?php
									echo form_input(array('id'=>'first_date','name'=>'first_date','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'First Date'));											
								?>
								
								<h3 class="input-group-addon">S/D</h3>
							
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>              
								<?php
									echo form_input(array('id'=>'second_date','name'=>'second_date','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Second Date'));											
								?>
							</div>
								
						</div>
					</div>
				</div>
			</div>
			<div class='box-footer'>
				<?php
				echo form_button(array('type'=>'submit','class'=>'btn btn-md btn-primary','value'=>'save','content'=>'Search','id'=>'simpan-bro')).' ';
				//echo form_button(array('type'=>'button','class'=>'btn btn-md btn-danger','value'=>'back','content'=>'Back','onClick'=>'javascript:back()'));
				?>
			</div>
		</div>
		
		<!-- /.box-body -->
	 </div>
  <!-- /.box -->
<?php echo form_close() ?>


<?php $this->load->view('include/footer'); ?>
<script>
	
	$(function () {	
		// Daterange Picker
		$('#first_date').datepicker({
			dateFormat: 'yy-mm-dd',
				changeMonth:true,
				changeYear:true,
				yearRange: 'c-80:c+100',
			    
		});
		$('#second_date').datepicker({
			dateFormat: 'yy-mm-dd',
				changeMonth:true,
				changeYear:true,
				yearRange: 'c-80:c+100',
			    
		});
	});
</script>