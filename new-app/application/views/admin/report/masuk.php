<?php $this->load->view('templates/admin/header'); ?>
<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Data Pemasukan</h1>
                    </div>
                </div>
            </div>
            <!-- end row -->
            <div class="row">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Filter Data</h5>
                            </div>

                            <div class="card-body">
                                <div class="example-content">
                                    <form class="row g-3" action=" <?php echo base_url("report/filtermasuk"); ?>" role="form" method="POST">
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
                    <hr>


                    <!-- end row -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-danger"><i class="fa fa-book"></i> Laporan
                                        Pemasukan </h6>

                                </div>

                                <!-- Card Body -->
                                <div class="card-body">
                                    <!-- sample modal content -->


                                    <div class="col-lg-12">
                                        <div class="row">

                                            <div class="table-responsive">
                                                <table id="datatable1" class="display" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>Tanggal.</th>
                                                            <th>Jumlah Pemasukan</th>
                                                            <th>Asal Pemasukan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $i = 1;
                                                        foreach ($report as $row) {
                                                        ?>
                                                            <tr>
                                                                <td> <?php echo tanggal(date('Y-m-d', strtotime($row['last_update']))) ?>
                                                                </td>
                                                                <?php if ($row['fix_received'] == true) {
                                                                    $online = number_format($row['fix_received']);
                                                                } else {
                                                                    $online = number_format($row['price']);
                                                                } ?>

                                                                <td>Rp <?php echo $online; ?></td>



                                                                <td>Pembayaran Sukses dari <?php echo $row['nama']; ?> [
                                                                    Menggunakan : <?= $row['method'] ?> ] [ Diterima Oleh :
                                                                    <?= $row['update_by'] ?> ]

                                                                    <?php if ($row['update_by'] !== 'System Payment Gateway Tripay') {

                                                                    ?>

                                                                        [ Lihat Bukti : <a href="<?php echo base_url(); ?>data/bukti/<?= $row['bukti_pembayaran'] ?>" target="_blank">
                                                                            Lihat data bukti pembayaran</a> ]
                                                                    <?php } ?>
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
    </div>
</div>

<!-- end row -->
<script>
    $(".flatpickr1").flatpickr();
</script>
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
<?php $this->load->view('templates/admin/footer'); ?>