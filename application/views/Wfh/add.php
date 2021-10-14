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
                                <input type="text" class="form-control" name="employee_id" id="employee_id" required readonly value="<?= $employee['id']; ?>">
                                <input type="text" class="form-control" name="name" id="employee_name" readonly value="<?= $employee['name']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="division" class="col-sm-3 control-label">Division</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="division_id" readonly value="<?= $division->id; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="periode_year" class="col-sm-3 control-label">Year Periode <span class="text-red">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="periode_year" class="form-control" value="<?= date('Y'); ?>">
                            </div>
                        </div>
                    </div>

                    <!-- ! -->

                    <div class="form-group">
                        <label for="from_date" class="col-sm-3 control-label">Dari Tgl. <span class="text-red">*</span></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input type="date" name="from_date" min="<?= date('Y-m-d', strtotime(date('Y-m-d') . "-1 Month")); ?>" class="form-control" id="from_date">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="until_date" class="col-sm-3 control-label">Sampai Tgl. <span class="text-red">*</span></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input type="date" name="until_date" min="<?= date('Y-m-d', strtotime(date('Y-m-d') . "-1 Month")); ?>" class="form-control" id="until_date">
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="input-type-day" style="display: none;">
                        <label for="days_value" class="col-sm-3 control-label">Tipe Pengganti <span class="text-red">*</span></label>
                        <div class="col-sm-9">
                            <select name="type_day" id="type_day" class="form-control">
                                <option value=""></option>
                                <option value="HALF_DAY">Half Day</option>
                                <option value="FULL_DAY">Full Day</option>
                            </select>
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
                        <label for="" class="col-md-3 control-label">Alasan <span class="text-red">*</span></label>
                        <div class="col-md-9">
                            <textarea name="reason" id="reason" class="form-control" rows="3" required="required" placeholder="Alasan"></textarea>
                        </div>
                    </div>

                    <div class="form-group hidden">
                        <label for="approval_by" class="col-md-3 control-label">Approval By <span class="text-red">*</span></label>
                        <div class="col-md-9">
                            <input type="text" name="approval_by" id="approval_by" value="<?= ($divisionHead) ? $divisionHead->id : ''; ?>">
                        </div>
                    </div>
                </div>
            </div>
            <br>

            <div class="">
                <h4>Data Kegiatan</h4>
                <table id="table_planning" class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th class="text-center" width="20px">No</th>
                            <th class="text-center">Rencana Kerja</th>
                            <th class="text-center" width="8%">QTY</th>
                            <!-- <th class="text-center">Aktual Hasil</th>
                            <th class="text-center" width="8%">QTY</th> -->
                            <th class="text-center" width="5%">Opsi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <button type="button" id="add_planning" class="btn btn-primary"><i class="fa fa-plus"></i> Rencana Kerja</button>
            </div>
            <hr>
            <div class="" style="margin-top: 20px;">
                <div class="form-group">
                    <!-- <label class="col-md-2" for="">Permasalahan</label>
                    <div class="col-md-10">
                        <textarea name="problems" placeholder="Permasalahan" rows="5" id="problems" class="form-control"></textarea>
                    </div> -->

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
        let from_date = new Date($('#from_date').val());
        let until_date = new Date($('#until_date').val());

        calc = parseInt(until_date.getTime() || 0) - parseInt(from_date.getTime() || 0);
        days = parseInt(calc) / parseInt(1000 * 3600 * 24) + 1;
        // days = dateDifference(from_date, until_date);
        // alert(days)
        if (days > 0) {
            $('#total_days').val(days)
            if (days == 1) {
                $('#type_day_chosen').css({
                    width: '100%'
                });
                $('#input-type-day').show('ease')
                // $('#type_day').prop('readonly', true).trigger("chosen:updated");;
            } else {
                $('#input-type-day').hide('ease')
                $('#type_day').val('');
            }
        } else {
            $('#total_days').val('0')
        }

        return false;
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
        }
    })

    $(document).on('change', '#type_day', function() {
        let val = $(this).val()

        if (val == 'HALF_DAY') {
            $('#total_days').val('0.5')
        } else {
            $('#total_days').val('1')
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

        } else if (approval == '') {
            swal({
                title: 'Terjadi Kesalahan!',
                type: 'warning',
                text: 'Data persetujuan atasan belum diatur. Mohon mengubungi HRD terlebih dahulu.'
            })
            return false;
        } else if ($('#table_planning tbody tr').length == 0) {
            swal({
                title: 'Terjadi Kesalahan!',
                type: 'warning',
                text: 'Data Rencana Kerja belum diisi. Mohon mengisi Rencana Kerja terlebih dahulu.'
            })
            return false;
        } else {
            save()
        }
    })

    function save() {
        let formdata = new FormData($('#form-substituion')[0]);
        $.ajax({
            url: '<?= base_url('wfh/save'); ?>',
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
                        window.open('<?= base_url('wfh/'); ?>', '_self');
                    }, 1500)
                } else if (result.status == 0) {
                    swal({
                        title: 'Kesalahan',
                        text: result.msg,
                        type: 'warning',
                    });
                }
                // console.log(result + ", " + response);
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

    $(document).on('change', '#total_days', function() {
        let days = $(this).val() || 0;
        if (days > 1) {
            swal({
                title: "Perhatian!!",
                text: 'Jumlah hari tidak bisa melebihi dari 1 hari',
                type: 'warning',
            })
            $(this).val('');
            return false;
        }
    })

    $(document).on('click', '#add_planning', function() {
        let row = $('#table_planning tbody tr').length || 0
        row = parseInt(row) + parseInt(1);
        let html = `
        <tr>
            <td>` + row + `</td>
            <td><textarea name="works[` + row + `][work_planning]" class="form-control" placeholder="Rencana kerja"></textarea></td>
            <td><input type="text" name="works[` + row + `][qty_planning]" class="form-control" placeholder="0"></td>
            <td><button type="button" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i></button></td>
            </tr>
            `;
        // <td><textarea name="works[` + row + `][work_actual]" class="form-control" placeholder="Aktual pekerjaan"></textarea></td>
        // <td><input type="text" name="works[` + row + `][qty_actual]" class="form-control" placeholder="0"></td>
        $('#table_planning tbody').append(html);
        // console.log(html);

    })

    $(document).on('click', '.delete', function() {
        $(this).parents('tr').remove();
    })
</script>