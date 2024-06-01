<?php $this->load->view('templates/admin/header'); ?>
<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Setup Whatsapp Gateway</h1>
                    </div>
                </div>
            </div>
            <div class="row">

                <!-- Default Card Example -->
                <!-- Grow In Utility -->

                <?php
                foreach ($content->result() as $param) {
                    $sender = $param->sender;
                }

                if ($sender == null) {
                ?>
                    <div class="col-lg-6 mb-4">
                        <div class="card position-relative">
                            <div class="card-body">

                                <div class="mb-3">

                                    <form class="row g-3" action="<?php echo base_url('admin/proses_whatsapp'); ?>" role="form" method="POST">

                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                        <div class="col-md-12">

                                            <label for="sender" class="form-label">Nomor Whatsapp</label>
                                            <input type="text" class="form-control" id="sender" name="sender" placeholder="Masukan nomor whatsapp anda">
                                        </div>


                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                <?php } else if ($sender != null) {

                ?>


                    <div class="col-lg-6 mb-4">
                        <?php

                        if ($this->session->flashdata('pesan') != null) {



                        ?>
                            <?= $this->session->flashdata('pesan'); ?>
                    </div>

                    <form class="row g-3" action="<?php echo base_url('admin/refresh_whatsapp'); ?>" role="form" method="POST">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                        <input type="hidden" name="sender" value="<?= $sender ?>">

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Refresh</button>
                        </div>
                    </form>


                <?php } else {

                ?>


                    <div class="alert alert-light" role="alert">Silahkan klik tombol Scan QR . </div>

                    <div class="card position-relative">
                        <div class="card-body">

                            <div class="mb-3">

                                <form class="row g-3" action="<?php echo base_url('admin/scanqr_whatsapp'); ?>" role="form" method="POST">
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                    <input type="hidden" name="sender" value="<?= $sender ?>">

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-success">Scan QR</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php }
        ?>
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