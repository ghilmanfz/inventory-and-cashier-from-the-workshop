<?php

session_start();
if (!empty($_SESSION['admin'])) {
    require '../../config.php';
    if (!empty($_GET['kategori'])) {
        $nama= htmlentities(htmlentities($_POST['kategori']));
        $tgl= date("j F Y, G:i");
        $data[] = $nama;
        $data[] = $tgl;
        $sql = 'INSERT INTO kategori (nama_kategori,tgl_input) VALUES(?,?)';
        $row = $config -> prepare($sql);
        $row -> execute($data);
        echo '<script>window.location="../../index.php?page=kategori&&success=tambah-data"</script>';
    }

    if (!empty($_GET['barang'])) {
        $id = htmlentities($_POST['id']);
        $kategori = htmlentities($_POST['kategori']);
        $nama = htmlentities($_POST['nama']);
        $merk = htmlentities($_POST['merk']);
        $beli = htmlentities($_POST['beli']);
        $jual = htmlentities($_POST['jual']);
        $satuan = htmlentities($_POST['satuan']);
        $stok = htmlentities($_POST['stok']);
        $tgl = htmlentities($_POST['tgl']);

        $data[] = $id;
        $data[] = $kategori;
        $data[] = $nama;
        $data[] = $merk;
        $data[] = $beli;
        $data[] = $jual;
        $data[] = $satuan;
        $data[] = $stok;
        $data[] = $tgl;
        $sql = 'INSERT INTO barang (id_barang,id_kategori,nama_barang,merk,harga_beli,harga_jual,satuan_barang,stok,tgl_input) 
			    VALUES (?,?,?,?,?,?,?,?,?) ';
        $row = $config -> prepare($sql);
        $row -> execute($data);
        echo '<script>window.location="../../index.php?page=barang&success=tambah-data"</script>';
    }
    
    if (!empty($_GET['jual'])) {
        $id = $_GET['id'];

        // get tabel barang id_barang
        $sql = 'SELECT * FROM barang WHERE id_barang = ?';
        $row = $config->prepare($sql);
        $row->execute(array($id));
        $hsl = $row->fetch();

        if ($hsl['stok'] > 0) {
            $kasir =  $_GET['id_kasir'];
            $jumlah = 1;
            $total = $hsl['harga_jual'];
            $tgl = date("j F Y, G:i");

            $data1[] = $id;
            $data1[] = $kasir;
            $data1[] = $jumlah;
            $data1[] = $total;
            $data1[] = $tgl;

            $sql1 = 'INSERT INTO penjualan (id_barang,id_member,jumlah,total,tanggal_input) VALUES (?,?,?,?,?)';
            $row1 = $config -> prepare($sql1);
            $row1 -> execute($data1);

            echo '<script>window.location="../../index.php?page=jual&success=tambah-data"</script>';
        } else {
            echo '<script>alert("Stok Barang Anda Telah Habis !");
					window.location="../../index.php?page=jual#keranjang"</script>';
        }
    }
}
if (!empty($_SESSION['admin'])) {
    require '../../config.php';

    if (isset($_GET['user']) && $_GET['user'] == 'tambah') {
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        $id_member = $_POST['id_member'];
        $jabatan = $_POST['jabatan'];

        // Cek apakah username sudah dipakai
        $cek = $config->prepare("SELECT * FROM login WHERE user = ?");
        $cek->execute([$username]);
        $hasil = $cek->fetch();

        if ($hasil) {
            // Username sudah digunakan
            echo '<script>window.location="../../index.php?page=user&gagal=tambah";</script>';
        } else {
            // Tambah user baru
            $stmt = $config->prepare("INSERT INTO login (user, pass, id_member, jabatan) VALUES (?, ?, ?, ?)");
            $stmt->execute([$username, $password, $id_member, $jabatan]);

            echo '<script>window.location="../../index.php?page=user&success=tambah";</script>';
        }
    }
}
if (isset($_GET['barang']) && $_GET['barang'] == 'jual') {
    $id_barang = $_POST['id'];
    $jumlah = $_POST['jumlah'];
    // Lanjutkan simpan ke keranjang / session / DB
}

if (isset($_GET['supplier']) && $_GET['supplier'] === 'tambah') {
  $nama   = htmlentities($_POST['nama']);
  $no_wa  = htmlentities($_POST['no_wa']);
  $alamat = htmlentities($_POST['alamat']);

  $stmt = $config->prepare("INSERT INTO supplier (nama, no_wa, alamat) VALUES (?, ?, ?)");
  $success = $stmt->execute([$nama, $no_wa, $alamat]);

  if ($success) {
    header("Location: ../../index.php?page=supplier&success=tambah");
    exit;
  } else {
    echo "Gagal menambah supplier";
  }
}


