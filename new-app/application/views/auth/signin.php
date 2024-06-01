<?php $this->load->view('templates/auth/signin/header'); ?>
<div class="app app-auth-sign-in align-content-stretch d-flex flex-wrap justify-content-end">
    <div class="app-auth-background">

    </div>
    <div class="app-auth-container">
        <div class="logo">
            <a href="<?php echo base_url(); ?>"><?= $title ?></a>
        </div>
        </p>
        <div class="p-3">

            <?= $this->session->flashdata('pesan'); ?>

        </div>


        <form action="<?php echo base_url('auth/do_signin'); ?>" class="form-horizontal" role="form" method="POST">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

            <div class="auth-credentials m-b-xxl">
                <label for="signInEmail" class="form-label">Email / No HP</label>
                <input type="text" class="form-control m-b-md" name="email" aria-describedby="email" placeholder="Masukan Email / No Handphone">


                <label for="signInPassword" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" aria-describedby="password" placeholder="Password">
            </div>


            <div class="auth-submit">
                <button type="submit" class="btn btn-primary"><i class="material-icons-outlined">login</i> Sign
                    in</button>
                <a href="<?php echo base_url(); ?>auth/forgot" class="auth-forgot-password float-end">Forgot password?</a>

            </div>
            <br>

        </form>
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
            timer: 1200

        });
    </script>
<?php
}
?>
<?php $this->load->view('templates/auth/signin/footer'); ?>