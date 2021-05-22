<?= $this->extend('template/admin') ?>
<?= $this->section('content') ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Quiz</h1>
    <a type="button" class="btn btn-primary" href="<?= base_url("quiz") ?>">Kembali</a>
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
                    <tr>
                        <td>1</td>
                        <td><?= allMapel($quiz['mapel'])  ?></td>
                        <td><?= $quiz['q_mapel'] . ' Soal' ?></td>
                        <td><?= $quiz['t_mapel'] . ' menit' ?></td>
                        <td>
                            <a href="<?= base_url('quiz') . "/editsoal/" . $quiz['id_quiz'] . '/' . '1' ?>" class="badge badge-primary">Edit Soal</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endsection() ?>
<?= $this->section('script') ?>
<?= $this->endsection() ?>