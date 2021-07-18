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

</head>
<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
		<header class="main-header">
			<a href="#" class="logo">      
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
							<a href="<?php echo base_url(); ?>index.php/dashboard/logout" data-role="qtip" title="Sign Out">
							  <i class="fa fa-sign-out"></i>
							  
							</a>
						</li>
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<img src="<?php echo base_url('assets/img/avatar.png') ?>" class="img-circle" alt="User Image" height="20px" width="20px">
								
								<span class="hidden-xs">
								<?php 
									$Data_Session		= $this->session->userdata;
									
									echo $Data_Session['User']['username']; 
								?>
								</span>
							</a>							
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
					  <img src="<?php echo base_url('assets/img/avatar.png') ?>" class="img-circle" alt="User Image" height="25px" width="25px">
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
				<div class="container-fluid">
					<div class="row">
						<ol class="breadcrumb">
							<li><?php echo ucwords(strtolower($this->uri->segment(1))); ?></a></li>
							<li class="active">
								<a href="<?php echo base_url().'index.php/'.strtolower($this->uri->segment(1).'/'.$action); ?>">
								<!--i class="fa fa-bars"></i--> <?php echo ucwords(strtolower($action)); ?>
								</a>
							</li>
						</ol>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<?php echo $this->session->flashdata('alert_data'); ?>							
						
