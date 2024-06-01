<?php $this->load->view('templates/member/header'); ?>
<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1> Beli Voucher Wifi</h1>
                    </div>
                </div>
            </div>
            <!-- end row -->
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Informasi</h5>
                        </div>

                        <div class="card-body">
                            <pre>
Pilihlah akses point / modem kami di dekat
anda agar anda lebih nyaman
saat menggunakan wifi kami
                            </pre>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card overflow-hidden">
                        <div class="card-header d-flex justify-content-between align-items-center">
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" action="<?php echo base_url() ?>member/createvoucher" role="form" method="POST">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                <div class="row mb-3">
                                    <label for="paket" class="col-sm-2 col-form-label">Paket</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="service" name="service">
                                            <option value="0">Pilih salah satu ...</option>
                                            <?php
                                            $check = $this->db->query("SELECT * FROM services_voucher ORDER BY id");
                                            foreach ($check->result() as $data) {
                                            ?>
                                                <option value="<?= $data->service ?>"><?= $data->service ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div id="note"></div>



                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Beli voucher</button>
                                </div>


                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.10.2.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

        $("#service").change(function() {
            var service = $("#service").val();
            $.ajax({
                url: '<?= base_url(); ?>ajax/ambilservice',
                data: 'service=' + service,
                type: 'POST',
                dataType: 'html',
                success: function(msg) {
                    $("#note").html(msg);
                }
            });
        });
    });
</script>

<script src="<?php echo base_url(); ?>assets/js/sweetalert.min.js"></script>

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
            timer: 1200

        });
    </script>
<?php
}
?>
<?php $this->load->view('templates/member/footer'); ?>