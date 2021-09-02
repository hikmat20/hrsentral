<?php
$this->load->view('include/side_menu');
$namaBulan = ["Januari", "Februaru", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
?>

<div class="box box-solid rounded-1 box-shadow">
    <div class="box-header">
        <h2 class="box-title font-nunito" style="padding: 10px;"><?= $title; ?></h2>
    </div>
    <div class="box-body">
        <form class="form-horizontal" id="form-substituion" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="hidden">
                        <div class="form-group">
                            <label for="employee_id" class="col-sm-3 control-label">Employee <span class="text-red">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="id" id="id" readonly value="<?= $employee->id; ?>">
                                <input type="text" class="form-control" name="employee_id" id="employee_id" readonly value="<?= $employee->employee_id; ?>">
                                <input type="text" class="form-control" name="name" id="employee_name" readonly value="<?= $employee->name; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="division" class="col-sm-3 control-label">Division</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="division_id" readonly value="<?= $employee->division_id; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="periode_year" class="col-sm-3 control-label">Year Periode <span class="text-red">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="periode_year" class="form-control" value="<?= ($employee->periode_year) ? $employee->periode_year : date('Y'); ?>">
                            </div>
                        </div>
                    </div>

                    <!-- ! -->
                    <!-- <div class="form-group">
                        <label for="have_leave" class="col-sm-3 control-label">Tipe Pengganti <span class="text-red">*</span></label>
                        <div class="col-sm-9">
                            <select name="type" class="form-control">
                                <option value=""></option>
                                <option value="HALF_DAY">Half Day</option>
                                <option value="FULL_DAY">Full Day</option>
                            </select>
                        </div>
                    </div> -->

                    <div class="form-group">
                        <label for="from_date" class="col-sm-3 control-label">Dari Tgl. <span class="text-red">*</span></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input type="date" name="from_date" min="<?= date('Y-m-d', strtotime(date('Y-m-d') . "-1 Month")); ?>" value="<?= $employee->from_date; ?>" class="form-control" id="from_date">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="until_date" class="col-sm-3 control-label">Sampai Tgl. <span class="text-red">*</span></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input type="date" name="until_date" min="<?= date('Y-m-d', strtotime(date('Y-m-d') . "-1 Month")); ?>" value="<?= $employee->until_date; ?>" class="form-control" id="until_date">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="total_days" class="col-sm-3 control-label">Jumlah Hari </label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" readonly name="total_days" value="<?= $employee->total_days; ?>" class="form-control" id="total_days" placeholder="0">
                                <span class="input-group-addon">hari</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Permintaan <span class="text-red">*</span></label>
                        <div class="col-md-9">
                            <select name="request_by" id="request_by" class="form-control" style="margin-bottom:10px">
                                <option value=""></option>
                                <option value="CLIENT" <?= ($employee->request_by == 'CLIENT') ? 'selected' : ''; ?>>Client</option>
                                <option value="OTHER" <?= ($employee->request_by == 'OTHER') ? 'selected' : ''; ?>>Lainnya</option>
                            </select>
                            <input style="margin-top:10px" <?= ($employee->reason_request) ? '' : 'disabled'; ?> name="reason_request" value="<?= ($employee->reason_request) ? $employee->reason_request : ''; ?>" id="reason_request" class="form-control" required="required" placeholder="Asal Permintaan Lainnya">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Alasan <span class="text-red">*</span></label>
                        <div class="col-md-9">
                            <textarea name="reason" id="reason" class="form-control" rows="3" required="required" placeholder="Alasan"><?= $employee->reason; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group hidden">
                        <label for="approval_by" class="col-md-3 control-label">Approval By <span class="text-red">*</span></label>
                        <div class="col-md-9">
                            <input type="text" name="approval_by" id="approval_by" value="<?= ($employee->approval_by) ? $employee->approval_by : '' ?>">
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group text-center doc">
                        <!-- <label for="sick_leave_category" class="col-md-3 col-md-offset-3 text-left">Dok. Pendukung<span class="text-red"></span></label> -->
                        <div class="col-sm-12">
                            <button type="button" id="btn-doc" onclick="$('#doc').click()" class="btn btn-warning" style="margin-bottom:10px"><i class="fa fa-upload"></i> Upload Dok. Pendukung</button>
                            <input type="file" class="hidden" name="doc" id="doc">
                            <input type="text" class="hidden" value="<?= ($employee->doc) ? $employee->doc : ''; ?>" name="doc_old">
                            <div class="">
                                <a href="<?= base_url('assets/dokumen_pengajuan/'); ?><?= ($employee->doc) ? $employee->doc : 'document.png'; ?>" target="_blank">
                                    <img src="<?= base_url('assets/dokumen_pengajuan/'); ?><?= ($employee->doc) ? $employee->doc : 'document.png'; ?>" alt="" id="prev" class="img-responsive img-thumbnail" style="max-height: 250px;">
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
            <div class="col-md-6">
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
        // document.getElementById('from_date-').max = new Date(new Date().getTime() - new Date().getTimezoneOffset() * 60000).toISOString().split("T")[0];
        // document.getElementById('until_date-').max = new Date(new Date().getTime() - new Date().getTimezoneOffset() * 60000).toISOString().split("T")[0];
    });


    $(document).on('change', '#from_date,#until_date', function() {
        let from_date = ($('#from_date').val());
        let until_date = ($('#until_date').val());

        // calc = parseInt(until_date.getTime() || 0) - parseInt(from_date.getTime() || 0);
        // days = parseInt(calc) / parseInt(1000 * 3600 * 24);
        // days = dateDifference(from_date, until_date);

        if (from_date != '' || until_date != '') {
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

        }
    })

    $(document).on('change', '#request_by', function() {
        let type = $(this).val();
        if (type == 'OTHER') {
            $('#reason_request').prop('disabled', '')
            $('#reason_request').addClass('oth_req')
        } else {
            $('#reason_request').prop('disabled', 'disabled')
            $('#reason_request').removeClass('oth_req')
            $('#reason_request').val('')
        }
    })


    $(document).on('click', '#save', function() {
        // console.log(formdata);
        let reason = $('#reason').val();
        let from_date = $('#from_date').val();
        let until_date = $('#until_date').val();
        let total_days = $('#total_days').val() || 0;
        let approval = $('#approval_by').val();
        let request = $('#request_by').val();
        let oth_req = $('.oth_req').val();
        // return false
        if (from_date == '') {
            swal({
                title: 'Terjadi Kesalahan!',
                type: 'warning',
                text: 'Tanggal awal pengajuan cuti pengganti belum di isi.'
            })
            return false;
        } else if (until_date == '') {
            swal({
                title: 'Terjadi Kesalahan!',
                type: 'warning',
                text: 'Tanggal akhir pengajuan cuti pengganti belum di isi.'
            })
            return false;
        } else if (total_days == '' || total_days == '0') {
            swal({
                title: 'Terjadi Kesalahan!',
                type: 'warning',
                text: 'Jumlah hari masih kosong.'
            })
            return false;
        } else if (reason == '') {
            swal({
                title: 'Terjadi Kesalahan!',
                type: 'warning',
                text: 'Alasan pengajuan cuti belum di isi.'
            })
            return false;
        } else if (oth_req == '') {
            swal({
                title: 'Terjadi Kesalahan!',
                type: 'warning',
                text: 'Alasan Permintaan pengajuan cuti belum di isi.'
            })
            return false;
        } else if (approval == '') {
            swal({
                title: 'Terjadi Kesalahan!',
                type: 'warning',
                text: 'Data persetujuan atasan belum diatur. Mohon menhubungi HRD terlebih dahulu.'
            })
            return false;
        } else {
            save()
        }
    })

    function save() {
        let formdata = new FormData($('#form-substituion')[0]);
        $.ajax({
            url: '<?= base_url('pengganti/save'); ?>',
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
                        window.open('<?= base_url('pengganti/'); ?>', '_self');
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


    $(document).on('change', '#doc', function(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('prev');
            output.src = reader.result;
            // dataUpload = new FormData($('#dataUpload')[0]);
        }
        reader.readAsDataURL(event.target.files[0]);

    })
</script>