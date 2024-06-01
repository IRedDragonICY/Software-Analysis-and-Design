<?php $this->load->view('templates/admin/header'); ?>
<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Tambah data user</h1>
                    </div>
                </div>
            </div>
            <div class="row">

                <!-- Default Card Example -->
                <!-- Grow In Utility -->

                <div class="col-lg-12 mb-4">
                    <div class="card position-relative">
                        <div class="card-body">
                            <div class="mb-3">

                                <form class="form-horizontal" action="<?php echo base_url('admin/adduser'); ?>" role="form" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">


                                    <div class="row mb-3">
                                        <label for="username" class="col-sm-2 col-form-label">Nama</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="name" id="name" placeholder="Nama" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="username" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="password" id="password" value="<?php echo $password ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Level

                                        </label>

                                        <div class="col-sm-10">
                                            <select class="form-select" aria-label="Default select example" id="level" name="level" required>
                                                <option disabled value="" selected>Level</option>
                                                <?php
                                                if ($this->session->userdata('level') === 'developer') {
                                                ?>

                                                    <option value="admin">Admin</option>
                                                <?php } ?>
                                                <option value="cs">Customer Service </option>
                                            </select>
                                        </div>
                                    </div>



                                    <button type="submit" class="btn btn-primary">Submit</button>


                                </form>
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
<?php $this->load->view('templates/admin/footer'); ?>