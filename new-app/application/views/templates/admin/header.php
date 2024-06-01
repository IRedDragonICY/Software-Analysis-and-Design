<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Aplikasi Tagihan RT/RW Net">
    <meta name="author" content="<?= $author ?> ">
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

    <link href="<?php echo base_url(); ?>assets/plugins/select2/css/select2.min.css" rel="stylesheet">



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
                <a href="<?php echo base_url('admin'); ?>" class="logo-icon"><span class="logo-text"><?= $logotext ?></span></a>
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

                    <li class="<?= $title == 'Dashboard Admin' ? 'active-page' : '' ?>">
                        <a href="<?php echo base_url(); ?>admin">
                            <i class="material-icons-two-tone">dashboard</i>Dashboard
                        </a>
                    </li>

                    <li class="<?= $title == 'Data Rumahan' | $title == 'Data Member' | $title == 'Data Reseller' ? 'active-page' : '' ?>">
                        <a href=""><i class="material-icons-two-tone">contacts</i>Data Pelanggan<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                        <ul class="sub-menu">
                            <li>
                                <a href="<?php echo base_url(); ?>admin/customer" class="<?= $title == 'Data Rumahan' ? 'active' : '' ?>">Rumahan</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>admin/customer/member" class="<?= $title == 'Data Member' ? 'active' : '' ?>">Member</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>admin/customer/reseller" class="<?= $title == 'Data Reseller' ? 'active' : '' ?>">Reseller Voucher</a>
                            </li>

                        </ul>
                    </li>

                    <li class="<?= $title == 'Paket Layanan' ? 'active-page' : '' ?>">
                        <a href="<?php echo base_url(); ?>admin/customer/service"><i class="material-icons-two-tone">person_add</i>Input
                            Pelanggan Baru</a>
                    </li>


                    <li class="<?= $title == 'Data Layanan' ? 'active-page' : '' ?>">
                        <a href="<?php echo base_url(); ?>admin/services"><i class="material-icons-two-tone">storage</i>Data Layanan</a>
                    </li>


                    <li class="<?= $title == 'Data Invoice' | $title == 'Invoice Rumahan' | $title == 'Invoice Member' | $title == 'Laporan Keuangan' | $title == 'Generate Manual Invoice' ? 'active-page' : '' ?>">
                        <a href=""><i class="material-icons-two-tone">account_balance</i>Finansial<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                        <ul class="sub-menu">
                            <li>
                                <a href="<?php echo base_url(); ?>admin/invoice/generate" class="<?= $title == 'Generate Manual Invoice'  ? 'active' : '' ?>">Generate Manual Invoice</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>admin/invoice" class="<?= $title == 'Data Invoice' | $title == 'Invoice Rumahan' | $title == 'Invoice Member' ? 'active' : '' ?>">Data Invoice</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>admin/report" class="<?= $title == 'Laporan Keuangan' ? 'active' : '' ?>">Laporan Keuangan</a>
                            </li>

                        </ul>
                    </li>
                    <li class="<?= $title == 'Data Tiket' ? 'active-page' : '' ?>">
                        <a href="<?php echo base_url(); ?>admin/ticket"><i class="material-icons-two-tone">email</i>Tiket</a>
                    </li>


                    <li class="<?= $title == 'Kirim Informasi' ? 'active-page' : '' ?>">
                        <a href="<?php echo base_url(); ?>admin/infouser"><i class="material-icons-two-tone">notifications</i>Kirim Informasi</a>
                    </li>

                    <li class="<?= $title == 'Catatan' ? 'active-page' : '' ?>">
                        <a href="<?php echo base_url(); ?>admin/note"><i class="material-icons-two-tone">sticky_note_2</i>Catatan</a>
                    </li>

                    <li class="<?= $title == 'Pengaturan Akun' | $title == 'Pengaturan Company' | $title == 'Metode Pembayaran' || $title == 'Tambah User' || $title == 'Payment Gateway' || $title == 'SMTP Mail' || $title == 'Bot Telegram' || $title == 'Pengaturan Website' || $title == 'Pengaturan Whatsapp Gateway' | $title == 'Ganti Password' ? 'active-page' : '' ?>">
                        <a href=""><i class="material-icons-two-tone">settings</i>Pengaturan<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                        <ul class="sub-menu">
                            <li>
                                <a href="<?php echo base_url(); ?>admin/account" class="<?= $title == 'Pengaturan Akun' | $title == 'Ganti Password' ? 'active' : '' ?>">Akun</a>
                                <?php
                                if ($this->session->userdata('level') === 'developer') {
                                ?>

                                    <a href="<?php echo base_url(); ?>admin/website" class="<?= $title == 'Pengaturan Website' | $title == 'Pengaturan Website' ? 'active' : '' ?>">Website</a>
                                    <a href="<?php echo base_url(); ?>admin/smtp" class="<?= $title == 'SMTP Mail' | $title == 'SMTP Mail' ? 'active' : '' ?>">SMTP
                                        Mail</a>
                                    <a href="<?php echo base_url(); ?>admin/company" class="<?= $title == 'Pengaturan Company' | $title == 'Pengaturan Company' ? 'active' : '' ?>">Company</a>
                                <?php } ?>
                                <a href="<?php echo base_url(); ?>admin/tambahuser" class="<?= $title == 'Tambah User' | $title == 'Tambah User' ? 'active' : '' ?>">Tambah
                                    User</a>
                                <?php if ($this->session->userdata('level') === 'developer') {
                                ?>
                                    <a href="#" class="<?= $title == 'Bot Telegram' | $title == 'Bot Telegram' ? 'active' : '' ?>">Bot
                                        Telegram</a>
                                    <a href="<?php echo base_url(); ?>admin/payment" class="<?= $title == 'Metode Pembayaran' | $title == 'Payment Gateway' ? 'active' : '' ?>">Payment Gateway</a>

                                    <a href="<?php echo base_url(); ?>admin/whatsapp" class="<?= $title == 'Pengaturan Whatsapp Gateway' | $title == 'Pengaturan Whatsapp Gateway' ? 'active' : '' ?>">Whatsapp
                                        Gateway</a>
                                <?php } ?>


                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>admin/voucher"><i class="material-icons-two-tone">wifi</i>Voucher Hotspot</a>
                    </li>
                    <?php

                    if ($this->session->userdata('level') === 'developer') {
                    ?>
                        <li>
                            <a href="<?php echo base_url(); ?>admin/router"><i class="material-icons-two-tone">dns</i>Mikrotik</a>
                        </li>
                    <?php } ?>
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