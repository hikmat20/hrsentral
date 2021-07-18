<?php
$this->load->view('include/side_menu'); ?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h2 class="box-title text-bold"><?= $title; ?></h2>
    </div>
    <div class="box-body">
        <div class="row box-body">
            <form class="form-horizontal" id="form-leave">

                <div class="col-md-6">
                    <input type="hidden" name="id" value="<?= $leaveApp->id; ?>">
                    <div class="form-group">
                        <label for="employee_id" class="col-sm-3 control-label">Employee <span class="text-red">*</span></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                <div class="input-group-addon bg-gray"><?= $leaveApp->employee_id ?></div>
                                <input type="text" class="form-control" id="employee_id" required readonly value="<?= $leaveApp->employee_id; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="division" class="col-sm-3 control-label">Division</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="division_id" readonly value="<?= $division->name; ?>">
                        </div>
                    </div>
                    <?php
                    $first_year     = date('Y', strtotime($employee['hiredate']));
                    $year_now       = date('Y');
                    $Arr_year       = range($first_year, $year_now);
                    $List_year    = array_combine($Arr_year, $Arr_year);
                    // echo '<pre>';
                    // print_r($Arr_combine);
                    // echo '<pre>';
                    // exit;
                    ?>
                    <div class="form-group">
                        <label for="periode_year" class="col-sm-3 control-label">Year Periode <span class="text-red">*</span></label>
                        <div class="col-sm-9">
                            <select name="periode_year" id="periode_year" class="form-control">
                                <option value=""></option>
                                <?php foreach ($List_year as $year) : ?>
                                    <option value="<?= $year; ?>" <?= ($year == $leaveApp->periode_year) ? 'selected' : ''; ?>><?= $year; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <!-- <div class="input-group">
                                <input type="text" name="periode" class="form-control" id="periode" readonly placeholder="Periode">
                                <span class="input-group-addon">day(s)</span>
                            </div> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="have_leave" class="col-sm-3 control-label">Have Leaves <span class="text-red">*</span></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" name="unused_leave" class="form-control" required id="have_leave" readonly placeholder="0" value="<?= $leaveApp->unused_leave; ?>">
                                <span class="input-group-addon">day(s)</span>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="from_date" class="col-sm-3 control-label">From Date <span class="text-red">*</span></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input type="date" name="from_date" class="form-control" id="from_date" value="<?= $leaveApp->from_date; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="until_date" class="col-sm-3 control-label">Until Date <span class="text-red">*</span></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input type="date" name="until_date" class="form-control" id="until_date" value="<?= $leaveApp->until_date; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="applied_leave" class="col-sm-3 control-label">Applied Leave </label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" readonly name="applied_leave" class="form-control" id="applied_leave" placeholder="0" value="<?= $leaveApp->applied_leave; ?>">
                                <span class="input-group-addon">day(s)</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="remaining_leave" class="col-sm-3 control-label">Remaining Leaves</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" name="remaining_leave" class="form-control" id="remaining_leave" readonly placeholder="0" value="<?= $leaveApp->remaining_leave; ?>">
                                <span class="input-group-addon">day(s)</span>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="leave_category" class="col-md-3 control-label">Leave Category <span class="text-red">*</span></label>
                        <div class="col-md-9">
                            <select name="leave_category" id="leave_category" required class="form-control" rows="3" required="required">
                                <option value=""></option>
                                <?php foreach ($leaveCategory as $lc) : ?>
                                    <option value="<?= $lc->id; ?>" <?= ($leaveApp->leave_category == $lc->id) ? 'selected' : ''; ?>><?= $lc->name; ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Description <span class="text-red">*</span></label>
                        <div class="col-md-9">
                            <textarea name="descriptions" id="descriptions" class="form-control" rows="3" required="required" placeholder="Descriptions"><?= $leaveApp->descriptions; ?></textarea>
                        </div>
                    </div>


                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="approval_by" class="col-md-3 control-label">Approval By <span class="text-red">*</span></label>
                        <div class="col-md-9">
                            <select name="approval_by" id="approval_by" class="form-control">
                                <option value=""></option>
                                <?php foreach ($employees as $list) : ?>
                                    <option value="<?= $list->id; ?>" <?= ($leaveApp->approval_by == $list->id) ? 'selected' : ''; ?>><?= $list->name; ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="info_holday2" class="col-md-3 control-label">Holiday Info <span class="text-red">*</span></label>
                        <div class="col-md-9">
                            <textarea name="holiday_info" id="info_holday2" readonly class="form-control text-red"><?= $leaveApp->holiday_info; ?></textarea>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <div class="box-footer">
        <div class="row">
            <div class="col-md-5 text-right col-md-offset-1">
                <button type="button" class="btn btn-primary" id="save_update"><i class="fa fa-save"></i> Update</button>
            </div>
            <div class="col-md-6">
                <a href="<?= base_url('leavesapps/'); ?>" class="btn btn-danger"><i class="fa fa-times"></i> Cancel</a>
            </div>
        </div>
    </div>

    <?php

    // echo '<pre>';
    // print_r($leaveApp);
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
                        remainingLeave()
                    } else {
                        if (result.leaveEmployee['leave']) {
                            $('#have_leave').val(result.leaveEmployee['leave']);
                            remainingLeave()
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
        let leavehave = $('#have_leave').val();
        let from_date = ($('#from_date').val());
        let until_date = ($('#until_date').val());

        // calc = parseInt(until_date.getTime() || 0) - parseInt(from_date.getTime() || 0);
        // days = parseInt(calc) / parseInt(1000 * 3600 * 24);
        // days = dateDifference(from_date, until_date);

        if (leavehave) {
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
                            console.log(holdate);
                            console.log(getMonth);
                            // $('#info_holday').text(getDate + " " + getMonth + " : " + holiday_desc)
                            $('#info_holday2').text(getDate + " " + getMonth + " : " + holiday_desc)
                        } else {
                            $('#info_holday2').text('')
                        }
                        $('#applied_leave').val(days)
                        remainingLeave()
                    } else {
                        $('#applied_leave').val('0')
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
                text: 'Hak Cuti belum di isi.'
            });
            $(this).val('')
            return false
        }
    })

    function remainingLeave() {
        let haveLeave = parseInt($('#have_leave').val()) || 0;
        let applied = parseInt($('#applied_leave').val()) || 0;
        // alert(applied + "," + haveLeave)
        if (applied) {
            if (applied > haveLeave) {
                swal({
                    title: 'Warning!',
                    text: 'Jumlah hari yang diajukan melebihi hak cuti!',
                    type: 'warning'
                })
                $('#until_date').val('').change();
                $('#remaining_leave').val('0');
                return false
            } else {
                remainingDay = parseInt(haveLeave) - parseInt(applied);
                day = (remainingDay >= 0) ? remainingDay : '0';
                $('#remaining_leave').val(day);
                return false
            }
        }
    }


    $(document).on('click', '#save_update', function() {

        let year = $('#periode_year').val();
        let leaveCat = $('#leave_category').val();
        let desc = $('#descriptions').val();
        let approval = $('#approval_by').val();

        console.log(year + ", " + leaveCat + ", " + desc + ", " + approval);
        if (year == '') {
            swal({
                title: 'Warning',
                type: 'warning',
                text: 'Periode tahun belum di isi.'
            })
        } else if (leaveCat == '') {
            swal({
                title: 'Warning',
                type: 'warning',
                text: 'Kategory cuti belum di isi.'
            })
        } else if (desc == '') {
            swal({
                title: 'Warning',
                type: 'warning',
                text: 'Deskripsi cuti belum di isi.'
            })
        } else if (approval == '') {
            swal({
                title: 'Warning',
                type: 'warning',
                text: 'Approval cuti belum di isi.'
            })
        } else {

            let formdata = new FormData($('#form-leave')[0]);
            $.ajax({
                url: '<?= base_url('leavesapps/save_update'); ?>',
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
</script>