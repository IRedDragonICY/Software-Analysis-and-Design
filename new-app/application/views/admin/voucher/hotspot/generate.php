<?php $this->load->view('templates/voucher/header'); ?>
<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Generate Voucher</h1>
                    </div>
                </div>
            </div>
            <div class="row">

                <!-- Default Card Example -->
                <!-- Grow In Utility -->

                <div class="col-lg-12 mb-4">
                    <div class="card position-relative">
                        <div class="card-body">
                            <div class="mb-3">

                                <form class="form-horizontal" action="<?php echo base_url('voucher/prosesgenerate'); ?>" role="form" method="POST">
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                            </div>
                            <div class="row mb-3">
                                <label for="username" class="col-sm-2 col-form-label">Quantity</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" autocomplete="off" name="quantity" id="quantity" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Server</label>
                                <div class="col-sm-10">
                                    <select class="form-select" aria-label="Default select example" name="server" id="server">
                                        <option disabled value="" selected>Pilih Server</option>
                                        <option value="all">all</option>
                                        <?php foreach ($server as $data) { ?>
                                            <option><?= $data['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Panjang tiap voucher </label>
                                <div class="col-sm-10">
                                    <select class="form-select" aria-label="Default select example" name="lenght" id="lenght">
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>

                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Karakter</label>
                                <div class="col-sm-10">
                                    <select class="form-select" aria-label="Default select example" name="character" id="character">
                                        <option value="lower1">Random abcd2345</option>
                                        <option value="upper1">Random ABCD2345</option>
                                        <option value="upplow1">Random aBcD2345</option>
                                        <option value="mix">Random 5ab2c34d</option>
                                        <option value="mix1">Random 5AB2C34D</option>
                                        <option value="mix2">Random 5aB2c34D</option>

                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Profile</label>
                                <div class="col-sm-10">
                                    <select class="form-select" aria-label="Default select example" name="profile" id="profile">
                                        <option disabled value="" selected>Pilih Profile</option>
                                        <?php foreach ($profile as $data) { ?>
                                            <option value="<?= $data->id ?>"><?= $data->service ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="username" class="col-sm-2 col-form-label">TimeLimit ( Waktu Aktif Voucher )</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" autocomplete="off" name="timelimit" id="timelimit">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="username" class="col-sm-2 col-form-label">Comment</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" autocomplete="off" name="comment" id="comment" required>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Kirim voucher untuk</label>
                                <div class="col-sm-10">
                                    <select class="form-select" aria-label="Default select example" name="voucherfor" id="voucherfor">
                                        <option disabled value="" selected>Pilih data</option>
                                        <option value="Admin">Admin</option>
                                        <?php foreach ($reseller as $data) { ?>
                                            <option value="<?= $data->email ?>"><?= $data->email ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <a href="<?php echo base_url('voucher/users') ?>" class="btn btn-secondary">Kembali</a>

                            <button type="submit" class="btn btn-primary">Submit</button>

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