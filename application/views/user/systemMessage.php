<script type="text/javascript" src="<?= base_url(); ?>assets/js/custom-js/full_width.js"></script>

<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">Message Module</a></li>
        <li class="active">System Message</li>
    </ul>
</div>
<div class="app-heading app-heading-bordered app-heading-page">
    <div class="icon icon-lg">
        <span class="fa fa-user" style="color: #e69c0f;"></span>
    </div>
    <div class="title">
        <h1>System Message</h1>
        <p>Create / Edit / Inactive / Active </p>
    </div>
    <?php
    if ($funcPerm[0]->inst == 1) { ?>
        <div class="pull-right">
            <button class="btn btn-sm btn-info btn-icon-fixed btn-rounded" data-toggle="modal" data-target="#modal-add">
                <span class="fa fa-plus"></span>New Message
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
                <!--<div class="form-group">
                    <label class="col-md-4 col-xs-12 control-label">Type</label>
                    <div class="col-md-8 col-xs-12">
                        <select class="bs-select" name="type" id="type"
                                onchange="chngDiv(this.value)">
                            <option value="0"> All User</option>
                            <option value="1"> User Level</option>
                            <option value="2"> User</option>
                        </select>
                    </div>
                </div>-->
                <div class="form-group">
                    <label class="col-md-4 col-xs-12 control-label">From Date</label>
                    <div class="col-md-8 col-xs-12">
                        <div class='input-group date'>
                            <input type='text' class="form-control dateranger" id="dteRng" name="dteRng"/>
                            <span class="input-group-addon">
                                <span class="fa fa-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!--<div class="form-group">
                    <label class="col-md-4 col-xs-12 control-label">User Level </label>
                    <div class="col-md-8 col-xs-12">
                        <select class="bs-select" name="srcUslv" id="srcUslv"
                                onchange="chckBtn(this.value,'srcUslv'); getusersrh(this.value)">
                            <option value="0"> -- Select User Level --</option>
                            <?php
                /*                            foreach ($uslvlinfo as $uslv) {
                                                echo "<option value='$uslv->id'>$uslv->lvnm</option>";
                                            }
                                            */ ?>
                        </select>
                    </div>
                </div>-->
            </div>

            <div class="col-md-4">
                <!--<div class="form-group">
                    <label class="col-md-4 col-xs-12 control-label">User</label>
                    <div class="col-md-8 col-xs-12" id="srcUsrDiv">
                        <select id="srcUsr" name="srcUsr" class="bs-select" onchange="chckBtn(this.value,'srcUsr')">
                            <option value="0"> -- Select User --</option>
                        </select>
                    </div>
                </div>-->
                <div class="form-group">
                    <button class="btn btn-sm btn-primary btn-rounded  btn-icon-fixed pull-right" onclick="srchUser()">
                        <span class="fa fa-search"></span>Search
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="block">
        <div class="row form-horizontal">
            <div class="table-responsive">
                <table id="userDataTb" class="table dataTable table-striped table-bordered" width="100%">
                    <thead>
                    <tr>
                        <th class="text-left">#</th>
                        <th class="text-left">MESSAGE TYPE</th>
                        <th class="text-left">USER LEVEL</th>
                        <th class="text-left">USER</th>
                        <th class="text-left">TITLE</th>
                        <th class="text-left">MESSAGE</th>
                        <th class="text-left">NOTIFY</th>
                        <th class="text-left">MSG BY</th>
                        <th class="text-left">MSG DATE</th>
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
        <div class="modal-dialog modal-lg" role="document" style="width: 80%">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="icon-cross"></span>
            </button>
            <form id="addForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> New Message
                        </h4>
                    </div>

                    <div class="modal-body">
                        <div class="container">
                            <div class="row form-horizontal">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Type</label>
                                        <div class="col-md-8 col-xs-12">
                                            <select class="bs-select" name="type" id="type"
                                                    onchange="chngDiv(this.value)">
                                                <option value="0"> All User</option>
                                                <option value="1"> User Level</option>
                                                <option value="2"> User</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Title
                                            <span class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input class="form-control" type="text" name="titl" id="titl"
                                                   placeholder="Message Title"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Notification
                                            <span class="fa fa-asterisk req-astrick "></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <label class="switch">
                                                No <input type="checkbox" value="1" id="ntfy" name="ntfy">
                                            </label> Yes
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">User Level </label>
                                        <div class="col-md-8 col-xs-12">
                                            <select class="bs-select" name="srcUslv" id="srcUslv"
                                                    onchange="chckBtn(this.value,'srcUslv'); getusersrh(this.value,'srcUsrDiv','srcUsr')">
                                                <option value="0"> -- Select User Level --</option>
                                                <?php
                                                foreach ($uslvlinfo as $uslv) {
                                                    echo "<option value='$uslv->id'>$uslv->lvnm</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Message
                                            <span class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <textarea class="form-control" rows="5" name="msgs" id="msgs"
                                                      placeholder="Message"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">User</label>
                                        <div class="col-md-8 col-xs-12" id="srcUsrDiv">
                                            <select id="srcUsr" name="srcUsr" class="bs-select"
                                                    onchange="chckBtn(this.value,'srcUsr')">
                                                <option value="0"> -- Select User --</option>
                                            </select>
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
        <div class="modal-dialog modal-lg" role="document" style="width: 80%">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="icon-cross"></span>
            </button>

            <form id="edtform">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> New Message
                            <span class="text-muted" id="subTitle_edit"></span></h4>
                        <input type="hidden" id="func" name="func"/>
                        <input type="hidden" id="auid" name="auid"/>
                    </div>

                    <div class="modal-body">
                        <div class="container">
                            <div class="row form-horizontal">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Type</label>
                                        <div class="col-md-8 col-xs-12">
                                            <select class="bs-select" name="typeEdt" id="typeEdt"
                                                    onchange="chngDivEdt(this.value)">
                                                <option value="0"> All User</option>
                                                <option value="1"> User Level</option>
                                                <option value="2"> User</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Title
                                            <span class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input class="form-control" type="text" name="titlEdt" id="titlEdt"
                                                   placeholder="Message Title"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Notification
                                            <span class="fa fa-asterisk req-astrick "></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <label class="switch">
                                                No <input type="checkbox" value="1" id="ntfyEdt" name="ntfyEdt">
                                            </label> Yes
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">User Level </label>
                                        <div class="col-md-8 col-xs-12">
                                            <select class="bs-select" name="srcUslvEdt" id="srcUslvEdt"
                                                    onchange="chckBtn(this.value,'srcUslvEdt'); getusersrh(this.value,'srcUsrDivEdt','srcUsrEdt')">
                                                <option value="0"> -- Select User Level --</option>
                                                <?php
                                                foreach ($uslvlinfo as $uslv) {
                                                    echo "<option value='$uslv->id'>$uslv->lvnm</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Message
                                            <span class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <textarea class="form-control" rows="5" name="msgsEdt" id="msgsEdt"
                                                      placeholder="Message"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">User</label>
                                        <div class="col-md-8 col-xs-12" id="srcUsrDivEdt">
                                            <select id="srcUsrEdt" name="srcUsrEdt" class="bs-select"
                                                    onchange="chckBtn(this.value,'srcUsrEdt')">
                                                <option value="0"> -- Select User --</option>
                                            </select>
                                        </div>
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
            $('#userDataTb').DataTable({
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
            });

            $('#addForm').validate({
                rules: {
                    type: {
                        required: true,
                        //notEqual: 0
                    },
                    titl: {
                        required: true
                    },
                    srcUslv: {
                        required: true,
                        notEqual: 0
                    },
                    srcUsr: {
                        required: true,
                        notEqual: 0
                    },
                    msgs: {
                        required: true,
                    },
                },
                messages: {
                    type: {
                        required: "Select Message Type ",
                        notEqual: "Select Message Type"
                    },
                    srcUslv: {
                        required: "Select User Level",
                        notEqual: "Select User Level"
                    },
                    titl: {
                        required: "Enter Message title",
                    },
                    srcUsr: {
                        required: "Select User ",
                    },
                    msgs: {
                        required: "Enter Message",
                    },
                }
            });

            $('#edtform').validate({
                rules: {
                    typeEdt: {
                        required: true,
                        //notEqual: 0
                    },
                    titlEdt: {
                        required: true
                    },
                    srcUslvEdt: {
                        required: true,
                        notEqual: 0
                    },
                    srcUsrEdt: {
                        required: true,
                        notEqual: 0
                    },
                    msgsEdt: {
                        required: true,
                    },
                },
                messages: {
                    typeEdt: {
                        required: "Select Message Type ",
                        notEqual: "Select Message Type"
                    },
                    srcUslvEdt: {
                        required: "Select User Level",
                        notEqual: "Select User Level"
                    },
                    titlEdt: {
                        required: "Enter Message title",
                    },
                    srcUsrEdt: {
                        required: "Select User ",
                    },
                    msgsEdt: {
                        required: "Enter Message",
                    },
                }
            });

            //srchUser();

            disableSelct('srcUslv');
            disableSelct('srcUsr');
        });

        // type div change
        function chngDiv(val) {
            if (val == 1) {
                enableSelct('srcUslv');
                disableSelct('srcUsr');
            } else if (val == 2) {
                enableSelct('srcUslv');
                enableSelct('srcUsr');
            } else {
                disableSelct('srcUslv');
                disableSelct('srcUsr');
            }
        }

        // type div change edit
        function chngDivEdt(val) {
            if (val == 1) {
                enableSelct('srcUslvEdt');
                disableSelct('srcUsrEdt');
            } else if (val == 2) {
                enableSelct('srcUslvEdt');
                enableSelct('srcUsrEdt');
            } else {
                disableSelct('srcUslvEdt');
                disableSelct('srcUsrEdt');
            }
        }

        //load search users
        function getusersrh(uslv, div, htid) {
            //var user = document.getElementById('srlevel').value;
            $.ajax({
                url: '<?= base_url(); ?>user/getusersrh',
                type: 'post',
                data: {
                    uslv: uslv,
                },
                dataType: 'json',
                success: function (response) {
                    var len = response.length;
                    var child1 = $('#' + div).children();
                    var child2 = child1.find('div').children();
                    child2.empty();

                    if (len != 0) {
                        $('#' + htid).empty();
                        $('#' + htid).append("<option value='0'>-- Select A User --</option>");
                        child2.append("<li data-original-index=\"0\"><a tabindex=\"0\" class=\"\" data-tokens=\"null\" role=\"option\" aria-disabled=\"false\" aria-selected=\"true\"><span class=\"text\">-- Select A User --\n" +
                            "</span><span class=\" fa fa-check check-mark\"></span></a></li>");
                        for (var i = 0; i < len; i++) {
                            var id = response[i]['auid'];
                            var name = response[i]['usnm'];
                            var $el = $('#' + htid);
                            $el.append($("<option  > Select User</option>")
                                .attr("value", id).text(name));

                            child2.append("<li data-original-index=\"" + (i + 1) + "\"><a tabindex=\"0\" class=\"\" data-tokens=\"null\" role=\"option\" aria-disabled=\"false\" aria-selected=\"true\"><span class=\"text\">" + name + "\n" +
                                "</span><span class=\" fa fa-check check-mark\"></span></a></li>");
                        }
                    } else {
                        $('#' + htid).empty();
                        $('#' + htid).append("<option value=''>No User</option>");

                        child2.append("<li data-original-index=\"0\" class=\"\"><a tabindex=\"0\" class=\"\" data-tokens=\"null\" role=\"option\" aria-disabled=\"false\" aria-selected=\"false\"><span class=\"text\">-- No User --</span><span class=\" fa fa-check check-mark\"></span></a></li>");
                    }
                    default_Selector(child1.find('div'));
                },
            });
        }

        //Search
        function srchUser() {
            var dteRng = $('#dteRng').val();

            $('#userDataTb').DataTable().clear();
            $('#userDataTb').DataTable({
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
                    {className: "text-left", "targets": [1, 2, 3, 5]},
                    {className: "text-center", "targets": [0, 6, 7, 8, 9]},
                    {className: "text-right", "targets": [0]},
                    {className: "text-nowrap", "targets": [5]},
                ],
                "order": [[8, "DESC"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '3%'}, //#
                    {sWidth: '10%'}, //Code
                    {sWidth: '10%'}, //Name
                    {sWidth: '10%'}, //Address
                    {sWidth: '10%'}, //Mobile
                    {sWidth: '15%'}, //Created By
                    {sWidth: '5%'}, //Created date
                    {sWidth: '10%'}, //Status
                    {sWidth: '10%'}, //Status
                    {sWidth: '5%'} //Option
                ],
                "ajax": {
                    url: '<?= base_url(); ?>user/srchSysMsg',
                    type: 'post',
                    data: {
                        dteRng: dteRng,
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
                    text: "Data saving..",
                    imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                    showConfirmButton: false
                });

                jQuery.ajax({
                    type: "POST",
                    url: "<?= base_url(); ?>user/addNewmessg",
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
        function edtModule(id, func) {
            swal({
                title: "Loading Data...",
                text: "Details Loading",
                imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                showConfirmButton: false
            });

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
            //EDIT MODEL

            $('#func').val(func);
            $('#auid').val(id);

            jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>user/getSysMsgDet",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (data) {
                    var len = data.length;
                    if (len > 0) {
                        chngDivEdt(data[0]['cmtp']);

                        set_select('typeEdt', data[0]['cmtp']);
                        set_select('srcUslvEdt', data[0]['uslv']);

                        //getusersrh(data[0]['uslv']);
                        getusersrh(data[0]['uslv'], 'srcUsrDivEdt', 'srcUsrEdt');
                        set_select('srcUsrEdt', data[0]['mgus']);

                        $('#titlEdt').val(data[0]['mdle']);
                        $('#msgsEdt').val(data[0]['chng']);

                        if (data[0]['swnt'] == 1) {
                            $("#ntfyEdt").prop("checked", true);
                        } else {
                            $("#ntfyEdt").prop("checked", false);
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

                            swal({
                                title: "Processing...",
                                text: "User's details updating..",
                                imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                                showConfirmButton: false
                            });

                            jQuery.ajax({
                                type: "POST",
                                url: "<?= base_url(); ?>user/sysMsgEdit",
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

                        } else {
                            swal("Cancelled", " ", "warning");
                        }
                    });
            }
        });

    </script>
</div>
<!-- END PAGE CONTAINER -->
