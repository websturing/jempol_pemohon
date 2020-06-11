<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Panel min</title>
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <link href="<?php echo e(url('public/css/icon.css')); ?>" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
        <link href="<?php echo e(url('public/global_assets/css/icons/icomoon/styles.css')); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo e(url('public/assets/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo e(url('public/assets/css/bootstrap_limitless.min.css')); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo e(url('public/assets/css/layout.min.css')); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo e(url('public/assets/css/components.min.css')); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo e(url('public/assets/css/colors.min.css')); ?>" rel="stylesheet" type="text/css">
        <style>
            .error{
                background-color: red !important;
                z-index: 999 !important;
                border: 1px solid red;
            }
        </style>
    </head>
    <body>
        <div id="app">
        <div class="page-header page-header-dark">

            <!-- Main navbar -->
            <div class="navbar navbar-expand-md navbar-dark border-transparent">
                <div class="navbar-brand wmin-0 mr-5">
                    <a href="index.html" class="d-inline-block">
                        <img src="<?php echo e(url('public/global_assets/images/logo_light.png')); ?>" alt="">
                    </a>
                </div>
            </div>
            <!-- /main navbar -->
    
    
            <!-- Page header content -->
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4>{{activeName}} <small class="font-size-base opacity-50">Good morning, Eugene</small></h4>
                    <a href="#" class="header-elements-toggle text-white d-md-none"><i class="icon-more"></i></a>
                </div>
    
                <div class="header-elements d-none bg-transparent py-0 border-0 mb-3 mb-md-0">
                    <form action="#">
                        <div class="form-group form-group-feedback form-group-feedback-right">
                            <input type="search" class="form-control bg-light-alpha border-transparent wmin-md-200" placeholder="Search">
                            <div class="form-control-feedback">
                                <i class="icon-search4 font-size-sm"></i>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /page header content -->
    
    
            <!-- Secondary navbar -->
            <navbar :active-link="activeLink"></navbar>
            <!-- /secondary navbar -->

        </div>
        <div class="page-content">
            <div class="content-wrapper">
                <div class="content">
                <div>
                    <router-view :key="$route.fullPath"></router-view>
                </div>
                </div>
            </div>
        </div> 
        </div>
        <script src="<?php echo e(url('public/js/app.js')); ?>"></script>
    </body>
</html>
<?php /**PATH C:\xampp\htdocs\vueadminpanel\resources\views/panelmin/login.blade.php ENDPATH**/ ?>