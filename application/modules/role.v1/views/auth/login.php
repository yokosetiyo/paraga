<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta name="description" content="Paguyuban Remaja Gabahan">
        <meta name="keywords" content="paraga, gabahan, sonorejo, karang taruna, muda mudi">
        <meta name="author" content="Paraga">
        <title>PARAGA APP | LOGIN</title>
        <link rel="shortcut icon" type="image/x-icon" href="<?= base_url(); ?>app-assets/images/logo_paraga.jpg">
        <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>app-assets/vendors/css/vendors.min.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>app-assets/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>app-assets/css/bootstrap-extended.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>app-assets/css/colors.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>app-assets/css/components.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>app-assets/css/themes/dark-layout.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>app-assets/css/themes/semi-dark-layout.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>app-assets/css/core/menu/menu-types/vertical-menu.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>app-assets/css/pages/authentication.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>app-assets/sweetalert/dist/sweetalert2.min.css">
        <style type="text/css">
            .alert{
                margin-bottom: 10px;
                padding: 5px;
            }
        </style>
        <script>
            const appUrl = "<?= base_url() ?>";
            const apiUrl = "<?= base_url() ?>api";
        </script>
    </head>
    <body class="vertical-layout vertical-menu-modern 1-column  navbar-sticky footer-static bg-full-screen-image  blank-page blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column">
        <div class="app-content content">
            <div class="content-overlay"></div>
            <div class="content-wrapper">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <section id="auth-login" class="row flexbox-container">
                        <div class="col-xl-8 col-11">
                            <div class="card bg-authentication mb-0">
                                <div class="row m-0">
                                    <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
                                        <div class="card-content">
                                            <img class="img-fluid" src="<?= base_url(); ?>app-assets/images/pages/login.png" alt="branding logo">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12 px-0">
                                        <div class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
                                            <div class="card-header" style="padding-bottom: 0px;">
                                                <div class="card-title text-center">
                                                    <img src="<?= base_url()?>app-assets/images/logo_paraga.jpg" style="width: 100px; margin-bottom: 5px;">
                                                    <h4 class="text-center">PARAGA APP</h4>
                                                </div>
                                            </div>
                                            <div class="card-content" style="padding-top: 0px;">
                                                <div class="card-body">
                                                    <div class="divider">
                                                        <div class="divider-text text-uppercase text-muted">
                                                            <small>login dengan username dan password</small>
                                                        </div>
                                                    </div>
                                                    <form novalidate="novalidate" method="post" id="form_login" action="#">
                                                        <div class="form-group mb-50">
                                                            <label class="text-bold-600" for="username">Username</label>
                                                            <input type="text" class="form-control" id="username" name="username_user" placeholder="Username" value="<?= $this->session->flashdata('username_user')?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="text-bold-600" for="password">Password</label>
                                                            <input type="password" class="form-control" name="password_user" id="password" placeholder="Password">
                                                        </div>
                                                        <input type="hidden" name="url_redirect" id="url_redirect" value="">
                                                        <button type="submit" class="btn btn-primary glow w-100 position-relative" id="btn_login">
                                                            Login <i id="icon-arrow" class="bx bx-right-arrow-alt"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <script src="<?= base_url(); ?>app-assets/vendors/js/vendors.min.js"></script>
        <script src="<?= base_url(); ?>app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.js"></script>
        <script src="<?= base_url(); ?>app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js"></script>
        <script src="<?= base_url(); ?>app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js"></script>
        <script src="<?= base_url(); ?>app-assets/js/scripts/configs/vertical-menu-light.js"></script>
        <script src="<?= base_url(); ?>app-assets/js/core/app-menu.js"></script>
        <script src="<?= base_url(); ?>app-assets/js/core/app.js"></script>
        <script src="<?= base_url(); ?>app-assets/js/scripts/components.js"></script>
        <script src="<?= base_url(); ?>app-assets/js/scripts/footer.js"></script>
        <script src="<?= base_url(); ?>app-assets/sweetalert/dist/sweetalert2.all.min.js"></script>
        <script>
            <?php if (!empty($this->session->flashdata('error_messages'))) { ?>
                Swal.fire({
                    icon: 'warning',
                    title: 'Gagal',
                    text: '<?= $this->session->flashdata('error_messages') ?>'
                });
            <?php } ?>
            
            $(document).ready(function() {
                var form = document.getElementById('form_login');
                var submitButton = document.getElementById('btn_login');
               
                submitButton.addEventListener("click", function (e) {
                    e.preventDefault();
                    var username = $('#username').val();
                    var password = $('#password').val();
                    
                    if(username.length == "") {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Oops...',
                            text: 'Username Wajib Diisi !'
                        });
                    } else if(password.length == "") {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Oops...',
                            text: 'Password Wajib Diisi !'
                        });
                    } else {
                        submitButton.disabled = true;
                        $('#form_login').attr('action', appUrl + 'role/auth/process').submit();
                    }
                });
            });
        </script>
    </body>
</html>