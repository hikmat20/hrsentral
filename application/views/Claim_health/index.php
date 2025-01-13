<?php
$action='';
$this->load->view('include/side_menu');
?>
<div class="box box-primary">
    <div class="box-header">
        <h2 class="box-title text-bold"><?= $title; ?></h2>
    </div>
    <div class="box-body">
        <div class="text-lg-right" style="margin-bottom: 10px; display:block">
            <?php if ($access['create'] == '1') : ?>
                <a href="<?= base_url(); ?>claim_health/add" class=' btn btn-md btn-primary' title='Buat Claim Baru' data-role='qtip'><i class='fa fa-plus'></i> Claim Baru</a>
            <?php endif; ?>
        </div>
        <div class="table-responsive">
			<table id="mytabledata" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>No Claim</th>
						<th>Tanggal Claim</th>
						<th>Tertanggung</th>
						<th>Jenis Claim</th>
						<th>Biaya Claim</th>
						<th>Status</th>
						<th></th>
					</tr>
				</thead>
            </table>
        </div>
    </div>
</div>
<!-- page script -->
<?php $this->load->view('include/footer'); ?>
<script type="text/javascript">
	var siteurl			= '<?php echo base_url(); ?>';
	var active_controller	= 'claim_health/';
     $(document).ready(function(){
        $('#mytabledata').DataTable({
          'processing': true,
          'serverSide': true,
          'serverMethod': 'post',
          'ajax': {
             'url': siteurl + active_controller + 'getDataJSON',
          },
          'columns': [
             { data: 'no_claim' },
             { data: 'tgl_claim' },
             { data: 'nama_tertanggung' },
             { data: 'jenis_claim' },
             { data: 'biaya_claim' },
             { data: 'status' },
             { data: 'detail' },
          ],
		  "order": [[1, 'desc']],
		  columnDefs: [ { orderable: false, targets: [4,6] }, {"className": "text-center",targets: [4]} ],
        });
     });

</script>