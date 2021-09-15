<?php
$this->load->view('include/side_menu');
?>

<div class="box box-solid box-shadow" style="border-radius: 1rem;">
    <div class="box-body">
        <div class="row box-body" id="print_page">
            <div class="text-center">
                <h3 class="text-bold">PENGAJUAN CUTI PENGGANTI KARYAWAN</h3>
                <h3 class="text-bold">PT. SENTRAL TEHNOLOGI MANAGEMEN</h3>
            </div>
            <hr>
            <div class="col-md-10 col-md-offset-1">
                <div class="table-resposive">
                    <table class="table table-bordered table-condenseds table-resposive">
                        <tbody>
                            <tr>
                                <td width="">Tanggal Pengajuan</td>
                                <td class="text-center">:</td>
                                <td colspan="3"><?= date('D, d F Y', strtotime($employee->created_at)); ?></td>
                            </tr>
                            <tr>
                                <td width="">Nama</td>
                                <td class="text-center">:</td>
                                <td colspan="3"><?= $employee->name; ?></td>
                            </tr>
                            <tr>
                                <td>Divisi</td>
                                <td class="text-center">:</td>
                                <td colspan="3"><?= $employee->divisions_name; ?></td>
                            </tr>
                            <tr>
                                <td>Periode Tahun</td>
                                <td class="text-center">:</td>
                                <td colspan="4"><?= $employee->periode_year; ?></td>
                            </tr>
                            <tr>
                                <td>Jml. Hari</td>
                                <td class="text-center">:</td>
                                <td colspan="3"><?= $employee->total_days; ?> hari</td>
                            </tr>
                            <tr>
                                <td>Alasan</td>
                                <td height="70px" class="text-center">:</td>
                                <td colspan="3"><?= $employee->reason; ?></td>
                            </tr>
                            <tr>
                                <td>Appr. by D. Head</td>
                                <td height="20px" class="text-center">:</td>
                                <td colspan="2"> <?= $sts[$employee->status]; ?></td>
                            </tr>
                            <tr>
                                <td>Appr. by HR </td>
                                <td height="20px" class="text-center">:</td>
                                <td colspan="2"> <?= $sts[$employee->approved_hr]; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <label>Data Kegiatan</label>
                <div class="table-responsive">
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <td class="text-center" width="20px">No</td>
                                <td class="text-center">Rencana Kerja</td>
                                <td class="text-center" width="8%">QTY</td>
                                <td class="text-center">Aktual</td>
                                <td class="text-center" width="8%">QTY</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $n = 0;
                            foreach ($works as $wr) : $n++ ?>
                                <tr>
                                    <td><?= $n; ?></td>
                                    <td><?= $wr->work_planning; ?></td>
                                    <td><?= $wr->qty_planning; ?></td>
                                    <td><?= $wr->work_actual; ?></td>
                                    <td><?= $wr->qty_actual; ?></td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>

                <label>Permasalahan</label>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td style="height: 100px;"><?= $employee->problems; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="box-footer" style="border-radius: 1rem;">
        <div class="row">
            <div class="col-md-12 text-center">
                <?php if ($employee->status !== 'APV') : ?>
                    <button type="button" class="btn btn-success btn-lg" data-id="<?= $employee->id; ?>" id="approve_dh"><i class="fa fa-check"></i> Approve</button>
                <?php endif; ?>
                <?php if ($this->session->Group['name'] == 'Admin' and $employee->status == 'APV' and $employee->approved_hr == 'N') : ?>
                    <button type="button" class="btn btn-success btn-lg" data-id="<?= $employee->id; ?>" id="approve_hr"><i class="fa fa-check"></i> Approve</button>
                <?php endif; ?>
                <a href="javascript:void(0)" onclick="history.go(-1)" class="btn btn-danger btn-lg"><i class="fa fa-reply"></i> Kembali</a>
            </div>
        </div>
    </div>

</div>
<style>
    @page {
        size: auto;
        margin: 0;
    }

    @media print {
        @page {
            margin-top: 0;
            margin-bottom: 0;
        }

        body {
            padding-top: 0px;
            padding-bottom: 72px;
        }

        .btn,
        a,
        span,
        p,
        label,
        li,
        ul,
        ol {
            display: none;
        }
    }
</style>

<?php $this->load->view('include/footer'); ?>
<script>
    $(document).on('click', '#print', function() {
        window.print($('#print_page'))
    })

    $(document).on('click', '#approve_dh', function() {
        let id = $(this).data('id');
        swal({
            title: 'Perhatian!',
            text: 'Apakah Anda yakin data Pengajuan Cuti Pengganti akan di Disetujui?',
            type: 'warning',
            showConfirmButton: true,
            confirmButtonText: "Ya, Setujui",
            showCancelButton: true,

        }, function(value) {
            if (value) {
                $.ajax({
                    url: base_url + active_controller + '/save_approve',
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

    $(document).on('click', '#approve_hr', function() {
        let id = $(this).data('id');
        swal({
            title: 'Perhatian!',
            text: 'Apakah Anda yakin data Pengajuan Cuti Pengganti akan di Disetujui?',
            type: 'warning',
            showConfirmButton: true,
            confirmButtonText: "Ya, Setujui",
            showCancelButton: true,

        }, function(value) {
            if (value) {
                $.ajax({
                    url: base_url + active_controller + '/save_approve_hr',
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
</script>