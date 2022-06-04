<?php

function jamPulang($date, $checkout)
{
  if ($checkout == null) {
    $data = "Belum Checkout";
    return $data;
  }
  date_default_timezone_set("Asia/Jakarta");

  $date = $date;
  $jampulang = "17:00:00";
  $merge1 = $date . ' ' . $jampulang;
  $merge2 = $date . ' ' . $checkout;

  $waktu_awal = strtotime($merge1);
  $waktu_akhir = strtotime($merge2);

  $diff    = $waktu_awal - $waktu_akhir;
 
  $menit = floor($diff / (60));

  if ($menit <= 0) {
    $menit = 0;
  } else {
    $menit;
  }
  echo $menit . ' Menit' . PHP_EOL;
}

function jamMasuk($date, $checkout)
{
  date_default_timezone_set("Asia/Jakarta");

  $date = $date;
  $jammasuk = "08:00:00";
  $merge1 = $date . ' ' . $jammasuk;
  $merge2 = $date . ' ' . $checkout;

  $waktu_awal = strtotime($merge1);
  $waktu_akhir = strtotime($merge2);

  $diff    = $waktu_awal - $waktu_akhir;
 
  $menit = floor($diff / (60));

  if ($menit <= 0) {
    $menit *= -1;
  } else {
    $menit = 0;
  }

  echo $menit . ' Menit' . PHP_EOL;
}

function lamaLembur($date, $checkout)
{
  date_default_timezone_set("Asia/Jakarta");

  $date = $date;
  $jampulang = "17:00:00";
  $merge1 = $date . ' ' . $jampulang;
  $merge2 = $date . ' ' . $checkout;

  $waktu_awal = strtotime($merge1);
  $waktu_akhir = strtotime($merge2);

  $diff    = $waktu_awal - $waktu_akhir;
 
  $menit = floor($diff / (60));

  if ($menit <= 0) {
    $menit *= -1;
  } else {
    $menit = 0;
  }
  echo $menit . ' Menit';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
    <?= $model['title'] ?>
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

<body class="">
  <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
      <!-- Toggler -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Brand -->
      <a class="navbar-brand pt-0" href="../index.html">
        <h1>Absensi</h1>
      </a>
      <!-- User -->
      <ul class="nav align-items-center d-md-none">
        <li class="nav-item dropdown">
          <a class="nav-link nav-link-icon" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ni ni-bell-55"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right" aria-labelledby="navbar-default_dropdown_1">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="media align-items-center">
              <span class="avatar avatar-sm rounded-circle">
                <img alt="Image placeholder" src="../assets/img/theme/team-1-800x800.jpg
">
              </span>
            </div>
          </a>
          <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
            <div class=" dropdown-header noti-title">
              <h6 class="text-overflow m-0">Welcome!</h6>
            </div>
            <a href="#!" class="dropdown-item">
              <i class="ni ni-user-run"></i>
              <span>Logout</span>
            </a>
          </div>
        </li>
      </ul>
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Collapse header -->
        <!-- Navigation -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link " href="/employees/admin">
              <i class="ni ni-tv-2 text-primary"></i> Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/employees/admin/register">
              <i class="ni ni-circle-08 text-pink"></i> Register
            </a>
          </li>
        </ul>
        <!-- Navigation -->
      </div>
    </div>
  </nav>
  <div class="main-content">
    <!-- Navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
      <div class="container-fluid">
        <!-- Brand -->
        <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="../index.html">Aplikasi absensi terpadu</a>
        
        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">
          <li class="nav-item dropdown">
            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="media align-items-center">
                <span class="avatar avatar-sm rounded-circle">
                  <img alt="Image placeholder" src="../assets/img/theme/team-4-800x800.jpg">
                </span>
                <div class="media-body ml-2 d-none d-lg-block">
                  <span class="mb-0 text-sm  font-weight-bold"><?= $model['employee']['name'] ?></span>
                </div>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
              <div class=" dropdown-header noti-title">
                <h6 class="text-overflow m-0">Welcome!</h6>
              </div>
              <a href="/employees/logout" class="dropdown-item">
                <i class="ni ni-user-run"></i>
                <span>Logout</span>
              </a>
            </div>
          </li>
        </ul>
      </div>
    </nav>
    <!-- End Navbar -->
    <!-- Header -->
    <div class="header bg-gradient-primary pb-6 pt-5 pt-md-8"></div>
    <div class="container-fluid mt--7">
      <!-- Table -->
      <div class="row"></div>
      <!-- Dark table -->
      <div class="row mt-2">
        <div class="col">
          <div class="card bg-default shadow">
            <div class="card-header bg-transparent border-0">
              <h3 class="text-white mb-0">Data Absensi Karyawan</h3>
            </div>
            <div class="table-responsive">
              <table class="table align-items-center table-dark table-flush">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">NIK</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Jam Masuk</th>
                    <th scope="col">Jam Keluar</th>
                    <th scope="col">Telat</th>
                    <th scope="col">Pulang Cepat</th>
                    <th scope="col">Lembur</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($model['presents'] as $present) { ?>
                  <tr>
                    <td><?= $present->employeeId ?></td>
                    <td><?= $present->date ?></td>
                    <td><?= $present->checkin ?></td>
                    <td><?= $present->checkout ?></td>
                    <td><?php jamMasuk($present->date, $present->checkin) ?> </td>
                    <td><?php jamPulang($present->date, $present->checkout) ?> </td>
                    <td><?php lamaLembur($present->date, $present->checkout) ?> </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--   Core   -->
  <script src="../assets/js/plugins/jquery/dist/jquery.min.js"></script>
  <script src="../assets/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!--   Optional JS   -->
  <!--   Argon JS   -->
  <script src="../assets/js/argon-dashboard.min.js?v=1.1.2"></script>
  <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
  <script>
    window.TrackJS &&
      TrackJS.install({
        token: "ee6fab19c5a04ac1a32a645abde4613a",
        application: "argon-dashboard-free"
      });
  </script>
</body>

</html>