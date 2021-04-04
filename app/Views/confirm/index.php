<?= $this->extend('template/admin') ?>
<?= $this->section('content') ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tabel Konfirmasi Tryout</h1>
</div>

<div class="card shadow mb-4">
    <!-- <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Tabel Konfirmasi User</h6>
                        </div> -->
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Tryout</th>
                        <th>Nama Akun</th>
                        <th>Bukti Berkas</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama Tryout</th>
                        <th>Nama Akun</th>
                        <th>Bukti Berkas</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php $no = 1;
                    foreach ($reports as $item) : ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td><?= $item['name'] ?></td>
                            <td><?= $item['fullname'] ?></td>
                            <td>
                                <?php
                                $images =  explode(',', $item['imageto']);
                                foreach ($images as $image) :
                                    if ($image) :
                                ?>
                                        <a href="<?= base_url() . "/assets/image/ruleto/" . $image ?>" target="_blank" class="badge badge-primary">Lihat Detail</a>
                                        <br>
                                <?php
                                    endif;
                                endforeach
                                ?>
                            </td>
                            <td><?= $item['created_at'] ?></td>
                            <td>
                                <a class="btn btn-danger" href="<?= base_url('confirm/notconfirm') . '/' . $item['id_mytryout'] ?>">Tidak Diterima</a>
                                <a class="btn btn-success" href="<?= base_url('confirm/confirm') . '/'  . $item['id_mytryout'] ?>">Diterima</a>
                            </td>
                        </tr>
                    <?php endforeach;
                    $no++ ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endsection() ?>