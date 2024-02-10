<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
    <!-- BEGIN: Head-->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta name="description" content="Paguyuban Remaja Gabahan">
        <meta name="keywords" content="paraga, gabahan, sonorejo, karang taruna, muda mudi">
        <meta name="author" content="Paraga">
        <title>PARAGA APP | <?= @$_title ?></title>
        <link rel="shortcut icon" type="image/x-icon" href="<?= base_url(); ?>app-assets/images/logo_paraga.jpg">
        <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">

        <!-- BEGIN: Vendor CSS-->
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/vendors/css/vendors.min.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/vendors/css/forms/select/select2.min.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/vendors/css/pickers/pickadate/pickadate.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/vendors/css/pickers/daterange/daterangepicker.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/vendors/css/tables/datatable/datatables.min.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/vendors/css/extensions/toastr.css">
        <!-- END: Vendor CSS-->

        <!-- BEGIN: Theme CSS-->
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/bootstrap-extended.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/colors.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/components.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/themes/dark-layout.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/themes/semi-dark-layout.css">
        <!-- END: Theme CSS-->

        <!-- BEGIN: Page CSS-->
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/core/menu/menu-types/vertical-menu.css">
        <link rel="stylesheet" href="<?= base_url() ?>app-assets/alertifyjs/css/alertify.min.css"/>
        <link rel="stylesheet" href="<?= base_url() ?>app-assets/alertifyjs/css/themes/default.min.css"/>
        <link rel="stylesheet" href="<?= base_url() ?>app-assets/alertifyjs/css/themes/semantic.min.css"/>
        <link rel="stylesheet" href="<?= base_url() ?>app-assets/alertifyjs/css/themes/bootstrap.min.css"/>
        <link rel="stylesheet" href="<?= base_url() ?>app-assets/alertifyjs/css/alertify.rtl.min.css"/>
        <link rel="stylesheet" href="<?= base_url() ?>app-assets/alertifyjs/css/themes/default.rtl.min.css"/>
        <link rel="stylesheet" href="<?= base_url() ?>app-assets/alertifyjs/css/themes/semantic.rtl.min.css"/>
        <link rel="stylesheet" href="<?= base_url() ?>app-assets/alertifyjs/css/themes/bootstrap.rtl.min.css"/>
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/vendors/css/animate/animate.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>app-assets/sweetalert/dist/sweetalert2.min.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/css/plugins/extensions/toastr.css">
        <!-- END: Page CSS-->

        <!-- BEGIN: Custom CSS-->
        <link rel="stylesheet" href="<?= base_url() ?>app-assets/custom.css"/>
        <?php isset($cssExtra) ? $this->load->view($cssExtra) : ''; ?>
        <!-- END: Custom CSS-->
        <script>
            const appUrl = "<?= base_url() ?>";
            const apiUrl = "<?= base_url() ?>api";
        </script>
    </head>
    <!-- END: Head-->

    <!-- BEGIN: Body-->
    <body class="vertical-layout vertical-menu-modern 2-columns  navbar-sticky footer-static" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
        <div class="se-pre-con" style="display: none;">
            <div class="container_asb">
                <div class="vertical-center_asb">
                    <img src="<?= base_url() ?>app-assets/Preloader_3.gif">
                    <p id="text-loading">This may take some minutes.<br>Data sedang diproses.</p>
                </div>
            </div>
        </div>
        <!-- BEGIN: Header-->
        <div class="header-navbar-shadow"></div>
        <nav class="header-navbar main-header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top ">
            <div class="navbar-wrapper">
                <div class="navbar-container content">
                    <div class="navbar-collapse" id="navbar-mobile">
                        <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                            <ul class="nav navbar-nav">
                                <li class="nav-item text-center mobile-menu d-xl-none mr-auto">
                                    <a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#">
                                	    <i class="ficon bx bx-menu"></i><br>Menu
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav navbar-nav bookmark-icons mt-m-17">
                                <li class="nav-item" style="border-radius: 0.267rem;">
                                    <!-- <div id="content-mobile">
                                        <a class="btn btn-sm btn-warning" href="<?= base_url('app/v1/')?>" style="font-size: 18px; background-color: #FF5B5C !important; border-color: #ff2829 !important; padding: 0.467rem 0.8rem;">
                                            <?= $this->session->userdata('nama_sistem_SESS'); ?>
                                        </a>
                                    </div> -->
                                    <div id="content-desktop">
                                        <a class="btn btn-sm btn-warning" href="<?= base_url('app/v1/')?>" style="font-size: 18px; background-color: #FF5B5C !important; border-color: #ff2829 !important;">
                                            <i class="bx bx-home" style="top: 1px;"></i> <?= $this->session->userdata('nama_sistem_SESS'); ?>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <ul class="nav navbar-nav float-right">
                            <li class="dropdown dropdown-language nav-item" style="margin-right: 5px;">
                                <select class="select2 form-control basicSelect_bulan">
                                    <option selected="" hidden="" disabled="">Pilih Bulan</option>
                                    <?php 
                                        if(empty($this->session->userdata('bulan_SESS'))){
                                            $this->session->set_userdata('bulan_SESS', date('m'));
                                        }
                                        for ($i = 1; $i < 13; $i++) { 
                                            $bulan_id = $i;
                                            if (strlen($i) == 1) {
                                                $bulan_id = '0'.$i;
                                            } 
                                    ?>
                                            <option value="<?= $bulan_id?>" <?= ($this->session->userdata('bulan_SESS')==$bulan_id)? 'selected':''?>><?= get_nama_bulan($i) ?></option>
                                    <?php } ?>
                                </select>
                            </li>
                            <div id="content-desktop">
                                <li class="dropdown dropdown-language nav-item">
                                    <select class="select2 form-control" id="basicSelect">
                                        <option selected="" hidden="" disabled="">Pilih Tahun</option>
                                        <?php
                                            if(empty($this->session->userdata('tahun_SESS'))){
                                                $this->session->set_userdata('tahun_SESS', date('Y'));
                                            }
                                            $tahun[0] = [
                                                'tahun' => date('Y')
                                            ];
                                            foreach ($tahun as $row) { 
                                        ?>
                                                <option value="<?= $row['tahun']?>" <?= ($this->session->userdata('tahun_SESS')==$row['tahun'])? 'selected':''?>><?= $row['tahun']?></option>
                                        <?php } ?>
                                    </select>
                                </li>
                            </div>
                            <li class="nav-item d-none d-lg-block">
                                <a class="nav-link nav-link-expand">
                                    <i class="ficon bx bx-fullscreen"></i>
                                </a>
                            </li>
                            <li class="dropdown dropdown-user nav-item">
                                <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                    <div class="user-nav d-sm-flex d-none">
                                        <span class="user-name"><?php echo strtoupper($this->session->userdata('nama_user')) ?></span>
                                        <span class="user-status text-muted"><small><?php echo strtoupper($this->session->userdata('level_user')) ?></small></span>
                                    </div>
                                    <span><img class="round" src="<?= base_url() ?>app-assets/images/logo_paraga.jpg" alt="avatar" height="40" width="40"></span>
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
        <!-- END: Header-->