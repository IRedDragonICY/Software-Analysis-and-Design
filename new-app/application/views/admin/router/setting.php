<?php $this->load->view('templates/router/header'); ?>
<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description page-description-tabbed">
                        <h1>Router Setting </h1>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">

                    <div class="card">
                        <div class="card-body">
                            <form class="form-horizontal" action="<?php echo base_url('router/update'); ?>" role="form" method="POST">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                <div class="row m-t-xxl">
                                    <div class="col-md-12">
                                        <label for="settingsCurrentPassword" class="form-label">Nama Server</label>
                                        <input type="text" name="name" class="form-control" value="<?php echo $router[0]['nama'] ?>">
                                    </div>
                                </div>
                                <div class="row m-t-xxl">
                                    <div class="col-md-12">
                                        <label for="settingsNewPassword" class="form-label">DNS</label>
                                        <input type="text" name="dns" class="form-control" value="<?php echo $router[0]['dns'] ?>">
                                    </div>
                                </div>
                                <div class="row m-t-xxl">
                                    <div class="col-md-12">
                                        <label for="settingsConfirmPassword" class="form-label">IP Mikrotik</label>
                                        <input type="text" name="host" class="form-control" value="<?php echo $router[0]['ip'] ?>">
                                    </div>
                                </div>
                                <div class="row m-t-xxl">
                                    <div class="col-md-12">
                                        <label for="settingsConfirmPassword" class="form-label">Username</label>
                                        <input type="text" name="username" class="form-control" value="<?php echo $router[0]['username'] ?>">
                                    </div>
                                </div>
                                <div class="row m-t-xxl">
                                    <div class="col-md-12">
                                        <label for="settingsConfirmPassword" class="form-label">Password</label>
                                        <input type="text" name="password" class="form-control" value="<?php echo decrypt($router[0]['password']) ?>">
                                    </div>
                                </div>
                                <div class="row m-t-xxl">
                                    <div class="col-md-12">
                                        <label for="settingsConfirmPassword" class="form-label">Traffic
                                            Interface</label>
                                        <input type="text" name="traffic-interface" class="form-control" value="<?php echo $router[0]['traffic-interface'] ?>" placeholder="Isikan Traffic Interface, Cth : ether1-isp / ether1 ">
                                    </div>
                                </div>


                                <div class="row m-t-lg">
                                    <div class="col">
                                        <button type="submit" class="btn btn-primary m-t-sm">Update</button>
                                        <a href="<?php echo base_url('router/ping') ?>" class="btn btn-success m-t-sm">PING</a>

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
<?php $this->load->view('templates/router/footer'); ?>