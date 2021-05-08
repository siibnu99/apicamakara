<?= $this->extend('template/admin') ?>
<?= $this->section('content') ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Tryout</h1>
</div>
<?php if (session()->getFlashdata('message')) : ?>
    <div class="alert alert-success" role="alert">
        <strong> <?= session()->getFlashdata('message') ?> </strong>
    </div>
<?php endif ?>
<div class="alert alert-success messageSuccess d-none" role="alert">
</div>
<a href="<?= base_url('tryout/create') ?>" class="btn btn-primary mb-4">Buat Tryout</a>

<div class="card shadow mb-4">

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Tryout</th>
                        <th>Tanggal Mulai</th>
                        <th>Waktu Mulai</th>
                        <th>Tanggal Akhir</th>
                        <th>Waktu Akhir</th>
                        <th>Jenis Tryout</th>
                        <th>Kategori</th>
                        <th>Metode Pembayaran</th>
                        <th>Harga</th>
                        <th>Active</th>
                        <th>Dibuat oleh</th>
                        <th>Diedit oleh</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama Tryout</th>
                        <th>Tanggal Mulai</th>
                        <th>Waktu Mulai</th>
                        <th>Tanggal Akhir</th>
                        <th>Waktu Akhir</th>
                        <th>Jenis Tryout</th>
                        <th>Kategori</th>
                        <th>Metode Pembayaran</th>
                        <th>Harga</th>
                        <th>Active</th>
                        <th>Dibuat oleh</th>
                        <th>Diedit oleh</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($Tryout as $item) : ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td><?= $item['name'] ?></td>
                            <td><?= $item['date_start'] ?></td>
                            <td><?= $item['time_start'] ?></td>
                            <td><?= $item['date_end'] ?></td>
                            <td><?= $item['time_end'] ?></td>
                            <td><?= jenisTryout($item['type_tryout']) ?></td>
                            <td>
                                <?php
                                $arr1 = str_split($item['cat_tryout']);
                                foreach ($arr1 as $item1) : ?>
                                    <li><?= catTryout($item1) ?></li>
                                <?php endforeach
                                ?>
                            </td>
                            <td><?= paymentMethod($item['payment_method']) ?></td>
                            <?php if ($item['payment_method'] == 1) : ?>
                                <td>
                                    <?php if ($item['rule1']) : ?> <li><?= $item['rule1'] ?></li> <?php endif ?>
                                    <?php if ($item['rule2']) : ?> <li><?= $item['rule2'] ?></li> <?php endif ?>
                                    <?php if ($item['rule3']) : ?> <li><?= $item['rule3'] ?></li> <?php endif ?>
                                    <?php if ($item['rule4']) : ?> <li><?= $item['rule4'] ?></li> <?php endif ?>
                                    <?php if ($item['rule5']) : ?> <li><?= $item['rule5'] ?></li> <?php endif ?>
                                </td>
                            <?php else : ?>
                                <td><?= $item['price'] ?></td>
                            <?php endif ?>

                            <td>
                                <label class="switch ">
                                    <input type="checkbox" class="primary" <?= $item['active'] ? 'checked' : '' ?> onclick="toogleActive('<?= $item['id_tryout'] ?>','<?= $item['name'] ?>',<?= $item['active'] ?>)">
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td><?= $usermodel->find($item['created_by'])->email ?></td>
                            <td><?= $usermodel->find($item['updated_by'])->email ?></td>
                            <td>
                                <a href="<?= base_url('tryout/detail/' . $item['id_tryout']) ?>" class="badge badge-primary">Detail</a>
                                <a href="<?= base_url('tryout/edit/' . $item['id_tryout']) ?>" class="badge badge-warning">Edit</a>
                                <a href="<?= base_url('tryout/delete/' . $item['id_tryout']) ?>" class="badge badge-danger">Hapus</a>
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
<?= $this->section('script') ?>
<script>
    function toogleActive(id, nama, checked) {
        $.post("<?= base_url('tryout/toogleactive') ?>" + "/" + id).done(function(data) {
            $('.messageSuccess').removeClass('d-none');
            $('.messageSuccess').html("<strong>" + data + "</strong>");
        });
    }
</script>
<?= $this->endsection() ?>