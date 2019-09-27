<script type="text/javascript" src="<?= base_url(); ?>assets/js/custom-js/full_width.js"></script>

<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">MIT Setting</a></li>
        <li class="active">System Update</li>
    </ul>
</div>
<div class="app-heading app-heading-bordered app-heading-page">
    <div class="icon icon-lg">
        <span class="fa fa-user" style="color: #e69c0f;"></span>
    </div>
    <div class="title">
        <h1>System Update</h1>
        <p>Create / Edit / Inactive </p>
    </div>

    <div class="pull-right">
        <button class="btn btn-sm btn-info btn-icon-fixed btn-rounded" data-toggle="modal" data-target="#modal-add">
            <span class="fa fa-plus"></span> Add Schedule
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
                            onclick="srcSchedule()">
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
                        <th class="text-left">MESSAGE</th>
                        <th class="text-left">FROM</th>
                        <th class="text-left">TO</th>
                        <th class="text-left">CR BY</th>
                        <th class="text-left">CR DATE</th>
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
        <div class="modal-dialog modal-md" role="document">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="icon-cross"></span>
            </button>
            <form id="addForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> Add New
                            System Down
                        </h4>
                    </div>

                    <div class="modal-body">
                        <div class="container">
                            <div class="row form-horizontal">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Date</label>
                                        <div class="col-md-8 col-xs-12">
                                            <div class='input-group date'>
                                                <input type='text' class="form-control datetimepicker" id="scdt"
                                                       name="scdt" value="<?= date('Y-m-d') ?>"/>
                                                <span class="input-group-addon"><span class="fa fa-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Message <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <textarea class="form-control" name="mssg" id="mssg"
                                                      placeholder="Message"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Start Time <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <div class='input-group date'>
                                                <input type='text' class="form-control dtimPck" name="sttm" id="sttm"/>
                                                <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-time"></span>
                                                    </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">End Time <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <div class='input-group date' id=''>
                                                <input type='text' class="form-control dtimPck" name="entm" id="entm"/>
                                                <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-time"></span>
                                                    </span>
                                            </div>
                                        </div>
                                    </div>
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
        <div class="modal-dialog modal-md" role="document">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="icon-cross"></span>
            </button>

            <form id="edtform">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> Edit System
                            Down
                            <span class="text-muted" id="subTitle_edit"></span></h4>
                        <input type="hidden" id="func" name="func"/>
                        <input type="hidden" id="auid" name="auid"/>
                    </div>

                    <div class="modal-body">
                        <div class="container">
                            <div class="row form-horizontal">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Date</label>
                                        <div class="col-md-8 col-xs-12">
                                            <div class='input-group date'>
                                                <input type='text' class="form-control datetimepicker" id="scdtEdt"
                                                       name="scdtEdt" value="<?= date('Y-m-d') ?>"/>
                                                <span class="input-group-addon"><span class="fa fa-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Message <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <textarea class="form-control" name="mssgEdt" id="mssgEdt"
                                                      placeholder="Message"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Start Time <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <div class='input-group date'>
                                                <input type='text' class="form-control dtimPck" name="sttmEdt"
                                                       id="sttmEdt"/>
                                                <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-time"></span>
                                                    </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">End Time <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <div class='input-group date' id=''>
                                                <input type='text' class="form-control dtimPck" name="entmEdt"
                                                       id="entmEdt"/>
                                                <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-time"></span>
                                                    </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                        <button type="button" id="edtBtn" class="btn btn-warning btn-sm btn-rounded">Edit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END VIEW  -->

    <script type="text/javascript">

        $().ready(function () {
            //Table Initializing
            $('#DataTbSysupdt').DataTable({
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
            });

            $('.dtimPck').datetimepicker({
                //format: 'LT'
                format: 'HH:mm'
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
            srcSchedule();
        });

        //Search
        function srcSchedule() {
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
                    {className: "text-left", "targets": [2, 3, 5, 6]},
                    {className: "text-center", "targets": [0, 1, 4, 7, 8]},
                    {className: "text-right", "targets": [0]},
                    {className: "text-nowrap", "targets": [2, 3]},
                ],
                "order": [[6, "DESC"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '3%'}, //#
                    {sWidth: '10%'}, //
                    {sWidth: '10%'}, //
                    {sWidth: '10%'}, //
                    {sWidth: '10%'}, //
                    {sWidth: '10%'}, //
                    {sWidth: '10%'}, //
                    {sWidth: '10%'}, //Status
                    {sWidth: '10%'} //Option
                ],
                "ajax": {
                    url: '<?= base_url(); ?>admin/srchSystmUpdte',
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
                    url: "<?= base_url(); ?>admin/addSysDown",
                    data: $("#addForm").serialize(),
                    dataType: 'json',
                    success: function (data) {
                        swal({title: "", text: "Registration Success!", type: "success"},
                            function () {
                                $('#addBtn').prop('disabled', false);
                                clear_Form('addForm');
                                $('#modal-add').modal('hide');
                                srcSchedule();
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
        function edtSchedule(id) {
            $.ajax({
                url: '<?= base_url(); ?>Admin/getDetSysDown',
                type: 'POST',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (response) {
                    document.getElementById("scdtEdt").value = response[0]['date'];
                    document.getElementById("sttmEdt").value = response[0]['frtm'];
                    document.getElementById("entmEdt").value = response[0]['totm'];
                    document.getElementById("mssgEdt").value = response[0]['mesg'];
                    document.getElementById("auid").value = id;
                }
            });
        }

        // EDIT HERE
        $('#edtBtn').click(function (e) {
            e.preventDefault();
            if ($('#edtform').valid()) {

                swal({
                        title: "Are you sure to do this ?",
                        text: "",
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
                            var func = $('#func').val();
                            $('#edtBtn').prop('disabled', false);

                            swal({
                                title: "Processing...",
                                text: "User's details updating..",
                                imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                                showConfirmButton: false
                            });

                            jQuery.ajax({
                                type: "POST",
                                url: "<?= base_url(); ?>admin/edtSysDown",
                                data: $("#edtform").serialize(),
                                dataType: 'json',
                                success: function (data) {
                                    swal({title: "", text: "Updating Success!", type: "success"},
                                        function () {
                                            $('#edtBtn').prop('disabled', false);
                                            clear_Form('edtform');
                                            $('#modal-view').modal('hide');
                                            srcSchedule();
                                        });
                                },
                                error: function (data, textStatus) {
                                    swal({title: "Updating Failed", text: textStatus, type: "error"},
                                        function () {
                                            location.reload();
                                        });
                                }
                            });

                        } else {
                            swal("Cancelled", " ", "warning");
                        }
                    });
            }
        });

        function doneSchedule(id) {
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
                                    srcSchedule();
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
