<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">System Component</a></li>
        <li class="active">User Level</li>
    </ul>
</div>
<div class="app-heading app-heading-bordered app-heading-page">
    <div class="icon icon-lg">
        <span class="fa fa-user" style="color: #e69c0f;"></span>
    </div>
    <div class="title">
        <h1>User Level</h1>
        <p>view </p>
    </div>
    <?php
    if ($funcPerm[0]->inst == 1) { ?>
        <div class="pull-right">
            <button class="btn btn-sm btn-info btn-icon-fixed btn-rounded" data-toggle="modal" data-target="#modal-add">
                <span class="fa fa-plus"></span>Register
            </button>
        </div>
    <?php }
    ?>
</div>
<!-- END PAGE HEADING -->

<!-- START PAGE CONTAINER -->
<div class="container">

    <div class="block">
        <div class="row form-horizontal">

            <!-- <div class="col-md-4">
                <div class="form-group">
                    <label class="col-md-4 col-xs-12 control-label">Branch</label>
                    <div class="col-md-8 col-xs-12">
                        <select class="bs-select" name="brch" id="brch"
                                onchange="chckBtn(this.value,'brch')">
                            <?php
            /*                            foreach ($branchinfo as $branch) {
                                            echo "<option value='$branch[brch_id]'>$branch[brch_name]</option>";
                                        }
                                        */ ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-md-4 col-xs-12 control-label">User </label>
                    <div class="col-md-8 col-xs-12" id="userSclt">
                        <select class="bs-select" name="uslv" id="uslv"
                                onchange="chckBtn(this.value,'uslv')">
                            <option value="all"> -- All Level --</option>
                            <?php
            /*                            foreach ($uslvlinfo as $uslv) {
                                            echo "<option value='$uslv->id]'>$uslv->lvnm</option>";
                                        }
                                        */ ?>
                        </select>
                    </div>
                </div>
            </div>-->

            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-md-4 col-xs-12 control-label">Status</label>
                    <div class="col-md-8 col-xs-12">
                        <select id="stat" name="stat" class="bs-select" onchange="srchLvl()">
                            <option value="all">All</option>
                            <!--<option value="0">Pending</option>-->
                            <option value="1">Active</option>
                            <option value="2">Tmp Disable</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="block">
        <div class="row form-horizontal">
            <div class="table-responsive">
                <table id="userLvlDataTb" class="table dataTable table-striped table-bordered" width="100%">
                    <thead>
                    <tr>
                        <th class="text-left">#</th>
                        <th class="text-left">LEVEL NAME</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $().ready(function () {
            //Table Initializing
            $('#userLvlDataTb').DataTable({
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
            });
            srchLvl();
        });

        //Search
        function srchLvl() {

            var stat = $('#stat').val();

            $('#userLvlDataTb').DataTable().clear();
            $('#userLvlDataTb').DataTable({
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
                    {className: "text-left", "targets": [1]},
                    {className: "text-center", "targets": [0]},
                    {className: "text-right", "targets": [0]},
                    {className: "text-nowrap", "targets": []},
                ],
                "order": [[0, "DESC"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '3%'}, //#
                    {sWidth: '10%'}, //Code
                ],
                "ajax": {
                    url: '<?= base_url(); ?>admin/searchUserLvl',
                    type: 'post',
                    data: {
                        stat: stat,
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
                    url: "<?= base_url(); ?>admin/userCreate",
                    data: $("#addForm").serialize(),
                    dataType: 'json',
                    success: function (data) {
                        swal({title: "", text: "Registration Success!", type: "success"},
                            function () {
                                $('#addBtn').prop('disabled', false);
                                clear_Form('addForm');
                                $('#modal-add').modal('hide');
                                srchUser();
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
        function viewBrnc(id, func) {
            swal({
                title: "Loading Data...",
                text: "Supplier's Details",
                imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                showConfirmButton: false
            });

            if (func == 'view') {
                //VIEW MODEL
                $('#subTitle_edit').html(' - View');
                $('#edtBtn').css('display', 'none');
                $("#modal-view").find('.edit_req').css("display", "none");

                //Make readonly all fields
                $("#modal-view :input").attr("readonly", true);
                $("#prmTpEdt").attr("disabled", true);

                $("#modal-view").find('.bootstrap-select').addClass("disabled dropup");
                $("#modal-view").find('.bootstrap-select').children().addClass("disabled dropup");
                var des = "disabled";
                //VIEW MODEL
            } else if (func == 'edit') {
                //EDIT MODEL
                $('#subTitle_edit').html(' - Edit');
                $('#edtBtn').css('display', 'inline');
                $('#edtBtn').html('Update');
                $("#modal-view").find('.edit_req').css("display", "inline");

                //Remove readonly all fields
                $("#modal-view :input").attr("readonly", false);
                $("#prmTpEdt").attr("disabled", false);
                $("#udobEdt").attr("readonly", true);

                $("#modal-view").find('.bootstrap-select').removeClass("disabled dropup");
                $("#modal-view").find('.bootstrap-select').children().removeClass("disabled dropup");
                var des = "";
                //EDIT MODEL
            }

            $('#func').val(func);
            $('#auid').val(id);

            jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>admin/getUserDet",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (data) {
                    var len = data.length;
                    if (len > 0) {
                        set_select('brchNwEdt', data[0]['brch']);
                        set_select('uslvNwEdt', data[0]['usmd']);
                        set_select('ugndEdt', data[0]['gend']);

                        $('#frnmEdt').val(data[0]['fnme']);
                        $('#lsnmEdt').val(data[0]['lnme']);

                        $('#emilEdt').val(data[0]['emid']);
                        $('#usnmEdt').val(data[0]['usnm']);

                        $('#unicEdt').val(data[0]['unic']);
                        $('#udobEdt').val(data[0]['udob']);
                        //$('#ugndEdt').val(data[0]['gend']);
                        $('#teleEdt').val(data[0]['tpno']);
                        $('#mobiEdt').val(data[0]['almo']);

                        if (data[0]['prmd'] == 1) {
                            $("#prmTpEdt").prop("checked", true);
                        } else {
                            $("#prmTpEdt").prop("checked", false);
                        }
                    }
                    swal.close();
                },
                error: function (data, textStatus) {
                    swal({title: "Loading Failed", text: textStatus, type: "error"},
                        function () {
                            location.reload();
                        });
                }
            });
        }

        //APPROVE || EDIT HERE
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

                            if (func == 'edit') {
                                swal({
                                    title: "Processing...",
                                    text: "User's details updating..",
                                    imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                                    showConfirmButton: false
                                });

                                jQuery.ajax({
                                    type: "POST",
                                    url: "<?= base_url(); ?>admin/userEdit",
                                    data: $("#edtform").serialize(),
                                    dataType: 'json',
                                    success: function (data) {
                                        swal({title: "", text: "Updating Success!", type: "success"},
                                            function () {
                                                $('#edtBtn').prop('disabled', false);
                                                clear_Form('edtform');
                                                $('#modal-view').modal('hide');
                                                srchUser();
                                            });
                                    },
                                    error: function (data, textStatus) {
                                        swal({title: "Updating Failed", text: textStatus, type: "error"},
                                            function () {
                                                location.reload();
                                            });
                                    }
                                });
                            }
                            else {
                                alert('Contact System Admin');
                            }
                        } else {
                            swal("Cancelled", " ", "warning");
                        }
                    });
            }
        });

        //Reject
        function rejectUser(id) {
            swal({
                    title: "Are you sure reject ?",
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
                        swal({
                            title: "Processing...",
                            text: "Rejecting...",
                            imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                            showConfirmButton: false
                        });

                        $.ajax({
                            type: "POST",
                            url: "<?= base_url(); ?>admin/brnReject",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (data) {
                                swal({title: "", text: "Branch was rejected!", type: "success"},
                                    function () {
                                        srchUser();
                                    });
                            },
                            error: function (data, textStatus) {
                                swal({title: "Faild", text: textStatus, type: "error"},
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

        //Deactivate
        function inactUser(id) {
            swal({
                    title: "Are you sure to deactivate ?",
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
                        swal({
                            title: "Processing...",
                            text: "",
                            imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                            showConfirmButton: false
                        });

                        $.ajax({
                            type: "POST",
                            url: "<?= base_url(); ?>admin/userDeactive",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (data) {
                                swal({title: "", text: "Deactivated!", type: "success"},
                                    function () {
                                        srchUser();
                                    });
                            },
                            error: function (data, textStatus) {
                                swal({title: "Faild", text: textStatus, type: "error"},
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

        //activate Supplier
        function reactUser(id) {
            swal({
                    title: "Are you sure to activate ?",
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
                        swal({
                            title: "Processing...",
                            text: "Activating...",
                            imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                            showConfirmButton: false
                        });

                        $.ajax({
                            type: "POST",
                            url: "<?= base_url(); ?>admin/userReactiv",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (data) {
                                swal({title: "", text: "Activated!", type: "success"},
                                    function () {
                                        srchUser();
                                    });
                            },
                            error: function (data, textStatus) {
                                swal({title: "Faild", text: textStatus, type: "error"},
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
    </script>
</div>
<!-- END PAGE CONTAINER -->
