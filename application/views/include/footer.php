</div>
</div>
<div class="row">

	<div class="pull-right" style="margin-right:10px;">

	</div>
</div>
</div>
</section>
</div>
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
</aside>
<!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>

</div>

<div class="modal fade" id="spinner">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Please Wait.......</h4>
			</div>
			<div class="modal-body">

				<div class="progress progress-striped active" style="margin-bottom:0;">
					<div class="progress-bar" style="width: 100%" role="progressbar"></div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<div class="modal fade" id="Mymodal">
	<div class="modal-dialog" style="width:80%">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">List Master COA</h4>
			</div>
			<div class="modal-body" id="listCoa">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<style>
	.ui-datepicker select.ui-datepicker-month,
	.ui-datepicker select.ui-datepicker-year {
		color: #666;
	}
</style>
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
<!-- page script -->
<script type="text/javascript">
	var base_url = '<?php echo base_url(); ?>';
	var active_controller = '<?php echo ($this->uri->segment(1)); ?>';
	var active_action = '<?php echo ($this->uri->segment(2)); ?>';


	$(function() {

		$("#example1").DataTable({
			scrollX: false
		});
		$('select').addClass('chosen-select');
		/*$('input[type="text"][data-role="datepicker"]').datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth:true,
			changeYear:true,
		    maxDate:'+0d'
		});*/
		$('[data-role="qtip"]').tooltip();

		if ($('#flash-message')) {
			window.setTimeout(function() {
				$('#flash-message').fadeOut();
			}, 3000);
		}


		//	B:CHOSEN SETUP =================================================================================================================================

		//	general setup
		$('.chosen-select').chosen({
			allow_single_deselect: true,
			search_contains: true,
			no_results_text: 'No result found for : ',
			placeholder_text_single: 'Select an option'
		});

		//	disable chosen for multiple select, and data grid's select
		//select[multiple="multiple"],
		$('#data-grid select , #listDetailShift select').removeAttr('style', '').removeClass('chzn-done').data('chosen', null).next().remove();

		//	E:CHOSEN SETUP =================================================================================================================================
		/*
		$('#spinner').modal({
			backdrop: 'static',
			keyboard: false
		});
		*/


	});

	function back() {
		loading_spinner();
		window.location.href = base_url + 'index.php/' + active_controller;
	}

	function loading_spinner() {
		swal({
			title: "Loading!",
			text: "Please Wait..........",
			imageUrl: base_url + 'assets/img/loading.gif',
			showConfirmButton: false,
			showCancelButton: false
		});
	}
</script>
</body>

</html>

<!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->


</body>

</html>