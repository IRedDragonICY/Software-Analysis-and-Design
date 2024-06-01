<?php $this->load->view('templates/member/header'); ?>
<?php foreach ($content as $row) : ?>

    <div class="app-content">
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="page-description">
                            <h1>Detail Voucher</h1>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <!-- Default Card Example -->
                    <!-- Grow In Utility -->

                    <div class="col-lg-12 mb-4">
                        <div class="alert alert-dark " role="alert">
                            Klik Kode Voucher, otomatis kode akan tersalin
                        </div>

                        <div class="card position-relative">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered" data-filter=#filter>

                                        <tr>
                                            <td><b>ID Pesanan</b></td>
                                            <td><?= $row->oid ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Paket</b></td>
                                            <td><?= $row->service ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Kode Voucher</b></td>

                                            <td>
                                                <input type="hidden" class="form-control" id="kodevoucher" value="<?= $row->kode ?>" disabled>
                                                <button class="btn btn-secondary text-black" type="button" id="salinkodevoucher" onClick="copyToClipboard();">
                                                    <svg style="margin-top:-3px;" xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24">
                                                        <path d="M15.143 13.244l.837-2.244 2.698 5.641-5.678 2.502.805-2.23s-8.055-3.538-7.708-10.913c2.715 5.938 9.046 7.244 9.046 7.244zm8.857-7.244v18h-18v-6h-6v-18h18v6h6zm-2 2h-12.112c-.562-.578-1.08-1.243-1.521-2h7.633v-4h-14v14h4v-3.124c.6.961 1.287 1.823 2 2.576v6.548h14v-14z" />
                                                    </svg>
                                                    <?= $row->kode ?>
                                                </button>


                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Harga</b></td>
                                            <td>Rp <?php echo number_format($row->harga) ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Status Voucher</b></td>
                                            <?php
                                            if ($row->status_v == "Belum digunakan") {
                                                $label = "info";
                                            } else if ($row->status_v == "Sudah digunakan") {
                                                $label = "dark";
                                            }
                                            ?>
                                            <td><label class="btn btn-<?php echo $label; ?>"><?= $row->status_v ?></label></td>
                                        </tr>
                                        <tr>
                                            <td><b>Tanggal Pembelian</b></td>
                                            <td><?= tgl_indo($row->date) ?></td>
                                        </tr>
                                    </table>
                                    <a href="<?php echo base_url(); ?>member/history/order" class="btn btn-success m-b-10"><i class='material-icons-outlined'>arrow_back</i>Kembali</a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endforeach ?>
<script type="text/javascript">
    function copyToClipboard() {
        console.time('time2');
        var temp = document.createElement('input');
        var texttoCopy = document.getElementById('kodevoucher').value;
        var buttontemp = document.getElementById('salinkodevoucher').innerHTML;
        temp.type = 'input';
        temp.setAttribute('value', texttoCopy);
        document.body.appendChild(temp);
        temp.select();
        document.execCommand("copy");
        temp.remove();
        document.getElementById('salinkodevoucher').innerHTML = 'Berhasil disalin !';
        document.getElementById("salinkodevoucher").disabled = true;
        setTimeout(function() {
            document.getElementById('salinkodevoucher').innerHTML = buttontemp;
        }, 3000);
        document.getElementById("salinkodevoucher").disabled = false;
        console.timeEnd('time2');
    }
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