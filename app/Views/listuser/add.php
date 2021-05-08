<?= $this->extend('template/admin') ?>
<?= $this->section('content') ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Buat User</h1>
    <a type="button" class="btn btn-primary" href="<?= base_url("listuser") ?>">Kembali</a>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <form method="POST" action="<?= base_url('listuser/createAttempt') ?>" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" class="form-control  <?= ($validation->hasError('email')) ? 'is-invalid' : "" ?>" name="email" value="<?= old('email') ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('email') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Username</label>
                        <input type="text" class="form-control  <?= ($validation->hasError('username')) ? 'is-invalid' : "" ?>" name="username" value="<?= old('username') ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('username') ?>
                        </div>
                    </div>
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
                    <div class="form-group">
                        <?php helper('menu') ?>
                        <label for="">Group User</label>
                        <select class="custom-select" id="jenis_tryout" name="group">
                            <option value="0" selected disabled>Pilihan</option>
                            <?php
                            foreach (groupUser() as $item) : ?>
                                <option value="<?= $item['1'] ?>" <?= old('group') ==  $item['1']  ? 'selected'  : ''  ?>><?= $item['0'] ?></option>
                            <?php endforeach
                            ?>
                        </select>
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