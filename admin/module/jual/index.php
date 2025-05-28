 <!--sidebar end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
<?php 
	$id = $_SESSION['admin']['id_member'];
	$hasil = $lihat -> member_edit($id);
?>
	<h4>Keranjang Penjualan</h4>
	<br>
	<?php if(isset($_GET['success'])){?>
	<div class="alert alert-success">
		<p>Edit Data Berhasil !</p>
	</div>
	<?php }?>
	<?php if(isset($_GET['remove'])){?>
	<div class="alert alert-danger">
		<p>Hapus Data Berhasil !</p>
	</div>
	<?php }?>
	<div class="row">
		<div class="col-sm-4">
			<div class="card card-primary mb-3">
				<div class="card-header bg-primary text-white">
					<h5><i class="fa fa-search"></i> Cari Barang</h5>
				</div>
				<div class="card-body">
					<input type="text" id="cari" class="form-control" name="cari" placeholder="Masukan : Kode / Nama Barang  [ENTER]">
				</div>
			</div>
		</div>
		<div class="col-sm-8">
			<div class="card card-primary mb-3">
				<div class="card-header bg-primary text-white">
					<h5><i class="fa fa-list"></i> Hasil Pencarian</h5>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<div id="hasil_cari"></div>
						<div id="tunggu"></div>
					</div>
				</div>
			</div>
		</div>
		

		<div class="col-sm-12">
			<div class="card card-primary">
				<div class="card-header bg-primary text-white">
					<h5><i class="fa fa-shopping-cart"></i> KASIR
					<a class="btn btn-danger float-right" 
						onclick="javascript:return confirm('Apakah anda ingin reset keranjang ?');" href="fungsi/hapus/hapus.php?penjualan=jual">
						<b>RESET KERANJANG</b></a>
					</h5>
				</div>
				<div class="card-body">
					<div id="keranjang" class="table-responsive">
						<table class="table table-bordered">
							<tr>
								<td><b>Tanggal</b></td>
								<td><input type="text" readonly="readonly" class="form-control" value="<?php echo date("j F Y, G:i");?>" name="tgl"></td>
							</tr>
						</table>
						<table class="table table-bordered w-100" id="example1">
							<thead>
								<tr>
									<td> No</td>
									<td> Nama Barang</td>
									<td style="width:10%;"> Jumlah</td>
									<td style="width:20%;"> Total</td>
									<td> Kasir</td>
									<td> Aksi</td>
								</tr>
							</thead>
							<tbody>
								<?php $total_bayar=0; $no=1; $hasil_penjualan = $lihat -> penjualan();?>
								<?php foreach($hasil_penjualan  as $isi){?>
								<tr>
									<td><?php echo $no;?></td>
									<td><?php echo $isi['nama_barang'];?></td>
									<td>
										<!-- aksi ke table penjualan -->
										<form method="POST" action="fungsi/edit/edit.php?jual=jual">
												<input type="number" name="jumlah" value="<?php echo $isi['jumlah'];?>" class="form-control">
												<input type="hidden" name="id" value="<?php echo $isi['id_penjualan'];?>" class="form-control">
												<input type="hidden" name="id_barang" value="<?php echo $isi['id_barang'];?>" class="form-control">
											</td>
											<td>Rp.<?php echo number_format($isi['total']);?>,-</td>
											<td><?php echo $isi['nm_member'];?></td>
											<td>
												<button type="submit" class="btn btn-warning">Update</button>
										</form>
										<!-- aksi ke table penjualan -->
										<a href="fungsi/hapus/hapus.php?jual=jual&id=<?php echo $isi['id_penjualan'];?>&brg=<?php echo $isi['id_barang'];?>
											&jml=<?php echo $isi['jumlah']; ?>"  class="btn btn-danger"><i class="fa fa-times"></i>
										</a>
									</td>
								</tr>
								<?php $no++; $total_bayar += $isi['total'];}?>
							</tbody>
					</table>
					<br/>
					<?php $hasil = $lihat -> jumlah(); ?>
					<div id="kasirnya">
						<table class="table table-stripped">
							<?php
							// proses bayar dan ke nota
							if(!empty($_GET['nota'] == 'yes')) {
								$total = $_POST['total'];
								$bayar = $_POST['bayar'];
								if(!empty($bayar))
								{
									$hitung = $bayar - $total;
									if($bayar >= $total)
									{
										$id_barang = $_POST['id_barang'];
										$id_member = $_POST['id_member'];
										$jumlah = $_POST['jumlah'];
										$total = $_POST['total1'];
										$tgl_input = $_POST['tgl_input'];
										$periode = $_POST['periode'];
										$jumlah_dipilih = count($id_barang);
										
										for($x=0;$x<$jumlah_dipilih;$x++){

											$d = array($id_barang[$x],$id_member[$x],$jumlah[$x],$total[$x],$tgl_input[$x],$periode[$x]);
											$sql = "INSERT INTO nota (id_barang,id_member,jumlah,total,tanggal_input,periode) VALUES(?,?,?,?,?,?)";
											$row = $config->prepare($sql);
											$row->execute($d);

											// ubah stok barang
											$sql_barang = "SELECT * FROM barang WHERE id_barang = ?";
											$row_barang = $config->prepare($sql_barang);
											$row_barang->execute(array($id_barang[$x]));
											$hsl = $row_barang->fetch();
											
											$stok = $hsl['stok'];
											$idb  = $hsl['id_barang'];

											$total_stok = $stok - $jumlah[$x];
											// echo $total_stok;
											$sql_stok = "UPDATE barang SET stok = ? WHERE id_barang = ?";
											$row_stok = $config->prepare($sql_stok);
											$row_stok->execute(array($total_stok, $idb));
										}
										echo '<script>alert("Belanjaan Berhasil Di Bayar !");</script>';
									}else{
										echo '<script>alert("Uang Kurang ! Rp.'.$hitung.'");</script>';
									}
								}
							}
							?>
							<!-- aksi ke table nota -->
						<form method="POST" action="index.php?page=jual&nota=yes#kasirnya">
  <div class="row mb-3">
    <div class="col-md-6">
      <label>Nama Pelanggan</label>
      <input type="text" name="nama_pelanggan" class="form-control" required>
    </div>
    <div class="col-md-6">
      <label>No. Plat Kendaraan</label>
      <input type="text" name="no_plat" class="form-control" required>
    </div>
  </div>

  <?php foreach($hasil_penjualan as $isi): ?>
    <input type="hidden" name="id_barang[]" value="<?= $isi['id_barang'] ?>">
    <input type="hidden" name="id_member[]" value="<?= $isi['id_member'] ?>">
    <input type="hidden" name="jumlah[]" value="<?= $isi['jumlah'] ?>">
    <input type="hidden" name="total1[]" value="<?= $isi['total'] ?>">
    <input type="hidden" name="tgl_input[]" value="<?= $isi['tanggal_input'] ?>">
    <input type="hidden" name="periode[]" value="<?= date('m-Y') ?>">
  <?php endforeach; ?>

  <table class="table">
    <tr>
      <td>Total</td>
      <td><input type="text" name="total" class="form-control" value="<?= $total_bayar ?>"></td>
      <td>Bayar</td>
      <td><input type="text" name="bayar" class="form-control" required></td>
      <td>
        <button class="btn btn-success"><i class="fa fa-shopping-cart"></i> Bayar</button>
        <?php if (!empty($_GET['nota'] == 'yes')): ?>
          <a class="btn btn-danger" href="fungsi/hapus/hapus.php?penjualan=jual">Reset</a>
        <?php endif; ?>
      </td>
    </tr>
  </table>
</form>

							<!-- aksi ke table nota -->
							<tr>
								<td>Kembali</td>
								<td><input type="text" class="form-control" value="<?php echo $hitung;?>"></td>
								<td></td>
								<td>
									<a href="print.php?nm_member=<?php echo $_SESSION['admin']['nm_member'];?>
									&bayar=<?php echo $bayar;?>&kembali=<?php echo $hitung;?>" target="_blank">
									<button class="btn btn-secondary">
										<i class="fa fa-print"></i> Print Untuk Bukti Pembayaran
									</button></a>
								</td>
							</tr>
						</table>
						<br/>
						<br/>
					</div>
				</div>
			</div>
		</div>
	</div>
	


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$('#cari').on('keypress', function(e) {
  if (e.which == 13) { 
    e.preventDefault(); 
    const keyword = $(this).val();
    console.log("Mencari barang:", keyword);

    $.ajax({
      type: 'POST',
      url: "/EFRI/fungsi/edit/edit.php?cari_barang=yes",
      data: { keyword: keyword },
      beforeSend: function(){
        $('#hasil_cari').hide();
        $('#tunggu').html('<p style="color:green">Tunggu sebentar...</p>');
      },
      success: function(response){
        $('#tunggu').html('');
        $('#hasil_cari').show().html(response);
      },
      error: function(xhr, status, error){
        console.error("AJAX Error:", status, error);
        $('#tunggu').html('<p style="color:red">Gagal memuat data.</p>');
      }
    });
  }
});

</script>