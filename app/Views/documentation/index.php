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
                    <p class=" m-0">Untuk melakukan pendaftaran user di APi camakara ini, menggunakan link: <span class="badge badge-secondary">http://localhost:8080/api/user</span> dengan method <span class="badge badge-warning">POST</span> dengan mengirimkan beberapa data dengan keterangan berikut :</p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">email &emsp; : &emsp; Wajib, Valid email </span> </p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">password &emsp; : &emsp; Wajib, lebih dari 8 karakter</span> </p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">fullname &emsp; : &emsp; Wajib, lebih dari 3 karakter</span> </p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">Telp &emsp; : &emsp; Wajib, wajib angka</span> </p>
                    <p class=" m-0">Response yang akan di dapatkan ada dua : <span class="badge badge-danger">Error</span> dan <span class="badge badge-success">Success</span> yang mana jika response error akan terlihat error terdapat di mana?</p>
                </li>
                <hr>
                <li>
                    2. Api Login
                    <p class=" m-0">Login Api dari camakara ini menggunakan service JWT yang mana nanti JWT ini digunakan untuk pengaksesan resource yang lain, seperti contoh Profile, kelas dan sebagainya, dan bisa untuk mendeteksi sudah login atau belum, menggunakan link: <span class="badge badge-secondary">http://localhost:8080/api/user</span> dengan method <span class="badge badge-warning">GET</span> dengan mengirimkan beberapa data dengan keterangan berikut :</p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">email &emsp; : &emsp; Wajib, Valid email </span> </p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">password &emsp; : &emsp; Wajib</span> </p>
                    <p class=" m-0">Response yang akan di dapatkan ada dua : <span class="badge badge-danger">Error</span> dan <span class="badge badge-success">Success</span> yang mana jika response error akan terlihat error terdapat di mana?. Sedangkan response success akan mengembalikan data dari user dan juga mengembalikan token JWT</p>
                </li>
                <hr>
                <li>
                    3. Api Cek Login
                    <p class=" m-0">Cek login ini digunakan untuk mengecek apakah user sudah login atau belum dengan memanfaatkan <span class="badge badge-info">JWT Token</span> yang usdah di dapatkan pada saat login , menggunakan link: <span class="badge badge-secondary">http://localhost:8080/api/user/islogin</span> dengan method <span class="badge badge-warning">GET</span> dengan mengirimkan beberapa data dengan keterangan berikut :</p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">Bearer Token &emsp; : &emsp; Wajib </span> </p>
                    <p class=" m-0">Response yang akan di dapatkan ada dua : <span class="badge badge-danger">Error</span> dan <span class="badge badge-success">Success</span> yang mana jika response error artinya token tidak valid dengan kesimpulan belom login. Sedangkan response success artinya token valid dan user sudah login</p>
                </li>
                <hr>
                <li>
                    4. Api Get Profile
                    <p class=" m-0">Untuk mendapatkan data profile dari user, membutuhkan beberapa syarat, pertama : <span class="badge badge-info">JWT Token</span> dan yang kedua: <span class="badge badge-info">ID User</span> , menggunakan link: <span class="badge badge-secondary">http://localhost:8080/api/user/{id}</span> dengan method <span class="badge badge-warning">GET</span></p>
                    <p class="pl-5 m-0 "><span class="badge badge-success">Bearer Token &emsp; : &emsp; Wajib </span> </p>
                    <p class=" m-0">Response yang akan di dapatkan ada dua : <span class="badge badge-danger">Error</span> dan <span class="badge badge-success">Success</span> yang mana jika response error artinya token tidak valid dengan kesimpulan belom login. Sedangkan response success artinya token valid dan user profile didapatkan.</p>
                </li>
                <li>
                    5. Api Update Profile
                    <p class=" m-0">Untuk update data profile user, membutuhkan beberapa syarat, pertama : <span class="badge badge-info">JWT Token</span> dan yang kedua: <span class="badge badge-info">ID User</span> , menggunakan link: <span class="badge badge-secondary">http://localhost:8080/api/user/{id}</span> dengan method <span class="badge badge-warning">PUT</span></p>
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
                    <p class=" m-0">untuk mendapatkan semua data univeristas, menggunakan link: <span class="badge badge-secondary">http://localhost:8080/api/univ</span> dengan method <span class="badge badge-warning">GET</span>
                </li>
                <hr>
                <li>
                    2. Get Id Universitas
                    <p class=" m-0">Untuk mendapatkan satu data dengan kunci id univ, menggunakan link: <span class="badge badge-secondary">http://localhost:8080/api/univ/{id}</span> dengan method <span class="badge badge-warning">GET</span> contoh penggunaan </p>
                    <p><span class="badge badge-primary">http://localhost:8080/api/univ/22</span></p>
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
                    <p class=" m-0">untuk mendapatkan semua data prodi, menggunakan link: <span class="badge badge-secondary">http://localhost:8080/api/prodi</span> dengan method <span class="badge badge-warning">GET</span>
                </li>
                <hr>
                <li>
                    2. Get Id Prodi
                    <p class=" m-0">Untuk mendapatkan satu data dengan kunci id prodi, menggunakan link: <span class="badge badge-secondary">http://localhost:8080/api/prodi/{id}</span> dengan method <span class="badge badge-warning">GET</span> contoh penggunaan </p>
                    <p><span class="badge badge-primary">http://localhost:8080/api/prodi/22</span></p>
                </li>
                <li>
                    3. Get Id With ID-Univ Prodi
                    <p class=" m-0">Untuk mendapatkan data prodi sesuai univnya, menggunakan link: <span class="badge badge-secondary">http://localhost:8080/api/prodi/get/{id}</span> dengan method <span class="badge badge-warning">GET</span> contoh penggunaan </p>
                    <p><span class="badge badge-primary">http://localhost:8080/api/prodi/get/7</span></p>
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
                    <p class=" m-0">Untuk mendapatkan semua data provinsi, menggunakan link: <span class="badge badge-secondary">http://localhost:8080/api/prov</span> dengan method <span class="badge badge-warning">GET</span>
                </li>
                <hr>
                <li>
                    2. Get Id Provinsi
                    <p class=" m-0">Untuk mendapatkan satu data dengan kunci id provinsi, menggunakan link: <span class="badge badge-secondary">http://localhost:8080/api/prov/{id}</span> dengan method <span class="badge badge-warning">GET</span> contoh penggunaan </p>
                    <p><span class="badge badge-primary">http://localhost:8080/api/prov/22</span></p>
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
                    <p class=" m-0">untuk mendapatkan semua data Kota/Kabupaten, menggunakan link: <span class="badge badge-secondary">http://localhost:8080/api/reg</span> dengan method <span class="badge badge-warning">GET</span>
                </li>
                <hr>
                <li>
                    2. Get Id Regencie
                    <p class=" m-0">Untuk mendapatkan satu data dengan kunci id Kota/Kabupaten, menggunakan link: <span class="badge badge-secondary">http://localhost:8080/api/reg/{id}</span> dengan method <span class="badge badge-warning">GET</span> contoh penggunaan </p>
                    <p><span class="badge badge-primary">http://localhost:8080/api/reg/22</span></p>
                </li>
                <li>
                    3. Get Id With ID-Province Regencie
                    <p class=" m-0">Untuk mendapatkan data Kota/Kabupaten sesuai provinsi, menggunakan link: <span class="badge badge-secondary">http://localhost:8080/api/reg/get/{id}</span> dengan method <span class="badge badge-warning">GET</span> contoh penggunaan </p>
                    <p><span class="badge badge-primary">http://localhost:8080/api/reg/get/7</span></p>
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
                    1. Get ALl Tryout
                    <p class=" m-0">untuk mendapatkan semua data Tryout, menggunakan link: <span class="badge badge-secondary">http://localhost:8080/api/tryout</span> dengan method <span class="badge badge-warning">GET</span>
                </li>
                <hr>
                <li>
                    2. Get Id Tryout
                    <p class=" m-0">Untuk mendapatkan satu data dengan id, menggunakan link: <span class="badge badge-secondary">http://localhost:8080/api/tryout/{id}</span> dengan method <span class="badge badge-warning">GET</span> contoh penggunaan </p>
                    <p><span class="badge badge-primary">http://localhost:8080/api/reg/22</span></p>
                </li>
            </ul>
        </div>
    </div>
</div>
<?= $this->endsection() ?>