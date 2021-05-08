<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Camakara - Administrator</title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets') ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets') ?>/css/sb-admin-2.min.css" rel="stylesheet">

    <link href="<?= base_url('assets') ?>/vendor/datatables/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url() ?>/css/style.css">
    <style>
        /* The switch - the box around the slider */
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
            float: right;
        }

        /* Hide default HTML checkbox */
        .switch input {
            display: none;
        }

        /* The slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input.default:checked+.slider {
            background-color: #444;
        }

        input.primary:checked+.slider {
            background-color: #2196F3;
        }

        input.success:checked+.slider {
            background-color: #8bc34a;
        }

        input.info:checked+.slider {
            background-color: #3de0f5;
        }

        input.warning:checked+.slider {
            background-color: #FFC107;
        }

        input.danger:checked+.slider {
            background-color: #f44336;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('dashboard') ?>">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-chalkboard-teacher "></i>
                </div>
                <div class="sidebar-brand-text mx-3">Camakara</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item <?= $title == 'dashboard' ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('dashboard') ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <?php
            if (in_groups(1) || in_groups(3)) :
            ?>
                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading">
                    Event
                </div>
                <!-- Nav Item - Dashboard -->
                <li class="nav-item <?= $title == 'confirm' ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('confirm') ?>">
                        <i class="fas fa-fw fa-archive"></i>
                        <span>Tabel Konfirmasi</span></a>
                </li>
                <!-- Nav Item - Dashboard -->
                <li class="nav-item <?= $title == 'tryout' ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('tryout') ?>">
                        <i class="fas fa-fw fa-book-open"></i>
                        <span>Tryout</span></a>
                </li>
                <!-- Nav Item - Dashboard -->
                <li class="nav-item <?= $title == 'quiz' ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('quiz') ?>">
                        <i class="fas fa-fw fa-book-open"></i>
                        <span>Quiz</span></a>
                </li>
                <!-- Divider -->
                <hr class="sidebar-divider">
            <?php endif;
            if (in_groups(1) || in_groups(2)) : ?>
                <!-- Heading -->
                <div class="sidebar-heading">
                    Keuangan
                </div>
                <!-- Nav Item - Dashboard -->
                <li class="nav-item <?= $title == 'confirmfinance' ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('confirmfinance') ?>">
                        <i class="fas fa-fw fa-archive"></i>
                        <span>Tabel Konfirmasi</span></a>
                </li>
                <!-- Nav Item - Dashboard -->
                <li class="nav-item <?= $title == 'tabledata' ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('tabledata') ?>">
                        <i class="fas fa-fw fa-book-open"></i>
                        <span>Tabel Data</span></a>
                </li>
                <!-- Divider -->
                <hr class="sidebar-divider">
            <?php endif;
            if (in_groups(1)) :
            ?>
                <!-- Heading -->
                <div class="sidebar-heading">
                    User Management
                </div>
                <!-- Nav Item - Dashboard -->
                <li class="nav-item <?= $title == 'listuser' ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('listuser') ?>">
                        <i class="fas fa-fw fa-users"></i>
                        <span>List User</span></a>
                </li>
                <!-- Divider -->
                <hr class="sidebar-divider">
                <!-- Heading -->
                <div class="sidebar-heading">
                    Documentation
                </div>
                <!-- Nav Item - Dashboard -->
                <li class="nav-item <?= $title == 'documentation' ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('documentation') ?>">
                        <i class="fas fa-fw fa-book"></i>
                        <span>APi dokumentation</span></a>
                </li>
                <!-- Divider -->
                <hr class="sidebar-divider">
            <?php endif
            ?>
            <!-- Nav Item - Dashboard -->
            <li class="nav-item <?= $title == 'logout' ? 'active' : '' ?>">
                <a data-toggle="modal" data-target="#logoutModal" class="nav-link">
                    <i class="fas fa-fw fa-door-open"></i>
                    <span>Log Out</span></a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <div class="d-inline">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= user()->email ?></span>
                                    <img class="img-profile rounded-circle" src="<?= base_url('assets') ?>/img/undraw_profile.svg">
                                </a>
                            </div>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <!-- <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div> -->
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <?= $this->renderSection('content') ?>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Camakara <?= date('Y') ?></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Yakin Logout?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Yakin logout?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-warning" href="<?= base_url('logout') ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets') ?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('assets') ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets') ?>/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets') ?>/js/sb-admin-2.min.js"></script>
    <!-- Page level plugins -->
    <script src="<?= base_url('assets') ?>/vendor/datatables/datatables.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?= base_url('assets') ?>/js/demo/datatables-demo.js"></script>
    <!-- Page level plugins -->
    <script src="<?= base_url('assets') ?>/vendor/chart.js/Chart.min.js"></script>
    <?= $this->renderSection('script') ?>
</body>

</html>