<?php $this->load->view('templates/admin/header'); ?>
<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Data Layanan <?= $titleweb ?> </h1>
                    </div>
                </div>
            </div>
            <!-- end row -->
            <div class="row">




                <!-- end row -->
                <div class="row">
                    <div class="col-xl-12 col-lg-7">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <!-- Card Body -->
                            <div class="card-body">
                                <!-- sample modal content -->
                                <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <div class="float-left">
                                                    <h6 class="modal-title" id="custom-width-modalLabel"><i class="fa fa-plus"></i> Input Data Paket</h6>
                                                </div>
                                                <div class="float-right">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" action="<?php echo base_url('admin/services_create'); ?>" role="form" method="POST">
                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label"> Paket</label>
                                                        <div class="col-md-12">
                                                            <input type="text" name="package" class="form-control" placeholder="Paket Internet 100Mbps">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Harga</label>
                                                        <div class="col-md-12">
                                                            <input type="number" name="price" class="form-control" placeholder="Example : 50000">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-12 control-label">PPN ( Isikan dengan angka saja ) </label>
                                                        <div class="col-md-12">
                                                            <input type="number" name="ppn" class="form-control" placeholder="Example : 10">
                                                        </div>
                                                    </div>


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
                                        <div class="col-lg-6">
                                            <div class="input-group mb-3">
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                                    Input Paket Baru
                                                </button>
                                            </div>
                                        </div>
                                        </form>
                                        <br>
                                        <div class="table-responsive">
                                            <table id="datatable1" class="display" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Paket.</th>
                                                        <th>Harga </th>
                                                        <th>PPN</th>

                                                        <th>Status</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($packages as $row) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $i++; ?></td>
                                                            <td><?php echo $row->paket ?></td>
                                                            <td>Rp <?php echo number_format($row->harga) ?></td>
                                                            <td><?php echo $row->ppn ?>%</td>

                                                            <td><?php echo $row->status ?></td>
                                                            <td>
                                                                <a href="<?= base_url("admin/services/edit/" .  $row->id) ?>" class="btn btn-sm btn-warning"><i class='material-icons-outlined'>edit</i><strong>Edit</strong></a>
                                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete-<?= $row->id; ?>"><i class="material-icons-outlined">delete</i>Delete</button>

                                                                <!--- Modal Delete -->
                                                                <div class="modal fade" id="delete-<?= $row->id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Delete Layanan</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                Apakah anda ingin menghapus Layanan <b><u><?= $row->paket ?></u></b> ?
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                <a class="btn btn-primary" href="<?= base_url("admin/service/delete/$row->id"); ?> ">Yes</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
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

<!-- end row -->

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