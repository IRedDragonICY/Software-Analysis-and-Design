<?php $this->load->view('templates/voucher/header'); ?>
<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1> <?= $title ?></h1>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-xl-12 col-lg-7">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <!-- Card Body -->
                        <div class="card-body">
                            <!-- sample modal content -->
                            <div class="col-lg-12">
                                <div class="row">

                                    <div class="table-responsive">

                                        <button type="button" style="margin-bottom: 10px" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete-<?= $comment[0]['comment'] ?>"><i class="material-icons-outlined">delete</i>Hapus Semua Voucher ( <?= $comment[0]['comment'] ?> ) </button>

                                        <!--- Modal Delete -->
                                        <div class="modal fade" id="delete-<?= $comment[0]['comment'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Delete Voucher By Comment</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah anda ingin menghapus data tersebut ?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <a class="btn btn-primary" href="<?= base_url(); ?>Ajax/deletevoucherbycomment/<?= $comment[0]['comment'] ?>">Yes</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <table id="datatable1" class="table table-bordered text-nowrap border-bottom" style="border-collapse: collapse; border-spacing: 0; width: 100%;">


                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Kode Voucher</th>
                                                    <th>Profile </th>
                                                    <th>Status Voucher</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                foreach ($comment as $row) {
                                                ?>
                                                    <tr>
                                                        <td><?= $i++ ?></td>
                                                        <td><?= $row['kode'] ?></td>
                                                        <td><?= $row['service'] ?></td>
                                                        <td><?= $row['status_v'] ?></td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end row -->

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        $('#master').on('click', function(e) {
            if ($(this).is(':checked', true)) {
                $(".form-check-input").prop('checked', true);
            } else {
                $(".form-check-input").prop('checked', false);
            }
        });

        $('.delete_all').on('click', function(e) {

            var allVals = [];
            $(".form-check-input:checked").each(function() {
                allVals.push($(this).attr('data-id'));
            });

            if (allVals.length <= 0) {
                alert("Silahkan pilih data terlebih dahulu ");
            } else {


                var check = confirm("Yakin ingin menghapus data ini ?");
                if (check == true) {

                    var join_selected_values = allVals.join(",");

                    $.ajax({
                        url: $(this).data('url'),
                        type: 'POST',
                        data: 'ids=' + join_selected_values,
                        success: function(data) {
                            console.log(data);
                            $(".form-check-input:checked").each(function() {
                                $(this).parents("tr").remove();
                            });
                            alert("Data berhasil dihapus");

                        },
                        error: function(data) {
                            alert(data.responseText);
                        }
                    });

                    $.each(allVals, function(index, value) {
                        $('table tr').filter("[data-row-id='" + value + "']").remove();
                    });
                }
            }
        });
    });
</script>

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