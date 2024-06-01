<?php $this->load->view('templates/admin/header'); ?>
<?php foreach ($content as $row) : ?>


    <div class="app-content">
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="page-description page-description-tabbed">
                            <h1>Edit Layanan </h1>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">

                        <div class="card">
                            <div class="card-body">
                                <form class="form-horizontal" action="<?php echo base_url('admin/service_update'); ?>" role="form" method="POST">
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                    <div class="row m-t-xxl">
                                        <div class="col-md-12">
                                            <label for="settingsCurrentPassword" class="form-label">Nama Paket</label>
                                            <input type="hidden" name="target" value="<?= $row->id ?>">
                                            <input type="text" name="nama" class="form-control" value="<?= $row->paket ?>">
                                        </div>
                                    </div>
                                    <div class="row m-t-xxl">
                                        <div class="col-md-12">
                                            <label for="settingsNewPassword" class="form-label">Harga </label>
                                            <input type="text" name="harga" class="form-control" value="<?= $row->harga ?>">
                                        </div>
                                    </div>

                                    <div class="row m-t-xxl">
                                        <div class="col-md-12">
                                            <label for="settingsNewPassword" class="form-label">PPN ( Isikan dengan angka saja ) </label>
                                            <input type="text" name="ppn" class="form-control" value="<?= $row->ppn ?>">
                                        </div>
                                    </div>



                                    <div class="row m-t-lg">
                                        <div class="col">
                                            <button type="submit" class="btn btn-primary m-t-sm">Update</button>

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


<?php endforeach; ?>
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
} else if ($this->session->flashdata('message_success')) {
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
<?php $this->load->view('templates/admin/footer'); ?>