<?php $this->load->view('templates/member/header'); ?>
<?php foreach ($content as $row) : ?>

    <div class="app-content">
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="page-description">
                            <h1>Dashboard </h1>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="card widget widget-stats">
                            <a href="<?php echo base_url('member/topup') ?>" style="text-decoration: none;">

                                <div class="card-body">
                                    <div class="widget-stats-container d-flex">
                                        <div class="widget-stats-icon widget-stats-icon-primary">
                                            <i class="material-icons-outlined">credit_card</i>
                                        </div>
                                        <div class="widget-stats-content flex-fill">
                                            <span class="widget-stats-title">Saldo</span>
                                            <span class="widget-stats-info">Rp <?php echo number_format($row->balance) ?> </span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card widget widget-stats">
                            <a href="<?php echo base_url('member/history/order') ?>" style="text-decoration: none;">

                                <div class="card-body">
                                    <div class="widget-stats-container d-flex">
                                        <div class="widget-stats-icon widget-stats-icon-success">
                                            <i class="material-icons-outlined">shopping_cart</i>
                                        </div>
                                        <div class="widget-stats-content flex-fill">
                                            <span class="widget-stats-title">Total Pembelian</span>
                                            <span class="widget-stats-info"> <?php echo $total; ?> Voucher</span>
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
<?php endforeach ?>

<?php $this->load->view('templates/member/footer'); ?>