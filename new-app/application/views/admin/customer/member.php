<?php $this->load->view('templates/admin/header'); ?>
<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Data Member</h1>
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