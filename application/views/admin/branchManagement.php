<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">System Component</a></li>
        <li class="active">Branch Management</li>
    </ul>
</div>
<div class="app-heading app-heading-bordered app-heading-page">
    <div class="icon icon-lg">
        <span class="fa fa-user" style="color: #e69c0f;"></span>
    </div>
    <div class="title">
        <h1>Branch Management</h1>
        <p>Create / Edit / Inactive / Active </p>
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
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-md-4 col-xs-12 control-label">Status</label>
                    <div class="col-md-8 col-xs-12">
                        <select id="stat" name="stat" onchange="srchBrnch();" class="bs-select">
                            <option value="all">All</option>
                            <option value="0">Pending</option>
                            <option value="1">Active</option>
                            <option value="2">Tmp Disable</option>
                            <option value="3">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="block">
        <div class="row form-horizontal">
            <div class="table-responsive">
                <table id="supp_table" class="table dataTable table-striped table-bordered" width="100%">
                    <thead>
                    <tr>
                        <th class="text-left">#</th>
                        <th class="text-left">CODE</th>
                        <th class="text-left">NAME</th>
                        <th class="text-left">ADDRESS</th>
                        <th class="text-left">MOBILE</th>
                        <th class="text-left">CREATED BY</th>
                        <th class="text-left">CREATED DATE</th>
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

    <!-- MODAL ADD NEW SUPPLIER -->
    <div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modal-default-header">
        <div class="modal-dialog" role="document">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="icon-cross"></span>
            </button>
            <form id="addBrncform">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> Branch Create
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row form-horizontal">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Branch Name <span
                                                    class="fa fa-asterisk" style="color: red"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input class="form-control" type="text" name="name" id="name"
                                                   placeholder="Branch Name"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Branch Code <span
                                                    class="fa fa-asterisk" style="color: red"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input class="form-control text-uppercase" type="text" name="code" id="code"
                                                   placeholder="Branch Code"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Address <span
                                                    class="fa fa-asterisk"
                                                    style="color: red"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                        <textarea class="form-control" name="addr" id="addr"
                                                  placeholder="Address"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Contact <span
                                                    class="fa fa-asterisk"
                                                    style="color: red"></span></label>
                                        <div class="col-md-4 col-xs-12">
                                            <input class="form-control" type="text" name="mobi" id="mobi"
                                                   placeholder="Mobile"/>
                                        </div>
                                        <div class="col-md-4 col-xs-12">
                                            <input class="form-control" type="text" name="tele" id="tele"
                                                   placeholder="Land Tele."/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Email <span
                                                    class="fa fa-asterisk"
                                                    style="color: red"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input class="form-control" type="email" name="email" id="email"
                                                   placeholder="Email"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Remark</label>
                                        <div class="col-md-8 col-xs-12">
                                        <textarea class="form-control" rows="5" name="remk" id="remk"
                                                  placeholder="Remark"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="pull-left">
                            <span class="fa fa-hand-o-right"></span> <label style="color: red"> <span
                                        class="fa fa-asterisk"></span> Required Fields </label>
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

    <!-- MODAL VIEW  -->
    <div class="modal fade" id="modal-view" tabindex="-1" role="dialog" aria-labelledby="modal-default-header">
        <div class="modal-dialog modal-md" role="document">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"
                                                                                              class="icon-cross"></span>
            </button>
            <form id="brnEdtform">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> Branch
                            Creation <span class="text-muted" id="subTitle_edit"></span></h4>
                        <input type="hidden" id="func" name="func"/>
                        <input type="hidden" id="auid" name="auid"/>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row form-horizontal">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Branch Name <span
                                                    class="fa fa-asterisk" style="color: red"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input class="form-control" type="text" name="nameEdt" id="nameEdt"
                                                   placeholder="Branch Name"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Branch Code <span
                                                    class="fa fa-asterisk" style="color: red"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input class="form-control text-uppercase" type="text" name="codeEdt"
                                                   id="codeEdt"
                                                   placeholder="Branch Code"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Address <span
                                                    class="fa fa-asterisk"
                                                    style="color: red"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                        <textarea class="form-control" name="addrEdt" id="addrEdt"
                                                  placeholder="Address"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Contact <span
                                                    class="fa fa-asterisk"
                                                    style="color: red"></span></label>
                                        <div class="col-md-4 col-xs-12">
                                            <input class="form-control" type="text" name="mobiEdt" id="mobiEdt"
                                                   placeholder="Mobile"/>
                                        </div>
                                        <div class="col-md-4 col-xs-12">
                                            <input class="form-control" type="text" name="teleEdt" id="teleEdt"
                                                   placeholder="Land Tele."/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Email <span
                                                    class="fa fa-asterisk"
                                                    style="color: red"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input class="form-control" type="email" name="emailEdt" id="emailEdt"
                                                   placeholder="Email"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Remark</label>
                                        <div class="col-md-8 col-xs-12">
                                        <textarea class="form-control" rows="5" name="remkEdt" id="remkEdt"
                                                  placeholder="Remark"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-horizontal" id="view_Area">
                                <div class="col-md-12">
                                    <!--<div class="form-group">
                                        <label class="col-md-4 control-label">Status</label>
                                        <label class="col-md-8 control-label" id="sup_stat"></label>
                                    </div>-->
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Created By</label>
                                        <label class="col-md-8 control-label" id="crby"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Created Date</label>
                                        <label class="col-md-8 control-label" id="crdt"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Approved By</label>
                                        <label class="col-md-8 control-label" id="apby"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Approved Date</label>
                                        <label class="col-md-8 control-label" id="apdt"></label>
                                    </div>
                                    <!--<div class="form-group">
                                        <label class="col-md-4 control-label">Rejected By</label>
                                        <label class="col-md-8 control-label" id="rjby"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Rejected Date</label>
                                        <label class="col-md-8 control-label" id="rjdt"></label>
                                    </div>-->
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Updated By</label>
                                        <label class="col-md-8 control-label" id="mdby"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Updated Date</label>
                                        <label class="col-md-8 control-label" id="mddt"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                        <button type="button" id="edtBtn" class="btn btn-warning btn-sm btn-rounded">
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
            $('#supp_table').DataTable({
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
            });

            $('#addBrncform').validate({
                rules: {
                    name: {
                        required: true,
                        remote: {
                            url: "<?= base_url(); ?>admin/chkBrncName",
                            type: "post",
                            data: {
                                name: function () {
                                    return $("#name").val();
                                },
                                stat: 0
                            }
                        }
                    },
                    code: {
                        required: true,
                        minlength: 2,
                        maxlength: 2,
                        remote: {
                            url: "<?= base_url(); ?>admin/chkBrnCode",
                            type: "post",
                            data: {
                                code: function () {
                                    return $("#code").val();
                                },
                                stat: 0
                            }
                        }
                    },
                    addr: {
                        required: true
                    },
                    mobi: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 10,
                    },
                    tele: {
                        digits: true,
                        minlength: 10,
                        maxlength: 10,
                    },
                    email: {
                        required: true,
                        email: true
                    },

                },
                messages: {
                    name: {
                        required: "Enter Branch Name",
                        remote: "Already entered Name"
                    },
                    code: {
                        required: "Enter Branch Code",
                        remote: "Already Entered Code"
                    },
                    addr: {
                        required: "Enter Branch address"
                    },
                    mobi: {
                        required: "Enter mobile number",
                        digits: "Only numbers are allowed",
                        minlength: "Please enter 10 digits number",
                        maxlength: "Please enter 10 digits number",
                        remote: "This number is already added"
                    },
                    tele: {
                        digits: "Only numbers are allowed",
                        minlength: "Please enter 10 digits number",
                        maxlength: "Please enter 10 digits number",
                        remote: "This number is already added"
                    },
                    email: {
                        required: "Enter email address",
                        email: "Please enter valid email address"
                    },
                }
            });

            $('#brnEdtform').validate({
                rules: {
                    nameEdt: {
                        required: true,
                        remote: {
                            url: "<?= base_url(); ?>admin/chkBrncName",
                            type: "post",
                            data: {
                                name: function () {
                                    return $("#nameEdt").val();
                                },
                                auid: function () {
                                    return $("#auid").val();
                                },
                                stat: 1
                            }
                        }
                    },
                    codeEdt: {
                        required: true,
                        remote: {
                            url: "<?= base_url(); ?>admin/chkBrnCode",
                            type: "post",
                            data: {
                                code: function () {
                                    return $("#codeEdt").val();
                                },
                                auid: function () {
                                    return $("#auid").val();
                                },
                                stat: 1
                            }
                        }
                    },
                    addrEdt: {
                        required: true
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
                    emailEdt: {
                        required: true,
                        email: true
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

            srchBrnch();
        });

        //Search
        function srchBrnch() {
            var stat = $('#stat').val();
            $('#supp_table').DataTable().clear();
            $('#supp_table').DataTable({
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
                    {className: "text-left", "targets": [2, 3, 5]},
                    {className: "text-center", "targets": [0, 1, 4, 6, 7, 8]},
                    {className: "text-right", "targets": [0]},
                    {className: "text-nowrap", "targets": [2, 3]},
                ],
                "order": [[6, "DESC"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '3%'}, //#
                    {sWidth: '5%'}, //Code
                    {sWidth: '15%'}, //Name
                    {sWidth: '15%'}, //Address
                    {sWidth: '10%'}, //Mobile
                    {sWidth: '10%'}, //Created By
                    {sWidth: '10%'}, //Created date
                    {sWidth: '8%'}, //Status
                    {sWidth: '12%'} //Option
                ],

                "ajax": {
                    url: '<?= base_url(); ?>admin/searchBranc',
                    type: 'post',
                    data: {
                        stat: stat
                    }
                }
            });
        }

        //Add New
        $('#addBtn').click(function (e) {
            e.preventDefault();
            if ($('#addBrncform').valid()) {
                $('#addBtn').prop('disabled', true);
                swal({
                    title: "Processing...",
                    text: "Branch's data saving..",
                    imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                    showConfirmButton: false
                });

                jQuery.ajax({
                    type: "POST",
                    url: "<?= base_url(); ?>admin/branchCreate",
                    data: $("#addBrncform").serialize(),
                    dataType: 'json',
                    success: function (data) {
                        swal({title: "", text: "Registration Success!", type: "success"},
                            function () {
                                $('#addBtn').prop('disabled', false);
                                clear_Form('addBrncform');
                                $('#modal-add').modal('hide');
                                srchBrnch();
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
                $("#edit_Area").css('display', 'none');
                $("#view_Area").css('display', 'block');
                //Make readonly all fields
                $("#modal-view :input").attr("readonly", true);
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
                $("#edit_Area").css('display', 'block');
                $("#view_Area").css('display', 'none');
                //Remove readonly all fields
                $("#modal-view :input").attr("readonly", false);
                $("#modal-view").find('.bootstrap-select').removeClass("disabled dropup");
                $("#modal-view").find('.bootstrap-select').children().removeClass("disabled dropup");
                var des = "";
                //EDIT MODEL
            } else if (func == 'app') {
                //APPROVE MODEL
                $('#subTitle_edit').html(' - Approve');
                $('#edtBtn').css('display', 'inline');
                $('#edtBtn').html('Approve');
                $("#modal-view").find('.edit_req').css("display", "inline");
                $("#edit_Area").css('display', 'block');
                $("#view_Area").css('display', 'none');
                //Remove readonly all fields
                $("#modal-view :input").attr("readonly", false);
                $("#modal-view").find('.bootstrap-select').removeClass("disabled dropup");
                $("#modal-view").find('.bootstrap-select').children().removeClass("disabled dropup");
                var des = "";
                //APPROVE MODEL
            }

            $('#func').val(func);
            $('#auid').val(id);

            jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>admin/getBrncDet",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (data) {
                    var len = data['brnch'].length;
                    if (len > 0) {
                        $('#nameEdt').val(data['brnch'][0]['brnm']);
                        $('#codeEdt').val(data['brnch'][0]['brcd']);
                        $('#addrEdt').val(data['brnch'][0]['brad']);
                        $('#mobiEdt').val(data['brnch'][0]['brmb']);
                        $('#teleEdt').val(data['brnch'][0]['brtp']);
                        $('#emailEdt').val(data['brnch'][0]['brem']);
                        $('#remkEdt').val(data['brnch'][0]['remk']);

                        //$('#sup_stat').html(": " + stat);
                        //$('#code').html(": " + data['subDtil'][0]['spcd']);
                        $('#crby').html(": " + data['subDtil'][0]['crby']);
                        $('#crdt').html(": " + data['subDtil'][0]['crdt']);
                        $('#apby').html(": " + ((data['subDtil'][0]['apby'] != null) ? data['subDtil'][0]['apby'] : "--"));
                        $('#apdt').html(": " + ((data['subDtil'][0]['apdt'] != null && data['subDtil'][0]['apdt'] != "0000-00-00 00:00:00") ? data['subDtil'][0]['apdt'] : "--"));
                        //$('#rjby').html(": " + ((data['subDtil'][0]['rjnm'] != null) ? data['subDtil'][0]['rjnm'] : "--"));
                        //$('#rjdt').html(": " + ((data['subDtil'][0]['rjdt'] != null && data['subDtil'][0]['rjdt'] != "0000-00-00 00:00:00") ? data['subDtil'][0]['rjdt'] : "--"));
                        $('#mdby').html(": " + ((data['subDtil'][0]['mdby'] != null) ? data['subDtil'][0]['mdby'] : "--"));
                        $('#mddt').html(": " + ((data['subDtil'][0]['mddt'] != null && data['subDtil'][0]['mddt'] != "0000-00-00 00:00:00") ? data['subDtil'][0]['mddt'] : "--"));


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
            if ($('#brnEdtform').valid()) {

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
                                    text: "Branch's details updating..",
                                    imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                                    showConfirmButton: false
                                });

                                jQuery.ajax({
                                    type: "POST",
                                    url: "<?= base_url(); ?>admin/brncEdit",
                                    data: $("#brnEdtform").serialize(),
                                    dataType: 'json',
                                    success: function (data) {
                                        swal({title: "", text: "Updating Success!", type: "success"},
                                            function () {
                                                $('#edtBtn').prop('disabled', false);
                                                clear_Form('brnEdtform');
                                                $('#modal-view').modal('hide');
                                                srchBrnch();
                                            });
                                    },
                                    error: function (data, textStatus) {
                                        swal({title: "Updating Failed", text: textStatus, type: "error"},
                                            function () {
                                                location.reload();
                                            });
                                    }
                                });
                            } else if (func == 'app') {
                                swal({
                                    title: "Processing...",
                                    text: "Supplier approving..",
                                    imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                                    showConfirmButton: false
                                });

                                jQuery.ajax({
                                    type: "POST",
                                    url: "<?= base_url(); ?>admin/brncEdit",
                                    data: $("#brnEdtform").serialize(),
                                    dataType: 'json',
                                    success: function (data) {
                                        swal({title: "", text: "Approved!", type: "success"},
                                            function () {
                                                $('#edtBtn').prop('disabled', false);
                                                clear_Form('brnEdtform');
                                                $('#modal-view').modal('hide');
                                                srchBrnch();
                                            });
                                    },
                                    error: function (data, textStatus) {
                                        swal({title: "Approving Failed", text: textStatus, type: "error"},
                                            function () {
                                                location.reload();
                                            });
                                    }
                                });
                            } else {
                                alert('Contact System Admin');
                            }
                        } else {
                            swal("Cancelled", " ", "warning");
                        }
                    });
            }
        });

        //Reject
        function rejectSupp(id) {
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
                                        srchBrnch();
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
        function inactSupp(id) {
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
                            url: "<?= base_url(); ?>admin/brnDeactive",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (data) {
                                swal({title: "", text: "Branch was deactivated!", type: "success"},
                                    function () {
                                        srchBrnch();
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
        function reactSupp(id) {
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
                            url: "<?= base_url(); ?>admin/brncReactiv",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (data) {
                                swal({title: "", text: "Branch was activated!", type: "success"},
                                    function () {
                                        srchBrnch();
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
