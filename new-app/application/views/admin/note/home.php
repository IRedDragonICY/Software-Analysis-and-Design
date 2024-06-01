<?php $this->load->view('templates/admin/header'); ?>
<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Catatan</h1>
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
                                                    <h6 class="modal-title" id="custom-width-modalLabel"><i class="fa fa-plus"></i> Buat catatan baru</h6>
                                                </div>
                                                <div class="float-right">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" action="<?php echo base_url('admin/addnote'); ?>" role="form" method="POST" enctype="multipart/form-data">
                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label"> Isi Catatan</label>
                                                        <div class="col-md-12">
                                                            <textarea name="pesan" class="form-control"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-12 control-label">Foto (* Jika dibutukan )</label>
                                                        <div class="col-md-12">
                                                            <input type="file" class="form-control" name="image" id="image"></input>
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
                                                    Buat catatan baru
                                                </button>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table id="datatable1" class="display" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Pembuat</th>
                                                        <th>Catatan </th>
                                                        <th>Tanggal</th>
                                                        <th>Lihat detail</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($cek as $row) {
                                                        $beritastr = "-" . strlen($row->message);

                                                        $beritasensor = substr($row->message, $beritastr, +10);

                                                    ?>
                                                        <tr>
                                                            <td><?php echo $i++; ?></td>
                                                            <td><?php echo $row->account ?></td>
                                                            <td><?php echo nl2br($beritasensor . "....."); ?></td>
                                                            <td><?php echo tanggal(date('Y-m-d', strtotime($row->date))) ?>
                                                            </td>

                                                            <td><a href="<?= base_url("admin/ceknote/$row->id") ?>" class="btn btn-sm btn-success"><i class='material-icons-outlined'>
                                                                        check_circle
                                                                    </i><strong>Cek Disini</strong></a>

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