<?php $this->load->view('templates/reseller/header'); ?>
<?php foreach ($content as $row) : ?>

    <div class="app-content">
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="page-description">
                            <h1>Dashboard Reseller</h1>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4">
                        <div class="card widget widget-stats">

                            <div class="card-body">
                                <div class="widget-stats-container d-flex">
                                    <div class="widget-stats-icon widget-stats-icon-primary">
                                        <i class="material-icons-outlined">shopping_cart</i>
                                    </div>
                                    <div class="widget-stats-content flex-fill">
                                        <span class="widget-stats-title">Total pembelian voucher</span>
                                        <span class="widget-stats-info"> <?= $totalorder ?> Voucher </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card widget widget-stats">

                            <div class="card-body">
                                <div class="widget-stats-container d-flex">
                                    <div class="widget-stats-icon widget-stats-icon-success">
                                        <i class="material-icons-outlined">payments</i>
                                    </div>
                                    <div class="widget-stats-content flex-fill">
                                        <span class="widget-stats-title">Total semua pendapatan</span>

                                        <span class="widget-stats-info">Rp <?= number_format($totalincome) ?> </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card widget widget-stats">

                            <div class="card-body">
                                <div class="widget-stats-container d-flex">
                                    <div class="widget-stats-icon widget-stats-icon-warning">
                                        <i class="material-icons-outlined">shopping_cart</i>
                                    </div>
                                    <div class="widget-stats-content flex-fill">
                                        <span class="widget-stats-title">Pembelian hari ini</span>
                                        <span class="widget-stats-info"> Rp <?= number_format($ordertoday) ?> ( <?php echo $voctoday; ?> Voucher ) </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card widget widget-stats">

                            <div class="card-body">
                                <div class="widget-stats-container d-flex">
                                    <div class="widget-stats-icon widget-stats-icon-danger">
                                        <i class="material-icons-outlined">shopping_cart</i>
                                    </div>
                                    <div class="widget-stats-content flex-fill">
                                        <span class="widget-stats-title">Pembelian kemarin</span>
                                        <span class="widget-stats-info">Rp <?= number_format($orderyesterday) ?> ( <?php echo $vocyesterday; ?> Voucher )</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card widget widget-stats">

                            <div class="card-body">
                                <div class="widget-stats-container d-flex">
                                    <div class="widget-stats-icon widget-stats-icon-primary">
                                        <i class="material-icons-outlined">calendar_month</i>
                                    </div>
                                    <div class="widget-stats-content flex-fill">
                                        <span class="widget-stats-title">Total pendapatan bersih bulan ini</span>
                                        <?php

                                        $komisi = $row->komisi;

                                        $harga = $profitmonth;

                                        $hitungprofit = $harga * $komisi / 100;


                                        ?>
                                        <span class="widget-stats-info">Rp <?= number_format($hitungprofit) ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card widget widget-stats">

                            <div class="card-body">
                                <div class="widget-stats-container d-flex">
                                    <div class="widget-stats-icon widget-stats-icon-success">
                                        <i class="material-icons-outlined">shopping_cart</i>
                                    </div>
                                    <div class="widget-stats-content flex-fill">
                                        <span class="widget-stats-title">Total pendapatan bersih bulan kemarin</span>
                                        <?php

                                        $komisi = $row->komisi;

                                        $harga = $profitprevmonth;

                                        $hitungprofitprevmonth = $harga * $komisi / 100;


                                        ?>

                                        <span class="widget-stats-info">Rp <?= number_format($hitungprofitprevmonth) ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12">
                        <div class="card widget widget-stats">

                            <div class="card-body">
                                <div class="widget-stats-container d-flex">
                                    <div class="widget-stats-icon widget-stats-icon-success">
                                        <i class="material-icons-outlined">account_balance</i>
                                    </div>
                                    <div class="widget-stats-content flex-fill">
                                        <span class="widget-stats-title">Saldo anda</span>
                                        <span class="widget-stats-info">Rp <?php echo number_format($row->balance) ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>

<?php $this->load->view('templates/reseller/footer'); ?>