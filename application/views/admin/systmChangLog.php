<script type="text/javascript" src="<?= base_url(); ?>assets/js/custom-js/full_width.js"></script>

<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">MIT Setting</a></li>
        <li class="active">System Changelog</li>
    </ul>
</div>
<div class="app-heading app-heading-bordered app-heading-page">
    <div class="icon icon-lg">
        <span class="fa fa-user" style="color: #e69c0f;"></span>
    </div>
    <div class="title">
        <h1>System Changelog</h1>
        <p>Create / Edit / Inactive </p>
    </div>

    <div class="pull-right">
        <button class="btn btn-sm btn-info btn-icon-fixed btn-rounded" data-toggle="modal" data-target="#modal-add">
            <span class="fa fa-plus"></span> Add Note
        </button>
    </div>

</div>
<!-- END PAGE HEADING -->

<!-- START PAGE CONTAINER -->
<div class="container">

    <div class="block">
        <div class="row form-horizontal">

            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-md-4 col-xs-12 control-label">From Date</label>
                    <div class="col-md-8 col-xs-12">
                        <div class='input-group date'>
                            <input type='text' class="form-control datetimepicker" id="frdt" name="frdt"
                                   value="<?= date('Y-m-d') ?>"/>
                            <span class="input-group-addon">
                                <span class="fa fa-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-md-4 col-xs-12 control-label">To Date</label>
                    <div class="col-md-8 col-xs-12">
                        <div class='input-group date'>
                            <input type='text' class="form-control datetimepicker" id="todt" name="todt"
                                   value="<?= date('Y-m-d') ?>"/>
                            <span class="input-group-addon">
                                <span class="fa fa-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <button class="btn btn-sm btn-primary btn-rounded  btn-icon-fixed pull-right"
                            onclick="srcLgnote()">
                        <span class="fa fa-search"></span>Search
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="block">
        <div class="row form-horizontal">
            <div class="table-responsive">
                <table id="DataTbSysupdt" class="table dataTable table-striped table-bordered" width="100%">
                    <thead>
                    <tr>
                        <th class="text-left">#</th>
                        <th class="text-left">DATE</th>
                        <th class="text-left">Sending email</th>
                        <th class="text-left">STATUS</th>
                        <th class="text-left">ACTION</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- MODAL ADD NEW -->
    <div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modal-default-header">
        <div class="modal-dialog modal-lg" role="document" style="width: 80%">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="icon-cross"></span>
            </button>
            <form id="addForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span>
                            New Release Note
                        </h4>
                    </div>

                    <div class="modal-body">
                        <div class="container">
                            <div class="row form-horizontal">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Release Date</label>
                                            <div class="col-md-8 col-xs-12">
                                                <div class='input-group date'>
                                                    <input type='text' class="form-control datetimepicker" id="rcdt"
                                                           name="rcdt" value="<?= date('Y-m-d') ?>"/>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Note By </label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type='text' class="form-control" id="poby" name="poby"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-md-2 col-xs-12 control-label">Send To Email </label>
                                            <div class="col-md-10 col-xs-12">
                                                <input type='text' class="text" data-role="tagsinput" name="tag"
                                                       id="tag"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <!-- SUMMERNOTE EXAMPLE -->
                                    <div class="block">
                                        <div class="form-group">
                                             <textarea class="form-control editor-summernote" name="remk"
                                                       id="remk"> </textarea>
                                        </div>
                                    </div>
                                    <!-- END SUMMERNOTE EXAMPLE -->
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="pull-left">
                            <span class="fa fa-hand-o-right"></span>
                            <label style="color: red"> <span class="fa fa-asterisk req-astrick"></span> Required Fields
                            </label>
                        </div>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                        <button type="button" id="addBtn" class="btn btn-warning btn-sm btn-rounded">Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END ADD NEW  -->

    <!-- MODAL VIEW / EDIT /  -->
    <div class="modal fade" id="modal-view" tabindex="-1" role="dialog" aria-labelledby="modal-default-header">
        <div class="modal-dialog modal-lg" role="document" style="width: 80%">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="icon-cross"></span>
            </button>

            <form id="edtform">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span>
                            View System Release Note
                            <span class="text-muted" id="subTitle_edit"></span></h4>
                    </div>

                    <div class="modal-body">
                        <div class="container">
                            <div class="row form-horizontal">

                                <label><b> Notes Date : </b><span id="rcdtv"></span></label> &nbsp;&nbsp;&nbsp;
                                <label><b> Notes By :</b> <span id="rcbyv"> </span></label><br>
                                <label><b> Notes Send To : </b><span id="sendv"> </span></label> <br>
                                <hr>
                                <span id="relceNty"></span>

                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END VIEW  -->

    <script src="<?= base_url(); ?>assets/js/vendor/tinymce/tinymce.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/vendor/summernote/summernote.min.js"></script>

    <script type="text/javascript">

        $().ready(function () {
            //Table Initializing
            $('#DataTbSysupdt').DataTable({
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
            });

            $('#addForm').validate({
                rules: {
                    scdt: {
                        required: true,
                        notEqual: 0
                    },
                    mssg: {
                        required: true
                    },
                    sttm: {
                        required: true,
                    },
                    entm: {
                        required: true,
                    },

                },
                messages: {
                    brchNw: {
                        required: "Select Branch ",
                        notEqual: "Select Branch"
                    },
                    uslvNw: {
                        required: "Select User Level",
                        notEqual: "Select User Level"
                    },
                }
            });

            $('#edtform').validate({
                rules: {
                    usnmEdt: {
                        required: true,
                        remote: {
                            url: "<?= base_url(); ?>admin/chkUserName",
                            type: "post",
                            data: {
                                usnm: function () {
                                    return $("#usnmEdt").val();
                                },
                                auid: function () {
                                    return $("#auid").val();
                                },
                                stat: 1
                            }
                        }
                    },
                    brchNwEdt: {
                        required: true,
                        notEqual: 0
                    },
                    frnmEdt: {
                        required: true
                    },
                    emilEdt: {
                        required: true,
                        email: true
                    },
                    mobiEdt: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 10,
                    },
                    teleEdt: {
                        digits: true,
                        minlength: 10,
                        maxlength: 10,
                    },
                },
                messages: {
                    nameEdt: {
                        required: "Enter Branch name",
                        remote: "Already entered name"
                    },
                    codeEdt: {
                        required: "Enter Branch code",
                        remote: "Already entered code"
                    },

                    addrEdt: {
                        required: "Enter supplier address"
                    },
                    mobiEdt: {
                        required: "Enter mobile number",
                        digits: "Only numbers are allowed",
                        minlength: "Please enter 10 digits number",
                        maxlength: "Please enter 10 digits number",
                    },
                    teleEdt: {
                        digits: "Only numbers are allowed",
                        minlength: "Please enter 10 digits number",
                        maxlength: "Please enter 10 digits number",
                    },
                    emailEdt: {
                        required: "Enter email address",
                        email: "Please enter valid email address"
                    },
                }
            });
            srcLgnote();

            $('.editor-summernote').summernote({
                height: 400,
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['picture', 'link', 'video']]
                ]
            });
            $(window).resize();

        });

        tinymce.init({
            selector: '.editor-base',
            height: 400,
            menubar: false,
            toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            skin_url: 'css/vendor/tinymce',
            content_css: 'css/vendor/tinymce/content-style.css'
        });

        tinymce.init({
            selector: '.editor-full',
            height: 400,
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools'
            ],
            toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            toolbar2: 'print preview media | forecolor backcolor emoticons',
            image_advtab: true,
            skin_url: 'css/vendor/tinymce',
            content_css: 'css/vendor/tinymce/content-style.css'
        });

        //Search
        function srcLgnote() {
            var frdt = $('#frdt').val();
            var todt = $('#todt').val();

            $('#DataTbSysupdt').DataTable().clear();
            $('#DataTbSysupdt').DataTable({
                "destroy": true,
                "cache": false,
                "processing": true,
                "orderable": true,
                "language": {
                    processing: '<i class="fa fa-spinner fa-spin fa-fw" style="font-size:20px;color:red;"></i><span class=""> Loading...</span> '
                },
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                "serverSide": true,
                "columnDefs": [
                    {className: "text-left", "targets": [2]},
                    {className: "text-center", "targets": [0, 1, 3, 4]},
                    {className: "text-right", "targets": [0]},
                    {className: "text-nowrap", "targets": [2]},
                ],
                "order": [[1, "DESC"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '3%'}, //#
                    {sWidth: '10%'}, //
                    {sWidth: '50%'}, //
                    {sWidth: '10%'}, //
                    {sWidth: '10%'} //Option
                ],
                "ajax": {
                    url: '<?= base_url(); ?>admin/srchRelenseNt',
                    type: 'post',
                    data: {
                        frdt: frdt,
                        todt: todt,
                    }
                }
            });

        }

        //Add New
        $('#addBtn').click(function (e) {
            e.preventDefault();
            if ($('#addForm').valid()) {
                $('#addBtn').prop('disabled', true);
                swal({
                    title: "Processing...",
                    text: "User data saving..",
                    imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                    showConfirmButton: false
                });

                jQuery.ajax({
                    type: "POST",
                    url: "<?= base_url(); ?>admin/addRelesNote",
                    data: $("#addForm").serialize(),
                    dataType: 'json',
                    success: function (data) {
                        swal({title: "", text: "Release Note Creation Success!", type: "success"},
                            function () {
                                $('#addBtn').prop('disabled', false);
                                clear_Form('addForm');
                                $('#modal-add').modal('hide');
                                srcLgnote();
                            });
                    },
                    error: function (data, textStatus) {
                        swal({title: "Registration Failed", text: textStatus, type: "error"},
                            function () {
                                location.reload();
                            });
                    }
                });
            }
        });

        //View
        function edtReleseNote(id) {
            $.ajax({
                url: '<?= base_url(); ?>Admin/getReleseNote',
                type: 'POST',
                data: {
                    chid: id
                },
                dataType: 'json',
                success: function (response) {
                    var len = response.length;

                    if (len > 0) {
                        document.getElementById("rcdtv").innerHTML = response[0]['rcdt'];
                        document.getElementById("rcbyv").innerHTML = response[0]['poby'];
                        document.getElementById("sendv").innerHTML = response[0]['rfno'];
                        document.getElementById("relceNty").innerHTML = response[0]['rmks'];

                    } else {
                        document.getElementById("rcdtv").innerHTML = '-';
                        document.getElementById("rcbyv").innerHTML = '-';
                        document.getElementById("sendv").innerHTML = '-';
                        document.getElementById("relceNty").innerHTML = "no Note";
                    }
                }
            });
        }

        function sendMail(chid) {
            swal({
                title: "Processing...",
                text: "User data saving..",
                imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                showConfirmButton: false
            });

            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>admin/sendMail",
                data: {
                    chid: chid,
                },
                dataType: 'json',
                success: function (data) {
                    srcLgnote();
                    swal({title: "Release Notes Send Success!", text: "", type: "success"},
                        function () {
                            location.reload();
                        });
                },
                error: function () {
                    swal({title: "Notes Sending Failed !", text: "", type: "error"},
                        function () {
                            location.reload();
                        });
                }
            })
        }

        function rejecSppy(id) {
            swal({
                    title: "Are you sure?",
                    text: "Your will not be able to recover this check",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3bdd59",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            url: '<?= base_url(); ?>admin/rejecSppy',
                            type: 'post',
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (response) {
                                if (response) {
                                    swal({title: "Inactive Success !", text: "", type: "success"});
                                    srcLgnote();
                                }
                            }
                        });
                    } else {
                        swal("Cancelled!", "Not Rejected", "error");
                    }
                });
        }

        function sendMaildd(id) {
            swal({
                    title: "Are you sure?",
                    text: "Your will not be able to recover this check",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3bdd59",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            url: '<?= base_url(); ?>admin/doneSchedule',
                            type: 'post',
                            data: {
                                auid: id
                            },
                            dataType: 'json',
                            success: function (response) {
                                if (response) {
                                    srcLgnote();
                                    swal({title: "Schedule Done Success !", text: "", type: "success"},
                                        function () {
                                            //  location.reload();
                                        });
                                }
                            }
                        });
                    } else {
                        swal("Cancelled!", "Schedule Done Faild", "error");
                    }
                });
        }

    </script>


</div>
<!-- END PAGE CONTAINER -->
