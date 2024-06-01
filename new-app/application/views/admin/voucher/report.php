<?php $this->load->view('templates/voucher/header'); ?>
<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Report Voucher </h1>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-xl-4">
                    <div class="card widget widget-stats">

                        <div class="card-body">
                            <div class="widget-stats-container d-flex">
                                <div class="widget-stats-icon widget-stats-icon-primary">
                                    <i class="material-icons-outlined">payment</i>
                                </div>
                                <div class="widget-stats-content flex-fill">
                                    <span class="widget-stats-title">Total Pendapatan bulan ini</span>
                                    <span class="widget-stats-info">Rp <?= number_format($credit) ?></span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Filter Data</h5>
                        </div>

                        <div class="card-body">
                            <div class="example-content">
                                <form class="row g-3" action=" <?php echo base_url("admin/voucher/report/filter"); ?>" role="form" method="POST">
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                    <div class="col-md-6">
                                        <label for="inputbulan" class="form-label">Bulan</label>
                                        <select class="form-select" aria-label="Default select example" name="bulan">
                                            <option value="1">Januari</option>
                                            <option value="2">Februari</option>
                                            <option value="3">Maret</option>
                                            <option value="4">April</option>
                                            <option value="5">Mei</option>
                                            <option value="6">Juni</option>
                                            <option value="7">Juli</option>
                                            <option value="8">Agustus</option>
                                            <option value="9">September</option>
                                            <option value="10">Oktober</option>
                                            <option value="11">November</option>
                                            <option value="12">Desember</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputtahun" class="form-label">Tahun</label>
                                        <select class="form-select" aria-label="Default select example" name="tahun">
                                            <?php foreach ($tahun as $row) : ?>

                                                <option value="<?php echo $row->tahun ?>"><?php echo $row->tahun ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-success">Filter</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">

                        <div class="card-body">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="table-responsive">

                                        <table id="datatable1" class="display" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Paket</th>
                                                    <th>Kode voucher</th>
                                                    <th>Tanggal </th>
                                                    <th>Waktu</th>
                                                    <th>Harga</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                foreach ($voucher->result() as $row) {
                                                ?>
                                                    <tr>
                                                        <td><?= $i++ ?></td>
                                                        <td><?= $row->service ?></td>
                                                        <td><?= $row->kode ?></td>
                                                        <td><?= tgl_indo($row->date) ?></td>
                                                        <td><?= $row->time ?></td>
                                                        <td>Rp <?= number_format($row->harga) ?></td>

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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php
if ($this->session->flashdata('message_err')) {
?>
    <script>
        swal({
            text: "<?php echo $this->session->flashdata('message_err'); ?>",
            icon: "error",
            button: false,
            timer: 1200
        });
    </script>
<?php
} else if ($this->session->flashdata('message_success')) {
?>
    <script>
        swal({
            text: "<?php echo $this->session->flashdata('message_success'); ?>",
            icon: "success",
            button: false,
            timer: 1200
        });
    </script>
<?php
}
?>

<?php $this->load->view('templates/voucher/footer'); ?>