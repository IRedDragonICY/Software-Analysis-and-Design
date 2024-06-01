<?php $this->load->view('templates/voucher/header'); ?>
<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description page-description-tabbed">
                        <h1>Voucher Setting </h1>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">

                    <div class="card">
                        <div class="card-body">
                            <form class="form-horizontal" action="<?php echo base_url('voucher/update'); ?>" role="form" method="POST">

                                <div class="row m-t-xxl">
                                    <div class="col-md-12">
                                        <label for="settingsCurrentPassword" class="form-label">Server</label>
                                        <div class="col-md-12">
                                            <select class="form-select" aria-label="Default select example" name="server" id="server">
                                                <option value="<?php echo $voucher[0]->server ?>"><?= $voucher[0]->server ?></option>
                                                <option value="all">all</option>
                                                <?php foreach ($server as $data) { ?>
                                                    <option><?= $data['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row m-t-xxl">
                                    <div class="col-md-12">
                                        <label for="settingsNewPassword" class="form-label">Panjang tiap voucher</label>
                                        <div class="col-md-12">
                                            <select class="form-select" aria-label="Default select example" name="lenght" id="lenght">
                                                <option value="<?php echo $voucher[0]->lenght ?>"><?= $voucher[0]->lenght ?></option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row m-t-xxl">
                                    <div class="col-md-12">
                                        <label for="settingsConfirmPassword" class="form-label">Karakter</label>
                                        <div class="col-md-12">
                                            <select class="form-select" aria-label="Default select example" name="karakter" id="karakter">
                                                <option value="<?= $voucher[0]->karakter ?>"> <?= $voucher[0]->karakter ?></option>
                                                <option value="lower1">Random abcd2345 [ lower1 ]</option>
                                                <option value="upper1">Random ABCD2345 [ upper1 ]</option>
                                                <option value="upplow1">Random aBcD2345 [ upplow1 ] </option>
                                                <option value="mix">Random 5ab2c34d [ mix ]</option>
                                                <option value="mix1">Random 5AB2C34D [ mix1 ] </option>
                                                <option value="mix2">Random 5aB2c34D [ mix2 ] </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row m-t-lg">
                                    <div class="col">
                                        <button type="submit" class="btn btn-primary m-t-sm">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
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
<?php $this->load->view('templates/voucher/footer'); ?>