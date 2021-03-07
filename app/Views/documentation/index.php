<?= $this->extend('template/admin') ?>
<?= $this->section('content') ?>
<!-- Collapsable Card Example -->
<div class="card shadow mb-4">
    <!-- Card Header - Accordion -->
    <a href="#collapseCardExample" class="d-block card-header py-3 bg-warning" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
        <h6 class="m-0 font-weight-bold text-white">Dokumentasi APi Camakara</h6>
    </a>
    <!-- Card Content - Collapse -->
    <div class="collapse show" id="collapseCardExample">
        <div class="card-body">
            Ini merupakan halaman untuk melihat akses api dari Camakara.
        </div>
    </div>
</div>
<!-- Collapsable Card Example -->
<div class="card shadow mb-4">
    <!-- Card Header - Accordion -->
    <a href="#userApi" class="d-block card-header py-3 bg-warning" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="userApi">
        <h6 class="m-0 font-weight-bold text-white">User APi</h6>
    </a>
    <!-- Card Content - Collapse -->
    <div class="collapse show" id="userApi">
        <div class="card-body">
            <ul class="list-unstyled">
                <li>
                    1. Api Register
                    <p class=" m-0">Untuk melakukan pendaftaran user di APi camakara ini, menggunakan link: <span class="badge badge-secondary">http://admin.petikdua.store/api/user</span> dengan method <span class="badge badge-warning">POST</span> dengan mengirimkan beberapa data dengan keterangan berikut :</p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">email &emsp; : &emsp; Wajib, Valid email </span> </p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">password &emsp; : &emsp; Wajib, lebih dari 8 karakter</span> </p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">fullname &emsp; : &emsp; Wajib, lebih dari 3 karakter</span> </p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">Telp &emsp; : &emsp; Wajib, wajib angka</span> </p>
                    <p class=" m-0">Response yang akan di dapatkan ada dua : <span class="badge badge-danger">Error</span> dan <span class="badge badge-success">Success</span> yang mana jika response error akan terlihat error terdapat di mana?</p>
                </li>
                <hr>
                <li>
                    2. Api Login
                    <p class=" m-0">Login Api dari camakara ini menggunakan service JWT yang mana nanti JWT ini digunakan untuk pengaksesan resource yang lain, seperti contoh Profile, kelas dan sebagainya, dan bisa untuk mendeteksi sudah login atau belum, menggunakan link: <span class="badge badge-secondary">http://admin.petikdua.store/api/user</span> dengan method <span class="badge badge-warning">GET</span> dengan mengirimkan beberapa data dengan keterangan berikut :</p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">email &emsp; : &emsp; Wajib, Valid email </span> </p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">password &emsp; : &emsp; Wajib</span> </p>
                    <p class=" m-0">Response yang akan di dapatkan ada dua : <span class="badge badge-danger">Error</span> dan <span class="badge badge-success">Success</span> yang mana jika response error akan terlihat error terdapat di mana?. Sedangkan response success akan mengembalikan data dari user dan juga mengembalikan token JWT</p>
                </li>
                <hr>
                <li>
                    3. Api Cek Login
                    <p class=" m-0">Cek login ini digunakan untuk mengecek apakah user sudah login atau belum dengan memanfaatkan <span class="badge badge-info">JWT Token</span> yang usdah di dapatkan pada saat login , menggunakan link: <span class="badge badge-secondary">http://admin.petikdua.store/api/user/islogin</span> dengan method <span class="badge badge-warning">GET</span> dengan mengirimkan beberapa data dengan keterangan berikut :</p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">Bearer Token &emsp; : &emsp; Wajib </span> </p>
                    <p class=" m-0">Response yang akan di dapatkan ada dua : <span class="badge badge-danger">Error</span> dan <span class="badge badge-success">Success</span> yang mana jika response error artinya token tidak valid dengan kesimpulan belom login. Sedangkan response success artinya token valid dan user sudah login</p>
                </li>
                <hr>
                <li>
                    4. Api Get Profile
                    <p class=" m-0">Untuk mendapatkan data profile dari user, membutuhkan beberapa syarat, pertama : <span class="badge badge-info">JWT Token</span> dan yang kedua: <span class="badge badge-info">ID User</span> , menggunakan link: <span class="badge badge-secondary">http://admin.petikdua.store/api/user/{id}</span> dengan method <span class="badge badge-warning">GET</span></p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">Bearer Token &emsp; : &emsp; Wajib </span> </p>
                    <p class=" m-0">Response yang akan di dapatkan ada dua : <span class="badge badge-danger">Error</span> dan <span class="badge badge-success">Success</span> yang mana jika response error artinya token tidak valid dengan kesimpulan belom login. Sedangkan response success artinya token valid dan user profile didapatkan.</p>
                </li>
                <li>
                    5. Api Update Profile
                    <p class=" m-0">Untuk update data profile user, membutuhkan beberapa syarat, pertama : <span class="badge badge-info">JWT Token</span> dan yang kedua: <span class="badge badge-info">ID User</span> , menggunakan link: <span class="badge badge-secondary">http://admin.petikdua.store/api/user/{id}</span> dengan method <span class="badge badge-warning">PUT</span>. Type data yang dikirimkan diwajibkan <span class="badge badge-info">multipart/form-data</span></p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">Bearer Token &emsp; : &emsp; Wajib </span> </p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">firstname &emsp; : &emsp; Wajib </span> </p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">lastname &emsp; : &emsp; Wajib </span> </p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">school &emsp; : &emsp; Wajib </span> </p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">graduate &emsp; : &emsp; Wajib </span> </p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">province_id &emsp; : &emsp; Wajib </span> </p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">regenciy_id &emsp; : &emsp; Wajib </span> </p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">address &emsp; : &emsp; Wajib </span> </p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">univ1_id &emsp; : &emsp; Wajib </span> </p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">univ2_id &emsp; : &emsp; Wajib </span> </p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">prodi1_id &emsp; : &emsp; Wajib </span> </p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">prodi2_id &emsp; : &emsp; Wajib </span> </p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">image &emsp; : &emsp; Wajib, File </span> </p>
                    <p class=" m-0">Response yang akan di dapatkan ada dua : <span class="badge badge-danger">Error</span> dan <span class="badge badge-success">Success</span> yang mana jika response error artinya token tidak valid dengan kesimpulan belom login. Sedangkan response success artinya token valid dan user profile bisa diupdate.</p>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Collapsable Card Example -->
<div class="card shadow mb-4">
    <!-- Card Header - Accordion -->
    <a href="#univAPi" class="d-block card-header py-3 bg-warning" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="univAPi">
        <h6 class="m-0 font-weight-bold text-white">Universitas APi</h6>
    </a>
    <!-- Card Content - Collapse -->
    <div class="collapse show" id="univAPi">
        <div class="card-body">
            <ul class="list-unstyled">
                <li>
                    1. Get ALl Universitas
                    <p class=" m-0">untuk mendapatkan semua data univeristas, menggunakan link: <span class="badge badge-secondary">http://admin.petikdua.store/api/univ</span> dengan method <span class="badge badge-warning">GET</span>
                </li>
                <hr>
                <li>
                    2. Get Id Universitas
                    <p class=" m-0">Untuk mendapatkan satu data dengan kunci id univ, menggunakan link: <span class="badge badge-secondary">http://admin.petikdua.store/api/univ/{id}</span> dengan method <span class="badge badge-warning">GET</span> contoh penggunaan </p>
                    <p><span class="badge badge-primary">http://admin.petikdua.store/api/univ/22</span></p>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Collapsable Card Example -->
<div class="card shadow mb-4">
    <!-- Card Header - Accordion -->
    <a href="#prodiApi" class="d-block card-header py-3 bg-warning" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="prodiApi">
        <h6 class="m-0 font-weight-bold text-white">Prodi APi</h6>
    </a>
    <!-- Card Content - Collapse -->
    <div class="collapse show" id="prodiApi">
        <div class="card-body">
            <ul class="list-unstyled">
                <li>
                    1. Get ALl Prodi
                    <p class=" m-0">untuk mendapatkan semua data prodi, menggunakan link: <span class="badge badge-secondary">http://admin.petikdua.store/api/prodi</span> dengan method <span class="badge badge-warning">GET</span>
                </li>
                <hr>
                <li>
                    2. Get Id Prodi
                    <p class=" m-0">Untuk mendapatkan satu data dengan kunci id prodi, menggunakan link: <span class="badge badge-secondary">http://admin.petikdua.store/api/prodi/{id}</span> dengan method <span class="badge badge-warning">GET</span> contoh penggunaan </p>
                    <p><span class="badge badge-primary">http://admin.petikdua.store/api/prodi/22</span></p>
                </li>
                <li>
                    3. Get Id With ID-Univ Prodi
                    <p class=" m-0">Untuk mendapatkan data prodi sesuai univnya, menggunakan link: <span class="badge badge-secondary">http://admin.petikdua.store/api/prodi/get/{id}</span> dengan method <span class="badge badge-warning">GET</span> contoh penggunaan </p>
                    <p><span class="badge badge-primary">http://admin.petikdua.store/api/prodi/get/7</span></p>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Collapsable Card Example -->
<div class="card shadow mb-4">
    <!-- Card Header - Accordion -->
    <a href="#provApi" class="d-block card-header py-3 bg-warning" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="provApi">
        <h6 class="m-0 font-weight-bold text-white">Provinsi APi</h6>
    </a>
    <!-- Card Content - Collapse -->
    <div class="collapse show" id="provApi">
        <div class="card-body">
            <ul class="list-unstyled">
                <li>
                    1. Get ALl Province
                    <p class=" m-0">Untuk mendapatkan semua data provinsi, menggunakan link: <span class="badge badge-secondary">http://admin.petikdua.store/api/prov</span> dengan method <span class="badge badge-warning">GET</span>
                </li>
                <hr>
                <li>
                    2. Get Id Provinsi
                    <p class=" m-0">Untuk mendapatkan satu data dengan kunci id provinsi, menggunakan link: <span class="badge badge-secondary">http://admin.petikdua.store/api/prov/{id}</span> dengan method <span class="badge badge-warning">GET</span> contoh penggunaan </p>
                    <p><span class="badge badge-primary">http://admin.petikdua.store/api/prov/22</span></p>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Collapsable Card Example -->
<div class="card shadow mb-4">
    <!-- Card Header - Accordion -->
    <a href="#regApi" class="d-block card-header py-3 bg-warning" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="regApi">
        <h6 class="m-0 font-weight-bold text-white">Regencie APi</h6>
    </a>
    <!-- Card Content - Collapse -->
    <div class="collapse show" id="regApi">
        <div class="card-body">
            <ul class="list-unstyled">
                <li>
                    1. Get ALl Regencie
                    <p class=" m-0">untuk mendapatkan semua data Kota/Kabupaten, menggunakan link: <span class="badge badge-secondary">http://admin.petikdua.store/api/reg</span> dengan method <span class="badge badge-warning">GET</span>
                </li>
                <hr>
                <li>
                    2. Get Id Regencie
                    <p class=" m-0">Untuk mendapatkan satu data dengan kunci id Kota/Kabupaten, menggunakan link: <span class="badge badge-secondary">http://admin.petikdua.store/api/reg/{id}</span> dengan method <span class="badge badge-warning">GET</span> contoh penggunaan </p>
                    <p><span class="badge badge-primary">http://admin.petikdua.store/api/reg/22</span></p>
                </li>
                <li>
                    3. Get Id With ID-Province Regencie
                    <p class=" m-0">Untuk mendapatkan data Kota/Kabupaten sesuai provinsi, menggunakan link: <span class="badge badge-secondary">http://admin.petikdua.store/api/reg/get/{id}</span> dengan method <span class="badge badge-warning">GET</span> contoh penggunaan </p>
                    <p><span class="badge badge-primary">http://admin.petikdua.store/api/reg/get/7</span></p>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Collapsable Card Example -->
<div class="card shadow mb-4">
    <!-- Card Header - Accordion -->
    <a href="#TryApi" class="d-block card-header py-3 bg-warning" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="TryApi">
        <h6 class="m-0 font-weight-bold text-white">Tryout APi</h6>
    </a>
    <!-- Card Content - Collapse -->
    <div class="collapse show" id="TryApi">
        <div class="card-body">
            <ul class="list-unstyled">
                <li>
                    0. Info Tryout
                    <p class=" m-0">
                        A. Penjelasan mengenai <span class=" badge badge-warning"> type_tryout</span> <br>
                        <?php foreach (jenisTryout() as $item) : ?>
                            &emsp; <span class=" badge badge-info"> <?= $item[1] ?> &emsp; : &emsp; <?= $item[0] ?></span><br>
                        <?php endforeach ?>
                    </p>
                    <p class=" m-0">
                        B. Penjelasan mengenai <span class=" badge badge-warning"> cat_tryout</span> <br>
                        <?php foreach (catTryout() as $item) : ?>
                            &emsp; <span class=" badge badge-info"> <?= $item[1] ?> &emsp; : &emsp; <?= $item[0] ?></span><br>
                        <?php endforeach ?>
                    </p>
                    <p class=" m-0">
                        C. Penjelasan mengenai <span class=" badge badge-warning"> payment_method</span> <br>
                        <?php foreach (paymentMethod() as $item) : ?>
                            &emsp; <span class=" badge badge-info"> <?= $item[1] ?> &emsp; : &emsp; <?= $item[0] ?></span><br>
                        <?php endforeach ?>
                    </p>
                    <p class=" m-0">
                        D. Penjelasan mengenai <span class=" badge badge-warning"> Mapel</span> <br>
                        <?php foreach (allMapel() as $item) : ?>
                            &emsp; <span class=" badge badge-info"> <?= $item[1] ?> &emsp; : &emsp; <?= $item[0] ?></span><br>
                        <?php endforeach ?>
                    </p>
                </li>
                <hr>
                <li>
                    1. Get ALl Tryout
                    <p class=" m-0">untuk mendapatkan semua data Tryout, menggunakan link: <span class="badge badge-secondary">http://admin.petikdua.store/api/tryout</span> dengan method <span class="badge badge-warning">GET</span></p>
                </li>
                <hr>
                <li>
                    2. Get Id Tryout
                    <p class=" m-0">Untuk mendapatkan satu data dengan id, menggunakan link: <span class="badge badge-secondary">http://admin.petikdua.store/api/tryout/{id}</span> dengan method <span class="badge badge-warning">GET</span> contoh penggunaan </p>
                    <p><span class="badge badge-primary">http://admin.petikdua.store/api/reg/22</span></p>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Collapsable Card Example -->
<div class="card shadow mb-4">
    <!-- Card Header - Accordion -->
    <a href="#myTryApi" class="d-block card-header py-3 bg-warning" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="myTryApi">
        <h6 class="m-0 font-weight-bold text-white">My Tryout APi</h6>
    </a>
    <!-- Card Content - Collapse -->
    <div class="collapse show" id="myTryApi">
        <div class="card-body">
            <ul class="list-unstyled">
                <li>
                    1. Get ALl My Tryout
                    <p class=" m-0">untuk mendapatkan semua data My Tryout, menggunakan link: <span class="badge badge-secondary">http://admin.petikdua.store/api/mytryout/{page}</span> dengan method <span class="badge badge-warning">GET</span> contoh penggunaan <span class="badge badge-primary">http://admin.petikdua.store/api/mytryout/22</span> Dengan mengirimkan beberapa data dengan keterangan berikut :</p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">id &emsp; : &emsp; Wajib, Ket: id dari user </span> </p>
                    </p>
                </li>
                <hr>
                <li>
                    2. Check My Tryout
                    <p class=" m-0">Untuk mengecek data My Tryout, menggunakan link: <span class="badge badge-secondary">http://admin.petikdua.store/api/mytryout/check</span> dengan method <span class="badge badge-warning">GET</span> . Dengan mengirimkan beberapa data dengan keterangan berikut :</p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">iduser &emsp; : &emsp; Wajib, Ket: id dari user </span> </p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">idtryout &emsp; : &emsp; Wajib, Ket: id dari tryout </span> </p>
                    </p>
                </li>
                <hr>
            </ul>
        </div>
    </div>
</div>
<!-- Collapsable Card Example -->
<div class="card shadow mb-4">
    <!-- Card Header - Accordion -->
    <a href="#topApi" class="d-block card-header py-3 bg-warning" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="topApi">
        <h6 class="m-0 font-weight-bold text-white">Top Up APi</h6>
    </a>
    <!-- Card Content - Collapse -->
    <div class="collapse show" id="topApi">
        <div class="card-body">
            <ul class="list-unstyled">
                <li>
                    0. Info TopUp
                    <p class=" m-0">
                        A. Penjelasan mengenai <span class=" badge badge-warning"> bank_id</span> <br>
                        <?php foreach (AllPayment() as $item) : ?>
                            &emsp; <span class=" badge badge-info"> <?= $item[1] ?> &emsp; : &emsp; <?= $item[0] ?></span><br>
                        <?php endforeach ?>
                    </p>
                    <p class=" m-0">
                        B. Penjelasan mengenai <span class=" badge badge-warning"> status</span> <br>
                        <?php foreach (statusTopup() as $item) : ?>
                            &emsp; <span class=" badge badge-info"> <?= $item[1] ?> &emsp; : &emsp; <?= $item[0] ?></span><br>
                        <?php endforeach ?>
                    </p>
                </li>
                <hr>
                <li>
                    1. Get ALl Topup
                    <p class=" m-0">Untuk mendapatkan semua data Top Up, menggunakan link: <span class="badge badge-secondary">http://admin.petikdua.store/api/topup</span> dengan method <span class="badge badge-warning">GET</span>
                        dengan mengirimkan beberapa data dengan keterangan berikut :</p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">id &emsp; : &emsp; Wajib, Ket: id dari user </span> </p>
                </li>
                <hr>
                <li>
                    2. Get Single Topup
                    <p class=" m-0">Untuk mendapatkan satu data dengan id topup, menggunakan link: <span class="badge badge-secondary">http://admin.petikdua.store/api/topup/{id}</span> dengan method <span class="badge badge-warning">GET</span> contoh penggunaan </p>
                    <p><span class="badge badge-primary">http://admin.petikdua.store/api/topup/22</span></p>
                </li>
                <li>
                    3. Create Topup
                    <p class=" m-0">Untuk melakukan pembuatan topup, menggunakan link: <span class="badge badge-secondary">http://admin.petikdua.store/api/topup/</span> dengan method <span class="badge badge-warning">POST</span> . Type data yang dikirimkan diwajibkan <span class="badge badge-info">multipart/form-data</span>. Dengan mengirimkan beberapa data dengan keterangan berikut :</p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">id &emsp; : &emsp; Wajib, Ket: id dari user </span> </p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">bankid &emsp; : &emsp; Wajib, Ket: id dari bank yang dipilih </span> </p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">nominal &emsp; : &emsp; Wajib</span> </p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">image &emsp; : &emsp; Wajib, File</span> </p>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Collapsable Card Example -->
<div class="card shadow mb-4">
    <!-- Card Header - Accordion -->
    <a href="#transfapi" class="d-block card-header py-3 bg-warning" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="transfapi">
        <h6 class="m-0 font-weight-bold text-white">Transfer APi</h6>
    </a>
    <!-- Card Content - Collapse -->
    <div class="collapse show" id="transfapi">
        <div class="card-body">
            <ul class="list-unstyled">
                <li>
                    1. Get ALl Transfer
                    <p class=" m-0">Untuk mendapatkan data Transfer semua pada satu user, menggunakan link: <span class="badge badge-secondary">http://admin.petikdua.store/api/transfer</span> dengan method <span class="badge badge-warning">GET</span>
                        dengan mengirimkan beberapa data dengan keterangan berikut :</p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">id &emsp; : &emsp; Wajib, Ket: id dari user </span> </p>
                </li>
                <hr>
                <li>
                    2. Get Single Data
                    <p class=" m-0">Untuk mendapatkan satu data dengan id transfer, menggunakan link: <span class="badge badge-secondary">http://admin.petikdua.store/api/transfer/{id}</span> dengan method <span class="badge badge-warning">GET</span> contoh penggunaan </p>
                    <p><span class="badge badge-primary">http://admin.petikdua.store/api/transfer/22</span></p>
                </li>
                <li>
                    3. Create Transfer
                    <p class=" m-0">Untuk melakukan pembuatan transfer, menggunakan link: <span class="badge badge-secondary">http://admin.petikdua.store/api/transfer/</span> dengan method <span class="badge badge-warning">POST</span> . Dengan mengirimkan beberapa data dengan keterangan berikut :</p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">fromid &emsp; : &emsp; Wajib, Ket: id dari user pengirim </span> </p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">telp &emsp; : &emsp; Wajib, Ket: id dari nomer hp penerima </span> </p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">nominal &emsp; : &emsp; Wajib</span> </p>
                </li>
                <li>
                    4. Get Telp Transfer
                    <p class=" m-0">Untuk melakukan mengecek nomer hp transfer, menggunakan link: <span class="badge badge-secondary">http://admin.petikdua.store/api/transfer/notelp/{nohp}</span> dengan method <span class="badge badge-warning">get</span> . Dengan mengirimkan beberapa data dengan keterangan berikut :</p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">Token &emsp; : &emsp; Wajib,Bearear Token</span> </p>
                </li>
            </ul>
        </div>
    </div>
</div>
<?= $this->endsection() ?>