<?php $this->load->view('templates/admin/header'); ?>
<?php foreach ($payment as $row) {

    $merchantcode = $row->code_merchant;
    $apiurl = $row->api_url;
    $apikey = $row->api_key;
    $privatekey = $row->private_key;
    $callback = $row->callback;
    $status = $row->status;
}
?>
<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Pengaturan Payment Gateway</h1>
                    </div>
                </div>
            </div>
            <!-- end row -->
            <div class="row">

                <div class="col-sm-6">
                    <div class="card overflow-hidden">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title"><i class="fa fa-key"></i> Payment Gateway Settings</h3>
                        </div>
                        <div class="card-body">

                            <form autocomplete="off" name="formadd" method="post" action="<?php echo base_url('admin/payment_update'); ?>">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                <div class="mb-3 row">
                                    <label for="merchantcode" class="col-sm-2 col-form-label">Kode Merchant</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="code_merchant" name="code_merchant" value="<?= $merchantcode ?>">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="apiurl" class="col-sm-2 col-form-label">API URL</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="api_url" name="api_url" value="<?= $apiurl ?>">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="apikey" class="col-sm-2 col-form-label">API Key</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="api_key" name="api_key" value="<?= $apikey ?>">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="privatekey" class="col-sm-2 col-form-label">Private Key</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="private_key" name="private_key" value="<?= $privatekey ?>">
                                    </div>
                                </div>



                                <div class="mb-3 row">
                                    <label for="status" class="col-sm-2 col-form-label">Status</label>

                                    <div class="col-sm-10">

                                        <select class="form-select" aria-label="Default select example" name="status">
                                            <option value="<?php echo $row->status ?>"> <?php echo $row->status ?>
                                            </option>
                                            <option value="enable">Enable</option>
                                            <option value="disable">Disable</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="buttonadd" class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-10">
                                        <button class="btn btn-primary" id="buttonadd" type="submit"><i class="fe fe-save"></i> Simpan</button>
                                    </div>
                                </div>

                            </form>

                        </div>

                    </div>
                </div>





                <!-- COL END -->
                <div class="col-sm-6">


                    <div class="card overflow-hidden">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title"><i class="fa fa-credit-card"></i> Payment Method</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <?php foreach ($metode as $row) { ?>
                                    <div class="custom-control custom-switch d-block">
                                        <div class="form-check form-switch">
                                            <input type="checkbox" class="form-check-input form-control-md" id="set<?= $row->provider_code ?>" <?php if ($row->status == '1') {
                                                                                                                                                    echo 'checked';
                                                                                                                                                }
                                                                                                                                                ?>>
                                            <span class="settingsIntegrationOneSwitcher"></span>
                                            <span class="form-check-label"><?= $row->name ?></span>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- COL END -->

<script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.js"></script>


<?php
foreach ($metode as $row) { ?>
    <script>
        $('#set<?= $row->provider_code ?>').on('change', function(event) {
            var status = $('#set<?= $row->provider_code ?>').is(":checked") ? 1 : 0;
            var kodepm = '<?= $row->provider_code ?>';
            $.ajax({
                url: "<?= base_url('ajax/update_payment_method') ?>",
                method: "POST",
                data: {
                    status: status,
                    kodepm: kodepm
                },
                async: true,
                dataType: 'html',
                success: function() {
                    location.reload();
                }

            });
        });
    </script>
<?php } ?>
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