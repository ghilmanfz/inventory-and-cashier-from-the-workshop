<h4><i class="fa fa-user"></i> Manajemen User</h4>
<hr>

<!-- Tombol Tambah -->
<button type="button" class="btn btn-primary btn-md mb-3" data-toggle="modal" data-target="#modalUser">
    <i class="fa fa-user-plus"></i> Tambah User
</button>

<!-- Modal Tambah -->
<div id="modalUser" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title"><i class="fa fa-user-plus"></i> Tambah User</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form action="fungsi/tambah/tambah.php?user=tambah" method="POST">
        <div class="modal-body">
          <table class="table">
            <tr>
              <td>Username</td>
              <td><input type="text" name="username" required class="form-control"></td>
            </tr>
            <tr>
              <td>Password</td>
              <td><input type="password" name="password" required class="form-control"></td>
            </tr>
            <tr>
              <td>ID Member</td>
              <td><input type="number" name="id_member" required class="form-control"></td>
            </tr>
            <tr>
              <td>Jabatan</td>
              <td>
                <select name="jabatan" class="form-control" required>
                  <option value="">-- Pilih Jabatan --</option>
                  <option value="admin">Admin</option>
                  <option value="kasir">Kasir</option>
                  <option value="owner">Owner</option>
                </select>
              </td>
            </tr>
          </table>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Insert</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit User -->
<div id="modalEditUser" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-warning text-white">
        <h5 class="modal-title"><i class="fa fa-edit"></i> Edit User</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form action="fungsi/edit/edit.php?user=edit" method="POST">
        <div class="modal-body">
          <input type="hidden" name="id_login" id="edit_id_login">
          <table class="table">
            <tr>
              <td>Username</td>
              <td><input type="text" name="username" id="edit_username" class="form-control"></td>
            </tr>
            <tr>
              <td>Password</td>
              <td><input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah"></td>
            </tr>
            <tr>
              <td>ID Member</td>
              <td><input type="number" name="id_member" id="edit_id_member" class="form-control"></td>
            </tr>
            <tr>
              <td>Jabatan</td>
              <td>
                <select name="jabatan" id="edit_jabatan" class="form-control">
                  <option value="">-- Pilih Jabatan --</option>
                  <option value="admin">Admin</option>
                  <option value="kasir">Kasir</option>
                  <option value="owner">Owner</option>
                </select>
              </td>
            </tr>
          </table>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-warning">Simpan</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Daftar User -->
<div class="card card-body">
  <table class="table table-bordered table-striped table-sm">
    <thead>
      <tr style="background:#eee;">
        <th>No</th>
        <th>Username</th>
        <th>ID Member</th>
        <th>Jabatan</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $no = 1;
        $userList = $config->prepare("SELECT * FROM login ORDER BY id_login DESC");
        $userList->execute();
        foreach ($userList as $user) {
      ?>
      <tr>
        <td><?= $no++; ?></td>
        <td><?= htmlspecialchars($user['user']); ?></td>
        <td><?= $user['id_member']; ?></td>
        <td><?= htmlspecialchars($user['jabatan']); ?></td>
        <td>
          <button class="btn btn-warning btn-sm btn-edit"
                  data-id="<?= $user['id_login']; ?>"
                  data-username="<?= $user['user']; ?>"
                  data-id_member="<?= $user['id_member']; ?>"
                  data-jabatan="<?= $user['jabatan']; ?>"
                  data-toggle="modal" data-target="#modalEditUser">
            <i class="fa fa-edit"></i> Edit
          </button>
          <a href="fungsi/hapus/hapus.php?user=hapus&id=<?= $user['id_login']; ?>"
             onclick="return confirm('Yakin ingin menghapus user ini?')"
             class="btn btn-danger btn-sm">
            <i class="fa fa-trash"></i> Hapus
          </a>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<!-- JavaScript: isi modal edit -->
<script>
$(document).ready(function(){
  $('.btn-edit').click(function(){
    $('#edit_id_login').val($(this).data('id'));
    $('#edit_username').val($(this).data('username'));
    $('#edit_id_member').val($(this).data('id_member'));
    $('#edit_jabatan').val($(this).data('jabatan'));
  });
});
</script>
