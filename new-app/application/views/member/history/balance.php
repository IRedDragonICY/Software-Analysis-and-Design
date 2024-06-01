<?php $this->load->view('templates/member/header'); ?>

<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>History Saldo </h1>
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
                                                    <th>No </th>
                                                    <th>Tanggal/Waktu</th>
                                                    <th>Tipe</th>
                                                    <th>Kategori</th>
                                                    <th>Jumlah</th>
                                                    <th>Deskripsi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                foreach ($content as $row) {

                                                ?>
                                                    <tr>
                                                        <td><?= $i++ ?></td>
                                                        <td><?= tgl_indo($row->date) ?> <?= $row->time ?></td>
                                                        <td><?= $row->type ?></td>
                                                        <?php
                                                        if ($row->category == 'Deposit') {
                                                            $label = "success";
                                                            $pes = "DEPOSIT";
                                                        } else if ($row->category == 'Pembelian') {
                                                            $label = "danger";
                                                            $pes = "PEMBELIAN";
                                                        }

                                                        ?>

                                                        <td><label class="btn btn-<?= $label ?>"><?= $pes ?></label></td>
                                                        <td>Rp <?php echo number_format($row->balance) ?></td>

                                                        <td><?= $row->message ?> </td>


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