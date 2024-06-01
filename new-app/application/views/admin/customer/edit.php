<?php $this->load->view('templates/admin/header'); ?>

<?php foreach ($customers as $row) : ?>

    <div class="app-content">
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="page-description">
                            <h1><?php echo $title ?></h1>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <!-- Default Card Example -->
                    <!-- Grow In Utility -->

                    <div class="col-lg-6 mb-4">
                        <div class="card position-relative">
                            <div class="card-header">
                                <h5 class="card-title">Data Pelanggan</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="row mb-3">
                                        <label for="paket" class="col-sm-2 col-form-label">Nama</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="<?php echo $row->nama ?>" disabled>

                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="username" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="<?php echo $row->email ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="username" class="col-sm-2 col-form-label">Nomor Handphone </label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="<?php echo  $row->nomor ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="username" class="col-sm-2 col-form-label">Alamat</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" disabled> <?php echo $row->alamat ?>

                                                </textarea>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mb-3">
                                        <label for="username" class="col-sm-2 col-form-label">ID Pelanggan </label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="<?php echo  $cek[0]->idpel ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="username" class="col-sm-2 col-form-label">Layanan </label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="<?php echo  $cek[0]->paket ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="username" class="col-sm-2 col-form-label">Tanggal Aktif </label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="<?php echo tanggal($cek[0]->date) ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="username" class="col-sm-2 col-form-label">Masa Aktif Sampai </label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="<?php echo tanggal(date('Y-m-d', strtotime($cek[0]->expdate))) ?>" disabled>
                                        </div>
                                    </div>




                                    <a href="<?php echo base_url('admin/contacts') ?>" class="btn btn-secondary">Kembali</a>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">PPPoE User</h5>
                            </div>
                            <form class="form-horizontal" action="<?php echo base_url('contact/update'); ?>" role="form" method="POST">

                                <div class="card-body">
                                    <div class="example-container">
                                        <div class="example-content">
                                            <input type="hidden" value="<?= $cek[0]->id ?> " name="id">
                                            <select class="form-select" aria-label="Default select example" name="user_pppoe" id="user_pppoe">
                                                <?php if ($cek[0]->pppoe_user != null) {

                                                ?>
                                                    <option disabled value="" selected><?= $cek[0]->pppoe_user ?></option>
                                                    <?php foreach ($alluser as $data) { ?>
                                                        <option><?= $data['name'] ?></option>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <option disabled value="" selected>Pilih Data User</option>

                                                    <?php foreach ($alluser as $data) { ?>
                                                        <option><?= $data['name'] ?></option>
                                                <?php }
                                                } ?>
                                            </select>

                                        </div>

                                    </div>
                                    <br>

                                    <button type="submit" class="btn btn-primary">Update Data</button>

                                </div>

                            </form>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Informasi</h5>
                            </div>

                            <div class="card-body">
                                <pre>
Membuat auto isolir : 
silahkan buat ip address dan cidr terlebih dahulu : <a href="<?php echo  base_url('admin/pool/add') ?> ">Klik disini</a>
dan juga copy script dibawah ini paste kan di terminal mikrotik anda 
</pre>
                                <br />
                                <?php
                                $admin = new M_admin();

                                $pool = $admin->get('pool');

                                foreach ($pool->result() as $row) {
                                    $iprange = $row->ip_range;
                                    $cidr = $row->cidr;

                                    $x = 2;

                                    $host = $x - 2;

                                    $hostnya = $iprange . $host . $cidr;
                                }

                                ?>

                                <?php if ($cek = $pool->num_rows() == 0) {
                                    $text = "Note : Tidak ada Pool Host di database, silahkan buat terlebih dahulu !";
                                } ?>

                                <?php if ($cek == true) {
                                ?>
                                    <p style="color:red;"><?= $text;  ?>

                                    <?php
                                } else {

                                    ?>
                                        <br />
                                        <code>
                                            # Menambahkan ip address list ip isolir <br />
                                            klik tulisan <b>klik disini</b> dan copy kan semua yang ada pada halaman tersebut : <a href="<?php echo  base_url('admin/pool/ipisolir') ?> " target="_blank">Klik disini</a>
                                            <br /><br />
                                            # Mengaktifkan web proxy <br />
                                            /ip proxy set enabled=yes port=8181 max-cache-size=none
                                            <br /><br />

                                            # Menambahkan address-list dibagian access web proxy <br />
                                            /ip proxy access <br />
                                            add action=allow dst-port=8181 src-address=<?php echo $hostnya; ?> comment="Auto isolir by MBS Cloud" <br />
                                            add action=deny src-address=<?php echo $hostnya; ?> dst-address=!27.112.78.188 redirect="isolir.fiberdelta.net"

                                            <br /> <br />
                                            # Mematikan koneksi IP yang isolir <br />
                                            /ip firewall filter <br />
                                            add chain=forward src-address-list=ISOLIR action=drop comment="Auto isolir by MBS Cloud"
                                            <br />
                                            add chain=forward protocol=udp dst-port=53,5353 action=accept
                                            <br /> <br />

                                            # Mengalihkan ke web proxy <br />
                                            /ip firewall nat <br />
                                            add chain=dstnat src-address-list=ISOLIR protocol=tcp dst-port=80,443 action=redirect to-ports=8181 comment="Auto isolir by MBS Cloud" <br />
                                            add chain=dstnat src-address-list=ISOLIR protocol=udp dst-port=80,443 action=redirect to-ports=8181
                                            <br><br>



                                        </code>
                                    <?php } ?>
                            </div>

                        </div>


                    </div>

                </div>

            </div>
        </div>
    </div>

<?php endforeach ?>
<script src="<?php echo base_url(); ?>assets/plugins/select2/js/select2.full.min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/pages/select2.js"></script>


<?php $this->load->view('templates/admin/footer'); ?>