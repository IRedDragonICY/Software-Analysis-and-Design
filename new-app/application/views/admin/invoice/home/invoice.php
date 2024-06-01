<?php $this->load->view('templates/admin/header'); ?>

<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Invoice Rumahan </h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4">
                    <div class="card widget widget-stats">
                        <a href="<?php echo base_url('admin/invoice/home/prevmonth') ?>" style="text-decoration: none;">

                            <div class="card-body">
                                <div class="widget-stats-container d-flex">
                                    <div class="widget-stats-icon widget-stats-icon-danger">
                                        <i class="material-icons-outlined">article</i>
                                    </div>
                                    <div class="widget-stats-content flex-fill">
                                        <span class="widget-stats-title">Invoice Bulan Kemarin</span>
                                        <span class="widget-stats-info"><?php echo $prevmonthpaid ?> Pembayaran ( Sudah Terbayar ) </span>
                                        <span class="widget-stats-info"><?php echo $prevmonthunpaid ?> Pembayaran ( Belum Terbayar )</span>

                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="card widget widget-stats">
                        <a href="<?php echo base_url('admin/invoice/home/thismonth') ?>" style="text-decoration: none;">

                            <div class="card-body">
                                <div class="widget-stats-container d-flex">
                                    <div class="widget-stats-icon widget-stats-icon-primary">
                                        <i class="material-icons-outlined">article</i>
                                    </div>
                                    <div class="widget-stats-content flex-fill">
                                        <span class="widget-stats-title">Invoice Bulan ini</span>
                                        <span class="widget-stats-info"><?php echo $totalmonthpaid ?> Pembayaran ( Sudah Terbayar ) </span>
                                        <span class="widget-stats-info"><?php echo $totalmonthunpaid ?> Pembayaran ( Belum Terbayar )</span>

                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="card widget widget-stats">
                        <a href="<?php echo base_url('admin/invoice/home/allinvoice') ?>" style="text-decoration: none;">

                            <div class="card-body">
                                <div class="widget-stats-container d-flex">
                                    <div class="widget-stats-icon widget-stats-icon-success">
                                        <i class="material-icons-outlined">article</i>
                                    </div>
                                    <div class="widget-stats-content flex-fill">
                                        <span class="widget-stats-title">Semua Data Invoice</span>
                                        <span class="widget-stats-info"><?php echo $paid  ?> Pembayaran ( Sudah Terbayar )</span>
                                        <span class="widget-stats-info"><?php echo $unpaid ?> Pembayaran ( Belum Terbayar )</span>
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