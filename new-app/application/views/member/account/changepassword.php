<?php $this->load->view('templates/member/header'); ?>
<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description page-description-tabbed">
                        <h1>Ganti Password</h1>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">

                    <div class="card">
                        <div class="card-body">
                            <?= $this->session->flashdata('gagal'); ?>
                            <?= form_error('currentpassword', '<div class="alert alert-danger alert-message" role="alert">', '</div>'); ?>
                            <?= form_error('new_password', '<div class="alert alert-danger alert-message" role="alert">', '</div>'); ?>
                            <?= form_error('repeat_password', '<div class="alert alert-danger alert-message" role="alert">', '</div>'); ?>
                            <form class="form-horizontal" action="<?php echo base_url('member/changepassword'); ?>" role="form" method="POST">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                <div class="row m-t-xxl">
                                    <div class="col-md-12">
                                        <label for="settingsCurrentPassword" class="form-label">Current Password</label>
                                        <input type="password" name="currentpassword" class="form-control" aria-describedby="settingsCurrentPassword" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
                                        <div id="settingsCurrentPassword" class="form-text"></div>
                                    </div>
                                </div>
                                <div class="row m-t-xxl">
                                    <div class="col-md-12">
                                        <label for="settingsNewPassword" class="form-label">New Password</label>
                                        <input type="password" name="new_password" class="form-control" aria-describedby="settingsNewPassword" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
                                    </div>
                                </div>
                                <div class="row m-t-xxl">
                                    <div class="col-md-12">
                                        <label for="settingsConfirmPassword" class="form-label">Confirm Password</label>
                                        <input type="password" name="repeat_password" class="form-control" aria-describedby="settingsConfirmPassword" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
                                    </div>
                                </div>

                                <div class="row m-t-lg">
                                    <div class="col">
                                        <button type="submit" class="btn btn-primary m-t-sm">Submit</button>
                                    </div>
                                </div>
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
<?php $this->load->view('templates/member/footer'); ?>