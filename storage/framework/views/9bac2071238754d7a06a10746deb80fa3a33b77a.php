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
        <navbar :active-link="activeLink" :active-name="activeName" v-show="activeShow"></navbar>
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
<?php /**PATH C:\xampp\htdocs\vueadminpanel\resources\views/panelmin/master.blade.php ENDPATH**/ ?>