<?= $this->extend('template/admin') ?>
<?= $this->section('content') ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Quiz</h1>
</div>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tabel Data Keuangan</h1>
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
                        <th>Nama Akun</th>
                        <th>Jenis Pembayaran</th>
                        <th>Email Akun</th>
                        <th>Tanggal</th>
                        <th>Uang masuk</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama Akun</th>
                        <th>Jenis Pembayaran</th>
                        <th>Email Akun</th>
                        <th>Tanggal</th>
                        <th>Uang masuk</th>
                    </tr>
                </tfoot>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Yopiangga</td>
                        <td>OVO</td>
                        <td>yopigambyok@gmail.com</td>
                        <td>18-Februari-2021</td>
                        <td>Rp 25.000</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Yopiangga</td>
                        <td>OVO</td>
                        <td>yopigambyok@gmail.com</td>
                        <td>18-Februari-2021</td>
                        <td>Rp 25.000</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Yopiangga</td>
                        <td>OVO</td>
                        <td>yopigambyok@gmail.com</td>
                        <td>18-Februari-2021</td>
                        <td>Rp 25.000</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Yopiangga</td>
                        <td>OVO</td>
                        <td>yopigambyok@gmail.com</td>
                        <td>18-Februari-2021</td>
                        <td>Rp 25.000</td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endsection() ?>