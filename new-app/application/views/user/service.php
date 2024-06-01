<?php $this->load->view('templates/user/header'); ?>
<?php foreach ($content as $row) : ?>

    <div class="app-content">
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="page-description">
                            <h1>Layanan Anda</h1>
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
                                    <div class="row mb-3">
                                        <label for="paket" class="col-sm-2 col-form-label">ID Pelanggan</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="<?php echo $row->idpel ?>" disabled>

                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="paket" class="col-sm-2 col-form-label">Layanan</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="<?php echo $row->paket ?>" disabled>

                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="username" class="col-sm-2 col-form-label">Tanggal Aktif</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="<?php echo tanggal($row->date) ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="username" class="col-sm-2 col-form-label">Masa aktif sampai </label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="<?php echo tanggal(date('Y-m-d', strtotime($row->expdate))) ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="username" class="col-sm-2 col-form-label">Status</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="<?php echo $row->status ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>

<?php $this->load->view('templates/user/footer'); ?>