<style>
    .qrcode {
        height: 80px;
        width: 80px;
    }
</style>
<?php

foreach ($router as $data) {
    $dns = $data->dns;
}
foreach ($comment as $datanya) {
    $vouchernya = $datanya->kode;
}

foreach ($service as $services) {
    $paket = $services->service;
    $uptime = $services->uptime;
    $timelimit = $services->timelimit;
    $price = $services->harga;
    $vouchernya;
    $dns;
    $totalnya = $total;

    $url = urlencode('http://' . $dns . '/login?username=' . $vouchernya . '&password=' . $vouchernya);
}

for ($i = 0; $i < $totalnya; $i++) {





?>
    <table class="voucher" style=" width: 220px;">
        <tbody>
            <!-- Logo Hotspotname -->
            <tr>
                <td style="text-align: left; font-size: 14px; font-weight:bold; border-bottom: 1px black solid;"><img src="<?= $logo; ?>" alt="logo" style="height:30px;border:0;"> <?= $dns; ?> </td>
            </tr>
            <!-- /  -->
            <tr>
                <td>
                    <table style=" text-align: center; width: 210px; font-size: 12px;">
                        <tbody>
                            <!-- Username Password QR    -->
                            <tr>
                                <td>
                                    <table style="width:100%;">
                                        <!-- Username = Password    -->
                                        <tr>
                                            <td font-size: 12px;>Kode Voucher</td>
                                        </tr>
                                        <tr>
                                            <td style="width:100%; border: 1px solid black; font-weight:bold; font-size:16px;"><?= $vouchernya; ?></td>
                                        </tr>
                                        <!-- /  -->
                                        <!-- Username & Password  -->

                                        <!-- Check QR  -->



                                        <!-- /  -->
                                    </table>
                                </td>
                                <!-- QR Code    -->

                                <!-- /  -->
                            <tr>
                                <!-- Price  -->
                                <td colspan="2" style="border-top: 1px solid black;font-weight:bold; font-size:16px"><?= $uptime; ?> <?= $timelimit; ?> <?= $price; ?></td>
                                <!-- /  -->
                            </tr>
                            <tr>
                                <!-- Note  -->
                                <td colspan="2" style="font-weight:bold; font-size:12px">Login: http://<?= $dns; ?></td>
                                <!-- /  -->
                            </tr>
                            <!-- /  -->
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
<?php
}


?>