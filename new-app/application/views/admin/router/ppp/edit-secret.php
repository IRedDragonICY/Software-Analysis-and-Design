<?php $this->load->view('templates/router/header'); ?>
<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Edit Secret</h1>
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

                                <form class="form-horizontal" action="<?php echo base_url('router/ppp_proses_edit'); ?>" role="form" method="POST">
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                    <div class="row mb-3">
                                        <label for="username" class="col-sm-2 col-form-label">Nama</label>
                                        <div class="col-sm-10">
                                            <input type="hidden" value="<?= $secret[".id"] ?> " name="edit-id">
                                            <input type="text" class="form-control" autocomplete="off" name="user" id="user" value="<?= $secret['name'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" autocomplete="off" name="password" id="password" value="<?= $secret['password'] ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Service</label>
                                        <div class="col-sm-10">
                                            <select class="form-select" aria-label="Default select example" name="service" id="service">
                                                <option value="<?= $secret['service'] ?>" selected><?= $secret['service'] ?></option>
                                                <option value="any">any</option>
                                                <option value="async">async</option>
                                                <option value="l2tp">l2tp</option>
                                                <option value="ovpn">ovpn</option>
                                                <option value="pppoe">pppoe</option>
                                                <option value="pptp">pptp</option>
                                                <option value="sstp">sstp</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Profile </label>
                                        <div class="col-sm-10">
                                            <select class="form-select" aria-label="Default select example" name="profile" id="profile">
                                                <option value="<?= $secret['profile'] ?>" selected><?= $secret['profile'] ?></option>
                                                <?php foreach ($profile as $data) { ?>
                                                    <option value="<?= $data['name'] ?>"><?= $data['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="password" class="col-sm-2 col-form-label">Local Address</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" autocomplete="off" name="localaddr" id="localaddr" value="<?= $secret['local-address'] ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="password" class="col-sm-2 col-form-label">Remote Address</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" autocomplete="off" name="remoteaddr" id="remoteaddr" value="<?= $secret['remote-address'] ?>">
                                        </div>
                                    </div>



                                    <a href="<?php echo base_url('admin/router/ppp/secret') ?>" class="btn btn-secondary">Kembali</a>

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