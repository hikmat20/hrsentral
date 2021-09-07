<?php
$this->load->view('include/side_menu');
$req = [
    'OTHER' => 'Lainnya',
    'CLIENT' => 'Client'
]
?>
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title"><strong><?= $title; ?></strong></h3>
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
                    <th>D.Head</th>
                    <th>Apv. D.Head</th>
                    <th>Apv. HR</th>
                    <th width="150px">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php $n = 0;
                foreach ($row as $data) : $n++ ?>
                    <tr>
                        <td><?= $n; ?></td>
                        <td><?= $data->name; ?></td>
                        <td><?= $data->from_date; ?></td>
                        <td><?= $data->until_date; ?></td>
                        <td><?= $data->total_days; ?></td>
                        <td><?= $data->reason; ?></td>
                        <td><?= $req[$data->request_by]; ?></td>
                        <td><?= $data->approval_by_name; ?></td>
                        <td><?= $sts[$data->status]; ?></td>
                        <td><?= $sts[$data->approved_hr]; ?></td>
                        <td>
                            <a href="<?= base_url('pengganti/view/') . $data->id; ?>" class="btn btn-primary btn-sm view" title="View Pengajuan" tooltip="qtip"><i class="fa fa-eye"></i></a>
                            <?php if ($access['approve'] == '1') : ?>
                                <a href="<?= base_url('pengganti/approval/') . $data->id; ?>" class="btn btn-success btn-sm approve" title="Approve Pengajuan" tooltip="qtip"><i class="fa fa-check"></i></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $this->load->view('include/footer'); ?>
<script>
    $(document).ready(function() {
        $(document).on('click', '.cancel', function() {
            let id = $(this).data('id');
            swal({
                title: 'Perhatian!',
                text: 'Apakah Anda yakin data Pengajuan Cuti Pengganti akan di Batalkan?',
                type: 'warning',
                showConfirmButton: true,
                confirmButtonText: "Ya, Batalakan",
                showCancelButton: true,

            }, function(value) {
                if (value) {
                    $.ajax({
                        url: base_url + active_controller + '/cancel',
                        data: {
                            id
                        },
                        type: 'POST',
                        dataType: 'JSON',
                        success: function(result) {
                            if (result.status == 1) {
                                swal({
                                    title: 'Succes',
                                    text: result.msg,
                                    type: 'success',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                setTimeout(function() {
                                    location.reload()
                                }, 1500)
                            } else if (result.status == 0) {
                                swal({
                                    title: 'Kesalahan Upload',
                                    text: result.msg,
                                    type: 'warning',
                                });
                            }
                            console.log(result + ", " + response);
                        },
                        error: function(result) {
                            swal({
                                title: 'Error!!',
                                text: 'Internal Error',
                                type: 'error'
                            })
                        }
                    })
                }
            });
        })
    })
</script>