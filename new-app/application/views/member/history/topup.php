<?php $this->load->view('templates/member/header'); ?>

<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>History Isi Saldo </h1>
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
                                                    <th>No</th>
                                                    <th>Tanggal</th>
                                                    <th>Faktur</th>
                                                    <th>Metode</th>
                                                    <th>Saldo Diterima</th>
                                                    <th>Status</th>
                                                    <th>Detail</th>
                                                    <th>#</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                foreach ($content as $row) {

                                                ?>
                                                    <tr>
                                                        <td><?= $i++ ?></td>
                                                        <td><?php echo tgl_indo($row->date) ?></td>
                                                        <td>#<?php echo $row->code ?></td>
                                                        <td><?php echo $row->method ?></td>

                                                        <td>Rp <?php echo number_format($row->price) ?></td>
                                                        <?php
                                                        if ($row->status == "Paid") {
                                                            $label = "success";
                                                        } else if ($row->status == "Unpaid") {
                                                            $label = "warning";
                                                        } else if ($row->status == "Error") {
                                                            $label = "danger";
                                                        }
                                                        ?>
                                                        <td><label class="btn btn-<?= $label ?>"><?php echo $row->status ?></label></td>

                                                        <td>
                                                            <a href="<?= base_url("member/topup/detail/$row->code") ?> " class="btn btn-sm btn-info" target="_blank"><i class="material-icons-outlined">
                                                                    history
                                                                </i><strong> Detail Topup </strong></a>
                                                        </td>

                                                        <td>

                                                            <a href="<?= base_url("member/invoice/detail/$row->code") ?> " class="btn btn-sm btn-primary" target="_blank"><i class="material-icons-outlined">
                                                                    print
                                                                </i><strong> Print Invoice </strong></a>
                                                        </td>
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