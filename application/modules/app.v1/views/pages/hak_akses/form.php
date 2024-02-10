<form method="POST" autocomplete="off" action="<?= base_url('api/v1/hak_akses/do_simpan') ?>">
	<div class="modal-body">
		<input type="hidden" name="id" id="id">
		<label>Nama Hak Akses</label>
		<div class="form-group">
			<input type="text" class="form-control" required name="name" id="name" placeholder="Nama Hak Akses">
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-light-secondary" data-dismiss="modal">
			<i class="bx bx-x d-block d-sm-none"></i>
			<span class="d-none d-sm-block">Tutup</span>
		</button>
		<button type="submit" id="submit" class="btn btn-primary ml-1">
			<i class="bx bx-check d-block d-sm-none"></i>
			<span class="d-none d-sm-block">Simpan</span>
		</button>
	</div>
</form>