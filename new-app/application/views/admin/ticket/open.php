<?php $this->load->view('templates/admin/header'); ?>
<?php foreach ($ticket as $row) {
    $this->session->set_userdata('id', $row->id);
    $this->session->set_userdata('user', $row->user);

?>

    <div class="app-content">
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="page-description">
                            <h1>Reply Ticket #<?php echo $row->id ?></h1>
                        </div>
                    </div>
                </div>

                <!-- end row -->
                <div class="col-xl-12 col-lg-7">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-danger"><i class="fa fa-comments"></i> Subjek : <?php echo $row->subject; ?></h6>

                        </div>
                        <!-- Card Body -->
                        <div class="card-body">

                            <div style="max-height: 400px; overflow: auto;">
                                <div class="alert alert-info alert-white text-right">
                                    <b><?php echo $row->user; ?></b><br /><?php echo nl2br($row->message); ?><br /><i class="text-white" style="font-size: 10px;"><?php echo $row->datetime; ?></i>
                                </div>
                                <?php
                                $check = $this->db->query("SELECT * FROM tickets_message WHERE ticket_id = '$row->id'")->result_array();
                                foreach ($check as $row) {
                                    $checkadmin = $row['user'];

                                    if ($row['sender'] == "Admin") {
                                        $msg_alert = "success";
                                        $msg_sender = "Admin [ $checkadmin ]";
                                    } else {
                                        $msg_alert = "info";
                                        $msg_sender = $row['user'];
                                    }
                                ?>
                                    <div class="alert alert-<?php echo $msg_alert; ?>">
                                        <b><?php echo $msg_sender; ?></b><br /><?php echo nl2br($row['message']); ?><br /><i class="text-white" style="font-size: 10px;"><?php echo $row['datetime']; ?></i>
                                    </div>
                                <?php
                                }
                                ?>

                            </div>
                            <br>
                            <a href="<?= base_url("admin/ticket") ?>" class="btn btn-warning"><i class="material-icons-outlined">reply</i>Kembali</a>

                        </div>



                    </div>
                </div>
            </div>
        </div>


    <?php } ?>
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