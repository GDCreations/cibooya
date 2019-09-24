<script type="text/javascript" src="<?= base_url(); ?>assets/js/custom-js/full_width.js"></script>

<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">General</a></li>
        <li class="active">Recent Activity</li>
    </ul>
</div>
<div class="app-heading app-heading-bordered app-heading-page">
    <div class="icon icon-lg">
        <span class="fa fa-sliders" style="color: #e69c0f;"></span>
    </div>
    <div class="title">
        <h1>Recent Activity</h1>
        <p>User Activity</p>
    </div>
</div>
<!-- END PAGE HEADING -->

<!-- START PAGE CONTAINER -->
<div class="container">
    <!--    <div class="block">-->

    <div class="panel panel-default block">
        <div class="row form-horizontal">

            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-md-4 col-xs-12 control-label">Branch</label>
                    <div class="col-md-8 col-xs-12">
                        <select class="bs-select" name="brch" id="brch"
                                onchange="getUser(this.value,'userSclt');chckBtn(this.value,'brch')">
                            <?php
                            foreach ($branchinfo as $branch) {
                                echo "<option value='$branch[brch_id]'>$branch[brch_name]</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 col-xs-12 control-label">From Date</label>
                    <div class="col-md-8 col-xs-12">
                        <input type="text" class="form-control bs-datepicker" name="frdt" id="frdt"
                               value="<?= date('m-d-Y') ?>"/>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-md-4 col-xs-12 control-label">User </label>
                    <div class="col-md-8 col-xs-12" id="userSclt">
                        <select class="bs-select" name="user" id="user"
                                onchange="chckBtn(this.value,'user')">
                            <option value="0"> Select User</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 col-xs-12 control-label">To Date</label>
                    <div class="col-md-8 col-xs-12">
                        <input type="text" class="form-control bs-datepicker" name="todt" id="todt"
                               value="<?= date('m-d-Y') ?>"/>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group"><br> <br></div>
                <button class="btn btn-sm btn-primary btn-rounded  btn-icon-fixed pull-right" data-toggle="modal"
                        data-target="#modal-add"
                        onclick="srchActv()">
                    <span class="fa fa-search"></span>Search
                </button>
            </div>
        </div>
    </div>
    <div class="panel panel-default block">
        <div class="row form-horizontal">
            <div class="table-responsive">
                <table id="dataTbRcnt" class="table dataTable table-striped table-bordered" width="100%">
                    <thead>
                    <tr>
                        <th class="text-left">#</th>
                        <th class="text-left">USER</th>
                        <th class="text-left">ACTIVITY LOG</th>
                        <th class="text-left">DATE & TIME</th>
                        <th class="text-left">LOGIN IP</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!--    </div>-->
    <script type="text/javascript">

        $().ready(function () {

        });

        function chckBtn(id, inpu) {
            if (id == 0) { //brch_cst
                document.getElementById(inpu).style.borderColor = "red";
            } else {
                document.getElementById(inpu).style.borderColor = "";
            }
        }

        function getUser(brid, div) {
            $.ajax({
                url: '<?= base_url(); ?>admin/getUser',
                type: 'post',
                data: {
                    brid: brid,
                    uslv: 'all'
                },
                dataType: 'json',
                success: function (response) {
                    var len = response.length;
                    var child1 = $('#' + div).children();
                    var child2 = child1.find('div').children();
                    child2.empty();

                    if (len != 0) {
                        $('#user').empty();
                        $('#user').append("<option value='all'>All User </option>");
                        child2.append("<li data-original-index=\"0\"><a tabindex=\"0\" class=\"\" data-tokens=\"null\" role=\"option\" aria-disabled=\"false\" aria-selected=\"true\"><span class=\"text\">All User\n" +
                            "</span><span class=\" fa fa-check check-mark\"></span></a></li>");
                        // $('#user').append("<option value='all'> All User</option>");

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
                        $('#user').append("<option value='no'>No User</option>");
                        child2.append("<li data-original-index=\"0\" class=\"\"><a tabindex=\"0\" class=\"\" data-tokens=\"null\" role=\"option\" aria-disabled=\"false\" aria-selected=\"false\"><span class=\"text\">-- No User --</span><span class=\" fa fa-check check-mark\"></span></a></li>");
                    }
                    default_Selector(child1.find('div'));
                }
            });

        }

        // Search btn
        function srchActv() {

            var brn = document.getElementById('brch').value;
            var user = document.getElementById('user').value;
            //var act = document.getElementById('act').value;
            var frdt = document.getElementById('frdt').value;
            var todt = document.getElementById('todt').value;

            console.log(brn + ' x ' + user + ' x ' + frdt + ' x ' + todt + ' x ');

            if (brn == '0') {
                document.getElementById('brch').style.borderColor = "red";
            } else {
                document.getElementById('brch').style.borderColor = "";

                $('#dataTbRcnt').DataTable().clear();
                $('#dataTbRcnt').DataTable({
                    "destroy": true,
                    "cache": false,
                    "processing": true,
                    searching: true,
                    "language": {
                        processing: '<i class="fa fa-spinner fa-spin fa-fw" style="font-size:20px;color:red;"></i><span class=""> Loading...</span> '
                    },
                    "lengthMenu": [
                        [25, 50, 100, -1],
                        [25, 50, 100, "All"]
                    ],
                    "serverSide": true,
                    "columnDefs": [

                        {className: "text-left", "targets": [1, 2]},
                        {className: "text-center", "targets": [0, 4]},
                        {className: "text-right", "targets": [3]},
                        {className: "text-nowrap", "targets": [0]},

                        //  image add this function
                        //  Search Add  View Update Approval Reject
                        {
                            /*https://datatables.net/examples/advanced_init/column_render.html*/
                            "render": function (data, type, row) {
                                var act = row[2];

                                var sr = act.search(/Search/i);
                                var ad = act.search(/Add/i);
                                var vw = act.search(/View/i);
                                var up = act.search(/Update/i);
                                var up2 = act.search(/Edit/i);
                                var ap = act.search(/Approval/i);
                                var rj = act.search(/Reject/i);
                                var rj2 = act.search(/Inactive /i);
                                var rj3 = act.search(/Close /i);

                                var reac = act.search(/Reactive /i);
                                var upg = act.search(/Upgrade /i);

                                var lgi = act.search(/Login /i);
                                var lgo = act.search(/Logout /i);

                                var prnt = act.search(/print /i);
                                var rpnt = act.search(/Reprint /i);

                                var expt = act.search(/Export/i);

                                if (sr > 0) {
                                    return '<i class="fa fa-search"></i> ' + data;

                                } else if (ad > 0) {
                                    return '<i class="fa fa-plus"></i> ' + data;
                                } else if (vw > 0) {
                                    return '<i class="fa fa-eye"></i> ' + data;

                                } else if (up > 0 || up2 > 0) {
                                    return '<i class="fa fa-edit"></i> ' + data;

                                } else if (ap > 0) {
                                    return '<i class="fa fa-check"></i> ' + data;

                                } else if (rj > 0 || rj2 > 0 || rj3 > 0) {
                                    return '<i class="fa fa-close"></i> ' + data;

                                } else if (reac > 0 || upg > 0) {
                                    return '<i class="glyphicon glyphicon-wrench"></i> ' + data;

                                } else if (lgi > 0) {
                                    return '<i class="fa fa-sign-in"></i> ' + data;

                                } else if (lgo > 0) {
                                    return '<i class="fa fa-sign-out"></i> ' + data;

                                } else if (prnt > 0 || rpnt > 0) {
                                    return '<i class="fa fa-print"></i> ' + data;

                                } else if (expt > 0) {
                                    return '<i class="fa fa-file-excel-o"></i> ' + data;

                                } else {
                                    return data;
                                }
                            },
                            "targets": 2
                        }

                    ],
                    "order": [[3, "desc"]],
                    "aoColumns": [
                        {sWidth: '5%'},
                        {sWidth: '10%'},
                        {sWidth: '30%'}, // name
                        {sWidth: '18%'},
                        {sWidth: '10%'}
                    ],
                    "ajax": {
                        url: '<?= base_url(); ?>admin/srchActivit',
                        type: 'post',
                        data: {
                            brn: brn,
                            user: user,
                            //act: act,
                            frdt: frdt,
                            todt: todt
                        }
                    },
                });
            }
        }


    </script>
</div>
<!-- END PAGE CONTAINER -->
