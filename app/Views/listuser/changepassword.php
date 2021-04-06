<?= $this->extend('template/admin') ?>
<?= $this->section('content') ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Password User</h1>
</div>
<hr>
<table>
    <tr>
        <td>
            <h4 class=" mb-0 text-primary">Email</h4>
        </td>
        <td>
            <h4 class=" mb-0 text-primary">:</h4>
        </td>
        <td>
            <h4 class=" mb-0 text-primary"><?= $user->email ?></h4>
        </td>
    </tr>
    <tr>
        <td>
            <h4 class=" mb-0 text-primary">Username</h4>
        </td>
        <td>
            <h4 class=" mb-0 text-primary">:</h4>
        </td>
        <td>
            <h4 class=" mb-0 text-primary"><?= $user->username ?></h4>
        </td>
    </tr>
</table>
<hr>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <form method="POST" action="<?= base_url('listuser/changePasswordAttempt/' . $id) ?>" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" class="form-control  <?= ($validation->hasError('password')) ? 'is-invalid' : "" ?>" name="password" value="<?= old('password') ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('password') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Password Konfirmasi</label>
                        <input type="password" class="form-control  <?= ($validation->hasError('pass_confirm')) ? 'is-invalid' : "" ?>" name="pass_confirm" value="<?= old('pass_confirm') ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('pass_confirm') ?>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?= $this->endsection() ?>
<?= $this->section('script') ?>
<script>
    function previewImg() {
        const sampul = document.querySelector('#sampul');
        const imgPreview = document.querySelector('#preview');

        const fileSampul = new FileReader();
        fileSampul.readAsDataURL(sampul.files[0]);

        fileSampul.onload = function(e) {
            imgPreview.src = e.target.result;
        }
    }
</script>

<?= $this->endsection() ?>