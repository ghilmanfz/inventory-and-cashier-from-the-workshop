<?php 
@ob_start();
session_start();

if (!empty($_SESSION['admin']) && !empty($_SESSION['role'])) {
	require 'config.php';
	include $view;
	$lihat = new view($config);
	$toko = $lihat->toko();

	$page = isset($_GET['page']) ? $_GET['page'] : '';
	$role = $_SESSION['role'];
	if ($role == 'kasir') {
		if ($page == '' || $page == 'jual' || $page == 'laporan') {
			if ($page == '') {
				echo '<script>window.location="index.php?page=jual";</script>';
				exit;
			} else {
				include 'kasir-tamplate.php';
				exit;
			}
		} else {
			echo '<script>alert("Akses ditolak! Kasir hanya dapat mengakses Transaksi dan Laporan."); window.location="index.php?page=jual";</script>';
			exit;
		}
	}
	if ($role == 'owner') {
		if ($page == '' || $page == 'laporan') {
			if ($page == '') {
				echo '<script>window.location="index.php?page=laporan";</script>';
				exit;
			} else {
				include 'owner-template.php';
				exit;
			}
		} else {
			echo '<script>alert("Akses ditolak! Owner hanya dapat mengakses Laporan."); window.location="index.php?page=laporan";</script>';
			exit;
		}
	}

	include 'admin/template/header.php';
	include 'admin/template/sidebar.php';

	if (!empty($page)) {
		include 'admin/module/' . $page . '/index.php';
	} else {
		include 'admin/template/home.php';
	}

	include 'admin/template/footer.php';

} else {
	echo '<script>window.location="login.php";</script>';
	exit;
}
