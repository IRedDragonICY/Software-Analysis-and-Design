<?php $this->load->view('templates/invoice/header'); ?>

<div class="container" style="max-width:630px;">
    <div class="row p-2 m-1 rounded bg-light mob1 shadow-lg">
        <div class="d-flex justify-content-between mb-2">
            <div class="text-left" style="margin-left:1px;">
                <span>Pembayaran dengan<strong>
                        <br />
                        <?php
                        echo $tripay->data->payment_name;
                        ?>
                    </strong>

                </span>
            </div>
            <div class="text-right" style="margin-top: auto;margin-bottom: auto;">
                <img src="<?= $payment->data[0]->icon_url ?> " style="height:100%;max-height:30px;" />
            </div>
        </div>


        <div class="col-md-7 col-lg-12 mt-2">
            <ul class="list-group mb-3">
                <li class="list-group-item">
                    <h6 class="my-0">No Invoice</h6>
                    <small class="text-muted"><?= $tripay->data->merchant_ref ?></small>
                </li>
                <?php if ($tripay->data->payment_method == 'QRIS' || $tripay->data->status == 'UNPAID') { ?>

                    <li class="list-group-item">
                        <div>
                            <h6 class="my-0">Kode QRIS <small class="fw-normal">(*Klik untuk memperbesar kode QR)</small></h6>
                            <div class="mt-1 w-100 d-flex justify-content-center">
                                <img onclick='zoomQR()' src="<?= $tripay->data->qr_url ?>" width="175px" height="175px" />
                            </div>
                            <!-- <div class="d-flex justify-content-center">
                            <button class="btn btn-primary btn-sm" id="downloadImage"> Download QR Code </button>
                        </div> -->
                        </div>
                    </li>
                <?php } else { ?>
                    <li class="list-group-item">
                        <div>
                            <h6 class="my-0">Kode Bayar / No VA</h6>
                            <div class="input-group mt-1 w-100">
                                <input type="text" class="form-control" id="kodebayar" value="<?= $tripay->data->pay_code ?>">
                                <button class="btn btn-outline-secondary text-black" type="button" id="salinkodebayar" onClick="copyToClipboard();">
                                    <svg style="margin-top:-3px;" xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24">
                                        <path d="M15.143 13.244l.837-2.244 2.698 5.641-5.678 2.502.805-2.23s-8.055-3.538-7.708-10.913c2.715 5.938 9.046 7.244 9.046 7.244zm8.857-7.244v18h-18v-6h-6v-18h18v6h6zm-2 2h-12.112c-.562-.578-1.08-1.243-1.521-2h7.633v-4h-14v14h4v-3.124c.6.961 1.287 1.823 2 2.576v6.548h14v-14z" />
                                    </svg>
                                    Salin
                                </button>
                            </div>
                        </div>
                    </li>
                <?php } ?>

                <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                        <h6><?= $data[0]['package']; ?></h6>
                    </div>

                </li>

                <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                        <small>Biaya Admin</small>
                        <h6>Jumlah Tagihan</h6>
                    </div>
                    <div>
                        <small>Rp <?= number_format($tripay->data->fee_customer, 0, ',', '.') ?></small>
                        <h6>Rp <?= number_format($tripay->data->amount, 0, ',', '.') ?></h6>
                    </div>
                </li>

                <li class="list-group-item d-flex justify-content-between">
                    <div>
                        <h6 class="my-0 d-inline">Status</h6>
                        <!-- <small>(AutoRefresh: <span id="timer"></span>)</small> -->
                    </div>
                    <div>
                        <strong>
                            <?php
                            if ($tripay->data->status == 'UNPAID') {
                                echo '<small class="text-danger">Menunggu Pembayaran</small>';
                            } else if ($tripay->data->status == 'PAID') {
                                echo '<small class="text-success">Lunas</small>';
                            } else if ($tripay->data->status == 'EXPIRED') {
                                echo '<small class="text-danger">Kadaluarsa</small>';
                            } else {
                                echo '<small class="text-danger">Gagal</small>';
                            }
                            ?>
                        </strong>
                    </div>
                </li>
                <?php if ($tripay->data->status == 'UNPAID') { ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <h6 class="my-0">Batas Pembayaran</h6>
                        <span class="text-danger"><strong><?= tanggal_indo(date("Y-m-d", $tripay->data->expired_time)) .  ' ' .  date("H:i", $tripay->data->expired_time)  ?> WIB</strong></span>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <div class="d-flex justify-content-center">
            <a href="<?= base_url() ?>user/invoice" class="btn btn-success btn-sm me-2" type="button">
                <i class=" fas fa-arrow-left"></i> Kembali</a>

            <button type="button" class="btn btn-primary btn-sm" onclick='openModal()'>Cara Pembayaran</button>
            <br />
        </div>
        <footer class="text-center mt-4">
            <small>Secure Payment by <a style="text-decoration:none;" href="#"><img src="https://tripay.co.id/images/logo.png" style="height:20px;margin-left: 7px;" alt="TriPay"></a></small>
        </footer>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h7 class="modal-title" id="exampleModalLabel">Petunjuk Pembayaran
                    <?php
                    echo $tripay->data->payment_name;
                    ?>
                </h7>
            </div>

            <div class="modal-body" style="padding:0 !important;">
                <?php foreach ($tripay->data->instructions as $row) { ?>
                    <button id="instructionstitle" class="accordion"><?= $row->title ?><div class="btnarrow"> <i class="arrow"></i></div></button>
                    <div class="accordion-content">
                        <ol type="1" style="margin-top:5px;margin-left:5px;margin-bottom:5px;">
                            <?php foreach ($row->steps as $steps) { ?>
                                <li><?= $steps ?></li>
                            <?php } ?>
                        </ol>
                    </div>
                <?php } ?>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-secondary btn-sm" onclick="closeModal()">Tutup</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" onclick="closeQR()" id="zoomModal" tabindex="-1" aria-labelledby="zoomModalLabel" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body" style="padding:0 !important;">
                <img onclick="closeQR()" src="<?= $tripay->data->qr_url ?>" width="100%" height="100%" />
            </div>
        </div>
    </div>
</div>

<div class="modal-backdrop fade show" id="backdrop" style="display: none;"></div>

<?php $this->load->view('templates/invoice/footer'); ?>