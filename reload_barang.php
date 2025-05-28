<?php
include 'config.php';
$query = $config->prepare("SELECT * FROM barang WHERE stok > 0");
$query->execute();
$dataBarang = $query->fetchAll();

foreach ($dataBarang as $barang): ?>
  <div class="col-md-3 mb-3">
    <div class="card bg-light" style="cursor:pointer;"
         onclick="tambahKeKeranjang('<?= $barang['id_barang'] ?>', '<?= htmlspecialchars($barang['nama_barang']) ?>', <?= $barang['harga_jual'] ?>)">
      <div class="card-body p-2">
        <h6><?= htmlspecialchars($barang['nama_barang']) ?></h6>
        <small>Kode: <?= $barang['kode_barang'] ?></small><br>
        <small>Stok: <?= $barang['stok'] ?></small><br>
        <strong>Rp <?= number_format($barang['harga_jual']) ?></strong>
      </div>
    </div>
  </div>
<?php endforeach; ?>
