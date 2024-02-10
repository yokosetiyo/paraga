									
					</section>
				</div>
			</div>
		</div>
		<!-- END: Content-->

		<!-- BEGIN: Footer-->
		<footer class="footer footer-static footer-light">
			<p class="clearfix mb-0">
				<span class="float-left d-inline-block">&copy; PARAGA APP - Since 2024</span>
			</p>
		</footer>
		<!-- END: Footer-->

		<script type="text/javascript">
			var BASE_URL = "<?= base_url()?>";
		</script>

		<!-- BEGIN: Vendor JS-->
		<script src="<?= base_url()?>app-assets/vendors/js/vendors.min.js"></script>
		<script src="<?= base_url()?>app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.js"></script>
		<script src="<?= base_url()?>app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js"></script>
		<script src="<?= base_url()?>app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js"></script>
		<!-- END Vendor JS-->

		<!-- BEGIN: Page Vendor JS-->
		<script src="<?= base_url()?>app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
		<script src="<?= base_url()?>app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js"></script>
		<script src="<?= base_url()?>app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js"></script>
		<script src="<?= base_url()?>app-assets/vendors/js/tables/datatable/buttons.html5.min.js"></script>
		<script src="<?= base_url()?>app-assets/vendors/js/tables/datatable/buttons.print.min.js"></script>
		<script src="<?= base_url()?>app-assets/vendors/js/tables/datatable/buttons.bootstrap.min.js"></script>
		<script src="<?= base_url()?>app-assets/vendors/js/tables/datatable/pdfmake.min.js"></script>
		<script src="<?= base_url()?>app-assets/vendors/js/tables/datatable/vfs_fonts.js"></script>
		<script src="<?= base_url()?>app-assets/vendors/js/extensions/toastr.min.js"></script>
		<!-- END: Page Vendor JS-->

		<!-- BEGIN: Theme JS-->
		<script src="<?= base_url()?>app-assets/js/scripts/configs/vertical-menu-light.js"></script>
		<script src="<?= base_url()?>app-assets/js/core/app-menu.js"></script>
		<script src="<?= base_url()?>app-assets/js/core/app.js"></script>
		<script src="<?= base_url()?>app-assets/js/scripts/components.js"></script>
		<script src="<?= base_url()?>app-assets/js/scripts/footer.js"></script>
		<!-- END: Theme JS-->

		<!-- BEGIN: Custom JS-->
	    <script src="<?= base_url()?>app-assets/js/system.js"></script>
		<!-- END: Custom JS-->

		<!-- BEGIN: Page JS-->
    	<script src="<?= base_url()?>app-assets/vendors/js/forms/select/select2.full.min.js"></script>
		<script src="<?= base_url()?>app-assets/js/scripts/datatables/datatable.js"></script>
    	<script src="<?= base_url()?>app-assets/js/scripts/forms/select/form-select2.js"></script>
		<script src="<?= base_url()?>app-assets/vendors/js/pickers/pickadate/picker.js"></script>
		<script src="<?= base_url()?>app-assets/vendors/js/pickers/pickadate/picker.date.js"></script>
		<script src="<?= base_url()?>app-assets/alertifyjs/alertify.min.js"></script>
	    <script src="<?= base_url()?>app-assets/vendors/js/extensions/polyfill.min.js"></script>
		<script src="<?= base_url(); ?>app-assets/sweetalert/dist/sweetalert2.all.min.js"></script>
		<script src="<?= base_url()?>app-assets/js/scripts/extensions/toastr.js"></script>
		<!-- END: Page JS-->

		<script type="text/javascript">
		    function show_loading(isi = null) {
		        $(`.se-pre-con`).show();
		        if (isi != null) {
		        	$(`#text-loading`).html(isi);
		        }
		    }

			$(document).ready(function(){
				$(`div`).filter(function() {
					return $(this).css('background') == '#ffffffed';
				}).each(function() {
					$(this).css('background', 'red');
				});
			});

			$(`#basicSelect`).change(function() {
					var thn = $(this).val();
                    $.ajax({
                    url : "<?= base_url('dashboard/sess_tahun/')?>" + $(this).val(),
                    type: 'GET',
                    dataType:'JSON',
                    cache: false,
                    success : function(data) {
                        if (data.success) {
                            Swal.fire({
                                title: "Berhasil!",
                                text: data.msg,
                                type: "success",
                                confirmButtonClass: 'btn btn-success',
                                buttonsStyling: false,
						    }).then(function() {
							    location.reload();
							});
                        }
                        else
                        {
                            alert("Error!!");
                        }
                    }
                });
            });

			$(`.basicSelect_bulan`).change(function() {
					var bln = $(this).val();
                    $.ajax({
                    url : "<?= base_url('dashboard/sess_bulan/')?>" + $(this).val(),
                    type: 'GET',
                    dataType:'JSON',
                    cache: false,
                    success : function(data) {
                        if (data.success) {
                            Swal.fire({
						        title: "Berhasil!",
                                text: data.msg,
                                type: "success",
                                confirmButtonClass: 'btn btn-success',
                                buttonsStyling: false,
						    }).then(function() {
							    location.reload();
							});
                        }
                        else
                        {
                            alert("Error!!");
                        }

                    }
                });
            });

            var datePickerOption = {
	            changeMonth: false,
	            showMonthAfterYear: false,
	            startView: 3,
	            minViewMode: 2,
	            format: 'yyyy',
	            autoclose: 'true',
	        };

	        $(function () {
	            $(`#tahun_top`).pickadate(datePickerOption)
	            .on( `changeDate`, function(dateText) {
	            	console.log(dateText.dates[0].getFullYear());
	              	window.location.href = "<?= site_url('auth/sess_tahun/')?>" + dateText.dates[0].getFullYear();
	            });
	        });

			let ubah = false;
			let hapus = false;

			<?php if($this->aksi['ubah']){ ?>
				ubah = true;
			<?php } ?>
			<?php if($this->aksi['hapus']){ ?>
				hapus = true;
			<?php } ?>
		</script>
		<?php isset($extra_js) ? $this->load->view($extra_js) : ''; ?>
		<?= isset($javascript) ? $javascript : ''; ?>
	</body>
	<!-- END: Body-->
</html>