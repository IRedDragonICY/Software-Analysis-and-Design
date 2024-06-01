<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Aplikasi Tagihan RT/RW Net">
    <meta name="author" content="Badut">
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



    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/morris/morris.css">

    <!-- Theme Styles -->
    <link href="<?php echo base_url(); ?>assets/css/main.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/custom.css" rel="stylesheet">

    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url(); ?>assets/logo/<?= $logo ?>" />
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>assets/logo/<?= $logo ?>" />


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
                <a href="<?php echo base_url('admin/voucher'); ?>" class="logo-icon"><span class="logo-text"><?= $logotext ?></span></a>
                <div class="sidebar-user-switcher">
                    <a href="#">
                        <img src="<?php echo base_url(); ?>assets/images/avatars/profile.svg">
                        <span class="activity-indicator"></span>
                        <span class="user-info-text"><?php echo $this->session->userdata('nama'); ?><br><span class="user-state-info"><?php echo $this->session->userdata('level'); ?></span></span>
                    </a>
                </div>
            </div>
            <div class="app-menu">
                <ul class="accordion-menu">
                    <li class="sidebar-title">
                        Apps
                    </li>

                    <li class="<?= $title == 'Dashboard Voucher Wifi' ? 'active-page' : '' ?>">
                        <a href="<?php echo base_url(); ?>admin/voucher">
                            <i class="material-icons-two-tone">dashboard</i>Dashboard
                        </a>
                    </li>

                    <li class="<?= $title == 'Users List' | $title == 'Generate Voucher' | $title == 'Add User Profile' | $title == 'Profile List' | $title == 'Edit Profile' ? 'active-page' : '' ?>">
                        <a href=""><i class="material-icons-two-tone">wifi</i>Hotspot<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                        <ul class="sub-menu">
                            <li class="<?= $title == 'Users List' | $title == 'Generate Voucher' ? 'active-page' : '' ?>"> <a href=""> Users<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                                <ul class="sub-menu">
                                    <li>
                                        <a href="<?php echo base_url(); ?>admin/voucher/hotspot/user" class="<?= $title == 'Users List' ? 'active' : '' ?>">Users List</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>admin/voucher/hotspot/generate" class="<?= $title == 'Generate Voucher' ? 'active' : '' ?>">Generate Voucher</a>
                                    </li>
                                </ul>
                            </li>

                            <li class="<?= $title == 'Add User Profile' |  $title == 'Profile List' | $title == 'Edit Profile'  ? 'active-page' : '' ?>">
                                <a href=""> Profile<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                                <ul class="sub-menu">
                                    <li>
                                        <a href="<?php echo base_url(); ?>admin/voucher/hotspot/profile" class="<?= $title == 'Profile List' | $title == 'Edit Profile' ? 'active' : '' ?>">Profile List</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>admin/voucher/hotspot/addprofile" class="<?= $title == 'Add User Profile' ? 'active' : '' ?>">Add Profile</a>
                                    </li>

                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="<?= $title == 'Logs Voucher' ? 'active-page' : '' ?>">
                        <a href="<?php echo base_url(); ?>admin/voucher/logs">
                            <i class="material-icons-two-tone">history</i>Logs Voucher
                        </a>
                    </li>
                    <li class="<?= $title == 'Report Voucher' ? 'active-page' : '' ?>">
                        <a href="<?php echo base_url(); ?>admin/voucher/report">
                            <i class="material-icons-two-tone">menu_book</i>Report Voucher
                        </a>
                    </li>



                    <li>
                        <a href="#">
                            <i class="material-icons-two-tone">edit</i>Template Editor
                        </a>
                    </li>

                    <li class="<?= $title == 'Backup Voucher Cloud' ? 'active-page' : '' ?>">
                        <a href="#">
                            <i class="material-icons-two-tone">backup</i>Backup Voucher
                        </a>
                    </li>
                    <li class="<?= $title == 'Setting Voucher' ? 'active-page' : '' ?>">
                        <a href="<?php echo base_url(); ?>admin/voucher/setting">
                            <i class="material-icons-two-tone">settings</i>Pengaturan
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>admin"><i class="material-icons-two-tone">arrow_back</i>Kembali</a>
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