<?php
$this->load->view('include/side_menu');
//echo"<pre>";print_r($data_menu);
?>
<div class="box box-solid box-shadow rounded" style="border-radius: 1em;">
    <div class="box-header">
        <h3 class="box-title"><?= $title; ?></h3>
    </div>
    <div class="box-body">
        <form class="form-horizontal" role="form">
            <div class="form-group">
                <label for="" class="col-md-2">Periode Bulan : </label>
                <div class="col-md-4">

                    <select name="month" id="month" class="form-control" required="required">
                        <option value=""></option>
                        <?php foreach ($month as $key => $mon) : ?>
                            <option value="<?= $key; ?>"><?= $mon; ?></option>
                        <?php endforeach; ?>
                    </select>

                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-md-2">Start Date : </label>
                <div class="col-md-4">
                    <input type="date" class="form-control" id="start_date" value="<?= date('Y-m-d'); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-md-2">End Date : </label>
                <div class="col-md-4">
                    <input type="date" class="form-control" id="end_date" value="<?= date('Y-m-d'); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="" class="col-md-2"></label>
                <div class="col-md-4">
                    <button type="button" id="view_data" class="btn btn-primary"><i class="fa fa-search"></i> Lihat</button>
                </div>
            </div>
            <hr>
            <div class="" id="view"></div>
        </form>

    </div>
    <?php $this->load->view('include/footer'); ?>
    <script>
        $(document).on('click', '#view_data', function() {
            let sDate = $('#start_date').val();
            let eDate = $('#end_date').val();
            let month = $('#month').val();

            if (!sDate) {
                swal({
                    title: 'Perhatian!',
                    text: 'Tanggal awal belum di pilih.',
                    type: 'warning',
                    timer: 3000
                })
                return false;
            } else if (!month) {
                swal({
                    title: 'Perhatian!',
                    text: 'Periode bulan belum di pilih.',
                    type: 'warning',
                    timer: 3000
                })
                return false;
            } else if (!eDate) {
                swal({
                    title: 'Perhatian!',
                    text: 'Tanggal awal belum di pilih.',
                    type: 'warning',
                    timer: 3000
                })
                return false;
            } else if (sDate > eDate) {
                swal({
                    title: 'Perhatian!',
                    text: 'Tanggal tidak valid.',
                    type: 'warning',
                    timer: 3000
                })
                return false;
            } else {
                loading_spinner();
                $.ajax({
                    url: base_url + active_controller + '/view_rekap',
                    type: 'POST',
                    data: {
                        sDate,
                        eDate,
                        month
                    },
                    success: function(result) {
                        console.log(result);
                        if (result) {
                            $('#view').html(result);
                        } else {
                            swal({
                                title: 'Perhatian!',
                                text: 'Data tidak valid.',
                                type: 'warning',
                                timer: 3000
                            })
                            return false;
                        }
                        swal.close();
                    },
                    error: function(result) {
                        swal({
                            title: 'Error!',
                            text: 'Server timeout.',
                            type: 'error',
                            timer: 3000
                        })
                        return false;
                    }
                })
            }
        })

        $(document).on('click', '#proses', function() {
            let sDate = $('#start_date').val();
            let eDate = $('#end_date').val();
            let month = $('#month').val();
            if (!sDate) {
                swal({
                    title: 'Perhatian!',
                    text: 'Tanggal awal belum di pilih.',
                    type: 'warning',
                    timer: 3000
                })
                return false;
            } else if (!month) {
                swal({
                    title: 'Perhatian!',
                    text: 'Periode bulan belum di pilih.',
                    type: 'warning',
                    timer: 3000
                })
                return false;
            } else if (!eDate) {
                swal({
                    title: 'Perhatian!',
                    text: 'Tanggal awal belum di pilih.',
                    type: 'warning',
                    timer: 3000
                })
                return false;
            } else if (sDate > eDate) {
                swal({
                    title: 'Perhatian!',
                    text: 'Tanggal tidak valid.',
                    type: 'warning',
                    timer: 3000
                })
                return false;
            } else {
                loading_spinner();
                $.ajax({
                    url: base_url + active_controller + '/save_rekap',
                    type: 'POST',
                    data: {
                        sDate,
                        eDate,
                        month
                    },
                    success: function(result, response) {
                        if (result.status == 1) {
                            swal({
                                title: 'Succes',
                                text: result.msg,
                                type: 'success',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        } else if (result.status == 0) {
                            swal({
                                title: 'Kesalahan',
                                text: result.msg,
                                type: 'warning',
                            });
                        }
                        window.open(base_url + 'rekapabsen', '_self');
                        swal.close();
                        // console.log(result + ", " + response);
                    },
                    error: function(result) {
                        swal.close();
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