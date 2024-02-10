<form method="POST" autocomplete="off" id="form_user" enctype="multipart/form-data" action="<?= base_url('api/v1/menu/do_simpan') ?>">
	<div class="modal-body">
		<input type="hidden" name="id" id="id">
        <div class="row">
            <div class="col-md-4 mb-1">
                <label>Urutan Menu</label>
                <div class="form-group">
                    <input type="number" class="form-control" required name="urutan" id="urutan" placeholder="Urutan Menu">
                </div>
            </div>
            <div class="col-md-4 mb-1">
                <label>Level Menu</label>
                <div class="form-group">
                    <select class="form-control" name="level" id="level">
                        <option selected hidden disabled value="">Pilih Level</option>
                        <option value="1">Menu</option>
                        <option value="2">Sub Menu</option>
                        <option value="3">Sub Sub Menu</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4 mb-1">
                <label>Parent Menu</label>
                <div class="form-group">
                    <select class="form-control" name="id_parent" id="id_parent">
                        <option selected hidden disabled value="">Pilih Parent</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6 mb-1">
                <label>Nama Menu</label>
                <div class="form-group">
                    <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Menu">
                </div>
            </div>
            <div class="col-md-6 mb-1">
                <label>Jenis Link</label>
                <div class="form-group">
                    <select class="form-control" name="tipe_link" id="tipe_link">
                        <option selected value="">Pilih Jenis Link</option>
                        <option value="">Dropdown</option>
                        <option value="system">Url Sistem</option>
                        <option value="link">Direct Link</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6 mb-1">
                <label>Link</label>
                <div class="form-group">
                    <input type="text" class="form-control" required name="link" id="link" placeholder="Link">
                </div>
            </div>
            <div class="col-md-6 mb-1">
                <label>Icon</label>
                <div class="form-group">
                    <input type="text" class="form-control mb-1" name="icon" id="icon" readonly placeholder="Pilih icon dibawah ini">
                </div>
            </div>
            <div class="col-md-12 mb-1">
				<div class="form-control">
					<div class="row" style="max-height: 200px; overflow:auto;" id="div_icon">

					</div>
				</div>
			</div>
        </div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-light-secondary" data-dismiss="modal">
			<i class="bx bx-x d-block d-sm-none"></i>
			<span class="d-none d-sm-block">Tutup</span>
		</button>
        <span id="div_btn_hapus"></span>
		<button type="submit" id="submit" class="btn btn-primary ml-1">
			<i class="bx bx-check d-block d-sm-none"></i>
			<span class="d-none d-sm-block">Simpan</span>
		</button>
	</div>
</form>
<!-- BEGIN: Vendor JS-->
<script src="<?= base_url() ?>app-assets/vendors/js/vendors.min.js"></script>
<script src="<?= base_url() ?>app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.js"></script>
<script src="<?= base_url() ?>app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js"></script>
<script src="<?= base_url() ?>app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js"></script>
<!-- BEGIN Vendor JS-->

<script src="<?= base_url() ?>app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
<script src="<?= base_url() ?>app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
	    getIcons();
    });

    $('#div_icon').on('click', '.select_icon', function(e) {
        icon = $(this).data('icon');
        $('#icon').val(icon);
    });

    $("#level").change(function() {
        level = $(this).val();
        if (level != 1) {
            getParent(level);
        } else {
            $('#parent').val(null);
            $('#parent').prop('disabled', true);
        }
    });

    $("#route_type").change(function() {
        route_type = $(this).val();
        if (route_type == '') {
            $('#route').val(null);
            $('#route').prop('disabled', true);
        } else {
            $('#route').prop('disabled', false);
        }
    });

    $('#div_btn_hapus').on('click', '.btn-hapus', function(e) {
        let id = $('#id').val();
        Swal.fire({
            title: "Hapus data?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#ea1c18",
            confirmButtonText: "Ya",
            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'POST',
                    url: "<?= base_url('api/v1/menu/hapus'); ?>",
                    data: {
                        id: id
                    },
                    cache: false,
                    success: function(data) {
                        //$("#modal-popout").modal("toggle");
                        // initTableMenu();
                        location.reload();
                    }
                });
            }
        });
    });

    function getParent(level, parent_id = null) {
		$('#id_parent').prop('disabled', false);
		$.ajax({
			type: "POST",
			url: "<?= base_url('api/v1/menu/getParent') ?>",
			data: {
				level: level,
			},
			dataType: "JSON",
			success: function(res) {
				if (res.status == 'success') {
					var html = `<option selected="" hidden="" disabled="">Pilih Parent</option>`;
					$.map(res.data, function(e, i) {
						selected = '';
						if (e.id == parent_id) {
							selected = 'selected';
						}
						html += `
							<option value="${e.id}" ${selected}>${e.nama}</option>
						`;
					});
					$('#id_parent').html(html);
				}
			}
		});
	}

	function getIcons() {
		$('#div_icon').html('loading...');
		$.ajax({
			type: "GET",
			url: "<?= base_url('api/v1/menu/getIcons') ?>",
			dataType: "JSON",
			success: function(res) {
				div_icon = '';
				for (let index = 1; index < res.data.icons.length; index++) {
					const element = res.data.icons[index];
					div_icon += `
						<div class="col-md-1 mb-3 text-center select_icon" data-icon="${element.icon}">
                            <div class="fonticon-wrap">
                                <i class="bx ${element.icon}"></i>
                            </div>
						</div>
					`;
				}
				$('#div_icon').html(div_icon);
			}
		});
	}
</script>