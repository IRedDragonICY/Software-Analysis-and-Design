<?php $this->load->view('templates/member/header'); ?>

<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Data Tiket</h1>
                    </div>
                </div>
            </div>
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
                                                <h6 class="modal-title" id="custom-width-modalLabel"><i class="fa fa-plus"></i> Buat tiket</h6>
                                            </div>
                                            <div class="float-right">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal" action="<?php echo base_url('member/tiket_create'); ?>" role="form" method="POST">
                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                                <div class="form-group">
                                                    <label class="col-md-2 control-label"> Subject</label>
                                                    <div class="col-md-12">
                                                        <input type="text" name="subject" class="form-control" placeholder="Error / Gangguan">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Pesan</label>
                                                    <div class="col-md-12">
                                                        <textarea name="pesan" class="form-control"></textarea>
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
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#myModal">
                                                Buat tiket baru
                                            </button>
                                        </div>
                                    </div>
                                    </form>
                                    <br>
                                    <div class="table-responsive">
                                        <table id="datatable1" class="display" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Subject.</th>
                                                    <th>Status </th>
                                                    <th>Terakhir diperbaharui</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                foreach ($tiket as $row) {
                                                ?>
                                                    <tr>
                                                        <td><a href="<?= base_url("member/tiket/open/$row->id") ?>" class="btn btn-primary"><i class='material-icons-outlined'>list</i><strong>Lihat tiket</strong></a></td>
                                                        <td><?php echo $row->subject ?></td>
                                                        <td>
                                                            <?php
                                                            if ($row->status == 'Pending') {
                                                                echo "<span class='btn btn-warning'>Pending</span>";
                                                            } else if ($row->status == 'Responded') {
                                                                echo "<span class='btn btn-success'>Responded</span>";
                                                            } else if ($row->status == 'Closed') {
                                                                echo "<span class='btn btn-danger'>Closed</span>";
                                                            } else if ($row->status == 'Waiting') {
                                                                echo "<span class='btn btn-info'>Waiting</span>";
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?php echo $row->last_update ?></td>

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
<?php $this->load->view('templates/member/footer'); ?>