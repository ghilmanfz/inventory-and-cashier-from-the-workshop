<?php
@ob_start();
session_start();

if (!isset($_SESSION['admin'])) {
    echo '<script>window.location="login.php";</script>';
    exit;
}

require 'config.php';
include $view;
$lihat = new view($config);
$toko = $lihat->toko();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari POST
    $nama = htmlentities($_POST['nama_pelanggan']);
    $noPlat = htmlentities($_POST['no_plat']);
    $bayar = (int) $_POST['bayar'];
    $kembali = (int) $_POST['kembali'];
    $keranjangData = json_decode($_POST['keranjangData'], true);

    $id_member = $_SESSION['id_member'] ?? 0;
    $tanggal = date('Y-m-d H:i:s');
    $periode = date('Y-m');

    // Simpan ke tabel nota dan update stok
    foreach ($keranjangData as $id_barang => $item) {
        $jumlah = $item['jumlah'];
        $total = $item['harga'] * $jumlah;

        // Simpan nota
       $kasir = $_SESSION['username'] ?? 'unknown';

$stmt = $config->prepare("
    INSERT INTO nota (id_barang, id_member, kasir, jumlah, total, tanggal_input, periode)
    VALUES (?, ?, ?, ?, ?, ?, ?)
");
$stmt->execute([$id_barang, $id_member, $kasir, $jumlah, $total, $tanggal, $periode]);


        // Update stok
        $updateStok = $config->prepare("UPDATE barang SET stok = stok - ? WHERE id_barang = ?");
        $updateStok->execute([$jumlah, $id_barang]);
    }

    // Tampilkan struk HTML
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Struk Transaksi</title>
        <link rel="stylesheet" href="assets/css/bootstrap.css">
        <style>
            body { font-size: 14px; }
            .container { margin-top: 20px; }
            table th, table td { font-size: 13px; }
        </style>
    </head>
    <body onload="window.print();">
        <div class="container">
            <div class="text-center">
                <h5><strong><?= htmlentities($toko['nama_toko']) ?></strong></h5>
                <p><?= htmlentities($toko['alamat_toko']) ?></p>
                <p><?= date("j F Y, G:i") ?></p>
                <p>Kasir: <?= htmlentities($_SESSION['username']) ?></p>
                <p>Pelanggan: <?= $nama ?></p>
                <p>No. Plat: <?= $noPlat ?></p>
            </div>

            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; $grandTotal = 0; ?>
                    <?php foreach ($keranjangData as $item): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlentities($item['nama']) ?></td>
                            <td><?= $item['jumlah'] ?></td>
                            <td>Rp <?= number_format($item['harga'] * $item['jumlah']) ?></td>
                        </tr>
                        <?php $grandTotal += $item['harga'] * $item['jumlah']; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="text-end">
                <p><strong>Total :</strong> Rp <?= number_format($grandTotal) ?></p>
                <p><strong>Bayar :</strong> Rp <?= number_format($bayar) ?></p>
                <p><strong>Kembali :</strong> Rp <?= number_format($kembali) ?></p>
            </div>

            <div class="text-center mt-3">
                <p>Terima kasih telah berbelanja di toko kami!</p>
            </div>
        </div>
    </body>
    </html>
    <?php
}
?>
