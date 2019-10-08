<script type="text/javascript" src="<?= base_url(); ?>assets/js/custom-js/full_width.js"></script>

<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">Stock Access</a></li>
        <li class="active">Good Received Note (GRN)</li>
    </ul>
</div>
<div class="app-heading app-heading-bordered app-heading-page">
    <div class="icon icon-lg">
        <span class="fa fa-user" style="color: #e69c0f;"></span>
    </div>
    <div class="title">
        <h1>Good Received Note (GRN)</h1>
        <p>Register / Edit / Reject / Deactive / Search & View</p>
    </div>
    <?php
    if ($funcPerm[0]->inst == 1) { ?>
        <div class="pull-right">
            <button class="btn btn-sm btn-info btn-icon-fixed btn-rounded" data-toggle="modal" data-target="#modal-add">
                <span class="fa fa-plus"></span>New GRN
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
                    <label class="col-md-4 col-xs-12 control-label">Supply</label>
                    <div class="col-md-8 col-xs-12">
                        <select id="supl" name="supl" class="bs-select" onchange="chckBtn(this.value,this.id)">
                            <option value="0">-- Select Supply --</option>
                            <option value="all">All Supply</option>
                            <?php
                            foreach ($supplyInfo as $supp) {
                                echo "<option value='$supp->spid'>" . $supp->spcd . " - " . $supp->spnm . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-md-4 col-xs-12 control-label">Date Range</label>
                    <div class="col-md-8 col-xs-12">
                        <div class='input-group'>
                            <input type='text' class="form-control dateranger" id="dtrng" name="dtrng"
                                   value="<?= date('Y-m-d') ?> / <?= date('Y-m-d') ?>"/>
                            <span class="input-group-addon">
                                <span class="fa fa-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-md-4 col-xs-12 control-label">Status</label>
                    <div class="col-md-8 col-xs-12">
                        <select id="stat" name="stat" class="bs-select">
                            <option value="all">All</option>
                            <option value="0">Pending</option>
                            <option value="1">Active</option>
                            <option value="3">Inactive</option>
                            <option value="2">Reject</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 col-xs-12 control-label"><br></label>
                    <div class="col-md-8 col-xs-12">
                        <button class="btn btn-sm btn-primary btn-rounded btn-icon-fixed pull-right"
                                onclick="srchGrn()">
                            <span class="fa fa-search"></span>Search
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="block">
        <div class="row form-horizontal">
            <div class="table-responsive">
                <table id="grnTable" class="table dataTable table-striped table-bordered" width="100%">
                    <thead>
                    <tr>
                        <th class="text-left">#</th>
                        <th class="text-left">GRN NO</th>
                        <th class="text-left">SUPPLY</th>
                        <th class="text-left">PO NO</th>
                        <th class="text-left">GRN DATE</th>
                        <th class="text-left">ODR QTY</th>
                        <th class="text-left">FRE QTY</th>
                        <th class="text-left">RCV QTY</th>
                        <th class="text-left">RTN QTY</th>
                        <th class="text-left">STATUS</th>
                        <th class="text-left">CR DATE</th>
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
        <div class="modal-dialog modal-lg" role="document" style="width: 90%">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="icon-cross"></span>
            </button>
            <form id="addForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> GRN & GRRN
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="container">

                            <div class="row form-horizontal">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-6 col-xs-12 control-label">Supplier Name <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-6 col-xs-12" id="">
                                            <select id="suplSrc" name="suplSrc" class="bs-select"
                                                    onchange="chckBtn(this.value,this.id);loadPo(this.value,'podt','poDiv')">
                                                <option value="0">-- Select Supply --</option>
                                                <?php
                                                foreach ($supplyInfo as $supp) {
                                                    echo "<option value='$supp->spid'>" . $supp->spcd . " | " . $supp->spnm . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6 col-xs-12 control-label">GRN Date <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-6 col-xs-12">
                                            <input class="form-control datetimepicker" type="text" name="grdt" id="grdt"
                                                   placeholder="" readonly value="<?= date('Y-m-d'); ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-6 col-xs-12 control-label">Reference Details (PO) <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-6 col-xs-12" id="poDiv">
                                            <select id="podt" name="podt" class="bs-select"
                                                    onchange="chckBtn(this.value,this.id);getPodet(this.value) ">
                                                <option value="0">-- Select Po --</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6 col-xs-12 control-label">Delivery Warehouse <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-6 col-xs-12" id="">
                                            <select id="whsid" name="whsid" class="bs-select"
                                                    onchange="chckBtn(this.value,this.id)">
                                                <option value="0">-- Select Warehouse --</option>
                                                <?php
                                                foreach ($whouseInfo as $whouse) {
                                                    echo "<option value='$whouse->whid'>" . $whouse->whcd . " | " . $whouse->whnm . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="row form-horizontal">
                                <h5 class="text-title"><span class="fa fa-tag"></span> PO Details</h5>
                            </div>
                            <div class="row form-horizontal">
                                <div class="col-md-12">
                                    <div class="table-responsive" style="padding: 10px 25px 10px 10px ">
                                        <table class="table dataTable table-striped table-bordered" id="grnTbl"
                                               style="width: 100%">
                                            <thead>
                                            <tr>
                                                <th width="" class="text-center">NO</th>
                                                <th width="" class="text-center">CODE</th>
                                                <th width="" class="text-center">ITEM NAME</th>
                                                <th width="" class="text-center">UNIT PRICE</th>
                                                <th width="" class="text-center">ORDER QTY</th>
                                                <th width="" class="text-center">FREE QTY</th>
                                                <th width="" class="text-center">RECEIVE QTY</th>
                                                <th width="" class="text-center">TOTAL PRICE</th>
                                                <th width="" class="text-center">RETURN QTY</th>
                                                <th width="" class="text-center">RETURN RMK</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                            <th colspan="4"></th>
                                            <th id="ttlQt"></th>
                                            <th id="ttlFr"></th>
                                            <th id="ttlGd"></th>
                                            <th id="ttlPrc"></th>
                                            <th id="ttlBd"></th>
                                            <th></th>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <input type="hidden" id="leng" name="leng">
                                    <input type="hidden" id="ttlQt2" name="ttlQt2">
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-5  control-label">Remarks </label>
                                        <div class="col-md-7">
                                            <textarea class="form-control" name="remk" id="remk"
                                                      rows="6" placeholder="Remarks"> </textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-5  control-label">Check By</label>
                                        <div class="col-md-7 col-xs-12">
                                            <input type="text" class="form-control"
                                                   name="chkby" id="chkby"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">ORDER QTY</label>
                                        <div class="col-md-6 col-xs-12">
                                            <input class="form-control" type="text" name="odrqt" id="odrqt" readonly/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">FREE QTY</label>
                                        <div class="col-md-6 col-xs-12">
                                            <input class="form-control" type="text" name="tfrqt" id="tfrqt" readonly/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">RECEIVE QTY</label>
                                        <div class="col-md-6 col-xs-12">
                                            <input class="form-control" type="text" name="rcvqt" id="rcvqt" readonly/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">RETURN QTY </label>
                                        <div class="col-md-6 col-xs-12">
                                            <input class="form-control" type="text" name="rtnqt" id="rtnqt" readonly/>
                                        </div>
                                    </div>


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
            //Table Initializing
            $('#grnTable').DataTable({
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
                    suplSrc: {
                        required: true,
                        notEqual: 0
                    },
                    podt: {
                        required: true,
                        notEqual: 0
                    },
                    whsid: {
                        required: true,
                        notEqual: 0
                    },

                    odrqt: {
                        required: true,
                        notEqual: 0,
                        digits:true
                    },
                    tfrqt: {
                        required: true,
                        notEqual: 0,
                        digits:true
                    },
                    rcvqt: {
                        required: true,
                        notEqual: 0,
                        digits:true
                    },
                    rtnqt: {
                        required: true,
                        notEqual: 0,
                        digits:true
                    },
                    chkby: {
                        required: true,
                        notEqual: 0
                    },

                },
                messages: {
                    name: {
                        required: "Enter supplier name",
                        remote: "Already entered name"
                    },
                    addr: {
                        required: "Enter supplier address"
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
                    bnknm: {
                        notEqual: "Select a bank"
                    },
                    bnkbr: {
                        notEqual: "Select a bank branch"
                    },
                    acno: {
                        required: "Enter bank account number",
                        digits: "Only numbers are allowed",
                        minlength: "Minumum length is 8 digits",
                        remote: "This account number is already added"
                    }
                }
            });

            $('#app_sup_form').validate({
                rules: {
                    name_edt: {
                        required: true,
                        remote: {
                            url: "<?= base_url(); ?>Stock/chk_spName",
                            type: "post",
                            data: {
                                name: function () {
                                    return $("#name_edt").val();
                                },
                                spid: function () {
                                    return $("#spid").val();
                                },
                                stat: 1
                            }
                        }
                    },
                    addr_edt: {
                        required: true
                    },
                    mobi_edt: {
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
                    tele_edt: {
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
                    email_edt: {
                        required: true,
                        email: true
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

            srchGrn();
        });

        // Get supply PO Details
        function loadPo(supid, html, mhtml) {
            $.ajax({
                url: '<?= base_url(); ?>Stock/getPodet',
                type: 'post',
                data: {
                    supid: supid,
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
                        $('#' + html).append("<option value='0'>-- Select A Po Details --</option>");
                        child2.append("<li data-original-index=\"0\"><a tabindex=\"0\" class=\"\" data-tokens=\"null\" role=\"option\" aria-disabled=\"false\" aria-selected=\"true\"><span class=\"text\">-- Select A Po Details --\n" +
                            "</span><span class=\" fa fa-check check-mark\"></span></a></li>");
                        for (var a = 0; a < len; a++) {
                            var id = response[a]['poid'];
                            var name = response[a]['oddt'] + " - " + response[a]['pono'];
                            var $el = $('#' + html);
                            $el.append($("<option></option>")
                                .attr("value", id).text(name));

                            child2.append("<li data-original-index=\"" + (a + 1) + "\"><a tabindex=\"0\" class=\"\" data-tokens=\"null\" role=\"option\" aria-disabled=\"false\" aria-selected=\"true\"><span class=\"text\">" + name + "\n" +
                                "</span><span class=\" fa fa-check check-mark\"></span></a></li>");
                        }
                        //document.getElementById('brnmEdt').value = 15;
                    } else {
                        $('#' + html).empty();
                        $('#' + html).append("<option value='0'>-- No Po Details --</option>");
                        child2.append("<li data-original-index=\"0\" class=\"\"><a tabindex=\"0\" class=\"\" data-tokens=\"null\" role=\"option\" aria-disabled=\"false\" aria-selected=\"false\"><span class=\"text\">-- No Po Details --</span><span class=\" fa fa-check check-mark\"></span></a></li>");
                    }
                    default_Selector(child1.find('div'));
                }
            });
        }

        // PO DETAILS TABLE
        function getPodet(poid) {

            $('#grnTbl').DataTable().clear();
            var t = $('#grnTbl').DataTable({
                destroy: true,
                searching: false,
                bPaginate: false,
                "ordering": false,
                "columnDefs": [
                    {className: "text-left", "targets": [1, 2]},
                    {className: "text-center", "targets": [0]},
                    {className: "text-right", "targets": [3, 4, 5, 6, 7, 8]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                "aoColumns": [
                    {sWidth: '2%'},
                    {sWidth: '5%'},    // br
                    {sWidth: '17%'},    // cnt
                    {sWidth: '5%'},     //
                    {sWidth: '4%'},
                    {sWidth: '4%'},
                    {sWidth: '4%'},
                    {sWidth: '6%'},
                    {sWidth: '4%'},
                    {sWidth: '10%'}
                ],
                "rowCallback": function (row, data, index) {
                },
                // "order": [[5, "ASC"]], //ASC  desc
            });

            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>Stock/getPodetils",
                data: {
                    poid: poid
                },
                dataType: 'json',
                success: function (response) {
                    // IF CHECK ALREDY ADD GRN OR NOT
                    if (response['grndt'].length > 0) {
                        $('#whid').val(0);
                        document.getElementById('ttlQt').innerHTML = '';
                        swal({title: "", text: "This Po Already Added GRN", type: "warning"},);

                    } else {
                        var len = response['podet'].length;
                        $('#leng').val(len);
                        set_select('whsid', response['podet'][0]['whid'])

                        var ttlqt = 0;
                        for (var a = 0; a < len; a++) {
                            t.row.add([
                                a + 1,
                                response['podet'][a]['itcd'] + '<input type="text" name="itid[]" value="' + response['podet'][a]['itid'] + '">',       // ITEM CODE
                                response['podet'][a]['itnm'],                                                    // ITEM NAME
                                numeral(response['podet'][a]['untp']).format('0,0.00') + '<input type="text" name="untp[]" value="' + response['podet'][a]['untp'] + '" >',                          // PRICE
                                numeral(response['podet'][a]['qnty']).format('0,0') + '<input type="text" name="odrQty[]" value="' + response['podet'][a]['qnty'] + '">',                            // ODR QUNT
                                '<input type="text" size="4" class="form-control" id="grfr_' + a + '" name="grfr[]" onkeyup="calFrQty(this.value)" style="text-align:right;">',                                                           // RCV QTY
                                '<input type="text" size="4" class="form-control dfg" id="grgd_' + a + '" name="grgd[]" onkeyup="calQty( ' + response['podet'][a]['qnty'] + ',this.value,' + a + ',' + response['podet'][a]['untp'] + ')" style="text-align:right;">',       // RCV QTY
                                '<label id="grTprc_' + a + '">' + numeral(0).format('0,0.00') + '</label><input type="text" value="0" name="grhTprc[]" id="grhTprc_' + a + '">', //total price of items
                                '<input type="text" class="form-control" id="grbd_' + a + '" name="grbd[]" readonly size="4" style="text-align:right;">',      // RTN QTY
                                '<input type="text" class="form-control" name="rtnRmk[]">',             // RTN REMK

                            ]).draw(false);
                            ttlqt = +ttlqt + +response['podet'][a]['qnty'];
                        }
                        $('#ttlQt').html(ttlqt);
                        $('#ttlQt2').val(ttlqt);
                    }
                }
            });
        }

        // CAL FREE QUENTY
        function calFrQty(qnty, gd, lpid) {
            var ttlFr = 0;
            $("input[name='grfr[]']").each(function () {
                ttlFr = ttlFr + +this.value;
            });
            $('#ttlFr').html(ttlFr);
            $('#tfrqt').val(ttlFr);
        }

        // GRN & GRRN QTY
        function calQty(qnty, gd, lpid, untp) {
            //console.log(qnty + ' * ' + gd + ' lpid ' + lpid);
            if (gd > qnty) {
                document.getElementById('grgd_' + lpid).style.borderColor = "red";
            } else {
                document.getElementById('grgd_' + lpid).style.borderColor = '';
                document.getElementById('grbd_' + lpid).value = +qnty - +gd;
                document.getElementById('grTprc_' + lpid).innerHTML = numeral((+gd) * untp).format('0,0.00');
                document.getElementById('grhTprc_' + lpid).value = (+gd) * untp;
            }

            var ttlGd = 0;
            var ttlBd = 0;
            var ttlPRC = 0.00;
            $("input[name='grgd[]']").each(function () {
                ttlGd = ttlGd + +this.value;
            });
            $("input[name='grbd[]']").each(function () {
                ttlBd = ttlBd + +this.value;
            });
            $("input[name='grhTprc[]']").each(function () {
                ttlPRC = ttlPRC + +this.value;
            });

            var ttlQt = document.getElementById('ttlQt2').value;
            if (ttlGd > ttlQt) {
                document.getElementById("addBtn").setAttribute("class", "hidden");
            } else {
                document.getElementById("addBtn").removeAttribute("class");
                document.getElementById("addBtn").setAttribute("class", "btn btn-warning btn-sm btn-rounded");
            }
            //document.getElementById('ttlPrc').innerHTML = numeral(ttlPRC).format('0,0.00');
            $('#ttlGd').html(ttlGd);
            $('#ttlBd').html(ttlBd);
            $('#ttlPrc').html(numeral(ttlPRC).format('0,0.00'));

            $('#odrqt').val(ttlQt);
            $('#rcvqt').val(ttlGd);
            $('#rtnqt').val(ttlBd);
        }


        //Add New Supplier
        $('#addBtn').click(function (e) {
            e.preventDefault();
            if ($('#addForm').valid()) {
                $('#addBtn').prop('disabled', true);
                swal({
                    title: "Processing...",
                    text: "GRN's data saving..",
                    imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                    showConfirmButton: false
                });

                jQuery.ajax({
                    type: "POST",
                    url: "<?= base_url(); ?>Stock/addGrndet",
                    data: $("#addForm").serialize(),
                    dataType: 'json',
                    success: function (data) {
                        swal({title: "", text: "GRN Added Success!", type: "success"},
                            function () {
                               $('#addBtn').prop('disabled', false);
                               clear_Form('addForm');
                               $('#modal-add').modal('hide');
                                srchGrn();
                            });
                    },
                    error: function (data, textStatus) {
                        swal({title: "GRN Added Failed", text: textStatus, type: "error"},
                            function () {
                               location.reload();
                            });
                    }
                });
            }
        });

        //Search Suppliers
        function srchGrn() {
            var stat = $('#stat').val();
            var supl = $('#supl').val();
            var dtrng = $('#dtrng').val();

            chckBtn(supl,'supl');

            if(supl != 0 ){
                $('#grnTable').DataTable().clear();
                $('#grnTable').DataTable({
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
                        {sWidth: '10%'}, //Address
                        {sWidth: '10%'}, //Mobile
                        {sWidth: '5%'}, //Created By
                        {sWidth: '5%'}, //Created date
                        {sWidth: '5%'}, //Created date
                        {sWidth: '5%'}, //Created date
                        {sWidth: '5%'}, //Created date
                        {sWidth: '5%'},  //Status
                        {sWidth: '12%'}  //Option
                    ],

                    "ajax": {
                        url: '<?= base_url(); ?>Stock/srchGrnDeti',
                        type: 'post',
                        data: {
                            stat: stat,
                            supl: supl,
                            dtrng: dtrng,
                        }
                    }
                });
            }
        }

        //View Supplier
        function viewSupp(id, func) {
            swal({
                title: "Loading Data...",
                text: "Supplier's Details",
                imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                showConfirmButton: false
            });

            $('#func').val(func);
            $('#spid').val(id);

            jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>Stock/get_SuppDet",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (data) {
                    if (func == 'view') {
                        //VIEW MODEL
                        $('#subTitle_edit').html(' - View');
                        $('#app_sup_btn').css('display', 'none');
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
                        $('#app_sup_btn').css('display', 'inline');
                        $('#app_sup_btn').html('Update');
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
                        $('#app_sup_btn').css('display', 'inline');
                        $('#app_sup_btn').html('Approve');
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
                    var len = data['spdet'].length;
                    var len2 = data['bkdet'].length;
                    var spdet = data['spdet'];
                    var bkdet = data['bkdet'];
                    if (len > 0) {
                        $('#name_edt').val(spdet[0]['spnm']);
                        $('#addr_edt').val(spdet[0]['addr']);
                        $('#mobi_edt').val(spdet[0]['mbno']);
                        $('#tele_edt').val(spdet[0]['tele']);
                        $('#email_edt').val(spdet[0]['email']);
                        $('#remk_edt').val(spdet[0]['dscr']);

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

                        if (spdet[0]['bkdt'] == 1) {
                            $('#bankDtilEdt').css("display", "block");
                            ($('#bnkDtlEdt').prop('checked', true));
                        } else {
                            $('#bankDtilEdt').css("display", "none");
                            ($('#bnkDtlEdt').prop('checked', false));
                        }
                    }

                    if (len2 > 0) {

                        $('#supp_Bank').DataTable().clear();
                        var t1 = $('#supp_Bank').DataTable({
                            "bInfo": false,
                            destroy: true,
                            searching: false,
                            bPaginate: false,
                            "ordering": false,
                            "columnDefs": [
                                {className: "text-right", "targets": []},
                                {className: "text-left", "targets": [0, 1, 2]},
                                {className: "text-center", "targets": [3]},
                                {className: "text-nowrap", "targets": [0, 1, 2]}
                            ],
                            "aoColumns": [
                                // {sWidth: '3%'},
                                {sWidth: '30%'},
                                {sWidth: '30%'},
                                {sWidth: '30%'},
                                {sWidth: '10%'}
                            ]
                        });

                        for (var ii = 0; ii < len2; ii++) {
                            if (bkdet[ii]['dfst'] == 1) {
                                var dfst = "<label class='label label-info' title='Default Account Number'>D</label> ";
                                var radio = "<div title='Default Account' class='app-radio round'><input type='radio'" +
                                    "onclick='desDefClose($(this))'" + des +
                                    " name='dfstRd[]' value='" + bkdet[ii]['acid'] + "' checked/></div>"
                                var defDes = 'disabled';
                            } else {
                                var dfst = "";
                                var radio = "<div class='app-radio round'><input type='radio'" +
                                    "onclick='desDefClose($(this))'" + des +
                                    " name='dfstRd[]' value='" + bkdet[ii]['acid'] + "'/></div>"
                                var defDes = '';
                            }

                            var bnknm = bkdet[ii]['bkcd'] + " - " + bkdet[ii]['bknm'];
                            var brnm = bkdet[ii]['brcd'] + " - " + bkdet[ii]['bcnm'];
                            var acc = dfst + bkdet[ii]['acno'];
                            var opt = "<button " + defDes + " " + des + " id='dltrw' class='btn btn-xs btn-warning btn-rounded btn_dlt_acc' title='Remove'><span class='fa fa-close'></span></button> " +
                                radio +
                                "<input type='hidden' id='acnoList' name='acnoList[]' value='" + bkdet[ii]['acid'] + "'/>";
                            t1.row.add([
                                // (ii+1),
                                bnknm,
                                brnm,
                                acc,
                                opt
                            ]).draw(false);
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

        //Disbled default account close button
        function desDefClose(node) {
            $('.btn_dlt_acc').prop('disabled', false);
            node.parent().prev().prop('disabled', true);
        }

        // table data remove
        $('#supp_Bank tbody').on('click', '#dltrw', function () {
            var table = $('#supp_Bank').DataTable();
            table
                .row($(this).parents('tr'))
                .remove()
                .draw();

            if (!table.data().count()) {
                $("#app_sup_btn").hide();
            } else {
                $("#app_sup_btn").show();
            }
        });

        //APPROVE || EDIT HERE
        $('#app_sup_btn').click(function (e) {
            e.preventDefault();

            var table = $('#supp_Bank').DataTable();
            //var row = table.rows().count();

            if (table.rows().count() > 0) {
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
                                        url: "<?= base_url(); ?>Stock/supp_update",
                                        data: $("#app_sup_form").serialize(),
                                        dataType: 'json',
                                        success: function (data) {
                                            swal({title: "", text: "Updating Success!", type: "success"},
                                                function () {
                                                    $('#app_sup_btn').prop('disabled', false);
                                                    clear_Form('app_sup_form');
                                                    $('#modal-view').modal('hide');
                                                    srchGrn();
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
                                        url: "<?= base_url(); ?>Stock/supp_update",
                                        data: $("#app_sup_form").serialize(),
                                        dataType: 'json',
                                        success: function (data) {
                                            swal({title: "", text: "Approved!", type: "success"},
                                                function () {
                                                    $('#app_sup_btn').prop('disabled', false);
                                                    clear_Form('app_sup_form');
                                                    $('#modal-view').modal('hide');
                                                    srchGrn();
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
            } else {
                swal("No Any bank Details..", "", "info");
            }
        });

        //Add New bank Account Number
        $('#add_new_acc').click(function (e) {
            if ($('#edit_bank_form').valid()) {
                swal({
                    title: "Processing...",
                    text: "Supplier's account number saving..",
                    imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                    showConfirmButton: false
                });

                var spid = $('#spid').val();
                $('#add_new_acc').prop('disabled', true);

                jQuery.ajax({
                    type: "POST",
                    url: "<?= base_url(); ?>Stock/supp_add_bnkAcc",
                    data: {
                        spid: spid,
                        bknm: function () {
                            return $('#bnknm_edt').val();
                        },
                        bkbr: function () {
                            return $('#bnkbr_edt').val();
                        },
                        acc: function () {
                            return $('#acno_edt').val();
                        },
                    },
                    dataType: 'json',
                    success: function (data) {
                        swal({title: "", text: "Saved!", type: "success"},
                            function () {
                                $('#add_new_acc').prop('disabled', false);
                                clear_Form('edit_bank_form');
                                $('#modal-Bank-New').modal('hide');
                                var len2 = data['accDet'].length;
                                var bkdet = data['accDet'];

                                $('#supp_Bank').DataTable().clear();
                                var t1 = $('#supp_Bank').DataTable();

                                for (var ii = 0; ii < len2; ii++) {
                                    if (bkdet[ii]['dfst'] == 1) {
                                        var dfst = "<label class='label label-info' title='Default Account Number'>D</label> ";
                                        var radio = "<div title='Default Account' class='app-radio round'><input type='radio'" +
                                            "onclick='desDefClose($(this))'" +
                                            " name='dfstRd[]' value='" + bkdet[ii]['acid'] + "' checked/></div>"
                                        var defDes = 'disabled';
                                    } else {
                                        var dfst = "";
                                        var radio = "<div class='app-radio round'><input type='radio'" +
                                            "onclick='desDefClose($(this))'" +
                                            " name='dfstRd[]' value='" + bkdet[ii]['acid'] + "'/></div>"
                                        var defDes = '';
                                    }

                                    var bnknm = bkdet[ii]['bkcd'] + " - " + bkdet[ii]['bknm'];
                                    var brnm = bkdet[ii]['brcd'] + " - " + bkdet[ii]['bcnm'];
                                    var acc = dfst + bkdet[ii]['acno'];
                                    var opt = "<button " + defDes + " id='dltrw' class='btn btn-xs btn-warning btn-rounded btn_dlt_acc' title='Remove'><span class='fa fa-close'></span></button> " +
                                        radio +
                                        "<input type='hidden' id='acnoList' name='acnoList[]' value='" + bkdet[ii]['acid'] + "'/>";
                                    t1.row.add([
                                        // (ii+1),
                                        bnknm,
                                        brnm,
                                        acc,
                                        opt
                                    ]).draw(false);
                                }
                            });
                        //console.log(" awaaa");
                        $("#app_sup_btn").show();
                    },
                    error: function (data, textStatus) {
                        swal({title: "Failed", text: textStatus, type: "error"},
                            function () {
                                location.reload();
                            });
                    }
                });
            }
        });

        //Reject Supplier
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
                            url: "<?= base_url(); ?>Stock/supp_Reject",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (data) {
                                swal({title: "", text: "Supplier was rejected!", type: "success"},
                                    function () {
                                        srchGrn();
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

        //Deactivate Supplier
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
                            url: "<?= base_url(); ?>Stock/supp_Deactive",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (data) {
                                swal({title: "", text: "Supplier was deactivated!", type: "success"},
                                    function () {
                                        srchGrn();
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
                            url: "<?= base_url(); ?>Stock/supp_Activate",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (data) {
                                swal({title: "", text: "Supplier was activated!", type: "success"},
                                    function () {
                                        srchGrn();
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

        // supply bank details show hide
        function loadBnkDit() {
            if ($('#bnkDtl').prop('checked')) {
                $('#bankDtil').css("display", "block");
            } else {
                $('#bankDtil').css("display", "none");
            }
        }

        // supply bank details show hide edit
        function loadBnkDitEdt() {
            if ($('#bnkDtlEdt').prop('checked')) {
                $('#bankDtilEdt').css("display", "block");
            } else {
                $('#bankDtilEdt').css("display", "none");
            }
        }

    </script>
</div>
<!-- END PAGE CONTAINER -->
