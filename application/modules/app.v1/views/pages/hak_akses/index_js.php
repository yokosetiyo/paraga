<script>
	let tableHakAkses;

    $(document).ready(function() {
		initTableHakAkses();
    });

    $(".btn-tambah").click(function () {
        $("#modal-popout").modal({ backdrop: "static", keyboard: false });
        $("#modal-popout").modal("show");
        $("#content_modal").html(`<div class="text-center p-3"><img src="<?= base_url('app-assets/Preloader_3.gif') ?>" style="width:auto;"></div>`);
        $.ajax({
            url: "<?= base_url('app/v1/hak_akses/tambah'); ?>",
            cache: false,
            success: function(data){
                $("#content_modal").html(data);
                $('#m-detail').html('Tambah Hak Akses');
            }
        });
    });

    $(".btn-refresh").click(function () {
        $.ajax({
            url: "<?= base_url('api/v1/hak_akses/refreshMenu') ?>",
            cache: false,
            success: function(data){
                location.reload();
            }
        });
    });

    $("#tb_hak_akses tbody").on("click", ".btn-ubah", function () {
        id = $(this).data('id');
        $("#modal-popout").modal({ backdrop: "static", keyboard: false });
        $("#modal-popout").modal("show");
        $("#content_modal").html(`<div class="text-center p-3"><img src="<?= base_url('app-assets/Preloader_3.gif') ?>" style="width:auto;"></div>`);
        $.ajax({
            type: 'POST',
            url: "<?= base_url('app/v1/hak_akses/ubah'); ?>",
            data:{
                id:id
            },
            cache: false,
            success: function(data){
                $("#content_modal").html(data);
                $('#m-detail').html('Ubah Hak Akses');
                getHakAksesId(id);
            }
        });
    });
    
    $("#tb_hak_akses tbody").on("click", ".btn-hapus", function () {
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
                    url: "<?= base_url('api/v1/hak_akses/hapus'); ?>",
                    data:{
                        id:id
                    },
                    cache: false,
                    success: function(data){
                        $("#modal-popout").modal("hide");
                        initTableHakAkses();
                    }
                });
            }
        });
    });

	function getHakAksesId(id){
		$.ajax({
			type: "POST",
			url: "<?= base_url('api/v1/hak_akses/getHakAksesId') ?>",
			data:{
				id:id
			},
			dataType: "JSON",
			success: function(res) {
				const element = res.data.data_row;
				$('#id').val(element.id);
				$('#name').val(element.nama_role);
			}
		});
	}

	function initTableHakAkses() {
		tableHakAkses = $('#tb_hak_akses').DataTable({
			initComplete: function() {
				
			},
			destroy: true,
			ajax: {
				url: appUrl + 'api/v1/hak_akses/getData/',
				type: 'get',
				dataType: 'json'
			},
			order: [[0, 'asc']],
			columnDefs: [
                {
                    targets: [0,-1],
                    class: 'text-center',
			    }
            ],
			columns: [
                {
                    data: 'id',
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'nama_role',
                    render: (data) => {
                        return (data + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
                            return $1.toUpperCase();
                        });
                    }
                },
                {
                    data: 'id',
                    render: (id) => {
                        let button_edit = '', button_delete = '', button_access = '';

                        button_access = $('<a>', {
                            html: $('<i>', {
                                class: 'bx bx-wrench'
                            }).prop('outerHTML'),
                            class: 'btn btn-sm btn-dark btn-access',
                            'data-toggle': 'tooltip',
                            'data-placement': 'top',
                            title: 'Ubah hak akses',
                            href: appUrl + 'app/v1/hak_akses/atur_akses/' + id
                        })

                        button_edit = $('<button>', {
                            html: $('<i>', {
                                class: 'bx bx-edit'
                            }).prop('outerHTML'),
                            class: 'btn btn-sm btn-primary btn-ubah',
                            type: 'button',
                            'data-id': id,
                            'data-toggle': 'tooltip',
                            'data-placement': 'top',
                            title: 'Ubah Data'
                        })

                        button_delete = $('<button>', {
                            html: $('<i>', {
                                class: 'bx bx-trash'
                            }).prop('outerHTML'),
                            class: 'btn btn-sm btn-danger btn-hapus',
                            'data-id': id,
                            'data-toggle': 'tooltip',
                            'data-placement': 'top',
                            title: 'Hapus Data'
                        });

                        return $('<div>', {
                            class: 'btn-group',
                            html: [button_access, button_edit, button_delete]
                        }).prop('outerHTML');
                    }
                }
            ]
		});
	}

	<?php if(!empty($this->session->flashdata('msg_success'))){ ?>
		showBasicToastr("success", '<?= $this->session->flashdata('msg_success') ?>');
	<?php } ?>
	
	<?php if(!empty($this->session->flashdata('msg_error'))){ ?>
		showBasicToastr("error", '<?= $this->session->flashdata('msg_error') ?>');
	<?php } ?>
</script>