<!DOCTYPE html>
<html>

<head>
    <title><?= $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="{$_theme}/images/favicon.ico">
    <style>
        .v_wrapper {
            width: 241px;
            padding: 0 5px 5px 0;
            display: inline-block;
            border-right: 1px dashed #999;
            border-bottom: 1px dashed #999;
        }

        .table_printed {
            border: 1px solid #ccc;
            font-family: arial;
            font-size: 12px;
        }

        .td_header {
            border-bottom: 1px solid #ccc;
            background: #ddd !important;
            text-align: center;
        }

        .td_body_title {
            text-align: left;
        }

        .td_body_content {
            text-align: right;
        }

        .td_footer {
            border-bottom: 1px solid #ccc;
            background: #eee !important;
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

        $timelimit = $uptime;


        if (substr($timelimit, -1) == "d" & strlen($timelimit) > 3) {
            $timelimit = "" . ((substr($timelimit, 0, -1) * 7) +  substr($timelimit, 2, 1)) . " HARI";
        } else if (substr($timelimit, -1) == "d") {
            $timelimit = "" . substr($timelimit, 0, -1) . " HARI";
        } else if (substr($timelimit, -1) == "h") {
            $timelimit = "" . substr($timelimit, 0, -1) . " Jam";
        } else if (substr($timelimit, -1) == "w") {
            $timelimit = "" . (substr($timelimit, 0, -1) * 7) . " HARI";
        }

        $url = urlencode('http://' . $dns . '/login?username=' . $vouchernya . '&password=' . $vouchernya);
    }

    for ($i = 0; $i < $totalnya; $i++) {





    ?>

        <div class="v_wrapper">
            <table class="table_printed" width="100%">
                <tr>
                    <th colspan="3" class="td_header"><span style="padding:10px;font-size:15px;">** Voucher <?= $paket ?> **</span></th>
                </tr>
                <tr>
                    <td rowspan="6">
                        <img style="-webkit-user-select: none;margin: auto;background-color: hsl(0, 0%, 90%);transition: background-color 300ms;" src="https://api.qrserver.com/v1/create-qr-code/?size=60x60&amp;data='<?php echo $url; ?>'">
                    </td>
                </tr>
                <tr>
                    <td class="td_body_title"><span style="padding:5px;">Kode Voucher</span></td>
                    <td class="td_body_content"><span style="padding:5px;"><b><?= $vouchernya ?></b></span></td>
                </tr>

                <tr>
                    <td class="td_body_title"><span style="padding:5px;">Uptime</span></td>
                    <td class="td_body_content"><span style="padding:5px;"><b><?= $timelimit ?></b></span></td>
                </tr>

                <tr>
                    <td class="td_body_title"><span style="padding:5px;">Harga</span></td>
                    <td class="td_body_content"><span style="padding:5px;"><b>Rp <?= number_format($price) ?></b></span></td>
                </tr>
                <tr>
                    <td style="text-align: center" colspan="3"><span style="color:#008899;">Login: <span style="color:#ff7777">http://<?php echo $dns; ?></span></span></td>
                </tr>
            </table>
        </div>

    <?php
    }


    ?>
</head>

<body>
    <page size="A4">
        <form method="post" class="no-print">
            <table width="100%" border="0" cellspacing="0" cellpadding="1" class="btn btn-default btn-sm">
                <script>
                    window.onload = function() {
                        window.print();
                    }
                </script>