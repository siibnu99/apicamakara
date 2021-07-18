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
            <table class="table table-bordered" id="tableex1" width="100%" cellspacing="0">
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

                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endsection() ?>
<?= $this->section('script') ?>
<script>
    $(document).ready(function() {

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = false;

        var pusher = new Pusher('9572fc108523db38ff8c', {
            cluster: 'ap1'
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('confirmfinance', function(data) {
            getData();
        });
    })

    function getData() {

        var dataTable = $('#tableex1').DataTable({
            "processing": true,
            destroy: true,
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
                url: "<?= base_url('admincamakara/confirmfinance/listdata') ?>", // json datasource
                type: "post", // method  , by default get
                error: function() { // error handling
                    $(".tabel_serverside-error").html("");
                    $("#tabel_serverside").append('<tbody class="tabel_serverside-error"><tr><th colspan="3">Data Tidak Ditemukan di Server</th></tr></tbody>');
                    $("#tabel_serverside_processing").css("display", "none");

                }
            }
        });
    }
    $(document).ready(function() {
        getData();
    });
</script>
<?= $this->endsection() ?>