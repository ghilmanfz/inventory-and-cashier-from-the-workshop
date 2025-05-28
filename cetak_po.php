<?php
include 'config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID PO tidak valid.");
}

$po_id = $_GET['id'];

$stmt = $config->prepare("SELECT po.*, supplier.nama AS nama_supplier FROM po 
                          JOIN supplier ON po.supplier_id = supplier.id 
                          WHERE po.id = ?");
$stmt->execute([$po_id]);
$po = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$po) {
    die("PO tidak ditemukan.");
}

$detail_stmt = $config->prepare("SELECT * FROM po_detail WHERE po_id = ?");
$detail_stmt->execute([$po_id]);
$items = $detail_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Cetak PO #<?= $po_id ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    @media print {
      .no-print { display: none; }
    }
    body {
      font-size: 14px;
    }
    .table th, .table td {
      vertical-align: middle;
    }
  </style>
</head>
<body>

<div class="container mt-4">

  <div class="d-flex justify-content-between align-items-center no-print mb-4">
    <h4 class="mb-0">Purchase Order (PO)</h4>
    <div>
      <a href="javascript:window.print()" class="btn btn-success me-2">
        🖨️ Cetak
      </a>
      <a href="index.php?page=po" class="btn btn-secondary">← Kembali</a>
    </div>
  </div>

  <table class="table table-bordered w-100">
    <tbody>
      <tr>
        <th style="width: 20%;">No. PO</th>
        <td>#<?= $po['id'] ?></td>
      </tr>
      <tr>
        <th>Tanggal</th>
        <td><?= date('d-m-Y', strtotime($po['tanggal'])) ?></td>
      </tr>
      <tr>
        <th>Supplier</th>
        <td><?= htmlspecialchars($po['nama_supplier']) ?></td>
      </tr>
      <tr>
        <th>Status</th>
        <td><?= strtoupper($po['status']) ?></td>
      </tr>
    </tbody>
  </table>

  <h5 class="mt-4 mb-3">Detail Barang</h5>

  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr class="text-center">
        <th style="width: 5%;">No</th>
        <th>Nama Barang</th>
        <th style="width: 10%;">Jumlah</th>
        <th style="width: 15%;">Harga Satuan</th>
        <th style="width: 15%;">Subtotal</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      $total = 0;
      foreach ($items as $i => $item):
        $subtotal = $item['jumlah'] * $item['harga_satuan'];
        $total += $subtotal;
      ?>
      <tr>
        <td class="text-center"><?= $i + 1 ?></td>
        <td><?= htmlspecialchars($item['nama_barang']) ?></td>
        <td class="text-center"><?= $item['jumlah'] ?></td>
        <td class="text-end">Rp<?= number_format($item['harga_satuan'], 0, ',', '.') ?></td>
        <td class="text-end">Rp<?= number_format($subtotal, 0, ',', '.') ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="4" class="text-end">Grand Total</th>
        <th class="text-end">Rp<?= number_format($total, 0, ',', '.') ?></th>
      </tr>
    </tfoot>
  </table>

</div>

</body>
</html>
