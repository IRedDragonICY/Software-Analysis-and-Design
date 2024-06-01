<?php $this->load->view('templates/admin/header'); ?>
<?php
foreach ($query as $row) {
    $this->session->set_userdata('paket', $row->paket);
    $this->session->set_userdata('harga', $row->harga);


?>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="page-description">
                            <h1>Form Pelanggan Baru</h1>
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

                                    <form class="form-horizontal" action="<?php echo base_url('admin/customer_prosesadd'); ?>" role="form" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                        <div class="row mb-3">
                                            <label for="paket" class="col-sm-2 col-form-label">Paket</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="package" id="package" value="<?php echo $row->paket ?>" disabled>
                                                <input type="hidden" name="package" value="<?php echo $this->session->userdata('paket'); ?>">

                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="username" class="col-sm-2 col-form-label">Nama</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="name" id="name" placeholder="Nama" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="username" class="col-sm-2 col-form-label">Nomor Handphone</label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control" name="nohp" id="nohp" placeholder="Nomor Handphone" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="username" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="username" class="col-sm-2 col-form-label">Alamat</label>
                                            <div class="col-sm-10">
                                                <textarea type="text" class="form-control" name="alamat" id="alamat" required></textarea>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="username" class="col-sm-2 col-form-label"> Dokumen ( KTP / SIM )</label>
                                            <div class="col-sm-10">
                                                <input type="file" class="form-control" name="image" id="image" required></input>
                                            </div>
                                        </div>
                                        <?php if (isset($error)) : ?>
                                            <div class="invalid-feedback"><?= $error ?></div>
                                        <?php endif; ?>

                                        <hr>


                                        <div class="row mb-3">
                                            <label for="password" class="col-sm-2 col-form-label">ID Pelanggan</label>
                                            <div class="col-sm-10">
                                                <?php foreach ($idpel as $data) :
                                                    $a = $data['idpel'];
                                                    $char = "P-";
                                                    $urutan = (int) substr($a, 2, 4);
                                                    $urutan++;

                                                    $kode = $char . sprintf("%04s", $urutan);

                                                ?>
                                                    <input type="text" class="form-control" name="idpel" value="<?php echo $kode ?>" readonly>
                                                <?php endforeach ?>
                                            </div>
                                        </div>
                                        <div class="row mb-3" id="username" style="display:none">
                                            <label class="col-md-2 control-label">Username</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="username" id="username" placeholder="Isikan untuk didalam mikrotik PPP [name] ">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="password" class="col-sm-2 col-form-label">Password</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="password" id="password" value="<?php echo $password ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="inputEmail3" class="col-sm-2 col-form-label">IP Address
                                                <span class="text-primary cursor-pointer" data-bs-toggle="tooltip" data-bs-placement="right" title="Tanggal tetap ialah tanggal yg harus dibayar oleh client misalkan tanggal 5, berati client harus membayar setiap tanggal 5">[?]</span>

                                            </label>

                                            <div class="col-sm-10">
                                                <select class="form-select" aria-label="Default select example" id="jenip" name="jenip" required>
                                                    <option disabled value="" selected>IP Address</option>
                                                    <option value="statis">Static</option>
                                                    <option value="dinamis">Dynamic </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label">Static</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" value="192.178.77.10" name="ipadd" minlength="7" maxlength="15" disabled>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="inputEmail3" class="col-sm-2 col-form-label">Periode Pembayaran
                                                <span class="text-primary cursor-pointer" data-bs-toggle="tooltip" data-bs-placement="right" title="Tanggal tetap ialah tanggal yg harus dibayar oleh client misalkan tanggal 5, berati client harus membayar setiap tanggal 5">[?]</span>

                                            </label>

                                            <div class="col-sm-10">
                                                <select class="form-select" aria-label="Default select example" id="billpriod" name="billpriod">
                                                    <option disabled value="" selected>Pilih Periode Pembayaran</option>
                                                    <option value="fixdate">Tanggal Tetap</option>
                                                    <option value="randomdate">Tanggal random </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3" id="datefix" style="display:none">
                                            <label class="col-md-2 control-label">Tanggal Tetap</label>
                                            <div class="col-sm-10">
                                                <input class="form-control flatpickr1" name="datefix" id="datefix" type="text" placeholder="Silahkan pilih tanggal">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="harga" class="col-sm-2 col-form-label">Total Harga ( + PPN ) </label>
                                            <div class="col-sm-10">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text text-primary">Rp</span></div>
                                                    <?php

                                                    $ppn = $row->ppn;
                                                    $price = $row->harga;
                                                    $cal = $price + $price * $ppn / 100;

                                                    $hasil = $cal

                                                    ?>




                                                    <input type="text" class="form-control" id="price" name="price" value="<?= number_format($hasil) ?>" disabled>
                                                    <input type="hidden" name="price" value="<?= $hasil ?>">

                                                </div>
                                            </div>
                                        </div>
                                        <a href="<?php echo base_url('orders') ?>" class="btn btn-secondary">Kembali</a>

                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    <?php } ?>


                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.js"></script>


    <script type="text/javascript">
        $('#billpriod').change((e) => {
            if (e.target.value == "fixdate")
                $('#datefix').fadeIn();
            else
                $('#datefix').fadeOut();
        })
    </script>

    <script>
        $('#jenip').change(function() {
            var a = $(this).val();
            if (a == "statis") {
                $("input[name='ipadd']").prop("disabled", false);
            } else {
                $("input[name='ipadd']").prop("disabled", true);
            }


        });
    </script>
    <?php $this->load->view('templates/admin/footer'); ?>