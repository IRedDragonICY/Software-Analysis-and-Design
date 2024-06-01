<?php $this->load->view('templates/voucher/header'); ?>
<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Profile List</h1>
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

                                <div class="col-lg-12">
                                    <div class="row">

                                        <br>

                                        <div class="table-responsive">
                                            <table id="datatable1" class="display" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Total Profile : <?= $totalhotspotprofile ?></th>
                                                        <th>Nama</th>
                                                        <th>Shared Users</th>
                                                        <th>Rate Limit</th>
                                                        <th>Uptime</th>
                                                        <th>Harga</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($hotspotprofile as $row) {

                                                    ?>

                                                        <tr>
                                                            <td>


                                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete-<?= $row->id ?>"><i class="material-icons-outlined">delete</i>Hapus Profile </button>
                                                                <a href="<?= base_url("admin/voucher/hotspot/profile/edit/" . $row->id) ?>" class="btn btn-sm btn-warning"><i class='material-icons-outlined'>edit</i><strong>Edit</strong></a>
                                                            </td>
                                                            <td><?= $row->service ?></td>
                                                            <td><?= $row->shared ?></td>
                                                            <td><?= $row->ratelimit ?></td>
                                                            <td><?= $row->uptime ?></td>
                                                            <td>Rp <?= number_format($row->harga) ?></td>
                                                        </tr>
                                                        <!--- Modal Delete -->
                                                        <div class="modal fade" id="delete-<?= $row->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                        <a class="btn btn-primary" href="<?= base_url(); ?>Ajax/delete_profile_hotspot/<?= $row->service ?>">Ya</a>
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