<?php $this->load->view('templates/admin/header'); ?>
<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Laporan Keuangan Per Bulan</h1>
                    </div>
                </div>
            </div>
            <!-- end row -->
            <div class="row">
                <div class="col-xl-4">
                    <div class="card widget widget-stats">
                        <a href="<?php echo base_url('admin/report/masuk') ?>" style="text-decoration: none;">

                            <div class="card-body">
                                <div class="widget-stats-container d-flex">
                                    <div class="widget-stats-icon widget-stats-icon-success">
                                        <i class="material-icons-outlined">payment</i>
                                    </div>
                                    <div class="widget-stats-content flex-fill">
                                        <span class="widget-stats-title">Pemasukan Pelanggan Bulanan </span>
                                        <span class="widget-stats-info">Rp <?php echo number_format($credit); ?> </span>
                                    </div>
                                </div>
                            </div>
                        </a>

                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card widget widget-stats">
                        <a href="<?php echo base_url('admin/report/keluar') ?>" style="text-decoration: none;">

                            <div class="card-body">
                                <div class="widget-stats-container d-flex">
                                    <div class="widget-stats-icon widget-stats-icon-danger">
                                        <i class="material-icons-outlined">payment</i>
                                    </div>
                                    <div class="widget-stats-content flex-fill">
                                        <span class="widget-stats-title">Pengeluaran </span>
                                        <span class="widget-stats-info">Rp <?php echo number_format($debit);  ?></span>
                                    </div>
                                </div>
                            </div>
                        </a>

                    </div>
                </div>


                <div class="col-xl-4">
                    <div class="card widget widget-stats">
                        <a href="<?php echo base_url('admin/report/psb') ?>" style="text-decoration: none;">
                            <div class="card-body">
                                <div class="widget-stats-container d-flex">
                                    <div class="widget-stats-icon widget-stats-icon-primary">
                                        <i class="material-icons-outlined">payment</i>
                                    </div>
                                    <div class="widget-stats-content flex-fill">
                                        <span class="widget-stats-title">Pemasukan Pemasangan Baru</span>
                                        <span class="widget-stats-info">Rp <?= number_format($psb) ?></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-xl-12">
                    <div class="card widget widget-stats">
                        <div class="card-body">
                            <div class="widget-stats-container d-flex">
                                <div class="widget-stats-icon widget-stats-icon-primary">
                                    <i class="material-icons-outlined">payment</i>
                                </div>
                                <div class="widget-stats-content flex-fill">
                                    <span class="widget-stats-title">Total Pendapatan Bersih</span>
                                    <span class="widget-stats-info">Rp <?php echo number_format($bersih); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- end row -->
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('templates/admin/footer'); ?>