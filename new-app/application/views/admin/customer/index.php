<?php $this->load->view('templates/admin/header'); ?>
<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Data Pelanggan</h1>
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
                                                        <th>ID Pelanggan</th>
                                                        <th>Nama </th>
                                                        <th>Paket</th>
                                                        <th>User PPPOE</th>
                                                        <th>Masa Aktif Sampai</th>
                                                        <th>Status</th>
                                                        <th>Lihat Data</th>
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
                                                            <td><?php echo $row->idpel ?></td>
                                                            <td><?php echo $row->nama ?></td>
                                                            <td><?= $row->paket ?></td>
                                                            <td><?php echo $row->pppoe_user; ?></td>
                                                            <td><?php echo tanggal(date('Y-m-d', strtotime($row->expdate))) ?>
                                                            </td>
                                                            <?php
                                                            if ($row->status == 'Active') {
                                                                $label = "success";
                                                            } else if ($row->status == 'Isolir') {
                                                                $label = "warning";
                                                            } else if ($row->status == 'Berhenti') {
                                                                $label = "danger";
                                                            }
                                                            ?>
                                                            <td><span class="btn btn-<?php echo $label; ?>"><?php echo $row->status; ?></span></td>


                                                            <td><a href="<?= base_url("admin/customer/detail/$row->idpel") ?>" class="btn btn-sm btn-success"><i class='material-icons-outlined'>
                                                                        check_circle
                                                                    </i><strong>Cek Disini</strong></a>

                                                            </td>
                                                            <?php
                                                            if ($this->session->userdata('level') === 'developer') {

                                                            ?>
                                                                <td><a href="<?= base_url("admin/customer/edit/$row->idpel") ?> " class="btn btn-sm btn-warning"><i class="material-icons-outlined">
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