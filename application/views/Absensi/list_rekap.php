<?php
$this->load->view('include/side_menu');
//echo"<pre>";print_r($data_menu);
?>
<div class="box box-solid box-shadow rounded" style="border-radius: 1em;">
    <div class="box-header">
        <h3 class="box-title"><?= $title; ?></h3>
        <div class="box-tools"><a href="<?= base_url('rekapabsen/proses_rekap'); ?>" class="btn btn-primary btn-hover"><i class="fa fa-refresh"></i> Proses Rekap Absensi</a></div>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table id="example1" class="table table-bordered table-condensed table-hover">
                <thead class="bg-primary">
                    <tr>
                        <th>No</th>
                        <th>Tahun</th>
                        <th>Bulan</th>
                        <th>Periode Tgl. Awal</th>
                        <th>Periode Tgl. Akhir</th>
                        <th>Nama Karywan</th>
                        <th>Absen Masuk</th>
                        <th>Onsite</th>
                        <th>Lembur</th>
                        <th>WFH</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $n = 0;
                    foreach ($row as $dt) : $n++; ?>
                        <tr>
                            <td><?= $n ?></td>
                            <td><?= $dt->year; ?></td>
                            <td><?= $dt->month; ?></td>
                            <td><?= $dt->start_date; ?></td>
                            <td><?= $dt->end_date; ?></td>
                            <td><?= $dt->name; ?></td>
                            <td><?= $dt->absen; ?></td>
                            <td><?= $dt->onsite; ?></td>
                            <td><?= $dt->overtime; ?></td>
                            <td><?= $dt->wfh; ?></td>
                            <td><?= $dt->total; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
    <?php $this->load->view('include/footer'); ?>
    <script>
        $(document).on('click', '#view_data', function() {
            let sDate = $('#start_date').val();
            let eDate = $('#end_date').val();
            let detail = $('#detail').is(':checked');
            console.log(detail);
            if (!sDate) {
                swal({
                    title: 'Perhatian!',
                    text: 'Tanggal awal belum di pilih.',
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
                $.ajax({
                    url: base_url + active_controller + '/report_wfh',
                    type: 'POST',
                    data: {
                        sDate,
                        eDate,
                        detail
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
            let id = $(this).data('id');
            if (!id) {
                swal({
                    title: 'Perhatian!',
                    text: 'Data tidak valid.',
                    type: 'warning',
                    timer: 3000
                })
                return false;
            } else {
                loading_spinner();
                $.ajax({
                    url: base_url + active_controller + '/proses',
                    type: 'POST',
                    data: {
                        id
                    },
                    success: function(result) {},
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
    </script>