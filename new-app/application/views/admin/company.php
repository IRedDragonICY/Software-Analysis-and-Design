<?php $this->load->view('templates/admin/header'); ?>
<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description page-description-tabbed">
                        <h1>Pengaturan Company </h1>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">

                    <div class="card">
                        <div class="card-body">
                            <?php echo form_open_multipart('admin/company_update');  ?>
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                            <div class="row m-t-xxl">
                                <div class="col-md-12">
                                    <label for="settingsCurrentPassword" class="form-label">Logo</label>
                                    <br>
                                    <a href="<?php echo base_url(); ?>assets/logo/<?php echo $logo; ?>" target="_blank"><img src="<?php echo base_url(); ?>assets/logo/<?php echo $logo; ?>" alt="" width="300"> </a>
                                    <input type="hidden" class="form-control" name="logo" id="logo" value="<?= $logo ?>"></input>

                                </div>
                            </div>
                            <div class="row m-t-xxl">
                                <div class="col-md-12">
                                    <label for="settingsCurrentPassword" class="form-label">Upload Logo</label>
                                    <input type="file" class="form-control" name="image" id="image"></input>
                                </div>
                            </div>
                            <div class="row m-t-xxl">
                                <div class="col-md-12">
                                    <label for="settingsNewPassword" class="form-label">Alamat</label>
                                    <input type="text" name="address" class="form-control" value="<?php echo $addr ?>">
                                </div>
                            </div>
                            <div class="row m-t-xxl">
                                <div class="col-md-12">
                                    <label for="settingsConfirmPassword" class="form-label">Kota</label>
                                    <input type="text" name="city" class="form-control" value="<?php echo $city ?>">
                                </div>
                            </div>
                            <div class="row m-t-xxl">
                                <div class="col-md-12">
                                    <label for="settingsConfirmPassword" class="form-label">Provinsi</label>
                                    <input type="text" name="province" class="form-control" value="<?php echo $prov ?>">
                                </div>
                            </div>
                            <div class="row m-t-xxl">
                                <div class="col-md-12">
                                    <label for="settingsConfirmPassword" class="form-label">Negara</label>
                                    <input type="text" name="country" class="form-control" value="<?php echo $country ?>">
                                </div>
                            </div>

                            <div class="row m-t-xxl">
                                <div class="col-md-12">
                                    <label for="settingsConfirmPassword" class="form-label">Postal Code</label>
                                    <input type="text" name="postal_code" class="form-control" value="<?php echo $zip ?>">
                                </div>
                            </div>



                            <div class="row m-t-lg">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary m-t-sm">Update</button>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
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