<!DOCTYPE html>
<html class="no-js h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Sistem Informasi Poliklinik</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="<?= base_url('assets/css/all.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/icon.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/third_party/datatables/dataTables.bootstrap4.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" id="main-stylesheet" data-version="1.1.0" href="<?= base_url('assets/styles/shards-dashboards.1.1.0.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/styles/extras.1.1.0.min.css') ?>">
    <script async defer src="<?= base_url('assets/js/buttons.js') ?>"></script>
    <script src="<?= base_url('assets/js/jquery-3.3.1.min.js') ?>" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?= base_url('assets/css/jquery-ui.css') ?>">
</head>

<body class="h-100">
    <div id="base-url" style="display: none"><?= base_url() ?></div>
    <div class="container-fluid">
        <div class="row">
            <aside class="main-sidebar col-12 col-md-3 col-lg-2 px-0">
                <div class="main-navbar">
                    <nav class="navbar align-items-stretch navbar-light bg-white flex-md-nowrap border-bottom p-0">
                        <a class="navbar-brand w-100 mr-0" href="#" style="line-height: 25px;">
                            <div class="d-table m-auto">
                                <img id="main-logo" class="d-inline-block align-top mr-1" style="max-width: 25px;" src="<?= base_url('assets/images/shards-dashboards-logo.svg') ?>" alt="Shards Dashboard">
                                <span class="d-none d-md-inline ml-1">Poliklinik System</span>
                            </div>
                        </a>
                        <a class="toggle-sidebar d-sm-inline d-md-none d-lg-none">
                            <i class="material-icons">&#xE5C4;</i>
                        </a>
                    </nav>
                </div>

                <div class="nav-wrapper">
                    <?php

                    switch (session()->get('log_role')) {
                        case 1:
                            $menu = 'menu_admin';
                            break;
                        case 2:
                            $menu = 'menu_doctor';
                            break;
                        case 3:
                            $menu = 'menu_pasien';
                            break;
                        case 4:
                            $menu = 'menu_klinik';
                            break;
                        case 5:
                            $menu = 'menu_apoteker';
                            break;
                    }
                    ?>
                    <?= $this->include("layouts/$menu") ?>
                </div>
            </aside>

            <main class="main-content col-lg-10 col-md-9 col-sm-12 p-0 offset-lg-2 offset-md-3">
                <div class="main-navbar sticky-top bg-white">
                    <!-- Main Navbar -->
                    <nav class="navbar align-items-stretch navbar-light flex-md-nowrap p-0">
                        <form action="#" class="main-navbar__search w-100 d-none d-md-flex d-lg-flex">
                            <div class="input-group input-group-seamless ml-3">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <!-- <i class="fas fa-search"></i> -->
                                    </div>
                                </div>
                                <input class="navbar-search form-control" type="hidden" placeholder="Search for something..." aria-label="Search">
                            </div>
                        </form>
                        <ul class="navbar-nav border-left flex-row ">
                            <li class="nav-item dropdown">
                                <?php getLoggedInUser(); ?>
                                <a class="nav-link  text-nowrap px-3" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                    <?php if (session()->get('log_photo') == NULL) : ?>
                                        <img src="<?= base_url('assets/images/no-user-image.png') ?>" class="img-responsive user-avatar rounded-circle mr-2">
                                    <?php else : ?>
                                        <img src="<?= base_url('uploads/photo/' . session()->get('log_photo')) ?>" class="img-responsive user-avatar rounded-circle mr-2">
                                    <?php endif; ?>
                                    <span class="d-none d-md-inline-block"><?= session()->get('log_fullname') ?></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-small ">
                                    <a class="dropdown-item" href="<?= base_url('profile') ?>"><i class="material-icons">summarize</i> Profile</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="<?= base_url('auth/logout') ?>">
                                        <i class="material-icons text-danger">logout</i> Logout </a>
                                </div>
                            </li>
                        </ul>
                        <nav class="nav">
                            <a href="#" class="nav-link nav-link-icon toggle-sidebar d-md-inline d-lg-none text-center border-left" data-toggle="collapse" data-target=".header-navbar" aria-expanded="false" aria-controls="header-navbar">
                                <i class="material-icons">&#xE5D2;</i>
                            </a>
                        </nav>
                    </nav>
                </div>

                <!-- FLASH DATA -->

                <div class="alert alert-success alert-icon alert-dismissible fade show mb-0 <?= session()->getFlashData('message') ? '' : 'd-none' ?>" id="flash-alert" role="alert">
                    <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>


                    <i class="fa fa-check-circle mx-2"></i>
                    <strong>Pemberitahuan!</strong>
                    <span class="flash-message"><?= session()->getFlashData('message') ?></span>
                </div>

                <!-- END FLASH DATA -->

                <!-- START CONTENT -->

                <div class="main-content-container container-fluid px-4">