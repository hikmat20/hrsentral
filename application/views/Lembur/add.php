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
                        <label for="from_date" class="col-sm-3 control-label">Date <span class="text-red">*</span></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input type="date" name="date" min="<?= date('Y-m-d', strtotime(date('Y-m-d') . "0 Day")); ?>" class="form-control" id="date">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="start_time" class="col-sm-3 control-label">Jam Mulai <span class="text-red">*</span></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
                                <input type="time" name="start_time" min="<?= date('Y-m-d', strtotime(date('Y-m-d') . "0 Day")); ?>" class="form-control" id="start_time">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="end_time" class="col-sm-3 control-label">Jam Selesai <span class="text-red">*</span></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
                                <input type="time" name="end_time" min="<?= date('Y-m-d', strtotime(date('Y-m-d') . "0 Day")); ?>" class="form-control" id="end_time">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="total_time" class="col-sm-3 control-label">Total Jam </label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" readonly name="total_time" class="form-control" id="total_time" placeholder="0">
                                <span class="input-group-addon">Jam</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">No SO/SPK <span class="text-red">*</span></label>
                        <div class="col-md-9">
                            <input type="text" name="no_so" id="no_so" class="form-control" placeholder="No SO/SPK">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Alasan <span class="text-red">*</span></label>
                        <div class="col-md-9">
                            <textarea name="reason" id="reason" class="form-control" rows="3" required="required" placeholder="Alasan"></textarea>
                        </div>
                    </div>
                    <div class="form-group hidden">
                        <label for="approval_by" class="col-md-3 control-label"> By <span class="text-red">*</span></label>
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
                    <label class="col-md-2" for="">Permasalahan</label>
                    <div class="col-md-10">
                        <textarea name="problems" placeholder="Permasalahan" rows="5" id="problems" class="form-control"></textarea>
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

    $(document).on('change', '#start_time,#end_time,#date', function() {
        count_times();
    })

    function count_times() {
        let sTime = $('#start_time').val();
        let eTime = $('#end_time').val();
        let date = $('#date').val();
        sTime = new Date(date + " " + sTime).getHours();
        eTime = new Date(date + " " + eTime).getHours();

        console.log(date + ", " + sTime + ", " + eTime);
        let res = Math.abs(eTime - sTime);
        if (!date) {
            swal({
                title: 'Perhatian!',
                type: 'warning',
                text: 'Tanggal tidak valid. Mohon Isi tanggal terlebih dahulu.',
                timer: 3000
            })
            return false;
        } else if (sTime > eTime) {
            swal({
                title: 'Perhatian!',
                type: 'warning',
                text: 'Jam tidak valid. Jam selesai tidak boleh lebih kecil dari Jam mulai.',
                timer: 3000
            })
            $('#end_date').val('');
            return false;
        } else if (!sTime && !eTime) {
            $('#total_time').val('');
        } else {
            $('#total_time').val(res);
        }
    }

    $(document).on('click', '#save', function() {

        let reason = $('#reason').val();
        let start_time = $('#start_time').val();
        let end_time = $('#end_time').val();
        let total_times = $('#total_time').val() || 0;
        let approval = $('#approval_by').val();
        let no_so = $('#no_so').val();

        // return false
        if (start_time == '') {
            swal({
                title: 'Peringatan!',
                type: 'warning',
                text: 'Jam Mulai lembur belum di isi.'
            })
            return false;
        } else if (end_time == '') {
            swal({
                title: 'Peringatan!',
                type: 'warning',
                text: 'Jam selesai lembur belum di isi.'
            })
            return false;
        } else if (no_so == '') {
            swal({
                title: 'Peringatan!',
                type: 'warning',
                text: 'Nomor SO/SPK lembur belum di isi.'
            })
            return false;
        } else if (total_times == '' || total_times == '0') {
            swal({
                title: 'Peringatan!',
                type: 'warning',
                text: 'Jumlah Jam masih kosong.'
            })
            return false;
        } else if (reason == '') {
            swal({
                title: 'Peringatan!',
                type: 'warning',
                text: 'Alasan pengajuan cuti belum di isi.'
            })
            return false;

        } else if (approval == '') {
            swal({
                title: 'Peringatan!',
                type: 'warning',
                text: 'Data persetujuan atasan belum diatur. Mohon mengubungi HRD terlebih dahulu.'
            })
            return false;
        } else if ($('#table_planning tbody tr').length == 0) {
            swal({
                title: 'Peringatan!',
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
            url: base_url + active_controller + '/save',
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
                    }, function() {
                        window.open(base_url + 'lembur', '_self');

                    })
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