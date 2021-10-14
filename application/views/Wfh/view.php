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
                <h3 class="text-bold">PENGAJUAN WORK FROM HOME KARYAWAN</h3>
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
                                <td colspan="3"><?= date('D, d F Y', strtotime($wfh->created_at)); ?></td>
                            </tr>
                            <tr>
                                <td width="">Nama</td>
                                <td class="text-center">:</td>
                                <td colspan="3"><?= $wfh->name; ?></td>
                            </tr>
                            <tr>
                                <td>Divisi</td>
                                <td class="text-center">:</td>
                                <td colspan="3"><?= $wfh->divisions_name; ?></td>
                            </tr>
                            <tr>
                                <td>Periode Tahun</td>
                                <td class="text-center">:</td>
                                <td colspan="4"><?= $wfh->periode_year; ?></td>
                            </tr>
                            <tr>
                                <td>Jml. Hari</td>
                                <td class="text-center">:</td>
                                <td colspan="3"><?= $wfh->total_days; ?> hari</td>
                            </tr>
                            <tr>
                                <td>Apv. by DH</td>
                                <td height="20px" class="text-center">:</td>
                                <td colspan="2"> <?= $sts[$wfh->status]; ?></td>
                            </tr>
                            <tr>
                                <td>Apv. by HR</td>
                                <td height="20px" class="text-center">:</td>
                                <td colspan="2"> <?= $sts[$wfh->approved_hr]; ?></td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td height="70px" class="text-center">:</td>
                                <td colspan="3"><?= $wfh->reason; ?></td>
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
                            <td style="height: 100px;"><?= $wfh->problems; ?></td>
                        </tr>
                    </tbody>
                </table>

                <label>Catatan</label>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td style="height: 100px;"><?= $wfh->note; ?></td>
                        </tr>
                    </tbody>
                </table>

                <div class="table-responsive">
                    <table class="table table-bordered table-responsive">
                        <tbody>
                            <tr>
                                <td width="50%" class="text-center">Jakarta, <?= date('d M Y'); ?></td>
                                <td class="text-center">Disetujui, <?= ($wfh->approved_at) ? date('d M Y', strtotime($wfh->approved_at)) : '-'; ?></td>
                            </tr>
                            <tr>
                            </tr>
                            <tr>
                                <td class="text-center text-bold"> ( <?= $wfh->name; ?> )</td>
                                <td class="text-center text-bold"> ( <?= $wfh->approval_employee_name; ?> )</td>
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