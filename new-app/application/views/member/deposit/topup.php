<?php $this->load->view('templates/member/header'); ?>
<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h3>Isi Saldo </h3>
                    </div>
                </div>
            </div>
            <form action="<?php echo base_url('member/pembayaran') ?>" method="POST">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                <div class="row">
                    <div class="col-lg-12 mb-4">
                        <div class="card position-relative">
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="row mb-3">
                                        <label for="username" class="col-sm-2 col-form-label">Metode Pembayaran</label>
                                        <div class="col-sm-10">
                                            <select class="form-select" aria-label="Default select example" id="category" name="category" required>
                                                <option disabled value="" selected>Pilih metode pembayaran</option>
                                                <?php
                                                $query = $this->db->query("SELECT * FROM payment_cat WHERE status = '1' ORDER BY id ASC");
                                                foreach ($query->result() as $data) {
                                                ?>
                                                    <option value="<?php echo $data->category ?> "><?php echo $data->name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="username" class="col-sm-2 col-form-label">Tersedia</label>
                                        <div class="col-sm-10">
                                            <select class="form-select" aria-label="Default select example" name="service" id="service">
                                                <option value="0">Pilih Metode...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="harga" class="col-sm-2 col-form-label">Jumlah isi saldo</label>
                                        <div class="col-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text text-primary">Rp</span></div>
                                                <input type="number" class="form-control" name="quantity" placeholder="Masukan jumlah">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary"><i class='material-icons-outlined'>payment</i>Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.10.2.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#category").change(function() {
            var category = $("#category").val();
            $.ajax({
                url: '<?php echo base_url('ajax/ambilcategory') ?>',
                data: 'category=' + category,
                type: 'POST',
                dataType: 'html',
                success: function(msg) {
                    $("#service").html(msg);
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