<?php $this->load->view('templates/admin/header'); ?>
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
                                            <table id="datatable1" class="display" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Tiket No</th>
                                                        <th>Status</th>
                                                        <th>Subjek </th>
                                                        <th>Pelanggan</th>
                                                        <th>Terakhir Update</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($content as $row) {
                                                        if ($row->status == 'Responded') {
                                                            $label = "success";
                                                        } else if ($row->status == 'Closed') {
                                                            $label = "danger";
                                                        } else if ($row->status == 'Pending') {
                                                            $label = "warning";
                                                        } else if ($row->status == 'Waiting') {
                                                            $label = "info";
                                                        }
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $i++; ?></td>
                                                            <td><a href="<?= base_url("admin/ticket/open/$row->id") ?>" class="btn btn-primary"><i class='material-icons-outlined'>list</i><strong>Lihat tiket</strong></a></td>
                                                            <td><span class="btn btn-<?php echo $label; ?>"><?php echo $row->status; ?></span></td>
                                                            <td><?php echo $row->subject ?></td>
                                                            <td><?php echo $row->user ?></td>
                                                            <td><?php echo $row->last_update; ?></td>
                                                            <td>
                                                                <?php if ($row->status !== "Closed") {
                                                                ?>
                                                                    <a href="<?= base_url("admin/ticket/reply/$row->id") ?>" class="btn btn-sm btn-success"><i class="material-icons-outlined">reply</i>Reply</a>
                                                                <?php } ?>

                                                                <?php if ($row->status !== "Closed") {

                                                                ?>
                                                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#close-<?= $row->id; ?>"><i class="material-icons-outlined">cancel</i>Close</button>

                                                                <?php } ?>
                                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete-<?= $row->id; ?>"><i class="material-icons-outlined">delete</i>Delete</button>



                                                                <!--- Modal Delete -->
                                                                <div class="modal fade" id="delete-<?= $row->id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Delete Ticket</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                Apakah anda ingin menghapus tiket tersebut ?
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                <a class="btn btn-primary" href="<?= base_url("admin/ticket_delete/$row->id"); ?> ">Yes</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!--- Modal Close -->
                                                                <div class="modal fade" id="close-<?= $row->id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Close Ticket</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                Apakah anda ingin menutup tiket tersebut ?
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                <a class="btn btn-primary" href="<?= base_url("admin/ticket_closed/$row->id"); ?> ">Yes</a>
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