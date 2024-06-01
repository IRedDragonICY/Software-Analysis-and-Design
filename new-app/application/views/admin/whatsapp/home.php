<?php $this->load->view('templates/admin/header'); ?>
<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Pengaturan Whatsapp Gateway</h1>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <?php foreach ($content as $row) : ?>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="card overflow-hidden">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3 class="card-title"><i class="fa fa-key"></i> Whatsapp Gateway</h3>
                            </div>
                            <div class="card-body">
                                <form autocomplete="off" name="formadd" method="post" action="<?php echo base_url('admin/whatsapp/update'); ?>">
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                    <div class="mb-3 row">
                                        <label for="apikey" class="col-sm-2 col-form-label">Pengirim</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="sender" name="sender" value="<?= $row->sender ?>" disabled>
                                            <input type="hidden" name="sender" value="<?= $row->sender ?>">

                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="apikey" class="col-sm-2 col-form-label">Pesan Notifikasi Tagihan</label>
                                        <div class="col-sm-10">
                                            <textarea rows="20" name="notif" class="form-control"><?= $row->tagihan_otomatis ?></textarea>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="apikey" class="col-sm-2 col-form-label">Pesan Tagihan Terbayar</label>
                                        <div class="col-sm-10">
                                            <textarea rows="20" name="terbayar" class="form-control"><?= $row->tagihan_terbayar ?></textarea>
                                        </div>
                                    </div>


                                    <div class="mb-3 row">
                                        <label for="apikey" class="col-sm-2 col-form-label">Pesan Pelanggan Baru</label>
                                        <div class="col-sm-10">
                                            <textarea rows="20" name="register" class="form-control"><?= $row->register ?></textarea>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="buttonadd" class="col-sm-2 col-form-label"></label>
                                        <div class="col-sm-10">
                                            <button class="btn btn-primary" id="buttonadd" type="submit"><i class="fe fe-save"></i> Simpan</button>
                                        </div>
                                    </div>

                                </form>

                            </div>

                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Informasi</h5>
                            </div>

                            <div class="card-body">
                                <pre>

Keyword Tersedia :
{expdate} *menampilkan jatuh tempo
{nama_web} *menampilkan nama web
{link_web} *menampilkan link web
{nama_customer} *menampilkan nama pelanggan
{nomor_invoice} *menampilkan nomor invoice
                                                        </pre>
                            </div>

                        </div>
                    </div>
                </div>


            <?php endforeach ?>




            <!-- end row -->

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