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
				<label class='label-control col-sm-2'><b>Company Name<span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>              
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
						<span class="input-group-addon"><i class="fa fa-file"></i></span>              
						<?php
							$data_divisions[0]	= 'Select An Option';						
							echo form_dropdown('division_id',$data_divisions, $row[0]->division_id, array('id'=>'division_id','class'=>'form-control input-sm'));											
						?>
					</div>
				</div>
				<label class='label-control col-sm-2'><b>Departement Name<span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>              
						<?php
							$data_department[0]	= 'Select An Option';						
							echo form_dropdown('department_id',$data_department, $row[0]->department_id, array('id'=>'department_id','class'=>'form-control input-sm'));											
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
							$data_title[0]	= 'Select An Option';						
							echo form_dropdown('title_id',$data_title, $row[0]->title_id, array('id'=>'title_id','class'=>'form-control input-sm'));											
						?>
					</div>
				</div>
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
				<label class='label-control col-sm-2'><b>Place Of Birth <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>              
						<?php
							echo form_input(array('id'=>'hometown','name'=>'hometown','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Hometown'),$row[0]->hometown);											
						?>
					</div>	
				</div>
				
				<label class='label-control col-sm-2'><b>Date Of Birth <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>              
						<?php
							echo form_input(array('id'=>'birthday','name'=>'birthday','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Birthday'),$row[0]->birthday);											
						
						?>
					</div>
							
				</div>
				
			</div>
			<div class='form-group row'>
			    <label class='label-control col-sm-2'><b>Religion <span class='text-red'>*</span></b></label>
					<div class='col-sm-4'>
						<div class='input-group'>
							<span class='input-group-addon'><i class='fa fa-user'></i></span> 
							<?php
							$relid[0]	= 'Select An Option';	
							$relid[1]	= 'Islam';
							$relid[2]	= 'Katolik';
							$relid[3]	= 'Kristen';
							$relid[4]	= 'Hindu';
							$relid[5]	= 'Budha';
							$relid[6]	= 'Kong Hu Chu';
							echo form_dropdown('relid',$relid, $row[0]->relid, array('id'=>'relid','class'=>'form-control input-sm'));											
							?>
						</div>
					</div>
				<label class='label-control col-sm-2'><b>Gender</b></label>
				<div class='col-sm-4'>
				<?php
				    $active		= ($row[0]->genderid =='L')?TRUE:FALSE;
					$data = array(
							'name'          => 'genderid',
							'id'            => 'genderid',
							'checked'       => $active,
							'value'         => 'L',
							'class'         => 'input-sm'
					);
	
					echo form_radio($data).'&nbsp;&nbsp;Male';
					
				?>				
				<?php
					$active		= ($row[0]->genderid =='P')?TRUE:FALSE;
					$data = array(
							'name'          => 'genderid',
							'id'            => 'genderid',
							'checked'       => $active,
							'value'         => 'P',
							'class'         => 'input-sm'
					);
	
					echo form_radio($data).'&nbsp;&nbsp;Female';
					
				?>				
				</div>
			</div>
			<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Stay Address<span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-book"></i></span>              
						<?php
							echo form_textarea(array('cols'=>'40','rows'=>'3','id'=>'address','name'=>'address','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Address'),$row[0]->address);											
						?>
					</div>
							
				</div>
				<label class='label-control col-sm-2'><b>City <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>              
						<?php
							echo form_input(array('id'=>'city','name'=>'city','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'City'),$row[0]->city);											
						?>
					</div>
							
				</div>
			</div>
			
			<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Province<span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>              
						<?php
							echo form_input(array('id'=>'province','name'=>'province','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Province'),$row[0]->province);											
						?>
					</div>
							
				</div>
				<label class='label-control col-sm-2'><b>Post Code <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>              
						<?php
							echo form_input(array('id'=>'postcode','name'=>'postcode','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Post code'),$row[0]->postcode);											
						?>
					</div>	
				</div>
			</div>
			<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Nationality<span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>              
						<?php
							echo form_input(array('id'=>'nationality','name'=>'nationality','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Nationality'),$row[0]->nationality);											
						?>
					</div>
							
				</div>
				<label class='label-control col-sm-2'><b>License Id <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>              
						<?php
							echo form_input(array('id'=>'licensid','name'=>'licensid','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'License Id'),$row[0]->licensid);											
						?>
					</div>	
				</div>
			</div>
			<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>IdCard Address<span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-book"></i></span>              
						<?php
							echo form_textarea(array('cols'=>'40','rows'=>'3','id'=>'idcard_address','name'=>'idcard_address','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'IdCard Address'),$row[0]->idcard_address);											
						?>
					</div>
							
				</div>
				<label class='label-control col-sm-2'><b>Tax ID <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>              
						<?php
							echo form_input(array('id'=>'taxid','name'=>'taxid','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'taxid'),$row[0]->taxid);											
						?>
					</div>
							
				</div>
			</div>
			<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Phone Number<span class='text-red'></span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-phone"></i></span>              
						<?php
							echo form_input(array('id'=>'phone','name'=>'phone','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Phone Number'),$row[0]->phone);											
						?>
					</div>	
				</div>
				<label class='label-control col-sm-2'><b>Handphone Number <span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-phone"></i></span>              
						<?php
							echo form_input(array('id'=>'hp','name'=>'hp','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Handphone Number'),$row[0]->hp);											
						?>
					</div>	
				</div>
			</div>
			<div class='form-group row'>			
				<label class='label-control col-sm-2'><b>Hire Date<span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>              
						<?php
							echo form_input(array('id'=>'hiredate','name'=>'hiredate','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Hire Date'),$row[0]->hiredate);											
						?>
					</div>
				</div>
				<label class='label-control col-sm-2'><b>Marital Status<span class='text-red'>*</span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file"></i></span>              
						<?php
							$data_marital[0]	= 'Select An Option';						
							echo form_dropdown('marital_status',$data_marital,$row[0]->marital_status, array('id'=>'marital_status','class'=>'form-control input-sm'));											
						?>
					</div>
				</div>
			</div>
			<div class='form-group row'>			
				
				<label class='label-control col-sm-2'><b>Bank Id<span class='text-red'></span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-building"></i></span>              
						<?php
						echo form_input(array('id'=>'bank_id','name'=>'bank_id','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Bank id'),$row[0]->bank_id);						?>
					</div>
				
				</div>
				<label class='label-control col-sm-2'><b>Account Number<span class='text-red'></span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-credit-card"></i></span>              
						<?php
							echo form_input(array('id'=>'accnumber','name'=>'accnumber','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Account Number'),$row[0]->accnumber);											
						?>
					</div>
				</div>	
			</div>
			<div class='form-group row'>			
				
				<label class='label-control col-sm-2'><b>Account Name<span class='text-red'></span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-credit-card"></i></span>              
						<?php
						echo form_input(array('id'=>'accname','name'=>'accname','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Account name'),$row[0]->accname);						?>
					</div>
				
				</div>
				<label class='label-control col-sm-2'><b>Health Number Of BPJS <span class='text-red'></span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-credit-card"></i></span>              
						<?php
							echo form_input(array('id'=>'bpjs_kes','name'=>'bpjs_kes','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Health Number Of BPJS'),$row[0]->bpjs_kes);											
						?>
					</div>
				</div>	
			</div>
			<div class='form-group row'>			
				
				<label class='label-control col-sm-2'><b>Employee Number Of BPJS <span class='text-red'></span></b></label>
				<div class='col-sm-4'>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-credit-card"></i></span>              
						<?php
							echo form_input(array('id'=>'bpjs_ket','name'=>'bpjs_ket','class'=>'form-control input-sm','autocomplete'=>'off','placeholder'=>'Employee Number Of BPJS'),$row[0]->bpjs_ket);											
						?>
					</div>
				
				</div>
				<label class='label-control col-sm-2'><b>Active</b></label>
				<div class='col-sm-4'>
				<?php
				    $active		= ($row[0]->flag_active =='Y')?TRUE:FALSE;
					$data = array(
							'name'          => 'flag_active',
							'id'            => 'flag_active',
							'checked'       => $active,
							'value'         => 'Y',
							'class'         => 'input-sm'
					);
	
					echo form_radio($data).'&nbsp;&nbsp;Yes';
					
				?>				
				<?php
					$active		= ($row[0]->flag_active =='N')?TRUE:FALSE;
					$data = array(
							'name'          => 'flag_active',
							'id'            => 'flag_active',
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
		<!-- /.box-body -->
	 </div>
  <!-- /.box -->
</form>
