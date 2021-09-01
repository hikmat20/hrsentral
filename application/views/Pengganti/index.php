<?php
$this->load->view('include/side_menu');
?>
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title"><strong><?= $title; ?></strong></h3>
        <div class="box-tool pull-right">
            <a href="<?= base_url('pengganti/add'); ?>" class="btn btn-primary" id="add"><i class="fa fa-plus"></i> Add New</a>
        </div>
    </div>
    <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead class="bg-primary">
                <tr>
                    <th>No</th>
                    <th>Karyawan</th>
                    <th>Tgl. Awal</th>
                    <th>Tgl. Akhir</th>
                    <th>Jml. Hari</th>
                    <th>Alasan</th>
                    <th>Permintaan</th>
                    <th>Status</th>
                    <th>Apv. D.Head</th>
                    <th>Apv. HR</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php $n = 0;
                foreach ($row as $data) : $n++ ?>

                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $this->load->view('include/footer'); ?>
<script>
    $(document).ready(function() {
        $(document).on('click', '#sadd', function() {

        })
    })
</script>