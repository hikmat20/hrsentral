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
        foreach ($data as $row) : $n++; ?>
            <tr>
                <td><?= $n; ?></td>
                <td><?= $row->year; ?></td>
                <td><?= $month; ?></td>
                <td><?= $start_date; ?></td>
                <td><?= $end_date; ?></td>
                <td><?= $row->name; ?></td>
                <td><?= $row->absen; ?></td>
                <td><?= $row->onsite; ?></td>
                <td><?= $row->lembur; ?></td>
                <td><?= $row->wfh; ?></td>
                <td><?= ($row->absen + $row->onsite) - ($row->wfh); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="text-center">
    <button class="btn btn-primary btn-md" type="button" id="proses"><i class="fa fa-refresh"></i> Proses</button>
</div>