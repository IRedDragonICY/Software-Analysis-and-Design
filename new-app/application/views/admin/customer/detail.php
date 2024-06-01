<?php $this->load->view('templates/admin/header'); ?>
<?php foreach ($customers as $row) : ?>

    <div class="app-content">
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="page-description">
                            <h1>Detail Pelanggan</h1>
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
                                        <label for="paket" class="col-sm-2 col-form-label">Nama</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="<?php echo $row->nama ?>" disabled>

                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="username" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="<?php echo $row->email ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="username" class="col-sm-2 col-form-label">Nomor Handphone </label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="<?php echo  $row->nomor ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="username" class="col-sm-2 col-form-label">Alamat</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" disabled> <?php echo $row->alamat ?>

                                                </textarea>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mb-3">
                                        <label for="username" class="col-sm-2 col-form-label">ID Pelanggan </label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="<?php echo  $cek[0]->idpel ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="username" class="col-sm-2 col-form-label">Layanan </label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="<?php echo  $cek[0]->paket ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="username" class="col-sm-2 col-form-label">Tanggal Aktif </label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="<?php echo tanggal($cek[0]->date) ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="username" class="col-sm-2 col-form-label">Masa Aktif Sampai </label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="<?php echo tanggal(date('Y-m-d', strtotime($cek[0]->expdate))) ?>" disabled>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="username" class="col-sm-2 col-form-label">Dokumen </label>

                                        <div class="col-sm-10">
                                            <a href="<?php echo base_url(); ?>data/document/<?php echo $cek[0]->image; ?>" target="_blank"><img src="<?php echo base_url(); ?>data/document/<?php echo $cek[0]->image; ?>" alt="" width="300"> </a>
                                        </div>
                                    </div>



                                    <a href="<?php echo base_url('admin/customer') ?>" class="btn btn-warning">Kembali</a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>

<?php $this->load->view('templates/admin/footer'); ?>