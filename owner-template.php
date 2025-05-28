<?php
@ob_start();
session_start();

if (empty($_SESSION['admin']) || $_SESSION['role'] != 'owner') {
    echo '<script>window.location="login.php";</script>';
    exit;
}

require 'config.php';
include 'config/view.php';
$lihat = new view($config);
$toko = $lihat->toko();

$page = isset($_GET['page']) ? $_GET['page'] : 'laporan';
$modulePath = "admin/module/{$page}/index.php";
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>POS Owner</title>
  <link href="sb-admin/css/sb-admin-2.min.css" rel="stylesheet">
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background: #fff;
    }
    .navbar {
      padding: 1rem;
      background: #28a745;
      color: white;
    }
    .navbar a.btn {
      color: white;
      margin-right: 10px;
    }
  </style>
</head>
<body>
  <div class="navbar d-flex justify-content-between align-items-center">
    <div>
      <strong>POS Owner - Laporan Penjualan</strong>
    </div>
    <div>
      <a href="logout.php" class="btn btn-sm btn-danger" onclick="return confirm('Logout sekarang?')">
        <i class="fa fa-sign-out-alt"></i> Logout
      </a>
    </div>
  </div>

  <div class="container-fluid mt-4">
    <?php
      if (file_exists($modulePath)) {
        include $modulePath;
      } else {
        echo "<div class='alert alert-danger'>Halaman tidak ditemukan: <strong>{$modulePath}</strong></div>";
      }
    ?>
  </div>
</body>
</html>
