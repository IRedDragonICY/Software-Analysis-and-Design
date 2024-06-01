<?php $this->load->view('templates/voucher/header'); ?>
<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Report Bulan <?php echo $subtitle ?> Tahun <?= $tahun ?></h1>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <!-- end row -->
            <div class="row">
                <div class="col-xl-4">
                    <div class="card widget widget-stats">

                        <div class="card-body">
                            <div class="widget-stats-container d-flex">
                                <div class="widget-stats-icon widget-stats-icon-primary">
                                    <i class="material-icons-outlined">payment</i>
                                </div>
                                <div class="widget-stats-content flex-fill">
                                    <span class="widget-stats-title">Total Pendapatan <i>Bulan <?php echo $subtitle ?> Tahun <?= $tahun ?></i></span>
                                    <span class="widget-stats-info">Rp <?= number_format($credit) ?></span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-xl-12 col-lg-7">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <!-- Card Body -->
                        <div class="card-body">
                            <!-- sample modal content -->

                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="table-responsive">
                                        <table id="datatable1" class="display" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal</th>
                                                    <th>Paket</th>
                                                    <th>Kode voucher</th>
                                                    <th>Harga</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                foreach ($datafilter->result_array() as $row) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $i++; ?></td>
                                                        <td><?php echo tanggal($row['date']); ?></td>
                                                        <td><?= $row['service'] ?></td>
                                                        <td><?= $row['kode'] ?></td>
                                                        <td>Rp <?php echo number_format($row['harga']); ?></td>

                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end row -->

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php
if ($this->session->flashdata('message_err')) {
?>
    <script>
        swal({
            text: "<?php echo $this->session->flashdata('message_err'); ?>",
            icon: "error",
            button: false,
            timer: 1200
        });
    </script>
<?php
} else if ($this->session->flashdata('message_success')) {
?>
    <script>
        swal({
            text: "<?php echo $this->session->flashdata('message_success'); ?>",
            icon: "success",
            button: false,
            timer: 1200
        });
    </script>
<?php
}
?>
<?php $this->load->view('templates/voucher/footer'); ?>