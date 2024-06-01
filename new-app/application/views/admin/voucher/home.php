<?php $this->load->view('templates/voucher/header'); ?>

<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Dashboard Voucher Wifi </h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4">
                    <div class="card widget widget-stats">

                        <div class="card-body">
                            <div class="widget-stats-container d-flex">
                                <div class="widget-stats-icon widget-stats-icon-primary">
                                    <i class="material-icons-outlined">credit_card</i>
                                </div>
                                <div class="widget-stats-content flex-fill">
                                    <span class="widget-stats-title">Penggunaan Voucher Hari Ini</span>
                                    <span class="widget-stats-info"><?= $vcrtoday ?> Voucher </span>
                                    <span class="widget-stats-info">Rp <?php echo number_format($today); ?> </span>

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
                                    <i class="material-icons-outlined">credit_card</i>
                                </div>
                                <div class="widget-stats-content flex-fill">
                                    <span class="widget-stats-title">Penggunaan Voucher Kemarin</span>
                                    <span class="widget-stats-info"><?= $vcrystrdy ?> Voucher</span>
                                    <span class="widget-stats-info">Rp <?php echo number_format($yesterday); ?> </span>

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
                                    <i class="material-icons-outlined">credit_card</i>
                                </div>
                                <div class="widget-stats-content flex-fill">
                                    <span class="widget-stats-title">Penggunaan Voucher Bulan ini</span>
                                    <span class="widget-stats-info"><?= $vcrmonth ?> Voucher </span>
                                    <span class="widget-stats-info">Rp <?php echo number_format($month); ?> </span>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Penggunaan Voucher Wifi</h5>
                        </div>

                        <div class="card-body">
                            <div id="graph"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script type="text/javascript">
    <?php
    $lastweek = date('Y-m-d', strtotime('-30 days', strtotime(date("Y-m-d"))));

    function ambil($table, $limit)
    {
        $ci = &get_instance();

        $checkdata = $ci->db->query("SELECT * FROM " . $table . " WHERE " . $limit);
        $countdata = $checkdata->num_rows();
        return $countdata;
    }


    ?>

    $(function() {
        new Morris.Line({
            element: 'graph',
            data: [
                <?php for ($i = 1; $i <= 30; $i++) {
                    $orderdate = date('Y-m-d', strtotime('+' . $i . 'days', strtotime($lastweek)));
                    $line = $orderdate;
                    $pemesanan = ambil('logs_voucher', "date = '$orderdate'");


                ?> {
                        y: '<?php echo $orderdate; ?>',
                        Penggunaan: <?php echo $pemesanan; ?>,

                    },
                <?php
                }
                ?>
            ],
            xkey: 'y',
            ykeys: ['Penggunaan'],
            labels: ['Total Penggunaan'],
            lineColors: ['#2196f3'],
            hideHover: 'auto',
            resize: true
        });
    });
</script>

<?php $this->load->view('templates/voucher/footer'); ?>