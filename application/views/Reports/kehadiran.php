<?php
$this->load->view('include/side_menu');
//echo"<pre>";print_r($data_menu);
?>
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title"><?= $title; ?></h3>
    </div>
    <div class="box-body">
        <div style="margin-bottom: 10px;" class="box-title">Periode : <?= date('d F Y', strtotime($start_date)) . ' s/d ' . date('d F Y', strtotime($end_date)); ?></div>
        <table id="example1" class="table table-condensed table-bordered">
            <thead>
                <tr>
                    <th width="20px">No.</th>
                    <th width="">Nama</th>
                    <th width="7%" class=" text-center">Hari kerja</th>
                    <th width="7%" class="text-center">Cuti</th>
                    <th width="7%" class="text-center">Sakit</th>
                    <th width="7%" class="text-center">Cuti Tdk. Dibayar</th>
                    <th width="7%" class="text-center">Cuti Pengganti</th>
                    <th width="7%" class="text-center">Alpha</th>
                    <th width="7%" class="text-center">Efektif Kerja</th>
                    <th width="7%" class="text-center">%</th>
                </tr>
            </thead>
            <tbody>
                <?php $n = 0;
                foreach ($row as $data) : $n++;
                    $efektif    = ($hari_kerja - $data->leave - $data->sick_leave - $data->alpha - $data->notpay_leave) + $data->substitute_leave;
                    $pres       = ($efektif / $hari_kerja) * 100;
                ?>
                    <tr>
                        <td><?= $n; ?></td>
                        <td><?= $data->name; ?></td>
                        <td class="text-center"><?= $hari_kerja; ?> hari</td>
                        <td class="text-center">
                            <span class="badge bg-aqua"><?= ($data->leave >= 0) ? $data->leave : '-'; ?></span>
                        </td>
                        <td class="text-center"><span class="badge bg-red"><?= ($data->sick_leave >= 0) ? $data->sick_leave : '-'; ?></span></td>
                        <td class="text-center"><span class="badge bg-purple"><?= ($data->notpay_leave >= 0) ? $data->notpay_leave : '-'; ?></span></td>
                        <td class="text-center"><span class="badge bg-blue"><?= ($data->substitute_leave >= 0) ? $data->substitute_leave : '-'; ?></span></td>
                        <td class="text-center"><span class="badge bg-default"><?= ($data->alpha >= 0) ? $data->alpha : '-'; ?></span></td>
                        <td class="text-center"><?= $efektif ?> hari</td>
                        <td class="text-center"><?= round($pres); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
    <div class='box-footer'>

    </div>

</div>
<?php $this->load->view('include/footer'); ?>