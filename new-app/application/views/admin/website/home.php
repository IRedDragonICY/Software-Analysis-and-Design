<?php $this->load->view('templates/admin/header'); ?>
<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description page-description-tabbed">
                        <h1>Pengaturan Website </h1>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">

                    <div class="card">
                        <div class="card-body">
                            <form class="form-horizontal" action="<?php echo base_url('admin/update_website'); ?>" role="form" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                <div class="row m-t-xxl">
                                    <div class="col-md-12">
                                        <label for="settingsCurrentPassword" class="form-label">Title</label>
                                        <input type="text" name="title" class="form-control" value="<?php echo $titledata ?>">
                                    </div>
                                </div>
                                <div class="row m-t-xxl">
                                    <div class="col-md-12">
                                        <label for="settingsNewPassword" class="form-label">Logo Text</label>
                                        <input type="text" name="logotext" class="form-control" value="<?php echo $logotext ?>">
                                    </div>
                                </div>
                                <div class="row m-t-xxl">
                                    <div class="col-md-12">
                                        <label for="settingsConfirmPassword" class="form-label">Author</label>
                                        <input type="text" name="author" class="form-control" value="<?php echo $author ?>">
                                    </div>
                                </div>
                                <div class="row m-t-xxl">
                                    <div class="col-md-12">
                                        <label for="settingsCurrentPassword" class="form-label">Logo</label>
                                        <br>
                                        <a href="<?php echo base_url(); ?>assets/logo/<?php echo $logo; ?>" target="_blank"><img src="<?php echo base_url(); ?>assets/logo/<?php echo $logo; ?>" alt="" width="300"> </a>
                                        <input type="hidden" class="form-control" name="logo" id="logo" value="<?php echo $logo; ?>"></input>

                                    </div>
                                </div>
                                <div class="row m-t-xxl">
                                    <div class="col-md-12">
                                        <label for="settingsCurrentPassword" class="form-label">Upload Logo</label>
                                        <input type="file" class="form-control" name="image" id="image"></input>
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