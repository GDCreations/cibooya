<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">General</a></li>
        <li class="active">Branding</li>
    </ul>
</div>
<div class="app-heading app-heading-bordered app-heading-page">
    <div class="icon icon-lg">
        <span class="fa fa-bank" style="color: #e69c0f;"></span>
    </div>
    <div class="title">
        <h1>Branding</h1>
        <p>Company Information</p>
    </div>
</div>
<!-- END PAGE HEADING -->

<!-- START PAGE CONTAINER -->
<div class="container">
    <div class="block">

        <form class="form-horizontal" id="brandingEdt" enctype="multipart/form-data">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-4 control-label">Company Name</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" value="<?= $compInfo[0]->cmne ?>" name="cmne"
                               id="cmne"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Company Address</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" value="<?= $compInfo[0]->cadd ?>" name="cadd"
                               id="cadd"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Company Phone</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" value="<?= $compInfo[0]->ctel ?>" name="ctel"
                               id="ctel"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">System Link</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" value="<?= $compInfo[0]->syln ?>" name="syln"
                               id="syln"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 col-xs-12">Report Logo</label>
                    <div class="col-md-8 col-xs-12">
                        <input type="file" id="rptLgo" name="rptLgo"/>
                    </div>
                </div>
            </div>
            <input type="hidden" name="rptLgoOld" value="<?= $compInfo[0]->rplg?>">
            <input type="hidden" name="logImgOld" value="<?= $compInfo[0]->cplg?>">

            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-4 control-label">System Name</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" value="<?= $compInfo[0]->synm ?>" name="synm"
                               id="synm"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Email</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" value="<?= $compInfo[0]->ceml ?>" name="ceml"
                               id="ceml"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Register Date</label>
                    <div class="col-md-8">
                        <input type='text' class="form-control datetimepicker" id="regd" name="regd"
                               value="<?= $compInfo[0]->regd ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Web Mail Link</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" value="<?= $compInfo[0]->wbml ?>" name="wbml"
                               id="wbml"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 col-xs-12">Login Image</label>
                    <div class="col-md-8 col-xs-12">
                        <input type="file" id="logImg" name="logImg"/>
                    </div>
                </div>

                <div class="form-group margin-top-20">
                    <button class="btn btn-sm btn-rounded btn-success pull-right" type="button" id="save">Submit
                    </button>
                </div>
            </div>
        </form>

    </div>

    <script type="text/javascript">

        $().ready(function () {
            $('#brandingEdt').validate({
                rules: {
                    cmne: {
                        required: true
                    },
                    cadd: {
                        required: true
                    },
                    ctel: {
                        digits: true,
                        minlength: 10,
                        maxlength: 10,
                    },
                    ceml: {
                        required: true,
                        email: true
                    },
                    syln: {
                        required: true,
                    },
                    synm: {
                        required: true,
                    },
                },
                messages: {
                    cmne: {
                        required: "Enter supplier name"
                    },
                    addr: {
                        required: "Enter supplier address"
                    },
                }
            });


            //File Uploader Initialiting
            $("#rptLgo").fileinput('enable');
            $("#rptLgo").fileinput('destroy');
            $("#rptLgo").fileinput({
                allowedFileExtensions: ['jpg', 'png', 'jpeg'],
                showUpload: false,
                showCaption: false,
                browseClass: "btn btn-primary btn-sm btn-rounded",
                removeClass: "btn btn-warning btn-sm btn-rounded",
                maxFileSize: 5000, //Kb
                initialPreviewAsData: true,
                initialPreview: [
                    "<?= base_url()?>uploads/report_logo/<?= $compInfo[0]->rplg?>"
                ]
            });

            $("#logImg").fileinput('enable');
            $("#logImg").fileinput('destroy');
            $("#logImg").fileinput({
                allowedFileExtensions: ['jpg', 'png', 'jpeg'],
                showUpload: false,
                showCaption: false,
                browseClass: "btn btn-primary btn-sm btn-rounded",
                removeClass: "btn btn-warning btn-sm btn-rounded",
                maxFileSize: 5000, //Kb
                initialPreviewAsData: true,
                initialPreview: [
                    "<?= base_url()?>uploads/loginImg/<?= $compInfo[0]->cplg ?>"
                ]
            });


            /* //File Uploader Initialiting
             $("#rptLgo").fileinput({
                 allowedFileExtensions: ['jpg', 'png', 'jpeg'],
                 showUpload: false,
                 showCaption: false,
                 browseClass: "btn btn-primary btn-sm btn-rounded",
                 removeClass: "btn btn-warning btn-sm btn-rounded",
                 maxFileSize: 5000, //Kb
             });
             $("#logImg").fileinput({
                 allowedFileExtensions: ['jpg', 'png', 'jpeg'],
                 showUpload: false,
                 showCaption: false,
                 browseClass: "btn btn-primary btn-sm btn-rounded",
                 removeClass: "btn btn-warning btn-sm btn-rounded",
                 maxFileSize: 5000, //Kb
             });*/
        });

        //Add New Supplier
        $('#save').click(function (e) {
            e.preventDefault();
            if ($('#brandingEdt').valid()) {

                var formObj = document.getElementById('brandingEdt');
                var formData = new FormData(formObj);

                $('#save').prop('disabled', true);

                swal({
                    title: "Processing...",
                    text: "Branding data saving..",
                    imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                    showConfirmButton: false
                });

                jQuery.ajax({
                    type: "POST",
                    url: "<?= base_url(); ?>admin/updateBranding",
                    data: formData,
                    mimeType: "multipart/form-data",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        swal({title: "", text: "Update Success!", type: "success"},
                            function () {
                                $('#save').prop('disabled', false);
                                //clear_Form('brandingEdt');
                                //$('#modal-add').modal('hide');
                                location.reload();
                            });
                    },
                    error: function (data, textStatus) {
                        swal({title: "Update Failed", text: textStatus, type: "error"},
                            function () {
                                location.reload();
                            });
                    }
                });
            }
        });

    </script>
</div>
<!-- END PAGE CONTAINER -->