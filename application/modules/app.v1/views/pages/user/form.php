<form method="POST" autocomplete="off" id="form_user" enctype="multipart/form-data" action="<?= base_url('api/v1/user/do_simpan') ?>">
	<div class="modal-body">
		<input type="hidden" name="id" id="id">
		<label>Nama</label>
		<div class="form-group">
			<input type="text" class="form-control" required name="name" id="name" placeholder="Nama">
		</div>
		<label>Username</label>
		<div class="form-group">
			<input type="text" autocomplete="new-password" class="form-control" required name="username" id="username" placeholder="Username">
		</div>
		<label>Password</label>
		<div class="form-group">
			<input type="password" autocomplete="new-password" class="form-control password" name="password" id="password" placeholder="Password">
		</div>
		<label>Ulangi Password</label>
		<div class="form-group">
			<input type="password" class="form-control password" name="re_password" id="re_password" placeholder="Ulangi Password">
			<span id="stat_pass"></span>
		</div>
		<label>Role</label>
		<div class="row" id="div_role">
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-light-secondary" data-dismiss="modal">
			<i class="bx bx-x d-block d-sm-none"></i>
			<span class="d-none d-sm-block">Tutup</span>
		</button>
		<button type="submit" id="submit" disabled class="btn btn-primary ml-1">
			<i class="bx bx-check d-block d-sm-none"></i>
			<span class="d-none d-sm-block">Simpan</span>
		</button>
	</div>
</form>

<script>
	$(".password").keyup(function () {
		pass = $('#password').val();
		re_pass = $('#re_password').val();
		if(pass == re_pass){
			$('#stat_pass').html('<font class="mt-1 text-success">Password sama</font>');
			$('#submit').prop('disabled', false);
		}else{
			$('#stat_pass').html('<font class="mt-1 text-danger">Password tidak sama</font>');
			$('#submit').prop('disabled', true);
		}
	});
</script>