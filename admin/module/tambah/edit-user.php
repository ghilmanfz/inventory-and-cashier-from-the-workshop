<?php
$id = $_GET['id'];
$user = $config->prepare("SELECT * FROM login WHERE id_login = ?");
$user->execute([$id]);
$data = $user->fetch();
?>

<h4><i class="fa fa-edit"></i> Edit User</h4>
<hr>

<form method="POST" action="fungsi/edit/edit.php?user=edit">
    <input type="hidden" name="id_login" value="<?= $data['id_login']; ?>">

    <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" required class="form-control" value="<?= $data['user']; ?>">
    </div>
    <div class="form-group">
        <label>Password Baru (kosongkan jika tidak diubah)</label>
        <input type="password" name="password" class="form-control" placeholder="Password Baru">
    </div>
    <div class="form-group">
        <label>ID Member</label>
        <input type="number" name="id_member" required class="form-control" value="<?= $data['id_member']; ?>">
    </div>
    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    <a href="index.php?page=tambah" class="btn btn-secondary">Kembali</a>
</form>
