<?php $this->load->view('templates/user/header'); ?>
<?php foreach ($content as $row) : ?>

    <div class="app-content">
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="page-description">
                            <h1>Dashboard</h1>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card widget widget-stats">
                            <?php if ($invoice == true) {

                            ?>
                                <a href="<?php echo base_url('user/invoice/detail/' . $invoice[0]->code) ?>" style="text-decoration: none;">


                                    <div class="card-body">
                                        <div class="widget-stats-container d-flex">
                                            <div class="widget-stats-icon widget-stats-icon-primary">
                                                <i class="material-icons-outlined">receipt</i>
                                            </div>
                                            <div class="widget-stats-content flex-fill">
                                                <span class="widget-stats-title">Tagihan anda bulan ini</span>

                                                <span class="widget-stats-info"><strong>Rp <?= number_format($invoice[0]->price) ?></strong></span>

                                            </div>
                                        </div>
                                    </div>
                                </a>
                            <?php } else { ?>
                                <div class="card-body">
                                    <div class="widget-stats-container d-flex">
                                        <div class="widget-stats-icon widget-stats-icon-primary">
                                            <i class="material-icons-outlined">receipt</i>
                                        </div>
                                        <div class="widget-stats-content flex-fill">
                                            <span class="widget-stats-title">Tagihan anda bulan ini</span>


                                            <span class="widget-stats-info"><strong>Belum ada tagihan</strong></span>

                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card widget widget-stats">
                            <div class="card-body">
                                <div class="widget-stats-container d-flex">

                                    <div class="widget-stats-icon widget-stats-icon-success">
                                        <i class="material-icons-outlined">dns</i>
                                    </div>
                                    <div class="widget-stats-content flex-fill">
                                        <span class="widget-stats-title">Layanan anda</span>
                                        <span class="widget-stats-info"><?php echo $row->paket ?></span>

                                    </div>
                                    <div class="align-self-start">
                                        <?php
                                        if ($row->status == 'Active') {
                                            echo "<span class='btn btn-success'> Active</span>";
                                        } else if ($row->status == 'Isolir') {
                                            echo "<span class='btn btn-danger '>Isolir</span>";
                                        }
                                        ?> </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>

<?php $this->load->view('templates/user/footer'); ?>