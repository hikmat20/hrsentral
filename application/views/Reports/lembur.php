<?php
$this->load->view('include/side_menu');
//echo"<pre>";print_r($data_menu);
?>
<div class="box box-solid box-shadow rounded" style="border-radius: 1em;">
	<div class="box-header">
		<h3 class="box-title"><?= $title; ?></h3>
	</div>
	<div class="box-body">
		<form class="form-horizontal" role="form">
			<div class="form-group">
				<label for="" class="col-md-2">Start Date : </label>
				<div class="col-md-4">
					<input type="date" class="form-control" id="start_date" value="<?= date('Y-m-d'); ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-md-2">End Date : </label>
				<div class="col-md-4">
					<input type="date" class="form-control" id="end_date" value="<?= date('Y-m-d'); ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-md-2">Detail : </label>
				<div class="col-md-4">
					<div class="checkbox">
						<label>
							<input type="checkbox" id="detail" name="details">
							Sertakan list rencana kerja
						</label>
					</div>
				</div>
			</div>


			<div class="form-group">
				<label for="" class="col-md-2"></label>
				<div class="col-md-4">
					<button type="button" id="view_data" class="btn btn-primary"><i class="fa fa-search"></i> Lihat</button>
				</div>
			</div>
			<hr>
			<div class="" id="view"></div>
		</form>

	</div>
	<?php $this->load->view('include/footer'); ?>
	<script>
		$(document).on('click', '#view_data', function() {
			let sDate = $('#start_date').val();
			let eDate = $('#end_date').val();
			let detail = $('#detail').is(':checked');
			console.log(detail);
			if (!sDate) {
				swal({
					title: 'Perhatian!',
					text: 'Tanggal awal belum di pilih.',
					type: 'warning',
					timer: 3000
				})
				return false;
			} else if (!eDate) {
				swal({
					title: 'Perhatian!',
					text: 'Tanggal awal belum di pilih.',
					type: 'warning',
					timer: 3000
				})
				return false;
			} else if (sDate > eDate) {
				swal({
					title: 'Perhatian!',
					text: 'Tanggal tidak valid.',
					type: 'warning',
					timer: 3000
				})
				return false;
			} else {
				$.ajax({
					url: base_url + active_controller + '/report_lembur',
					type: 'POST',
					data: {
						sDate,
						eDate,
						detail
					},
					success: function(result) {
						console.log(result);
						if (result) {
							$('#view').html(result);
						} else {
							swal({
								title: 'Perhatian!',
								text: 'Data tidak valid.',
								type: 'warning',
								timer: 3000
							})
							return false;
						}
					},
					error: function(result) {
						swal({
							title: 'Error!',
							text: 'Server timeout.',
							type: 'error',
							timer: 3000
						})
						return false;
					}
				})
			}
		})

		$(document).on('click', '.view_works', function() {
			let id = $(this).data('id');
			if (!id) {
				swal({
					title: 'Perhatian!',
					text: 'Data tidak valid.',
					type: 'warning',
					timer: 3000
				})
				return false;
			} else {
				loading_spinner();
				$.ajax({
					url: base_url + active_controller + '/view_works',
					type: 'POST',
					data: {
						id
					},
					success: function(result) {},
					error: function(result) {
						swal({
							title: 'Error!',
							text: 'Server timeout.',
							type: 'error',
							timer: 3000
						})
						return false;
					}
				})
			}
		})
	</script>