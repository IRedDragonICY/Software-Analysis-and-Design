<?php $this->load->view('templates/user/header'); ?>
<?php foreach ($history as $row) : ?>

    <div class="app-content">
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="page-description">
                            <h1>Detail Invoice</h1>
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
                                        <label for="paket" class="col-sm-2 col-form-label">Invoice</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="<?php echo $row->code ?>" disabled>

                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="username" class="col-sm-2 col-form-label">Paket</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="<?php echo $row->package ?>" disabled>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="username" class="col-sm-2 col-form-label">Status</label>
                                        <div class="col-sm-10">
                                            <?php
                                            if ($row->status == 'Unpaid') {
                                                $text = "Belum Terbayar";
                                            } else if ($row->status == "Paid") {
                                                $text = "Sudah Terbayar";
                                            }
                                            ?>
                                            <input type="text" class="form-control" value="<?php echo $text ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="username" class="col-sm-2 col-form-label">Tanggal jatuh tempo</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="<?php echo tanggal(date('Y-m-d', strtotime($row->expdate))) ?>" disabled>
                                        </div>
                                    </div>


                                    <?php

                                    $hariini = strtotime($date);
                                    $tglexp = strtotime($row->exppay);

                                    if ($row->status == 'Unpaid' && $hariini >= $tglexp) {

                                    ?>
                                        <a href="<?= base_url("user/invoice/payment/$row->code") ?>" class="btn btn-primary"><i class='material-icons-outlined'>payment</i><strong>Lakukan
                                                Pembayaran</strong></a></td>

                                    <?php } else if ($row->category != null && $row->status == 'Unpaid') {

                                    ?>
                                        <a href="<?= base_url("user/invoice/cek/$row->code") ?>" class="btn btn-primary"><i class='material-icons-outlined'>payment</i><strong>Cek Pembayaran</strong></a>
                                        </td>

                                    <?php } ?>


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