<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta name="description" content="Paguyuban Remaja Gabahan">
        <meta name="keywords" content="paraga, gabahan, sonorejo, karang taruna, muda mudi">
        <meta name="author" content="Paraga">
        <title>PARAGA APP | UBAH PASSWORD</title>
        <link rel="shortcut icon" type="image/x-icon" href="<?= base_url(); ?>app-assets/images/logo_paraga.jpg">
        <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/app-assets/vendors/css/vendors.min.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/app-assets/vendors/css/ui/prism.min.css">

        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/app-assets/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/app-assets/css/bootstrap-extended.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/app-assets/css/colors.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/app-assets/css/components.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/app-assets/css/themes/dark-layout.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/app-assets/css/themes/semi-dark-layout.css">

        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/app-assets/css/core/menu/menu-types/vertical-menu.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/app-assets/css/plugins/forms/validation/form-validation.css">

        <script>
            const appUrl = "<?= base_url() ?>";
            const apiUrl = "<?= base_url() ?>api";
        </script>
        <style>
            .alert {
                padding: 10px;
                margin-bottom: 30px;
                box-shadow: -2px 2px 5px 0 rgba(57, 218, 138, 0.4) !important;
            }
        </style>
    </head>
    <body class="vertical-layout vertical-menu-modern 1-column  navbar-sticky footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="1-column">
        <div class="header-navbar-shadow"></div>
        <nav class="header-navbar main-header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top ">
            <div class="navbar-wrapper">
                <div class="navbar-container content">
                    <div class="navbar-collapse" id="navbar-mobile">
                        <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                        </div>
                        <ul class="nav navbar-nav float-right">
                            <li class="dropdown dropdown-user nav-item">
                                <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                    <div class="user-nav d-sm-flex d-none">
                                        <span class="user-name">
                                            <?= strtoupper($this->session->userdata('USER_SESSION')['USER_FULLNAME']) ?>
                                        </span>
                                        <span class="user-status text-muted">
                                            <small>
                                                <?= strtoupper($this->session->userdata('USER_SESSION')['ROLE_NAME']) ?>
                                            </small>
                                        </span>
                                    </div>
                                    <span><img class="round" src="<?= base_url()?>app-assets/images/logo_paraga.jpg" alt="avatar" height="40" width="40"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <?php if ($this->session->userdata('USER_SESSION')['MULTIROLE']): ?>
                                        <a class="dropdown-item" href="<?= base_url('role/auth/chooseRole/'.$this->session->userdata('USER_SESSION')['USER_ID']."?redirect=".base_url($_SERVER["REQUEST_URI"])) ?>">
                                            <i class="bx bx-shield mr-50"></i> Ganti Role
                                        </a>
                                    <?php endif ?>
                                    <a class="dropdown-item" href="<?= base_url('role/auth/change_password?callback='.base_url($_SERVER["REQUEST_URI"])) ?>">
                                        <i class="bx bx-user mr-50"></i> Ganti Password
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?= base_url('role/auth/logout') ?>">
                                        <i class="bx bx-power-off mr-50"></i> Keluar
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <div class="app-content content">
            <div class="content-overlay"></div>
            <div class="content-wrapper">
                <div class="content-header row">
                    <div class="content-header-left col-12 mb-2 mt-1">
                        <div class="row breadcrumbs-top">
                            <div class="col-12">
                                <h5 class="content-header-title float-left pr-1 mb-0">SISTEM</h5>
                                <div class="breadcrumb-wrapper col-12">
                                    <ol class="breadcrumb p-0 mb-0">
                                        <li class="breadcrumb-item">
                                            <a href="<?= base_url('app/v1/') ?>"><i class="bx bx-home-alt"></i></a>
                                        </li>
                                        <li class="breadcrumb-item active">
                                            Ubah Password
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-body">
                    <h2 class="text-center mb-2">PARAGA APP</h2>
                    <div class="row">
                        <div class="col-sm-6 dashboard-users-success" style="padding-right: 8px; padding-left: 8px">
                            <div class="card text-center" style="margin-bottom: 15px; box-shadow: -4px 4px 0px 0 rgba(25, 42, 70, 0.13);">
                                <div class="card-content">
                                    <div class="card-body" style="padding: 10px;">
                                        <div class="card-header">
                                            <h4 class="card-title">Ubah Password</h4>
                                        </div>
                                        <div class="card-content">
                                            <div class="card-body">
                                                <form class="form form-horizontal" action="#" method="POST" id="change_password_form" novalidate>
                                                    <div class="form-body">
                                                        <div class="row">
                                                            <div class="col-md-12 form-group">
                                                                <label>Password Lama</label>
                                                                <input type="password" class="form-control" name="pass_old" id="pass_old" placeholder="Masukkan Password Lama..." required data-validation-required-message="Password lama tidak boleh kosong">
                                                                <div class="help-block"></div>
                                                            </div>
                                                            <div class="col-md-12 form-group">
                                                                <label>Password Baru</label>
                                                                <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan Password Baru..." required data-validation-required-message="Password baru tidak boleh kosong" minlength="8" data-validation-minlength-message="Password baru harus lebih dari 8 karakter">
                                                                <div class="help-block"></div>
                                                            </div>
                                                            <div class="col-md-12 form-group">
                                                                <label>Ulangi Password</label>
                                                                <input type="password" class="form-control" name="re_pass" id="re_pass" placeholder="Masukkan Ulang Password..." required minlength="8" data-validation-minlength-message="Password ulang harus lebih dari 8 karakter" data-validation-match-match="password" data-validation-required-message="Password baru tidak sama">
                                                                <div class="help-block"></div>
                                                            </div>
                                                            <div class="col-sm-12 d-flex justify-content-end">
                                                                <a href="<?= !empty($callback) ? $callback : base_url("app/v1")  ?>" class="btn btn-dark mr-1">Kembali</a>
                                                                <button type="submit" id="button_submit" class="btn btn-primary">
                                                                    Ganti Password
                                                                </button>
                                                            </div>
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
                </div>
            </div>
        </div>
        <div class="sidenav-overlay"></div>
        <div class="drag-target"></div>
        <footer class="footer footer-static footer-light">
            <p class="clearfix mb-0">
                <span class="float-left d-inline-block">&copy; PARAGA APP - Since 2024</span>
                <button class="btn btn-primary btn-icon scroll-top" type="button"><i class="bx bx-up-arrow-alt"></i></button>
            </p>
        </footer>
        <script type="text/javascript">
            var BASE_URL = '<?= base_url()?>';
        </script>
        <script src="<?= base_url(); ?>/app-assets/vendors/js/vendors.min.js"></script>
        <script src="<?= base_url(); ?>/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.js"></script>
        <script src="<?= base_url(); ?>/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js"></script>
        <script src="<?= base_url(); ?>/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js"></script>

        <script src="<?= base_url(); ?>/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"></script>
        
        <script src="<?= base_url(); ?>/app-assets/js/scripts/configs/vertical-menu-light.js"></script>
        <script src="<?= base_url(); ?>/app-assets/js/core/app-menu.js"></script>
        <script src="<?= base_url(); ?>/app-assets/js/core/app.js"></script>
        <script src="<?= base_url(); ?>/app-assets/sweetalert/dist/sweetalert2.all.min.js"></script>

        <script>
            $(document).ready(function() {
                $("#change_password_form input").jqBootstrapValidation({
                    preventSubmit: true,
                    submitSuccess: function($form, event){
                        event.preventDefault();
                        $this = $('#button_submit');
                        $this.prop('disabled', true);
                        var form_data = $("#change_password_form").serialize();
                        $.ajax({
                            type: "POST",
                            url: `${appUrl}role/auth/change_password_post`,
                            data: form_data,
                            dataType: "JSON",
                            success: function(res) {
                                if (res.status) {
                                    Swal.fire({
                                        text: res.message,
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok",
                                        customClass: {
                                            confirmButton: "btn btn-primary",
                                        }
                                    }).then(function() {
                                        window.location = `${appUrl}role/auth/logout`;
                                    });

                                } else {
                                    Swal.fire({
                                        text: res.message,
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok",
                                        customClass: {
                                            confirmButton: "btn btn-primary",
                                        },
                                    });
                                }
                            },
                            error:function(){
                                
                            },
                            complete:function(){
                                setTimeout(function(){
                                    $this.prop("disabled", false);
                                }, 5000);
                            }
                        });
                    }
                })
            });
        </script>
    </body>
</html>