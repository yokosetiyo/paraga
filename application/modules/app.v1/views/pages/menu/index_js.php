<script>
    let tableMenu;

    $(document).ready(function() {
		initTableMenu();
    });

    $('#tb_menu thead tr').clone(true).addClass('filters').appendTo('#tb_menu thead');

    $(".btn-refresh").click(function () {
        $.ajax({
            url: "<?= base_url('api/v1/hak_akses/refreshMenu') ?>",
            cache: false,
            success: function(data){
                location.reload();
            }
        });
    });

    $("#tb_menu tbody").on("click", "tr", function() {
        tableMenu.$("tr.selected").removeClass("selected");
        $(this).addClass("selected");
    });

    $(".btn-tambah").click(function () {
        $("#modal-popout").modal({ backdrop: "static", keyboard: false });
        $("#modal-popout").modal("show");
        $("#content_modal").html(`<div class="text-center p-3"><img src="<?= base_url('app-assets/Preloader_3.gif') ?>" style="width:auto;"></div>`);
        $.ajax({
            url: "<?= base_url('app/v1/menu/tambah'); ?>",
            cache: false,
            success: function(data){
                $("#content_modal").html(data);
                $('#m-detail').html('Tambah Menu');
            }
        });
    });

    $("#tb_menu tbody").on("dblclick", "tr", function () {
        tableMenu.$("tr.selected").removeClass("selected");
        $(this).addClass("selected");
        id = tableMenu.row(this).data().id;

        $("#modal-popout").modal({ backdrop: "static", keyboard: false });
        $("#modal-popout").modal("show");
        $("#content_modal").html(`<div class="text-center p-3"><img src="<?= base_url('app-assets/Preloader_3.gif') ?>" style="width:auto;"></div>`);
        $.ajax({
            type: 'POST',
            url: "<?= base_url('app/v1/menu/ubah'); ?>",
            data:{
                id:id
            },
            cache: false,
            success: function(data){
                $("#content_modal").html(data);
                $('#m-detail').html('Ubah Menu');
                $('.btn-hapus').data('id', id);
                $('#div_btn_hapus').html('');
                getMenuId(id);
            }
        });
        return false;
    });
    
    function getMenuId(id){
		$.ajax({
			type: "POST",
			url: "<?= base_url('api/v1/menu/getMenuId') ?>",
			data:{
				id:id
			},
			dataType: "JSON",
			success: function(res) {
				const element = res.data.data_row;
				$('#id').val(element.id);
				$('#urutan').val(element.urutan);
				$('#level').val(element.level);
				if(element.level > 1){
					getParent(element.level, element.id_parent);
				}
				$('#nama').val(element.nama);
				$('#tipe_link').val(element.tipe_link);
				if(element.tipe_link != 'system' && element.tipe_link != 'link'){
					$('#link').prop('disabled', true);
				}
				$('#link').val(element.link);
				$('#icon').val(element.icon);

				$('#div_btn_hapus').html(`<button type="button" class="btn btn-danger btn-hapus">Hapus Data</button>`);
			}
		});
	}
    
    function initTableMenu() {
		tableMenu = $('#tb_menu').DataTable({
			orderCellsTop: true,
			fixedHeader: false,
			initComplete: function() {
				var api = this.api();
				// For each column
				api
					.columns()
					.eq(0)
					.each(function(colIdx) {
						// Set the header cell to contain the input element
						var cell = $('.filters th').eq(
							$(api.column(colIdx).header()).index()
						);
						var title = $(cell).text();
						if ($(api.column(colIdx).header()).index() >= 0) {
							$(cell).html('<input type="text" placeholder="Cari" style="max-width: inherit; font-size:10px" />');
						}

						// On every keypress in this input
						$(
							'input',
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
					});

				tableMenu.order.neutral().draw();
				tableMenu
					.search('')
					.columns().search('')
					.draw();
			},
			destroy: true,
			// stateSave: true,
			ajax: {
				url: appUrl + 'api/v1/menu/menuData/',
				type: 'get',
				dataType: 'json'
			},
			order: [[1, 'desc']],
			columnDefs: [{
				targets: [0],
				class: 'text-center',
			},{
				targets: [5],
				visible: false,
			}],
			columns: [{
				data: 'urutan',
			},{
				data: 'level',
				render: (data) => {
					if(data == 1){
						return 'Menu';
					}else if(data == 2){
						return 'Sub Menu';
					}else if(data == 3){
						return 'Sub Sub Menu';
					}
				}
			}, {
				data: 'nama',
				render: (data) => {
					return (data + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
						return $1.toUpperCase();
					});
				}
			}, {
				data: 'link',
				render: (data) => {
					if (data == null) return '-';
					return data
				}
			}, {
				data: 'icon',
				render: (data) => {
					if (data == null) return '<i class="bx bx-right-arrow-alt"></i> bx-right-arrow-alt';
					return $('<i>', {
						class: 'bx '+data
					}).prop('outerHTML') + ' ' + data
				}
			},{
				data: 'creaated_at',
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