<?php $this->load->view('templates/router/header'); ?>
<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>PPP Secret</h1>
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
                                                    <h6 class="modal-title" id="custom-width-modalLabel"><i class="fa fa-plus"></i> Add Secret</h6>
                                                </div>
                                                <div class="float-right">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" action="<?php echo base_url('ppp/addsecret'); ?>" role="form" method="POST">
                                                    <div class="form-group">
                                                        <label class="col-md-12 control-label">Name</label>
                                                        <div class="col-md-12">
                                                            <input type="text" name="name" class="form-control" autocomplete="off" value="">

                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label"> Password</label>
                                                        <div class="col-md-12">
                                                            <input type="text" name="password" class="form-control" autocomplete="off" value="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 col-form-label">Profile </label>
                                                        <div class="col-md-12">
                                                            <select class="form-select" aria-label="Default select example" name="profile" id="profile">
                                                                <option disabled value="" selected>Pilih salah satu</option>
                                                                <?php foreach ($profile as $data) { ?>
                                                                    <option><?= $data['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 col-form-label">Service</label>
                                                        <div class="col-md-12">
                                                            <select class="form-select" aria-label="Default select example" name="service" id="service">
                                                                <option disabled value="" selected>Pilih salah satu</option>
                                                                <option value="any">any</option>
                                                                <option value="async">async</option>
                                                                <option value="l2tp">l2tp</option>
                                                                <option value="ovpn">ovpn</option>
                                                                <option value="pppoe">pppoe</option>
                                                                <option value="pptp">pptp</option>
                                                                <option value="sstp">sstp</option>
                                                            </select>
                                                        </div>
                                                    </div>


                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label"> Remote Address</label>
                                                        <div class="col-md-12">
                                                            <input type="text" name="remoteaddr" class="form-control" autocomplete="off" value="">
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
                                                    Add Secret
                                                </button>
                                            </div>
                                        </div>
                                        <br>

                                        <div class="table-responsive">
                                            <table id="datatable1" class="display" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Total Data : <?= $totalsecret ?></th>
                                                        <th>Service</th>
                                                        <th>Profile</th>
                                                        <th>Nama</th>
                                                        <th>Local Address</th>

                                                        <th>Remote Address</th>
                                                        <th>Last Logged Out</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($getsecret as $row) {
                                                    ?>
                                                        <tr>
                                                            <?php $id = str_replace('*', '', $row['.id']) ?>
                                                            <td>
                                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete-<?= $id ?>"><i class="material-icons-outlined">delete</i>Hapus Data </button>

                                                                <a href="<?= base_url("admin/router/ppp/secret/edit/" . $id) ?>" class="btn btn-sm btn-warning"><i class='material-icons-outlined'>edit</i><strong>Edit</strong></a>

                                                            </td>
                                                            </td>
                                                            <td><?= $row['service'] ?></td>
                                                            <td><?= $row['profile'] ?></td>
                                                            <td><?= $row['name'] ?></td>
                                                            <td><?= $row['local-address'] ?></td>
                                                            <td><?= $row['remote-address'] ?></td>
                                                            <td><?= $row['last-logged-out'] ?></td>

                                                        </tr>
                                                        <div class="modal fade" id="delete-<?= $id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Hapus Profile</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Apakah anda ingin menghapus Profile <b><u><?= $row->service ?></u></b> ?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                                                                        <a class="btn btn-primary" href="<?= base_url(); ?>Ajax/delete_secret_ppp/<?= $id ?>">Ya</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
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
<?php $this->load->view('templates/router/footer'); ?>