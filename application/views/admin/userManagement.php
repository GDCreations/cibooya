<script type="text/javascript" src="<?= base_url(); ?>assets/js/custom-js/full_width.js"></script>

<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">System Component</a></li>
        <li class="active">User Management</li>
    </ul>
</div>
<div class="app-heading app-heading-bordered app-heading-page">
    <div class="icon icon-lg">
        <span class="fa fa-user" style="color: #e69c0f;"></span>
    </div>
    <div class="title">
        <h1>User Management</h1>
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
                    <label class="col-md-4 col-xs-12 control-label">Branch</label>
                    <div class="col-md-8 col-xs-12">
                        <select class="bs-select" name="brch" id="brch"
                                onchange="chckBtn(this.value,'brch')">
                            <?php
                            foreach ($branchinfo as $branch) {
                                echo "<option value='$branch[brch_id]'>$branch[brch_name]</option>";
                            }
                            ?>
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
                            foreach ($uslvlinfo as $uslv) {
                                echo "<option value='$uslv->id]'>$uslv->lvnm</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-md-4 col-xs-12 control-label">Status</label>
                    <div class="col-md-8 col-xs-12">
                        <select id="stat" name="stat" class="bs-select">
                            <option value="all">All</option>
                            <!--<option value="0">Pending</option>-->
                            <option value="1">Active</option>
                            <option value="2">Tmp Disable</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
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
                        <th class="text-left">BRNC</th>
                        <th class="text-left">USERNAME</th>
                        <th class="text-left">NAME</th>
                        <th class="text-left">MOBILE</th>
                        <th class="text-left">NIC</th>
                        <th class="text-left">LEVEL</th>
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
        <div class="modal-dialog modal-lg" role="document" style="width: 80%">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="icon-cross"></span>
            </button>
            <form id="addForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> User Creation
                        </h4>
                    </div>

                    <div class="modal-body">
                        <div class="container">
                            <div class="row form-horizontal">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Branch <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <select class="bs-select" name="brchNw" id="brchNw"
                                                    onchange="chckBtn(this.value,'brchNw')">
                                                <?php
                                                foreach ($branchinfo as $branch) {
                                                    if ($branch['brch_id'] == 'all') {
                                                    } else {
                                                        echo "<option value='$branch[brch_id]'>$branch[brch_name]</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">First Name <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input class="form-control" type="text" name="frnm" id="frnm"
                                                   placeholder="First Name"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">User Name <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input class="form-control" type="text" name="usnm" id="usnm"
                                                   placeholder="User Name"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">NIC <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input class="form-control" type="text" name="unic" id="unic"
                                                   onkeyup="checkNic(this.value,'unic','addBtn','udob','ugnd','ugndDiv')"
                                                   placeholder="NIC"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Contact <span
                                                    class="fa fa-asterisk req-astrick"
                                            ></span></label>
                                        <div class="col-md-4 col-xs-12">
                                            <input class="form-control" type="text" name="mobi" id="mobi"
                                                   placeholder="Mobile"/>
                                        </div>
                                        <div class="col-md-4 col-xs-12">
                                            <input class="form-control" type="text" name="tele" id="tele"
                                                   placeholder="Land Tele."/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">User Level <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <select class="bs-select" name="uslvNw" id="uslvNw"
                                                    onchange="chckBtn(this.value,'uslvNw')">
                                                <option value="0"> -- Select Level --</option>
                                                <?php
                                                foreach ($uslvlinfo as $uslv) {
                                                    echo "<option value='$uslv->id]'>$uslv->lvnm</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Last Name <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input class="form-control" type="text" name="lsnm" id="lsnm"
                                                   placeholder="Last Name"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Email <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input class="form-control" type="email" name="emil"
                                                   id="emil" placeholder="Email"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">DOB / Gender <span
                                                    class="fa fa-asterisk req-astrick"
                                            ></span></label>
                                        <div class="col-md-4 col-xs-12">
                                            <input class="form-control datetimepicker" type="text" name="udob" id="udob"
                                                   placeholder="DOB" readonly/>
                                        </div>
                                        <div class="col-md-4 col-xs-12" id="ugndDiv">
                                            <select class="bs-select" name="ugnd" id="ugnd"
                                                    onchange="chckBtn(this.value,'ugnd')" readonly>
                                                <option value='0'>-- Select --</option>
                                                <option value='1'> Male</option>
                                                <option value='2'> Female</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Permission Type
                                            <span class="fa fa-asterisk req-astrick "></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <label class="switch">
                                                Default <input type="checkbox" value="1" id="prmTp" name="prmTp">
                                            </label> Manual
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="pull-left">
                            <span class="fa fa-hand-o-right"></span>
                            <label style="color: red"> <span class="fa fa-asterisk req-astrick"></span> Required Fields </label>
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
                        <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> User Creation
                            <span class="text-muted" id="subTitle_edit"></span></h4>
                        <input type="hidden" id="func" name="func"/>
                        <input type="hidden" id="auid" name="auid"/>
                    </div>

                    <div class="modal-body">
                        <div class="container">
                            <div class="row form-horizontal">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Branch <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <select class="bs-select" name="brchNwEdt" id="brchNwEdt"
                                                    onchange="chckBtn(this.value,'brchNwEdt')">
                                                <?php
                                                foreach ($branchinfo as $branch) {
                                                    if ($branch['brch_id'] == 'all') {
                                                    } else {
                                                        echo "<option value='$branch[brch_id]'>$branch[brch_name]</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">First Name <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input class="form-control" type="text" name="frnmEdt" id="frnmEdt"
                                                   placeholder="First Name"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">User Name <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input class="form-control" type="text" name="usnmEdt" id="usnmEdt"
                                                   placeholder="User Name"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">NIC <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input class="form-control" type="text" name="unicEdt" id="unicEdt"
                                                   onkeyup="checkNic(this.value,'unicEdt','edtBtn','udobEdt','ugndEdt','ugndDivEdt')"
                                                   placeholder="NIC"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Contact <span
                                                    class="fa fa-asterisk req-astrick"
                                            ></span></label>
                                        <div class="col-md-4 col-xs-12">
                                            <input class="form-control" type="text" name="mobiEdt" id="mobiEdt"
                                                   placeholder="Mobile"/>
                                        </div>
                                        <div class="col-md-4 col-xs-12">
                                            <input class="form-control" type="text" name="teleEdt" id="teleEdt"
                                                   placeholder="Land Tele."/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">User Level <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <select class="bs-select" name="uslvNwEdt" id="uslvNwEdt"
                                                    onchange="chckBtn(this.value,'uslvNwEdt')">
                                                <option value="0"> -- Select Level --</option>
                                                <?php
                                                foreach ($uslvlinfo as $uslv) {
                                                    echo "<option value='$uslv->id'>$uslv->lvnm</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Last Name <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input class="form-control" type="text" name="lsnmEdt" id="lsnmEdt"
                                                   placeholder="Last Name"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Email <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input class="form-control" type="email" name="emilEdt"
                                                   id="emilEdt" placeholder="Email"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">DOB / Gender <span
                                                    class="fa fa-asterisk req-astrick"
                                            ></span></label>
                                        <div class="col-md-4 col-xs-12">
                                            <input class="form-control datetimepicker" type="text" name="udobEdt"
                                                   id="udobEdt"
                                                   placeholder="DOB" readonly/>
                                        </div>
                                        <div class="col-md-4 col-xs-12" id="ugndDivEdt">
                                            <select class="bs-select" name="ugndEdt" id="ugndEdt"
                                                    onchange="chckBtn(this.value,'ugnd')" readonly>
                                                <option value='0'>-- Select --</option>
                                                <option value='1'> Male</option>
                                                <option value='2'> Female</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Permission Type <span
                                                    class="fa fa-asterisk req-astrick "
                                            ></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <label class="switch">
                                                Default <input type="checkbox" value="1" id="prmTpEdt" name="prmTpEdt">
                                            </label> Manual
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
                    brchNw: {
                        required: true,
                        notEqual: 0
                    },
                    frnm: {
                        required: true
                    },
                    emil: {
                        required: true,
                        email: true
                    },
                    usnm: {
                        required: true,
                        remote: {
                            url: "<?= base_url(); ?>admin/chkUserName",
                            type: "post",
                            data: {
                                usnm: function () {
                                    return $("#usnm").val();
                                },
                                stat: 0
                            }
                        }
                    },
                    unic: {
                        required: true,
                        minlength: 10,
                        maxlength: 12,
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
                    uslvNw: {
                        required: true,
                        notEqual: 0
                    },
                    lsnm: {
                        required: true,
                    },
                    udob: {
                        required: true,
                    },
                    ugnd: {
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
                    usnm: {
                        required: "Enter User Name",
                        remote: "Already entered User Name",
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
            //srchUser();
        });

        //Search
        function srchUser() {
            var brch = $('#brch').val();
            var uslv = $('#uslv').val();
            var stat = $('#stat').val();

            if (brch == '0') {
                $('#brch').parent().css('border', '1px solid red');
                $('#brch').parent().css('border-radius', '4px');
            } else {
                $('#brch').parent().css('border', '0px');

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
                        {className: "text-left", "targets": [2, 3, 5, 6]},
                        {className: "text-center", "targets": [0, 1, 4, 7, 8]},
                        {className: "text-right", "targets": [0]},
                        {className: "text-nowrap", "targets": [2, 3]},
                    ],
                    "order": [[6, "DESC"]], //ASC  desc
                    "aoColumns": [
                        {sWidth: '3%'}, //#
                        {sWidth: '5%'}, //Code
                        {sWidth: '10%'}, //Name
                        {sWidth: '15%'}, //Address
                        {sWidth: '10%'}, //Mobile
                        {sWidth: '10%'}, //Created By
                        {sWidth: '10%'}, //Created date
                        {sWidth: '10%'}, //Status
                        {sWidth: '15%'} //Option
                    ],
                    "ajax": {
                        url: '<?= base_url(); ?>admin/searchUser',
                        type: 'post',
                        data: {
                            brch: brch,
                            uslv: uslv,
                            stat: stat,
                        }
                    }
                });
            }
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

        //PASSWORD RESET
        function resetPass(id) {
            swal({
                    title: "Are you sure to Password Reset ?",
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
                            url: "<?= base_url(); ?>admin/userPassReset",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (data) {
                                swal({title: "", text: "Successful Password Reset!", type: "success"},
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
