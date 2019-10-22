<script type="text/javascript" src="<?= base_url(); ?>assets/js/custom-js/full_width.js"></script>

<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">Customer Management</a></li>
        <li class="active">Customer Registration</li>
    </ul>
</div>
<div class="app-heading app-heading-bordered app-heading-page">
    <div class="icon icon-lg">
        <span class="icon-home" style="color: #e69c0f;"></span>
    </div>
    <div class="title">
        <h1>Customer Registration</h1>
        <p>Register / Edit / Reject / Deactive / Search & View</p>
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
                        <select id="stat" name="stat" onchange="srchCustmer();" class="bs-select">
                            <option value="all">All</option>
                            <option value="0">Pending</option>
                            <option value="1">Active</option>
                            <option value="3">Inactive</option>
                            <option value="2">Reject</option>
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
                        <th class="text-left">NIC</th>
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
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"
                                                                                              class="icon-cross"></span>
            </button>
            <form id="addForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> Customer
                            Registering</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row form-horizontal">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Customer Name <span
                                                    class="fa fa-asterisk" style="color: red"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input class="form-control" type="text" name="cusnm" id="cusnm"
                                                   placeholder="Customer Name"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Address <span
                                                    class="fa fa-asterisk"
                                                    style="color: red"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                        <textarea class="form-control" name="addr" id="addr"
                                                  placeholder="Customer Address"></textarea>
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
                                        <label class="col-md-4 col-xs-12 control-label">NIC <span
                                                    class="fa fa-asterisk"
                                                    style="color: red"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input class="form-control" type="text" name="anic" id="anic"
                                                   onkeyup="checkNic(this.value,'anic','addBtn','','','')"
                                                   placeholder="NIC"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Email </label>
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
                            <span class="fa fa-hand-o-right"></span> <label style="color: red">
                                <span class="fa fa-asterisk"></span> Required Fields </label>
                        </div>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                        <button type="button" id="addBtn" class="btn btn-warning btn-xs btn-rounded">Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END ADD NEW SUPPLIER -->

    <!-- MODAL VIEW SUPPLIER -->
    <div class="modal fade" id="modal-view" tabindex="-1" role="dialog" aria-labelledby="modal-default-header">
        <div class="modal-dialog modal-lg" role="document">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="icon-cross"></span>
            </button>
            <form id="app_sup_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> Customer
                            Registering <span class="text-muted" id="subTitle_edit"></span></h4>
                        <input type="hidden" id="func" name="func"/>
                        <input type="hidden" id="cuid" name="cuid"/>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="form-horizontal">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Customer Name <span
                                                    class="fa fa-asterisk" style="color: red"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input class="form-control" type="text" name="cusnmEdt" id="cusnmEdt"
                                                   placeholder="Customer Name"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Address <span
                                                    class="fa fa-asterisk"
                                                    style="color: red"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                        <textarea class="form-control" name="addrEdt" id="addrEdt"
                                                  placeholder="Customer Address"></textarea>
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
                                        <label class="col-md-4 col-xs-12 control-label">NIC <span
                                                    class="fa fa-asterisk"
                                                    style="color: red"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input class="form-control" type="text" name="anicEdt" id="anicEdt"
                                                   onkeyup="checkNic(this.value,'anicEdt','edtBtn','','','')"
                                                   placeholder="NIC"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Email </label>
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
                            <div class="form-horizontal view_Area">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Status</label>
                                        <label class="col-md-8 control-label" id="sup_stat"></label>
                                    </div>
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
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Rejected By</label>
                                        <label class="col-md-8 control-label" id="rjby"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Rejected Date</label>
                                        <label class="col-md-8 control-label" id="rjdt"></label>
                                    </div>
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
                        <button type="button" id="edtBtn" class="btn btn-warning btn-xs btn-rounded">
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END VIEW SUPPLIER -->

    <script type="text/javascript">

        $().ready(function () {
            //Table Initializing
            $('#supp_table').DataTable({
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                "aoColumns": [
                    {sWidth: '3%'},
                    {sWidth: '5%'},
                    {sWidth: '15%'},
                    {sWidth: '15%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '8%'},
                    {sWidth: '12%'}
                ],
            });

            $('#addForm').validate({
                rules: {
                    cusnm: {
                        required: true,
                    },
                    addr: {
                        required: true
                    },
                    mobi: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 10,
                        remote: {
                            url: "<?= base_url(); ?>Stock/chk_mobile",
                            type: "post",
                            data: {
                                mobi: function () {
                                    return $("#mobi").val();
                                },
                                stat: 0
                            }
                        }
                    },
                    tele: {
                        digits: true,
                        minlength: 10,
                        maxlength: 10,
                        remote: {
                            url: "<?= base_url(); ?>Stock/chk_mobile",
                            type: "post",
                            data: {
                                mobi: function () {
                                    return $("#tele").val();
                                },
                                stat: 0
                            }
                        }
                    },
                    email: {
                        //required: true,
                        email: true
                    },
                    anic: {
                        required: true,
                        minlength: 10,
                        maxlength: 12,
                    },
                },
                messages: {
                    cusnm: {
                        required: "Enter Customer name",
                        remote: "Already entered name"
                    },
                    addr: {
                        required: "Enter Customer Address"
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

            $('#app_sup_form').validate({
                rules: {
                    cusnmEdt: {
                        required: true,
                    },
                    addrEdt: {
                        required: true
                    },
                    mobiEdt: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 10,
                        remote: {
                            url: "<?= base_url(); ?>Stock/chk_mobile",
                            type: "post",
                            data: {
                                mobi: function () {
                                    return $("#mobi_edt").val();
                                },
                                spid: function () {
                                    return $("#spid").val();
                                },
                                stat: 1
                            }
                        }
                    },
                    teleEdt: {
                        digits: true,
                        minlength: 10,
                        maxlength: 10,
                        remote: {
                            url: "<?= base_url(); ?>Stock/chk_mobile",
                            type: "post",
                            data: {
                                mobi: function () {
                                    return $("#tele_edt").val();
                                },
                                spid: function () {
                                    return $("#spid").val();
                                },
                                stat: 1
                            }
                        }
                    },
                    emailEdt: {
                        //required: true,
                        email: true
                    },
                    anicEdt: {
                        required: true,
                        minlength: 10,
                        maxlength: 12,
                    },
                },
                messages: {
                    name_edt: {
                        required: "Enter supplier name",
                        remote: "Already entered name"
                    },
                    addr_edt: {
                        required: "Enter supplier address"
                    },
                    mobi_edt: {
                        required: "Enter mobile number",
                        digits: "Only numbers are allowed",
                        minlength: "Please enter 10 digits number",
                        maxlength: "Please enter 10 digits number",
                        remote: "This number is already added"
                    },
                    tele_edt: {
                        digits: "Only numbers are allowed",
                        minlength: "Please enter 10 digits number",
                        maxlength: "Please enter 10 digits number",
                        remote: "This number is already added"
                    },
                    email_edt: {
                        required: "Enter email address",
                        email: "Please enter valid email address"
                    },
                }
            });
            srchCustmer();
        });

        //Add New Supplier
        $('#addBtn').click(function (e) {
            e.preventDefault();
            if ($('#addForm').valid()) {
                $('#addBtn').prop('disabled', true);
                swal({
                    title: "Processing...",
                    text: "Supplier's data saving..",
                    imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                    showConfirmButton: false
                });

                jQuery.ajax({
                    type: "POST",
                    url: "<?= base_url(); ?>user/custmerRegist",
                    data: $("#addForm").serialize(),
                    dataType: 'json',
                    success: function (data) {
                        swal({title: "", text: "Registration Success!", type: "success"},
                            function () {
                                $('#addBtn').prop('disabled', false);
                                clear_Form('addForm');
                                $('#modal-add').modal('hide');
                                srchCustmer();
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

        //Search Suppliers
        function srchCustmer() {
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
                    {className: "text-left", "targets": [2, 3, 4]},
                    {className: "text-center", "targets": [0, 1, 5, 6, 7, 8, 9]},
                    {className: "text-right", "targets": [0]},
                    {className: "text-nowrap", "targets": [2, 3]},
                ],
                "order": [[6, "DESC"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '3%'}, //#
                    {sWidth: '5%'}, //Code
                    {sWidth: '15%'}, //Name
                    {sWidth: '10%'}, //Name
                    {sWidth: '15%'}, //Address
                    {sWidth: '10%'}, //Mobile
                    {sWidth: '10%'}, //Created By
                    {sWidth: '10%'}, //Created date
                    {sWidth: '8%'}, //Status
                    {sWidth: '12%'} //Option
                ],

                "ajax": {
                    url: '<?= base_url(); ?>user/searchCustmer',
                    type: 'post',
                    data: {
                        stat: stat
                    }
                }
            });
        }

        //View Customer
        function viewCust(id, func) {
            swal({
                title: "Loading Data...",
                text: "Supplier's Details",
                imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                showConfirmButton: false
            });

            $('#func').val(func);
            $('#cuid').val(id);

            jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>user/get_customerDet",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (data) {
                    if (func == 'view') {
                        //VIEW MODEL
                        $('#subTitle_edit').html(' - View');
                        $('#edtBtn').css('display', 'none');
                        $("#modal-view").find('.edit_req').css("display", "none");
                        $("#edit_Area").css('display', 'none');
                        $(".view_Area").css('display', 'block');
                        //Make readonly all fields
                        $("#modal-view :input").attr("readonly", true);
                        $("#modal-view").find('.bootstrap-select').addClass("disabled dropup");
                        $("#modal-view").find('.bootstrap-select').children().addClass("disabled dropup");
                        var des = "disabled";
                        $("#bnkDtlEdt").attr("disabled", true);
                        //VIEW MODEL
                    } else if (func == 'edit') {
                        //EDIT MODEL
                        $('#subTitle_edit').html(' - Edit');
                        $('#edtBtn').css('display', 'inline');
                        $('#edtBtn').html('Update');
                        $("#modal-view").find('.edit_req').css("display", "inline");
                        $("#edit_Area").css('display', 'block');
                        $(".view_Area").css('display', 'none');
                        //Remove readonly all fields
                        $("#modal-view :input").attr("readonly", false);
                        $("#modal-view").find('.bootstrap-select').removeClass("disabled dropup");
                        $("#modal-view").find('.bootstrap-select').children().removeClass("disabled dropup");
                        var des = "";
                        $("#bnkDtlEdt").attr("disabled", false);
                        //EDIT MODEL
                    } else if (func == 'app') {
                        //APPROVE MODEL
                        $('#subTitle_edit').html(' - Approve');
                        $('#edtBtn').css('display', 'inline');
                        $('#edtBtn').html('Approve');
                        $("#modal-view").find('.edit_req').css("display", "inline");
                        $("#edit_Area").css('display', 'block');
                        $(".view_Area").css('display', 'none');
                        //Remove readonly all fields
                        $("#modal-view :input").attr("readonly", false);
                        $("#modal-view").find('.bootstrap-select').removeClass("disabled dropup");
                        $("#modal-view").find('.bootstrap-select').children().removeClass("disabled dropup");
                        var des = "";
                        $("#bnkDtlEdt").attr("disabled", false);
                        //APPROVE MODEL
                    }
                    var len = data.length;
                    var spdet = data;
                    if (len > 0) {
                        $('#cusnmEdt').val(spdet[0]['funm']);
                        $('#addrEdt').val(spdet[0]['hoad']);
                        $('#mobiEdt').val(spdet[0]['mobi']);
                        $('#teleEdt').val(spdet[0]['tele']);
                        $('#anicEdt').val(spdet[0]['anic']);
                        $('#emailEdt').val(spdet[0]['emil']);
                        $('#remkEdt').val(spdet[0]['rmks']);
                        //$('#remk_edt').val(spdet[0]['dscr']);

                        if (spdet[0]['stat'] == 0) {
                            var stat = "<label class='label label-warning'>Pending</label>";
                        } else if (spdet[0]['stat'] == 1) {
                            var stat = "<label class='label label-success'>Active</label>";
                        } else if (spdet[0]['stat'] == 2) {
                            var stat = "<label class='label label-danger'>Reject</label>";
                        } else if (spdet[0]['stat'] == 3) {
                            var stat = "<label class='label label-info'>Inactive</label>";
                        } else {
                            var stat = "--";
                        }
                        $('#sup_stat').html(": " + stat);
                        $('#code').html(": " + spdet[0]['spcd']);
                        $('#crby').html(": " + spdet[0]['crnm']);
                        $('#crdt').html(": " + spdet[0]['crdt']);
                        $('#apby').html(": " + ((spdet[0]['apnm'] != null) ? spdet[0]['apnm'] : "--"));
                        $('#apdt').html(": " + ((spdet[0]['apdt'] != null && spdet[0]['apdt'] != "0000-00-00 00:00:00") ? spdet[0]['apdt'] : "--"));
                        $('#rjby').html(": " + ((spdet[0]['rjnm'] != null) ? spdet[0]['rjnm'] : "--"));
                        $('#rjdt').html(": " + ((spdet[0]['rjdt'] != null && spdet[0]['rjdt'] != "0000-00-00 00:00:00") ? spdet[0]['rjdt'] : "--"));
                        $('#mdby').html(": " + ((spdet[0]['mdnm'] != null) ? spdet[0]['mdnm'] : "--"));
                        $('#mddt').html(": " + ((spdet[0]['mddt'] != null && spdet[0]['mddt'] != "0000-00-00 00:00:00") ? spdet[0]['mddt'] : "--"));

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

                if ($('#app_sup_form').valid()) {

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
                                $('#app_sup_btn').prop('disabled', true);
                                if (func == 'edit') {
                                    swal({
                                        title: "Processing...",
                                        text: "Supplier's details updating..",
                                        imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                                        showConfirmButton: false
                                    });

                                    jQuery.ajax({
                                        type: "POST",
                                        url: "<?= base_url(); ?>user/custmUpdate",
                                        data: $("#app_sup_form").serialize(),
                                        dataType: 'json',
                                        success: function (data) {
                                            swal({title: "", text: "Updating Success!", type: "success"},
                                                function () {
                                                    $('#app_sup_btn').prop('disabled', false);
                                                    clear_Form('app_sup_form');
                                                    $('#modal-view').modal('hide');
                                                    srchCustmer();
                                                });
                                        },
                                        error: function (data, textStatus) {
                                            swal({title: "Updating Failed", text: textStatus, type: "error"},
                                                function () {
                                                    location.reload();
                                                });
                                        }
                                    });
                                }  else {
                                    alert('Contact System Admin');
                                }
                            } else {
                                swal("Cancelled", " ", "warning");
                            }
                        });
                }

        });

    </script>
</div>
<!-- END PAGE CONTAINER -->