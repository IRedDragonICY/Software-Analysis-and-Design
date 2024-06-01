<?php $this->load->view('templates/admin/header'); ?>
<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Data Pengeluaran</h1>
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
                                    <form class="row g-3" action=" <?php echo base_url("report/filter"); ?>" role="form" method="POST" enctype="multipart/form-data">
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

                                                    <option value="<?php echo $row->tahun ?>"><?php echo $row->tahun ?></option>
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

                    <div class="col-lg-6">
                        <div class="input-group mb-3">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                Input Pengeluaran
                            </button>
                        </div>
                    </div>

                    <!-- end row -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-danger"><i class="fa fa-book"></i> Laporan Pengeluaran </h6>

                                </div>

                                <!-- Card Body -->
                                <div class="card-body">
                                    <!-- sample modal content -->
                                    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <div class="float-left">
                                                        <h6 class="modal-title" id="custom-width-modalLabel"><i class="fa fa-plus"></i> Input Data Pengeluaran</h6>
                                                    </div>
                                                    <div class="float-right">
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                </div>
                                                <div class="modal-body">
                                                    <form class="form-horizontal" action="<?php echo base_url('report/create'); ?>" role="form" method="POST" enctype="multipart/form-data">
                                                        <div class="form-group">
                                                            <label class="col-md-12 control-label">Category</label>
                                                            <div class="col-md-12">
                                                                <select class="form-control" name="category">
                                                                    <option value="Pengeluaran">Pengeluaran</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label"> Uang Keluar</label>
                                                            <div class="col-md-12">
                                                                <input type="number" name="balance" class="form-control" placeholder="Etc: 30000">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Asal</label>
                                                            <div class="col-md-12">
                                                                <input type="text" name="asal" class="form-control" placeholder="Example : Pembayaran ISP ">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Tanggal</label>
                                                            <div class="col-md-12">
                                                                <input class="form-control flatpickr1" name="tanggal" type="text" placeholder="Select Date..">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Bukti Kwitansi</label>
                                                            <div class="col-md-12">
                                                                <input type="file" class="form-control" name="image" id="image"></input>
                                                            </div>
                                                        </div>

                                                        <?php if (isset($error)) : ?>
                                                            <div class="invalid-feedback"><?= $error ?></div>
                                                        <?php endif; ?>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Kembali</button>
                                                            <button type="reset" class="btn btn-danger waves-effect" data-dismiss="modal"><i class="fa fa-refresh"></i> Reset</button>
                                                            <button type="submit" class="btn btn-success btn-bordered waves-effect w-md waves-light" name="add"><i class="fa fa-plus"></i> Tambah</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->

                                    <div class="col-lg-12">
                                        <div class="row">

                                            <div class="table-responsive">
                                                <table id="datatable1" class="display" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Tanggal.</th>
                                                            <th>Jumlah Pengeluaran</th>
                                                            <th>Asal Pengeluaran</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $i = 1;
                                                        foreach ($report as $row) {
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $i++; ?></td>
                                                                <td><?php echo tanggal($row['date']); ?></td>
                                                                <td>Rp <?php echo number_format($row['balance']); ?></td>
                                                                <td> <?php echo $row['asal']; ?>
                                                                    [ Lihat Bukti : <a href="<?php echo base_url(); ?>data/pengeluaran/<?= $row['image'] ?>" target="_blank">
                                                                        Lihat data bukti</a> ]
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