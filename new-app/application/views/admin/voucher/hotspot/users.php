<?php $this->load->view('templates/voucher/header'); ?>
<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Users List Only Admin</h1>
                    </div>
                </div>
            </div>
            <!-- end row -->
            <div class="row">
                <!-- end row -->
                <div class="col-sm-12">
                    <div class="card">


                        <div class="card-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <select class="form-control" id="comment" name="comment">
                                        <option value="">Pilih Voucher</option>

                                        <?php

                                        foreach ($comment->result() as $data) {
                                        ?>
                                            <option value="<?= $data->comment; ?>"><?= $data->comment; ?></option>

                                        <?php } ?>

                                    </select>

                                </div>
                            </div>
                            <br>

                            <script>
                                function printV() {
                                    var comm = document.getElementById('comment').value;
                                    var url = "<?= base_url('admin/voucher/print/default/') ?>" + comm + "";
                                    if (comm === "") {
                                        alert('Silakan pilih salah satu Comment terlebih dulu!');
                                    } else {
                                        var win = window.open(url, '_blank');
                                        win.focus();
                                    }
                                }
                            </script>
                            <script>
                                function printsmall(a, b) {
                                    var comm = document.getElementById('comment').value;
                                    var url = "print_small.php?id=" + comm + "&" + a + "=" + b + "";
                                    if (comm === "") {
                                        alert('Silakan pilih salah satu Comment terlebih dulu!');
                                    } else {
                                        var win = window.open(url, '_blank');
                                        win.focus();
                                    }
                                }
                            </script>
                            <script>
                                function lihat_data() {
                                    var comm = document.getElementById('comment').value;
                                    var url = "<?= base_url('admin/voucher/comment/') ?>" + comm + "";

                                    if (comm === "") {
                                        alert('Silakan pilih salah satu Comment terlebih dulu!');
                                    } else {
                                        var win = window.open(url, '_blank');
                                        win.focus();
                                    }
                                }
                            </script>



                            <button class="btn btn-primary btn-xs dim" title='Print' onclick="printV();"><i class="material-icons-outlined">
                                    print
                                </i> Default</button>
                            <button class="btn btn-primary btn-xs dim" title='Print' onclick="printsmall('small','yes');"><i class="material-icons-outlined">
                                    print
                                </i> Small</button>
                            <button class="btn btn-primary btn-xs dim" title='lihat data' onclick="lihat_data();"><i class="material-icons-outlined">
                                    list
                                </i> Cek data by comment</button>

                        </div>

                    </div>
                </div>
            </div>
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
                                                    <th>Total Voucher : <?= $totalhotspotuser ?></th>
                                                    <th>Kode Voucher</th>
                                                    <th>Profile </th>

                                                    <th>Comment</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                foreach ($hotspotuser as $row) {
                                                ?>
                                                    <tr>
                                                        <?php $id = str_replace('*', '', $row['id']) ?>
                                                        <td><?= $i++ ?></td>
                                                        <td><?= $row['kode'] ?></td>
                                                        <td><?= $row['service'] ?></td>

                                                        <td><?= $row['comment'] ?></td>
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
<?php $this->load->view('templates/voucher/footer'); ?>