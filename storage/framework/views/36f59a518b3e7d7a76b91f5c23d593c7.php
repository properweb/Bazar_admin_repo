<!DOCTYPE html>
<html lang="en">
<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin</title>

    <link rel="stylesheet" href="<?php echo e(asset('/public/css/vendors/simplebar.css')); ?>">

    <link href="<?php echo e(asset('/public/css/style.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/themes/prism.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <link href="<?php echo e(asset('/public/css/examples.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('/public/vendors/@coreui/chartjs/css/coreui-chartjs.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">

            <img src="https://staging1.bazarcenter.ca/assets/images/bazar.svg" alt="">

        <svg class="sidebar-brand-narrow" width="46" height="46" alt="CoreUI Logo">
            <use xlink:href="<?php echo e(asset('/public/assets/brand/coreui.svg#signet')); ?>"></use>
        </svg>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <li class="nav-item"><a class="nav-link" href="<?php echo url('/dashboard')?>">
                Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo url('/role/show')?>">
                Role</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo url('/role/show-admin-user')?>">
                Admin Users</a></li>
    </ul>
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
<div class="wrapper d-flex flex-column min-vh-100 bg-light">
    <header class="header header-sticky mb-4">
        <div class="container-fluid">
            <button class="header-toggler px-md-0 me-md-3" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">

            </button><a class="header-brand d-md-none" href="#">
            </a>
            <ul class="header-nav d-none d-md-flex">
                <li class="nav-item"><a class="nav-link" href="#">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Change Password</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo url('/login/logout')?>">Log Out</a></li>
            </ul>


        </div>
        <div class="header-divider"></div>

<?php /**PATH /home/bazarcenter/public_html/staging.bazarcenter.ca/admin/resources/views/include/header.blade.php ENDPATH**/ ?>