<?php
$this->load->view('include/side_menu');
$ses_userId = $this->session->User['employee_id'];
?>
<div class="box box-primary">
    <div class="box-header">
        <h2 class="box-title text-bold"><?= $title; ?></h2>
    </div>
    <div class="box-body">
        <div class="text-lg-right" style="margin-bottom: 10px; display:block">
            <?php if ($access['create'] == '1') : ?>
                <a href="<?= base_url(); ?>lembur/add" class=' btn btn-md btn-primary' title='Create Application' data-role='qtip'><i class='fa fa-plus'></i> New Applications</a>
            <?php endif; ?>
        </div>

        <div class="table-responsive">
            <table id="wfh-table" class="table table-bordered table-striped">
                <thead>
                    <tr class='bg-blue'>
                        <th class="text-center">No.</th>
                        <th class="text-center">Name Employees</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Jam Mulai</th>
                        <th class="text-center">Jam Selesai</th>
                        <th class="text-center">Jumlah Jam</th>
                        <th class="text-center">Alasan</th>
                        <th class="text-center">Apv. by D.Head</th>
                        <th class="text-center">Apv. by HR</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($row) : $n  = 0;
                        foreach ($row as $data) : $n++; ?>
                            <tr>
                                <td><?= $n; ?></td>
                                <td><?= $data->name; ?></td>
                                <td><?= $data->date; ?></td>
                                <td><?= $data->start_time; ?></td>
                                <td><?= $data->end_time; ?></td>
                                <td><?= $data->total_time; ?></td>
                                <td><?= $data->reason; ?></td>
                                <td><?= $status[$data->status]; ?></td>
                                <td><?= $status[$data->approved_hr]; ?></td>
                                <td>
                                    <?php if ($access['read'] == '1') : ?>
                                        <a href="<?= base_url(); ?>lembur/view/<?= $data->id; ?>" class=' btn btn-sm btn-primary' title='View Application' data-role='qtip'><i class='fa fa-eye'></i></a>
                                    <?php endif ?>
                                    <?php if ($ses_userId == $data->approval_employee_id) : ?>
                                        <?php if ($access['approve'] == '1') : ?>
                                            <a href="<?= base_url('lembur/approval/' . $data->id); ?>" data-id="<?= $data->id; ?>" id="approve" data-action="approve" class='btn btn-sm btn-success' title='Approve Application' data-role='qtip'><i class='fa fa-check'></i></a>
                                        <?php endif ?>
                                    <?php else : ?>
                                        <?php if ($data->status == 'OPN') : ?>
                                            <?php if ($access['update'] == '1') : ?>
                                                <a href="<?= base_url(); ?>lembur/edit/<?= $data->id; ?>" class=' btn btn-sm btn-warning' title='Edit Application' data-role='qtip'><i class='fa fa-pencil'></i></a>
                                            <?php endif ?>
                                            <?php if ($access['delete'] == '1') : ?>
                                                <a href="javascript:void(0)" class=' btn btn-sm btn-danger' id="cancel" data-id="<?= $data->id; ?>" title='Cancel Application' data-role='qtip'><i class='fa fa-stop'></i></a>
                                            <?php endif ?>
                                            <?php if ($access['create'] == '1') :
                                                $text = "Dengan Hormat,%0aSaya yang bertanda tangan dibawah ini :%0a%0aNama : " . $data->name . "%0aDivisi : " . $data->divisions_name . "%0a%0aBermaksud untuk mengajukan Lembur pada tanggal " . $data->date . ", Jam Mulai " . $data->start_time . " s/d " . $data->end_time . " selama " . $data->total_time . " jam.%0a%0aUntuk lebih detailnya bisa klik link dibawah ini:%0a" . base_url('lembur/view/' . $data->id) . "%0a%0aDemikian surat izin lembur ini saya sampaikan. Atas perhatiannya saya ucapkan terima kasih.%0a%0aHormat Saya,%0a" . $data->name;
                                            ?>
                                                <a href="https://api.whatsapp.com/send/?phone=<?= $phone[$data->approval_employee_id]; ?>&text=<?= $text; ?>" class='btn btn-success btn-sm' id="wa" data-id="" target="_blank" title='Send Whatsapp' data-role='qtip'><i class='fa fa-whatsapp' style="font-size: 1.4em;"></i></a>
                                                <!-- <a href="javascript:void(0)" class=' btn btn-sm btn-info' id="sendEmail" data-id="<?= $data->id; ?>" title='Send Email' data-role='qtip'><i class='fa fa-send'></i></a> -->
                                            <?php endif ?>
                                        <?php elseif ($data->status == 'REV') : ?>
                                            <?php if ($access['update'] == '1') : ?>
                                                <a href="<?= base_url(); ?>lembur/update_revision/<?= $data->id; ?>" class=' btn btn-sm btn-warning' title='Update Application' data-role='qtip'><i class='fa fa-pencil'></i></a>
                                            <?php endif ?>
                                        <?php else : ?>
                                            <?php if (($data->status == 'APV') && ($data->approved_hr == 'N') && ($ses_userId == $data->employee_id)) : ?>
                                                <a href="<?= base_url('lembur/update/') . $data->id; ?>" class="btn btn-warning btn-sm edit" title="Update Rencana Kerja" tooltip="qtip"><i class="fa fa-pencil"></i></a>
                                            <?php endif; ?>
                                            <?php if ($access['delete'] == '1' && $data->approved_hr == 'N') : ?>
                                                <a href="javascript:void(0)" class=' btn btn-sm btn-danger' id="cancel" data-id="<?= $data->id; ?>" title='Cancel Application' data-role='qtip'><i class='fa fa-stop'></i></a>
                                            <?php endif ?>
                                            <?php if ($this->session->userdata('Group')['id'] == 40) : ?>
                                                <a href="<?= base_url(); ?>lembur/approval/<?= $data->id; ?>" data-action="view" class=' btn btn-sm btn-success' title='Approval Application' data-role='qtip'><i class='fa fa-check'></i></a>
                                            <?php endif; ?>
                                        <?php endif ?>

                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
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

        $('#wfh-table').DataTable();

        $(document).on('click', '#cancel', function() {
            let id = $(this).data('id');

            swal({
                    title: "Are you sure?",
                    text: "You will not be able to process again this data!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, Process it!",
                    cancelButtonText: "No, cancel process!",
                    closeOnConfirm: true,
                    // closeOnCancel: true
                },
                function(isConfirm) {
                    if (isConfirm) {
                        // loading_spinner();
                        var baseurl = base_url + active_controller + '/cancel';
                        $.ajax({
                            url: baseurl,
                            type: "POST",
                            data: {
                                id
                            },
                            dataType: 'json',
                            success: function(result) {
                                if (result.status == 1) {
                                    swal({
                                        title: "Cancel Success!",
                                        text: result.msg,
                                        type: "success",
                                        timer: 1500,
                                        showCancelButton: false,
                                        showConfirmButton: false,
                                        allowOutsideClick: false
                                    });
                                    setTimeout(function() {
                                        location.reload();
                                    }, 1500);
                                } else {
                                    swal({
                                        title: "Error Message !",
                                        text: 'An Error Occured During Process. Please try again..',
                                        type: "danger",
                                        timer: 7000,
                                        showCancelButton: false,
                                        showConfirmButton: false,
                                        allowOutsideClick: false
                                    });
                                }
                            },
                            error: function() {
                                swal({
                                    title: "Error Message !",
                                    text: 'An Error Occured During Process. Please try again..',
                                    type: "warning",
                                    timer: 7000,
                                    showCancelButton: false,
                                    showConfirmButton: false,
                                    allowOutsideClick: false
                                });
                            }
                        });
                    }
                });
        })

        $(document).on('click', '#sendEmail', function() {
            let id = $(this).data('id');

            swal({
                    title: "Kirim ke Email?",
                    text: "Pastikan data pengajuan cuti sudah benar. Periksa kembali sebelum form ini dikirim ke email tujuan.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Ya, Kirim!",
                    cancelButtonText: "Batal!",
                    closeOnConfirm: false,
                    // closeOnCancel: true
                },
                function(isConfirm) {
                    if (isConfirm) {
                        loading_spinner();
                        var baseurl = '<?= base_url(); ?>' + 'lembur/sendEmail';
                        $.ajax({
                            url: baseurl,
                            type: "POST",
                            data: {
                                id
                            },
                            dataType: 'json',
                            success: function(result) {
                                if (result.status == 1) {
                                    (result.error) ? console.log(result.error): '';
                                    swal({
                                        title: "Email Terkirim!",
                                        text: result.msg,
                                        type: "success",
                                        showCancelButton: false,
                                        showConfirmButton: true,
                                        allowOutsideClick: false
                                    }, function(isConfirm) {
                                        location.reload();
                                    });
                                } else {
                                    (result.error) ? console.log(result.error): '';
                                    swal({
                                        title: "Gagal Terkirim",
                                        text: 'Terkendala jaringan atau data tidak valid',
                                        type: "error",
                                        showCancelButton: false,
                                        showConfirmButton: true,
                                        allowOutsideClick: false
                                    });
                                }
                            },
                            error: function() {
                                swal({
                                    title: "Email Tidak terkirim",
                                    text: 'Mohon periksa jaringan Anda atau data yang Anda masukan tidak valid',
                                    type: "warning",
                                    showCancelButton: false,
                                    showConfirmButton: false,
                                    allowOutsideClick: false
                                });
                            }
                        });
                    }
                });
        })



    });
</script>