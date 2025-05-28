<?php
// Aktifkan error untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Jalankan session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'config.php'; // koneksi PDO dalam $config

// Cek jika form dikirim
if (isset($_POST['reset_password'])) {
  $username   = $_SESSION['username'];
  $password   = $_POST['password_baru'];
  $konfirmasi = $_POST['konfirmasi_password'];

  if ($password !== $konfirmasi) {
    echo "<script>alert('Password tidak cocok!'); window.location.href='index.php?page=jual';</script>";
    exit;
  }

  $password_md5 = md5($password); // sesuai struktur tabel login (char(32))

  $sql = "UPDATE login SET pass=? WHERE user=?";
  $stmt = $config->prepare($sql);
  $stmt->execute([$password_md5, $username]);

  if ($stmt->rowCount() > 0) {
    echo "<script>alert('Password berhasil direset!'); window.location.href='index.php?page=jual';</script>";
  } else {
    echo "<script>alert('Password tidak berubah. Mungkin sama seperti sebelumnya.'); window.location.href='index.php?page=jual';</script>";
  }
}
?>


<!DOCTYPE html>
<html>
<head>
  <title>POS Kasir <?php echo $_SESSION['username']; ?></title>
  <link href="sb-admin/css/sb-admin-2.min.css" rel="stylesheet">
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-white">
  <!-- Navbar -->
  <div class="navbar d-flex justify-content-between align-items-center p-3 bg-light">
    <div>
      <strong>POS Kasir - <?= strtoupper($_GET['page'] ?? 'DASHBOARD') ?></strong>
    </div>
    <text>SELAMAT DATANG <?php echo $_SESSION['username']; ?></text>
    <div>
      <?php $page = $_GET['page'] ?? ''; ?>
      <?php if ($page !== 'jual') : ?>
        <a href="index.php?page=jual" class="btn btn-sm btn-light">
          <i class="fa fa-shopping-cart"></i> Transaksi
        </a>
      <?php endif; ?>
      <?php if ($page !== 'laporan') : ?>
        <a href="index.php?page=laporan" class="btn btn-sm btn-light">
          <i class="fa fa-chart-bar"></i> Laporan
        </a>
      <?php endif; ?>
      <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#resetPasswordModal">
        <i class="fa fa-key"></i> Reset Password
      </button>

      <a href="logout.php" class="btn btn-sm btn-danger" onclick="return confirm('Logout sekarang?')">
        <i class="fa fa-sign-out-alt"></i> Logout
      </a>
    </div>
  </div>

  <!-- Konten Dinamis -->
  <div class="container mt-4">
    <?php
    if (isset($_GET['page'])) {
      include 'admin/module/' . $_GET['page'] . '/index.php';
    } else {
      echo "<h4>Selamat datang di POS Kasir</h4>";
    }
    ?>
  </div>

  <!-- Modal Reset Password -->
  <div class="modal fade" id="resetPasswordModal" tabindex="-1" role="dialog" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form method="POST" action="">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="resetPasswordModalLabel">Reset Password</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Password Baru</label>
              <input type="password" name="password_baru" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Konfirmasi Password</label>
              <input type="password" name="konfirmasi_password" class="form-control" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" name="reset_password" class="btn btn-warning">Simpan</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- JS Bootstrap dan jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
