<?= $this->extend('template/admin') ?>
<?= $this->section('content') ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Tryout</h1>
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
                        <th>Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Tryout UTBK V3</td>
                        <td>18 Februari 2021</td>
                        <td>00.00</td>
                        <td>20 Februari 2021</td>
                        <td>23.59</td>
                        <td>SAINTEK</td>
                        <td>
                            <li>Tryout UTBK</li>
                            <li>Tryout Lama</li>
                        </td>
                        <td>Berbayar</td>
                        <td>29.000</td>
                        <td>
                            <a href="event-detail-tryout.html" class="badge badge-primary">Detail</a>
                            <a href="event-edit-tryout.html" class="badge badge-warning">Edit</a>
                            <a href="" class="badge badge-danger">Hapus</a>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Tryout UTBK V3</td>
                        <td>18 Februari 2021</td>
                        <td>00.00</td>
                        <td>20 Februari 2021</td>
                        <td>23.59</td>
                        <td>SOSHUM</td>
                        <td>
                            <li>Tryout UTBK</li>
                            <li>Tryout Lama</li>
                        </td>
                        <td>Bebas</td>
                        <td>1.000</td>
                        <td>
                            <a href="event-detail-tryout.html" class="badge badge-primary">Detail</a>
                            <a href="event-edit-tryout.html" class="badge badge-warning">Edit</a>
                            <a href="" class="badge badge-danger">Hapus</a>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Tryout UTBK V3</td>
                        <td>18 Februari 2021</td>
                        <td>00.00</td>
                        <td>20 Februari 2021</td>
                        <td>23.59</td>
                        <td>SAINTEK</td>
                        <td>
                            <li>Tryout Lama</li>
                        </td>
                        <td>Gratis</td>
                        <td>
                            <li>Follow IG camakara</li>
                            <li>Share foto di media sosial</li>
                        </td>
                        <td>
                            <a href="event-detail-tryout.html" class="badge badge-primary">Detail</a>
                            <a href="event-edit-tryout.html" class="badge badge-warning">Edit</a>
                            <a href="" class="badge badge-danger">Hapus</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endsection() ?>