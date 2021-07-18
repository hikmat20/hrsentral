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
				<label class='label-control col-sm-2'><b>Username <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>              
						<?php
							echo form_hidden('id',$rows_data[0]->id);
							echo form_input(array('id'=>'username','name'=>'username','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Username','readOnly'=>true),$rows_data[0]->username);											
						?>
					</div>
							
				</div>
				<label class='label-control col-sm-2'><b>Group <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>              
						<?php
							$data_group[0]	= 'Select An Option';						
							echo form_dropdown('group_id',$data_group, $rows_data[0]->group_id, array('id'=>'group_id','class'=>'form-control input-sm','disabled'=>true));											
						?>
					</div>
					
				</div>
			</div>
			
			<div class='form-group row'>						
				<label class='label-control col-sm-2'><b>View Salary</b></label>
				<div class='col-sm-4'>
				<?php
					$active		= ($rows_data[0]->flag_salary =='1')?TRUE:FALSE;
					$data = array(
							'name'          => 'flag_salary',
							'id'            => 'flag_salary',
							'value'         => '1',
							'disabled'		=>true,
							'checked'       => $active,
							'class'         => 'input-sm'
					);
	
					echo form_checkbox($data).'&nbsp;&nbsp;Yes';
					
				?>				
				</div>
				<label class='label-control col-sm-2'><b>Active</b></label>
				<div class='col-sm-4'>
				<?php
					$active		= ($rows_data[0]->flag_active =='1')?TRUE:FALSE;
					$data = array(
							'name'          => 'flag_active',
							'id'            => 'flag_active',
							'value'         => '1',
							'disabled'		=>true,
							'checked'       => $active,
							'class'         => 'input-sm'
					);
	
					echo form_checkbox($data).'&nbsp;&nbsp;Yes';
					
				?>				
				</div>
			</div>				
		</div>
		<div class='box-footer'>
			<?php
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
		
	});
</script>
