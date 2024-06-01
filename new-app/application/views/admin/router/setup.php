<?php $this->load->view('templates/router/header'); ?>
<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description page-description-tabbed">
                        <h1>Router Setup </h1>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">

                    <div class="card">
                        <div class="card-body">
                            <form class="form-horizontal" action="<?php echo base_url('router/router_save'); ?>" role="form" method="POST">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                <div class="row m-t-xxl">
                                    <div class="col-md-12">
                                        <label for="settingsCurrentPassword" class="form-label">Nama Server</label>
                                        <input type="text" name="name" class="form-control" placeholder="Contoh : Mbs Cloud">
                                    </div>
                                </div>
                                <div class="row m-t-xxl">
                                    <div class="col-md-12">
                                        <label for="settingsNewPassword" class="form-label">DNS</label>
                                        <input type="text" name="dns" class="form-control" placeholder="contoh : mbscloud.id">
                                    </div>
                                </div>
                                <div class="row m-t-xxl">
                                    <div class="col-md-12">
                                        <label for="settingsConfirmPassword" class="form-label">IP Mikrotik</label>
                                        <input type="text" name="host" class="form-control" placeholder="10.10.10.1">
                                    </div>
                                </div>
                                <div class="row m-t-xxl">
                                    <div class="col-md-12">
                                        <label for="settingsConfirmPassword" class="form-label">Username</label>
                                        <input type="text" name="username" class="form-control" placeholder="Masukan Username Mikrotik">
                                    </div>
                                </div>
                                <div class="row m-t-xxl">
                                    <div class="col-md-12">
                                        <label for="settingsConfirmPassword" class="form-label">Password</label>
                                        <input type="text" name="password" class="form-control" placeholder="Masukan Password Mikrotik">
                                    </div>
                                </div>
                                <div class="row m-t-xxl">
                                    <div class="col-md-12">
                                        <label for="settingsConfirmPassword" class="form-label">Traffic
                                            Interface</label>
                                        <input type="text" name="traffic-interface" class="form-control" placeholder="Isikan Traffic Interface, Cth : ether1-isp / ether1 ">
                                    </div>
                                </div>


                                <div class="row m-t-lg">
                                    <div class="col">
                                        <button type="submit" class="btn btn-primary m-t-sm">Save</button>
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