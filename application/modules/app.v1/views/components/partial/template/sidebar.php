<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed <?= $this->session->userdata('dark_mode_SESS') == 'dark'?'menu-dark':'menu-light' ?> menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
                <a class="navbar-brand" href="#">
                    <img src="<?= base_url() ?>app-assets/images/logo_paraga.jpg" style="width: 30px">
                    <h2 class="brand-text mb-0" style="color: #FF5B5C !important">PARAGA</h2>
                </a>
            </li>
            <li class="nav-item nav-toggle">
                <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
                    <i class="bx bx-x d-block d-xl-none font-medium-4 danger"></i>
                    <i class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block danger" data-ticon="bx-disc"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="lines">
            <li class=" navigation-header">
                <span>MENU</span>
            </li>
            <?= load_menu() ?>
        </ul>
    </div>
</div>
<!-- END: Main Menu-->

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-12 mb-2 mt-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h5 class="content-header-title float-left pr-1 mb-0"><?= @$_title?></h5>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb p-0 mb-0">
                                <li class="breadcrumb-item">
                                    <a href="#"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active" style="color: #FF5B5C !important;"><?= empty($_sub_title)?@$_title:@$_sub_title ?>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section id="font-livicons">