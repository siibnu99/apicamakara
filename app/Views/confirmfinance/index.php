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
                    <tr>
                        <td>1</td>
                        <td><img src="img/undraw_profile.svg" alt=""></td>
                        <td>Yopiangga</td>
                        <td>OVO</td>
                        <td>25.000</td>
                        <td>18-Februari-2021</td>
                        <td>
                            <a class="btn btn-danger">Tidak Diterima</a>
                            <a class="btn btn-success">Diterima</a>
                        </td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td><img src="img/undraw_profile.svg" alt=""></td>
                        <td>Yopiangga</td>
                        <td>OVO</td>
                        <td>25.000</td>
                        <td>18-Februari-2021</td>
                        <td>
                            <a class="btn btn-danger">Tidak Diterima</a>
                            <a class="btn btn-success">Diterima</a>
                        </td>
                    </tr>

                    <tr>
                        <td>3</td>
                        <td><img src="img/undraw_profile.svg" alt=""></td>
                        <td>Yopiangga</td>
                        <td>OVO</td>
                        <td>25.000</td>
                        <td>18-Februari-2021</td>
                        <td>
                            <a class="btn btn-danger">Tidak Diterima</a>
                            <a class="btn btn-success">Diterima</a>
                        </td>
                    </tr>

                    <tr>
                        <td>4</td>
                        <td><img src="img/undraw_profile.svg" alt=""></td>
                        <td>Yopiangga</td>
                        <td>OVO</td>
                        <td>25.000</td>
                        <td>18-Februari-2021</td>
                        <td>
                            <a class="btn btn-danger">Tidak Diterima</a>
                            <a class="btn btn-success">Diterima</a>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endsection() ?>