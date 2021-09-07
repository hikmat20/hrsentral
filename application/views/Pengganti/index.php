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
                    <!-- <th>Permintaan</th> -->
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
                        <!-- <td><?= $data->request_by; ?></td> -->
                        <td><?= $data->approval_by_name; ?></td>
                        <td><?= $sts[$data->status]; ?></td>
                        <td><?= $sts[$data->approved_hr]; ?></td>
                        <td>
                            <a href="<?= base_url('pengganti/view/') . $data->id; ?>" class="btn btn-primary btn-sm view" title="View Pengajuan" tooltip="qtip"><i class="fa fa-eye"></i></a>
                            <?php if ($access['update'] == '1' && $data->status == 'OPN') : ?>
                                <a href="<?= base_url('pengganti/edit/') . $data->id; ?>" class="btn btn-warning btn-sm edit" title="Edit Pengajuan" tooltip="qtip"><i class="fa fa-pencil"></i></a>
                            <?php endif; ?>
                            <?php if ($access['delete'] == '1') : ?>
                                <button data-id="<?= $data->id; ?>" class="btn btn-danger btn-sm cancel" title="Cancel Pengajuan" tooltip="qtip"><i class="fa fa-stop"></i></button>
                            <?php endif; ?>
                            <?php
                            $text = "Dengan Hormat,%0aSaya yang bertanda tangan dibawah ini :%0a%0aNama : " . $data->name . "%0aDivisi : " . $data->divisions_name . "%0a%0aBermaksud untuk mengajukan Cuti Pengganti pada tanggal " . $data->from_date . " s/d " . $data->until_date . " selama " . $data->total_days . " hari.%0a%0aUntuk lebih detailnya bisa klik link dibawah ini:%0a" . base_url('pengganti/view/' . $data->id) . "%0a%0aDemikian surat pengajuan cuti pengganti ini saya sampaikan. Atas perhatiannya saya ucapkan terima kasih.%0a%0aHormat Saya,%0a" . $data->name; ?>
                            <?php if ($access['create'] == '1' && $data->status == 'OPN') : ?>
                                <a href="https://api.whatsapp.com/send/?phone=<?= $phone[$data->approval_employee_id]; ?>&text=<?= $text; ?>" class='btn btn-success btn-sm' id="wa" data-id="" target="_blank" title='Send Whatsapp' data-role='qtip'><i class='fa fa-whatsapp' style="font-size: 1.4em;"></i></a>
                            <?php endif; ?>
                            <?php if ($access['approve'] == '1') : ?>
                                <a href="<?= base_url('pengganti/approve/') . $data->id; ?>" class="btn btn-success btn-sm approve" title="Approve Pengajuan" tooltip="qtip"><i class="fa fa-check"></i></a>
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