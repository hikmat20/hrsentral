<?php
$this->load->view('include/side_menu');
?>

<div class="box box-solid box-shadow" style="border-radius: 1rem;">
    <div class="box-body">
        <div class="row box-body" id="print_page">
            <div class="text-center">
                <h3 class="text-bold">PENGAJUAN LEMBUR KARYAWAN</h3>
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
                                <td colspan="3"><?= date('D, d F Y', strtotime($data->date)); ?></td>
                            </tr>
                            <tr>
                                <td width="">Nama</td>
                                <td class="text-center">:</td>
                                <td colspan="3"><?= $data->name; ?></td>
                            </tr>
                            <tr>
                                <td>Divisi</td>
                                <td class="text-center">:</td>
                                <td colspan="3"><?= $data->divisions_name; ?></td>
                            </tr>
                            <tr>
                                <td>Periode Tahun</td>
                                <td class="text-center">:</td>
                                <td colspan="4"><?= $data->periode_year; ?></td>
                            </tr>
                            <tr>
                                <td>Jam Mulai</td>
                                <td class="text-center">:</td>
                                <td colspan="3"><?= $data->start_time; ?> </td>
                            </tr>
                            <tr>
                                <td>Jam Selesai</td>
                                <td class="text-center">:</td>
                                <td colspan="3"><?= $data->end_time; ?></td>
                            </tr>
                            <tr>
                                <td>Jml. Hari</td>
                                <td class="text-center">:</td>
                                <td colspan="3"><?= $data->total_time; ?> Jam</td>
                            </tr>
                            <tr>
                                <td>Alasan</td>
                                <td height="70px" class="text-center">:</td>
                                <td colspan="3"><?= $data->reason; ?></td>
                            </tr>
                            <tr>
                                <td>Appr. by D. Head</td>
                                <td height="20px" class="text-center">:</td>
                                <td colspan="2"> <?= $sts[$data->status]; ?></td>
                            </tr>
                            <tr>
                                <td>Appr. by HR </td>
                                <td height="20px" class="text-center">:</td>
                                <td colspan="2"> <?= $sts[$data->approved_hr]; ?></td>
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
                    <br>
                    <?php if ($data->status == 'OPN') : ?>
                        <form id="form-add-work">
                            <input type="hidden" name="id" id="id" value="<?= $data->id; ?>">
                            <input type="hidden" name="employee_id" id="employee_id" value="<?= $data->employee_id; ?>">
                            <table id="table_planning" class="table table-bordered table-responsive">
                                <thead>
                                    <tr>
                                        <td class="text-center" width="20px">No</td>
                                        <td class="text-center">Rencana Kerja</td>
                                        <td class="text-center" width="8%">QTY</td>
                                        <td class="text-center" width="8%">Opsi</td>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </form>
                        <button class="btn btn-success" id="add_work"><i class="fa fa-plus"></i> Rencana Kerja</button>
                    <?php endif; ?>
                </div>

                <label>Permasalahan</label>
                <table class="table">
                    <tbody>
                        <tr>
                            <td>
                                <textarea disabled class="form-control" rows="5"><?= $data->problems; ?>
                                </textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <label>Catatan</label>
                <table class="table">
                    <tbody>
                        <tr>
                            <td>
                                <textarea name="note" class="form-control" id="note" <?= ($data->status == 'APV') ? 'disabled' : ''; ?> rows="5"><?= $data->note; ?></textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="box-footer" style="border-radius: 1rem;">
        <div class="row">
            <div class="col-md-12 text-center">
                <?php if ($data->status !== 'APV') : ?>
                    <button type="button" class="btn btn-success btn-lg" data-id="<?= $data->id; ?>" id="approve_dh"><i class="fa fa-check"></i> Approve</button>
                <?php endif; ?>
                <?php if ($this->session->Group['name'] == 'Admin' and $data->status == 'APV' and $data->approved_hr == 'N') : ?>
                    <button type="button" class="btn btn-success btn-lg" data-id="<?= $data->id; ?>" id="approve_hr"><i class="fa fa-check"></i> Approve</button>
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
        // let id = $(this).data('id');
        let formdata = new FormData($('#form-add-work')[0]);

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
                    data: formdata,
                    type: 'POST',
                    dataType: 'JSON',
                    processData: false,
                    contentType: false,
                    cache: false,
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

    $(document).on('click', '#add_work', function() {
        let row = $('#table_planning tbody tr').length || 0
        row = parseInt(row) + parseInt(1);
        let html = `
        <tr>
            <td>` + row + `</td>
            <td><textarea name="works[` + row + `][work_planning]" class="form-control" placeholder="Rencana kerja"></textarea></td>
            <td><input type="text" name="works[` + row + `][qty_planning]" class="form-control" placeholder="0"></td>
            <td><button type="button" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i></button></td>
        </tr>
        `;

        $('#table_planning tbody').append(html);
        // console.log(html);
    })

    $(document).on('click', '.delete', function() {
        $(this).parents('tr').remove();
    })
</script>