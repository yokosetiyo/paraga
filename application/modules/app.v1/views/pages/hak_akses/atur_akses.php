<style>
    .ml-2{
        margin-left: 20px;
    }
    .ml-3{
        margin-left: 40px;
    }
    .form-check-input{
        height: 1.75rem !important;
    }
    .form-check.form-check-custom .form-check-label {
        margin-left: 0px !important;
    }
</style>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-content">
				<div class="card-body">
					<div class="row">
						<div class="col-md-12">
                            <div class="card-header" style="padding: 1px 0 1px 0;">
	                            <h5 class="card-title">Manajemen Hak Akses :&nbsp;<b class="text-primary" id="ROLE_NAME"></b></h5>
                                <div class="heading-elements" style="top: -5px;">
                                    <ul class="list-inline mb-0">
                                        <li>
                                            <a href="<?= base_url('app/v1/hak_akses') ?>" class="btn btn-secondary btn-sm">&nbsp; Kembali</a>
                                        </li>
                                    </ul>
                                </div>
	                        </div>
                            <hr style="margin-bottom: 0px;">
                            <form method="post" action="<?= base_url('api/v1/hak_akses/do_simpan_hak') ?>">
                                <input type="hidden" name="role_id" id="role_id">
                                <div class="row" id="div_menu">
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>