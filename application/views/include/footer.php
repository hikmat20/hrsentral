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

<!-- page script -->
<script type="text/javascript">
	var base_url = '<?php echo base_url(); ?>';
	var siteurl=base_url;
	var active_controller = '<?php echo ($this->uri->segment(1)); ?>';
	var active_action = '<?php echo ($this->uri->segment(2)); ?>';


	$(function() {

		$("#example1").DataTable({
			scrollX: false,
			stateSave: true,
			
			
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