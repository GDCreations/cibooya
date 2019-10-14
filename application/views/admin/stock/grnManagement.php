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
                    <label class="col-md-4 col-xs-12 control-label">Supplier</label>
                    <div class="col-md-8 col-xs-12">
                        <select id="supl" name="supl" class="bs-select" onchange="chckBtn(this.value,this.id)">
                            <option value="0">-- Select Supplier --</option>
                            <option value="all">All Supplier</option>
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
                        <th class="text-left">Supplier</th>
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
                                                    onchange="chckBtn(this.value,this.id);loadPo(this.value,'podt','poDiv','',0,true)">
                                                <option value="0">-- Select Supplier --</option>
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
                                            <th id="ttlQt">00</th>
                                            <th id="ttlFr">00</th>
                                            <th id="ttlGd">00</th>
                                            <th id="ttlPrc">0.00</th>
                                            <th id="ttlBd">00</th>
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
                                        <label class="col-md-5  control-label">Check By
                                            <span class="fa fa-asterisk req-astrick"></span></label>
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
        <div class="modal-dialog modal-lg" role="document" style="width: 90%">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="icon-cross"></span>
            </button>
            <form id="appForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> GRN & GRRN
                            <span class="text-muted" id="subTitle_edit"></span></h4>
                        <input type="hidden" id="func" name="func"/>
                        <input type="hidden" id="grnid" name="grnid"/>
                    </div>
                    <div class="modal-body">
                        <div class="container">

                            <div class="row form-horizontal">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-6 col-xs-12 control-label">Supplier Name <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-6 col-xs-12" id="">
                                            <select id="suplSrcEdt" name="suplSrcEdt" class="bs-select"
                                                    onchange="chckBtn(this.value,this.id);loadPo(this.value,'podtEdt','poDivEdt','',0,true)">
                                                <option value="0">-- Select Supplier --</option>
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
                                            <input class="form-control datetimepicker" type="text" name="grdtEdt"
                                                   id="grdtEdt"
                                                   readonly value="<?= date('Y-m-d'); ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-6 col-xs-12 control-label">Reference Details (PO) <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-6 col-xs-12" id="poDivEdt">
                                            <select id="podtEdt" name="podtEdt" class="bs-select"
                                                    onchange="chckBtn(this.value,this.id);getPodet(this.value) ">
                                                <option value="0">-- Select Po --</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6 col-xs-12 control-label">Delivery Warehouse <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-6 col-xs-12" id="">
                                            <select id="whsidEdt" name="whsidEdt" class="bs-select"
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
                                        <table class="table dataTable table-striped table-bordered" id="grnTblEdt"
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
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th id="ttlQtEdt">00</th>
                                            <th id="ttlFrEdt">00</th>
                                            <th id="ttlGdEdt">00</th>
                                            <th id="ttlPrcEdt">0.00</th>
                                            <th id="ttlBdEdt">00</th>
                                            <th></th>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <input type="hidden" id="lengEdt" name="lengEdt">
                                    <input type="hidden" id="ttlQt2Edt" name="ttlQt2Edt">
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-5  control-label">Remarks </label>
                                        <div class="col-md-7">
                                            <textarea class="form-control" name="remkEdt" id="remkEdt"
                                                      rows="6" placeholder="Remarks"> </textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-5  control-label">Check By
                                            <span class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-7 col-xs-12">
                                            <input type="text" class="form-control "
                                                   name="chkbyEdt" id="chkbyEdt"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">ORDER QTY</label>
                                        <div class="col-md-6 col-xs-12">
                                            <input class="form-control" type="text" name="odrqtEdt" id="odrqtEdt"
                                                   readonly/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">FREE QTY</label>
                                        <div class="col-md-6 col-xs-12">
                                            <input class="form-control" type="text" name="tfrqtEdt" id="tfrqtEdt"
                                                   readonly/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">RECEIVE QTY</label>
                                        <div class="col-md-6 col-xs-12">
                                            <input class="form-control" type="text" name="rcvqtEdt" id="rcvqtEdt"
                                                   readonly/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">RETURN QTY </label>
                                        <div class="col-md-6 col-xs-12">
                                            <input class="form-control" type="text" name="rtnqtEdt" id="rtnqtEdt"
                                                   readonly/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-horizontal view_Area">
                                <div class="row form-horizontal">
                                    <h5 class="text-title"><span class="fa fa-tag"></span> Process Details </h5>
                                </div>
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
                                    <!--<div class="form-group">
                                        <label class="col-md-4 control-label">Updated By</label>
                                        <label class="col-md-8 control-label" id="mdby"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Updated Date</label>
                                        <label class="col-md-8 control-label" id="mddt"></label>
                                    </div>-->
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
                        <button type="button" id="edtBtn" class="btn btn-warning btn-sm btn-rounded">Submit
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
                "columnDefs": [
                    {className: "text-left", "targets": [2, 3]},
                    {className: "text-center", "targets": [0, 1, 4, 9, 10]},
                    {className: "text-right", "targets": [0, 5, 6, 7, 8, 11]},
                    {className: "text-nowrap", "targets": [2, 3]},
                ],
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
                    {sWidth: '10%'},  //Status
                    {sWidth: '10%'}  //Option
                ]
            });

            $('#grnTbl').DataTable().clear();
            $('#grnTbl').DataTable({
                destroy: true,
                searching: false,
                bPaginate: false,
                "ordering": false,
                "columnDefs": [
                    {className: "text-left", "targets": [1, 2]},
                    {className: "text-center", "targets": [0, 5, 6, 8]},
                    {className: "text-right", "targets": [3, 4, 7]},
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
                }
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
                        decimal: true
                    },
                    tfrqt: {
                        //required: true,
                        notEqual: 0,
                        decimal: true
                    },
                    rcvqt: {
                        required: true,
                        notEqual: 0,
                        decimal: true
                    },
                    rtnqt: {
                        //required: true,
                        //notEqual: 0,
                        decimal: true
                    },
                    chkby: {
                        required: true,
                        notEqual: 0
                    },
                    'grgd[]': {
                        required: true,
                        decimal: true,
                        tblar_max: 'odrQty[]'
                    },
                    'grfr[]': {
                        decimal: true
                    }
                },
                messages: {
                    suplSrc: {
                        required: "Select supplier name",
                        notEqual: "Select supplier name",
                    },
                    podt: {
                        required: "Select po",
                        notEqual: "Select po"
                    },
                    whsid: {
                        required: "Select Delivery Warehouse",
                        notEqual: "Select Delivery Warehouse",
                    },
                    chkby: {
                        required: "Enter Check user",
                        notEqual: "Enter Check user",
                    }
                }
            });

            $('#appForm').validate({
                rules: {
                    suplSrcEdt: {
                        required: true,
                        notEqual: 0
                    },
                    podtEdt: {
                        required: true,
                        notEqual: 0
                    },
                    whsidEdt: {
                        required: true,
                        notEqual: 0
                    },
                    odrqtEdt: {
                        //required: true,
                        notEqual: 0,
                        digits: true
                    },
                    tfrqtEdt: {
                        //required: true,
                        //notEqual: 0,
                        digits: true
                    },
                    rcvqtEdt: {
                        //required: true,
                        notEqual: 0,
                        digits: true
                    },
                    rtnqtEdt: {
                        //required: true,
                        //notEqual: 0,
                        digits: true
                    },
                    chkbyEdt: {
                        required: true,
                        notEqual: 0
                    },
                },
                messages: {
                    suplSrcEdt: {
                        required: "Select supplier name",
                        notEqual: "Select supplier name",
                    },
                    podtEdt: {
                        required: "Select po",
                        notEqual: "Select po"
                    },
                    whsidEdt: {
                        required: "Select Delivery Warehouse",
                        notEqual: "Select Delivery Warehouse",
                    },
                    chkbyEdt: {
                        required: "Enter Check user",
                        notEqual: "Enter Check user",
                    },
                }
            });
            srchGrn();
        });

        // Get Supplier PO Details
        function loadPo(supid, html, mhtml, seltdid, st, init) {

            $.ajax({
                url: '<?= base_url(); ?>Stock/getPodet',
                type: 'post',
                data: {
                    supid: supid,
                    st: st,
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
                            if (seltdid == id) {
                                set_select(html, seltdid);
                            }
                        }
                    } else {
                        $('#' + html).empty();
                        $('#' + html).append("<option value='0'>-- No Po Details --</option>");
                        child2.append("<li data-original-index=\"0\" class=\"\"><a tabindex=\"0\" class=\"\" data-tokens=\"null\" role=\"option\" aria-disabled=\"false\" aria-selected=\"false\"><span class=\"text\">-- No Po Details --</span><span class=\" fa fa-check check-mark\"></span></a></li>");
                    }
                    //default_Selector(child1.find('div'));
                    // Default selector enable disable
                    if (init) default_Selector(child1.find('div'));
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
                    {className: "text-center", "targets": [0, 5, 6, 8]},
                    {className: "text-right", "targets": [3, 4, 7]},
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
                    // if (response['grndt'].length > 0) {
                    //     $('#whid').val(0);
                    //     document.getElementById('ttlQt').innerHTML = '';
                    //     swal({title: "", text: "This Po Already Added GRN", type: "warning"},);
                    //
                    // } else {
                    var len = response['podet'].length;
                    $('#leng').val(len);
                    set_select('whsid', response['podet'][0]['whid'])

                    var ttlqt = 0;
                    for (var a = 0; a < len; a++) {
                        t.row.add([
                            a + 1,
                            response['podet'][a]['itcd'] + '<input type="hidden" name="itid[]" value="' + response['podet'][a]['itid'] + '">',       // ITEM CODE
                            response['podet'][a]['itnm'],                                                    // ITEM NAME
                            numeral(response['podet'][a]['untp']).format('0,0.00') + '<input type="hidden" name="untp[]" value="' + response['podet'][a]['untp'] + '" >',                          // PRICE
                            numeral(response['podet'][a]['qnty']).format('0,0') + '<input type="hidden" name="odrQty[]" value="' + response['podet'][a]['qnty'] + '">',                            // ODR QUNT
                            '<input type="text" size="4" class="form-control" id="grfr_' + a + '" name="grfr[]" onkeyup="calFrQty(this.value)" style="text-align:right;width: 100%">',                                                           // RCV QTY
                            '<input type="text" size="4" class="form-control dfg" id="grgd_' + a + '" name="grgd[]" onkeyup="calQty( ' + response['podet'][a]['qnty'] + ',this.value,' + a + ',' + response['podet'][a]['untp'] + ')" style="text-align:right;width: 100%">',       // RCV QTY
                            '<label id="grTprc_' + a + '">' + numeral(0).format('0,0.00') + '</label><input type="hidden" value="0" name="grhTprc[]" id="grhTprc_' + a + '">', //total price of items
                            '<input type="text" class="form-control" id="grbd_' + a + '" name="grbd[]" readonly size="4" style="text-align:right;width: 100%">',      // RTN QTY
                            '<input type="text" class="form-control" name="rtnRmk[]" style="width: 100%">',             // RTN REMK

                        ]).draw(false);
                        ttlqt = +ttlqt + +response['podet'][a]['qnty'];
                    }
                    $('#ttlQt').html(ttlqt);
                    $('#ttlQt2').val(ttlqt);
                    // }
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
                $("#addBtn").attr("disabled", true);
            } else {
                $("#addBtn").attr("disabled", false);
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
                                $('#grnTbl').DataTable().clear().draw();
                                $('#ttlQt, #ttlFr, #ttlGd, #ttlBd').html('00');
                                $('#ttlPrc').html('0.00');
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

            chckBtn(supl, 'supl');

            if (supl != 0) {
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
                        {className: "text-left", "targets": [2, 3]},
                        {className: "text-center", "targets": [0, 1, 4, 9, 10, 11]},
                        {className: "text-right", "targets": [0, 5, 6, 7, 8]},
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
                        {sWidth: '10%'},  //Status
                        {sWidth: '10%'}  //Option
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

        // View
        function viewGrn(id, func) {
            swal({
                title: "Loading Data...",
                text: "GRN's Details",
                imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                showConfirmButton: false
            });

            $('#func').val(func);
            $('#grnid').val(id);

            jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>Stock/vewGrnDetails",
                data: {
                    auid: id
                },
                dataType: 'json',
                success: function (data) {
                    if (func == 'view') {
                        //VIEW MODEL
                        $('#subTitle_edit').html(' - View');
                        $('#edtBtn').css('display', 'none');
                        //$("#modal-view").find('.edit_req').css("display", "none");
                        $("#edit_Area").css('display', 'none');
                        $(".view_Area").css('display', 'block');
                        //Make readonly all fields
                        $("#modal-view :input").attr("readonly", true);
                        $("#modal-view").find('.bootstrap-select').addClass("disabled dropup");
                        $("#modal-view").find('.bootstrap-select').children().addClass("disabled dropup");
                        var des = "disabled";
                        //VIEW MODEL
                    } else if (func == 'app') {
                        //APPROVE MODEL
                        $('#subTitle_edit').html(' - Approve');
                        $('#edtBtn').css('display', 'inline');
                        $('#edtBtn').html('Approve');
                        //$("#modal-view").find('.edit_req').css("display", "inline");
                        $("#edit_Area").css('display', 'block');
                        $(".view_Area").css('display', 'none');
                        //Remove readonly all fields
                        $("#modal-view :input").attr("readonly", true);
                        $("#modal-view").find('.bootstrap-select').addClass("disabled dropup");
                        $("#modal-view").find('.bootstrap-select').children().addClass("disabled dropup");
                        var des = "";
                        //APPROVE MODEL
                    }

                    var len = data['grndtl'].length;
                    var len2 = data['poitem'].length;
                    var grndtl = data['grndtl'];
                    var poitem = data['poitem'];

                    if (len > 0) {
                        set_select('suplSrcEdt', grndtl[0]['spid']);
                        set_select('whsidEdt', grndtl[0]['whid']);
                        loadPo(grndtl[0]['spid'], 'podtEdt', 'poDivEdt', grndtl[0]['poid'], 1, false);

                        $('#odrqtEdt').val(grndtl[0]['odqt']);
                        $('#tfrqtEdt').val(grndtl[0]['frqt']);
                        $('#rcvqtEdt').val(grndtl[0]['rcqt']);
                        $('#rtnqtEdt').val(grndtl[0]['rtqt']);
                        $('#remkEdt').val(grndtl[0]['remk']);
                        $('#chkbyEdt').val(grndtl[0]['chby']);

                        if (grndtl[0]['stat'] == 0) {
                            var stat = "<label class='label label-warning'>Pending</label>";
                        } else if (grndtl[0]['stat'] == 1) {
                            var stat = "<label class='label label-success'>Active</label>";
                        } else if (grndtl[0]['stat'] == 2) {
                            var stat = "<label class='label label-danger'>Reject</label>";
                        } else if (grndtl[0]['stat'] == 3) {
                            var stat = "<label class='label label-info'>Inactive</label>";
                        } else {
                            var stat = "--";
                        }
                        $('#sup_stat').html(": " + stat);
                        $('#code').html(": " + grndtl[0]['spcd']);
                        $('#crby').html(": " + grndtl[0]['crnm']);
                        $('#crdt').html(": " + grndtl[0]['crdt']);
                        $('#apby').html(": " + ((grndtl[0]['apnm'] != null) ? grndtl[0]['apnm'] : "--"));
                        $('#apdt').html(": " + ((grndtl[0]['apdt'] != null && grndtl[0]['apdt'] != "0000-00-00 00:00:00") ? grndtl[0]['apdt'] : "--"));
                        $('#rjby').html(": " + ((grndtl[0]['rjnm'] != null) ? grndtl[0]['rjnm'] : "--"));
                        $('#rjdt').html(": " + ((grndtl[0]['rjdt'] != null && grndtl[0]['rjdt'] != "0000-00-00 00:00:00") ? grndtl[0]['rjdt'] : "--"));
                        //$('#mdby').html(": " + ((grndtl[0]['mdnm'] != null) ? grndtl[0]['mdnm'] : "--"));
                        //$('#mddt').html(": " + ((grndtl[0]['mddt'] != null && grndtl[0]['mddt'] != "0000-00-00 00:00:00") ? grndtl[0]['mddt'] : "--"));
                    }

                    if (len2 > 0) {
                        $('#grnTblEdt').DataTable().clear();
                        var m = $('#grnTblEdt').DataTable({
                            "bInfo": false,
                            destroy: true,
                            searching: false,
                            bPaginate: false,
                            "ordering": false,
                            "columnDefs": [
                                {className: "text-left", "targets": [1, 2, 9]},
                                {className: "text-center", "targets": [0]},
                                {className: "text-right", "targets": [3, 4, 5, 6, 7, 8]},
                                {className: "text-nowrap", "targets": [1]}
                            ],
                            "aoColumns": [
                                {sWidth: '5%'},
                                {sWidth: '10%'},    //
                                {sWidth: '10%'},    //
                                {sWidth: '5%'},    //
                                {sWidth: '5%'},     //
                                {sWidth: '5%'},     //
                                {sWidth: '5%'},     //
                                {sWidth: '5%'},     //
                                {sWidth: '5%'},     //
                                {sWidth: '5%'}
                            ],
                            "footerCallback": function (row, data, start, end, display) {
                                var api = this.api(), data;

                                // Remove the formatting to get integer data for summation
                                var intVal = function (i) {
                                    return typeof i === 'string' ?
                                        i.replace(/[\$,]/g, '') * 1 :
                                        typeof i === 'number' ?
                                            i : 0;
                                };
                                //COLUMN 3 TTL
                                var t3 = api.column(3).data().reduce(function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);
                                $(api.column(3).footer()).html(numeral(t3).format('0,0.00'));
                                //COLUMN 4 TTL
                                var t4 = api.column(4).data().reduce(function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);
                                $(api.column(4).footer()).html(numeral(t4).format('0,0'));
                                //document.getElementById("vw_odqt").innerHTML = t4;
                                //COLUMN 5 TTL
                                var t5 = api.column(5).data().reduce(function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);
                                $(api.column(5).footer()).html(numeral(t5).format('0,0'));
                                //COLUMN 6 TTL
                                var t6 = api.column(6).data().reduce(function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);
                                $(api.column(6).footer()).html(numeral(t6).format('0,0'));
                                //COLUMN 7 TTL
                                var t7 = api.column(7).data().reduce(function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);
                                $(api.column(7).footer()).html(numeral(t7).format('0,0.00'));
                                //COLUMN 8 TTL
                                var t8 = api.column(8).data().reduce(function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);
                                $(api.column(8).footer()).html(numeral(t8).format('0,0'));
                            },
                        });

                        var grtp = grndtl[0]['grtp'];
                        m.clear().draw();
                        for (var a = 0; a < len2; a++) {
                            if (grtp == 1) {    // GRN
                                var rcqt = poitem[a]['qnty'];
                                var rtqt = 0;
                                var frqt = poitem[a]['frqt'];
                            } else {            // GRRN
                                var rcqt = 0;
                                var rtqt = poitem[a]['qnty'];
                                var frqt = 0;
                            }

                            m.row.add([
                                a + 1,
                                poitem[a]['itcd'],
                                poitem[a]['itnm'],
                                numeral(poitem[a]['untp']).format('0,0.00'),
                                poitem[a]['odqt'],
                                frqt,
                                rcqt,
                                numeral(rcqt * poitem[a]['untp']).format('0,0.00'),
                                rtqt,
                                poitem[a]['remk'],

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

        //APPROVE || EDIT HERE
        $('#edtBtn').click(function (e) {
            e.preventDefault();

            if ($('#appForm').valid()) {
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
                            $('#edtBtn').prop('disabled', true);

                            if (func == 'app') {
                                swal({
                                    title: "Processing...",
                                    text: "GRN approving..",
                                    imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                                    showConfirmButton: false
                                });

                                jQuery.ajax({
                                    type: "POST",
                                    url: "<?= base_url(); ?>Stock/updateGrn",
                                    data: $("#appForm").serialize(),
                                    dataType: 'json',
                                    success: function (data) {
                                        swal({title: "", text: "Approved!", type: "success"},
                                            function () {
                                                $('#edtBtn').prop('disabled', false);
                                                clear_Form('appForm');
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
        });

        // GRN PRINT
        function prntGrn(auid) {
            swal({
                title: "Please wait...",
                text: "GRN generating..",
                imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                showConfirmButton: false
            });
            setTimeout(function () {
                window.open('<?= base_url() ?>Stock/grnPrint/' + auid, 'popup', 'width=1100,height=600,scrollbars=no,resizable=no');
                swal.close(); // Hide the loading message
            }, 1000);
        }

        //Reject Supplier
        function grnReject(id) {
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
        function inactgrn(id) {
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
        function reactgrn(id) {
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

    </script>
</div>
<!-- END PAGE CONTAINER -->
