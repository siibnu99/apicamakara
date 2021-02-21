<?= $this->extend('template/auth') ?>

<?= $this->section('content') ?>

<body class="daftar-page">

    <section class="main">
        <div class="content">
            <div class="card">
                <div class="card-heading">
                    <img src="<?= base_url() ?>/assets/images/logo-1.png" alt="">
                    <h1>Camakara</h1>
                    <div style="text-align: center; font-size:small;">
                        <?= view('Myth\Auth\Views\_message_block') ?>
                    </div>
                    <hr>
                    <p>atau sudah memiliki akun ? <a href="<?= route_to('login') ?>">Masuk sekarang</a> </p>
                </div>

                <div class="card-body">
                    <form action="<?= route_to('register') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" name="email" placeholder="Email" value="<?= old('email') ?>">
                        </div>
                        <div class="form-group">
                            <label for="username"><?= lang('Auth.username') ?></label>
                            <input type="text" class="form-control <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>" name="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>">
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" name="password" placeholder="Password" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="">Konfirmasi Password</label>
                            <input type="password" name="pass_confirm" placeholder="Konfirmasi Password" autocomplete="off">
                        </div>

                        <button type="submit" class="btn-daftar">Daftar</button>
                    </form>
                </div>
            </div>
        </div>
    </section>


    <script src="<?= base_url() ?>/assets/js/jquery-3.5.1.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/style.js"></script>

</body>

<?= $this->endSection() ?>