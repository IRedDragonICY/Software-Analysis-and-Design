<?php $this->load->view('templates/admin/header'); ?>
<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>IP Address Isolir</h1>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row">
                <div class="p-3">

                    <?= $this->session->flashdata('pesan'); ?>


                </div>

                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Informasi</h5>
                        </div>

                        <div class="card-body">
                            <pre>
Saat ini hanya mendukung subnet /24 atau
hanya 254 ip address untuk ip isolir 
</pre>
                            <br />

                        </div>

                    </div>
                    <div class="card overflow-hidden">

                        <div class="card-body">

                            <form autocomplete="off" name="formadd" method="post" action="<?php echo base_url('admin/pool_add'); ?>">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                <div class="mb-3 row">
                                    <label for="merchantcode" class="col-sm-2 col-form-label">IP Isolir</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="ip" name="ip" placeholder="contoh : 20.20.20.">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="apiurl" class="col-sm-2 col-form-label">CIDR</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="cidr" name="cidr" value="/24" disabled>
                                        <input type="hidden" class="form-control" id="cidr" name="cidr" value="/24">

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