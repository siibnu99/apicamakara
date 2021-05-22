<?= $this->extend('template/admin') ?>
<?= $this->section('content') ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tabel User</h1>
</div>
<a href="<?= base_url('listuser/create') ?>" class="btn btn-primary mb-4">Buat User</a>
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Tanggal dibuat</th>
                        <th>Tanggal diupdate</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Tanggal dibuat</th>
                        <th>Tanggal diupdate</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($users as $item) :
                    ?>
                        <tr>
                            <th><?= $no ?></th>
                            <th><?= $item->email ?></th>
                            <th><?= $item->username ?></th>
                            <th><?= $item->created_at ?></th>
                            <th><?= $item->updated_at ?></th>
                            <th>
                                <a href="<?= base_url('listuser/changepassword') . '/' . $item->id ?>" class="badge badge-primary">Change Password</a>
                                <a href="<?= base_url('listuser/edit') . '/' . $item->id ?>" class="badge badge-warning">Edit</a>
                                <a href="<?= base_url('listuser/deleteAttempt') . '/' . $item->id ?>" class="badge badge-danger">Hapus</a>
                            </th>
                        </tr>
                    <?php
                        $no++;
                    endforeach
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endsection() ?>