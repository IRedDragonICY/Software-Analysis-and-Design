<?php $this->load->view('templates/admin/header'); ?>
<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description text-center">
                        <h1>Paket Internet <?= $titleweb ?> </h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-12 col-sm-offset-2 col-sm-10 col-lg-offset-2 col-lg-10 mx-auto">
                    <?= $this->session->flashdata('pesan'); ?>

                    <div class="row">
                        <?php
                        foreach ($package as $row) {
                        ?>
                            <div class="col-12 col-xl-4">
                                <div class="card pricing-basic">
                                    <div class="card-body">
                                        <h3 class="plan-title"><?php echo $row->paket; ?></h3>
                                        <div class="m-t-md d-grid">
                                            <?php
                                            $id = $row->id;
                                            ?>
                                            <a href="<?php echo base_url('admin/customer/add/' . $id) ?>" class="btn btn-secondary btn-lg">Pilih</a>
                                            <?php ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
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
<?php $this->load->view('templates/admin/footer'); ?>