<?php
$uri = service('uri');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/css-reset.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/fonts/font-awesome/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/scss/desktop-style.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/scss/tablet-style.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/scss/mobile-style.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/scss/mobileLandscape-style.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/js/aos/aos.css">

    <title>Camakara Try Out UTBK</title>
</head>

<body class="<?= $classBody ?>">
    <nav class="nav-desktop" id="desktop">
        <div class="content">
            <div class="logo">
                <img src="assets/images/logo-1.png" alt="">
            </div>
            <div class="menu">
                <ul>
                    <a href="<?= base_url('/') ?>" class="<?php if ($uri->getSegment(1) == null)  echo ('active') ?>">
                        <li>Beranda</li>
                        <hr>
                    </a>
                    <a href="<?= base_url('about') ?>" class="<?php if ($uri->getSegment(1) == 'about')  echo ('active') ?>">
                        <li>Tentang Camakara</li>
                        <hr>
                    </a>
                    <a href="product.html">
                        <li>Produk</li>
                        <hr>
                    </a>
                    <a href="testimonial.html">
                        <li>Testimonial</li>
                        <hr>
                    </a>
                </ul>
            </div>
            <div class="icon">
                <div class="icon-coins">
                    <i class="far fa-money-bill-alt"></i>
                    <h4>59 K</h4>
                </div>
                <div class="icon-profile">
                    <i class="fas fa-user"></i>
                    <h4>Profile</h4>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="dropdownProfile">
                    <ul>
                        <a href="profile.html">
                            <li>Akun Saya</li>
                        </a>
                        <a href="topup.html">
                            <li>Top Up</li>
                        </a>
                        <a href="my-tryout.html">
                            <li>Tryout Saya</li>
                        </a>
                        <a href="riwayat-pembelian.html">
                            <li>Riwayat Top Up</li>
                        </a>
                        <a href="login.html">
                            <li>Log Out</li>
                        </a>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <nav class="nav-mobile" id="mobile">
        <div class="content">
            <div class="btn-menu">
                <i class="fas fa-bars"></i>
            </div>

            <div class="icon">
                <div class="icon-coins">
                    <i class="far fa-money-bill-alt"></i>
                    <h4>59 K</h4>
                </div>
                <div class="icon-profile">
                    <i class="fas fa-user"></i>
                    <h4>Profile</h4>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="dropdownProfile">
                    <ul>
                        <a href="profile.html">
                            <li>Akun Saya</li>
                        </a>
                        <a href="topup.html">
                            <li>Top Up</li>
                        </a>
                        <a href="my-tryout.html">
                            <li>Tryout Saya</li>
                        </a>
                        <a href="riwayat-pembelian.html">
                            <li>Riwayat Top Up</li>
                        </a>
                        <a href="login.html">
                            <li>Log Out</li>
                        </a>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div class="menu" id="mobile">
        <ul>
            <a href="<?= base_url() ?>">
                <li>Beranda</li>
                <hr>
            </a>
            <a href="<?= base_url('about') ?>" class="active">
                <li>Tentang Camakara</li>
                <hr>
            </a>
            <a href="product.html">
                <li>Produk</li>
                <hr>
            </a>
            <a href="testimonial.html">
                <li>Testimonial</li>
                <hr>
            </a>
        </ul>
    </div>
    <?= $this->renderSection('content') ?>

    <section class="footer">
        <div class="content">
            <div class="body">
                <div class="contact">
                    <h4>Contact</h4>
                    <h6 onclick="window.location.href='https://g.page/yopiangga-web-app-design?share'">Kediri, Jawa Timur - Indonesia</h6>
                    <h6 onclick="window.location.href=''">0823 3041 0865</h6>
                    <h6 onclick="window.location.href=''">admin@camakara.com</h6>
                    <h6 onclick="window.location.href='http://petikdua.store/'">www.camakara.com</h6>
                    <div class="media-sosial">
                        <i class="fab fa-facebook-f"></i>
                        <i class="fab fa-instagram"></i>
                        <i class="fab fa-twitter"></i>
                        <i class="fab fa-linkedin-in"></i>
                    </div>
                </div>
                <div class="information">
                    <h4>Information</h4>
                    <h6 onclick="window.location.href=''">Tryout Baru</h6>
                    <h6 onclick="window.location.href=''">Tryout Populer</h6>
                    <h6 onclick="window.location.href=''">Artikel</h6>
                    <h6 onclick="window.location.href='riwayat-pembelian.html'">Riwayat Pembelian</h6>
                </div>
                <div class="navigation">
                    <h4>Navigation</h4>
                    <h6 onclick="window.location.href='beranda.html'">Dashboard</h6>
                    <h6 onclick="window.location.href='about.html'">About Us</h6>
                    <h6 onclick="window.location.href='product.html'">Product</h6>
                    <h6 onclick="window.location.href='testimonial.html'">Testimonials</h6>
                    <h6 onclick="window.location.href='contact.html'">Contact</h6>
                </div>
                <div class="photo">
                    <h4>Photo in Instagram</h4>
                    <div class="image">
                        <img src="assets/images/example.jpg" alt="">
                        <img src="assets/images/example.jpg" alt="">
                        <img src="assets/images/example.jpg" alt="">
                        <img src="assets/images/example.jpg" alt="">
                    </div>
                </div>
            </div>
            <div class="copyright">
                <h4>Copyright @ 2021 Camakara - All Right Reserved</h4>
            </div>
        </div>
    </section>
    <script src="<?= base_url() ?>/assets/js/aos/aos.js"></script>
    <script>
        AOS.init()
    </script>
    <script src="<?= base_url() ?>/assets/js/jquery-3.5.1.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/style.js"></script>
</body>


</html>