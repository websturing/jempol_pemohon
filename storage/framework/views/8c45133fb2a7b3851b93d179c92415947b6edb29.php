<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dinas Penanaman Modal Dan Pelayanan Terpadu Satu Pintu Provinsi Kepulauan Riau</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?php echo e(url('public/starAdmin/assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(url('public/starAdmin/assets/vendors/iconfonts/ionicons/css/ionicons.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(url('public/starAdmin/assets/vendors/iconfonts/typicons/src/font/typicons.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(url('public/starAdmin/assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(url('public/starAdmin/assets/vendors/css/vendor.bundle.base.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(url('public/starAdmin/assets/vendors/css/vendor.bundle.addons.css')); ?>">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="<?php echo e(url('public/starAdmin/assets/css/shared/style.css')); ?>">
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="<?php echo e(url('public/starAdmin/assets/css/demo_1/style.css')); ?>">
    <!-- End Layout styles -->
    <link rel="shortcut icon" href="<?php echo e(url('public/starAdmin/assets/images/fav.png')); ?>" />
</head>

<body>
    <div class="container-scroller">
        <div id="app">
            <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
                <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
                    <a class="navbar-brand brand-logo" href="<?php echo e(url('/')); ?>">
                        <img src=" <?php echo e(url('public/starAdmin/assets/images/logo.png')); ?>" alt="logo" /> </a>
                    <a class="navbar-brand brand-logo-mini" href="<?php echo e(url('/')); ?>">
                        <img src="<?php echo e(url('public/starAdmin/assets/images/logo-mini.png')); ?>" alt="logo" /> </a>
                </div>
                <div class="navbar-menu-wrapper d-flex align-items-center">
                    <ul class="navbar-nav">
                        <li class="nav-item font-weight-semibold d-none d-lg-block">Pengaduaan / Pertanyaan : (+62)811-7779-727</li>
                    </ul>
                    <form class="ml-auto search-form d-none d-md-block" action="#">
                        <div class="form-group">
                            <input type="search" class="form-control" placeholder="Search Here">
                        </div>
                    </form>

                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                        <span class="mdi mdi-menu"></span>
                    </button>
                </div>
            </nav>
            <!-- partial -->
            <div class="container-fluid page-body-wrapper">
                <!-- partial:partials/_sidebar.html -->
                <nav class="sidebar sidebar-offcanvas" id="sidebar">
                    <ul class="nav">
                        <li class="nav-item nav-profile">
                            <a href="#" class="nav-link">
                                <div class="profile-image">
                                    <img class="img-xs rounded-circle" src="<?php echo e(url('public/starAdmin/assets/images/faces-clipart/pic-1.png')); ?>" alt="profile image">
                                    <div class="dot-indicator bg-success"></div>
                                </div>
                                <div class="text-wrapper">
                                    <p class="profile-name"><?php echo e(Session::get('username')); ?></p>
                                    <p class="designation">Pengguna Jasa</p>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item nav-category">Menu Utama</li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('/dashboard')); ?>">
                                <i class="menu-icon typcn typcn-document-text"></i>
                                <span class="menu-title">Beranda</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('/profile')); ?>">
                                <i class="menu-icon typcn typcn-document-text"></i>
                                <span class="menu-title">Identitas Diri</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                                <i class="menu-icon typcn typcn-coffee"></i>
                                <span class="menu-title">Pengajuan Permohonan</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse" id="ui-basic">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item">
                                        <a class="nav-link" href="pages/ui-features/buttons.html">Baru</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="pages/ui-features/dropdowns.html">Proses</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="pages/ui-features/typography.html">Tertunda</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pages/forms/basic_elements.html">
                                <i class="menu-icon typcn typcn-shopping-bag"></i>
                                <span class="menu-title">FAQ</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('/logout')); ?>">
                                <i class="menu-icon typcn typcn-th-large-outline"></i>
                                <span class="menu-title">Keluar</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- partial -->
                <router-view :key="$route.fullPath"></router-view>

            </div>
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="<?php echo e(url('public/starAdmin/assets/vendors/js/vendor.bundle.base.js')); ?>"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="<?php echo e(url('public/starAdmin/assets/js/shared/off-canvas.js')); ?>"></script>
    <script src="<?php echo e(url('public/starAdmin/assets/js/shared/misc.js')); ?>"></script>
    <script src="<?php echo e(url('public/js/app.js')); ?>"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->

    <!-- End custom js for this page-->
</body>
<style>
    .item-purchase-banner {
        display: none;
    }

</style>

</html>
<?php /**PATH C:\laragon\www\ptsp_pemohon\resources\views/panel/index.blade.php ENDPATH**/ ?>