<?php
$this->load->view('include/side_menu'); ?>
<div class="box box-solid rounded-1">
    <div class="box-body ">
        <div class="row box-body" id="print_page">
            <div class="text-center">
                <h3 class="text-bold">PENGAJUAN CUTI KARYAWAN</h3>
                <h3 class="text-bold">PT. SENTRAL TEHNOLOGI MANAGEMEN</h3>
            </div>
            <hr>

            <div class="col-md-10 col-md-offset-1">
                <div class="table-resposive">
                    <table class="table table-bordered table-condensed table-resposive">
                        <tbody>
                            <tr>
                                <td width="">Tanggal Pengajuan</td>
                                <td class="text-center">:</td>
                                <td colspan="3"><?= date('D, d M Y', strtotime($employee->created_at)); ?></td>
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
                                <td>Cuti Tahunan</td>
                                <td class="text-center">:</td>
                                <td colspan=""><?= $employee->unused_leave; ?> hari</td>
                                <td colspan="">Diambil : <?= $employee->get_year_leave; ?></td>
                                <td colspan="">Sisa : <?= $employee->remaining_leave; ?></td>

                            </tr>
                            <tr>
                                <td>Sakit</td>
                                <td class="text-center">:</td>
                                <td colspan="3"><?= $employee->sick_leave; ?> hari</td>
                            </tr>
                            <tr>
                                <td>Cuti Pemerintah</td>
                                <td class="text-center">:</td>
                                <td colspan=""><?= $employee->special_leave; ?> hari</td>
                                <td colspan="2"><?= $employee->category_name; ?></td>
                            </tr>
                            <tr>
                                <td>Cuti Tdk. Dibayar</td>
                                <td class="text-center">:</td>
                                <td colspan=""><?= $employee->notpay_leave; ?> hari</td>
                                <td colspan="2">Keperluan : <?= ($employee->notpay_leave_desc) ? $employee->notpay_leave_desc : '-'; ?></td>
                            </tr>
                            <tr>
                                <td>Total Cuti</td>
                                <td class="text-center">:</td>
                                <td colspan="3"><?= $employee->applied_leave; ?> hari</td>
                            </tr>
                            <tr>
                            <tr>
                                <td>Tanggal Cuti</td>
                                <td class="text-center">:</td>
                                <td><?= $employee->from_date; ?></td>
                                <td class="text-center">s/d</td>
                                <td><?= $employee->until_date; ?></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td height="20px" class="text-center">:</td>
                                <td colspan="3">
                                    <?php if ($employee->status == 'OPN') : ?>
                                        <label class="label-warning font-light label">Waiting Approval</label>
                                    <?php elseif ($employee->status == 'APV') : ?>
                                        <label class="label-success font-light label">Approved</label>
                                    <?php elseif ($employee->status == 'CNL') : ?>
                                        <label class="label-default font-light label">Cancel</label>
                                    <?php elseif ($employee->status == 'REJ') : ?>
                                        <label class="label-danger font-light label">Rejected</label>
                                    <?php elseif ($employee->status == 'REV') : ?>
                                        <label class="label-info font-light label">Revision</label>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td height="100px" class="text-center">:</td>
                                <td colspan="3"><?= $employee->descriptions; ?></td>
                            </tr>
                            <tr>
                                <td rowspan="4">Dokumen Pendukung</td>
                                <td rowspan="4" class="text-center">:</td>
                                <td class="text-center">Dok. Surat Sakit</td>
                                <td class="text-center">Dok. Kwitansi / Perincian Biaya Berobat</td>
                                <td class="text-center">Dok. Copy Resep</td>

                            </tr>
                            <tr height="100px">
                                <td>
                                    <a target="_blank" href="<?= base_url(); ?>assets/documents/<?= ($employee->doc_sick_leave) ? (file_exists(FCPATH . "assets/documents/$employee->doc_sick_leave") ? $employee->doc_sick_leave : 'No file uploded') : '-'; ?>">
                                        <img src=" <?= base_url(); ?>assets/documents/<?= ($employee->doc_sick_leave) ? (file_exists(FCPATH . "assets/documents/$employee->doc_sick_leave") ? $employee->doc_sick_leave : 'No file uploded') : '-'; ?>" alt="" width="200px">
                                    </a>
                                </td>
                                <td>
                                    <a target="_blank" href="<?= base_url(); ?>assets/documents/<?= ($employee->doc_sick_leave_2) ? (file_exists(FCPATH . "assets/documents/$employee->doc_sick_leave_2") ? $employee->doc_sick_leave_2 : "No file uploded") : '-'; ?>">
                                        <img src="<?= base_url(); ?>assets/documents/<?= ($employee->doc_sick_leave_2) ? (file_exists(FCPATH . "assets/documents/$employee->doc_sick_leave_2") ? $employee->doc_sick_leave_2 : "No file uploded") : '-'; ?>" alt="" width="200px">
                                    </a>
                                </td>
                                <td>
                                    <a target="_blank" href="<?= base_url(); ?>assets/documents/<?= ($employee->doc_sick_leave_3) ? (file_exists(FCPATH . "assets/documents/$employee->doc_sick_leave_3") ? $employee->doc_sick_leave_3 : "No file uploded") : '-'; ?>">
                                        <img src="<?= base_url(); ?>assets/documents/<?= ($employee->doc_sick_leave_3) ? (file_exists(FCPATH . "assets/documents/$employee->doc_sick_leave_3") ? $employee->doc_sick_leave_3 : "No file uploded") : '-'; ?>" alt="" width="200px">
                                    </a>
                                </td>								
                            </tr>
                            <tr>
                                <td class="text-center">Dok. Cuti Pemerintah</td>
                                <td class="text-center">Dok. Cuti Tdk. Dibayar</td>
								<td></td>
                            </tr>
                            <tr>
                                <td>
                                    <a target="_blank" href="<?= base_url(); ?>assets/documents/<?= ($employee->doc_special_leave) ? (file_exists(FCPATH . "assets/documents/$employee->doc_special_leave") ? $employee->doc_special_leave : "No file uploded") : '-'; ?>">
                                        <img src="<?= base_url(); ?>assets/documents/<?= ($employee->doc_special_leave) ? (file_exists(FCPATH . "assets/documents/$employee->doc_special_leave") ? $employee->doc_special_leave : "No file uploded") : '-'; ?>" alt="" width="200px">
                                    </a>
                                </td>
                                <td>
                                    <a target="_blank" href="<?= base_url(); ?>assets/documents/<?= ($employee->doc_notpay_leave) ? (file_exists(FCPATH . "assets/documents/$employee->doc_notpay_leave") ? $employee->doc_notpay_leave : "No file uploded") : '-'; ?>">
                                        <img src="<?= base_url(); ?>assets/documents/<?= ($employee->doc_notpay_leave) ? (file_exists(FCPATH . "assets/documents/$employee->doc_notpay_leave") ? $employee->doc_notpay_leave : "No file uploded") : '-'; ?>" alt="" width="200px">
                                    </a>
                                </td>
								<td></td>
                            </tr>
							</tbody>
                    </table>
                </div>
                <div class="form-horizontal">
                    <div class="form-group">
                        <label for="" class="col-md-1 control-labe">Catatan:</label>
                        <div class="col-md-11">
                            <textarea name="note" class="form-control" id="note" rows="3" placeholder="Catatan"><?= $employee->note; ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="box-footer">
        <div class="row">
            <div class="col-md-12 text-center">
                <?php if ($employee->status == 'OPN') : ?>
                    <button id="revisi" class="btn btn-info btn-lg" data-id="<?= $employee->id; ?>" type="button"><i class="fa fa-reply"></i> Revisi</button>
                    <button id="approve" class="btn btn-success btn-lg" data-id="<?= $employee->id; ?>" type="button"><i class="fa fa-check"></i> Approve</button>
                    <button id="reject" class="btn btn-danger bg-maroon btn-lg" data-id="<?= $employee->id; ?>" type="button"><i class="fa fa-minus-circle"></i> Reject</button>
                    <!-- <button id="aplha" class="btn btn-default btn-lg" data-id="<?= $employee->id; ?>" type="button"><i class="fa fa-minus"></i> Aplha</button> -->
                <?php endif; ?>
                <a href="javascript:void(0)" onclick="window.history.go(-1)" class="btn btn-danger btn-lg"><i class="fa fa-times"></i> Kembali</a>
                <!-- <button type="button" class="btn btn-default" id="print"><i class="fa fa-print"></i> Print</button> -->
            </div>
            <div class="col-md-6">
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

    $(document).on('click', '#approve,#revisi,#reject,#aplha', function() {
        let id = $(this).data('id');
        let act = $(this)[0].id;
        let note = $('#note').val()
        if (note == '' || note == null) {
            swal({
                title: "Peringatan!",
                text: "Mohon isi catatan terlebih dahulu.",
                type: "warning",
            })
            return false
        }

        swal({
                title: "Are you sure?",
                text: "You will not be able to process again this data!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, Process it!",
                cancelButtonText: "No, cancel process!",
                closeOnConfirm: false,
            },
            function(isConfirm) {
                if (isConfirm) {
                    loading_spinner();
                    var baseurl = '<?= base_url(); ?>' + 'leavesapps/process_approval';
                    $.ajax({
                        url: baseurl,
                        type: "POST",
                        data: {
                            id,
                            act,
                            note
                        },
                        dataType: 'json',
                        success: function(result) {
                            if (result.status == 1) {
                                (result.email_error) ? console.log(result.email_error): '';
                                swal({
                                    title: "Success!",
                                    text: result.msg,
                                    type: "success",
                                    showCancelButton: false,
                                    showConfirmButton: true,
                                    allowOutsideClick: false,
                                }, function(isConfirm) {
                                    location.href = "<?= base_url('leavesapps/approval'); ?>";
                                })
                            } else {
                                swal({
                                    title: "Error..!",
                                    text: result.msg,
                                    type: "danger",
                                    timer: 7000,
                                    showCancelButton: true,
                                    showConfirmButton: false,
                                    allowOutsideClick: false
                                });
                                console.log(result.email_error);
                            }
                        },
                        error: function() {
                            swal({
                                title: "Error Message !",
                                text: 'An Error Occured During Process. Please try again..',
                                type: "warning",
                                timer: 7000,
                                showCancelButton: true,
                                showConfirmButton: false,
                                allowOutsideClick: false
                            });
                        }
                    });
                }
            });
    })
</script>