<?= $this->extend('template/admin') ?>
<?= $this->section('content') ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Quiz</h1>
</div>

<a href="<?= base_url('quiz/create') ?>" class="btn btn-primary mb-4">Buat Quiz</a>
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="tableex1" width="100%" cellspacing="0">
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
                        <th>Active</th>
                        <th>Dibuat Oleh</th>
                        <th>Diubah Oleh</th>
                        <th>Dibuat Tanggal</th>
                        <th>Diubah Tanggal</th>
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
                        <th>Active</th>
                        <th>Dibuat Oleh</th>
                        <th>Diubah Oleh</th>
                        <th>Dibuat Tanggal</th>
                        <th>Diubah Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endsection() ?>
<?= $this->section('script') ?>
<script>
    function toogleActive(id, nama, checked) {
        $.post("<?= base_url('quiz/toogleactive') ?>" + "/" + id).done(function(data) {
            Swal.fire(
                'Berhasil',
                data,
                'success'
            )
        });
    }
    $(document).on('click', '.toogleActive', function() {
        let id = $(this).attr('idto');
        let nameto = $(this).attr('nameto');
        let active = $(this).attr('active');
        toogleActive(id, nameto, active)
    })
    $(document).ready(function() {

        var dataTable = $('#tableex1').DataTable({
            "processing": true,
            responsive: true,
            "oLanguage": {
                "sLengthMenu": "Tampilkan _MENU_ data per halaman",
                "sSearch": "Pencarian: ",
                "sZeroRecords": "Maaf, tidak ada data yang ditemukan",
                "sInfo": "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
                "sInfoEmpty": "Menampilkan 0 s/d 0 dari 0 data",
                "sInfoFiltered": "(di filter dari _MAX_ total data)",
                "oPaginate": {
                    "sFirst": "<<",
                    "sLast": ">>",
                    "sPrevious": "<",
                    "sNext": ">"
                }
            },
            columnDefs: [{
                targets: [0],
                orderable: false
            }],
            "ordering": true,
            "info": true,
            "serverSide": true,
            "stateSave": true,
            "scrollX": true,
            "ajax": {
                url: "<?= base_url('quiz/listdata') ?>", // json datasource
                type: "post", // method  , by default get
                error: function() { // error handling
                    $(".tabel_serverside-error").html("");
                    $("#tabel_serverside").append('<tbody class="tabel_serverside-error"><tr><th colspan="3">Data Tidak Ditemukan di Server</th></tr></tbody>');
                    $("#tabel_serverside_processing").css("display", "none");

                }
            }
        });
    });
</script>
<?= $this->endsection() ?>