<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Data Supplier</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>

<?php include '../../config.php'; ?>

<div class="container mt-4">

  <!-- Notifikasi -->
  <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">
      <?= $_GET['success'] === 'supplier' ? "✅ Supplier berhasil ditambahkan!" : ($_GET['success'] === 'edit' ? "✏️ Supplier berhasil diedit!" : ($_GET['success'] === 'hapus' ? "🗑️ Supplier berhasil dihapus!" : "✅ Berhasil!")) ?>
    </div>
  <?php endif; ?>

  <!-- Form Tambah -->
  <h4 class="mb-3">Tambah Supplier Baru</h4>
  <form action="fungsi/tambah/tambah.php?supplier=tambah" method="POST" class="row g-3 mb-5">
    <div class="col-md-4">
      <label class="form-label">Nama</label>
      <input type="text" name="nama" class="form-control" required>
    </div>
    <div class="col-md-4">
      <label class="form-label">No. WA</label>
      <input type="text" name="no_wa" class="form-control">
    </div>
    <div class="col-md-4">
      <label class="form-label">Alamat</label>
      <input type="text" name="alamat" class="form-control">
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-primary">
        <i class="fa fa-save"></i> Simpan Supplier
      </button>
    </div>
  </form>

  <!-- Tabel Supplier -->
  <h4>Data Supplier</h4>
  <div class="table-responsive">
    <table class="table table-bordered table-striped table-sm">
      <thead class="table-dark">
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>No. WA</th>
          <th>Alamat</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $stmt = $config->prepare("SELECT * FROM supplier");
        $stmt->execute();
        $jumlah = $stmt->rowCount();
        $no = 1;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
        ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= htmlspecialchars($row['nama']) ?></td>
          <td>
  <a href="https://api.whatsapp.com/send?phone=<?= preg_replace('/[^0-9]/', '', $row['no_wa']) ?>&text=Halo%20saya%20ingin%20bertanya%20mengenai%20produk" 
     target="_blank" 
     class="text-success text-decoration-none">
    <i class="fa fa-whatsapp"></i> <?= htmlspecialchars($row['no_wa']) ?>
  </a>
</td>

          <td><?= htmlspecialchars($row['alamat']) ?></td>
          <td>
            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id'] ?>">
              <i class="fa fa-edit"></i>
            </button>
            <a href="fungsi/hapus/hapus.php?supplier=hapus&id=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin dihapus?')" class="btn btn-danger btn-sm">
              <i class="fa fa-trash"></i>
            </a>
          </td>
        </tr>

        <!-- Modal Edit -->
        <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $row['id'] ?>" aria-hidden="true">
          <div class="modal-dialog">
            <form action="fungsi/edit/edit.php?supplier=edit" method="POST">
              <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                  <h5 class="modal-title" id="editModalLabel<?= $row['id'] ?>">Edit Supplier</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <input type="hidden" name="id" value="<?= $row['id'] ?>">
                  <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($row['nama']) ?>" required>
                  </div>
                  <div class="mb-3">
                    <label>No. WA</label>
                    <input type="text" name="no_wa" class="form-control" value="<?= htmlspecialchars($row['no_wa']) ?>">
                  </div>
                  <div class="mb-3">
                    <label>Alamat</label>
                    <input type="text" name="alamat" class="form-control" value="<?= htmlspecialchars($row['alamat']) ?>">
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
              </div>
            </form>
          </div>
        </div>

        <?php endwhile; ?>
      </tbody>
      <tfoot>
        <tr>
          <th colspan="4">Total Supplier</th>
          <th><?= $jumlah ?></th>
        </tr>
      </tfoot>
    </table>
  </div>
</div>

<!-- JS Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
