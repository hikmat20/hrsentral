<?php
$this->load->view('include/side_menu');
$Data_Session = $this->session->userdata;
$profileimg=base_url('assets/img/avatar.png');
if($Data_Session['User']['pict']!='') $profileimg=base_url('assets/profile/'.$Data_Session['User']['pict']);
?>
<div class="panel box-shadow" style="border-radius: 1em;">
	<h3 class="text-center">Personal Activity</h3>
	<section class="content">
		<div class="row">
			<div class="hidden-xs col-md-1 text-center">
			</div>
			<div class="col-xs-6 col-md-4 text-center">
				<div class="small-box bg-aqua rounded-1 box-shadow" style="cursor:pointer;background-image:linear-gradient(hsl(210deg, 69%, 61%),hsl(210deg, 69%, 61%));" onclick="location.href = '<?= base_url('Dashboard/dashboard'); ?>'">
					<div class="inner" style="padding: 9px;">
						<h4 class="font-nunito">Dashboard</h4>
					</div>
					<div class="icon text-white-600">
						<i class="fa fa-file-text"></i>
					</div>
					<a href="<?= base_url('Dashboard/dashboard'); ?>" class="small-box-footer" style="border-radius: 1em;background:transparent;padding:10px 0px"> <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<div class="hidden-xs col-md-1 text-center">
			</div>
			<div class="col-xs-6 col-md-6 text-center">
				<a href="<?=base_url('dashboard/profile')?>">
				<img src="<?php echo $profileimg ?>" class="img-rounded profile-user-img img-responsive" alt="User Image" width="100">
				</a>
				<p>
					<?php 
					echo ucfirst($Data_Session['User']['username']); ?>
				</p>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6 col-md-3">
              <a class="btn btn-app btn-block bg-purple" href="<?=base_url()?>absensi/form_absen">
                <i class="fa fa-bell-o"></i> Absen
              </a>				
			</div>
			<div class="col-xs-6 col-md-3">
              <a class="btn btn-app btn-block bg-purple" href="<?=base_url()?>dashboard/action_plan">
                <i class="fa fa-check-square-o"></i> Action Plan
              </a>				
			</div>
			<div class="col-xs-6 col-md-3">
              <a class="btn btn-app btn-block bg-purple" href="<?=base_url()?>leavesapps/add">
                <i class="fa fa-sticky-note-o"></i> Cuti / Sakit
              </a>				
			</div>
			<div class="col-xs-6 col-md-3 hidden">
              <a class="btn btn-app btn-block bg-purple" href="<?=base_url()?>expense/transport_create">
                <i class="fa fa-automobile"></i> Transportasi
              </a>				
			</div>
			<div class="col-xs-6 col-md-3">
              <a class="btn btn-app btn-block bg-purple" href="<?=base_url()?>wfh/add">
                <i class="fa fa-home"></i> WFH
              </a>				
			</div>
			<div class="col-xs-6 col-md-3 hidden">
              <a class="btn btn-app btn-block bg-navy" href="<?=base_url()?>expense/create">
                <i class="fa fa-copy"></i> Expense Report
              </a>				
			</div>
			<div class="col-xs-6 col-md-3">
              <a class="btn btn-app btn-block bg-purple" href="<?=base_url()?>lembur/add">
                <i class="fa  fa-clock-o"></i> Lembur
              </a>				
			</div>
			<div class="col-xs-6 col-md-3 hidden">
              <a class="btn btn-app btn-block bg-navy" href="<?=base_url()?>expense/kasbon_create">
                <i class="fa fa-calculator"></i> Kasbon
              </a>				
			</div>
		</div>
	</section>
</div>
<?php $this->load->view('include/footer'); ?>
