<?php $this->load->view('templates/admin/header'); ?>
<?php foreach ($payment as $row) : ?>

    <div class="app-content">
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="page-description page-description-tabbed">
                            <h1>Edit Pembayaran </h1>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">

                        <div class="card">
                            <div class="card-body">
                                <?php echo form_open_multipart('admin/update_invoice'); ?>
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">


                                <input type="hidden" name="target" value="<?php echo $row->id ?>">
                                <input type="hidden" name="expdate" id="expdate" value="<?php echo $row->expdate ?>">
                                <input type="hidden" name="code" id="code" value="<?php echo $row->code ?> ">
                                <div class="row m-t-xxl">
                                    <div class="col-md-12">
                                        <label for="settingsCurrentPassword" class="form-label">No Invoice</label>
                                        <input type="text" name="invoice" class="form-control" value="<?php echo $row->code ?>" disabled>
                                    </div>
                                </div>
                                <div class="row m-t-xxl">
                                    <div class="col-md-12">
                                        <label for="settingsNewPassword" class="form-label">ID Pelanggan</label>
                                        <input type="text" name="idpel" class="form-control" value="<?php echo $row->idpel ?>" disabled>
                                        <input type="hidden" name="idpel" value="<?php echo $row->idpel ?>">
                                    </div>
                                </div>
                                <div class="row m-t-xxl">
                                    <div class="col-md-12">
                                        <label for="settingsNewPassword" class="form-label">Nama</label>
                                        <input type="text" name="user" class="form-control" value="<?php echo $row->nama ?>" disabled>
                                        <input type="hidden" name="user" id="user" value="<?php echo $row->nama ?>">
                                    </div>
                                </div>
                                <div class="row m-t-xxl">
                                    <div class="col-md-12">
                                        <label for="settingsConfirmPassword" class="form-label">Paket</label>
                                        <input type="text" name="package" id="package" class="form-control" value="<?php echo $row->package ?>" disabled>

                                        <input type="hidden" name="package" id="package" value="<?php echo $row->package ?>">

                                    </div>
                                </div>

                                <div class="row m-t-xxl">
                                    <div class="col-md-12">
                                        <label for="settingsConfirmPassword" class="form-label">Jumlah yang harus
                                            dibayar </label>
                                        <input type="text" name="price" id="price" class="form-control" value="Rp <?php echo number_format($row->price) ?>" disabled>
                                        <input type="hidden" name="price" id="price" value="<?php echo $row->price ?>">

                                    </div>
                                </div>
                                <div class="row m-t-xxl">
                                    <div class="col-md-12">
                                        <label for="settingsConfirmPassword" class="form-label">Metode Pembayaran
                                        </label>
                                        <select class="form-select" aria-label="Default select example" name="category">
                                            <option value="<?php echo $row->category ?>"> <?php echo $row->category ?>
                                            </option>
                                            <option value="CASH">CASH</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row m-t-xxl">
                                    <div class="col-md-12">
                                        <label for="settingsConfirmPassword" class="form-label">Tersedia </label>
                                        <select class="form-select" aria-label="Default select example" name="metode">
                                            <option value="<?php echo $row->service ?>"> <?php echo $row->service ?>
                                            </option>
                                            <option value="Tunai ( Bayar di kantor )">Tunai ( Bayar di kantor )</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="row m-t-xxl">
                                    <div class="col-md-12">
                                        <label for="settingsConfirmPassword" class="form-label">Bukti Pembayaran (
                                            Kwitansi ) </label>
                                        <input type="file" class="form-control" name="image" id="image" required></input>

                                    </div>
                                </div>

                                <div class="row m-t-xxl">
                                    <div class="col-md-12">
                                        <label for="settingsConfirmPassword" class="form-label">Status </label>
                                        <select class="form-select" aria-label="Default select example" name="status">
                                            <option value="<?php echo $row->status ?>"> <?php echo $row->status ?>
                                            </option>
                                            <option value="Paid">Paid</option>

                                        </select>
                                    </div>
                                </div>



                                <div class="row m-t-lg">
                                    <div class="col">
                                        <button type="submit" class="btn btn-primary m-t-sm">Update</button>

                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

<?php endforeach ?>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php
if ($this->session->flashdata('message_err')) {
?>
    <script>
        swal({
            text: "<?php echo $this->session->flashdata('message_err'); ?>",
            icon: "error",
            button: false,
            timer: 2000
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
            timer: 2000
        });
    </script>
<?php
}
?>
<?php $this->load->view('templates/admin/footer'); ?>