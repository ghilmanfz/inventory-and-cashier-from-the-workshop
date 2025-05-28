<?php
@ob_start();
session_start();

if (isset($_POST['proses'])) {
	require 'config.php';

	$user = strip_tags($_POST['user']);
	$pass = strip_tags($_POST['pass']);

	$sql = 'SELECT member.*, login.user, login.pass, login.jabatan
			FROM member
			INNER JOIN login ON member.id_member = login.id_member
			WHERE login.user = ? AND login.pass = md5(?)';
	$row = $config->prepare($sql);
	$row->execute([$user, $pass]);
	$jum = $row->rowCount();

	if ($jum > 0) {
		$hasil = $row->fetch();
		$_SESSION['admin'] = $hasil;
		$_SESSION['username'] = $hasil['user'];
		$_SESSION['jabatan'] = $hasil['jabatan'];

		if ($hasil['jabatan'] == 'admin') {
			$_SESSION['role'] = 'admin';
			echo '<script>alert("Login Sukses - Admin"); window.location="index.php";</script>';
		} elseif ($hasil['jabatan'] == 'kasir') {
			$_SESSION['role'] = 'kasir';
			echo '<script>alert("Login Sukses - Kasir"); window.location="index.php?page=jual";</script>';
		} elseif ($hasil['jabatan'] == 'owner') {
			$_SESSION['role'] = 'owner';
			echo '<script>alert("Login Sukses - Owner"); window.location="index.php?page=laporan";</script>';
		} else {
			echo '<script>alert("Login Gagal - Jabatan tidak dikenali"); history.go(-1);</script>';
		}
	} else {
		echo '<script>alert("Login Gagal! Username atau Password salah."); history.go(-1);</script>';
	}
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Login</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="sb-admin/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">
    <div class="container">
<div class="sidebar-brand-icon">
        
    </div>
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-md-5 mt-5">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
						
                        <!-- Nested Row within Card Body -->
						<div class="p-5">
							<div class="text-center">
								<img src="assets/img/ajg.jp" alt="Logo" style="width: 100px; height: 100px; top: 200px">
								<h>nanti di sini ada logo</h>
							</div>
							<form class="form-login" method="POST">
								<div class="form-group">
									<input type="text" class="form-control form-control-user" name="user"
										placeholder="User ID" autofocus>
								</div>
								<div class="form-group">
									<input type="password" class="form-control form-control-user" name="pass"
										placeholder="Password">
								</div>
								<button class="btn btn-primary btn-block" name="proses" type="submit"><i
										class="fa fa-lock"></i>
									SIGN IN</button>
							</form>
							<!-- <hr>
							<div class="text-center">
								<a class="small" href="forgot-password.html">Forgot Password?</a>
							</div>
							<div class="text-center">
								<a class="small" href="register.html">Create an Account!</a>
							</div> -->
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="sb-admin/vendor/jquery/jquery.min.js"></script>
    <script src="sb-admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="sb-admin/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="sb-admin/js/sb-admin-2.min.js"></script>
</body>
</html>