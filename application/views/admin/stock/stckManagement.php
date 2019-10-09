<script type="text/javascript" src="<?= base_url(); ?>assets/js/custom-js/full_width.js"></script>

<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">Stock Access</a></li>
        <li class="active">Stock Management</li>
    </ul>
</div>
<div class="app-heading app-heading-bordered app-heading-page">
    <div class="icon icon-lg">
        <span class="fa fa-cubes" style="color: #e69c0f;"></span>
    </div>
    <div class="title">
        <h1>Stock Management</h1>
        <p>Add Stock / Edit / View / Approve / Search & View</p>
    </div>
    <?php
    if ($funcPerm[0]->inst == 1) { ?>
        <div class="pull-right">
            <button class="btn btn-sm btn-info btn-icon-fixed btn-rounded" data-toggle="modal" data-target="#modal-add">
                <span class="fa fa-plus"></span>New Stock
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
                    <label class="col-md-4 col-xs-6 control-label">Category</label>
                    <div class="col-md-8 col-xs-6">
                        <select class="bs-select" name="cats" id="cats"
                                onchange="chckBtn(this.value,this.id);">
                            <option value="all">All Categories</option>
                            <?php
                            foreach ($category as $ctgry) {
                                echo "<option value='$ctgry->ctid'>" . $ctgry->ctcd . " - " . $ctgry->ctnm . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 col-xs-6 control-label">Status</label>
                    <div class="col-md-8 col-xs-6">
                        <select class="bs-select" name="stats" id="stats">
                            <option value="1">Active</option>
                            <option value="0">Pending</option>
                            <option value="2">Finish</option>
                            <option value="3">Reject</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-md-4 col-xs-6 control-label">Brand</label>
                    <div class="col-md-8 col-xs-6">
                        <select class="bs-select" name="brnds" id="brnds"
                                onchange="chckBtn(this.value,this.id)">
                            <option value="all">All Brands</option>
                            <?php
                            foreach ($brand as $brnd) {
                                echo "<option value='$brnd->bdid'>" . $brnd->bdcd . " - " . $brnd->bdnm . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-md-4  control-label">Type</label>
                    <div class="col-md-8 ">
                        <select class="bs-select" name="typs" id="typs"
                                onchange="chckBtn(this.value,this.id)">
                            <option value="all">All Types</option>
                            <?php
                            foreach ($type as $typ) {
                                echo "<option value='$typ->tpid'>" . $typ->tpcd . " - " . $typ->tpnm . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 col-xs-12 control-label"><br></label>
                    <div class="col-md-8 col-xs-12">
                        <button class="btn btn-sm btn-primary btn-rounded btn-icon-fixed pull-right"
                                onclick="srchStck()"><span
                                    class="fa fa-search"></span>Search
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="block">
        <div class="row form-horizontal">
            <div class="table-responsive">
                <table class="table datatable table-bordered table-striped"
                       id="dataTbStck" width="100%">
                    <thead>
                    <tr>
                        <th class="text-left"> NO</th>
                        <th class="text-left"> STK NO</th>
                        <th class="text-left"> SUPPLY</th>
                        <th class="text-left"> ITEM</th>
                        <th class="text-left"> COST</th>
                        <th class="text-left"> FACE</th>
                        <th class="text-left"> SALE</th>
                        <th class="text-left"> QTY</th>
                        <th class="text-left success" title="FREE QUANTITY"> FR QTY</th>
                        <th class="text-left"> AVQT</th>
                        <th class="text-left"> CR DATE</th>
                        <th class="text-left"> STATUS</th>
                        <th class="text-left"> OPTION</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                    <th colspan="4"></th>
                    <th>0.00</th>
                    <th>0.00</th>
                    <th>0.00</th>
                    <th>00</th>
                    <th>00</th>
                    <th>00</th>
                    <th colspan="3"></th>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- MODAL ADD NEW SUPPLIER -->
    <div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modal-default-header">
        <div class="modal-dialog modal-lg" role="document" style="width: 90%">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="icon-cross"></span>
            </button>
            <form id="addForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> Stock Add
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row form-horizontal">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Supplier Name <span class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-6 col-xs-6">
                                            <select class="bs-select" name="spid" id="spid"
                                                    onchange="chckBtn(this.value,this.id);loadGrn(this.value,'grid','grid_cont')">
                                                <option value="0"> -- Select Supplier --</option>
                                                <?php
                                                foreach ($supplier as $spply) {
                                                    echo "<option value='$spply->spid'>$spply->spcd - $spply->spnm</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label"> GRN No <span class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-6 col-xs-6" id="grid_cont">
                                            <select class="bs-select" name="grid" id="grid"
                                                    onchange="chckBtn(this.value,this.id);getGrndet(this.value)">
                                                <option value="0"> -- Select GRN --</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label"> Stock Warehouse</label>
                                        <div class="col-md-6 col-xs-6">
                                            <input type="text" class="form-control" id="whnm" name="whnm"
                                                   readonly>
                                            <input type="hidden" class="form-control" id="whid" name="whid">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-horizontal">
                                <h5 class="text-title"><span class="fa fa-tag"></span> GRN Details</h5>
                            </div>
                            <div class="row form-horizontal">
                                <div class="col-md-12">
                                    <div class="table-responsive" style="padding: 10px 25px 10px 10px ">
                                        <table class="table dataTable table-bordered table-striped" id="grnTbl"
                                               style="width: 100%">
                                            <thead>
                                            <tr>
                                                <th width="" class="text-left">NO</th>
                                                <th width="" class="text-left">CODE</th>
                                                <th width="" class="text-left">ITEM NAME</th>
                                                <th width="" class="text-left">QTY</th>
                                                <th width="" class="text-left info"
                                                    title="FREE QUANTITY">FR QTY
                                                </th>
                                                <th width="" class="text-left">UNIT PRC</th>
                                                <th width="" class="text-left">PRC + TAX</th>
                                                <th width="" class="text-left">COST</th>
                                                <th width="" class="text-left">SALES</th>
                                                <th width="" class="text-left">DISPLAY</th>
                                                <th width="" class="text-left">MARKET</th>
                                                <th width="" class="text-left">REMARKS</th>
<!--                                                <th width="" class="text-left">BULK STOCK</th>-->
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                            <th colspan="3"></th>
                                            <th id="ttlQt">00</th>
                                            <th id="ttlFr">00</th>
                                            <th colspan="7"></th>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <input type="hidden" id="leng" name="leng">
                                    <input type="hidden" id="ttlQt2" name="ttlQt2">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="pull-left">
                            <span class="fa fa-hand-o-right"></span> <label style="color: red"> <span
                                        class="fa fa-asterisk req-astrick"></span> Required Fields </label>
                        </div>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                        <button type="button" id="addBtn" class="btn btn-warning btn-sm btn-rounded">Submit
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
                        <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> Supplier
                            Registering <span class="text-muted" id="subTitle_edit"></span></h4>
                        <input type="hidden" id="func" name="func"/>
                        <input type="hidden" id="spid" name="spid"/>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="form-horizontal">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Supplier Name <span
                                                    class="fa fa-asterisk req-astrick edit_req"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input class="form-control" type="text" name="name_edt" id="name_edt"
                                                   placeholder="Supplier Name"/>
                                        </div>
                                    </div>
                                    <div class="form-group view_Area">
                                        <label class="col-md-4 col-xs-12 control-label">Supplier Code</label>
                                        <label class="col-md-8 col-xs-12 control-label" id="code"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Address <span
                                                    class="fa fa-asterisk req-astrick edit_req"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                        <textarea class="form-control" name="addr_edt" id="addr_edt"
                                                  placeholder="Supplier Address"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Contact <span
                                                    class="fa fa-asterisk req-astrick edit_req"></span></label>
                                        <div class="col-md-4 col-xs-12">
                                            <input class="form-control" type="text" name="mobi_edt" id="mobi_edt"
                                                   placeholder="Mobile"/>
                                        </div>
                                        <div class="col-md-4 col-xs-12">
                                            <input class="form-control" type="text" name="tele_edt" id="tele_edt"
                                                   placeholder="Land Tele."/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Email <span
                                                    class="fa fa-asterisk req-astrick edit_req"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input class="form-control" type="email" name="email_edt" id="email_edt"
                                                   placeholder="Email"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <lable class="col-md-4 col-xs-12 control-label">Bank Details</lable>
                                        <div class="col-md-4 col-xs-12">
                                            <label class="switch">
                                                No <input type="checkbox" value="1" id="bnkDtlEdt" name="bnkDtlEdt"
                                                          onchange="loadBnkDitEdt()">
                                            </label> Yes
                                        </div>

                                        <div id="bankDtilEdt" style="display: none">
                                            <div id="edit_Area" class="col-md-4">
                                                <button type="button"
                                                        class="btn btn-xs btn-info btn-rounded btn-icon-fixed pull-right"
                                                        data-toggle="modal" data-target="#modal-Bank-New">
                                                    <span class="fa fa-plus"></span> Add
                                                </button>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table id="supp_Bank"
                                                           class="table dataTable table-striped table-bordered"
                                                           width="100%">
                                                        <thead>
                                                        <tr>
                                                            <th class="text-left">BANK</th>
                                                            <th class="text-left">BRANCH</th>
                                                            <th class="text-left">ACCOUNT NO.</th>
                                                            <th class="text-left">ACTION</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Remark</label>
                                        <div class="col-md-8 col-xs-12">
                                        <textarea class="form-control" rows="5" name="remk_edt" id="remk_edt"
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
                        <button type="button" id="app_sup_btn" class="btn btn-warning btn-sm btn-rounded">
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END VIEW SUPPLIER -->

    <script type="text/javascript">
        $().ready(function () {

            //VALIDATION INIT
            $("#addForm").validate({
                rules: {
                    spid: {
                        required: true,
                        notEqual: '0'
                    },
                    grid: {
                        required: true,
                        notEqual: '0'
                    },
                    'csvl[]': {
                        required: true,
                        currency: true,
                        notEqual: '0',
                    },
                    'slvl[]': {
                        required: true,
                        currency: true,
                        notEqual: '0',
                    },
                    'dsvl[]': {
                        required: true,
                        currency: true,
                        notEqual: '0',
                    },
                    'mkvl[]': {
                        currency: true,
                        notEqual: '0',
                    }
                },
                messages: {
                    spid: {
                        required: 'Please select supply',
                        notEqual: 'Please select supply'
                    },
                    grid: {
                        required: 'Please select GRN',
                        notEqual: 'Please select GRN' // currency: true,
                    },
                    'csvl[]': {
                        required: 'Please enter cost value',
                        notEqual: "Can't enter zero value"
                    },
                    'slvl[]': {
                        required: 'Please enter sales value',
                        notEqual: "Can't enter zero value"
                    },
                    'dsvl[]': {
                        required: 'Please enter face value',
                        notEqual: "Can't enter zero value"
                    },
                    'mkvl[]': {
                        notEqual: "Can't enter zero value"
                    },
                }
            });

            //Table INIT
            $('#grnTbl').DataTable({
                destroy: true,
                searching: false,
                bPaginate: false,
                "ordering": false,
                "columnDefs": [
                    {className: "text-left", "targets": [1, 2]},
                    {className: "text-center", "targets": [0,7, 8, 9, 10]},
                    {className: "text-right", "targets": [3, 4, 5, 6, 11]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                "aoColumns": [
                    {sWidth: '3%'},
                    {sWidth: '8%'},    //
                    {sWidth: '20%'},    //
                    {sWidth: '5%'},     //
                    {sWidth: '5%'},
                    {sWidth: '7%'},
                    {sWidth: '7%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    // {sWidth: '5%'}
                ]
            });
            srchStck();
        });

        function srchStck() {
            var cat = document.getElementById('cats').value;   //CATEGORY
            var brnd = document.getElementById('brnds').value;   //BRAND
            var typ = document.getElementById('typs').value;   //MODE
            var stat = document.getElementById('stats').value;   //STAT

            $('#dataTbStck').DataTable().clear();
            $('#dataTbStck').DataTable({
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
                    {className: "text-left", "targets": [1, 2, 3]},
                    {className: "text-center", "targets": [0, 10, 11, 12]},
                    {className: "text-right", "targets": [4, 5, 6, 7, 8, 9]},
                    {className: "text-nowrap", "targets": [2,3]}
                ],
                "aoColumns": [
                    {sWidth: '3%'},
                    {sWidth: '5%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '10%'}
                ],
                "ajax": {
                    url: '<?= base_url(); ?>Stock/srchStck',
                    type: 'post',
                    data: {
                        cat: cat,
                        brnd: brnd,
                        typ: typ,
                        stat: stat,
                    }
                },
                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api(), data;
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                    //COLUMN 4 TTL
                    var t4 = api.column(4).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(4).footer()).html(numeral(t4).format('0,0.00'));
                    //COLUMN 5 TTL
                    var t5 = api.column(5).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(5).footer()).html(numeral(t5).format('0,0.00'));
                    //COLUMN 6 TTL
                    var t6 = api.column(6).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(6).footer()).html(numeral(t6).format('0,0.00'));
                    //COLUMN 7 TTL
                    var t7 = api.column(7).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(7).footer()).html(numeral(t7).format('00'));
                    //COLUMN 8 TTL
                    var t8 = api.column(8).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(8).footer()).html(numeral(t8).format('00'));
                    //COLUMN 9 TTL
                    var t9 = api.column(9).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(9).footer()).html(numeral(t9).format('00'));

                },
            });
        }

        // GET GRN DETAILS
        function loadGrn(spid, html, mhtml) {
            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>Stock/getGrn",
                data: {
                    spid: spid
                },
                dataType: 'json',
                success: function (response) {
                    var len = response.length;
                    var child1 = $('#' + mhtml).children();
                    var child2 = child1.find('div').children();
                    child2.empty();
                    // TABLE SEARCH FILTER
                    if (len != 0) {
                        $('#' + html).empty();
                        $('#' + html).append("<option value='0'>-- Select GRN --</option>");
                        child2.append("<li data-original-index=\"0\"><a tabindex=\"0\" class=\"\" data-tokens=\"null\" role=\"option\" aria-disabled=\"false\" aria-selected=\"true\"><span class=\"text\">-- Select GRN --\n" +
                            "</span><span class=\" fa fa-check check-mark\"></span></a></li>");
                        for (var a = 0; a < len; a++) {
                            var id = response[a]['grid'];
                            var name = response[a]['grdt'] + " - " + response[a]['grno'];
                            var $el = $('#' + html);
                            $el.append($("<option></option>")
                                .attr("value", id).text(name));

                            child2.append("<li data-original-index=\"" + (a + 1) + "\"><a tabindex=\"0\" class=\"\" data-tokens=\"null\" role=\"option\" aria-disabled=\"false\" aria-selected=\"true\"><span class=\"text\">" + name + "\n" +
                                "</span><span class=\" fa fa-check check-mark\"></span></a></li>");
                        }
                        //document.getElementById('brnmEdt').value = 15;
                    } else {
                        $('#' + html).empty();
                        $('#' + html).append("<option value='0'>-- No GRN --</option>");
                        child2.append("<li data-original-index=\"0\" class=\"\"><a tabindex=\"0\" class=\"\" data-tokens=\"null\" role=\"option\" aria-disabled=\"false\" aria-selected=\"false\"><span class=\"text\">-- No GRN --</span><span class=\" fa fa-check check-mark\"></span></a></li>");
                    }
                    default_Selector(child1.find('div'));
                }
            });
        }

        // GRN DETAILS TABLE
        function getGrndet(grid) {

            $('#grnTbl').DataTable().clear();
            var t = $('#grnTbl').DataTable({
                destroy: true,
                searching: false,
                bPaginate: false,
                "ordering": false,
                "columnDefs": [
                    {className: "text-left", "targets": [1, 2]},
                    {className: "text-center", "targets": [0, 7, 8, 9, 10]},
                    {className: "text-right", "targets": [3, 4, 5, 6, 11]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                "aoColumns": [
                    {sWidth: '3%'},
                    {sWidth: '8%'},    //
                    {sWidth: '20%'},    //
                    {sWidth: '5%'},     //
                    {sWidth: '5%'},
                    {sWidth: '7%'},
                    {sWidth: '7%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    // {sWidth: '5%'}
                ],
                "rowCallback": function (row, data, index) {
                },
                // "order": [[5, "ASC"]], //ASC  desc
            });

            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>Stock/getGrnDet",
                data: {
                    grid: grid
                },
                dataType: 'json',
                success: function (response) {

                    var len = response['grn'].length;
                    var grn = response['grn'];
                    var len2 = response['grnd'].length;
                    var grnd = response['grnd'];
                    document.getElementById('leng').value = len2;

                    if (len > 0) {
                        document.getElementById('whnm').value = grn[0]['whcd'] + ' - ' + grn[0]['whnm'];
                        document.getElementById('whid').value = grn[0]['whid'];

                        var ttlqt = 0;
                        var ttlfr = 0;
                        for (var a = 0; a < len2; a++) {
                            var txunt = +grnd[a]['untp'] + ((+grnd[a]['untp'] * +grn[a]['rate']) / 100);

                            t.row.add([
                                a + 1,
                                grnd[a]['itcd'] + '<input type="hidden" name="itid[]" value="' + grnd[a]['itid'] + '">',// ITEM CODE
                                grnd[a]['itnm'] + '<input type="hidden" name="gdid[]" value="' + grnd[a]['gdid'] + '">',                                                                            // ITEM NAME
                                numeral(grnd[a]['qnty']).format('0,0') + '<input type="hidden" name="qunt[]" value="' + grnd[a]['qnty'] + '">',                            // ODR QUNT
                                numeral(grnd[a]['frqt']).format('0,0') + '<input type="hidden" name="frqt[]" value="' + grnd[a]['frqt'] + '">',                            // ODR QUNT
                                numeral(grnd[a]['untp']).format('0,0.00') + '<input type="hidden" id="untp' + a + '" name="untp[]" value="' + grnd[a]['untp'] + '" >',                          // PRICE
                                numeral(txunt).format('0,0.00') + '<input type="hidden" id="txpr_' + a + '" name="txpr[]" value="' + txunt + '" >',  // UNIT PRICE + TAX
                                '<input readonly type="text" class="form-control" style="text-align:right; width: 100px" id="csvl_' + a + '" name="csvl[]" value="' + txunt + '" onkeyup="chkVal(this.value,' + a + ',' + " 'cost'" + ')">',        // COST VALUE
                                '<span class="fa fa-asterisk req-astrick"></span> ' +
                                '<input type="text" class="form-control" style="text-align:right; width: 100px" id="slvl_' + a + '" name="slvl[]" onkeyup="chkVal(this.value,' + a + ',' + " 'sale'" + ')">',        // SALES VALUE
                                '<span class="fa fa-asterisk req-astrick"></span> ' +
                                '<input type="text" class="form-control" style="text-align:right; width: 100px" id="dsvl_' + a + '" name="dsvl[]" onkeyup="chkVal(this.value,' + a + ',' + " 'disp'" + ')">',        // DISPLAY VALUE
                                '<input type="text" class="form-control" style="text-align:right; width: 100px" id="mkvl_' + a + '" name="mkvl[]" onkeyup="chkVal(this.value,' + a + ',' + " 'mark'" + ')">',        // MARKET VALUE
                                '<input type="text" class="form-control" name="rmks[]" style="width: 100px"/>'                  // REMARKS
                                // '<label><input type="checkbox" name="blsk[' + a + ']"  id="checkbox-1"  class="icheckbox 0"/></label>'
                            ]).draw(false);

                            ttlqt = +ttlqt + +grnd[a]['qnty'];
                            ttlfr = +ttlfr + +grnd[a]['frqt'];
                        }
                        document.getElementById('ttlQt').innerHTML = ttlqt;
                        document.getElementById('ttlQt2').value = ttlqt;
                        document.getElementById('ttlFr').innerHTML = ttlfr;

                        document.getElementById('addBtn').disabled = false;

                    } else {
                        document.getElementById('ttlQt').innerHTML = 0;
                        document.getElementById('ttlQt2').value = 0;
                        document.getElementById('ttlFr').innerHTML = 0;
                        document.getElementById('addBtn').disabled = true;
                    }

                }
            });
        }

        // CHECK & COMPARE OTHER VALUE
        function chkVal(typvl, lpid, type) {

            var txpr = parseInt(document.getElementById('txpr_' + lpid).value);     // TAX + PRICE
            var csvl = parseInt(document.getElementById('csvl_' + lpid).value);     // COST
            var slvl = parseInt(document.getElementById('slvl_' + lpid).value);     // SALES
            var dsvl = parseInt(document.getElementById('dsvl_' + lpid).value);     // DISPLY
            var mkvl = parseInt(document.getElementById('mkvl_' + lpid).value);     // MARKET

            //console.log('typvl ' + typvl + ' txpr ' + txpr + ' csvl ' + csvl + ' slvl ' + slvl + ' dsvl ' + dsvl + ' mkvl ' + mkvl);

            if (type == 'cost') {
                if (txpr > typvl) {
                    document.getElementById('csvl_' + lpid).style.borderColor = "red";
                    document.getElementById('addAcc').disabled = true;

                } else {
                    document.getElementById('csvl_' + lpid).style.borderColor = '';
                    document.getElementById('addBtn').disabled = false;
                }
            } else if (type == 'sale') {
                if (csvl > typvl) {
                    document.getElementById('slvl_' + lpid).style.borderColor = "red";
                    document.getElementById('addBtn').disabled = true;
                } else {
                    document.getElementById('slvl_' + lpid).style.borderColor = '';
                    document.getElementById('addBtn').disabled = false;
                }
            } else if (type == 'disp') {
                if (slvl > typvl) {
                    document.getElementById('dsvl_' + lpid).style.borderColor = "red";
                    document.getElementById('addBtn').disabled = true;
                } else {
                    document.getElementById('dsvl_' + lpid).style.borderColor = '';
                    document.getElementById('addBtn').disabled = false;
                }
            }
            /*else if (type == 'mark') {
             if (mkvl > typvl) {
             document.getElementById('mkvl_' + lpid).style.borderColor = "red";
             } else {
             document.getElementById('mkvl_' + lpid).style.borderColor = '';
             }
             }*/
        }

        //ADD STOCK
        $('#addBtn').click(function (e) {
            e.preventDefault();
            if($('#addForm').valid()){
                $('#addBtn').prop('disabled', true);
                swal({
                    title: "Processing...",
                    text: "Stock Adding...",
                    imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                    showConfirmButton: false
                });
                jQuery.ajax({
                    type: "POST",
                    url: "<?= base_url(); ?>Stock/addStock",
                    data: $("#addForm").serialize(),
                    dataType: 'json',
                    success: function (data) {
                        swal({title: "", text: "Stock Added!", type: "success"},
                            function () {
                                $('#addBtn').prop('disabled', false);
                                clear_Form('addForm');
                                $('#modal-add').modal('hide');
                                srchStck();
                            });
                    },
                    error: function () {
                        swal({title: "", text: "Stock Adding Failed !", type: "error"},
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
