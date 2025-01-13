<?php $Data_Session		= $this->session->userdata; ?>
<?php
$id_comp = $Data_Session['Company']->company_id;
$comp = $this->db->get_where('companies', ['id' => $id_comp])->row();
$listComp = $this->db->get_where('view_assign_company', ['user_id' => $Data_Session['User']['id']])->result();
// echo '<pre>';
// print_r($listComp);
// echo '<pre>';
// exit;
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>
		HR SYSTEM
	</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="<?php echo base_url('adminlte/bootstrap/css/bootstrap.min.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/fa/css/font-awesome.css') ?>">

	<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">  
    -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<link rel="stylesheet" href="<?php echo base_url('adminlte/plugins/daterangepicker/daterangepicker.css') ?>">
	<link rel="stylesheet" href="<?php echo base_url('adminlte/plugins/iCheck/all.css') ?>">
	<link rel="stylesheet" href="<?php echo base_url('jquery-ui/jquery-ui.min.css') ?>">
	<link rel="stylesheet" href="<?php echo base_url('adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('adminlte/plugins/datatables/dataTables.bootstrap.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('adminlte/dist/css/AdminLTE.min.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('adminlte/dist/css/custom.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('adminlte/dist/css/skins/_all-skins.min.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('chosen/chosen.min.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('sweetalert/dist/sweetalert.css'); ?>">
	<script src="<?php echo base_url('adminlte/plugins/jQuery/jquery-2.2.3.min.js'); ?>"></script>
	<!-- Bootstrap 3.3.6 -->
	<script src="<?php echo base_url('adminlte/bootstrap/js/bootstrap.min.js'); ?>"></script>
	<!-- DataTables -->
	<script src="<?php echo base_url('adminlte/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
	<script src="<?php echo base_url('adminlte/plugins/datatables/dataTables.bootstrap.min.js'); ?>"></script>
	<!-- FastClick -->
	<script src="<?php echo base_url('adminlte/plugins/fastclick/fastclick.js'); ?>"></script>
	<!-- date-range-picker -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
	<script src="<?php echo base_url('adminlte/plugins/daterangepicker/daterangepicker.js') ?>"></script>
	<!-- bootstrap datepicker -->
	<script src="<?php echo base_url('adminlte/plugins/datepicker/bootstrap-datepicker.js') ?>"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo base_url('adminlte/dist/js/app.min.js'); ?>"></script>
	<!-- Sparkline -->
	<script src="<?php echo base_url('adminlte/plugins/sparkline/jquery.sparkline.min.js'); ?>"></script>
	<!-- jvectormap -->
	<script src="<?php echo base_url('adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js'); ?>"></script>
	<script src="<?php echo base_url('adminlte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js'); ?>"></script>
	<!-- SlimScroll 1.3.0 -->
	<script src="<?php echo base_url('adminlte/plugins/slimScroll/jquery.slimscroll.min.js'); ?>"></script>
	<!-- ChartJS 1.0.1 -->
	<script src="<?php echo base_url('adminlte/plugins/chartjs/Chart.min.js'); ?>"></script>
	<script src="<?php echo base_url('jquery-ui/jquery-ui.min.js') ?>"></script>
	<!-- iCheck 1.0.1 -->
	<script src="<?php echo base_url('adminlte/plugins/iCheck/icheck.min.js') ?>"></script>
	<script src="<?php echo base_url('chosen/chosen.jquery.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/dist/event_keypress.js'); ?>"></script>
	<script src="<?php echo base_url('assets/dist/jquery.maskMoney.js'); ?>"></script>
	<script src="<?php echo base_url('assets/dist/jquery.maskedinput.min.js'); ?>"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="<?php echo base_url('adminlte/dist/js/demo.js'); ?>"></script>
	<script src="<?php echo base_url('sweetalert/dist/sweetalert.min.js'); ?>"></script>
	<!--<script src="<?php echo base_url('assets/dist/bootstrap-datepicker.min.js'); ?>"></script>!-->
</head>

<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
		<header class="main-header">
			<a href="<?php echo base_url('index.php/dashboard'); ?>" class="logo">
				<span class="logo-mini"><b>HRIS</b></span>
				<span class="logo-lg"><b>HR SYSTEM</b></span>
			</a>

			<nav class="navbar navbar-static-top">
				<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>
				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<li class="dropdown tasks-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
								<i class="fa fa-building"> </i> &nbsp
								<?= $comp->name; ?>
							</a>
							<?php
							if (count($listComp) > 0) : ?>
								<ul class="dropdown-menu">
									<li>
										<ul class="menu">
											<?php foreach ($listComp as $lComp) : ?>
												<li>
													<!-- Task item -->
													<a href="#">
														<h3><?= $lComp->name; ?></h3>
													</a>
												</li>
											<?php endforeach; ?>
										</ul>
									</li>
								</ul>
							<?php endif; ?>
						</li>
						<!-- <li class="dropdown tasks-menu">
							<a href="<?php echo base_url(); ?>dashboard/logout" data-role="qtip" title="Sign Out">
								<i class="fa fa-sign-out"></i>

							</a>
						</li> -->
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<img src="<?php 
								$profileimg=base_url('assets/img/avatar.png');
								if($Data_Session['User']['pict']!='') $profileimg=base_url('assets/profile/'.$Data_Session['User']['pict']);
								echo $profileimg; ?>" class="img-circle" alt="User Image" height="20px" width="20px">
								<span class="hidden-xs">
									<?php
									echo ucfirst($Data_Session['User']['username']);
									?>
								</span>
							</a>
							<ul class="dropdown-menu">
								<!-- User image -->
								<li class="user-header">
									<img src="<?php echo $profileimg; ?>" class="img-circle" alt="User Image">
									<p>
										<?php echo ucfirst($Data_Session['User']['username']); ?>
										<!-- <small>Member since <?php $tgl = strtotime($Data_Session['User']['created']);
																	$tgl2 = date("F Y ", $tgl);
																	echo $tgl2; ?></small> -->
									</p>
								</li>
								<!-- Menu Body -->
								<!-- Menu Footer-->
								<li class="user-footer">
									<div class="pull-left">
										<a href="<?=base_url('dashboard/profile')?>" class="btn btn-primary btn-block">Profile</a>
									</div>
									<div class="pull-right">
										<a href="<?= base_url() ?>dashboard/logout" class="btn btn-danger btn-block">Sign out</a>
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
		</header>
		<aside class="main-sidebar">
			</br>
			<section class="sidebar">
				<div class="user-panel">
					<div class="pull-left image">
						<img src="<?php echo $profileimg ?>" class="img-circle" alt="User Image" height="25px" width="25px">
					</div>
					<div class="pull-left info">
						<p><?php echo $Data_Session['Group']['name']; ?></p>
						<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
					</div>
				</div>
				<!--  Build Menu !-->
				<?php

				$Menus	= group_menus_access();

				render_left_menus($Menus);

				?>
			</section>
		</aside>
		<div class="content-wrapper">
			<section class="content">
				<div class="container-fluid-">
				    <?php if(isset($action)){ ?>
					<div class="row">
						<ol class="breadcrumb">
							<li><?php echo ucwords(strtolower($this->uri->segment(1))); ?></a></li>
							<li class="active">
								<a href="<?php echo base_url() . 'index.php/' . strtolower($this->uri->segment(1) . '/' . $action); ?>">
									<!--i class="fa fa-bars"></i--> <?php echo ucwords(strtolower($action)); ?>
								</a>
							</li>
						</ol>
					</div>
					<?php } ?>
					<div class="row">
						<div class="col-lg-12">
							<?php echo $this->session->flashdata('alert_data'); ?>