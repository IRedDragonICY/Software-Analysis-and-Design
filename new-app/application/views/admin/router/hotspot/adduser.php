<?php $this->load->view('templates/router/header'); ?>
<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Add User Hotspot</h1>
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

                                <form class="form-horizontal" action="<?php echo base_url('hotspot/tambahuser'); ?>" role="form" method="POST">
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Server</label>
                                        <div class="col-sm-10">
                                            <select class="form-select" aria-label="Default select example" name="server" id="server">
                                                <option disabled value="" selected>Pilih Server</option>
                                                <option value="all">all</option>
                                                <?php foreach ($server as $data) { ?>
                                                    <option><?= $data['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="username" class="col-sm-2 col-form-label">User</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" autocomplete="off" name="user" id="user" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="password" class="col-sm-2 col-form-label">password</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" autocomplete="off" name="password" id="password" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Profile</label>
                                        <div class="col-sm-10">
                                            <select class="form-select" aria-label="Default select example" name="profile" id="profile">
                                                <option disabled value="" selected>Pilih Profile</option>
                                                <?php foreach ($profile as $data) { ?>
                                                    <option><?= $data['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="username" class="col-sm-2 col-form-label">TimeLimit</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" autocomplete="off" name="timelimit" id="timelimit">
                                        </div>
                                    </div>


                                    <a href="<?php echo base_url('admin/router/hotspot/users') ?>" class="btn btn-secondary">Kembali</a>

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
<?php $this->load->view('templates/router/footer'); ?>