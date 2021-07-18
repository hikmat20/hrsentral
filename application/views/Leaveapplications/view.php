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
                                <td colspan="3"><?= $employee->periode_year; ?></td>
                            </tr>
                            <tr>
                                <td>Jumlah Hak Cuti</td>
                                <td class="text-center">:</td>
                                <td colspan="3"><?= $employee->unused_leave; ?> hari</td>
                            </tr>
                            <tr>
                                <td>Cuti Diajukan</td>
                                <td class="text-center">:</td>
                                <td colspan="3"><?= $employee->applied_leave; ?> hari</td>
                            </tr>
                            <tr>
                                <td>Sisa Cuti</td>
                                <td class="text-center">:</td>
                                <td colspan="3"><?= $employee->remaining_leave; ?> hari</td>
                            </tr>
                            <tr>
                                <td>Tanggal Cuti</td>
                                <td class="text-center">:</td>
                                <td><?= $employee->from_date; ?></td>
                                <td class="text-center">s/d</td>
                                <td><?= $employee->until_date; ?></td>
                            </tr>

                            <tr>
                                <td>Keterangan</td>
                                <td height="20px" class="text-center">:</td>
                                <td colspan="3"><?= $employee->descriptions; ?> hari</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td height="20px" class="text-center">:</td>
                                <td colspan="3">
                                    <?php if ($employee->status == 'OPN') : ?>
                                        <label class="label-info label">Waiting Approval</label>
                                    <?php elseif ($employee->status == 'APV') : ?>
                                        <label class="label-success label">Approved</label>
                                    <?php elseif ($employee->status == 'CNL') : ?>
                                        <label class="label-default label">Cancel</label>
                                    <?php elseif ($employee->status == 'REJ') : ?>
                                        <label class="label-danger label">Rejected</label>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </tbody>

                    </table>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-responsive">
                        <tbody>
                            <tr>
                                <td width="50%" class="text-center">Jakarta, <?= date('d m- Y'); ?></td>
                                <td class="text-center">Disetujui, <?= $employee->approved_at; ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><br><br><br><br><br><br><br></td>
                                <td class="text-center"></td>
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
                <a href="<?= base_url('leavesapps/'); ?>" class="btn btn-danger"><i class="fa fa-times"></i> Cancel</a>
            </div>
            <div class="col-md-6">
            </div>
        </div>
    </div>

    <?php

    // echo '<pre>';
    // print_r($employee);
    // echo '<pre>';
    // exit;

    ?>

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