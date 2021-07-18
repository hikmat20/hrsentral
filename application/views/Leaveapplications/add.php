<?php
$this->load->view('include/side_menu'); ?>

<div class="box box-solid rounded-1">
    <div class="box-header">
        <h2 class="box-title font-nunito" style="padding: 10px;"><?= $title; ?></h2>
    </div>
    <div class="box-body">
        <div class="row box-body">
            <form class="form-horizontal" id="form-leave" enctype="multipart/form-data">

                <div class="col-md-6">
                    <div class="hidden">
                        <div class="form-group">
                            <label for="employee_id" class="col-sm-3 control-label">Employee <span class="text-red">*</span></label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                    <div class="input-group-addon bg-gray"><?= $employee['id'] ?></div>
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
                                <input type="text" name="periode_year" class="form-control" value="<?= date('Y'); ?>">
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
                                <input type="text" name="unused_leave" class="form-control" required id="have_leave" readonly value="<?= $totalLeave->leave; ?>" placeholder="0">
                                <span class="input-group-addon">Diambil</span>
                                <input type="text" name="get_year_leave" class="form-control" required id="get_year_leave" placeholder="0">
                                <span class="input-group-addon">hari</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label"></label>
                        <div class="col-sm-9 text-3right">
                            <span for="" class="text-muted">Sisa Cuti Tahunan : <span class="remaining_leave"><?= $totalLeave->leave; ?></span> hari</span>
                            <div class="input-group hidden">
                                <input type="text" name="remaining_leave" id="remaining_leave">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="special_leave_category" class="col-md-3 control-label">Cuti Khusus <span class="text-red"></span></label>
                        <div class="col-sm-12 col-md-9 col-lg-6" style="margin-bottom: 8px;">
                            <select name="special_leave_category" id="special_leave_category" required class="form-control" required="required">
                                <option value=""></option>
                                <?php foreach ($leaveCategory as $lc) : ?>
                                    <option value="<?= $lc->id; ?>"><?= $lc->name; ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="col-md-6 col-sm-6 col-lg-3">
                            <div class="input-group">
                                <input type="text" name="special_leave" class="form-control" readonly required id="special_leave" placeholder="0">
                                <span class="input-group-addon">hari</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="special_leave_category" class="col-md-3 control-label">Dok. Pendukung<span class="text-red"></span></label>
                        <div class="col-sm-12 col-md-9 col-lg-6" style="margin-bottom: 8px;">
                            <button type="button" onclick="$('#doc_special_leave').click()" class="btn btn-info"><i class="fa fa-upload"></i> Upload Dokumen</button>
                            <input type="file" class="hidden" name="doc_special_leave" id="doc_special_leave">
                            <a href="<?= base_url('assets/documents/surat.jpg'); ?>" target="_blank">
                                <div class="img-responsive hidden" style="padding-top:10px ;">
                                    <img src="<?= base_url('assets/documents/noimage'); ?>" alt="dokumen-pendukung" class="rounded-1" height="100px">
                                </div>
                            </a>
                            <?php
                            // . ($employee->doc_special_leave) ? $employee->doc_special_leave : "noimage.jpg"; 
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="notpay_leave_desc" class="col-md-3 control-label">Cuti Urgent <span class="text-red"></span></label>
                        <div class="col-md-6" style="margin-bottom: 8px;">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input type="checkbox" value="" id="check_notpay_leave">
                                </span>
                                <input type="text" name="notpay_leave_desc" id="notpay_leave_desc" class="form-control" placeholder="Keperluan Cuti">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="text" name="notpay_leave" class="form-control" required id="notpay_leave" placeholder="0">
                                <span class="input-group-addon">hari</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="doc_notpay_leave" class="col-md-3 control-label">Dok. Pendukung<span class="text-red"></span></label>
                        <div class="col-sm-12 col-md-9 col-lg-6" style="margin-bottom: 8px;">
                            <button type="button" onclick="$('#doc_notpay_leave').click()" class="btn btn-info"><i class="fa fa-upload"></i> Upload Dokumen</button>
                            <input type="file" class="hidden" name="doc_notpay_leave" id="doc_notpay_leave">
                            <a href="<?= base_url('assets/documents/surat.jpg'); ?>" target="_blank">
                                <div class="img-responsive hidden" style="padding-top:10px ;">
                                    <img src="<?= base_url('assets/documents/noimage.jpg'); ?>" alt="dokumen-pendukung" class="rounded-1" height="100px">
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-md-3 control-label"></label>
                        <div class="col-md-6 text-right">
                            <label for="" class="control-label">Total Hari Cuti</label>
                        </div>

                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="text" readonly name="applied_leave" class="form-control" required id="applied_leave" placeholder="0">
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
                                <input type="date" name="from_date" class="form-control" id="from_date">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="until_date" class="col-sm-3 control-label">Sampai Tgl. <span class="text-red">*</span></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input type="date" name="until_date" class="form-control" id="until_date">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="total_days" class="col-sm-3 control-label">Jumlah Hari </label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" readonly name="total_days" class="form-control" id="total_days" placeholder="0">
                                <span class="input-group-addon">hari</span>
                            </div>
                        </div>
                    </div>



                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Keterangan <span class="text-red">*</span></label>
                        <div class="col-md-9">
                            <textarea name="descriptions" id="descriptions" class="form-control" rows="3" required="required" placeholder="Descriptions"></textarea>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group hidden">
                        <label for="approval_by" class="col-md-3 control-label">Approval By <span class="text-red">*</span></label>
                        <div class="col-md-9">
                            <input type="text" name="approval_by" id="division_head" value="<?= ($divisionHead) ? $divisionHead->id : ''; ?>">
                        </div>
                    </div>
                </div>

                <div class="col-md-6 hidden">
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Info Hari Libur </label>
                        <div class="col-md-9">
                            <textarea name="holiday_info" id="info_holday2" readonly class="form-control text-red"></textarea>
                            <label id="info_holday" class="text-red"></label>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <div class="box-footer">
        <div class="row">
            <div class="col-md-6 text-center">
                <button type="button" class="btn btn-primary" id="save"><i class="fa fa-save"></i> Save</button>
                <a href="javascript:void(0)" onclick="window.history.go(-1)" class="btn btn-danger"><i class="fa fa-times"></i> Cancel</a>
            </div>
            <div class="col-md-6">
            </div>
        </div>
    </div>

    <?php

    // echo '<pre>';
    // print_r($divisionHead);
    // echo '<pre>';
    // exit;

    ?>

</div>

<?php $this->load->view('include/footer'); ?>
<script>
    $(document).ready(function() {
        $('.btn-spinner').click(function() {
            $('#spinner').modal('show');
        });

    });

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
                title: 'Warning!',
                type: 'warning',
                text: 'Total Cuti belum di isi. Mohon mengisi data pengambilan cuti.'
            });
            $(this).val('')
            return false
        }
    })

    $(document).on('change', '#special_leave_category', function() {
        if ($(this).val() == '') {
            $('#special_leave').attr('readonly', 'readonly').val('');
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
                    if (result.values > 0) {
                        $('#special_leave').attr('readonly', 'readonly').val(result.values);
                        getLeave()
                        return false
                    }
                    $('#special_leave').removeAttr('readonly').val('');
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
                    $('#notpay_leave').removeAttr('readonly').val('');
                    getLeave()
                },
                error: function(result) {
                    alert('error')
                    console.log(result);
                }
            })
        }


    })

    function cek() {
        let applied = parseInt($('#applied_leave').val()) || 0;
        let total_days = parseInt($('#total_days').val()) || 0;
        // alert(applied + "," + total_days)
        if (applied) {
            if (total_days < applied) {
                swal({
                    title: 'Terjadi Kesalahan!',
                    text: 'Jumlah hari yang diajukan tidak sesuai/kurang dari total cuti!',
                    type: 'warning'
                })
                // $('#until_date').val('').change();
                // $('#applied_leave').val('0');
                return false
            } else if (total_days > applied) {
                swal({
                    title: 'Warning!',
                    text: 'Jumlah hari yang diajukan melebihi total cuti!',
                    type: 'warning'
                })
                $('#until_date').val('').change();
                $('#applied_leave').val('0');
                return false
            }
            // else {
            //     return false
            //     // remainingDay = parseInt(haveLeave) - parseInt(applied);
            //     // day = (remainingDay >= 0) ? remainingDay : '0';
            //     // $('#remaining_leave').val(day);
            // }
        }
    }

    $(document).on('click', '#save', function() {
        let desc = $('#descriptions').val();
        let from_date = $('#from_date').val();
        let until_date = $('#until_date').val();
        let applied = $('#applied_leave').val() || 0;
        let total_days = $('#total_days').val() || 0;
        console.log(desc + ", " + from_date + ", " + until_date + ", " + applied + ", " + total_days);
        if (applied <= 0) {
            swal({
                title: 'Terjadi Kesalahan!',
                type: 'warning',
                text: 'Mohon mengisi pengambilan cuti terlebih dahulu!'
            })
        } else if (from_date == '') {
            swal({
                title: 'Terjadi Kesalahan!',
                type: 'warning',
                text: 'Tanggal awal cuti belum di isi.'
            })
        } else if (until_date == '') {
            swal({
                title: 'Terjadi Kesalahan!',
                type: 'warning',
                text: 'Tanggal akhir cuti belum di isi.'
            })
        } else if (parseInt(total_days) > parseInt(applied)) {
            swal({
                title: 'Terjadi Kesalahan!',
                type: 'warning',
                text: 'Jumlah hari yang diajukan tidak sama atau melebihi dari total cuti!.'
            })
        } else if (parseInt(total_days) < parseInt(applied)) {
            swal({
                title: 'Terjadi Kesalahan!',
                type: 'warning',
                text: 'Jumlah hari yang diajukan tidak sama atau kurang dari total cuti!.'
            })
        } else if (desc == '') {
            swal({
                title: 'Terjadi Kesalahan!',
                type: 'warning',
                text: 'Keterangan cuti belum di isi.'
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
                            title: 'Error',
                            text: result.msg,
                            type: 'error',
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
            alert('Jumlah pengambilan cuti melebihin sisa cuti!');
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
</script>