<?php $this->load->view('templates/router/header'); ?>
<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Hotspot Users</h1>
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
                                                        <th><?= $totalhotspotuser ?></th>
                                                        <th>Server</th>
                                                        <th>Name</th>
                                                        <th>Profile </th>
                                                        <th>Mac Address</th>
                                                        <th>Uptime</th>
                                                        <th>Bytes In</th>
                                                        <th>Bytes Out</th>
                                                        <th>Comment</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($hotspotuser as $row) {
                                                        if ($row['server'] == null) {
                                                            $servernya = 'all';
                                                    ?>
                                                            <tr>
                                                                <?php $id = str_replace('*', '', $row['.id']) ?>
                                                                <td><a href="<?= base_url("hotspot/delete/" . $id) ?>" onclick="return confirm('Apakah anda yakin ingin menghapus user <?= $row['name']; ?> ?')" class="btn btn-sm btn-danger"><i class='material-icons-outlined'>delete</i><strong>Delete</strong></a>
                                                                </td>


                                                                <td><?= $servernya ?></td>
                                                                <td><?= $row['name'] ?></td>
                                                                <td><?= $row['profile'] ?></td>
                                                                <td><?= $row['mac-address'] ?></td>
                                                                <td><?= formatDTM($row['uptime']) ?></td>
                                                                <td><?= formatBytes($row['bytes-in']) ?></td>
                                                                <td><?= formatBytes($row['bytes-out']) ?></td>
                                                                <td><?= $row['comment'] ?></td>
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