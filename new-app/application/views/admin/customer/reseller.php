<?php $this->load->view('templates/admin/header'); ?>
<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Data Reseller</h1>
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
                                                    <h6 class="modal-title" id="custom-width-modalLabel"> Input Data Reseller</h6>
                                                </div>
                                                <div class="float-right">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" action="<?php echo base_url('admin/addreseller'); ?>" role="form" method="POST">
                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Nama Reseller</label>
                                                        <div class="col-md-12">
                                                            <input type="text" name="name" class="form-control" placeholder="Adi Darmawan">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-12 control-label">Email Reseller </label>
                                                        <div class="col-md-12">
                                                            <input type="text" name="email" class="form-control" placeholder="Masukan email reseller">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-12 control-label">Nomor Whatsapp </label>
                                                        <div class="col-md-12">
                                                            <input type="number" name="nowa" class="form-control" placeholder="Masukan Nomor Whatsapp reseller">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-12 control-label">Password </label>
                                                        <div class="col-md-12">
                                                            <input type="text" name="password" class="form-control" value="<?= $password ?>">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Komisi</label>
                                                        <div class="col-md-12">
                                                            <input type="number" name="komisi" class="form-control" placeholder="Komisi per voucher : 20 ( 20% ) ">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-12 control-label">Saldo Tersedia</label>
                                                        <div class="col-md-12">
                                                            <input type="number" name="balance" class="form-control" placeholder="Example : 10000">
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
                                                    Input Reseller Baru
                                                </button>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="datatable1" class="display" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama</th>
                                                        <th>Email </th>
                                                        <th>Nomor Handphone</th>
                                                        <th>Saldo</th>
                                                        <th>Level</th>
                                                        <th>Komisi</th>
                                                        <th>#</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($cek as $row) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $i++; ?></td>
                                                            <td><?php echo $row->nama ?></td>
                                                            <td><?php echo $row->email ?></td>
                                                            <td><?php echo $row->nomor ?></td>
                                                            <td>Rp <?php echo number_format($row->balance) ?></td>
                                                            <td><?php echo $row->level ?></td>
                                                            <td><?php echo $row->komisi ?>%</td>



                                                            <?php
                                                            if ($this->session->userdata('level') === 'developer') {

                                                            ?>
                                                                <td><a href="<?= base_url("contact/edit/$row->id") ?> " class="btn btn-sm btn-warning"><i class="material-icons-outlined">
                                                                            edit
                                                                        </i><strong>Edit Data </strong></a></td>
                                                            <?php
                                                            } else {

                                                            ?>
                                                                <td></td>
                                                        </tr>
                                                <?php
                                                            }
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