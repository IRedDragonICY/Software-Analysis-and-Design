<?php $this->load->view('templates/admin/header'); ?>
<?php foreach ($cek as $row) : ?>

    <div class="app-content">
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="page-description">
                            <h1>Catatan</h1>
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
                                        <label for="paket" class="col-sm-2 col-form-label">Catatan</label>
                                        <div class="col-sm-10">
                                            <textarea rows="5" cols="130" name="content" class="form-control" disabled><?php echo $row->message; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="username" class="col-sm-2 col-form-label">Foto </label>

                                        <div class="col-sm-10">
                                            <a href="<?php echo base_url(); ?>data/catatan/<?php echo $row->image; ?>" target="_blank"><img src="<?php echo base_url(); ?>data/catatan/<?php echo $row->image; ?>" alt="" width="300"> </a>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="username" class="col-sm-2 col-form-label">Pada tanggal </label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="<?php echo  tanggal(date('Y-m-d', strtotime($row->date))) ?>" disabled>
                                        </div>
                                    </div>



                                    <a href="<?php echo base_url('admin/note') ?>" class="btn btn-warning">Kembali</a>

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