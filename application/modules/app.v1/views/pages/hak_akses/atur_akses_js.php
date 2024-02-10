<script>
	ROLE_ID = '<?= $ROLE_ID ?>';
	$('#role_id').val(ROLE_ID);

	$(document).ready(function() {
		loadHakAkses();
    });

	function loadHakAkses() {
		$.ajax({
			type: "POST",
			url: "<?= base_url('api/v1/hak_akses/getDataHakAkses') ?>",
			data: {
				ROLE_ID: ROLE_ID
			},
			dataType: "JSON",
			success: function(res) {
				$('#ROLE_NAME').html(res.data.data_row.nama_role);
				for (let index = 0; index < res.data.menu.length; index++) {
					const m = res.data.menu[index];
					let div_menu = '';

					// Only Parent
					if (m.level == 1) {
						div_menu += `
							<div class="col-md-12 mt-1 mb-1" id="parent-${m.id}">
								<span class="ml-${m.level} badge badge-primary">(1) Menu</span>
								<label>${ucwords(m.nama)}</label>`;

								div_menu += `<div class="row mt-1 ml-${m.level}">`;
								for (let i = 0; i < res.data.actions.length; i++) {
									const a = res.data.actions[i];

									if (m.link == null && a.nama != 'Lihat') continue;

									checked = '';

									if (res.data.menu_role[m.id] !== undefined) {
										if (res.data.menu_role[m.id][a.id_aksi] !== undefined) {
											checked = 'checked';
										}
									}

									div_menu += `
									<div class="col-md-3">
										<fieldset>
											<div class="checkbox">
												<input type="checkbox" class="checkbox-input" name="check_${m.id}_${a.id_aksi}" id="${m.id}_${a.id_aksi}" ${checked}>
												<label for="${m.id}_${a.id_aksi}">${a.nama}</label>
											</div>
										</fieldset>
									</div>`;
								}
								div_menu += `</div>`;
								div_menu += `<hr>
							</div>
						`;

						$('#div_menu').append(div_menu);
					}

					// only Sub parent
					if (m.level == 2) {
						div_menu += `
							<div class="col-md-12 mt-1 mb-1" id="parent-${m.id}">
								<span class="ml-${m.level} badge badge-success">(2) Sub Menu</span>
								<label>${ucwords(m.nama)}</label>`;

								div_menu += `<div class="row mt-1 ml-${m.level}">`;
								for (let i = 0; i < res.data.actions.length; i++) {
									const a = res.data.actions[i];

									if (m.link == null && a.nama != 'Lihat') continue;

									checked = '';

									if (res.data.menu_role[m.id] !== undefined) {
										if (res.data.menu_role[m.id][a.id_aksi] !== undefined) {
											checked = 'checked';
										}
									}

									div_menu += `
									<div class="col-md-3">
										<fieldset>
											<div class="checkbox">
												<input type="checkbox" class="checkbox-input" name="check_${m.id}_${a.id_aksi}" id="${m.id}_${a.id_aksi}" ${checked}>
												<label for="${m.id}_${a.id_aksi}">${a.nama}</label>
											</div>
										</fieldset>
									</div>`;
								}
								div_menu += `</div>`;
								div_menu += `<hr>
							</div>
						`;

						$(`#parent-${m.id_parent}`).append(div_menu);
					}

					// only Sub sub parent
					if (m.level == 3) {
						div_menu += `
                   			<div class="col-md-12 mt-1 mb-1">
								<span class="ml-${m.level} badge badge-info">(3) Sub Sub Menu</span>
                        		<label>${ucwords(m.nama)}</label>`;

								div_menu += `<div class="row mt-1 ml-${m.level}">`;
								for (let i = 0; i < res.data.actions.length; i++) {
									const a = res.data.actions[i];

									if (m.link == null && a.nama != 'Lihat') continue;

									checked = '';

									if (res.data.menu_role[m.id] !== undefined) {
										if (res.data.menu_role[m.id][a.id_aksi] !== undefined) {
											checked = 'checked';
										}
									}

									div_menu += `
									<div class="col-md-3">
										<fieldset>
											<div class="checkbox">
												<input type="checkbox" class="checkbox-input" name="check_${m.id}_${a.id_aksi}" id="${m.id}_${a.id_aksi}" ${checked}>
												<label for="${m.id}_${a.id_aksi}">${a.nama}</label>
											</div>
										</fieldset>
									</div>`;
								}
								div_menu += `</div>`;
								div_menu += `<hr>
							</div>
						`;
						
						$(`#parent-${m.id_parent}`).append(div_menu);
					}
				}
			}
		});
	}

	function ucwords(str) {
		return (str + '').replace(/^([a-z])|\s+([a-z])/g, function($1) {
			return $1.toUpperCase();
		});
	}
</script>