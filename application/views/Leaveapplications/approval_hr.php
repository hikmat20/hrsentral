<?php
$this->load->view('include/side_menu');
$namaBulan = ["Januari", "Februaru", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

?>

<div class="box box-solid rounded-1">
    <div class="box-header">
        <h2 class="box-title font-nunito" style="padding: 10px;">Leave Application</h2>
    </div>
    <div class="box-body">
        <div class="row box-body" id="print_page">
            <div class="col-md-10 col-md-offset-1">
                <div class="table-resposive">
                    <table class="table table-condenseds table-resposive">
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
            </div>
        </div>
    </div>
</div>
<div class="box box-solid rounded-1">
    <div class="box-header">
        <h2 class="box-title font-nunito" style="padding: 10px;">Approval Leave Application</h2>
    </div>
    <div class="box-body">

        <form class="form-horizontal" id="form-leave" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-4">
                    <input type="hidden" name="id" id="id" value="<?= $leaveApp->id; ?>">
                    <div class="form-group">
                        <label for="applied_leave" class="col-sm-5 control-label">Total Pengajuan Cuti</label>
                        <div class="col-sm-7">
                            <div class="input-group">
                                <input type="text" class="form-control" name="applied_leave" id="applied_leave" required readonly value="<?= $employee->applied_leave; ?>">
                                <div class="input-group-addon">Hari</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="actual_leave" class="col-sm-5 control-label">Aktual Cuti</label>
                        <div class="col-sm-7">
                            <div class="input-group">
                                <input type="text" class="form-control" id="actual_leave" name="actual_leave" value="" placeholder="0">
                                <div class="input-group-addon">Hari</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="alpha" class="col-sm-5 control-label">Alpha</label>
                        <div class="col-sm-7">
                            <div class="input-group">
                                <input type="text" name="alpha" id="alpha" required readonly class="form-control" value="">
                                <div class="input-group-addon">Hari</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="box-footer rounded-1">
        <div class="row">
            <div class="col-md-6 text-center">
                <button type="button" class="btn btn-success" id="approve"><i class="fa fa-check"></i> Approve</button>
                <button type="button" class="btn btn-primary bg-maroon" id="reject"><i class="fa fa-minus-circle"></i> Reject</button>
                <a href="javascript:void(0)" onclick="window.history.go(-1)" class="btn btn-danger"><i class="fa fa-times"></i> Cancel</a>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('include/footer'); ?>
<script>
    $(document).ready(function() {
        $('.btn-spinner').click(function() {
            $('#spinner').modal('show');
        });
    });

    $(document).on('change', '#actual_leave', function() {

        let act_leave = $(this).val();
        let applied_leave = $('#applied_leave').val();
        alpha = parseInt(act_leave) - parseInt(applied_leave);

        if (act_leave != 0) {
            if (parseInt(alpha) < 0) {
                swal({
                    title: 'Peringatan!',
                    text: 'Jumlah nilai aktual cuti terlalu besar.',
                    type: 'warning'
                })
                return false;
            }
            $('#alpha').val(alpha);
        } else {
            $('#alpha').val('');
        }
    })

    $(document).on('click', '#approve', function() {
        let alpha = $('#alpha').val();
        if (alpha == '') {
            swal({
                title: 'Peringatan!',
                type: 'warning',
                text: 'Nilai Alpha masih kosong!'
            })
            return false;
        }
        save_application()
    })

    function save_application() {
        let id = $('#id').val();
        let formdata = new FormData($('#form-leave')[0]);
        $.ajax({
            url: '<?= base_url('leavesapps/approveHR'); ?>',
            data: formdata,
            type: 'POST',
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function(result, response) {
                if (result.status == 1) {
                    swal({
                        title: 'Succes',
                        text: result.msg,
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(function() {
                        window.open('<?= base_url('leavesapps/approval'); ?>', '_self');
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

    function getLeave() {
        let yearLeave = $('#have_leave').val() || 0;
        let getYearLeave = $('#get_year_leave').val() || 0;
        let specialLeave = $('#special_leave').val() || 0;
        let otherLeave = $('#notpay_leave').val() || 0;
        let sickLeave = $('#sick_leave').val() || 0;

        if (yearLeave == 0) {
            getYearLeave = 0;
            $('#get_year_leave').val('0');
            $('#remaining_leave').val(yearLeave);
            $('.remaining_leave').text(yearLeave);
            swal({
                title: 'Terjadi kesalah',
                text: 'Hak Cuti Tahunan tidak tersedia!',
                type: 'warning'
            })
        } else if (parseInt(getYearLeave) > parseInt(yearLeave)) {
            getYearLeave = 0;
            $('#get_year_leave').val('0');
            $('#remaining_leave').val(yearLeave);
            $('.remaining_leave').text(yearLeave);
            swal({
                title: 'Terjadi kesalah',
                text: 'Jumlah pengambilan cuti melebihi sisa cuti!',
                type: 'warning'
            })
        } else {
            remLeave = (parseInt(yearLeave)) - parseInt(getYearLeave);
            $('#remaining_leave').val(remLeave);
            $('.remaining_leave').text(remLeave);
        }

        totalLeave = parseInt(getYearLeave) + parseInt(specialLeave) + parseInt(otherLeave) + parseInt(sickLeave);
        $('#applied_leave').val(totalLeave);
        console.log(totalLeave);
        return false
    }
</script>