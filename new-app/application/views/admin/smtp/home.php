<?php $this->load->view('templates/admin/header'); ?>
<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Pengaturan SMTP Mail</h1>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row">

                <div class="col-sm-6">
                    <div class="card overflow-hidden">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title"><i class="fa fa-key"></i> Integrasi SMTP Mail ( Sendinblue )</h3>
                        </div>
                        <div class="card-body">

                            <form autocomplete="off" name="formadd" method="post" action="<?php echo base_url('admin/update_smtp'); ?>">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                <input type="hidden" name="target" value="<?= $target ?>">
                                <div class="mb-3 row">
                                    <label for="merchantcode" class="col-sm-2 col-form-label">API Key</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="api_key" name="api_key" value="<?= $api_key ?>">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="apiurl" class="col-sm-2 col-form-label">Tampilan Nama</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="name" name="name" value="<?= $nama ?>">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="apikey" class="col-sm-2 col-form-label">Email System</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="email" name="email" value="<?= $email ?>">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="buttonadd" class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-10">
                                        <button class="btn btn-primary" id="buttonadd" type="submit"> Update</button>
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

<?php $this->load->view('templates/admin/footer'); ?>