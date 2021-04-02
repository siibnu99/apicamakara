<?= $this->extend('template/admin') ?>
<?= $this->section('content') ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tabel Konfirmasi Keuangan</h1>
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
                        <th>Bukti Pembayaran</th>
                        <th>Nama Akun</th>
                        <th>Jenis Pembayaran</th>
                        <th>Total Uang</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Bukti Pembayaran</th>
                        <th>Nama Akun</th>
                        <th>Jenis Pembayaran</th>
                        <th>Total Uang</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($topup as $item) : ?>

                        <tr>
                            <td><?= $no ?></td>
                            <td><img width="50px" height="50px" src="<?= base_url('assets/image/topup/') . '/' . $item['imageTop'] ?>" alt=""></td>
                            <td><?= $item['fullname'] ?></td>
                            <td><?= AllPayment($item['bank_id']) ?></td>
                            <td><?= $item['nominal'] ?></td>
                            <td><?= $item['createdTop'] ?></td>
                            <td>
                                <a class="btn btn-danger" href="<?= base_url('confirmfinance/notconfirm') . '/' . $item['id_topup'] ?>">Tidak Diterima</a>
                                <a class="btn btn-success" href="<?= base_url('confirmfinance/confirm') . '/'  . $item['id_topup'] ?>">Diterima</a>
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