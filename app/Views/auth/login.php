<?= $this->extend('template/auth') ?>

<?= $this->section('content') ?>

<body class="login-page">

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
                </div>

                <div class="card-body">
                    <form action="<?= base_url('login') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" name="login" placeholder="Email">
                        </div>

                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" name="password" placeholder="Password">
                        </div>

                        <a href="<?= base_url('forgot') ?>">Lupa Password ?</a>

                        <button type="submit" class="btn-login">Masuk</button>
                    </form>
                </div>
            </div>
        </div>
    </section>


    <script src="<?= base_url() ?>/assets/js/jquery-3.5.1.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/style.js"></script>

</body>

<?= $this->endSection() ?>