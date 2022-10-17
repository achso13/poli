<!DOCTYPE html>
<html class="no-js h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Login - Sistem Informasi Poliklinik</title>
    <meta name="description" content="">
    <link href="<?= base_url('assets/css/all.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/icon.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" id="main-stylesheet" data-version="1.1.0" href="<?= base_url('assets/styles/shards-dashboards.1.1.0.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/styles/extras.1.1.0.min.css') ?>">
    <script async defer src="<?= base_url('assets/js/buttons.js') ?>"></script>
    <script src="<?= base_url('assets/js/jquery-3.3.1.min.js') ?>" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
</head>

<body class="h-100">
    <div class="container-fluid">
        <div class="row h-100">
            <main class="main-content col">
                <div class="main-content-container container-fluid px-4 my-auto h-100">
                    <div class="row no-gutters h-100">
                        <div class="col-lg-3 col-md-5 auth-form mx-auto my-auto">
                            <div class="card">
                                <div class="card-body">
                                    <img class="auth-form__logo d-table mx-auto mb-3" src="<?= base_url('assets/images/shards-dashboards-logo.svg') ?>" alt="Shards Dashboards - Register Template">
                                    <h5 class="auth-form__title text-center mb-4">Silahkan masuk untuk mendapatkan layanan Poliklinik DPD RI</h5>

                                    <?php if (session()->get('info')) : ?>
                                        <?php $warning = session()->getFlashdata('info') ?>
                                        <div class="alert <?= $warning['class'] ?>" role="alert">
                                            <div class="mb-3">
                                                <i class="far <?= $warning['icon'] ?>"></i>
                                                <span class="alert-heading mx-2">Pemberitahuan</span>
                                            </div>
                                            <span>
                                                <?= $warning['message'] ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>

                                    <?= form_open('auth/verifying', array('autocomplate' => 'off')) ?>
                                    <?= csrf_field() ?>
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" name="f_username" class="form-control" placeholder="Masukkan username ...">
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" name="f_password" class="form-control" placeholder="Masukkan password ...">
                                    </div>
                                    <input type="submit" name="f_submit" value="Login" class="btn btn-pill btn-accent d-table mx-auto">
                                    <?= form_close() ?>

                                </div>
                            </div>

                            <!-- <div class="auth-form__meta d-flex mt-4">
                                <a href="<?= base_url('auth/forgot_password') ?>">Forgot your password?</a>
                                 <a class="ml-auto" href="<?= base_url('auth/register') ?>">Create new account?</a>
                            </div> -->

                        </div>
                    </div>
                </div>
            </main>
        </div>

    </div>
</body>

</html>