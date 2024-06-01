<?php $pg = $this->db->get('payment_gateway')->row_array(); ?>
<?php $discount = $invoice->disc_coupon ?>
<?php $Customer = $this->db->get_where('customer', ['no_services' => $invoice->no_services])->row_array(); ?>
<?php if ($Customer['codeunique'] == 1) { ?>
    <?php $code_unique = $invoice->code_unique ?>
<?php } ?>
<?php if ($Customer['codeunique'] == 0) { ?>
    <?php $code_unique = 0 ?>
<?php } ?>
<?php
$month =   $invoice->month;
$year = $invoice->year;
$no_services = $invoice->no_services;
$query = "SELECT *
                            FROM `invoice_detail`
                                WHERE `invoice_detail`.`d_month` =  $month and
                               `invoice_detail`.`d_year` =  $year and
                               `invoice_detail`.`d_no_services` =  $no_services";
$queryTot = $this->db->query($query)->result(); ?>
<?php $subTotaldetail = 0;
foreach ($queryTot as  $dataa)
    $subTotaldetail += (int) $dataa->total;
?>
<?php $ppn = $subTotaldetail * ($invoice->i_ppn / 100) ?>
<?php if ($invoice->amount != 0) { ?>
    <?php $tagihan = $invoice->amount + $code_unique - $discount ?>
<?php } ?>
<?php if ($invoice->amount == 0) { ?>
    <?php $tagihan = $subTotaldetail  + $code_unique + $ppn - $discount ?>
<?php } ?>

<?php if ($pg['vendor'] == 'Tripay') { ?>
    <?php if ($invoice->reference != '') { ?>
        <?php
        $apiKey = $pg['api_key'];

        $payload = ['reference'    => $invoice->reference];
        // $payload = ['reference'    => 'T52301519724TJYYH'];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_FRESH_CONNECT  => true,
            CURLOPT_URL            => 'https://tripay.co.id/api/transaction/detail?' . http_build_query($payload),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $apiKey],
            CURLOPT_FAILONERROR    => false,
        ]);

        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        $result = json_decode($response, true);
        // var_dump($result);
        // die;
        // var_dump($result['data']['status']);
        // die;
        ?>

        <?php if ($result['data']['status'] == 'PAID') { ?>
            <?php
            $updateinvoice = [
                'status' => 'SUDAH BAYAR',
                'date_payment' => $result['data']['paid_at'],
                'metode_payment' => 'Payment Gateway',
            ];
            $this->db->where('invoice', $invoice->invoice);
            $this->db->update('invoice', $updateinvoice);
            $addincome = [
                'nominal' => $tagihan,
                'date_payment' => date('Y-m-d', $result['data']['paid_at']),
                'remark' => 'Pembayaran Tagihan no layanan' . ' ' . $invoice->no_services . ' ' . 'a/n' . ' ' .  $Customer['name'] . ' ' . 'Periode' . ' ' . indo_month($invoice->month) . ' ' . $invoice->year . ' by Tripay ' . $result['data']['payment_method'],
                'invoice_id' => $invoice->invoice,
                'category' => 1,
                'create_by' => 0,
                'no_services' => $invoice->no_services,
                'mode_payment' => 'Payment Gateway',
                'created' => time()
            ];
            $this->db->insert('income', $addincome);
            $whatsapp = $this->db->get('whatsapp')->row_array();
            if ($whatsapp['is_active'] == 1) {


                if ($whatsapp['paymentinvoice'] == 1) {

                    $other = $this->db->get('other')->row_array();

                    $company = $this->db->get('company')->row_array();

                    $nominalWA = indo_currency($invoice['amount'] - $invoice['disc_coupon']);

                    $search  = array('{name}', '{noservices}', '{nova}', 'phone', '{email}', '{invoice}', '{month}', '{year}', '{period}', '{duedate}', '{nominal}', '{companyname}',  '{slogan}', '{link}', '{e}');



                    $replace = array($customer['name'], $customer['no_services'], $customer['no_va'], $customer['no_wa'], $customer['email'], $invoice['invoice'], $invoice['month'], $invoice['year'], $invoice['month'] . ' ' . $invoice['year'], $customer['due_date'], $nominalWA, $company['company_name'], $company['sub_name'], base_url(), '');

                    $subject = $other['thanks_wa'];

                    $message = str_replace($search, $replace, $subject);

                    $target = indo_tlp($customer['no_wa']);

                    sendmsg($target, $message);
                }
            }
            ?>
        <?php } ?>
        <?php if ($result['data']['status'] != 'EXPIRED') { ?>
            <?php redirect($invoice->payment_url) ?>
        <?php } ?>

    <?php } ?>



<?php } ?>
<div class="row">
    <div class="col-md-6">
        <div class="card shadow mb-2">

            <div class="card-header py-1">

                <h6 class="m-0 font-weight-bold">Tagihan Periode <?= indo_month($invoice->month); ?> <?= $invoice->year; ?></h6>

            </div>

            <div class="card-body">
                <?php if ($pg['vendor'] == 'Tripay') { ?>

                    <?php

                    $apiKey = $pg['api_key'];

                    $payload = ['reference'    => $invoice->reference];
                    // $payload = ['reference'    => 'T52301519724TJYYH'];

                    $curl = curl_init();

                    curl_setopt_array($curl, [
                        CURLOPT_FRESH_CONNECT  => true,
                        CURLOPT_URL            => 'https://tripay.co.id/api/transaction/detail?' . http_build_query($payload),
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_HEADER         => false,
                        CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $apiKey],
                        CURLOPT_FAILONERROR    => false,
                    ]);

                    $response = curl_exec($curl);
                    $error = curl_error($curl);

                    curl_close($curl);

                    $result = json_decode($response, true);

                    // var_dump($result['data']['status']);
                    // die;
                    ?>
                    <form action="<?= base_url('tripay/checkout'); ?>" method="post">
                        <div class="modal-body">
                            <input type="hidden" name="invoice" value="<?= $invoice->invoice ?>">
                            <input type="hidden" name="no_services" value="<?= $invoice->no_services ?>">
                            <input type="hidden" name="amount" id="amounttripay" value="<?= $tagihan + $pg['admin_fee'] ?>">
                            <?php if ($pg['mode'] == 0) { ?>
                                <span>Ini dalam mode sandbox (Test), dilarang melakukan pembayaran nyata !</span> <br><br>
                            <?php } ?>
                            <?php if ($discount == 0) { ?>
                                <?php $coupon = $this->db->get_where('coupon', ['is_active' => 1])->result() ?>
                                <?php if (count($coupon) > 0) { ?>
                                    <div class="form-group" id="infocoupontripay">
                                        Makin Hemat gunakan kode kupon, <a href="" class="btn btn-outline-primary" data-toggle="modal" data-target="#kuponModal">Daftar Kupon</a> <br>
                                        Copy kode ke form kode kupon dibawah <br>
                                        Klik dulu Cek Kupon sebelum Checkout
                                    </div>
                                    <span id="notifrefreshtripay" style="display: none;">Silahkan refresh untuk menggunakan kode kupon yang lain <a href="" class="btn btn-outline-info">Refresh</a></span>
                                    <div class="modal fade" id="kuponModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="demoModalLabel">Kode Kupon</h5>

                                                </div>
                                                <div class="modal-body">
                                                    <?php foreach ($coupon as $coupon) { ?>
                                                        <div class="card proj-t-card">
                                                            <div class="card-body">
                                                                <div class="row align-items-center ">
                                                                    <div class="col-auto">
                                                                        <!-- <i class="fas fa-paper-plane text-green f-30"></i> -->
                                                                    </div>
                                                                    <div class="col pl-0">
                                                                        <span class="mb-5">Kode Kupon</span>
                                                                        <h6 class="mb-0 text-green"><?= $coupon->code; ?></h6>
                                                                        <?php if ($coupon->max_active == 1 && $coupon->max_limit > 0) { ?>
                                                                            <span>Maksimal <?= indo_currency($coupon->max_limit); ?></span>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                                <div class="row align-items-center text-left">
                                                                    <div class="col">
                                                                        <span class="mb-0"><?= $coupon->remark; ?></span>
                                                                    </div>

                                                                </div>
                                                                <h6 class="pt-badge bg-green"><?= $coupon->percent; ?> %</h6>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Kode Kupon</label>

                                        <div class="input-group mb-3">
                                            <input type="text" id="codecoupontripay" name="codecoupontripay" oninput="this.value = this.value.toUpperCase()" onKeyDown="if(event.keyCode === 32) return false;" class="form-control">
                                            <div class="input-group-append">
                                                <a href="#" id="cekcoupontripay" class="input-group-text">Cek Kupon</a>
                                            </div>
                                        </div>


                                        <span id="notifcoupontripay"></span>


                                    </div>
                                    <div class="form-group">
                                        <div class="loadingcekcoupontripay">
                                        </div>

                                    </div>

                                <?php } ?>
                            <?php } ?>
                            <div class="form-group">
                                <label for="">ID Pelanggan</label>
                                <input type="text" class="form-control" value="<?= $Customer['no_services']; ?>" readonly>

                            </div>
                            <div class="form-group">
                                <label for="">Nama</label>
                                <input type="text" class="form-control" value="<?= $Customer['name']; ?>" readonly>

                            </div>
                            <div class="form-group">
                                <label for="">Periode</label>
                                <input type="text" class="form-control" value="<?= indo_month($invoice->month); ?> <?= $invoice->year ?>" readonly>

                            </div>
                            <div class="form-group">
                                <label for="">Tagihan</label>
                                <input type="text" class="form-control" value="<?= indo_currency($tagihan); ?>" readonly>

                            </div>

                            <?php if ($pg['admin_fee'] > 0) { ?>
                                <div class="form-group">
                                    <label for="">Biaya Admin</label>
                                    <input type="text" class="form-control" value="<?= indo_currency($pg['admin_fee']); ?>" readonly>

                                </div>
                            <?php } ?>

                            <div class="form-group" id="formdisctripay" style="display: none;">
                                <label for="">Diskon Kupon</label>
                                <input type="text" id="disccoupontripay" class="form-control" readonly>
                                <input type="hidden" name="disccoupontripay" id="amountdisccoupontripay" class="form-control" readonly>

                            </div>
                            <?php

                            $apiKey = $pg['api_key'];

                            if ($pg['mode'] == 1) {
                                $url = "https://tripay.co.id/api/merchant/payment-channel"; // Production
                            } else {
                                $url = 'https://tripay.co.id/api-sandbox/merchant/payment-channel'; // Sandbox
                            }

                            $curl = curl_init();

                            curl_setopt_array($curl, array(
                                CURLOPT_FRESH_CONNECT     => true,
                                CURLOPT_URL               => $url,
                                CURLOPT_RETURNTRANSFER    => true,
                                CURLOPT_HEADER            => false,
                                CURLOPT_HTTPHEADER        => array(
                                    "Authorization: Bearer " . $apiKey
                                ),
                                CURLOPT_FAILONERROR       => false
                            ));

                            $response = curl_exec($curl);
                            $err = curl_error($curl);
                            $response = json_decode($response, true);
                            // curl_close($curl);
                            // var_dump($response['data'][0]['group']);
                            // echo !empty($err) ? $err : $response;

                            ?>
                            <div class="form-group">
                                <label for=""><span style="color: red;">(Otomatis Verifikasi)</span></label>

                                <select class="form-control" name="selectpaymenttripay" required>
                                    <option value="">-Pilih-</option>
                                    <?php foreach ($response['data'] as $data) { ?>
                                        <option value="<?= $data['code']; ?>"><?= $data['name']; ?></option>
                                    <?php } ?>

                                </select>
                            </div>


                            <div class="form-group">
                                <h4>Total yang harus dibayarkan : <span style="color: red;" id="amountgrostripay"><?= indo_currency($tagihan + $pg['admin_fee']); ?></span></h4>
                            </div>

                            <br>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" id="click-tripay" class="btn btn-primary">Checkout</button>
                            </div>
                    </form>


                <?php } ?>

                <?php if ($pg['vendor'] == 'Xendit') { ?>
                    <?php if ($invoice->x_id == '') { ?>
                        <form action="<?= base_url('payment/createinvoice'); ?>" method="post">
                            <div class="modal-body">
                                <input type="hidden" name="invoice" value="<?= $invoice->invoice ?>">
                                <input type="hidden" name="no_services" value="<?= $invoice->no_services ?>">
                                <input type="hidden" name="amount" id="amounttripay" value="<?= $tagihan + $pg['admin_fee'] ?>">
                                <?php if ($pg['mode'] == 0) { ?>
                                    <span>Ini dalam mode sandbox (Test), dilarang melakukan pembayaran nyata !</span> <br><br>
                                <?php } ?>

                                <div class="form-group">
                                    <label for="">Tagihan</label>
                                    <input type="text" class="form-control" value="<?= indo_currency($tagihan); ?>" readonly>

                                </div>
                                <?php if ($pg['admin_fee'] > 0) { ?>
                                    <div class="form-group">
                                        <label for="">Biaya Admin</label>
                                        <input type="text" class="form-control" value="<?= indo_currency($pg['admin_fee']); ?>" readonly>

                                    </div>
                                <?php } ?>



                                <div class="form-group">
                                    <h4>Total yang harus dibayarkan : <span style="color: red;" id="amountgrostripay"><?= indo_currency($tagihan + $pg['admin_fee']); ?></span></h4>
                                </div>

                                <br>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" id="click-xendit" class="btn btn-primary">Checkout</button>
                                </div>
                        </form>
                    <?php } ?>
                    <?php if ($invoice->x_id != '') { ?>
                        <?php if ($xendit['status'] == 'EXPIRED') { ?>
                            <form action="<?= base_url('payment/createinvoice'); ?>" method="post">
                                <div class="modal-body">
                                    <input type="hidden" name="invoice" value="<?= $invoice->invoice ?>">
                                    <input type="hidden" name="no_services" value="<?= $invoice->no_services ?>">
                                    <input type="hidden" name="amount" id="amounttripay" value="<?= $tagihan + $pg['admin_fee'] ?>">
                                    <?php if ($pg['mode'] == 0) { ?>
                                        <span>Ini dalam mode sandbox (Test), dilarang melakukan pembayaran nyata !</span> <br><br>
                                    <?php } ?>

                                    <div class="form-group">
                                        <label for="">Tagihan</label>
                                        <input type="text" class="form-control" value="<?= indo_currency($tagihan); ?>" readonly>

                                    </div>
                                    <?php if ($pg['admin_fee'] > 0) { ?>
                                        <div class="form-group">
                                            <label for="">Biaya Admin</label>
                                            <input type="text" class="form-control" value="<?= indo_currency($pg['admin_fee']); ?>" readonly>

                                        </div>
                                    <?php } ?>



                                    <div class="form-group">
                                        <h4>Total yang harus dibayarkan : <span style="color: red;" id="amountgrostripay"><?= indo_currency($tagihan + $pg['admin_fee']); ?></span></h4>
                                    </div>

                                    <br>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" id="click-xendit" class="btn btn-primary">Checkout</button>
                                    </div>
                            </form>
                        <?php } ?>
                        <?php if ($xendit['status'] != 'EXPIRED') { ?>
                            <a href="<?= $invoice->payment_url ?>" class="btn btn-primary">LANJUT BAYAR</a>
                        <?php } ?>
                    <?php } ?>

                <?php } ?>
                <?php if ($pg['vendor'] == 'Midtrans') { ?>
                    <form id="payment-form" method="post" action="<?= site_url() ?>/snap/finish">
                        <input type="hidden" name="result_type" id="result-type" value="">
                        <input type="hidden" name="result_data" id="result-data" value="">
                        <input type="hidden" name="invoice" id="invoice" value="<?= $invoice->invoice ?>">
                    </form>
                    <?php if ($pg['mode'] == 1) { ?>
                        <?php $url = "https://app.midtrans.com/snap/snap.js" ?>
                    <?php } ?>
                    <?php if ($pg['mode'] == 0) { ?>
                        <?php $url = "https://app.sandbox.midtrans.com/snap/snap.js" ?>
                    <?php } ?>
                    <script type="text/javascript" src="<?= $url ?>" data-client-key=<?= $pg['client_key'] ?>></script>
                    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

                    <div class="modal-body">
                        <input type="hidden" name="tagihan" id="tagihan" value="<?= $tagihan; ?>">
                        <input type="hidden" name="namapelanggan" id="namapelanggan" value="<?= $Customer['name'] ?>">
                        <input type="hidden" name="no_services" id="no_services" value="<?= $Customer['no_services'] ?>">
                        <input type="hidden" name="email" id="email" value="<?= $Customer['email'] ?>">
                        <input type="hidden" name="phone" id="phone" value="<?= $Customer['no_wa'] ?>">
                        <input type="hidden" name="address" id="address" value="<?= $Customer['address'] ?>">
                        <input type="hidden" name="biayaadmin" id="biayaadmin" value="<?= $pg['admin_fee'] ?>">
                        <input type="hidden" name="periode" id="periode" value="<?= indo_month($invoice->month) ?> <?= $invoice->year ?>">
                        <input type="hidden" name="invoice_id" id="invoice_id" value="<?= $invoice->invoice ?>">
                        <?php if ($pg['mode'] == 1) {
                            $link = 'https://app.midtrans.com/snap/v2/vtweb/';
                        } else {
                            $link = 'https://app.sandbox.midtrans.com/snap/v2/vtweb/';
                        } ?>
                        <?php if ($pg['mode'] == 0) { ?>
                            <span>Ini dalam mode sandbox (Test), dilarang melakukan pembayaran nyata !</span> <br><br>
                        <?php } ?>

                        <div class="form-group">
                            <label for="">ID Pelanggan</label>
                            <input type="text" class="form-control" value="<?= $Customer['no_services']; ?>" readonly>

                        </div>
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="text" class="form-control" value="<?= $Customer['name']; ?>" readonly>

                        </div>
                        <div class="form-group">
                            <label for="">Periode</label>
                            <input type="text" class="form-control" value="<?= indo_month($invoice->month); ?> <?= $invoice->year ?>" readonly>

                        </div>
                        <div class="form-group">
                            <label for="">Tagihan</label>
                            <input type="text" class="form-control" value="<?= indo_currency($tagihan); ?>" readonly>

                        </div>

                        <?php if ($pg['admin_fee'] > 0) { ?>
                            <div class="form-group">
                                <label for="">Biaya Admin</label>
                                <input type="text" class="form-control" value="<?= indo_currency($pg['admin_fee']); ?>" readonly>

                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <h4>Total yang harus dibayarkan : <span style="color: red;" id="amountgrostripay"><?= indo_currency($tagihan + $pg['admin_fee']); ?></span></h4>
                        </div>

                        <br>
                        <?php if ($invoice->transaction_time != '') { ?>
                            <?php $dateint = strtotime($invoice->transaction_time)  ?>
                            <?php $hari = $invoice->expired * 24 ?>
                            <?php if ($pg['mode'] == 1) {
                                $link = 'https://app.midtrans.com/snap/v2/vtweb/';
                            } else {
                                $link = 'https://app.sandbox.midtrans.com/snap/v2/vtweb/';
                            } ?>
                            <?php if ((time() - $dateint) < (60 * 60 * $hari)) { ?>
                                <a href="<?= $link . $invoice->token ?>" class="btn btn-danger" target="blank">LANJUT BAYAR</a>
                                <?php if ($invoice->pdf_url != '') { ?>
                                    <a href="<?= $invoice->pdf_url ?>" class="btn btn-secondary" target="blank">CARA BAYAR</a>
                                <?php } ?>

                            <?php } ?>
                            <?php if ((time() - $dateint) > (60 * 60 * $hari)) { ?>
                                <a href="" id="pay-button" class="btn btn-danger">BAYAR</a>
                            <?php } ?>
                        <?php } ?>
                        <?php if ($invoice->transaction_time == '') { ?>
                            <a href="" id="pay-button" class="btn btn-primary">Checkout</a>
                        <?php } ?>
                        </form>


                    <?php } ?>

                    <?php if ($pg['vendor'] == 'Duitku') { ?>


                        <form action="<?= base_url('duitku/checkout'); ?>" method="post">
                            <div class="modal-body">
                                <input type="hidden" name="invoice" value="<?= $invoice->invoice ?>">
                                <input type="hidden" name="no_services" value="<?= $invoice->no_services ?>">
                                <input type="hidden" name="amount" value="<?= $tagihan + $pg['admin_fee'] ?>">
                                <?php if ($pg['mode'] == 0) { ?>
                                    <span>Ini dalam mode sandbox (Test), dilarang melakukan pembayaran nyata !</span> <br><br>
                                <?php } ?>

                                <div class="form-group">
                                    <label for="">ID Pelanggan</label>
                                    <input type="text" class="form-control" value="<?= $Customer['no_services']; ?>" readonly>

                                </div>
                                <div class="form-group">
                                    <label for="">Nama</label>
                                    <input type="text" class="form-control" value="<?= $Customer['name']; ?>" readonly>

                                </div>
                                <div class="form-group">
                                    <label for="">Periode</label>
                                    <input type="text" class="form-control" value="<?= indo_month($invoice->month); ?> <?= $invoice->year ?>" readonly>

                                </div>
                                <div class="form-group">
                                    <label for="">Tagihan</label>
                                    <input type="text" class="form-control" value="<?= indo_currency($tagihan); ?>" readonly>

                                </div>

                                <?php if ($pg['admin_fee'] > 0) { ?>
                                    <div class="form-group">
                                        <label for="">Biaya Admin</label>
                                        <input type="text" class="form-control" value="<?= indo_currency($pg['admin_fee']); ?>" readonly>

                                    </div>
                                <?php } ?>

                                <div class="form-group" id="formdisctripay" style="display: none;">
                                    <label for="">Diskon Kupon</label>
                                    <input type="text" id="disccoupontripay" class="form-control" readonly>
                                    <input type="hidden" name="disccoupontripay" id="amountdisccoupontripay" class="form-control" readonly>

                                </div>
                                <?php

                                $apiKey = $pg['api_key'];



                                $merchantCode = $pg['kodemerchant'];
                                // Set your merchant key (Note: Server key for sandbox and production mode are different)
                                $merchantKey = $pg['api_key'];

                                $datetime = date('Y-m-d H:i:s');
                                $paymentAmount = '10000';
                                $signature = hash('sha256', $merchantCode . $paymentAmount . $datetime . $merchantKey);

                                $itemsParam = array(
                                    'merchantcode' => $merchantCode,
                                    'amount' => $paymentAmount,
                                    'datetime' => $datetime,
                                    'signature' => $signature
                                );

                                class emp
                                {
                                }

                                $params = array_merge((array)$result, $itemsParam);

                                $params_string = json_encode($params);

                                if ($pg['mode'] == 1) {
                                    $url = "https://passport.duitku.com/webapi/api/merchant/paymentmethod/getpaymentmethod"; // Production
                                } else {
                                    $url = 'https://sandbox.duitku.com/webapi/api/merchant/paymentmethod/getpaymentmethod'; // Sandbox
                                }

                                $ch = curl_init();

                                curl_setopt($ch, CURLOPT_URL, $url);
                                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt(
                                    $ch,
                                    CURLOPT_HTTPHEADER,
                                    array(
                                        'Content-Type: application/json',
                                        'Content-Length: ' . strlen($params_string)
                                    )
                                );
                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

                                //execute post
                                $response = curl_exec($ch);
                                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                                if ($httpCode == 200) {
                                    $response = json_decode($response, true);
                                }
                                //  else {
                                //     $response = new emp();
                                //     $response->statusMessage = "Server Error . $httpCode ";
                                //     $response->error = $httpCode;
                                // }

                                ?>
                                <div class="form-group">
                                    <label for=""><span style="color: red;">(Otomatis Verifikasi)</span></label> *Biaya Admin <?= indo_currency($pg['admin_fee']); ?>
                                    <select class="form-control" name="selectpaymentduitku" required>
                                        <option value="">-Pilih-</option>
                                        <?php foreach ($response['paymentFee'] as $data) { ?>
                                            <option value="<?= $data['paymentMethod']; ?>"><?= $data['paymentName']; ?></option>
                                        <?php } ?>


                                    </select>
                                </div>


                                <div class="form-group">
                                    <h4>Total yang harus dibayarkan : <span style="color: red;" id="amountgrostripay"><?= indo_currency($tagihan + $pg['admin_fee']); ?></span></h4>
                                </div>

                                <br>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" id="click-tripay" class="btn btn-primary">Checkout</button>
                                </div>
                        </form>


                    <?php } ?>
                    </div>
            </div>
        </div>
    </div>
    <script>
        $('#cekcoupontripay').click(function(event) {
            var code = $("#codecoupontripay").val();
            var no_services = $("#no_services").val();
            var amount = $("#amounttripay").val();
            var url = "<?= site_url('coupon/cekcoupon') ?>" + "/" + Math.random();
            if (code == '') {
                $("#notifcoupontripay").html('Silahkan masukkan dulu kode kupon !');
                $("#codecoupontripay").focus();
            } else {
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: "&code=" + code + "&no_services=" + no_services + "&amount=" + amount,
                    cache: false,

                    beforeSend: function() {

                        $('.loadingcekcoupontripay').html(` <div class="container">
        <div class="text-center">
            <div class="spinner-border text-primary" style="width: 5rem; height: 5rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>`);
                    },
                    success: function(data) {
                        var c = jQuery.parseJSON(data);

                        $('.loadingcekcoupontripay').html('');
                        var disct = c['disc'];
                        var disc = disct.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        var gros = amount - disct;
                        var gross = gros.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        $("#disccoupontripay").val(disc);
                        $("#amountdisccoupontripay").val(c['disc']);
                        $("#notifcoupontripay").html(c['remark']);

                        if (c['disc'] > 0) {
                            $("#formdisctripay").show();
                            $("#cekcoupontripay").hide();
                            $("#infocoupontripay").hide();
                            $("#notifrefreshtripay").show();
                            $("#amounttripay").val(amount - disct);
                            $("#amountgrostripay").html(gross);
                        }


                    }
                });
            }
            return false;
        });
    </script>

    <style>
        :root {
            --light-color: rgba(10, 10, 220, .2);
            --dark-color: rgba(10, 10, 220, 1);
            --radius: 64px;
            --ring-width: 4px;
        }

        /* reset */
        * {
            margin: 0;
            padding: 0;
        }

        /* ring position */

        /* loading element style */
        .loading {
            width: var(--radius);
            height: var(--radius);
            border-radius: 50%;
            border: var(--ring-width) solid var(--light-color);
        }

        .loading:before {
            display: block;
            position: relative;
            left: calc(var(--ring-width) * -1);
            top: calc(var(--ring-width) * -1);
            content: ' ';
            width: var(--radius);
            height: var(--radius);
            border-radius: 50%;
            border: var(--ring-width) solid;
            border-color: var(--dark-color) transparent transparent transparent;
            animation: loading-rotate .8s ease-out infinite;
        }

        @keyframes loading-rotate {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    <div class="modal fade" id="popup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="loading"></div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $("#popup").modal({
                show: false,
                backdrop: 'static'
            });
        });
        $("#click-tripay").click(function() {
            $("#popup").modal("show");
            $("#tripay").modal("hide");
        });
        $("#click-xendit").click(function() {
            $("#popup").modal("show");
            $("#xendit").modal("hide");
        });
        $("#click-duitku").click(function() {
            $("#popup").modal("show");
            $("#duitku").modal("hide");
        });
    </script>
    <script type="text/javascript">
        $('#pay-button').click(function(event) {
            event.preventDefault();
            $(this).attr("disabled", "disabled");

            var tagihan = $("#tagihan").val();
            var namapelanggan = $("#namapelanggan").val();
            var no_services = $("#no_services").val();
            var periode = $("#periode").val();
            var email = $("#email").val();
            var phone = $("#phone").val();
            var address = $("#address").val();
            var biayaadmin = $("#biayaadmin").val();
            var invoice_id = $("#invoice_id").val();
            var invoice = $("#invoice").val();

            $.ajax({
                type: 'POST',
                url: '<?= site_url() ?>snap/token',
                data: {
                    tagihan: tagihan,
                    namapelanggan: namapelanggan,
                    no_services: no_services,
                    periode: periode,
                    email: email,
                    phone: phone,
                    address: address,
                    biayaadmin: biayaadmin,
                    invoice_id: invoice_id,
                    invoice: invoice,
                },
                cache: false,

                success: function(data) {
                    //location = data;

                    console.log('token = ' + data);

                    var resultType = document.getElementById('result-type');
                    var resultData = document.getElementById('result-data');

                    function changeResult(type, data) {
                        $("#result-type").val(type);
                        $("#result-data").val(JSON.stringify(data));

                        //resultType.innerHTML = type;
                        //resultData.innerHTML = JSON.stringify(data);
                    }

                    snap.pay(data, {

                        onSuccess: function(result) {
                            changeResult('success', result);
                            console.log(result.status_message);
                            console.log(result);
                            $("#payment-form").submit();
                        },
                        onPending: function(result) {
                            changeResult('pending', result);
                            console.log(result.status_message);
                            $("#payment-form").submit();
                        },
                        onError: function(result) {
                            changeResult('error', result);
                            console.log(result.status_message);
                            $("#payment-form").submit();
                        }
                    });
                }
            });
        });
    </script>