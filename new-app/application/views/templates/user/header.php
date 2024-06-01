<!DOCTYPE html>
<html translate="no">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Aplikasi Tagihan RT/RW Net">
    <meta name="author" content="Adi Darmawan">
    <!-- The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title><?php echo $title; ?></title>

    <!-- Styles -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/plugins/pace/pace.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/plugins/datatables/datatables.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/plugins/flatpickr/flatpickr.min.css" rel="stylesheet">




    <!-- Theme Styles -->
    <link href="<?php echo base_url(); ?>assets/css/main.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/custom.css" rel="stylesheet">

    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url(); ?>assets/logo/logo-220730-3dbccd89ca.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>assets/logo/logo-220730-3dbccd89ca.png" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <div class="app align-content-stretch d-flex flex-wrap">
        <div class="app-sidebar">
            <div class="logo">
                <a href="<?php echo base_url('user'); ?>" class="logo-icon"><span class="logo-text">FDN</span></a>
                <div class="sidebar-user-switcher">
                    <a href="#">
                        <img src="<?php echo base_url(); ?>assets/images/avatars/profile.svg">
                        <span class="activity-indicator"></span>
                        <span class="user-info-text"><?php echo $this->session->userdata('idpel'); ?><br><span class="user-state-info"><?php echo $this->session->userdata('level'); ?></span></span>
                    </a>
                </div>
            </div>
            <div class="app-menu">
                <ul class="accordion-menu">
                    <li class="sidebar-title">
                        Apps
                    </li>

                    <li class="<?= $title == 'Dashboard' ? 'active-page' : '' ?>">
                        <a href="<?php echo base_url(); ?>user">
                            <i class="material-icons-two-tone">dashboard</i>Dashboard
                        </a>
                    </li>

                    <li class="<?= $title == 'Layanan Anda' ? 'active-page' : '' ?>">
                        <a href="<?php echo base_url(); ?>user/service"><i class="material-icons-two-tone">dns</i>Cek
                            Layanan</a>
                    </li>

                    <li class="<?= $title == 'Data Invoice' | $title == 'Semua Data Invoice' ? 'active-page' : '' ?>">
                        <a href=""><i class="material-icons-two-tone">receipt</i>Invoice<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                        <ul class="sub-menu">
                            <li><a href="<?php echo base_url(); ?>user/invoice" class="<?= $title == 'Data Invoice' ? 'active' : '' ?>">Data Invoice</a></li>
                            <li><a href="<?php echo base_url(); ?>user/invoice/list" class="<?= $title == 'Semua Data Invoice' ? 'active' : '' ?>">Lihat semua data</a></li>
                        </ul>
                    </li>


                    <li class="<?= $title == 'Tiket' ? 'active-page' : '' ?>">
                        <a href="<?php echo base_url(); ?>user/ticket"><i class="material-icons-two-tone">email</i>Tiket</a>
                    </li>


                    <li class="<?= $title == 'Pengaturan Akun' | $title == 'Ganti Password' ? 'active-page' : '' ?>">
                        <a href=""><i class="material-icons-two-tone">settings</i>Pengaturan<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                        <ul class="sub-menu">
                            <li>
                                <a href="<?php echo base_url(); ?>user/account" class="<?= $title == 'Pengaturan Akun' | $title == 'Ganti Password' ? 'active' : '' ?>">Akun</a>
                            </li>

                        </ul>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>auth/signout"><i class="material-icons-two-tone">logout</i>Keluar</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="app-container">

            <div class="app-header">
                <nav class="navbar navbar-light navbar-expand-lg">
                    <div class="container-fluid">
                        <div class="navbar-nav" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link hide-sidebar-toggle-button" href="#"><i class="material-icons">first_page</i></a>
                                </li>
                            </ul>

                        </div>
                        <div class="d-flex">
                            <ul class="navbar-nav">



                            </ul>
                        </div>
                    </div>
                </nav>
            </div>