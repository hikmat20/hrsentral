<?php
$this->load->view('include/side_menu');
$flag_leave_type = [
    'ALP' => 'Alpha',
    'AMC' => 'Ambil Cuti',
    'CBS' => 'Cuti Bersama',
    'TMC' => 'Tambah Cuti',
];
?>

<div class="box box-solid box-shadow" style="border-radius: 1rem;">
    <div class="box-body">
        <div class="row box-body" id="print_page">
            <div class="text-center">
                <h3 class="text-bold">PENGAJUAN CUTI KARYAWAN</h3>
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
                                <td><?= date("D, d F Y", strtotime($employee->from_date)); ?></td>
                                <td class="text-center">s/d</td>
                                <td><?= date("D, d F Y", strtotime($employee->until_date)); ?></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td height="20px" class="text-center">:</td>
                                <td colspan="2">
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
                                <td rowspan="4">Dokumen Pendukung</td>
                                <td rowspan="4" class="text-center">:</td>
                                <td class="text-center">Dok. Surat Sakit</td>
                                <td class="text-center">Dok. Kwitansi / Perincian Biaya Berobat</td>
                                <td class="text-center">Dok. Copy Resep</td>
                            </tr>
                            <tr height="100px">
                                <td class="text-center">
                                    <!-- <p><label for="">Nama Dokumen</label></p> -->
                                    <a target="_blank" href="<?= (file_exists(FCPATH . "assets/documents/$employee->doc_sick_leave") ? base_url("assets/documents/$employee->doc_sick_leave") : 'no-file'); ?>">
                                        <?php
                                        if (file_exists(FCPATH . "assets/documents/$employee->doc_sick_leave")) :
                                            $filecontent = file_get_contents(FCPATH . "assets/documents/$employee->doc_sick_leave");
                                            if (preg_match("/^%PDF/", $filecontent)) { ?>
                                                <button type="button" class="btn btn-sm btn success"><i class="fa fa-file" aria-hidden="true"></i> View File</button>
                                            <?php } else {; ?>
                                                <img src="<?= (file_exists(FCPATH . "assets/documents/$employee->doc_sick_leave") ? base_url("assets/documents/$employee->doc_sick_leave") : 'no-file'); ?>" alt="" height="200px">
                                        <?php };
                                        endif; ?>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a target="_blank" href="<?= (file_exists(FCPATH . "assets/documents/$employee->doc_sick_leave_2") ? base_url("assets/documents/$employee->doc_sick_leave_2") : 'no-file'); ?>">
                                        <?php if (file_exists(FCPATH . "assets/documents/$employee->doc_sick_leave_2")) :
                                            $filecontent = file_get_contents(FCPATH . "assets/documents/$employee->doc_sick_leave_2");
                                            if (preg_match("/^%PDF/", $filecontent)) { ?>
                                                <button type="button" class="btn btn-sm btn success"><i class="fa fa-file" aria-hidden="true"></i> View File</button>
                                            <?php } else {; ?>
                                                <img src="<?= (file_exists(FCPATH . "assets/documents/$employee->doc_sick_leave_2") ? base_url("assets/documents/$employee->doc_sick_leave_2") : 'no-file'); ?>" alt="" height="200px">
                                        <?php };
                                        endif; ?>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a target="_blank" href="<?= (file_exists(FCPATH . "assets/documents/$employee->doc_sick_leave_3") ? base_url("assets/documents/$employee->doc_sick_leave_3") : 'no-file'); ?>">
                                        <?php if (file_exists(FCPATH . "assets/documents/$employee->doc_sick_leave_3")) :
                                            $filecontent = file_get_contents(FCPATH . "assets/documents/$employee->doc_sick_leave_3");
                                            if (preg_match("/^%PDF/", $filecontent)) { ?>
                                                <button type="button" class="btn btn-sm btn success"><i class="fa fa-file" aria-hidden="true"></i> View File</button>
                                            <?php } else {; ?>
                                                <img src="<?= (file_exists(FCPATH . "assets/documents/$employee->doc_sick_leave_3") ? base_url("assets/documents/$employee->doc_sick_leave_3") : 'no-file'); ?>" alt="" height="200px">
                                        <?php };
                                        endif; ?>
                                    </a>
                                </td>
                            </tr>
                            <tr class="tetx-center">
                                <td class="text-center">Dok. Cuti Pemerintah</td>
                                <td class="text-center">Dok. Cuti Tdk. Dibayar</td>
                                <td></td>
                            </tr>
                            <tr class="tetx-center">
                                <td>
                                    <a target="_blank" href="<?= (file_exists(FCPATH . "assets/documents/$employee->doc_special_leave") ? base_url("assets/documents/$employee->doc_special_leave") : 'no-file'); ?>">
                                        <?php if (file_exists(FCPATH . "assets/documents/$employee->doc_special_leave")) :
                                            $filecontent = file_get_contents(FCPATH . "assets/documents/$employee->doc_special_leave");
                                            if (preg_match("/^%PDF/", $filecontent)) { ?>
                                                <button type="button" class="btn btn-sm btn success"><i class="fa fa-file" aria-hidden="true"></i> View File</button>
                                            <?php } else {; ?>
                                                <img src="<?= (file_exists(FCPATH . "assets/documents/$employee->doc_special_leave") ? base_url("assets/documents/$employee->doc_special_leave") : 'no-file'); ?>" alt="" height="200px">
                                        <?php };
                                        endif; ?>
                                    </a>
                                </td>
                                <td>
                                    <a target="_blank" href="<?= (file_exists(FCPATH . "assets/documents/$employee->doc_notpay_leave") ? base_url("assets/documents/$employee->doc_notpay_leave") : 'no-file'); ?>">
                                        <?php if (file_exists(FCPATH . "assets/documents/$employee->doc_notpay_leave")) :
                                            $filecontent = file_get_contents(FCPATH . "assets/documents/$employee->doc_notpay_leave");
                                            if (preg_match("/^%PDF/", $filecontent)) { ?>
                                                <button type="button" class="btn btn-sm btn success"><i class="fa fa-file" aria-hidden="true"></i> View File</button>
                                            <?php } else {; ?>
                                                <img src="<?= (file_exists(FCPATH . "assets/documents/$employee->doc_notpay_leave") ? base_url("assets/documents/$employee->doc_notpay_leave") : 'no-file'); ?>" alt="" height="200px">
                                        <?php };
                                        endif; ?>
                                    </a>
                                </td>
                                <td></td>
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
                    <?php
                    $sttsApvHR = [
                        'Y' => ' <label class="label-success label">Approved</label>',
                        'N' => ' <label class="label-warning label">Waiting Approval</label>'
                    ]; ?>
                    <table class="table table-bordered table-responsive">
                        <tbody>
                            <tr>
                                <td width="20%" class="">Stts. Approve HR</td>
                                <td width="30px" class="text-center">:</td>
                                <td class=""><?= ($employee->approved_hr) ? $sttsApvHR[$employee->approved_hr] : '-'; ?></td>
                            </tr>
                            <tr>
                                <td class="">Total Pengajuan Cuti</td>
                                <td width="30px" class="text-center">:</td>
                                <td class=""><?= ($employee->applied_leave) ? $employee->applied_leave : '-'; ?> hari</td>
                            </tr>
                            <tr>
                                <td class="">Aktual Cuti</td>
                                <td class="text-center">:</td>
                                <td class=""><?= ($employee->actual_leave) ? $employee->actual_leave : '-'; ?> hari</td>
                            </tr>
                            <tr>
                                <td class="">Alpha</td>
                                <td class="text-center">:</td>
                                <td class=""><?= ($employee->alpha_value) ? $employee->alpha_value : '-'; ?> hari</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-responsive">
                        <tbody>
                            <tr>
                                <td width="50%" class="text-center">Jakarta, <?= date('d M Y'); ?></td>
                                <td class="text-center">Disetujui, <?= ($employee->approved_at) ? date('d M Y', strtotime($employee->approved_at)) : '-'; ?></td>
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

    <div class="box-footer" style="border-radius: 1rem;">
        <div class="row">
            <div class="col-md-12 text-center">
                <button type="button" class="btn btn-default" id="print"><i class="fa fa-print"></i> Print</button>
                <a href="javascript:void(0)" onclick="history.go(-1)" class="btn btn-danger"><i class="fa fa-times"></i> Cancel</a>
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