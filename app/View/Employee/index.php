<?php
date_default_timezone_set("Asia/Jakarta");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        <?= $model['title'] ?? 'Aplikasi Absensi' ?>
    </title>
    <!-- Favicon -->
    <link href="../assets/img/brand/favicon.png" rel="icon" type="image/png">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Icons -->
    <link href="../assets/js/plugins/nucleo/css/nucleo.css" rel="stylesheet" />
    <link href="../assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link href="../assets/css/argon-dashboard.css?v=1.1.2" rel="stylesheet" />
</head>

<body class="bg-default">
    <div class="main-content">
        <nav class="navbar navbar-horizontal navbar-expand-lg navbar-dark bg-default">
            <div class="container">
                <a class="navbar-brand" href="#">KBInsurance</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-default" aria-controls="navbar-default" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbar-default">
                    <div class="navbar-collapse-header">
                        <div class="row">
                            <div class="col-6 collapse-brand">
                                <a href="javascript:void(0)">
                                    <img src="../../assets-old/img/brand/blue.png">
                                </a>
                            </div>
                            <div class="col-6 collapse-close">
                                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar-default" aria-controls="navbar-default" aria-expanded="false" aria-label="Toggle navigation">
                                    <span></span>
                                    <span></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <ul class="navbar-nav ml-lg-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-link-icon" href="#" id="navbar-default_dropdown_1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="ni ni-settings-gear-65"></i>
                                <span class="nav-link-inner--text d-lg-none">Settings</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-default_dropdown_1">
                                <a class="dropdown-item" href="/employees/logout">Logout</a>
                                <!-- <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a> -->
                            </div>
                        </li>
                    </ul>
                    
                </div>
            </div>
        </nav>

        <div class="header bg-gradient-primary py-6 py-lg-6">
            <div class="container">
                <div class="header-body text-center mb-7">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 col-md-6">
                            <h1 class="text-white">Hallo <?= $model['employee']['name'] ?></h1>
                            <p class="text-lead text-light">Selamat datang di Aplikasi Absensi.</p>
                            <p class="text-lead text-light">Tanggal Absen : <?= $model['present']->date ?? '' ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="separator separator-bottom separator-skew zindex-100">
                <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </div>

        <!-- Page content -->
        <div class="container mt--8 pb-5">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-7">
                    <div class="card bg-secondary shadow border-0">
                        <div class="card-body px-lg-4 py-lg-4">

                            <?php if(isset($model['error'])) { ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <span class="alert-text"><strong>Danger!</strong> <?= $model['error']; ?></span>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php } ?>
                            <?php if(!isset($model['present'])) { ?>
                                <form role="form" method="post" action="/presents/checkin">
                                    <div class="text-center">
                                    <h3 class="text-muted">Silahkan Absen</h3>
                                    <p><small class="text-muted">Jam Masuk 08:00 | Jam Pulang 17:00</small></p>    
                                    </div>
                                    <div class="text-center">
                                        <input hidden class="form-control" placeholder="Nik" type="text" name="nik" value="<?= $model['employee']['id'] ?>">
                                        <input hidden class="form-control" placeholder="Password" type="text" name="date" value="<?= $model['attr']['date'] ?>">
                                        <input hidden class="form-control" placeholder="Password" type="text" name="checkin" value="<?= $model['attr']['time'] ?>">
                                        <button type="submit" class="btn btn-primary my-2">Checkin</button>
                                    </div>
                                </form>
                            <?php } ?>
                            <?php if(isset($model['present']) && $model['present']->date = date('Y-m-d') && $model['present']->checkout == null) { ?>
                                <form role="form" method="post" action="/presents/checkout">
                                    <div class="text-center">
                                    <h3 class="text-muted">Anda sudah melakukan absen  </h3>
                                    <p>
                                        <small class="text-muted">Jam Absen : <?= $model['present']->checkin ?></small>
                                    </p>    
                                    </div>
                                    <div class="text-center">
                                        <input hidden class="form-control" placeholder="Nik" type="text" name="nik" value="<?= $model['employee']['id'] ?>">
                                        <input hidden class="form-control" placeholder="Password" type="text" name="date" value="<?= $model['attr']['date'] ?>">
                                        <input hidden class="form-control" placeholder="Password" type="text" name="checkout" value="<?= $model['attr']['time'] ?>">
                                        <button type="submit" class="btn btn-primary my-2">Checkout</button>
                                    </div>
                                </form>
                            <?php } ?>
                            <?php if(isset($model['present']) && $model['present']->date = date('Y-m-d') && $model['present']->checkin != null && $model['present']->checkout != null) { ?>
                                <form role="form" method="post" action="/presents/checkout">
                                    <div class="text-center">
                                    <h3 class="text-muted">Anda sudah melakukan checkin dan checkout  untuk hari ini  </h3>
                                    <p>
                                        <small class="text-muted">Terima kasih</small>
                                    </p>    
                                    </div>
                                </form>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="py-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-12">
                        <div class="copyright text-center text-xl-center text-muted">
                            © 2022 <a href="https://www.kbinsure.co.id/insurance/index.php/" class="font-weight-bold ml-1" target="_blank">Creative Tim</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!--   Core   -->
    <script src="../assets/js/plugins/jquery/dist/jquery.min.js"></script>
    <script src="../assets/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!--   Optional JS   -->
    <!--   Argon JS   -->
    <script src="../assets/js/argon-dashboard.min.js?v=1.1.2"></script>
    <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
    <!-- <script>
        window.TrackJS &&
            TrackJS.install({
                token: "ee6fab19c5a04ac1a32a645abde4613a",
                application: "argon-dashboard-free"
            });
    </script> -->
</body>

</html>