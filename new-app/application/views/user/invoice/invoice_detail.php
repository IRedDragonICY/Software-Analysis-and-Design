<?php $this->load->view('templates/new-invoice/header'); ?>
<?php foreach ($content as $cetak) {
    foreach ($service as $data) {


?>
        <div class="tm_container">
            <div class="tm_invoice_wrap">
                <div class="tm_invoice tm_style2 tm_type1 tm_accent_border tm_radius_0 tm_small_border" id="tm_download_section">
                    <div class="tm_invoice_in">
                        <div class="tm_invoice_head tm_mb20 tm_m0_md">
                            <div class="tm_invoice_left">
                                <div class="tm_logo"><img src="<?= base_url() ?>assets/images/neptune.png" crossorigin="anonymous" alt="Logo"></div>
                            </div>
                            <div class="tm_invoice_right">
                                <div class="tm_grid_row tm_col_3">
                                    <div class="tm_text_center">
                                        <p class="tm_accent_color tm_mb0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512" fill="currentColor">
                                                <path d="M424 80H88a56.06 56.06 0 00-56 56v240a56.06 56.06 0 0056 56h336a56.06 56.06 0 0056-56V136a56.06 56.06 0 00-56-56zm-14.18 92.63l-144 112a16 16 0 01-19.64 0l-144-112a16 16 0 1119.64-25.26L256 251.73l134.18-104.36a16 16 0 0119.64 25.26z" />
                                            </svg>
                                        </p>
                                        admin@fiberdelta.net <br>
                                        adidarmawan@fiberdelta.net
                                    </div>
                                    <div class="tm_text_center">
                                        <p class="tm_accent_color tm_mb0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512" fill="currentColor">
                                                <path d="M391 480c-19.52 0-46.94-7.06-88-30-49.93-28-88.55-53.85-138.21-103.38C116.91 298.77 93.61 267.79 61 208.45c-36.84-67-30.56-102.12-23.54-117.13C45.82 73.38 58.16 62.65 74.11 52a176.3 176.3 0 0128.64-15.2c1-.43 1.93-.84 2.76-1.21 4.95-2.23 12.45-5.6 21.95-2 6.34 2.38 12 7.25 20.86 16 18.17 17.92 43 57.83 52.16 77.43 6.15 13.21 10.22 21.93 10.23 31.71 0 11.45-5.76 20.28-12.75 29.81-1.31 1.79-2.61 3.5-3.87 5.16-7.61 10-9.28 12.89-8.18 18.05 2.23 10.37 18.86 41.24 46.19 68.51s57.31 42.85 67.72 45.07c5.38 1.15 8.33-.59 18.65-8.47 1.48-1.13 3-2.3 4.59-3.47 10.66-7.93 19.08-13.54 30.26-13.54h.06c9.73 0 18.06 4.22 31.86 11.18 18 9.08 59.11 33.59 77.14 51.78 8.77 8.84 13.66 14.48 16.05 20.81 3.6 9.53.21 17-2 22-.37.83-.78 1.74-1.21 2.75a176.49 176.49 0 01-15.29 28.58c-10.63 15.9-21.4 28.21-39.38 36.58A67.42 67.42 0 01391 480z" />
                                            </svg>
                                        </p>
                                        +62xxxxxxxxxxx <br>
                                        +62xxxxxxxxxxx
                                    </div>
                                    <div class="tm_text_center">
                                        <p class="tm_accent_color tm_mb0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512" fill="currentColor">
                                                <circle cx="256" cy="192" r="32" />
                                                <path d="M256 32c-88.22 0-160 68.65-160 153 0 40.17 18.31 93.59 54.42 158.78 29 52.34 62.55 99.67 80 123.22a31.75 31.75 0 0051.22 0c17.42-23.55 51-70.88 80-123.22C397.69 278.61 416 225.19 416 185c0-84.35-71.78-153-160-153zm0 224a64 64 0 1164-64 64.07 64.07 0 01-64 64z" />
                                            </svg>
                                        </p>
                                        Jakarta Timur <br>
                                        Indonesia
                                    </div>
                                </div>
                            </div>
                            <div class="tm_shape_bg tm_accent_bg_10 tm_border tm_accent_border_20"></div>
                        </div>
                        <div class="tm_invoice_info tm_mb30 tm_align_center">
                            <div class="tm_invoice_info_left tm_mb20_md">
                                <p class="tm_mb0">
                                    <b class="tm_primary_color">Nomor Invoice: </b><br /> <?= $cetak->code ?> <br>
                                    <input type="hidden" id="nameinvoice" value="<?= $cetak->code ?>">
                                    <b class="tm_primary_color">Tanggal Faktur: </b><br /><?= tanggal_indo($cetak->date) ?>
                                </p>
                            </div>
                            <div class="tm_invoice_info_right">
                                <div class="tm_border tm_accent_border_20 tm_radius_0 tm_accent_bg_10 tm_curve_35 tm_text_center">
                                    <div>
                                        <?php
                                        if ($cetak->status == 'Unpaid') {
                                            $text =  "BELUM TERBAYAR";
                                        } else if ($cetak->status == "Paid") {
                                            $text =  "SUDAH TERBAYAR";
                                        } else if ($cetak->status == "Error") {
                                            $text =  "DIBATALKAN OLEH SISTEM";
                                        }
                                        ?>
                                        <b class="tm_accent_color tm_f26 tm_medium tm_danger_color"><?= $text ?></b>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h2 class="tm_f16 tm_section_heading tm_accent_border_20 tm_mb0"><span class="tm_accent_bg_10 tm_radius_0 tm_curve_35 tm_border tm_accent_border_20 tm_border_bottom_0 tm_accent_color"><span>Invoice To</span></span></h2>
                        <div class="tm_table tm_style1 tm_mb30">
                            <div class="tm_border  tm_accent_border_20 tm_border_top_0">
                                <div class="tm_table_responsive">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td class="tm_width_6 tm_border_top_0">
                                                    <b class="tm_primary_color tm_medium">Nama: </b><?= $cetak->nama ?>
                                                </td>
                                                <td class="tm_width_6 tm_border_top_0 tm_border_left tm_accent_border_20">
                                                    <b class="tm_primary_color tm_medium">Tagihan : </b>Rp <?= number_format($cetak->price) ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="tm_width_6 tm_accent_border_20">
                                                    <b class="tm_primary_color tm_medium">ID Pelanggan : </b><?= $cetak->idpel ?>
                                                </td>
                                                <td class="tm_width_6 tm_border_left tm_accent_border_20">
                                                    <b class="tm_primary_color tm_medium">Tanggal Tagihan : </b> <?= tgl_indo($cetak->date)  ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tm_table tm_style1">
                            <div class="tm_border tm_accent_border_20">
                                <div class="tm_table_responsive">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="tm_width_3 tm_semi_bold tm_accent_color tm_accent_bg_10">Deskripsi</th>
                                                <th class="tm_width_4 tm_semi_bold tm_accent_color tm_accent_bg_10 tm_text_center">Tanggal Tagihan</th>
                                                <th class="tm_width_4 tm_semi_bold tm_accent_color tm_accent_bg_10 tm_text_right">Tanggal Jatuh Tempo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="tm_width_3 tm_accent_border_20"><?= $cetak->package ?> </td>
                                                <td class="tm_width_4 tm_accent_border_20 tm_text_center"><?= tgl_indo($cetak->date)   ?></td>
                                                <td class="tm_width_4 tm_accent_border_20 tm_text_right"><?= tgl_indo($cetak->expdate)   ?></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tm_invoice_footer tm_mb15 tm_m0_md">
                                <div class="tm_left_footer">

                                </div>
                                <div class="tm_right_footer">
                                    <table class="tm_mb15 tm_m0_md">
                                        <tbody>
                                            <tr>
                                                <td class="tm_width_3 tm_primary_color tm_border_none tm_medium">Tagihan</td>
                                                <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_medium">Rp <?= number_format($data->harga) ?></td>
                                            </tr>
                                            <td class="tm_width_3 tm_primary_color tm_border_none tm_pt0">Pajak 11%</td>
                                            <?php
                                            $harga = $data->harga;
                                            $ppn = $data->ppn;
                                            $ppnnya = $harga * $ppn / 100;
                                            ?>

                                            <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_pt0">+ Rp <?= number_format($ppnnya) ?> </td>

                                            <tr class="tm_accent_border_20 tm_border">
                                                <td class="tm_width_3 tm_bold tm_f16 tm_border_top_0 tm_accent_color tm_accent_bg_10">Total Tagihan </td>
                                                <td class="tm_width_3 tm_bold tm_f16 tm_border_top_0 tm_accent_color tm_text_right tm_accent_bg_10">Rp <?= number_format($cetak->price) ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <div class="tm_bottom_invoice tm_accent_border_20">
                            <div class="tm_bottom_invoice_left">
                                <p class="tm_m0 tm_f18 tm_accent_color tm_mb5">Terimakasih sudah memilih kami.</p>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="tm_invoice_btns tm_hide_print">
                    <a href="javascript:window.print()" class="tm_invoice_btn tm_color1">
                        <span class="tm_btn_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                                <path d="M384 368h24a40.12 40.12 0 0040-40V168a40.12 40.12 0 00-40-40H104a40.12 40.12 0 00-40 40v160a40.12 40.12 0 0040 40h24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32" />
                                <rect x="128" y="240" width="256" height="208" rx="24.32" ry="24.32" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32" />
                                <path d="M384 128v-24a40.12 40.12 0 00-40-40H168a40.12 40.12 0 00-40 40v24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32" />
                                <circle cx="392" cy="184" r="24" fill='currentColor' />
                            </svg>
                        </span>
                        <span class="tm_btn_text">Print</span>
                    </a>
                    <button id="tm_download_btn" class="tm_invoice_btn tm_color2">
                        <span class="tm_btn_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                                <path d="M320 336h76c55 0 100-21.21 100-75.6s-53-73.47-96-75.6C391.11 99.74 329 48 256 48c-69 0-113.44 45.79-128 91.2-60 5.7-112 35.88-112 98.4S70 336 136 336h56M192 400.1l64 63.9 64-63.9M256 224v224.03" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" />
                            </svg>
                        </span>
                        <span class="tm_btn_text">Download</span>

                    </button>
                </div>
            </div>
        </div>
<?php }
} ?>
<?php $this->load->view('templates/new-invoice/footer'); ?>