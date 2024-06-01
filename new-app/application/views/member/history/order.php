<?php $this->load->view('templates/member/header'); ?>

<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>History Pembelian </h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12 col-lg-7">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <!-- Card Body -->
                        <div class="card-body">

                            <div class="col-lg-12">
                                <div class="row">

                                    <div class="table-responsive">
                                        <table id="datatable1" class="display" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>ID Pesanan</th>
                                                    <th>Paket </th>
                                                    <th>Tanggal</th>
                                                    <th>Harga</th>
                                                    <th>Status Voucher</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                foreach ($content as $row) {

                                                ?>
                                                    <tr>
                                                        <td><a href="<?= base_url("member/order/detail/$row->oid") ?> " class="btn btn-sm btn-success"><i class="material-icons-outlined">
                                                                    history
                                                                </i><strong> Detail Pembelian </strong></a></td>
                                                        <td><?php echo $row->oid ?></td>
                                                        <td><?php echo $row->service ?></td>
                                                        <td><?php echo tgl_indo($row->date) ?></td>
                                                        <?php
                                                        if ($row->status_v == "Belum digunakan") {
                                                            $label = "info";
                                                        } else if ($row->status_v == "Sudah digunakan") {
                                                            $label = "dark";
                                                        }
                                                        ?>
                                                        <td>Rp <?php echo number_format($row->harga) ?></td>

                                                        <td><label class="btn btn-<?= $label ?>"><?php echo $row->status_v ?></label></td>


                                                    </tr>
                                                <?php

                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php $this->load->view('templates/member/footer'); ?>