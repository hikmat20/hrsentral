<?php
$this->load->view('include/side_menu');
$namaBulan = ["Januari", "Februaru", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

?>

<div class="box box-solid rounded-1">
    <div class="box-header">
        <h2 class="box-title font-nunito" style="padding: 10px;"><?= $title; ?></h2>
    </div>
    <div class="box-body">
        <form class="form-horizontal" id="form-leave" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="hidden">
                        <input type="text" name="id" id="id" value="<?= $leaveApp->id; ?>">
                        <div class="form-group">
                            <label for="employee_id" class="col-sm-3 control-label">Employee <span class="text-red">*</span></label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                    <div class="input-group-addon bg-gray"><?= $leaveApp->employee_id ?></div>
                                    <input type="text" class="form-control" id="employee_id" required readonly value="<?= $employee['name']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="division" class="col-sm-3 control-label">Division</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="division_id" readonly value="<?= $division->name; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="periode_year" class="col-sm-3 control-label">Year Periode <span class="text-red">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="periode_year" class="form-control" value="<?= $leaveApp->periode_year; ?>">
                                <!-- <select name="periode_year" id="periode_year" class="form-control">
                                    <option value=""></option>
                                </select> -->
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="have_leave" class="col-sm-3 control-label">Cuti Tahunan <span class="text-red">*</span></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" name="unused_leave" class="form-control" required id="have_leave" readonly value="<?= $leaveApp->unused_leave; ?>" placeholder="0">
                                <span class="input-group-addon">Diambil</span>
                                <input type="number" min="0" name="get_year_leave" class="form-control text-right" required id="get_year_leave" placeholder="0" value="<?= $leaveApp->get_year_leave; ?>">
                                <span class="input-group-addon">hari</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label"></label>
                        <div class="col-sm-9 text-3right">
                            <span for="" class="text-muted">Sisa Cuti Tahunan : <span class="remaining_leave"><?= $leaveApp->remaining_leave; ?></span> hari</span>
                            <div class="input-group hidden">
                                <input type="text" name="remaining_leave" id="remaining_leave">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="special_leave_category" class="col-md-3 control-label">Cuti Khusus <span class="text-red"></span></label>
                        <div class="col-sm-12 col-md-9" style="margin-bottom: 8px;">
                            <select name="special_leave_category" id="special_leave_category" required class="form-control" required="required">
                                <option value=""></option>
                                <?php foreach ($leaveCategory as $lc) : ?>
                                    <option value="<?= $lc->id; ?>" <?= ($lc->id == $leaveApp->special_leave_category) ? 'selected' : ''; ?>><?= $lc->name; ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-md-3"></label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <input type="number" min="0" value="<?= $leaveApp->special_leave; ?>" name="special_leave" class="form-control text-right" readonly required id="special_leave" placeholder="0">
                                <span class="input-group-addon">hari</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="notpay_leave_desc" class="col-md-3 control-label">Cuti Urgent <span class="text-red"></span></label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input type="checkbox" value="" id="check_notpay_leave">
                                </span>
                                <input type="text" readonly value="<?= $leaveApp->notpay_leave_desc; ?>" name="notpay_leave_desc" id="notpay_leave_desc" class="form-control" placeholder="Keperluan Cuti">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-9">
                            <div class="input-group">
                                <input type="number" readonly name="notpay_leave" value="<?= $leaveApp->notpay_leave; ?>" min="0" class="text-right form-control" required id="notpay_leave" placeholder="0">
                                <span class="input-group-addon">hari</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-md-3 control-label"></label>
                        <div class="col-md-3 text-right">
                            <label for="" class="control-label">Total Hari Cuti</label>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="number" min="0" value="<?= $leaveApp->applied_leave; ?>" readonly name="applied_leave" class="form-control text-right" required id="applied_leave" placeholder="0">
                                <span class="input-group-addon">hari</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="from_date" class="col-sm-3 control-label">Dari Tgl. <span class="text-red">*</span></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input type="date" name="from_date" value="<?= $leaveApp->from_date; ?>" class="form-control" id="from_date">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="until_date" class="col-sm-3 control-label">Sampai Tgl. <span class="text-red">*</span></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input type="date" name="until_date" value="<?= $leaveApp->until_date; ?>" class="form-control" id="until_date">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="total_days" class="col-sm-3 control-label">Jumlah Hari </label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" readonly name="total_days" value="<?= $leaveApp->total_days; ?>" class="form-control" id="total_days" placeholder="0">
                                <span class="input-group-addon">hari</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Keterangan <span class="text-red">*</span></label>
                        <div class="col-md-9">
                            <textarea name="descriptions" id="descriptions" class="form-control" rows="3" required="required" placeholder="Descriptions"><?= $leaveApp->descriptions; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group hidden">
                        <label for="approval_by" class="col-md-3 control-label">Approval By <span class="text-red">*</span></label>
                        <div class="col-md-9">
                            <input type="text" name="approval_by" id="approval_by" value="<?= ($divisionHead) ? $divisionHead->id : ''; ?>">
                        </div>
                    </div>

                    <div class="form-group hidden">
                        <label for="" class="col-md-3 control-label">Info Hari Libur </label>
                        <div class="col-md-9">
                            <textarea name="holiday_info" id="info_holday2" readonly class="form-control text-red"><?= $leaveApp->holiday_info; ?></textarea>
                            <label id="info_holday" class="text-red"></label>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">

                <div class="col-md-6">
                    <div class="form-group text-center doc-special" style="display: none;">
                        <!-- <label for="special_leave_category" class="col-md-3 col-md-offset-3 text-left">Dok. Pendukung<span class="text-red"></span></label> -->
                        <div class="col-sm-12">
                            <button type="button" disabled id="btn-doc-special" onclick="$('#doc_special_leave').click()" class="btn btn-warning" style="margin-bottom:10px"><i class="fa fa-upload"></i> Upload Dok. Pendukung Cuti Khusus</button>
                            <input type="file" class="hidden" name="doc_special_leave" id="doc_special_leave">
                            <input type="text" class="hidden" name="doc_special_old">
                            <div class="">
                                <a href="<?= base_url('assets/documents/document.png'); ?>" target="_blank">
                                    <img src="<?= base_url(); ?>assets/documents/document.png" alt="" id="prev_img_special" class="img-responsive img-thumbnail" style="height: 150px;min-width:150px">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group text-center doc-notpay" style="display: none;">
                        <!-- <label for="doc_notpay_leave" class="col-md-3 control-label">Dok. Pendukung<span class="text-red"></span></label> -->
                        <div class="col-sm-12" style="margin-bottom: 8px;">
                            <button type="button" id="btn-doc-notpay" onclick="$('#doc_notpay_leave').click()" class="btn btn-warning" disabled style="margin-bottom:10px"><i class="fa fa-upload"></i> Upload Dok. Pendukung Cuti Urgent</button>
                            <input type="file" class="hidden" name="doc_notpay_leave" id="doc_notpay_leave">
                            <input type="text" class="hidden" name="doc_notpay_old">
                            <div class="">
                                <a href="<?= base_url('assets/documents/document.png'); ?>" target="_blank">
                                    <img src="<?= base_url(); ?>assets/documents/document.png" alt="" id="prev_img_notpay" class="img-responsive img-thumbnail" style="height: 150px;min-width:150px">
                                </a>
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
                <button type="button" class="btn btn-primary" id="save"><i class="fa fa-save"></i> Save</button>
                <a href="javascript:void(0)" onclick="window.history.go(-1)" class="btn btn-danger"><i class="fa fa-times"></i> Cancel</a>
            </div>
        </div>
    </div>
</div>
<div class="box box-solid rounded-1 box-shadow">
    <div class="box-body">
        <div class="box-header">
            <h2 class="box-title font-nunito">Frekuensi Cuti Sakit</h2>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-responsive table-condensed">
                <thead class="text-center bg-info">
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">Tahun</th>
                        <th class="text-center">Bulan</th>
                        <th class="text-center">Total Pengajuan</th>
                        <th class="text-center">Total Hari</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $n = $total_p = $total_h = 0;
                    foreach ($freq as $fq) : $n++;
                        $total_p += $fq->total_pengajuan;
                        $total_h += $fq->total_hari;
                    ?>
                        <tr>
                            <td class="text-center"><?= $n; ?></td>
                            <td class="text-center"><?= $fq->periode_year; ?></td>
                            <td class="text-center"><?= $namaBulan[$fq->bulan]; ?></td>
                            <td class="text-center"><?= $fq->total_pengajuan; ?></td>
                            <td class="text-center"><?= $fq->total_hari; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-center" colspan="3">Total</th>
                        <th class="text-center"><?= $total_p; ?></th>
                        <th class="text-center"><?= $total_h; ?></th>
                    </tr>
                </tfoot>
            </table>
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

    $(document).on('change', '#check_notpay_leave', function() {
        let check = $(this).prop('checked')
        console.log(check)
        if (check == true) {
            $('#notpay_leave_desc').removeAttr('readonly').addClass('notpay_leave_desc_req').val('')
            $('#notpay_leave').removeAttr('readonly').addClass('notpay_leave_req').val('')
            $('#btn-doc-notpay').removeAttr('disabled');
            $('#doc_notpay_leave').addClass('doc_notpay_leave_req');
            $('.doc-notpay').show('ease')
            return false;
        }
        $('#notpay_leave_desc').attr('readonly', 'readonly').removeClass('notpay_leave_desc_req').val('')
        $('#notpay_leave').attr('readonly', 'readonly').removeClass('notpay_leave_req').val('')
        $('#btn-doc-notpay').attr('disabled');
        $('#doc_notpay_leave').removeClass('doc_notpay_leave_req');
        $('.doc-notpay').hide('ease')
    })

    $(document).on('change', '#periode_year', function() {
        let year = $(this).val();

        if (year) {

            $.ajax({
                url: '<?= base_url('leavesapps/getLeaveYear'); ?>',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    year
                },
                success: function(result) {
                    if (result.leaveEmployee == '' || result.leaveEmployee == null) {
                        swal({
                            title: 'Warning!',
                            type: 'warning',
                            text: 'Hak cuti tidak ada/sudah habis di tahun ' + year
                        });
                        $('#have_leave').val('');
                        // remainingLeave()
                    } else {
                        if (result.leaveEmployee['leave']) {
                            $('#have_leave').val(result.leaveEmployee['leave']);
                            // remainingLeave()
                        }
                    }
                },
                error: function(result) {
                    alert('error' + result)
                },

            })
        }
        return false

    })

    $(document).on('change', '#from_date,#until_date', function() {
        let applied_leave = $('#applied_leave').val();
        let from_date = ($('#from_date').val());
        let until_date = ($('#until_date').val());

        // calc = parseInt(until_date.getTime() || 0) - parseInt(from_date.getTime() || 0);
        // days = parseInt(calc) / parseInt(1000 * 3600 * 24);
        // days = dateDifference(from_date, until_date);

        if (applied_leave) {
            $.ajax({
                url: '<?= base_url('leavesapps/getDateRange'); ?>',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    from_date,
                    until_date
                },
                success: function(result) {
                    let days = result.days;
                    var monthNames = ["January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"
                    ];
                    if (days > 0) {
                        if (result.holiDay['holiday']) {
                            holiday_desc = result.holiDay['deskripsi'];
                            holdate = new Date(result.holiDay['holiday'])
                            getDate = holdate.getDate()
                            getMonth = monthNames[holdate.getMonth()]
                            $('#info_holday2').text(getDate + " " + getMonth + " : " + holiday_desc)
                        } else {
                            $('#info_holday2').text('')
                        }
                        $('#total_days').val(days)
                        // remainingLeave()
                    } else {
                        $('#total_days').val('0')
                    }
                    // console.log(days);
                },
                error: function(result) {
                    swal("Internal Error", 'error');
                }
            })
            // return false

        } else {
            swal({
                title: 'Terjadi Kesalahan!',
                type: 'warning',
                text: 'Total Cuti belum tersedia. Mohon mengisi data pengambilan cuti terlebih dahulu.'
            });
            $(this).val('')
            return false
        }
    })

    $(document).on('change', '#special_leave_category', function() {
        if ($(this).val() == '') {
            $('#special_leave').attr('readonly', 'readonly').val('').removeClass('special_leave_req');
            $('#doc_special_leave').removeClass('doc_special_leave_req');
            $('.doc-special').hide('ease')
            getLeave()
        } else {
            let id_category = $(this).val();
            $.ajax({
                url: '<?= base_url('leavesapps/getLeaveCategory'); ?>',
                type: 'POST',
                data: {
                    id_category
                },
                dataType: 'JSON',
                success: function(result) {
                    console.log(result);
                    if (result.document == 'Y') {
                        $('#btn-doc-special').removeAttr('disabled');
                        $('.doc-special').show('ease')
                    } else {
                        $('#btn-doc-special').attr('disabled', 'disabled');
                        $('.doc-special').hide('ease')
                    }
                    if (result.values > 0) {
                        $('#special_leave').attr('readonly', 'readonly').val(result.values);
                        getLeave()
                        return false
                    }
                    $('#doc_special_leave').addClass('doc_special_leave_req');
                    $('#special_leave').removeAttr('readonly').val('').addClass('special_leave_req');
                    getLeave()
                },

                error: function(result) {
                    alert('error')
                    console.log(result);
                }
            })
        }
    })

    $(document).on('change', '#notpay_leave_category', function() {
        if ($(this).val() == '') {
            $('#notpay_leave').attr('readonly', 'readonly').val('');
            $('#doc_notpay_leave').removeClass('doc_notpay_leave_req');
            getLeave()
        } else {
            // $('#notpay_leave').removeAttr('readonly');
            let id_category = $(this).val();
            $.ajax({
                url: '<?= base_url('leavesapps/getLeaveCategory'); ?>',
                type: 'POST',
                data: {
                    id_category
                },
                dataType: 'JSON',
                success: function(result) {
                    console.log(result);
                    if (result.values > 0) {
                        $('#notpay_leave').attr('readonly', 'readonly').val(result.values);
                        getLeave()
                        return false
                    }

                    getLeave()
                },
                error: function(result) {
                    alert('error')
                    console.log(result);
                }
            })
        }


    })

    $(document).on('click', '#save', function() {
        // console.log(formdata);
        let desc = $('#descriptions').val();
        let special_leave = $('.special_leave_req').val();
        let notpay_leave = $('.notpay_leave_req').val();
        let nl_desc_req = $('.notpay_leave_desc_req').val();
        let nl_req = $('.notpay_leave_req').val();
        let from_date = $('#from_date').val();
        let until_date = $('#until_date').val();
        let applied = $('#applied_leave').val() || 0;
        let total_days = $('#total_days').val() || 0;
        let approval = $('#approval_by').val();
        let doc_special_leave = $('.doc_special_leave_req')[0] || '';
        let doc_notpay_leave = $('.doc_notpay_leave_req')[0] || '';
        let doc_special = (doc_special_leave) ? doc_special_leave.files.length : '';
        let doc_notpay = (doc_notpay_leave) ? doc_notpay_leave.files.length : '';

        console.log((doc_special) + ", " + doc_notpay);
        if (applied <= 0) {
            swal({
                title: 'Terjadi Kesalahan!',
                type: 'warning',
                text: 'Mohon mengisi pengambilan cuti terlebih dahulu!'
            })
            return false;
        } else if (special_leave <= 0) {
            swal({
                title: 'Terjadi Kesalahan!',
                type: 'warning',
                text: 'Mohon mengisi pengambilan jumlah hari cuti khusus terlebih dahulu!'
            })
            return false;
        } else if (nl_desc_req == '') {
            swal({
                title: 'Terjadi Kesalahan!',
                type: 'warning',
                text: 'Mohon mengisi keterangan keperluan cuti urgent terlebih dahulu!'
            })
            return false;
        } else if (nl_req <= 0) {
            swal({
                title: 'Terjadi Kesalahan!',
                type: 'warning',
                text: 'Mohon mengisi pengambilan jumlah hari cuti urgent terlebih dahulu!'
            })
            return false;
        } else if (from_date == '') {
            swal({
                title: 'Terjadi Kesalahan!',
                type: 'warning',
                text: 'Tanggal awal cuti belum di isi.'
            })
            return false;
        } else if (until_date == '') {
            swal({
                title: 'Terjadi Kesalahan!',
                type: 'warning',
                text: 'Tanggal akhir cuti belum di isi.'
            })
            return false;
        } else if (parseInt(total_days) > parseInt(applied)) {
            swal({
                title: 'Terjadi Kesalahan!',
                type: 'warning',
                text: 'Jumlah hari yang diajukan tidak sama atau melebihi dari total cuti!.'
            })
            return false;
        } else if (parseInt(total_days) < parseInt(applied)) {
            swal({
                title: 'Terjadi Kesalahan!',
                type: 'warning',
                text: 'Jumlah hari yang diajukan tidak sama atau kurang dari total cuti!.'
            })
            return false;
        } else if (desc == '') {
            swal({
                title: 'Terjadi Kesalahan!',
                type: 'warning',
                text: 'Keterangan cuti belum di isi.'
            })
            return false;
        } else if (approval == '') {
            swal({
                title: 'Terjadi Kesalahan!',
                type: 'warning',
                text: 'Data persetujuan atasan belum diatur. Mohon menhubungi HRD terlebih dahulu.'
            })
            return false;
        } else if (doc_special === 0) {
            swal({
                title: 'Terjadi Kesalahan!',
                type: 'warning',
                text: 'Dokumen Pendukung cuti khusus belum diupload. Mohon upload dokumen pendukung terlebih dahulu.'
            })
            return false;
        } else if (doc_notpay === 0) {
            swal({
                title: 'Terjadi Kesalahan!',
                type: 'warning',
                text: 'Dokumen Pendukung cuti urgent belum diupload. Mohon upload dokumen pendukung terlebih dahulu.'
            })

        } else {
            let formdata = new FormData($('#form-leave')[0]);
            $.ajax({
                url: '<?= base_url('leavesapps/save'); ?>',
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
                            window.open('<?= base_url('leavesapps/'); ?>', '_self');
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

    })

    $(document).on('change', '#get_year_leave,#special_leave,#notpay_leave', function() {
        getLeave();
    })

    function getLeave() {
        let yearLeave = $('#have_leave').val() || 0;
        let getYearLeave = $('#get_year_leave').val() || 0;
        let specialLeave = $('#special_leave').val() || 0;
        let otherLeave = $('#notpay_leave').val() || 0;

        if (getYearLeave > yearLeave) {
            swal({
                title: 'Terjadi kesalah',
                text: 'Jumlah pengambilan cuti melebihin sisa cuti!',
                type: 'warning'
            })
            // alert('Jumlah pengambilan cuti melebihin sisa cuti!');
            $('#get_year_leave').val('')
            $('#remaining_leave').val('0');
            $('.remaining_leave').text('0');
        } else {
            remLeave = (parseInt(yearLeave)) - parseInt(getYearLeave);
            $('#remaining_leave').val(remLeave);
            $('.remaining_leave').text(remLeave);
        }

        totalLeave = parseInt(getYearLeave) + parseInt(specialLeave) + parseInt(otherLeave);
        $('#applied_leave').val(totalLeave);
        return false
    }

    $(document).on('change', '#doc_notpay_leave', function(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('prev_img_notpay');
            output.src = reader.result;
            // dataUpload = new FormData($('#dataUpload')[0]);
        }
        reader.readAsDataURL(event.target.files[0]);

    })

    $(document).on('change', '#doc_special_leave', function(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('prev_img_special');
            output.src = reader.result;
            // dataUpload = new FormData($('#dataUpload')[0]);
        }
        reader.readAsDataURL(event.target.files[0]);

    })
</script>