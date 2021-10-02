<?= $this->extend('template/admin') ?>
<?= $this->section('content') ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Pengumpulan Tryout</h1>
    <a type="button" class="btn btn-primary" href="<?= base_url("admincamakara/tryout") ?>">Kembali</a>
</div>
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="tableex1" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Tryout</th>
                        <th>Nama User</th>
                        <th>Status</th>
                        <th>Biaya</th>
                        <?php if ($data[0]['type_tryout'] == 3) : ?>
                            <th>Skor TPS</th>
                            <th>Skor TKA</th>
                            <th>Total Skor</th>
                        <?php else : ?>
                            <th>Skor</th>
                        <?php endif; ?>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama Tryout</th>
                        <th>Nama User</th>
                        <th>Status</th>
                        <th>Biaya</th>
                        <?php if ($data[0]['type_tryout'] == 3) : ?>
                            <th>Skor TPS</th>
                            <th>Skor TKA</th>
                            <th>Total Skor</th>
                        <?php else : ?>
                            <th>Skor</th>
                        <?php endif; ?>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    foreach ($data as $key => $item) : ?>
                        <?php $dataProdi1 = ($item['prodi1'] ? $tryoutModel->getScore($item, $prodiModel->find($item['prodi1'])['kelompok_ujian'], 'true') : 0);
                        $dataProdi2 = ($item['prodi2'] ? $tryoutModel->getScore($item, $prodiModel->find($item['prodi2'])['kelompok_ujian'], 'true') : 0)  ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><?= $item['name'] ?></td>
                            <td><?= ($item['firstname'] . ' ' . $item['lastname']) > 3 ? ($item['firstname'] . ' ' . $item['lastname']) : $item['fullname'] ?></td>
                            <td><?= $item['finish'] ? '<span class="badge badge-success">Sudah Mengerjakan</span>' : '<span class="badge badge-danger">Belum Mengerjakan</span>' ?></td>
                            <td><?= $item['price'] ? $item['price'] : '0' ?></td>
                            <?php if ($data[0]['type_tryout'] == 3) : ?>
                                <?php
                                $skor1 = $tryoutModel->getScore($item, 1, 'true');
                                $skor2 = $tryoutModel->getScore($item, 2, 'true') ?>
                                <td><?= $skor1  ?></td>
                                <td><?= $skor2 ?></td>
                                <td><?= $skor1 + $skor2 ?></td>
                            <?php else : ?>
                                <td><?= $item['prodi1'] ? $tryoutModel->getScore($item, $prodiModel->find($item['prodi1'])['kelompok_ujian'], 'true') : 0 ?></td>
                            <?php endif; ?>
                            <td>
                                <?php if ($item['finish']) : ?>
                                    <a href="<?= base_url('admincamakara/tryout/submitted/' . $item['id_mytryout'] . '/reset') ?>">
                                        <span class="badge badge-primary">Reset</span>
                                    </a>
                                <?php else : ?>
                                    <span class="badge badge-info">Belum Finish</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endsection() ?>
<?= $this->section('script') ?>
<script>
    $(document).ready(function() {

        var dataTable = $('#tableex1').DataTable({
            responsive: true,
            "oLanguage": {
                "sLengthMenu": "Tampilkan _MENU_ data per halaman",
                "sSearch": "Pencarian: ",
                "sZeroRecords": "Maaf, tidak ada data yang ditemukan",
                "sInfo": "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
                "sInfoEmpty": "Menampilkan 0 s/d 0 dari 0 data",
                "sInfoFiltered": "(di filter dari _MAX_ total data)",
                "oPaginate": {
                    "sFirst": "<<",
                    "sLast": ">>",
                    "sPrevious": "<",
                    "sNext": ">"
                }
            },
            columnDefs: [{
                targets: [0],
                orderable: false
            }],
            "ordering": true,
            "info": true,
        });
    });
</script>
<?= $this->endsection() ?>