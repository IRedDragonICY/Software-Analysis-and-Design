<?php $this->load->view('templates/admin/header'); ?>
<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Kirim Informasi Ke Pelanggan </h1>
                    </div>
                </div>
            </div>
            <!-- end row -->


            <div class="row">
                <div class="p-3">



                </div>

                <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="float-left">
                                    <h6 class="modal-title" id="custom-width-modalLabel"><i class="fa fa-plus"></i> Kirim Informasi by media</h6>
                                </div>
                                <div class="float-right">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" action="<?php echo base_url('admin/sendmedia'); ?>" role="form" method="POST">
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                    <div class="form-group">
                                        <label class="col-md-2 control-label"> URL</label>
                                        <div class="col-md-12">
                                            <input type="text" name="url" class="form-control" placeholder="Url Media">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Type</label>
                                        <div class="col-md-12">
                                            <input type="text" name="type" class="form-control" placeholder="audio / video / image / pdf / xls /xlsx /doc /docx /zip">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Caption </label>
                                        <div class="col-md-12">
                                            <textarea rows="20" name="message" class="form-control"></textarea>
                                        </div>
                                    </div>


                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Kembali</button>
                                        <button type="reset" class="btn btn-danger waves-effect" data-dismiss="modal"><i class="fa fa-refresh"></i> Reset</button>
                                        <button type="submit" class="btn btn-success btn-bordered waves-effect w-md waves-light" name="add"><i class="fa fa-plus"></i> Kirim</button>
                                    </div>
                                </form>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
                <div class="input-group mb-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                        Kirim info by media
                    </button>
                </div>
                <div class="col-md-6">
                    <div class="card overflow-hidden">
                        <div class="card-body">


                            <form autocomplete="off" name="formadd" method="post" action="<?php echo base_url('admin/kiriminfo'); ?>">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                <div class="form-group">
                                    <label for="apikey" class="col-sm-2 col-form-label">Pesan </label>
                                    <div class="col-md-12">
                                        <textarea rows="20" name="message" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="buttonadd" class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-10">
                                        <button class="btn btn-primary" id="buttonadd" type="submit"> Kirim</button>
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