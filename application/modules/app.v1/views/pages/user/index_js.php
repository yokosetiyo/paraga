<script>
	let tableUser;

    $(document).ready(function() {
		initTableUser();
    });

	$('#tb_user thead tr')
			.clone(true)
			.addClass('filters')
			.appendTo('#tb_user thead');

	$(".btn-tambah").click(function () {
		$("#modal-popout").modal({ backdrop: "static", keyboard: false });
		$("#modal-popout").modal("show");
		$("#content_modal").html(`<div class="text-center p-3"><img src="<?= base_url('app-assets/Preloader_3.gif') ?>" style="width:auto;"></div>`);
		$.ajax({
			url: "<?= base_url('app/v1/user/tambah'); ?>",
			cache: false,
			success: function(data){
				$("#content_modal").html(data);
				$('#m-detail').html('Tambah User');
				getRole();
			}
		});
	});

	$("#tb_user tbody").on("click", ".btn-ubah", function () {
		var $btn 			= $(this);
		var $tr 			= $btn.closest("tr");
		var dataTableRow 	= tableUser.row($tr[0]);
		var rowData 		= dataTableRow.data();

		const ID = rowData.id_user;

		$("#modal-popout").modal({ backdrop: "static", keyboard: false });
		$("#modal-popout").modal("show");
		$("#content_modal").html(`<div class="text-center p-3"><img src="<?= base_url('app-assets/Preloader_3.gif') ?>" style="width:auto;"></div>`);
		$.ajax({
			type: 'POST',
			url: "<?= base_url('app/v1/user/ubah'); ?>",
			cache: false,
			success: function(data){
				$("#content_modal").html(data);
				$('#m-detail').html('Ubah User');
				getRole();
				getDataUser(ID);
				$('#submit').prop('disabled', false);
			}
		});
	});

	$("#tb_user tbody").on("click", ".btn-hapus", function () {
		let id = $(this).data('id');
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
					url: "<?= base_url('api/v1/user/hapus'); ?>",
					data:{
						id:id
					},
					cache: false,
					success: function(data){
						$("#modal-popout").modal("hide");
						initTableUser();
					}
				});
			}
		});
	});

	function getRole(){
		$.ajax({
			type: "GET",
			url: "<?= base_url('api/v1/user/getHakAkses') ?>",
			dataType: "JSON",
			success: function(res) {
				div_role = '';
				for (let index = 0; index < res.data.length; index++) {
					const row = res.data[index];
					div_role += `
						<div class="col-md-6 mb-1">
							<fieldset>
								<div class="checkbox">
									<input type="checkbox" class="checkbox-input" name="role[${row.id}]" id="role_${row.id}">
									<label for="role_${row.id}">${row.nama_role}</label>
								</div>
							</fieldset>
						</div>
					`;
				}

				$('#div_role').html(div_role);
			}
		});
	}

	function getDataUser(ID){
		$('#form_user input').addClass('loading');
		$.ajax({
			type: "POST",
			url: "<?= base_url('api/v1/user/getDataId') ?>",
			data:{
				id:ID
			},
			dataType: "JSON",
			success: function(res) {
				$('#form_user input').removeClass('loading');
				const element = res.data_row;
				$('#id').val(element.id_user);
				$('#name').val(element.nama_user);
				$('#username').val(element.username_user);

				waitForEl('.checkbox-input', function() {
					for (let index = 0; index < res.roles.length; index++) {
						const row = res.roles[index];
						$('#role_'+row.id_role).prop('checked', true);
					}
				});
			}
		});
	}

	function initTableUser() {
		tableUser = $('#tb_user').DataTable({
			orderCellsTop: true,
			fixedHeader: false,
			initComplete: function() {
				var api = this.api();
				// For each column
				api
					.columns()
					.eq(0)
					.each(function(colIdx) {
						if(colIdx!=3){
							// Set the header cell to contain the input element
							var cell = $('.filters th').eq(
								$(api.column(colIdx).header()).index()
							);
							var title = $(cell).text();
							if ($(api.column(colIdx).header()).index() >= 0) {
								$(cell).html('<input type="text" placeholder="Cari" style="max-width: inherit; font-size:10px" />');
							}

							// On every keypress in this input
							$('input',
								$('.filters th').eq($(api.column(colIdx).header()).index())
							)
							.off('keyup change')
							.on('keyup change', function(e) {
								e.stopPropagation();

								// Get the search value
								$(this).attr('title', $(this).val());
								var regexr = '({search})'; //$(this).parents('th').find('select').val();

								var cursorPosition = this.selectionStart;
								// Search the column for that value
								api
									.column(colIdx)
									.search(
										this.value != '' ?
										regexr.replace('{search}', '(((' + this.value + ')))') :
										'',
										this.value != '',
										this.value == ''
									)
									.draw();

								$(this)
									.focus()[0]
									.setSelectionRange(cursorPosition, cursorPosition);
							});
						}else{
							var cell = $('.filters th').eq(
								$(api.column(colIdx).header()).index()
							);
							var title = $(cell).text();
							if ($(api.column(colIdx).header()).index() >= 0) {
								$(cell).html('');
							}
						}
					});

				tableUser.order.neutral().draw();
				tableUser
					.search('')
					.columns().search('')
					.draw();
			},
			destroy: true,
			// stateSave: true,
			ajax: {
				url: appUrl + 'api/v1/user/getData/',
				type: 'get',
				dataType: 'json'
			},
			order: [[1, 'desc']],
			columnDefs: [{
				targets: [-1],
				class: 'text-center',
				orderable: false,
			}],
			columns: [{
				data: 'username_user',
			},{
				data: 'nama_user',
			}, {
				data: 'role',
				render: (role) => {
					if(role != null){
						return role.replace(",", ", ");
					}else{
						return '';
					}
				}
			},{
				data: 'id_user',
				render: (id_user) => {
					let button_edit = '', button_delete = '';

					if(ubah) {
						button_edit = $('<button>', {
							html: $('<i>', {
								class: 'bx bx-edit'
							}).prop('outerHTML'),
							class: 'btn btn-sm btn-primary btn-ubah',
							type: 'button',
							'data-id': id_user,
							'data-toggle': 'tooltip',
							'data-placement': 'top',
							title: 'Ubah Data'
						})
					}
					
					if(hapus) {
						button_delete = $('<button>', {
							html: $('<i>', {
								class: 'bx bx-trash'
							}).prop('outerHTML'),
							class: 'btn btn-sm btn-danger btn-hapus',
							'data-id': id_user,
							'data-toggle': 'tooltip',
							'data-placement': 'top',
							title: 'Hapus Data'
						});
					}

					return $('<div>', {
						class: 'btn-group',
						html: [button_edit, button_delete]
					}).prop('outerHTML');
				}
			}]
		});
	}

	<?php if(!empty($this->session->flashdata('msg_success'))){ ?>
		showBasicToastr("success", '<?= $this->session->flashdata('msg_success') ?>');
	<?php } ?>

	<?php if(!empty($this->session->flashdata('msg_error'))){ ?>
		showBasicToastr("error", '<?= $this->session->flashdata('msg_error') ?>');
	<?php } ?>
</script>