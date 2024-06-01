<?php $this->load->view('templates/voucher/header'); ?>
<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Add User Profile Hotspot</h1>
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

                                <form class="form-horizontal" action="<?php echo base_url('voucher/prosesprofile'); ?>" role="form" method="POST">
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                    <div class="row mb-3">
                                        <label for="username" class="col-sm-2 col-form-label">Nama Profile</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" autocomplete="off" name="name" id="name">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="password" class="col-sm-2 col-form-label">Rate Limit [up/down] </label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" autocomplete="off" name="ratelimit" id="ratelimit">
                                        </div>
                                    </div>


                                    <div class="row mb-3">
                                        <label for="password" class="col-sm-2 col-form-label">Masa Aktif [ Validity ]</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" autocomplete="off" name="uptime" id="uptime" placeholder="Example : 1h/4h/7h/30d">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="password" class="col-sm-2 col-form-label">Harga</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" autocomplete="off" name="price" id="price" placeholder="Example : 1000">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Kunci Mac Address </label>
                                        <div class="col-sm-10">
                                            <select class="form-select" aria-label="Default select example" name="mac" id="mac">
                                                <option disabled value="" selected>Pilih salah satu</option>
                                                <option value="Ya">Ya</option>
                                                <option value="Tidak">Tidak</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="username" class="col-sm-2 col-form-label">Shared Users</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" autocomplete="off" name="shared" id="shared">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Transparent Proxy </label>
                                        <div class="col-sm-10">
                                            <select class="form-select" aria-label="Default select example" name="proxy" id="proxy">
                                                <option disabled value="" selected>Pilih salah satu</option>
                                                <option value="yes">Ya</option>
                                                <option value="no">Tidak</option>
                                            </select>
                                        </div>
                                    </div>


                                    <a href="<?php echo base_url('hotspot/users') ?>" class="btn btn-secondary">Kembali</a>

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