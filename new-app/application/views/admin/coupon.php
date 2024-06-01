<?php $this->load->view('templates/admin/header'); ?>
<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Pengaturan Diskon Kupon </h1>
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
                                                    <h6 class="modal-title" id="custom-width-modalLabel"><i class="fa fa-plus"></i> Tambah data kupon</h6>
                                                </div>
                                                <div class="float-right">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" action="<?php echo base_url('admin/addcoupon'); ?>" role="form" method="POST">
                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label"> Kode Kupon</label>
                                                        <div class="col-md-12">
                                                            <input type="text" name="code" class="form-control" placeholder="Contoh : DISC10">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Diskon ( Persen )</label>
                                                        <div class="col-md-12">
                                                            <input type="number" name="rate" class="form-control" placeholder="Contoh : 10">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Sekali Pakai </label>
                                                        <div class="col-md-12">
                                                            <select class="form-select" aria-label="Default select example" id="otp" name="otp" required>
                                                                <option disabled value="" selected>Pilih Salah satu</option>
                                                                <option value="ya">Ya</option>
                                                                <option value="tidak">Tidak </option>
                                                            </select>
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
                                                    Tambah Data Kupon
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
                                                        <th>Kode Kupon.</th>
                                                        <th>Diskon </th>
                                                        <th>Sekali Pakai</th>
                                                        <th>Status</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($content as $row) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $i++; ?></td>
                                                            <td><?php echo $row->code ?></td>
                                                            <td><?php echo $row->rate ?>%</td>
                                                            <td><?php echo $row->otp ?></td>
                                                            <td><?= $row->status  ?> </td>
                                                            <td>
                                                                <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#update-<?= $row->id; ?>"><i class="material-icons-outlined">edit</i>Update Status</button>

                                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete-<?= $row->id; ?>"><i class="material-icons-outlined">delete</i>Delete</button>

                                                                <!--- Modal Delete -->
                                                                <div class="modal fade" id="delete-<?= $row->id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Delete Kupon Diskon</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                Apakah anda ingin menghapus Kupon <b><u><?= $row->code ?></u></b> ?
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                <a class="btn btn-primary" href="<?= base_url("admin/delcoupon/$row->id"); ?> ">Yes</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="modal fade" id="update-<?= $row->id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Update Kupon Diskon</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                Apakah anda ingin mengupdate Kupon <b><u><?= $row->code ?></u></b> ?
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                <a class="btn btn-primary" href="<?= base_url("admin/updatecoupon/$row->id"); ?> ">Yes</a>
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