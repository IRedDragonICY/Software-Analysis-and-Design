<?php $this->load->view('templates/admin/header'); ?>

<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Data Invoice </h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4">
                    <div class="card widget widget-stats">
                        <a href="<?php echo base_url('admin/invoice/home') ?>" style="text-decoration: none;">

                            <div class="card-body">
                                <div class="widget-stats-container d-flex">
                                    <div class="widget-stats-icon widget-stats-icon-danger">
                                        <i class="material-icons-outlined">home</i>
                                    </div>
                                    <div class="widget-stats-content flex-fill">
                                        <span class="widget-stats-title">Rumahan</span>
                                        <span class="widget-stats-amount"><?php echo $invoicehome ?> Invoice </span>


                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="card widget widget-stats">
                        <a href="<?php echo base_url('admin/invoice/member') ?>" style="text-decoration: none;">

                            <div class="card-body">
                                <div class="widget-stats-container d-flex">
                                    <div class="widget-stats-icon widget-stats-icon-success">
                                        <i class="material-icons-outlined">person</i>
                                    </div>
                                    <div class="widget-stats-content flex-fill">
                                        <span class="widget-stats-title">Member</span>
                                        <span class="widget-stats-amount"><?php echo $invoicemember ?> Invoice </span>


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