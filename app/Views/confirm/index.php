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
                    <tr>
                        <td>1</td>
                        <td>Tryout UTBK V3</td>
                        <td>Yopiangga</td>
                        <td>
                            <a href="event-detail-berkas.html" class="badge badge-primary">Lihat Detail</a>
                        </td>
                        <td>18-Februari-2021</td>
                        <td>
                            <button class="btn btn-success">Terima</button>
                            <button class="btn btn-danger">Tolak</button>
                        </td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Tryout UTBK V3</td>
                        <td>Yopiangga</td>
                        <td>
                            <a href="event-detail-berkas.html" class="badge badge-primary">Lihat Detail</a>
                        </td>
                        <td>18-Februari-2021</td>
                        <td>
                            <button class="btn btn-success">Terima</button>
                            <button class="btn btn-danger">Tolak</button>
                        </td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Tryout UTBK V3</td>
                        <td>Yopiangga</td>
                        <td>
                            <a href="event-detail-berkas.html" class="badge badge-primary">Lihat Detail</a>
                        </td>
                        <td>18-Februari-2021</td>
                        <td>
                            <button class="btn btn-success">Terima</button>
                            <button class="btn btn-danger">Tolak</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endsection() ?>