<?php
include '../../config.php';

// Simpan PO dan detail
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buat_po'])) {
    $supplier_id = $_POST['supplier_id'];
    $tanggal = date('Y-m-d');

    $stmt = $config->prepare("INSERT INTO po (supplier_id, tanggal) VALUES (?, ?)");
    $stmt->execute([$supplier_id, $tanggal]);
    $po_id = $config->lastInsertId();

    foreach ($_POST['barang'] as $item) {
        $stmt = $config->prepare("INSERT INTO po_detail (po_id, nama_barang, jumlah, harga_satuan) VALUES (?, ?, ?, ?)");
        $stmt->execute([$po_id, $item['nama'], $item['jumlah'], $item['harga']]);
    }

    header("Location: cetak_po.php?id=$po_id");
    exit;
}

// Ambil supplier
$suppliers = $config->query("SELECT * FROM supplier")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Tambah PO Barang</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
  <h4 class="mb-3">Buat Purchase Order (PO) Barang</h4>

  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Supplier</label>
      <select name="supplier_id" class="form-select" required>
        <option value="">-- Pilih Supplier --</option>
        <?php foreach ($suppliers as $s): ?>
          <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['nama']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <table class="table table-bordered" id="daftarBarang">
      <thead class="table-dark">
        <tr>
          <th>Nama Barang</th>
          <th>Jumlah</th>
          <th>Harga Satuan</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>

    <button type="button" class="btn btn-secondary mb-3" onclick="tambahBarang()">
      <i class="fa fa-plus"></i> Tambah Barang
    </button>

    <div class="mb-3">
      <button type="submit" name="buat_po" class="btn btn-primary">
        <i class="fa fa-save"></i> Simpan & Cetak PO
      </button>
    </div>
  </form>
</div>

<!-- Script -->
<script>
function tambahBarang() {
  const row = document.createElement('tr');
  row.innerHTML = `
    <td><input type="text" name="barang[][nama]" class="form-control" required></td>
    <td><input type="number" name="barang[][jumlah]" class="form-control" min="1" required></td>
    <td><input type="number" name="barang[][harga]" class="form-control" step="0.01" required></td>
    <td><button type="button" class="btn btn-danger btn-sm" onclick="hapusBarang(this)"><i class="fa fa-trash"></i></button></td>
  `;
  document.querySelector('#daftarBarang tbody').appendChild(row);
}

function hapusBarang(button) {
  button.closest('tr').remove();
}
</script>

<!-- Bootstrap Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
