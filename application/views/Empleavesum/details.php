<div class="">
    <h4 for=""><strong>Rekap Cuti Tahunan</strong></h4>

    <table class="table table-condensed table-bordered">
        <thead class="bg-success">
            <tr>
                <th width="50px">No.</th>
                <th>Tgl.</th>
                <th class="text-center">Jml. Cuti</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            <?php $n = 0;
            $total = 0;
            foreach ($empLeave as $row) : $n++;
                $total += $row->leave;
            ?>
                <tr>
                    <td><?= $n; ?></td>
                    <td><?= date("D, m d Y", strtotime($row->date)); ?></td>
                    <td class="text-center"><?= $row->leave; ?> Hari</td>
                    <td><?= $row->description; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2" class="text-right">Total Cuti Tahunan</th>
                <th class="text-center"><?= $total; ?> Hari</th>
            </tr>
        </tfoot>
    </table>

    <h4><strong>Rekap Pengambilan Cuti</strong></h4>

    <table class="table table-condensed table-bordered">
        <thead class="bg-success">
            <tr>
                <th rowspan="2" width="50px">No.</th>
                <th rowspan="2" width="200px">Tgl.</th>
                <th colspan="3" class="text-center">Cuti Tahunan</th>
                <th colspan="2" class="text-center">Cuti Khusus</th>
                <th colspan="2" class="text-center">Cuti Urgent</th>
                <th rowspan="2" class="text-center">Deskripsi</th>
            </tr>
            <tr>
                <th width="100px" class="text-center">Jml. Hak Cuti</th>
                <th width="100px" class="text-center">Jml. Ambil</th>
                <th width="100px" class="text-center">Sisa Cuti</th>
                <th width="100px" class="text-center">Jml. Hari</th>
                <th width="" class="text-center">Keterangan</th>
                <th width="100px" class="text-center">Jml. Hari</th>
                <th width="" class="text-center">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php $n = 0;
            foreach ($empLeaveApps as $la) : $n++; ?>
                <tr>
                    <td><?= $n; ?></td>
                    <td><?= date("D, m d Y", strtotime($la->created_at)); ?></td>
                    <td class="text-center"><?= $la->unused_leave; ?></td>
                    <td class="text-center"><?= $la->get_year_leave; ?></td>
                    <td class="text-center"><?= $la->remaining_leave; ?></td>
                    <td class="text-center"><?= $la->special_leave; ?></td>
                    <td><?= $la->category_name; ?></td>
                    <td class="text-center"><?= $la->notpay_leave; ?></td>
                    <td><?= $la->notpay_leave_desc; ?></td>
                    <td><?= $la->descriptions; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


</div>