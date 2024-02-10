<style type="text/css">
	.dataTables_scrollBody{
		height: unset !important;
	}
	.alert {
	    margin-bottom: 0px;
	    padding: 10px;
	    margin-top: 10px;
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
	                            <h5 class="card-title">Daftar Menu</h5>
                                <div class="heading-elements" style="top: -5px;">
                                    <ul class="list-inline mb-0">
                                        <li>
                                            <button type="button" class="btn btn-danger btn-sm btn-refresh">Muat Ulang Menu</button>
                                        </li>
                                        <li>
                                            <button type="button" class="btn btn-sm btn-primary btn-tambah">
                                                Tambah Menu
                                            </button>
                                        </li>
                                    </ul>
                                </div>
	                        </div>
	                        <hr style="margin-bottom: 0px;">
							<div class="table-responsive">
								<table class="table table-bordered table-striped" id="tb_menu">
									<thead>
										<tr>
                                            <th class="text-center">Urutan Menu</th>
                                            <th>Level</th>
                                            <th>Nama Menu</th>
                                            <th>Link</th>
                                            <th>Icon</th>
                                            <th></th>
										</tr>
									</thead>
									<tbody>
										
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-popout" tabindex="-1" role="dialog" aria-labelledby="m-detail" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header bg-danger">
				<h5 class="modal-title white" id="m-detail">Tambah Menu</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<i class="bx bx-x"></i>
				</button>
			</div>
            <div id="content_modal"></div>
		</div>
	</div>
</div>