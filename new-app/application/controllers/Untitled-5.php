<?php $this->load->view('templates/user/header'); ?>
<?php foreach ($history as $row) {
    $this->session->set_userdata('price', $row->price);
?>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="page-description">
                            <h1>Payment #<?php echo $row->code ?> </h1>
                        </div>
                    </div>
                </div>
                <form action="<?php echo base_url('user/invoice/pembayaran/' . $row->code) ?>" method="POST">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <div class="card position-relative">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="row mb-3">
                                            <label for="username" class="col-sm-2 col-form-label">Paket</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" value="<?php echo $row->package ?>" disabled>
                                                <input type="hidden" name="idpel" id="idpel" value="<?= $row->idpel ?> ">
                                                <input type="hidden" name="paket" id="paket" value="<?= $row->package ?> ">
                                                <input type="hidden" name="invoice" id="invoice" value="<?= $row->code ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="username" class="col-sm-2 col-form-label">Jumlah Tagihan ( + PPN) </label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" value="Rp <?php echo number_format($row->price) ?>" disabled>
                                                <input type="hidden" name="price" id="totalnya" value="<?php echo $row->price ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="username" class="col-sm-2 col-form-label">Metode Pembayaran</label>
                                            <div class="col-sm-10">
                                                <select class="form-select" aria-label="Default select example" id="category" name="category">
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
                                            <label for="username" class="col-sm-2 col-form-label">Kode Kupon</label>

                                            <div class="col-sm-10">
                                                <div class="input-group mb-3">
                                                    <input type="text" id="codecoupon" name="codecoupon" oninput="this.value = this.value.toUpperCase()" onKeyDown="if(event.keyCode === 32) return false;" class="form-control">
                                                    <a href="#" id="cekcoupon" style="text-decoration:none;" class="input-group-text">Cek Kupon</a>
                                                </div>
                                            </div>


                                            <span id="notifcoupon"></span>


                                        </div>

                                        <div class="form-group">
                                            <div class="loadingcekcoupon">
                                            </div>

                                        </div>



                                        <div class="row mb-3" id="formdiscount" style="display: none;">
                                            <label for="username" class="col-sm-2 col-form-label">Diskon Kupon </label>
                                            <div class="col-sm-10">
                                                <input type="text" id="disccoupon" class="form-control" readonly>
                                                <input type="hidden" name="disccoupon" id="amountdisccoupon" class="form-control" readonly>
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
<?php } ?>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.js"></script>
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

<script>
    $('#cekcoupon').click(function(event) {
        var code = $("#codecoupon").val();
        var idpel = $("#idpel").val();
        var tagihan = $("#totalnya").val();
        var url = "<?= site_url('Ajax/cekcoupon') ?>" + "/" + Math.random();
        if (code == '') {
            $("#notifcoupon").html('Silahkan masukkan dulu kode kupon !');
            $("#codecoupon").focus();
        } else {
            $.ajax({
                type: 'POST',
                url: url,
                data: "&code=" + code + "&idpel=" + idpel + "&tagihan=" + tagihan,
                cache: false,

                beforeSend: function() {

                    $('.loadingcekcoupon').html(` <div class="container">
        <div class="text-center">
        <div class="spinner-border text-primary" role="status">
    <span class="visually-hidden">Loading...</span>
</div>
        </div>
    </div>`);
                },
                success: function(data) {
                    var c = jQuery.parseJSON(data);

                    $('.loadingcekcoupon').html('');
                    var disct = c['disc'];
                    var disc = disct.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    var gros = tagihan - disct;
                    var gross = gros.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    $("#disccoupon").val(disc);
                    $("#amountdisccoupon").val(c['disc']);
                    $("#notifcoupon").html(c['remark']);

                    if (c['disc'] > 0) {
                        $("#formdiscount").show();
                        $("#cekcoupon").hide();
                        $("#totalnya").val(tagihan - disct);
                        $("#amountgros").html(gross);
                    }


                }
            });
        }
        return false;
    });
</script>
<?php $this->load->view('templates/user/footer'); ?>