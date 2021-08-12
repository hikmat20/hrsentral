<?php
$this->load->view('include/side_menu'); ?>

<div class="box box-solid">

    <div class="box-body">
        <div class="row box-body" id="print_page">
            <div class="text-center">
                <h3 class="text-bold">PENGAJUAN CUTI KARYAWAN</h3>
                <h3 class="text-bold">PT SENTAL TEHNOLOGI MANAGEMEN</h3>
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
                                <td colspan=""><?= $employee->periode_year; ?></td>
                                <td colspan="3"><?= $employee->periode_year; ?></td>
                            </tr>
                            <tr>
                                <td>Hak Cuti Tahunan</td>
                                <td class="text-center">:</td>
                                <td colspan=""><?= $employee->unused_leave; ?> hari</td>
                                <td colspan="">Diambil : <?= $employee->get_year_leave; ?></td>
                                <td colspan="">Sisa : <?= $employee->remaining_leave; ?></td>

                            </tr>
                            <tr>
                                <td>Cuti Khusus</td>
                                <td class="text-center">:</td>
                                <td colspan=""><?= $employee->special_leave; ?> hari</td>
                                <td colspan="2"><?= $employee->category_name; ?></td>
                            </tr>
                            <tr>
                                <td>Cuti Urgent</td>
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
                                <td><?= date("D, d F Y", strtotime($employee->from_date)); ?></td>
                                <td class="text-center">s/d</td>
                                <td><?= date("D, d F Y", strtotime($employee->until_date)); ?></td>
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
                                    <?php elseif ($employee->status == 'HIS') : ?>
                                        <label class="bg-maroon font-light label">History</label>
                                    <?php else : ?>
                                        <label class="label-default label">Unknow Status</label>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td height="70px" class="text-center">:</td>
                                <td colspan="3"><?= $employee->descriptions; ?></td>
                            </tr>
                            <tr>
                                <td>Dokumen Pendukung</td>
                                <td height="100px" class="text-center">:</td>
                                <td colspan="3">
                                    <!-- <p><label for="">Nama Dokumen</label></p> -->
                                    <img src="/assets/documents/<?= ($employee->doc_special_leave) ? $employee->doc_special_leave : '-'; ?>" alt="" height="200px">
                                    <img src="/assets/documents/<?= ($employee->doc_notpay_leave) ? $employee->doc_notpay_leave : '-'; ?>" alt="" height="200px">
                                </td>
                            </tr>
                            <tr>
                                <th>Catatan</th>
                                <td height="70px" class="text-center">:</td>
                                <td colspan="3"><?= $employee->note; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-responsive">
                        <tbody>
                            <tr>
                                <td width="50%" class="text-center">Jakarta, <?= date('d M Y'); ?></td>
                                <td class="text-center">Disetujui, <?= date('d M Y', strtotime($employee->approved_at)); ?></td>
                            </tr>
                            <tr>
                            </tr>
                            <tr>
                                <td class="text-center text-bold"> ( <?= $employee->name; ?> )</td>
                                <td class="text-center text-bold"> ( <?= $employee->approval_by_name; ?> )</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="box-footer">
        <div class="row">
            <div class="col-md-12 text-center">
                <button type="button" class="btn btn-default" id="print"><i class="fa fa-print"></i> Print</button>
                <a href="javascript:void(0)" onclick="history.go(-1)" class="btn btn-danger"><i class="fa fa-times"></i> Cancel</a>
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
</script>