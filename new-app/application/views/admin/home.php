<?php $this->load->view('templates/admin/header'); ?>

<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Dashboard Admin </h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4">
                    <div class="card widget widget-stats">
                        <a href="<?php echo base_url('admin/customer') ?>" style="text-decoration: none;">

                            <div class="card-body">
                                <div class="widget-stats-container d-flex">
                                    <div class="widget-stats-icon widget-stats-icon-primary">
                                        <i class="material-icons-outlined">person</i>
                                    </div>
                                    <div class="widget-stats-content flex-fill">
                                        <span class="widget-stats-title">Pelanggan</span>
                                        <span class="widget-stats-info">Total <?php echo $this->db->count_all('customer') ?> Pelanggan </span>
                                        <span class="widget-stats-info"> <span class="badge badge-success">
                                                <?php echo $useraktif ?> Pelanggan Aktif </span> </span>


                                        <span class="widget-stats-info"> <span class="badge badge-warning"> <?php echo $userisolir ?> Pelanggan Isolir </span> </span>
                                        <span class="widget-stats-info"><span class="badge badge-danger"> <?php echo $usersend ?> Pelanggan Berhenti </span> </span>

                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="card widget widget-stats">
                        <a href="<?php echo base_url('admin/invoice') ?>" style="text-decoration: none;">

                            <div class="card-body">
                                <div class="widget-stats-container d-flex">
                                    <div class="widget-stats-icon widget-stats-icon-success">
                                        <i class="material-icons-outlined">article</i>
                                    </div>
                                    <div class="widget-stats-content flex-fill">
                                        <span class="widget-stats-title">Invoice</span>
                                        <span class="widget-stats-info">Total <?php echo $this->db->count_all('invoice') ?> Invoice </span>

                                        <span class="widget-stats-info"><span class="badge badge-success"><?php echo $paid  ?> Invoice Terbayar </span></span>
                                        <span class="widget-stats-info"><span class="badge badge-danger"> <?php echo $unpaid ?> Invoice Belum Terbayar </span></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="card widget widget-stats">
                        <a href="<?php echo base_url('admin/ticket') ?>" style="text-decoration: none;">

                            <div class="card-body">
                                <div class="widget-stats-container d-flex">
                                    <div class="widget-stats-icon widget-stats-icon-danger">
                                        <i class="material-icons-outlined">email</i>
                                    </div>
                                    <div class="widget-stats-content flex-fill">
                                        <span class="widget-stats-title">Tiket</span>
                                        <span class="widget-stats-info">Total <?php echo $this->db->count_all('tickets') ?> Tiket </span>
                                        <span class="widget-stats-info"><span class="badge badge-success"><?php echo $close; ?> Tiket Selesai </span></span>
                                        <span class="widget-stats-info"><span class="badge badge-warning"><?php echo $pending; ?> Tiket Pending </span></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="card widget widget-stats">
                        <a href="<?php echo base_url('admin/customer/member') ?>" style="text-decoration: none;">

                            <div class="card-body">
                                <div class="widget-stats-container d-flex">
                                    <div class="widget-stats-icon widget-stats-icon-success">
                                        <i class="material-icons-outlined">groups</i>
                                    </div>
                                    <div class="widget-stats-content flex-fill">
                                        <span class="widget-stats-title">Member</span>
                                        <span class="widget-stats-info">Total <?php echo $members ?> Member </span>

                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="card widget widget-stats">
                        <a href="<?php echo base_url('admin/customer/reseller') ?>" style="text-decoration: none;">

                            <div class="card-body">
                                <div class="widget-stats-container d-flex">
                                    <div class="widget-stats-icon widget-stats-icon-info">
                                        <i class="material-icons-outlined">group</i>
                                    </div>
                                    <div class="widget-stats-content flex-fill">
                                        <span class="widget-stats-title">Reseller</span>
                                        <span class="widget-stats-info">Total <?php echo $reseller ?> Reseller </span>

                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('templates/admin/footer'); ?>