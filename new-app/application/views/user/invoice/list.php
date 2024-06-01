<?php $this->load->view('templates/user/header'); ?>

<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>History Invoice</h1>
                    </div>
                </div>
            </div>

            <div class="row">
                <?php foreach ($invoice as $row) {
                ?>
                    <div class="col-xl-4">
                        <div class="card widget widget-stats">
                            <div class="card-body">
                                <div class="widget-stats-container d-flex">
                                    <div class="widget-stats-icon widget-stats-icon-primary">
                                        <i class="material-icons-outlined">payment</i>
                                    </div>
                                    <div class="widget-stats-content flex-fill">
                                        <span class="widget-stats-title">Tagihan Anda Bulan <?php echo bulan_indo($row->date); ?></span>
                                        <?php
                                        if ($row->status == 'Unpaid') {
                                            $label = "danger";
                                            $text =  "Belum Terbayar";
                                        } else if ($row->status == "Paid") {
                                            $label = "success";
                                            $text =  "Sudah Terbayar";
                                        }
                                        ?>
                                        <span class="widget-stats-amount"><label class="btn btn-<?php echo $label; ?>"> <?php echo $text; ?></label></span>
                                        <hr>
                                        <a href="<?= base_url("user/invoice/print/$row->code") ?>" class="btn btn-primary" target="_blank"><i class='material-icons-outlined'>arrow_circle_right</i><strong>Lihat Full Invoice</strong></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php
if ($this->session->flashdata('message_err')) {
?>
    <script>
        swal({
            text: "<?php echo $this->session->flashdata('message_err'); ?>",
            icon: "error",
            button: false,
            timer: 2000
        });
    </script>
<?php
} elseif ($this->session->flashdata('message_success')) {
?>
    <script>
        swal({
            text: "<?php echo $this->session->flashdata('message_success'); ?>",
            icon: "success",
            button: false,
            timer: 2000

        });
    </script>
<?php
}
?>
    <?php $this->load->view('templates/user/footer'); ?>