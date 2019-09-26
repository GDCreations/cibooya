<script type="text/javascript" src="<?= base_url(); ?>assets/js/custom-js/full_width.js"></script>
<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">Advance Settings</a></li>
        <li class="active">Permission Management</li>
    </ul>
</div>
<div class="app-heading app-heading-bordered app-heading-page">
    <div class="icon icon-lg">
        <span class="fa fa-check-square-o" style="color: #e69c0f;"></span>
    </div>
    <div class="title">
        <h1>Permission Management</h1>
        <p>Permission Enable / Disable / Access Pages</p>
    </div>
</div>
<!-- END PAGE HEADING -->

<!-- START PAGE CONTAINER -->
<div class="container">
    <div class="panel panel-default block">
        <div class="row form-horizontal">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-md-5 col-xs-12 control-label">Permission Type</label>
                    <div class="col-md-7 col-xs-12">
                        <select id="prtp" name="prtp" onchange="chngType(this.value); chckBtn(this.value,'prtp')"
                                class="bs-select">
                            <option value="0">-- Select Type --</option>
                            <option value="1">Default Permission</option>
                            <option value="2">Manual Permission</option>
                        </select>
                    </div>
                </div>

                <div class="form-group" id="brn" style="display: none">
                    <label class="col-md-5 col-xs-12 control-label">Branch</label>
                    <div class="col-md-7 col-xs-12">
                        <select class="bs-select" name="brch" id="brch"
                                onchange="getUser(this.value,uslv.value);chckBtn(this.value,'brch')">
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
                    <label class="col-md-4 col-xs-12 control-label">User Level</label>
                    <div class="col-md-8 col-xs-12">
                        <select id="uslv" name="uslv" onchange="chckBtn(this.value,'uslv');" class="bs-select">
                            <option value="0">-- Select User Level --</option>
                            <?php
                            foreach ($uslvlinfo as $lv) {
                                echo "<option value='$lv->id'>$lv->lvnm</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group" id="usr" style="display: none">
                    <label class="col-md-4 col-xs-12 control-label">User</label>
                    <div class="col-md-8 col-xs-12" id="user_cont">
                        <select class="bs-select" name="user" id="user"
                                onchange="chckBtn(this.value,'user')">
                            <option value="0">-- Select User --</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <button class="btn btn-sm btn-primary btn-rounded btn-icon-fixed"
                            onclick="srchPerm()"><span class="fa fa-search"></span> Search
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default block" id="taba" style="display: none">
        <div>
            <ul class="nav nav-tabs nav-pills">
                <li class="active"><a href="#tabs-1" role="tab" data-toggle="tab">User
                        Permission</a>
                </li>
                <li><a href="#tabs-2" role="tab" data-toggle="tab">Master
                        Permission</a>
                </li>
                <li><a href="#tabs-3" role="tab" data-toggle="tab"> Advance Permission</a></li>
                <li><a href="#tabs-4" role="tab" data-toggle="tab"> Special Permission </a></li>
                <li><a href="#tabs-5" role="tab" data-toggle="tab"> Module Permission </a></li>
                <li id="tb6"><a href="#tabs-6" role="tab" id="ttb6"> Page Access </a></li>
            </ul>
            <div class="tab-content tab-content">
                <div class="tab-pane active" id="tabs-1">
                    <div class="col-md-12">
                        <button class="btn btn-info btn-sm btn-rounded btn-icon-fixed pull-right"
                                data-toggle="modal"
                                data-target="#modalAdd" onclick="mdulAdd(0)">
                            <span class="fa fa-plus"></span> Add Page
                        </button>
                    </div>
                    <div class="col-md-12">
                        <form class="form-horizontal" id="edt_prmi" name="edt_prmi" action=""
                              method="post">
                            <div class="table-responsive">
                                <table class="table table-head-custom datatable table-bordered"
                                       id="dataTbPer" width="100%">
                                    <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">MENU / MODULE</th>
                                        <th class="text-center">MENU TYPE</th>
                                        <th class="text-center">VIEW</th>
                                        <th class="text-center">ADD</th>
                                        <th class="text-center">EDIT</th>
                                        <th class="text-center">DELETE</th>
                                        <th class="text-center">APPROVAL</th>
                                        <th class="text-center" style="color: red">De Activate</th>
                                        <th class="text-center" style="color: dodgerblue">Re Activate
                                        </th>
                                        <th class="text-center">ALL</th>
                                        <th class="text-center">PAGE ACCESS</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <input type="hidden" name="len" id="len">
                            <button type="button" id="edt_prmi_btn"
                                    class="btn btn-warning btn-sm btn-rounded pull-right">Submit
                            </button>
                        </form>
                    </div>
                </div>
                <div class="tab-pane" id="tabs-2">
                    <div class="col-md-12">
                        <button class="btn btn-info btn-sm btn-rounded btn-icon-fixed pull-right"
                                data-toggle="modal"
                                data-target="#modalAdd" onclick="mdulAdd(1)">
                            <span class="fa fa-plus"></span> Add Page
                        </button>
                    </div>
                    <div class="col-md-12">
                        <form class="form-horizontal" id="edt_prmi_ms" name="edt_prmi_ms" action=""
                              method="post">
                            <div class="table-responsive">
                                <table class="table table-head-custom datatable table-bordered"
                                       id="dataTbPerMs" width="100%">
                                    <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">MENU / MODULE</th>
                                        <th class="text-center">MENU TYPE</th>
                                        <th class="text-center">VIEW</th>
                                        <th class="text-center">ADD</th>
                                        <th class="text-center">EDIT</th>
                                        <th class="text-center">DELETE</th>
                                        <th class="text-center">APPROVAL</th>
                                        <th class="text-center" style="color: red">De Activate</th>
                                        <th class="text-center" style="color: dodgerblue">Re Activate
                                        </th>
                                        <th class="text-center">ALL</th>
                                        <th class="text-center">PAGE ACCESS</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <input type="hidden" name="lenms" id="lenms">
                            <button type="button" id="edt_prmi_ms_btn"
                                    class="btn btn-warning btn-sm btn-rounded pull-right">Submit
                            </button>
                        </form>
                    </div>
                </div>
                <div class="tab-pane" id="tabs-3">
                    <form class="form-horizontal" id="advedt_prmi" name="advedt_prmi" action=""
                          method="post">
                        <div class="table-responsive">
                            <table class="table table-bordered table-head-custom table-striped table-actions"
                                   id="dataTbPerAdv">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">MENU</th>
                                    <th class="text-center">MENU TYPE</th>
                                    <th class="text-center">PRINT</th>
                                    <th class="text-center">REPRINT</th>
                                    <th class="text-center">ALL</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <input type="hidden" name="lensp" id="lensp">
                        <button type="button" id="edt_prmi_updt_btn"
                                class="btn btn-warning btn-sm btn-rounded pull-right">Submit
                        </button>
                    </form>
                </div>
                <div class="tab-pane" id="tabs-4">
                    <form class="form-horizontal" id="specil_prmi" name="specil_prmi" action=""
                          method="post">
                        <div class="table-responsive">
                            <table class="table table-bordered table-head-custom table-striped table-actions"
                                   id="dataTbPerSpcil">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">USER LEVEL</th>
                                    <th class="text-center">MASTER SETTING</th>
                                    <th class="text-center">ALL BRANCH</th>
                                    <th class="text-center">SPEC BRANCH</th>
                                    <th class="text-center">ALL OFFICER</th>
                                    <th class="text-center">ALL CENTER</th>
                                    <th class="text-center">TP SPECIAL</th>
                                    <th class="text-center">ALL</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <br>
                        <div class="table-responsive" id="perBrn" style="display: none">
                            <table class="table table-bordered table-striped table-actions"
                                   id="brnchTb">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">CODE</th>
                                    <th class="text-center">NAME</th>
                                    <th class="text-center">OPTIONAL</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <input type="hidden" name="lenMst" id="lenMst" title="lenMst">
                        <input type="hidden" name="type" id="type" title="type">
                        <input type="hidden" name="adprtp" id="adprtp" title="adprtp">
                        <input type="hidden" name="adprus" id="adprus" title="adprus">
                        <input type="hidden" name="brnLn" id="brnLn" title="brnLn">
                        <button type="button" id="specil_prmi_updt_btn"
                                class="btn btn-warning btn-sm btn-rounded pull-right">Submit
                        </button>
                    </form>
                </div>
                <div class="tab-pane" id="tabs-5">
                    <form class="form-horizontal" id="mdule_prmi" name="mdule_prmi" action=""
                          method="post">
                        <div class="table-responsive">
                            <table class="table table-bordered table-head-custom table-striped table-actions"
                                   id="dataTbPerMdul">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">USER LEVEL</th>
                                    <th class="text-center">USER MODULE</th>
                                    <th class="text-center">ADMIN MODULE</th>
                                    <th class="text-center">STOCK MODULE</th>
                                    <th class="text-center">ALL</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <input type="hidden" name="lenMst2" id="lenMst2">
                        <input type="hidden" name="type2" id="type2">
                        <input type="hidden" name="adprtp2" id="adprtp2">
                        <input type="hidden" name="adprus2" id="adprus2">
                        <button type="button" id="mdule_prmi_updt_btn"
                                class="btn btn-warning btn-sm btn-rounded pull-right">Submit
                        </button>
                    </form>
                </div>
                <div class="tab-pane" id="tabs-6">
                    <form class="form-horizontal" id="pgAccss" name="pgAccss" action=""
                          method="post">
                        <div class="table-responsive">
                            <table class="table datatable table-head-custom table-bordered table-actions"
                                   id="dataTbPgacs" width="100%">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">MENU / MODULE</th>
                                    <th class="text-center">MENU TYPE</th>
                                    <th class="text-center">PAGE ACCESS</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <input type="hidden" name="len5" id="len5">
                        <button type="button" id="pgAccss_updt_btn"
                                class="btn btn-warning btn-sm btn-rounded pull-right">Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Model -->
    <div class="modal fade" id="modalAdd" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="modal-default-header">
        <div class="modal-dialog modal-lg" role="document">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"
                                                                                              class="icon-cross"></span>
            </button>
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> Add New Page</h4>
                </div>
                <form class="form-horizontal" id="mdul_add" name="mdul_add"
                      action="" method="post">
                    <div class="modal-body">
                        <div class="container">
                            <div class="table-responsive">
                                <table class="table datatable table-bordered table-head-custom table-striped table-actions" width="100%"
                                       id="dataTbmdl">
                                    <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th class="text-center">MODULE PAGE</th>
                                        <th class="text-center">MODULE TYPE</th>
                                        <th class="text-center">ADD</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <input type="hidden" name="mdlen" id="mdlen">
                            <input type="hidden" name="uslvl" id="uslvl">
                            <input type="hidden" name="usid" id="usid">
                            <input type="hidden" name="ptp" id="ptp">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                        <button type="button" id="add_new_page" class="btn btn-warning btn-sm btn-rounded">
                            Add
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Add Model -->

    <script type="text/javascript">

        $().ready(function () {
            $('#dataTbPer').DataTable({
                destroy: true,
                searching: false,
                bPaginate: false,
                "ordering": false,
            });
            $('#dataTbPerMs').DataTable({
                destroy: true,
                searching: false,
                bPaginate: false,
                "ordering": false,
            });
            $('#dataTbmdl').DataTable({
                destroy: true,
                searching: false,
                bPaginate: false,
                "ordering": false,
            });
            $('#dataTbPerAdv').DataTable({
                destroy: true,
                searching: false,
                bPaginate: false,
                "ordering": false,
            });
            $('#dataTbPerSpcil').DataTable({
                destroy: true,
                searching: false,
                bPaginate: false,
                "ordering": false,
            });
            $('#dataTbPerMdul').DataTable({
                destroy: true,
                searching: false,
                bPaginate: false,
                "ordering": false,
            });
            $('#dataTbPgacs').DataTable({
                destroy: true,
                searching: false,
                bPaginate: false,
                "ordering": false,
            });
            $('#brnchTb').DataTable({
                destroy: true,
                searching: false,
                bPaginate: false,
                "ordering": false,
            });

            var rol = <?= $_SESSION['role'] ?>;
            if (rol == 1) {
                $('#tb6').attr('class', '');
                document.getElementById('ttb6').setAttribute('data-toggle', 'tab');
            } else {
                $('#tb6').attr('class', 'disabled');
                document.getElementById('ttb6').setAttribute('data-toggle', '');
            }
        });

        function chngType(tp) {
            if (tp == 2) {
                document.getElementById('usr').style.display = "block";
                document.getElementById('brn').style.display = "block";
            } else {
                document.getElementById('usr').style.display = "none";
                document.getElementById('brn').style.display = "none";
            }
        }

        function getUser(brid, uslv) {
            $.ajax({
                url: '<?= base_url(); ?>admin/getUser',
                type: 'post',
                data: {
                    brid: brid,
                    uslv: uslv
                },
                dataType: 'json',
                success: function (response) {
                    var len = response.length;
                    var child1 = $('#user_cont').children();
                    var child2 = child1.find('div').children();
                    child2.empty();
                    if (len != 0) {
                        $('#user').empty();
                        $('#user').append("<option value='0'>-- Select User --</option>");
                        child2.append("<li data-original-index=\"0\"><a tabindex=\"0\" class=\"\" data-tokens=\"null\" role=\"option\" aria-disabled=\"false\" aria-selected=\"true\"><span class=\"text\">-- Select User --\n" +
                            "</span><span class=\" fa fa-check check-mark\"></span></a></li>");
                        for (var i = 0; i < len; i++) {
                            var id = response[i]['auid'];
                            var name = response[i]['fnme'] + ' ' + response[i]['lnme'];
                            var $el = $('#user');
                            $el.append($("<option></option>")
                                .attr("value", id).text(name));

                            child2.append("<li data-original-index=\"" + (i + 1) + "\"><a tabindex=\"0\" class=\"\" data-tokens=\"null\" role=\"option\" aria-disabled=\"false\" aria-selected=\"true\"><span class=\"text\">" + name + "\n" +
                                "</span><span class=\" fa fa-check check-mark\"></span></a></li>");
                        }
                    } else {
                        $('#user').empty();
                        $('#user').append("<option value='no'>-- No User --</option>");
                        child2.append("<li data-original-index=\"0\" class=\"\"><a tabindex=\"0\" class=\"\" data-tokens=\"null\" role=\"option\" aria-disabled=\"false\" aria-selected=\"false\"><span class=\"text\">-- No User --</span><span class=\" fa fa-check check-mark\"></span></a></li>");
                    }
                    default_Selector(child1.find('div'));
                }
            });
        }

        function srchPerm() {
            var prtp = document.getElementById('prtp').value;
            var uslv = document.getElementById('uslv').value;
            var brch = document.getElementById('brch').value;
            var user = document.getElementById('user').value;

            if (prtp == 0) {
                $('#prtp').parent().css('border', '1px solid red');
                $('#prtp').parent().css('border-radius', '4px');
            }
            if (uslv == 0) {
                $('#uslv').parent().css('border', '1px solid red');
                $('#uslv').parent().css('border-radius', '4px');
            }

            if (brch == 0) {
                $('#brch').parent().css('border', '1px solid red');
                $('#brch').parent().css('border-radius', '4px');
            }
            if (user == 0) {
                $('#user').parent().css('border', '1px solid red');
                $('#user').parent().css('border-radius', '4px');
            }
            if (prtp == 1) {
                if (uslv != 0) {
                    srchPermOrgin();
                }
            } else if (prtp == 2) {
                if (uslv != 0 && brch != 0 && user != 0) {
                    srchPermOrgin();
                }
            }
        }

        function srchPermOrgin() {
            $('#taba').css('display', 'block');
            $('#dataTbPer').DataTable().clear();
            $('#dataTbPerAdv').DataTable().clear();
            $('#dataTbPerSpcil').DataTable().clear();
            $('#dataTbPerMdul').DataTable().clear();
            $('#dataTbPgacs').DataTable().clear();

            var prtp = document.getElementById('prtp').value;   // PERMISION TYPE
            var uslv = document.getElementById('uslv').value;   // USER LEVEL
            var brch = document.getElementById('brch').value;   // BRANCH ID
            var user2 = document.getElementById('user').value;   // USER ID


            // SEARCH PERMISION
            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>admin/srchPermis",
                data: {
                    prtp: prtp,
                    uslv: uslv,
                    brch: brch,
                    user: user2
                },
                dataType: 'json',
                success: function (response) {
                    var len = response.length;
                    document.getElementById('taba').style.display = "block";

                    document.getElementById("adprtp").value = prtp;
                    document.getElementById("adprus").value = user2;

                    // Basic setting
                    $('#dataTbPer').DataTable().clear();
                    var t = $('#dataTbPer').DataTable({
                        destroy: true,
                        searching: false,
                        bPaginate: false,
                        "ordering": false,
                        "columnDefs": [
                            {className: "text-left", "targets": [1]},
                            {className: "text-center", "targets": [0, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]},
                            {className: "text-right", "targets": [0]},
                            {className: "text-nowrap", "targets": [1]}
                        ],
                        "aoColumns": [
                            {sWidth: '3%'},
                            {sWidth: '30%'},
                            {sWidth: '8%'},
                            {sWidth: '5%'},
                            {sWidth: '5%'},
                            {sWidth: '5%'},
                            {sWidth: '5%'},
                            {sWidth: '5%'},
                            {sWidth: '5%'},
                            {sWidth: '5%'},
                            {sWidth: '5%'},
                            {sWidth: '5%'}
                        ],
                        "footerCallback": function (row, data, start, end, display) {
                            var api = this.api(), data;
                            document.getElementById("len").value = display.length;
                        },

                    });
                    for (var i = 0; i < len; i++) {
                        var hid = "<label class=''><input type='hidden' name='prid[" + i + "]'  value=" + response[i]['prid'] + " /> </label>";

                        if (response[i]['mntp'] == 1) {
                            var mntp = "<label class='label label-success'> Master </label>";
                        } else {
                            var mntp = "<label class='label label-info'> User </label>";
                        }

                        if (response[i]['view'] == 1) {
                            var viw = "<label class=''><input type='checkbox' name='view[" + i + "]' title='View' value=" + response[i]['view'] + " id='checkbox-1'  class='icheckbox " + i + "' checked='checked'/><span></span></label>";
                        } else {
                            var viw = "<label class=''><input type='checkbox' name='view[" + i + "]' title='View' value='1' id='checkbox-1'  class='icheckbox " + i + "' /> </label>";
                        }
                        if (response[i]['inst'] == 1) {
                            var inst = "<label class=''><input type='checkbox' name='inst[" + i + "]' title='Add' value=" + response[i]['inst'] + " id='checkbox-1'  class='icheckbox " + i + "' checked='checked'/> </label>";
                        } else {
                            var inst = "<label class=''><input type='checkbox' name='inst[" + i + "]' title='Add' value='1' id='checkbox-1'  class='icheckbox " + i + "' /> </label>";
                        }
                        if (response[i]['edit'] == 1) {
                            var edit = "<label class=''><input type='checkbox' name='edit[" + i + "]' title='Edit' value=" + response[i]['edit'] + " id='checkbox-1'  class='icheckbox " + i + "' checked='checked'/> </label>";
                        } else {
                            var edit = "<label class=''><input type='checkbox' name='edit[" + i + "]' title='Edit' value='1' id='checkbox-1'  class='icheckbox " + i + "' /> </label>";
                        }
                        if (response[i]['rejt'] == 1) {
                            var rejt = "<label class=''><input type='checkbox' name='rejt[" + i + "]' title='Reject/Delete' value=" + response[i]['rejt'] + " id='checkbox-1'  class='icheckbox " + i + "' checked='checked'/> </label>";
                        } else {
                            var rejt = "<label class=''><input type='checkbox' name='rejt[" + i + "]' title='Reject/Delete' value='1' id='checkbox-1'  class='icheckbox " + i + "' /> </label>";
                        }
                        if (response[i]['apvl'] == 1) {
                            var apvl = "<label class=''><input type='checkbox' name='apvl[" + i + "]' title='Approval' value=" + response[i]['apvl'] + " id='checkbox-1'  class='icheckbox " + i + "' checked='checked'/> </label>";
                        } else {
                            var apvl = "<label class=''><input type='checkbox' name='apvl[" + i + "]' title='Approval' value='1' id='checkbox-1'  class='icheckbox " + i + "' /> </label>";
                        }

                        if (response[i]['reac'] == 1) {
                            var reac = "<label class=''><input type='checkbox' name='reac[" + i + "]' title='Reactive' value=" + response[i]['reac'] + " id='checkbox-1'  class='icheckbox " + i + "' checked='checked'/> </label>";
                        } else {
                            var reac = "<label class=''><input type='checkbox' name='reac[" + i + "]' title='Reactive' value='1' id='checkbox-1'  class='icheckbox " + i + "' /> </label>";
                        }

                        if (response[i]['dact'] == 1) {
                            var dact = "<label class=''><input type='checkbox' name='dact[" + i + "]' title='Deactive' value=" + response[i]['dact'] + " id='checkbox-1'  class='icheckbox " + i + "' checked='checked'/> </label>";
                        } else {
                            var dact = "<label class=''><input type='checkbox' name='dact[" + i + "]' title='Deactive' value='1' id='checkbox-1'  class='icheckbox " + i + "' /> </label>";
                        }

                        var all = "<label class=''><input type='checkbox' title='All' name='all[" + i + "]' value='' id='checkbox-1' onclick='chckall(" + i + ",this.checked)'  class='icheckbox' /> </label>";

                        if (response[i]['pgac'] == 1) {
                            var pgac = " <label class='switch switch-sm' title='Page access'><input type='checkbox' name='pgac[" + i + "]' checked value = '1'/> <span></span> </label> ";
                        } else {
                            var pgac = " <label class='switch switch-sm' title='Page access'><input type='checkbox' name='pgac[" + i + "]' value = '1'/> <span></span> </label> ";
                        }

                        if (i > 0 && (response[i - 1]['mdnm'] != response[i]['mdnm'])) {
                            var rowNode = t.row.add([
                                '#',
                                "<span style='color: #2D3349'> <b> " + response[i]['mdnm'] + "   </b> </span>",
                                '',
                                '',
                                '',
                                '',
                                '',
                                '',
                                '',
                                '',
                                '',
                                ''
                            ]).draw(false).node();
                            $(rowNode).addClass('info');
                        }

                        t.row.add([
                            i + 1,
                            response[i]['pgnm'] + ' (' + response[i]['aid'] + ')' + hid,
                            mntp,
                            viw,
                            inst,
                            edit,
                            rejt,
                            apvl,
                            dact,
                            reac,
                            all,
                            pgac
                        ]).draw(false);
                    }

                    if (len == 0) {
                        $('#edt_prmi_btn').attr('disabled', true);
                    } else {
                        $('#edt_prmi_btn').attr('disabled', false);
                    }
                }
            });
            //
            // SEARCH MASTER PERMISION
            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>admin/srchPermisMs",
                data: {
                    prtp: prtp,
                    uslv: uslv,
                    brch: brch,
                    user: user2
                },
                dataType: 'json',
                success: function (response) {
                    var len = response.length;
                    document.getElementById('taba').style.display = "block";

                    document.getElementById("adprtp").value = prtp;
                    document.getElementById("adprus").value = user2;

                    // Basic setting
                    $('#dataTbPerMs').DataTable().clear();
                    var t = $('#dataTbPerMs').DataTable({
                        destroy: true,
                        searching: false,
                        bPaginate: false,
                        "ordering": false,
                        "columnDefs": [
                            {className: "text-left", "targets": [1]},
                            {className: "text-center", "targets": [0, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]},
                            {className: "text-right", "targets": [0]},
                            {className: "text-nowrap", "targets": [1]}
                        ],
                        "aoColumns": [
                            {sWidth: '3%'},
                            {sWidth: '30%'},
                            {sWidth: '8%'},
                            {sWidth: '5%'},
                            {sWidth: '5%'},
                            {sWidth: '5%'},
                            {sWidth: '5%'},
                            {sWidth: '5%'},
                            {sWidth: '5%'},
                            {sWidth: '5%'},
                            {sWidth: '5%'},
                            {sWidth: '5%'}
                        ],
                        "footerCallback": function (row, data, start, end, display) {
                            var api = this.api(), data;
                            document.getElementById("lenms").value = display.length;
                        },

                    });
                    for (var i = 0; i < len; i++) {
                        var hid = "<label class=''><input type='hidden' name='prid[" + i + "]'  value=" + response[i]['prid'] + " /> </label>";

                        if (response[i]['mntp'] == 1) {
                            var mntp = "<label class='label label-success'> Master </label>";
                        } else {
                            var mntp = "<label class='label label-info'> User </label>";
                        }

                        if (response[i]['view'] == 1) {
                            var viw = "<label class=''><input type='checkbox' name='view[" + i + "]' title='View' value=" + response[i]['view'] + " id='checkbox-1'  class='icheckbox " + i + "' checked='checked'/><span></span></label>";
                        } else {
                            var viw = "<label class=''><input type='checkbox' name='view[" + i + "]' title='View' value='1' id='checkbox-1'  class='icheckbox " + i + "' /> </label>";
                        }
                        if (response[i]['inst'] == 1) {
                            var inst = "<label class=''><input type='checkbox' name='inst[" + i + "]' title='Add' value=" + response[i]['inst'] + " id='checkbox-1'  class='icheckbox " + i + "' checked='checked'/> </label>";
                        } else {
                            var inst = "<label class=''><input type='checkbox' name='inst[" + i + "]' title='Add' value='1' id='checkbox-1'  class='icheckbox " + i + "' /> </label>";
                        }
                        if (response[i]['edit'] == 1) {
                            var edit = "<label class=''><input type='checkbox' name='edit[" + i + "]' title='Edit' value=" + response[i]['edit'] + " id='checkbox-1'  class='icheckbox " + i + "' checked='checked'/> </label>";
                        } else {
                            var edit = "<label class=''><input type='checkbox' name='edit[" + i + "]' title='Edit' value='1' id='checkbox-1'  class='icheckbox " + i + "' /> </label>";
                        }
                        if (response[i]['rejt'] == 1) {
                            var rejt = "<label class=''><input type='checkbox' name='rejt[" + i + "]' title='Reject/Delete' value=" + response[i]['rejt'] + " id='checkbox-1'  class='icheckbox " + i + "' checked='checked'/> </label>";
                        } else {
                            var rejt = "<label class=''><input type='checkbox' name='rejt[" + i + "]' title='Reject/Delete' value='1' id='checkbox-1'  class='icheckbox " + i + "' /> </label>";
                        }
                        if (response[i]['apvl'] == 1) {
                            var apvl = "<label class=''><input type='checkbox' name='apvl[" + i + "]' title='Approval' value=" + response[i]['apvl'] + " id='checkbox-1'  class='icheckbox " + i + "' checked='checked'/> </label>";
                        } else {
                            var apvl = "<label class=''><input type='checkbox' name='apvl[" + i + "]' title='Approval' value='1' id='checkbox-1'  class='icheckbox " + i + "' /> </label>";
                        }

                        if (response[i]['reac'] == 1) {
                            var reac = "<label class=''><input type='checkbox' name='reac[" + i + "]' title='Reactive' value=" + response[i]['reac'] + " id='checkbox-1'  class='icheckbox " + i + "' checked='checked'/> </label>";
                        } else {
                            var reac = "<label class=''><input type='checkbox' name='reac[" + i + "]' title='Reactive' value='1' id='checkbox-1'  class='icheckbox " + i + "' /> </label>";
                        }

                        if (response[i]['dact'] == 1) {
                            var dact = "<label class=''><input type='checkbox' name='dact[" + i + "]' title='Deactive' value=" + response[i]['dact'] + " id='checkbox-1'  class='icheckbox " + i + "' checked='checked'/> </label>";
                        } else {
                            var dact = "<label class=''><input type='checkbox' name='dact[" + i + "]' title='Deactive' value='1' id='checkbox-1'  class='icheckbox " + i + "' /> </label>";
                        }

                        var all = "<label class=''><input type='checkbox' name='all[" + i + "]' title='All' value='' id='checkbox-1' onclick='chckall(" + i + ",this.checked)'  class='icheckbox' /> </label>";

                        if (response[i]['pgac'] == 1) {
                            var pgac = " <label class='switch switch-sm' title='Page access'><input type='checkbox' name='pgac[" + i + "]' checked value = '1'/> <span></span> </label> ";
                        } else {
                            var pgac = " <label class='switch switch-sm' title='Page access'><input type='checkbox' name='pgac[" + i + "]' value = '1'/> <span></span> </label> ";
                        }

                        if (i > 0 && (response[i - 1]['mdnm'] != response[i]['mdnm'])) {

                            var rowNode = t.row.add([
                                '#',
                                "<span style='color: #2D3349'> <b> " + response[i]['mdnm'] + "   </b> </span>",
                                '',
                                '',
                                '',
                                '',
                                '',
                                '',
                                '',
                                '',
                                '',
                                ''
                            ]).draw(false).node();
                            $(rowNode).addClass('info');
                        }

                        t.row.add([
                            i + 1,
                            response[i]['pgnm'] + ' (' + response[i]['aid'] + ')' + hid,
                            mntp,
                            viw,
                            inst,
                            edit,
                            rejt,
                            apvl,
                            dact,
                            reac,
                            all,
                            pgac
                        ]).draw(false);
                    }

                    if (len == 0) {
                        $('#edt_prmi_ms_btn').attr('disabled', true);
                    } else {
                        $('#edt_prmi_ms_btn').attr('disabled', false);
                    }
                }
            });
            //
            // SEARCH ADVANCE PERMISION
            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>admin/srchPermisAdvn",
                data: {
                    prtp: prtp,
                    uslv: uslv,
                    brch: brch,
                    user: user2
                },
                dataType: 'json',
                success: function (response) {
                    var len2 = response.length;

                    document.getElementById("adprtp").value = prtp;
                    document.getElementById("adprus").value = user2;

                    // advance setting
                    $('#dataTbPerAdv').DataTable().clear();
                    var t2 = $('#dataTbPerAdv').DataTable({
                        destroy: true,
                        searching: false,
                        bPaginate: false,
                        "ordering": false,
                        bAutoWidth: false,
                        "columnDefs": [
                            {className: "text-left", "targets": [1]},
                            {className: "text-center", "targets": [0, 2, 3, 4, 5]},
                            {className: "text-nowrap", "targets": [0]}
                        ],
                        "aoColumns": [
                            {sWidth: '5%'},
                            {sWidth: '55%'},
                            {sWidth: '10%'},
                            {sWidth: '10%'},
                            {sWidth: '10%'},
                            {sWidth: '10%'}
                        ],
                        "footerCallback": function (row, data, start, end, display) {
                            var api = this.api(), data;
                            document.getElementById("lensp").value = display.length;
                        },
                    });
                    for (var a = 0; a < len2; a++) {
                        if (response[a]['mntp'] == 1) {
                            var mntp = "<label class='label label-success'> Admin</label>";
                        } else {
                            var mntp = "<label class='label label-info'> User</label>";
                        }

                        var hid = "<label class=''><input type='hidden' name='prid[" + a + "]'  value=" + response[a]['prid'] + " /> </label>";

                        if (response[a]['prnt'] == 1) {
                            var prnt = "<label class=''><input type='checkbox' name='prnt[" + a + "]' title='Print' value=" + response[a]['prnt'] + " id='checkbox-1'  class='icheckbox " + a + "' checked='checked'/> </label>";
                        } else {
                            var prnt = "<label class=''><input type='checkbox' name='prnt[" + a + "]' title='Print' value='1' id='checkbox-1'  class='icheckbox " + a + "' /> </label>";
                        }
                        if (response[a]['rpnt'] == 1) {
                            var rpnt = "<label class=''><input type='checkbox' name='rpnt[" + a + "]' title='Reprint' value=" + response[a]['rpnt'] + " id='checkbox-1'  class='icheckbox " + a + "' checked='checked'/> </label>";
                        } else {
                            var rpnt = "<label class=''><input type='checkbox' name='rpnt[" + a + "]' title='Reprint' value='1' id='checkbox-1'  class='icheckbox " + a + "' /> </label>";
                        }

                        var all = "<label class=''><input type='checkbox' name='all[" + a + "]' title='All' value='' id='checkbox-1' onclick='chckallAdv(" + a + ",this.checked)'  class='icheckbox' /> </label>";

                        t2.row.add([
                            a + 1,
                            response[a]['pgnm'] + ' (' + response[a]['aid'] + ')' + hid,
                            mntp,
                            prnt,
                            rpnt,
                            all
                        ]).draw(false);
                    }

                    if (len2 == 0) {
                        $('#edt_prmi_updt_btn').attr('disabled', true);
                    } else {
                        $('#edt_prmi_updt_btn').attr('disabled', false);
                    }
                }
            });
            //
            // SEARCH SPECIAL PERMISION
            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>admin/srchPermisSpecil",
                data: {
                    prtp: prtp,
                    uslv: uslv,
                    user: user2
                },
                dataType: 'json',
                success: function (response) {
                    var len3 = response['perm'].length;

                    document.getElementById("adprtp").value = prtp;
                    document.getElementById("adprus").value = user2;

                    // special setting
                    $('#dataTbPerSpcil').DataTable().clear();
                    var t2 = $('#dataTbPerSpcil').DataTable({
                        destroy: true,
                        searching: false,
                        bPaginate: false,
                        "ordering": false,
                        bAutoWidth: false,
                        "columnDefs": [
                            {className: "text-left", "targets": [1]},
                            {className: "text-center", "targets": [0, 2, 3, 4, 5, 6, 7, 8]},
                            {className: "text-nowrap", "targets": [0]}
                        ],
                        "aoColumns": [
                            {sWidth: '5%'},
                            {sWidth: '25%'},
                            {sWidth: '10%'},
                            {sWidth: '10%'},
                            {sWidth: '10%'},
                            {sWidth: '10%'},
                            {sWidth: '10%'},
                            {sWidth: '10%'},
                            {sWidth: '10%'}
                        ],
                        "footerCallback": function (row, data, start, end, display) {
                            var api = this.api(), data;
                            document.getElementById("lenMst").value = display.length;
                            //document.getElementById("lenMst").value = len3;
                        },
                    });

                    if (len3 > 0) {
                        document.getElementById("type").value = 2;

                        for (var a = 0; a < len3; a++) {
                            var hid = "<label class=''><input type='hidden' name='auid[" + a + "]'  value=" + response['perm'][a]['auid'] + " /> </label>";

                            if (response['perm'][a]['msve'] == 1) {
                                var msst = "<label class=''><input type='checkbox' name='msve[" + a + "]' title='Master Setting' value=" + response['perm'][a]['msve'] + " id='checkbox-1'  class='icheckbox " + a + "' checked='checked'/> </label>";
                            } else {
                                var msst = "<label class=''><input type='checkbox' name='msve[" + a + "]' title='Master Setting' value='1' id='checkbox-1'  class='icheckbox " + a + "' /> </label>";
                            }
                            if (response['perm'][a]['albr'] == 1) {
                                var albr = "<label class=''><input type='checkbox' name='albr[" + a + "]' title='All Branch' onclick='chkspBrn(this.id)' value=" + response['perm'][a]['albr'] + " id='checkbox_albr'  class='icheckbox " + a + "' checked='checked'/> </label>";
                            } else {
                                var albr = "<label class=''><input type='checkbox' name='albr[" + a + "]' title='All Branch' onclick='chkspBrn(this.id)' value='1' id='checkbox_albr'  class='icheckbox " + a + "' /> </label>";
                            }
                            if (response['perm'][a]['spbr'] == 1) {
                                var spbr = "<label class=''><input type='checkbox' name='spbr[" + a + "]' title='Special Branch' onclick='chkAlBrn(this.id)' value=" + response['perm'][a]['spbr'] + " id='checkbox_spbr'  class='icheckbox " + a + " panel-refresh' checked='checked'/> </label>";
                            } else {
                                var spbr = "<label class=''><input type='checkbox' name='spbr[" + a + "]' title='Special Branch' onclick='chkAlBrn(this.id)' value='1' id='checkbox_spbr'  class='icheckbox " + a + " panel-refresh' /> </label>";
                            }
                            if (response['perm'][a]['alof'] == 1) {
                                var alof = "<label class=''><input type='checkbox' name='alof[" + a + "]' title='All Officer' value=" + response['perm'][a]['alof'] + " id='checkbox-1'  class='icheckbox " + a + "' checked='checked'/> </label>";
                            } else {
                                var alof = "<label class=''><input type='checkbox' name='alof[" + a + "]' title='All Officer' value='1' id='checkbox-1'  class='icheckbox " + a + "' /> </label>";
                            }
                            if (response['perm'][a]['alcn'] == 1) {
                                var alcn = "<label class=''><input type='checkbox' name='alcn[" + a + "]' title='All Center' value=" + response['perm'][a]['alcn'] + " id='checkbox-1'  class='icheckbox " + a + "' checked='checked'/> </label>";
                            } else {
                                var alcn = "<label class=''><input type='checkbox' name='alcn[" + a + "]' title='All Center' value='1' id='checkbox-1'  class='icheckbox " + a + "' /> </label>";
                            }
                            if (response['perm'][a]['tpsp'] == 1) {
                                var tpsp = "<label class=''><input type='checkbox' name='tpsp[" + a + "]' title='Topup Special' value=" + response['perm'][a]['tpsp'] + " id='checkbox-1'  class='icheckbox " + a + "' checked='checked'/> </label>";
                            } else {
                                var tpsp = "<label class=''><input type='checkbox' name='tpsp[" + a + "]' title='Topup Special' value='1' id='checkbox-1'  class='icheckbox " + a + "' /> </label>";
                            }

                            var all = "<label class=''><input type='checkbox' name='all[" + a + "]' title='All' value='' id='checkbox-1' onclick='chckallSpec(" + a + ",this.checked)'  class='icheckbox' /> </label>";

                            t2.row.add([
                                a + 1 + hid,
                                response['uslv'][0]['lvnm'],
                                msst,
                                albr,
                                spbr,
                                alof,
                                alcn,
                                tpsp,
                                all
                            ]).draw(false);

                            if (response['perm'][a]['spbr'] == 1) {
                                getSpecBrn();
                            }
                        }

                    } else {
                        document.getElementById("type").value = 1;

                        var lvid = "<label class=''><input type='hidden' name='lvid[" + 0 + "]'  value=" + response['uslv'][0]['id'] + " /> </label>";

                        var msst = "<label class=''><input type='checkbox' name='msst[" + 0 + "]' value='1' title='Master Setting'  id='checkbox-1'  class='icheckbox " + 0 + "' /> </label>";
                        var albr = "<label class=''><input type='checkbox' name='albr[" + 0 + "]' value='1' onclick='chkspBrn(this.id)' title='All Branch'  id='checkbox_albr'  class='icheckbox " + 0 + "' /> </label>";
                        var spbr = "<label class=''><input type='checkbox' name='spbr[" + 0 + "]' value='1' onclick='chkAlBrn(this.id)' title='Special Branch'  id='checkbox_spbr'  class='icheckbox " + 0 + "' /> </label>";
                        var alof = "<label class=''><input type='checkbox' name='alof[" + 0 + "]' value='1' title='All Officer'  id='checkbox-1'  class='icheckbox " + 0 + "' /> </label>";
                        var alcn = "<label class=''><input type='checkbox' name='alcn[" + 0 + "]' value='1' title='All Center'  id='checkbox-1'  class='icheckbox " + 0 + "' /> </label>";
                        var tpsp = "<label class=''><input type='checkbox' name='tpsp[" + 0 + "]' value='1' title='Topup Special'  id='checkbox-1'  class='icheckbox " + 0 + "' /> </label>";
                        var all = "<label class=''><input type='checkbox' name='all[" + 0 + "]' title='All' value='1' value='' id='checkbox-1' onclick='chckallSpec(" + 0 + ",this.checked)'  class='icheckbox' /> </label>";

                        t2.row.add([
                            1,
                            response['uslv'][0]['lvnm'] + lvid,
                            msst,
                            albr,
                            spbr,
                            alof,
                            alcn,
                            tpsp,
                            all
                        ]).draw(false);
                    }
                }
            });
            //
            // SEARCH MODULE PERMISION
            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>admin/srchMdulPermis",
                data: {
                    prtp: prtp,
                    uslv: uslv,
                    user: user2
                },
                dataType: 'json',
                success: function (response) {
                    var len4 = response['perm'].length;

                    document.getElementById("adprtp2").value = prtp;
                    document.getElementById("adprus2").value = user2;

                    // special setting
                    $('#dataTbPerMdul').DataTable().clear();
                    var t2 = $('#dataTbPerMdul').DataTable({
                        destroy: true,
                        searching: false,
                        bPaginate: false,
                        "ordering": false,
                        bAutoWidth: false,
                        "columnDefs": [
                            {className: "text-left", "targets": [1]},
                            {className: "text-center", "targets": [0, 2, 3, 4, 5]},
                            {className: "text-nowrap", "targets": [0]}
                        ],
                        "aoColumns": [
                            {sWidth: '5%'},
                            {sWidth: '30%'},
                            {sWidth: '10%'},
                            {sWidth: '10%'},
                            {sWidth: '10%'},
                            {sWidth: '10%'},
                        ],
                        "footerCallback": function (row, data, start, end, display) {
                            var api = this.api(), data;
                            document.getElementById("lenMst2").value = display.length;
                        },
                    });

                    if (len4 > 0) {
                        document.getElementById("type2").value = 2;

                        for (var a = 0; a < len4; a++) {
                            var hid = "<label class=''><input type='hidden' name='auid[" + a + "]'  value=" + response['perm'][a]['auid'] + " /> </label>";

                            if (response['perm'][a]['user'] == 1) {
                                var user = "<label class=''><input type='checkbox' name='user[" + a + "]' title='User module' value=" + response['perm'][a]['user'] + " id='checkbox-1'  class='icheckbox " + a + "' checked='checked'/> </label>";
                            } else {
                                var user = "<label class=''><input type='checkbox' name='user[" + a + "]' title='User module' value='1' id='checkbox-1'  class='icheckbox " + a + "' /> </label>";
                            }
                            if (response['perm'][a]['admi'] == 1) {
                                var admi = "<label class=''><input type='checkbox' name='admi[" + a + "]' title='Admin Module' value=" + response['perm'][a]['admi'] + " id='checkbox-1'  class='icheckbox " + a + "' checked='checked'/> </label>";
                            } else {
                                var admi = "<label class=''><input type='checkbox' name='admi[" + a + "]' title='Admin Module' value='1' id='checkbox-1'  class='icheckbox " + a + "' /> </label>";
                            }
                            if (response['perm'][a]['stck'] == 1) {
                                var stck = "<label class=''><input type='checkbox' name='stck[" + a + "]' title='Stock Module' value=" + response['perm'][a]['stck'] + " id='checkbox-1'  class='icheckbox " + a + "' checked='checked'/> </label>";
                            } else {
                                var stck = "<label class=''><input type='checkbox' name='stck[" + a + "]' title='Stock Module' value='1' id='checkbox-1'  class='icheckbox " + a + "' /> </label>";
                            }

                            var all = "<label class=''><input type='checkbox' name='all[" + a + "]' title='All' value='' id='checkbox-1' onclick='chckallMdul(" + a + ",this.checked)'  class='icheckbox' /> </label>";

                            t2.row.add([
                                a + 1 + hid,
                                response['uslv'][0]['lvnm'],
                                user,
                                admi,
                                stck,
                                all
                            ]).draw(false);
                        }

                    } else {
                        document.getElementById("type2").value = 1;

                        var lvid = "<label class=''><input type='hidden' name='lvid[" + 0 + "]'  value=" + response['uslv'][0]['id'] + " /> </label>";

                        var user = "<label class=''><input type='checkbox' name='user[" + 0 + "]' value='1' title='User Module'  id='checkbox-1'  class='icheckbox " + 0 + "' /> </label>";
                        var admi = "<label class=''><input type='checkbox' name='admi[" + 0 + "]' value='1' title='Admin Module'  id='checkbox-1'  class='icheckbox " + 0 + "' /> </label>";
                        var stck = "<label class=''><input type='checkbox' name='stck[" + 0 + "]' value='1' title='Stock Module'  id='checkbox-1'  class='icheckbox " + 0 + "' /> </label>";
                        var all = "<label class=''><input type='checkbox' name='all[" + 0 + "]' title='All' value='1' value='' id='checkbox-1' onclick='chckallMdul(" + 0 + ",this.checked)'  class='icheckbox' /> </label>";

                        t2.row.add([
                            1,
                            response['uslv'][0]['lvnm'] + lvid,
                            user,
                            admi,
                            stck,
                            all
                        ]).draw(false);
                    }
                }
            });
            //
            // SEARCH PAGE ACCESS
            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>admin/srchPgAcss",
                data: {
                    prtp: prtp,
                    uslv: uslv,
                    brch: brch,
                    user: user2
                },
                dataType: 'json',
                success: function (response) {
                    var len5 = response.length;
                    document.getElementById('taba').style.display = "block";

                    // Basic setting
                    $('#dataTbPgacs').DataTable().clear();
                    var t = $('#dataTbPgacs').DataTable({
                        destroy: true,
                        searching: false,
                        bPaginate: false,
                        "ordering": false,
                        "columnDefs": [
                            {className: "text-left", "targets": [1]},
                            {className: "text-center", "targets": [0, 2, 3]},
                            {className: "text-right", "targets": [0]},
                            {className: "text-nowrap", "targets": [1]}
                        ],
                        "aoColumns": [
                            {sWidth: '5%'},
                            {sWidth: '50%'},
                            {sWidth: '10%'},
                            {sWidth: '10%'},
                        ],
                        "footerCallback": function (row, data, start, end, display) {
                            var api = this.api(), data;
                            document.getElementById("len5").value = display.length;
                        },

                    });
                    for (var i = 0; i < len5; i++) {
                        var hid = "<label class=''><input type='hidden' name='pgid[" + i + "]'  value=" + response[i]['aid'] + " /> </label>";

                        if (response[i]['mntp'] == 1) {
                            var mntp = "<label class='label label-success'> Admin </label>";
                        } else {
                            var mntp = "<label class='label label-info'> User </label>";
                        }

                        if (response[i]['stst'] == 1) {
                            var pgac = " <label class='switch switch-sm' title='Page access'><input type='checkbox' name='pgac[" + i + "]' checked value = '1'/> <span></span> </label> ";
                        } else {
                            var pgac = " <label class='switch switch-sm' title='Page access'><input type='checkbox' name='pgac[" + i + "]' value = '1'/> <span></span> </label> ";
                        }

                        if (i > 0 && (response[i - 1]['mdnm'] != response[i]['mdnm'])) {

                            var rowNode = t.row.add([
                                '#',
                                "<span style='color: #2D3349'> <b> " + response[i]['mdnm'] + "   </b> </span>",
                                '',
                                ''
                            ]).draw(false).node();
                            $(rowNode).addClass('info');
                        }else if(i==0){
                            var rowNode = t.row.add([
                                '#',
                                "<span style='color: #2D3349'> <b> " + response[i]['mdnm'] + "   </b> </span>",
                                '',
                                ''
                            ]).draw(false).node();
                            $(rowNode).addClass('info');
                        }

                        t.row.add([
                            i + 1,
                            response[i]['pgnm'] + ' (' + response[i]['aid'] + ')' + hid,
                            mntp,
                            pgac
                        ]).draw(false);
                    }

                    if (len5 == 0) {
                        $('#pgAccss_updt_btn').attr('disabled', true);
                    } else {
                        $('#pgAccss_updt_btn').attr('disabled', false);
                    }
                }
            });
        }

        // SPECIAL BRANCH
        function chkspBrn(htmId) {
            console.log(htmId);
            if (document.getElementById(htmId).checked == true) {
                if (htmId == 'checkbox_albr') {
                    document.getElementById('checkbox_spbr').checked = false;
                } else {
                    document.getElementById('checkbox_spbr').checked = false;
                }
            }
            getSpecBrn();
        }

        // CHECK ALL BRN
        function chkAlBrn(htmId) {
            console.log(htmId);
            if (document.getElementById(htmId).checked == true) {
                if (htmId == 'checkbox_spbr') {
                    document.getElementById('checkbox_albr').checked = false;
                } else {
                    document.getElementById('checkbox_albr').checked = false;
                }
            }
            getSpecBrn();
        }

        // GET SOME SPECIAL BRANCH
        function getSpecBrn() {
            //$('#taba a:first').tab('show');

            if (document.getElementById('checkbox_spbr').checked == true) {

                document.getElementById('perBrn').style.display = 'block';

                $('#brnchTb').DataTable().clear();
                var prtp = document.getElementById('prtp').value;   // PERMISION TYPE
                var uslv = document.getElementById('uslv').value;   // USER LEVEL
                var brch = document.getElementById('brch').value;   // BRANCH ID
                var user2 = document.getElementById('user').value;   // USER ID

                $.ajax({
                    type: "POST",
                    url: "<?= base_url(); ?>admin/getSpecilBrnch",
                    data: {
                        prtp: prtp,
                        uslv: uslv,
                        user: user2
                    },
                    dataType: 'json',
                    success: function (response) {
                        document.getElementById("adprtp").value = prtp;
                        document.getElementById("adprus").value = user2;

                        // special setting
                        $('#brnchTb').DataTable().clear();
                        var t2 = $('#brnchTb').DataTable({
                            destroy: true,
                            searching: false,
                            bPaginate: false,
                            "ordering": false,
                            bAutoWidth: false,
                            "columnDefs": [
                                {className: "text-left", "targets": [2]},
                                {className: "text-center", "targets": [0, 1, 3]},
                                {className: "text-nowrap", "targets": [0]}
                            ],
                            "aoColumns": [
                                {sWidth: '5%'},
                                {sWidth: '20%'},
                                {sWidth: '40%'},
                                {sWidth: '10%'}
                            ],
                            "footerCallback": function (row, data, start, end, display) {
                                var api = this.api(), data;
                                document.getElementById("brnLn").value = display.length;
                            },
                        });

                        var len3 = response['perm'].length; // PERMISION SET DETAILS
                        var brnc = response['brnc'].length; // ALL BRANCH

                        //var usrBrn = <?//= $_SESSION['usrbrnc']; ?>
                        // console.log()

                        if (len3 > 0) {
                            document.getElementById("brnLn").value = 2;

                            for (var a = 0; a < brnc; a++) {
                                var lvid = "<label class=''><input type='hidden' name='lvid[" + a + "]'  value=" + response['uslv'][0]['id'] + " /> </label>";

                                for (var x = 0; x < len3; x++) {
                                    var bridn = "<label class=''><input type='hidden' name='bridn[" + a + "]'  value=" + response['brnc'][a]['brid'] + " /> </label>";

                                    // IF CHECK ALL BRANCH == GET TB BRANCH
                                    if ((response['brnc'][a]['brid'] == response['perm'][x]['brid'])) {

                                        // IF CHECK STAT IS ACTIVE OR NOT
                                        if (response['perm'][x]['stat'] == 1) {
                                            var hid = "<label class=''><input type='hidden' name='buAuid[" + a + "]'  value=" + response['perm'][x]['auid'] + " /> </label>";
                                            var sppbrn = "<label class=''><input type='checkbox' name='sppbrn[" + a + "]' title='' value='1' id='checkbox-1'  class='icheckbox" + a + "' checked='checked'/> </label>";

                                        } else {
                                            var hid = "<label class=''><input type='hidden' name='buAuid[" + a + "]'  value=" + response['perm'][x]['auid'] + " /> </label>";
                                            var sppbrn = "<label class=''><input type='checkbox' name='sppbrn[" + a + "]' title='' value='1' id='checkbox-1'  class='icheckbox" + a + "' /> </label>";
                                        }
                                        break;

                                    } else {
                                        var hid = "<label class=''><input type='hidden' name='buAuid[" + a + "]'  value='' /> </label>";
                                        var sppbrn = "<label class=''><input type='checkbox' name='sppbrn_nm[" + a + "]' title='' value=" + response['brnc'][a]['brid'] + " id='checkbox-1'  class='icheckbox" + a + "' /> </label>";
                                    }
                                }

                                t2.row.add([
                                    a + 1 + hid + lvid,
                                    response['brnc'][a]['brcd'] + bridn,
                                    response['brnc'][a]['brnm'],
                                    sppbrn
                                ]).draw(false);
                            }

                        } else {
                            document.getElementById("brnLn").value = 1;

                            for (var a = 0; a < brnc; a++) {

                                var lvid = "<label class=''><input type='hidden' name='lvid[" + a + "]'  value=" + response['uslv'][0]['id'] + " /> </label>";
                                var bridn = "<label class=''><input type='hidden' name='bridn[" + a + "]'  value=" + response['brnc'][a]['brid'] + " /> </label>";
                                var sppbrn = "<label class=''><input type='checkbox' name='sppbrn_nm[" + a + "]' title='' value=" + response['brnc'][a]['brid'] + " id='checkbox-1'  class='icheckbox" + a + "' /> </label>";

                                t2.row.add([
                                    a + 1 + lvid,
                                    response['brnc'][a]['brcd'] + bridn,
                                    response['brnc'][a]['brnm'],
                                    sppbrn
                                ]).draw(false);
                            }
                        }
                    }
                })

            } else {
                document.getElementById('perBrn').style.display = 'none';
            }
        }

        // new module add function
        function mdulAdd(type) {
            var prtp = document.getElementById('prtp').value;
            var uslv = document.getElementById('uslv').value;
            var brch = document.getElementById('brch').value;
            var user = document.getElementById('user').value;

            document.getElementById("uslvl").value = uslv;
            document.getElementById("usid").value = user;
            document.getElementById("ptp").value = prtp;

            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>admin/srchModul",
                data: {
                    prtp: prtp,
                    uslv: uslv,
                    brch: brch,
                    user: user,
                    type: type
                },
                dataType: 'json',
                success: function (response) {
                    var len = response.length;

                    $('#dataTbmdl').DataTable().clear();
                    var t = $('#dataTbmdl').DataTable({
                        destroy: true,
                        searching: false,
                        bPaginate: false,
                        "ordering": false,
                        "columnDefs": [
                            {className: "text-left", "targets": [1]},
                            {className: "text-center", "targets": [0, 2, 3]},
                            {className: "text-nowrap", "targets": [1]}
                        ],
                        "aoColumns": [
                            {sWidth: '5%'},
                            {sWidth: '75%'},    // br
                            {sWidth: '10%'},
                            {sWidth: '10%'},
                        ],
                        "footerCallback": function (row, data, start, end, display) {
                            var api = this.api(), data;
                            document.getElementById("mdlen").value = display.length;
                        },
                    });
                    for (var i = 0; i < len; i++) {
                        if (response[i]['mntp'] == 1) {
                            var mntp = "<label class='label label-success'> Admin</label>";
                        } else {
                            var mntp = "<label class='label label-info'> User</label>";
                        }

                        var hid = "<label class=''><input type='hidden' name='aid[" + i + "]'  value=" + response[i]['aid'] + " /> </label>";
                        var viw = "<label class=''><input type='checkbox' title='Add' name='addm[" + i + "]' value='1' id='checkbox-1'  class='icheckbox' /> </label>";

                        if (i > 0 && (response[i - 1]['mdnm'] != response[i]['mdnm'])) {
                            var rowNode = t.row.add([
                                '#',
                                "<span style='color: #2D3349'> <b> " + response[i]['mdnm'] + "   </b> </span>",
                                '',
                                ''
                            ]).draw(false).node();
                            $(rowNode).addClass('info');
                        }else if(i==0){
                            var rowNode = t.row.add([
                                '#',
                                "<span style='color: #2D3349'> <b> " + response[i]['mdnm'] + "   </b> </span>",
                                '',
                                ''
                            ]).draw(false).node();
                            $(rowNode).addClass('info');
                        }

                        t.row.add([
                            i + 1,
                            '(' + response[i]['aid'] + ') ' + response[i]['pgnm'] + hid,
                            mntp,
                            viw,
                        ]).draw(false);
                    }

                    if (len == 0) {
                        $('#add_new_page').attr('disabled', true);
                    } else {
                        $('#add_new_page').attr('disabled', false);
                    }
                }
            })
        }

        $('#add_new_page').click(function (e) {
            e.preventDefault();

            swal({
                title: "Processing...",
                text: "",
                imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                showConfirmButton: false
            });

            jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>admin/addModul",
                data: $("#mdul_add").serialize(),
                dataType: 'json',
                success: function (response) {
                    swal({title: "", text: "New page add Success", type: "success"},
                        function () {
                            $('#modalAdd').modal('hide');
                            srchPerm();
                        });
                },
                error: function (data, textStatus) {
                    swal({title: "Error", text: textStatus, type: "error"},
                        function () {
                        });
                }
            });
        });

        $('#edt_prmi_btn').click(function (e) {
            e.preventDefault();
            swal({
                title: "Processing...",
                text: "",
                imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                showConfirmButton: false
            });

            var len = document.getElementById('len').value;
            if (len > 0) {
                jQuery.ajax({
                    type: "POST",
                    url: "<?= base_url(); ?>admin/edtPermin",
                    data: $("#edt_prmi").serialize(),
                    dataType: 'json',
                    success: function (response) {
                        swal({title: "", text: "Permission Update Successfully", type: "success"},
                            function () {
                                srchPerm();
                            });
                    },
                    error: function (data, textStatus) {
                        swal({title: "Update Error", text: textStatus, type: "error"},
                            function () {
                            });
                    }
                });
            } else {
                swal("NO Permission Updates", '', "warning");
            }
        });

        $('#edt_prmi_ms_btn').click(function (e) {
            e.preventDefault();
            swal({
                title: "Processing...",
                text: "",
                imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                showConfirmButton: false
            });

            var len = document.getElementById('lenms').value;
            if (len > 0) {
                jQuery.ajax({
                    type: "POST",
                    url: "<?= base_url(); ?>admin/edtPerminMs",
                    data: $("#edt_prmi_ms").serialize(),
                    dataType: 'json',
                    success: function (response) {
                        swal({title: "", text: "Permission Update Successfully", type: "success"},
                            function () {
                                srchPerm();
                            });
                    },
                    error: function (data, textStatus) {
                        swal({title: "Update Error", text: textStatus, type: "error"},
                            function () {
                            });
                    }
                });
            } else {
                swal("NO Permission Updates", '', "warning");
            }
        });

        $('#edt_prmi_updt_btn').click(function (e) {
            e.preventDefault();
            swal({
                title: "Processing...",
                text: "",
                imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                showConfirmButton: false
            });

            jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>admin/edtPerminAdvan",
                data: $("#advedt_prmi").serialize(),
                dataType: 'json',
                success: function (response) {
                    swal({title: "", text: "Permission Update Successfully", type: "success"},
                        function () {
                            srchPerm();
                        });
                },
                error: function (data, textStatus) {
                    swal({title: "Update Error", text: textStatus, type: "error"},
                        function () {
                            //location.reload();
                        });
                }
            });
        });

        $('#specil_prmi_updt_btn').click(function (e) {
            e.preventDefault();
            swal({
                title: "Processing...",
                text: "",
                imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                showConfirmButton: false
            });

            jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>admin/edtPerminSpecil",
                data: $("#specil_prmi").serialize(),
                dataType: 'json',
                success: function (response) {
                    swal({title: "", text: "Special Permission Update Successfully", type: "success"},
                        function () {
                            srchPerm();
                        });
                },
                error: function (data, textStatus) {
                    swal({title: "Update Error", text: textStatus, type: "error"},
                        function () {
                            //location.reload();
                        });
                }
            });
        });

        $('#mdule_prmi_updt_btn').click(function (e) {
            e.preventDefault();
            swal({
                title: "Processing...",
                text: "",
                imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                showConfirmButton: false
            });

            jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>admin/edtMdulPermis",
                data: $("#mdule_prmi").serialize(),
                dataType: 'json',
                success: function (response) {
                    swal({title: "", text: "Module Permission Update Successfully", type: "success"},
                        function () {
                            srchPerm();
                        });
                },
                error: function (data, textStatus) {
                    swal({title: "Update Error", text: textStatus, type: "error"},
                        function () {
                            //location.reload();
                        });
                }
            });
        });

        $('#pgAccss_updt_btn').click(function (e) {
            e.preventDefault();
            swal({
                title: "Processing...",
                text: "",
                imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                showConfirmButton: false
            });

            var len = document.getElementById('len5').value;
            if (len > 0) {
                jQuery.ajax({
                    type: "POST",
                    url: "<?= base_url(); ?>admin/edtPgaccs",
                    data: $("#pgAccss").serialize(),
                    dataType: 'json',
                    success: function (response) {
                        swal({title: "", text: "Permission Update Successfully", type: "success"},
                            function () {
                                srchPerm();
                            });
                    },
                    error: function (data, textStatus) {
                        swal({title: "Update Error", text: textStatus, type: "error"},
                            function () {
                            });
                    }
                });
            } else {
                swal("NO Permission Updates", '', "error");
            }

        });

        function chckall(prid, isChecked) {
            if (isChecked) {
                $("." + prid).each(function () {
                    $(this).prop("checked", true);
                });
            } else {
                $("." + prid).each(function () {
                    $(this).prop("checked", false);
                });
            }
        }

        function chckallAdv(prid, isChecked) {
            if (isChecked) {
                $("." + prid).each(function () {
                    $(this).prop("checked", true);
                });
            } else {
                $("." + prid).each(function () {
                    $(this).prop("checked", false);
                });
            }
        }

        function chckallSpec(prid, isChecked) {
            if (isChecked) {
                $("." + prid).each(function () {
                    $(this).prop("checked", true);
                });
            } else {
                $("." + prid).each(function () {
                    $(this).prop("checked", false);
                });
            }
        }

        function chckallMdul(prid, isChecked) {
            if (isChecked) {
                $("." + prid).each(function () {
                    $(this).prop("checked", true);
                });
            } else {
                $("." + prid).each(function () {
                    $(this).prop("checked", false);
                });
            }
        }
    </script>
</div>
<!-- END PAGE CONTAINER -->

