    <!-- Javascripts -->
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
            });
        </script>
    <?php
    }
    ?>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-3.5.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/pace/pace.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/main.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
    </body>

    </html>