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
                <a href="<?php echo base_url('admin/router'); ?>" class="logo-icon"><span class="logo-text"><?= $logotext ?></span></a>
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




                    <li class="<?= $title == 'Dashboard Mikrotik' ? 'active-page' : '' ?>">
                        <a href="<?php echo base_url(); ?>admin/router">
                            <i class="material-icons-two-tone">dashboard</i>Dashboard
                        </a>
                    </li>



                    <li class="<?= $title == 'Hotspot Users' | $title == 'Hotspot Add User' | $title == 'Hotspot Active' ? 'active-page' : '' ?>">
                        <a href=""><i class="material-icons-two-tone">wifi</i>Hotspot<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                        <ul class="sub-menu">
                            <li class="<?= $title == 'Hotspot Users' | $title == 'Hotspot Add User' | $title == 'Hotspot Active' ? 'active-page' : '' ?>">
                                <a href=""> Users<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                                <ul class="sub-menu">
                                    <li>
                                        <a href="<?php echo base_url(); ?>admin/router/hotspot/users" class="<?= $title == 'Hotspot Users' ? 'active' : '' ?>">Users List</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>admin/router/hotspot/adduser" class="<?= $title == 'Hotspot Add User' ? 'active' : '' ?>">Add User</a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="<?php echo base_url(); ?>admin/router/hotspot/active" class="<?= $title == 'Hotspot Active' ? 'active' : '' ?>">Hotspot Active</a>
                            </li>

                        </ul>
                    </li>

                    <li class="<?= $title == 'PPP Profile' | $title == 'PPP Secret' | $title == 'PPP Active' ? 'active-page' : '' ?>">
                        <a href=""><i class="material-icons-two-tone">rocket_launch</i>PPP<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                        <ul class="sub-menu">
                            <li>
                                <a href="<?php echo base_url(); ?>admin/router/ppp/profile" class="<?= $title == 'PPP Profile' ? 'active' : '' ?>">Profile</a>
                                <a href="<?php echo base_url(); ?>admin/router/ppp/secret" class="<?= $title == 'PPP Secret' ? 'active' : '' ?>">Secret</a>
                                <a href="<?php echo base_url(); ?>admin/router/ppp/active" class="<?= $title == 'PPP Active' ? 'active' : '' ?>">Active</a>
                            </li>
                        </ul>
                    </li>

                    <li class="<?= $title == 'Pengaturan Router' ? 'active-page' : '' ?>">
                        <a href="<?php echo base_url(); ?>admin/router/setting">
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
                                <li class="nav-item hidden-on-mobile">
                                    <a class="nav-link active" href="#">Applications</a>
                                </li>

                                <li class="nav-item hidden-on-mobile">
                                    <a class="nav-link nav-notifications-toggle" id="notificationsDropDown" href="#" data-bs-toggle="dropdown"><i class="material-icons-outlined">notifications</i></a>
                                    <div class="dropdown-menu dropdown-menu-end notifications-dropdown" aria-labelledby="notificationsDropDown">
                                        <h6 class="dropdown-header">Notifications</h6>
                                        <div class="notifications-dropdown-list">
                                            <a href="#">
                                                <div class="notifications-dropdown-item">
                                                    <div class="notifications-dropdown-item-image">
                                                        <span class="notifications-badge bg-info text-white">
                                                            <i class="material-icons-outlined">campaign</i>
                                                        </span>
                                                    </div>
                                                    <div class="notifications-dropdown-item-text">
                                                        <p class="bold-notifications-text">Donec tempus nisi sed erat
                                                            vestibulum, eu suscipit ex laoreet</p>
                                                        <small>19:00</small>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#">
                                                <div class="notifications-dropdown-item">
                                                    <div class="notifications-dropdown-item-image">
                                                        <span class="notifications-badge bg-danger text-white">
                                                            <i class="material-icons-outlined">bolt</i>
                                                        </span>
                                                    </div>
                                                    <div class="notifications-dropdown-item-text">
                                                        <p class="bold-notifications-text">Quisque ligula dui, tincidunt
                                                            nec pharetra eu, fringilla quis mauris</p>
                                                        <small>18:00</small>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#">
                                                <div class="notifications-dropdown-item">
                                                    <div class="notifications-dropdown-item-image">
                                                        <span class="notifications-badge bg-success text-white">
                                                            <i class="material-icons-outlined">alternate_email</i>
                                                        </span>
                                                    </div>
                                                    <div class="notifications-dropdown-item-text">
                                                        <p>Nulla id libero mattis justo euismod congue in et metus</p>
                                                        <small>yesterday</small>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#">
                                                <div class="notifications-dropdown-item">
                                                    <div class="notifications-dropdown-item-image">
                                                        <span class="notifications-badge">
                                                            <img src="<?php echo base_url(); ?>assets/images/avatars/avatar.png" alt="">
                                                        </span>
                                                    </div>
                                                    <div class="notifications-dropdown-item-text">
                                                        <p>Praesent sodales lobortis velit ac pellentesque</p>
                                                        <small>yesterday</small>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#">
                                                <div class="notifications-dropdown-item">
                                                    <div class="notifications-dropdown-item-image">
                                                        <span class="notifications-badge">
                                                            <img src="<?php echo base_url(); ?>assets/images/avatars/avatar.png" alt="">
                                                        </span>
                                                    </div>
                                                    <div class="notifications-dropdown-item-text">
                                                        <p>Praesent lacinia ante eget tristique mattis. Nam sollicitudin
                                                            velit sit amet auctor porta</p>
                                                        <small>yesterday</small>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>