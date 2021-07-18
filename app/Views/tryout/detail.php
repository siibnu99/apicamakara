<?= $this->extend('template/admin') ?>
<?= $this->section('content') ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Tryout</h1>
    <a type="button" class="btn btn-primary" href="<?= base_url("admincamakara/tryout") ?>">Kembali</a>
</div>
<div class="card shadow mb-4">

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Mata Pelajaran</th>
                        <th>Jumlah Soal</th>
                        <th>Waktu Pengerjaan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Mata Pelajaran</th>
                        <th>Jumlah Soal</th>
                        <th>Waktu Pengerjaan</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    $no = 1;
                    foreach (mapel($tryout['type_tryout'], $tryout) as $item) : ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td><?= $item[0] ?></td>
                            <td><?= $item[1] . ' Soal' ?></td>
                            <td><?= $item[2] . ' menit' ?></td>
                            <td>
                                <a href="<?= base_url('admincamakara/tryout') . "/editsoal/" . $tryout['id_tryout'] . '/' . $item[3] . '/' . '1' ?>" class="badge badge-primary">Edit Soal</a>
                                <a href="<?= base_url('admincamakara/tryout') . "/editbobot/" . $tryout['id_tryout'] . '/' . $item[3] ?>" class="badge badge-warning">Edit Bobot</a>
                            </td>
                        </tr>
                    <?php
                        $no++;
                    endforeach
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endsection() ?>
<?= $this->section('script') ?>
<?= $this->endsection() ?>