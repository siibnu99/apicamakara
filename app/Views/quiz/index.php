<?= $this->extend('template/admin') ?>
<?= $this->section('content') ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Quiz</h1>
</div>

<a href="<?= base_url('quiz/create') ?>" class="btn btn-primary mb-4">Buat Quiz</a>
<?php if (session()->getFlashdata('message')) : ?>
    <div class="alert alert-success" role="alert">
        <strong> <?= session()->getFlashdata('message') ?> </strong>
    </div>
<?php endif ?>
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Quiz</th>
                        <th>Tanggal Mulai</th>
                        <th>Waktu Mulai</th>
                        <th>Tanggal Akhir</th>
                        <th>Waktu Akhir</th>
                        <th>Kelas Quiz</th>
                        <th>Mata Pelajaran</th>
                        <th>Waktu Pengerjaan (Menit)</th>
                        <th>Kuota (Siswa)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama Quiz</th>
                        <th>Tanggal Mulai</th>
                        <th>Waktu Mulai</th>
                        <th>Tanggal Akhir</th>
                        <th>Waktu Akhir</th>
                        <th>Kelas Quiz</th>
                        <th>Mata Pelajaran</th>
                        <th>Waktu Pengerjaan (Menit)</th>
                        <th>Kuota (Siswa)</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($Quiz as $item) : ?>

                        <tr>
                            <td><?= $no ?></td>
                            <td><?= $item['name'] ?></td>
                            <td><?= $item['date_start'] ?></td>
                            <td><?= $item['time_start'] ?></td>
                            <td><?= $item['date_end'] ?></td>
                            <td><?= $item['time_end'] ?></td>
                            <td><?= classQuiz($item['class']) ?></td>
                            <td><?= allMapel($item['mapel']) ?></td>
                            <td><?= $item['t_mapel'] ?></td>
                            <td><?= $item['kuota'] ?></td>
                            <td>
                                <a href="<?= base_url('quiz/detail') . '/' . $item['id_quiz'] ?>" class="badge badge-primary">Detail</a>
                                <a href="<?= base_url('quiz/edit') . '/' . $item['id_quiz'] ?>" class="badge badge-warning">Edit</a>
                                <a href="<?= base_url('quiz/delete') . '/' . $item['id_quiz'] ?>" class="badge badge-danger">Hapus</a>
                            </td>
                        </tr>
                    <?php $no++;
                    endforeach
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endsection() ?>