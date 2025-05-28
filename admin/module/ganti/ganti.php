 <div class="container-fluid mt-4">
<div class="col-sm-4">
		<div class="card card-primary">
			<div class="card-header">
				<h5 class="mt-2"><i class="fa fa-lock"></i> Ganti Password</h5>
			</div>
			<div class="card-body">
				<div class="box-content">
					<form class="form-horizontal" method="POST" action="fungsi/edit/edit.php?pass=ganti-pas">
						<fieldset>
							<div class="control-group mb-3">
								<label class="control-label" for="typeahead">Username </label>
								<div class="input-group">
									<input type="text" class="form-control" style="border-radius:0px;" name="user"
										data-items="4" value="<?php echo $hasil['user'];?>" />
								</div>
							</div>
							<div class="control-group mb-3">
								<label class="control-label" for="typeahead">Password Baru</label>
								<div class="input-group">
									<input type="password" class="form-control" placeholder="Enter Your New Password" id="pass" name="pass" data-items="4" value=""
										required="required" />
								</div>
							</div>
							<input type="hidden" class="form-control" style="border-radius:0px;" name="id"
								value="<?php echo $hasil['id_member'];?>" required="required" />
							<button type="submit" class="btn btn-primary" value="Tambah" name="proses"><i class="fas fa-edit"></i> Ubah Password</button>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>