<?php
$this->load->view('include/side_menu');
//echo"<pre>";print_r($data_menu);
?>
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title"><?= $title; ?></h3>
    </div>

    <div class="box-body">

        <table class="table table-condensed table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Hari kerja</th>
                    <th>Cuti</th>
                    <th>Sakit</th>
                    <th>Alpha</th>
                    <th>Cuti Tdk. Dibayar</th>
                    <th>%</th>
                </tr>
            </thead>
            <tbody>
                <?php $n = 0;

                foreach ($row as $data) : $n++ ?>
                    <tr>
                        <td><?= $n; ?></td>
                        <td><?= $data->name; ?></td>
                        <td class="text-center"></td>
                        <td class="text-center">
                            <span class="badge bg-aqua"><?= $data->year_leave; ?></span>
                        </td>
                        <td class="text-center"><?= $data->sick_leave; ?></td>
                        <td class="text-center"><?= $data->alpha; ?></td>
                        <td class="text-center"><?= $data->notpay_leave; ?></td>
                        <td class="text-center"></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
    <div class='box-footer'>

    </div>

</div>


<?php $this->load->view('include/footer'); ?>