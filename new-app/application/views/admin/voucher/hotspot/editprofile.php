<?php $this->load->view('templates/voucher/header'); ?>
<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Edit Profile</h1>
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

                                <form class="form-horizontal" action="<?php echo base_url('hotspot/saveprofile'); ?>" role="form" method="POST">

                                    <div class="row mb-3">
                                        <label for="username" class="col-sm-2 col-form-label">Nama</label>
                                        <div class="col-sm-10">
                                            <input type="hidden" value="<?= $profile[".id"] ?> " name="edit-id">
                                            <input type="text" class="form-control" autocomplete="off" name="user" id="user" value="<?= $profile['name'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="password" class="col-sm-2 col-form-label">Rate Limit</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" autocomplete="off" name="ratelimit" id="ratelimit" value="<?= $profile['rate-limit'] ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-2 control-label"> Shared Users</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="shared" class="form-control" autocomplete="off" value="<?= $profile['shared-users'] ?>">
                                        </div>
                                    </div>




                                    <a href="<?php echo base_url('admin/voucher/hotspot/profile') ?>" class="btn btn-secondary">Kembali</a>

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
<?php $this->load->view('templates/voucher/footer'); ?>