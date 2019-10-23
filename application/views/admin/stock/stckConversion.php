<script type="text/javascript" src="<?= base_url(); ?>assets/js/custom-js/full_width.js"></script>

<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">Stock Access</a></li>
        <li class="active">Stock Conversion</li>
    </ul>
</div>
<div class="app-heading app-heading-bordered app-heading-page">
    <div class="icon icon-lg">
        <span class="fa fa-random" style="color: #e69c0f;"></span>
    </div>
    <div class="title">
        <h1>Stock Conversion</h1>
        <p>Convert stock item measuring scale with quantity (Convert / Reject / Approve / Search & View)</p>
    </div>
    <?php
    if ($funcPerm[0]->inst == 1) { ?>
        <div class="pull-right">
            <button class="btn btn-sm btn-info btn-icon-fixed btn-rounded" data-toggle="modal" data-target="#modal-add">
                <span class="fa fa-plus"></span>Add To Convert
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
                    <label class="col-md-4 col-xs-6 control-label">Branch</label>
                    <div class="col-md-8 col-xs-6">
                        <select class="bs-select" name="brchs" id="brchs"
                                onchange="chckBtn(this.value,this.id);">
                            <?php
                            foreach ($branchinfo as $brch) {
                                if ($brch['brch_id'] != '0') {
                                    if ($brch['brch_id'] == 'all') {
                                        echo "<option value='" . $brch['brch_id'] . "'>" . $brch['brch_name'] . "</option>";
                                    } else {
                                        echo "<option value='" . $brch['brch_id'] . "'>" . $brch['brch_code'] . " - " . $brch['brch_name'] . "</option>";
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 col-xs-6 control-label">Status</label>
                    <div class="col-md-8 col-xs-6">
                        <select class="bs-select" name="stats" id="stats">
                            <option value="all">All Status</option>
                            <option value="1">Active</option>
                            <option value="0">Pending</option>
                            <option value="2">Finish</option>
                            <option value="3">Reject</option>
                            <option value="4">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-md-4 col-xs-6 control-label">Item Name</label>
                    <div class="col-md-8 col-xs-6">
                        <select data-live-search="true" class="bs-select" name="itms" id="itms"
                                onchange="chckBtn(this.value,this.id);">
                            <option value="all">All Items</option>
                            <?php
                            foreach ($item as $it) {
                                echo "<option value='" . $it->itid . "'>" . $it->itcd . " - " . $it->itnm . "</option>";
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
                <div class="form-group">
                    <label class="col-md-4 col-xs-12 control-label"><br></label>
                    <div class="col-md-8 col-xs-12">
                        <button class="btn btn-sm btn-primary btn-rounded btn-icon-fixed pull-right"
                                onclick="srchConStck()"><span
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
                        <th class="text-center"> #</th>
                        <th class="text-left"> STK NO</th>
                        <th class="text-left" title="Branch"> BRCH</th>
                        <th class="text-left"> ITEM</th>
                        <th class="text-left"> COST</th>
                        <th class="text-left"> FACE</th>
                        <th class="text-left"> SALE</th>
                        <th class="text-left"> QTY</th>
                        <th class="text-left" title="Available Quantity"> AVQT</th>
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
                    <th colspan="3"></th>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- MODAL ADD NEW CONVERSION -->
    <div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modal-default-header">
        <div class="modal-dialog modal-info modal-lg" role="document" style="width: 90%">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="icon-cross"></span>
            </button>
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> Add Stock
                        Conversion
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row form-horizontal">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-6 control-label">Branch</label>
                                    <div class="col-md-8 col-xs-6">
                                        <select class="bs-select" name="brchid" id="brchid"
                                                onchange="chckBtn(this.value,this.id); loadStcks();">
                                            <?php
                                            foreach ($branchinfo as $brch) {
                                                if ($brch['brch_id'] == 0 || $brch['brch_id'] == 'all') {
                                                    echo "<option value='" . $brch['brch_id'] . "'>" . $brch['brch_name'] . "</option>";
                                                } else {
                                                    echo "<option value='" . $brch['brch_id'] . "'>" . $brch['brch_code'] . " - " . $brch['brch_name'] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-6 control-label">Item Name</label>
                                    <div class="col-md-8 col-xs-6">
                                        <select data-live-search="true" class="bs-select" name="itid" id="itid"
                                                onchange="chckBtn(this.value,this.id); loadStcks();">
                                            <option value="all">All Items</option>
                                            <?php
                                            foreach ($item as $it) {
                                                echo "<option value='" . $it->itid . "'>" . $it->itcd . " - " . $it->itnm . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-horizontal">
                            <div class="col-md-12">
                                <div class="table-responsive scroll"
                                     style="max-height: 65vh; padding: 10px 25px 10px 10px ">
                                    <table class="table dataTable table-bordered table-striped" id="brnchStck"
                                           style="width: 100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-left">STOCK</th>
                                            <th class="text-left">ITEM CODE</th>
                                            <th class="text-left">ITEM</th>
                                            <th class="text-left" title="Current Stock Scale">STK. SCALE</th>
                                            <th class="text-left" title="Available Quantity">AV. QTY.</th>
                                            <th class="text-left">SIZE</th>
                                            <th class="text-left" title="Conversion Stock Scale">CONV. SCALE</th>
                                            <th class="text-left" title="Quantity">QTY.</th>
                                            <th class="text-left" title="Cost Value">CS. VL.</th>
                                            <th class="text-left" title="Sale Value">SL. Vl.</th>
                                            <th class="text-left" title="Face Value">FC. Vl.</th>
                                            <th class="text-left" title="Market Value">MK. Vl.</th>
                                            <th class="text-left" title="Options">OPT.</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="pull-left">
                        <span class="fa fa-hand-o-right"></span> <label style="color: red"> Please convert item
                            scale that able to convert.
                            <strong>(EX : Electic Items & furnitures unable to convert)</strong>
                        </label>
                    </div>
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END ADD NEW STOCK -->
    <!-- MODAL ADD SERIAL STOCK -->
    <div class="modal fade" id="modal-srl" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="modal-default-header">
        <div class="modal-dialog modal-warning" role="document">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="icon-cross"></span>
            </button>
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> Select Converting
                        Items <span class="text-muted" id="qtyTitle"></span></h4>
                </div>
                <form id="addForm">
                    <input type="hidden" id="stBrchID" name="stBrchID"/>
                    <input type="hidden" id="addQty" name="addQty"/>
                    <input type="hidden" id="newScal" name="newScal"/>
                    <input type="hidden" id="newCsvl" name="newCsvl"/>
                    <input type="hidden" id="newSlvl" name="newSlvl"/>
                    <input type="hidden" id="newFcvl" name="newFcvl"/>
                    <input type="hidden" id="newMkvl" name="newMkvl"/>
                    <div class="modal-body">
                        <div class="row form-horizontal">
                            <div class="col-md-6 col-xs-12">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="srlSrch"
                                           placeholder="Serial / Barcode / ect"/>
                                    <span class="input-group-btn">
                                                <button onclick="srchSrlNum();" class="btn btn-default btn-sm"
                                                        style="margin-top: 0px; height: 33px; !important;"
                                                        type="button">Go!</button>
                                            </span>
                                </div>
                            </div>
                        </div>
                        <div class="row form-horizontal scroll" style="max-height: 30vh;" id="srl_Number_Area">
                            <h3>-- No Serial Numbers --</h3>
                        </div>
                        <div class="row form-horizontal">
                            <div class="col-md-12">
                                <h5 class="text-title"><span class="fa fa-tag"></span> Added</h5>
                            </div>
                        </div>
                        <div class="row form-horizontal scroll" style="max-height: 30vh;" id="added_srl">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                        <button type="button" id="addBtn" class="btn btn-warning btn-sm btn-rounded">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END ADD SERIAL STOCK -->
    <!-- VIEW CONVERSION STOCK-->
    <div class="modal fade" id="modal-view" tabindex="-1" role="dialog" aria-labelledby="modal-default-header">
        <div class="modal-dialog modal-lg modal-success" role="document">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="icon-cross"></span>
            </button>
            <div class="modal-content">
                <form id="appForm">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> Stock
                            Conversion
                            Management <span class="text-muted" id="conStViewTitle"> - View</span></h4>
                        <input type="hidden" name="stid_Vw" id="stid_Vw"/>
                        <input type="hidden" name="pr_stid_Vw" id="pr_stid_Vw"/>
                        <input type="hidden" name="func" id="func"/>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row form-horizontal">
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Category</label>
                                        <label class="col-md-8 col-xs-12 control-label" id="vewCat"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Model</label>
                                        <label class="col-md-8 col-xs-12 control-label" id="vewMdl"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Name</label>
                                        <label class="col-md-8 col-xs-12 control-label" id="vewName"> </label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Brand</label>
                                        <label class="col-md-8 col-xs-12 control-label" id="vewBrnd"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Type</label>
                                        <label class="col-md-8 col-xs-12 control-label" id="vewTyp"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Size</label>
                                        <label class="col-md-8 col-xs-12 control-label" id="vewSize"></label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="col-md-5 col-xs-12 control-label">Available Qty.</label>
                                        <label class="col-md-7 col-xs-12 control-label" id="vewAvQunty"></label>
                                        <input type="hidden" id="conQty" name="conQty"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-5 col-xs-12 control-label">Quantity</span></label>
                                        <label class="col-md-2 col-xs-12 control-label" id="vewQunty"></label>
                                        <div class="col-md-5 col-md-12">
                                            <select class="bs-select" id="vewScale" name="vewScale">
                                                <option value="0">-- Scale --</option>
                                                <?php
                                                foreach ($scale as $scl){
                                                    echo "<option value='$scl->slid'>($scl->scl) - $scl->scnm</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-5 col-xs-12 control-label">Cost Value</label>
                                        <div class="col-md-7 col-xs-12">
                                            <input type="text" id="vewCstvl" name="vewCstvl" readonly
                                                   style="text-align: right" class="form-control"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-5 col-xs-12 control-label">Sales Value <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-7 col-xs-12">
                                            <input type="text" id="vewSalvl" name="vewSalvl" style="text-align: right"
                                                   class="form-control"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-5 col-xs-12 control-label">Face (Display) Value <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-7 col-xs-12">
                                            <input type="text" id="vewFcvl" name="vewFcvl" style="text-align: right"
                                                   class="form-control"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-5 col-xs-12 control-label">Market Value</label>
                                        <div class="col-md-7 col-xs-12">
                                            <input type="text" id="vewMktvl" name="vewMktvl" style="text-align: right"
                                                   class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-horizontal">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h5 class="text-title"><span class="fa fa-tag"></span> Conversion Serial Numbers
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12 edit_Area">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="srlSrchEdt"
                                               placeholder="Serial / Barcode / ect"/>
                                        <span class="input-group-btn">
                                                <button onclick="srchSrlNumEdt();" class="btn btn-default btn-sm"
                                                        style="margin-top: 0px; height: 33px; !important;"
                                                        type="button">Go!</button>
                                            </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-horizontal scroll edit_Area" style="max-height: 30vh;"
                                 id="srl_Number_AreaEdt">
                                <h3>-- No Serial Numbers --</h3>
                            </div>
                            <div class="row form-horizontal edit_Area">
                                <div class="col-md-12">
                                    <h5><span class="fa fa-tag"></span> Added</h5>
                                </div>
                            </div>
                            <div class="row form-horizontal scroll" style="max-height: 30vh;" id="added_srlEdt">

                            </div>
                            <div class="row form-horizontal view_Area">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h5 class="text-title"><span class="fa fa-tag"></span> Other Details</h5>
                                        <label class="col-md-2 control-label">Status</label>
                                        <label class="col-md-10 control-label" id="stc_stat"></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Created By</label>
                                        <label class="col-md-8 col-xs-12 control-label" id="crby"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Created Date</label>
                                        <label class="col-md-8 col-xs-12 control-label" id="crdt"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Approved By</label>
                                        <label class="col-md-8 col-xs-12 control-label" id="apby"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Approved Date</label>
                                        <label class="col-md-8 col-xs-12 control-label" id="apdt"></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
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
                        <div class="pull-left edit_Area">
                            <span class="fa fa-hand-o-right"></span> <label style="color: red"> <span
                                        class="fa fa-asterisk req-astrick"></span> Required Fields </label>
                        </div>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                        <button type="button" id="edtBtn" class="btn btn-success btn-sm btn-rounded">
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END VIEW CONVERSION STOCK-->

    <script type="text/javascript">
        $().ready(function () {
            //Table INIT
            $('#brnchStck').DataTable({
                destroy: true,
                searching: false,
                bPaginate: false,
                "ordering": false,
                "columnDefs": [
                    {className: "text-left", "targets": [3, 4]},
                    {className: "text-center", "targets": [0, 1, 2, 7, 8, 10, 11, 12, 13]},
                    {className: "text-right", "targets": [3, 5, 6, 9]},
                    {className: "text-nowrap", "targets": [3]}
                ],
                "aoColumns": [
                    {sWidth: '3%'},
                    {sWidth: '8%'},    //
                    {sWidth: '8%'},     //
                    {sWidth: '20%'},
                    {sWidth: '8%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '8%'},
                    {sWidth: '5%'},
                    {sWidth: '8%'},
                    {sWidth: '8%'},
                    {sWidth: '8%'},
                    {sWidth: '8%'},
                    {sWidth: '3%'}
                ]
            });

            // Required for Bootstrap tooltips in DataTables
            $(document).ajaxComplete(function () {
                $('[data-toggle="tooltip"]').tooltip({
                    "html": true
                });
                $('[data-toggle="popover"]').popover({
                    "html": true
                });
            });

            //Validation Init
            $('#appForm').validate({
                rules: {
                    vewSalvl:{
                        required: true,
                        notEqual: 0,
                        decimal: true,
                        min: function () {
                            return +$('#vewCstvl').val();
                        }
                    },
                    vewFcvl:{
                        required: true,
                        notEqual: 0,
                        decimal: true,
                        min: function () {
                            return +$('#vewSalvl').val();
                        }
                    },
                    vewMktvl:{
                        decimal: true
                    },
                    vewScale:{
                        notEqual: 0
                    }
                },
                messages: {
                    vewSalvl: {
                        required: "Enter sale value",
                        notEqual: "Can't Enter zero value",
                    },
                    vewFcvl: {
                        required: "Enter display value",
                        notEqual: "Can't Enter zero value",
                    },
                    vewScale:{
                        notEqual: "Select scale"
                    }
                }
            });
            srchConStck();
        });

        function loadStcks() {
            var brch = $('#brchid').val();
            var itid = $('#itid').val();

            $('#brnchStck').DataTable().clear();
            $('#brnchStck').DataTable({
                destroy: true,
                searching: false,
                bPaginate: false,
                "ordering": false,
                "language": {
                    processing: '<i class="fa fa-spinner fa-spin fa-fw" style="font-size:20px;color:red;"></i><span class=""> Loading...</span> '
                },
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                "serverSide": true,
                "columnDefs": [
                    {className: "text-left", "targets": [3, 4]},
                    {className: "text-center", "targets": [0, 1, 2, 7, 8, 10, 11, 12, 13]},
                    {className: "text-right", "targets": [3, 5, 6, 9]},
                    {className: "text-nowrap", "targets": [3]}
                ],
                "aoColumns": [
                    {sWidth: '3%'},
                    {sWidth: '8%'},    //
                    {sWidth: '8%'},     //
                    {sWidth: '20%'},
                    {sWidth: '8%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '8%'},
                    {sWidth: '5%'},
                    {sWidth: '8%'},
                    {sWidth: '8%'},
                    {sWidth: '8%'},
                    {sWidth: '8%'},
                    {sWidth: '3%'}
                ],
                "ajax": {
                    url: '<?= base_url(); ?>Stock/srchBrchStck_Cn',
                    type: 'post',
                    data: {
                        brch: brch,
                        itid: itid
                    }
                }
            });
        }

        //Only Decimals input feilds
        function decimal(value) {
            var re = new RegExp(/^((\d+(\\.\d{0,2})?)|((\d*(\.\d{1,2}))))$/);
            if (re.test(value)) {
                return true;
            } else {
                return false;
            }
        }

        //Check QTY value is more than available value
        function checkQty(value, row) {
            var avqt = $('#avqn_' + row).val();

            $('#qty_' + row).next('br').remove();
            $('#qty_' + row).next('.error').remove();
            $('#qty_' + row).css('border', '1px dotted');

            if (value == '') {
                $('#qty_' + row).after("<br><label id='name-error' class='error' style='font-size: 13px;color: red; font-style: italic;' for='qty_" + row + "'>Enter quantity</label>");
                $('#qty_' + row).css('border', '1px dotted red');
                return false;
            } else if (decimal(value)) {
                if (value == 0) {
                    $('#qty_' + row).after("<br><label id='name-error' class='error' style='font-size: 13px;color: red; font-style: italic;' for='qty_" + row + "'>Can't enter zero value</label>");
                    $('#qty_' + row).css('border', '1px dotted red');
                    return false;
                } else {
                    if (+value > avqt) {
                        $('#qty_' + row).after("<br><label id='name-error' class='error' style='font-size: 13px;color: red; font-style: italic;' for='qty_" + row + "'>Can't enter more than " + avqt + "</label>");
                        $('#qty_' + row).css('border', '1px dotted red');
                        return false;
                    }
                    return true;
                }
            } else {
                $('#qty_' + row).after("<br><label id='name-error' class='error' style='font-size: 13px;color: red; font-style: italic;' for='qty_" + row + "'>Please enter a correct number, format 0.00</label>");
                $('#qty_' + row).css('border', '1px dotted red');
                return false;
            }
        }

        //Check scale is selected
        function checkScale(value, row) {
            $('#nscl_' + row).next('br').remove();
            $('#nscl_' + row).next('.error').remove();
            $('#nscl_' + row).css('border', '1px dotted');

            if (value == 0) {
                $('#nscl_' + row).after("<br><label id='name-error' class='error' style='font-size: 13px;color: red; font-style: italic;' for='nscl_" + row + "'>Select a scale</label>");
                $('#nscl_' + row).css('border', '1px dotted red');
                return false;
            }
            return true;
        }

        //Check Sale Value
        function checkSlvl(value, row) {
            var csvl = $('#csvl_' + row).val();

            $('#slvl_' + row).next('br').remove();
            $('#slvl_' + row).next('.error').remove();
            $('#slvl_' + row).css('border', '1px dotted');

            if (value == '') {
                $('#slvl_' + row).after("<br><label id='name-error' class='error' style='font-size: 13px;color: red; font-style: italic;' for='slvl_" + row + "'>Enter value</label>");
                $('#slvl_' + row).css('border', '1px dotted red');
                return false;
            } else if (decimal(value)) {
                if (value == 0) {
                    $('#slvl_' + row).after("<br><label id='name-error' class='error' style='font-size: 13px;color: red; font-style: italic;' for='slvl_" + row + "'>Can't enter zero value</label>");
                    $('#slvl_' + row).css('border', '1px dotted red');
                    return false;
                } else {
                    if (+value < csvl) {
                        $('#slvl_' + row).after("<br><label id='name-error' class='error' style='font-size: 13px;color: red; font-style: italic;' for='slvl_" + row + "'>Can't enter less than " + csvl + "</label>");
                        $('#slvl_' + row).css('border', '1px dotted red');
                        return false;
                    }
                    return true;
                }
            } else {
                $('#slvl_' + row).after("<br><label id='name-error' class='error' style='font-size: 13px;color: red; font-style: italic;' for='slvl_" + row + "'>Please enter a correct number, format 0.00</label>");
                $('#slvl_' + row).css('border', '1px dotted red');
                return false;
            }
        }

        //Check Face Value
        function checkFcvl(value, row) {
            var slvl = $('#slvl_' + row).val();

            $('#fcvl_' + row).next('br').remove();
            $('#fcvl_' + row).next('.error').remove();
            $('#fcvl_' + row).css('border', '1px dotted');

            if (value == '') {
                $('#fcvl_' + row).after("<br><label id='name-error' class='error' style='font-size: 13px;color: red; font-style: italic;' for='fcvl_" + row + "'>Enter value</label>");
                $('#fcvl_' + row).css('border', '1px dotted red');
                return false;
            } else if (decimal(value)) {
                if (value == 0) {
                    $('#fcvl_' + row).after("<br><label id='name-error' class='error' style='font-size: 13px;color: red; font-style: italic;' for='fcvl_" + row + "'>Can't enter zero value</label>");
                    $('#fcvl_' + row).css('border', '1px dotted red');
                    return false;
                } else {
                    if (+value < slvl) {
                        $('#fcvl_' + row).after("<br><label id='name-error' class='error' style='font-size: 13px;color: red; font-style: italic;' for='fcvl_" + row + "'>Can't enter less than " + slvl + "</label>");
                        $('#fcvl_' + row).css('border', '1px dotted red');
                        return false;
                    }
                    return true;
                }
            } else {
                $('#fcvl_' + row).after("<br><label id='name-error' class='error' style='font-size: 13px;color: red; font-style: italic;' for='fcvl_" + row + "'>Please enter a correct number, format 0.00</label>");
                $('#fcvl_' + row).css('border', '1px dotted red');
                return false;
            }
        }

        //Check Market Value
        function checkMkvl(value, row) {
            $('#mkvl_' + row).next('br').remove();
            $('#mkvl_' + row).next('.error').remove();
            $('#mkvl_' + row).css('border', '1px dotted');

            if ($('#mkvl_' + row).val() != '') {
                if (decimal(value)) {
                    return true;
                } else {
                    $('#mkvl_' + row).after("<br><label id='name-error' class='error' style='font-size: 13px;color: red; font-style: italic;' for='mkvl_" + row + "'>Please enter a correct number, format 0.00</label>");
                    $('#mkvl_' + row).css('border', '1px dotted red');
                    return false;
                }
            } else {
                return true;
            }
        }

        //Add to Convert View modal
        function addCon(stock, row) {
            var nscl = $('#nscl_' + row).val();
            var qty = $('#qty_' + row).val();
            var newScal = $('#nscl_' + row).val();
            var csvl = $('#csvl_' + row).val();
            var slvl = $('#slvl_' + row).val();
            var fcvl = $('#fcvl_' + row).val();
            var mkvl = $('#mkvl_' + row).val();

            if (checkScale(nscl, row) & checkQty(qty, row) & checkSlvl(slvl, row) & checkFcvl(fcvl, row) & checkMkvl(mkvl, row)) {
                $('#stBrchID').val(stock);
                $('#addQty').val(qty);
                $('#qtyTitle').html(" - (" + qty + ")");
                $('#newScal').val(newScal);
                $('#newCsvl').val(csvl);
                $('#newSlvl').val(slvl);
                $('#newFcvl').val(fcvl);
                $('#newMkvl').val(mkvl);
                $('#added_srl').html('');
                srchSrlNum();
                $('#added_srl').html('');
                $('#modal-srl').modal('show');
            }
        }

        //Search Serial Numbers
        function srchSrlNum() {
            var val = $('#srlSrch').val();
            $('#srl_Number_Area').html('');

            var stock = $('#stBrchID').val();
            swal({
                title: "Searching...",
                text: "",
                imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                showConfirmButton: false
            });

            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>Stock/srch_SrlNumCon",
                data: {
                    val: val,
                    stid: stock
                },
                dataType: 'json',
                success: function (data) {
                    var area = "";
                    var len = data.length;
                    if (len > 0) {
                        var stat = "";
                        for (var srl = 0; srl < len; srl++) {
                            var sbsid = data[srl]['sbsid'];
                            var srno = data[srl]['srno'];
                            area = area + '<div class="col-md-4">\n' +
                                '                                    <div class="app-widget-tile">\n' +
                                '                                        <div class="line">\n' +
                                '                                            <div class="title"><span class="badge badge-bordered badge-primary" title="Serial Number">' + srno + '</span></div>\n' +
                                '                                            <div class="title pull-right"><button type="button" onclick="addSrl(' + sbsid + ',' + srno + ',this)" class="btn btn-xs btn-info btn-rounded btn-condensed">Add</button></div>\n' +
                                '                                        </div>\n' +
                                '                                    </div>\n' +
                                '                                </div>';
                        }
                    } else {
                        area = "<h3>-- No Serial Numbers --</h3>";
                    }
                    $('#srl_Number_Area').html(area);
                    swal.close();
                },
                error: function (data, textStatus) {
                    $('#srl_Number_Area').html(area);
                    swal.close();
                }
            });
        }

        function srchSrlNumEdt() {
            var val = $('#srlSrchEdt').val();
            $('#srl_Number_AreaEdt').html('');
            $('#added_srlEdt').html('');

            var stock = $('#pr_stid_Vw').val();
            swal({
                title: "Searching...",
                text: "",
                imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                showConfirmButton: false
            });

            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>Stock/srch_SrlNumCon",
                data: {
                    val: val,
                    stid: stock
                },
                dataType: 'json',
                success: function (data) {
                    var area = "";
                    var len = data.length;
                    if (len > 0) {
                        var stat = "";
                        for (var srl = 0; srl < len; srl++) {
                            var sbsid = data[srl]['sbsid'];
                            var srno = data[srl]['srno'];
                            area = area + '<div class="col-md-3">\n' +
                                '                                    <div class="app-widget-tile">\n' +
                                '                                        <div class="line">\n' +
                                '                                            <div class="title"><span class="badge badge-bordered badge-primary" title="Serial Number">' + srno + '</span></div>\n' +
                                '                                            <div class="title pull-right"><button type="button" onclick="addSrlEdt(' + sbsid + ',' + srno + ',this)" class="btn btn-xs btn-info btn-rounded btn-condensed">Add</button></div>\n' +
                                '                                        </div>\n' +
                                '                                    </div>\n' +
                                '                                </div>';
                        }
                    } else {
                        area = "<h3>-- No Serial Numbers --</h3>";
                    }
                    $('#srl_Number_AreaEdt').html(area);
                    swal.close();
                },
                error: function (data, textStatus) {
                    $('#srl_Number_AreaEdt').html(area);
                    swal.close();
                }
            });
        }

        //Add Serial Number
        function addSrl(id, srl, node) {
            var flag = true;
            var len = $("input[name='srlnum[]']").length;
            $("input[name='srlnum[]']").each(function () {
                if (this.value == id) {
                    flag = false;
                }
            });

            if (len < +$('#addQty').val()) {
                $(node).parent().parent().parent().parent().remove();
                if (flag) {
                    $('#added_srl').append('<div class="col-md-4">\n' +
                        '                                    <div class="app-widget-tile">\n' +
                        '                                        <div class="line">\n' +
                        '                                            <div class="title"><span class="badge badge-bordered badge-primary" title="Serial Number">' + srl + '</span></div>\n' +
                        '                                            <div class="title pull-right"><button type="button" onclick="removeSrl(this)" class="btn btn-xs btn-warning btn-rounded btn-condensed"><span class="fa fa-close"></span></button></div>\n' +
                        '                                        <input type="hidden" id="" name="srlnum[]" value="' + id + '"/>' +
                        '                                        </div>\n' +
                        '                                    </div>\n' +
                        '                                </div>');
                } else {
                    swal({title: "", text: "Already Added", type: "warning"});
                }
            } else {
                swal({title: "", text: "Quantity reached", type: "warning"});
            }
        }

        function addSrlEdt(id, srl, node) {
            var flag = true;
            var len = $("input[name='srlnumEdt[]']").length;
            $("input[name='srlnumEdt[]']").each(function () {
                if (this.value == id) {
                    flag = false;
                }
            });

            if (len < +$('#conQty').val()) {
                $(node).parent().parent().parent().parent().remove();
                if (flag) {
                    $('#added_srlEdt').append('<div class="col-md-3">\n' +
                        '                                    <div class="app-widget-tile">\n' +
                        '                                        <div class="line">\n' +
                        '                                            <div class="title"><span class="badge badge-bordered badge-primary" title="Serial Number">' + srl + '</span></div>\n' +
                        '                                            <div class="title pull-right"><button type="button" onclick="removeSrl(this)" class="btn btn-xs btn-warning btn-rounded btn-condensed"><span class="fa fa-close"></span></button></div>\n' +
                        '                                        <input type="hidden" id="" name="srlnumEdt[]" value="' + id + '"/>' +
                        '                                        </div>\n' +
                        '                                    </div>\n' +
                        '                                </div>');
                } else {
                    swal({title: "", text: "Already Added", type: "warning"});
                }
            } else {
                swal({title: "", text: "Quantity reached", type: "warning"});
            }
        }

        //Remove Serial
        function removeSrl(node) {
            $(node).parent().parent().parent().parent().remove();
        }

        //Add to Convert
        $('#addBtn').click(function (e) {
            e.preventDefault();
            if ($("input[name='srlnum[]']").length == +$('#addQty').val()) {
                $('#addBtn').prop('disabled', true);
                swal({
                    title: "Processing...",
                    text: "",
                    imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                    showConfirmButton: false
                });
                jQuery.ajax({
                    type: "POST",
                    url: "<?= base_url(); ?>Stock/addToConv",
                    data: $("#addForm").serialize(),
                    dataType: 'json',
                    success: function (data) {
                        swal({title: "", text: "Added to convert!", type: "success"},
                            function () {
                                $('#addBtn').prop('disabled', false);
                                clear_Form('addForm');
                                $('#modal-srl').modal('hide');
                                loadStcks();
                                srchConStck();
                            });
                    },
                    error: function () {
                        swal({title: "", text: "Failed !", type: "error"},
                            function () {
                                location.reload();
                            });
                    }
                });
            } else {
                swal({title: "", text: "Quantity not reached", type: "warning"});
            }
        });

        //Search Conversion stocks
        function srchConStck() {
            var stat = document.getElementById('stats').value;   //STAT
            var dtrng = document.getElementById('dtrng').value;   //Date range
            var brch = document.getElementById('brchs').value;   //Branch
            var item = document.getElementById('itms').value;   //Item

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
                    {className: "text-center", "targets": [0, 9, 10, 11]},
                    {className: "text-right", "targets": [4, 5, 6, 7, 8]},
                    {className: "text-nowrap", "targets": [2, 3]}
                ],
                "order": [[9, "DESC"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '1%'},
                    {sWidth: '5%'},
                    {sWidth: '1%'},
                    {sWidth: '15%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '3%'},
                    {sWidth: '3%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '15%'}
                ],
                "ajax": {
                    url: '<?= base_url(); ?>Stock/srchConStck',
                    type: 'post',
                    data: {
                        brch: brch,
                        item: item,
                        stat: stat,
                        dtrng: dtrng
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
                },
            });
        }

        //Reject Conversion stock
        function rejecStck(id) {
            swal({
                    title: "Are you sure ?",
                    text: "Your will not be able to revers this process",
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
                            url: '<?= base_url(); ?>Stock/rejConStock',
                            type: 'post',
                            data: {
                                id: id,
                            },
                            dataType: 'json',
                            success: function (response) {
                                swal({title: "", text: "Stock Rejected!", type: "success"},
                                    function () {
                                        srchConStck();
                                    });
                            },
                            error: function (data, jqXHR, textStatus, errorThrown) {
                                swal({title: "error", text: "Faild", type: "error"},
                                    function () {
                                        location.reload();
                                    });
                            }
                        });
                    } else {
                        swal("Cancelled !", "Stock not reject", "warning");
                    }
                });
        }

        //VIEW || EDIT || APPROVE VIEW
        function viewStck(id, func) {
            $('#func').val(func);
            $('#stid_Vw').val(id);

            swal({
                title: "Please wait...",
                text: "Retrieving Data...",
                imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                showConfirmButton: false
            });

            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>Stock/vewConStock",
                data: {
                    auid: id
                },
                dataType: 'json',
                success: function (response) {
                    var des = "";

                    if (func == 'vew') {
                        //VIEW MODEL
                        $('#conStViewTitle').html(' - View');
                        $('#edtBtn').css('display', 'none');
                        $("#modal-view").find('.edit_req').css("display", "none");
                        $(".edit_Area").css('display', 'none');
                        $(".view_Area").css('display', 'block');
                        $(".req-astrick").css('display', 'none');
                        //Make readonly all fields
                        $("#modal-view :input").attr("readonly", true);
                        disableSelct('vewScale');
                        //VIEW MODEL
                        var des = "disabled";
                    } else if (func == 'edt') {
                        //EDIT MODEL
                        $('#conStViewTitle').html(' - Edit');
                        $('#edtBtn').css('display', 'inline');
                        $('#edtBtn').html('Update');
                        $("#modal-view").find('.edit_req').css("display", "inline");
                        $(".edit_Area").css('display', 'block');
                        $(".view_Area").css('display', 'none');
                        $(".req-astrick").css('display', 'inline');
                        //Remove readonly all fields
                        $("#modal-view :input").attr("readonly", false);
                        $("#vewCstvl").attr("readonly", true);
                        enableSelct('vewScale');
                        //EDIT MODEL
                    } else if (func == 'app') {
                        //APPROVE MODEL
                        $('#conStViewTitle').html(' - Approve');
                        $('#edtBtn').css('display', 'inline');
                        $('#edtBtn').html('Approve');
                        $("#modal-view").find('.edit_req').css("display", "inline");
                        $(".edit_Area").css('display', 'block');
                        $(".view_Area").css('display', 'none');
                        $(".req-astrick").css('display', 'inline');
                        //Remove readonly all fields
                        $("#modal-view :input").attr("readonly", false);
                        $("#vewCstvl").attr("readonly", true);
                        enableSelct('vewScale');
                        //APPROVE MODEL
                    }


                    var len = response['stdt'].length;
                    var len2 = response['sbdt'].length;
                    if (len > 0) {
                        $('#conStViewTitle').html($('#conStViewTitle').html()+" | "+response['stdt'][0]['stcd']);
                        document.getElementById("vewCat").innerHTML = ": " + response['stdt'][0]['ctcd'] + " | " + response['stdt'][0]['ctnm'];
                        document.getElementById("vewBrnd").innerHTML = ": " + response['stdt'][0]['bdcd'] + " | " + response['stdt'][0]['bdnm'];
                        document.getElementById("vewMdl").innerHTML = ": " + response['stdt'][0]['mlcd'] + " | " + response['stdt'][0]['mdl'];
                        document.getElementById("vewTyp").innerHTML = ": " + response['stdt'][0]['tpcd'] + " | " + response['stdt'][0]['tpnm'];
                        document.getElementById("vewSize").innerHTML = ": " + response['stdt'][0]['size'] + " " + response['stdt'][0]['sscl'] + " (" + response['stdt'][0]['sscnm'] + ")";
                        document.getElementById("vewName").innerHTML = ": " + response['stdt'][0]['itcd'] + " | " + response['stdt'][0]['itnm'];
                        document.getElementById("vewCstvl").value = response['stdt'][0]['csvl'];
                        document.getElementById("vewFcvl").value = response['stdt'][0]['fcvl'];
                        document.getElementById("vewSalvl").value = response['stdt'][0]['slvl'];
                        document.getElementById("vewMktvl").value = response['stdt'][0]['mkvl'];
                        document.getElementById("vewQunty").innerHTML = ": " + response['stdt'][0]['qunt'];
                        document.getElementById("vewAvQunty").innerHTML = ": " + response['stdt'][0]['avqn'] + " " + response['stdt'][0]['scl'] + " (" + response['stdt'][0]['scnm'] + ")";
                        document.getElementById("conQty").value = len2;

                        set_select('vewScale',response['stdt'][0]['cslid']);

                        //STATUS
                        if (response['stdt'][0]['stat'] == 0) {
                            var stat = "<label class='label label-warning'>Pending</label>";
                        } else if (response['stdt'][0]['stat'] == 1) {
                            var stat = "<label class='label label-success'>Active</label>";
                        } else if (response['stdt'][0]['stat'] == 2) {
                            var stat = "<label class='label label-primary'>Finish</label>";
                        } else if (response['stdt'][0]['stat'] == 3) {
                            var stat = "<label class='label label-danger'>Reject</label>";
                        } else {
                            var stat = "NOP";
                        }

                        $('#stc_stat').html(stat);

                        $('#crby').html(": " + response['stdt'][0]['crnm']);
                        $('#crdt').html(": " + response['stdt'][0]['crdt']);
                        $('#apby').html(": " + ((response['stdt'][0]['apnm'] != null) ? response['stdt'][0]['apnm'] : "--"));
                        $('#apdt').html(": " + ((response['stdt'][0]['apdt'] != null && response['stdt'][0]['apdt'] != "0000-00-00 00:00:00") ? response['stdt'][0]['apdt'] : "--"));
                        $('#rjby').html(": " + ((response['stdt'][0]['rjnm'] != null) ? response['stdt'][0]['rjnm'] : "--"));
                        $('#rjdt').html(": " + ((response['stdt'][0]['rjdt'] != null && response['stdt'][0]['rjdt'] != "0000-00-00 00:00:00") ? response['stdt'][0]['rjdt'] : "--"));
                        $('#mdby').html(": " + ((response['stdt'][0]['mdnm'] != null) ? response['stdt'][0]['mdnm'] : "--"));
                        $('#mddt').html(": " + ((response['stdt'][0]['mddt'] != null && response['stdt'][0]['mddt'] != "0000-00-00 00:00:00") ? response['stdt'][0]['mddt'] : "--"));

                        var sbdt = response['sbdt'];
                        if (len2 > 0) {
                            $('#pr_stid_Vw').val(sbdt[0]['stbid']);
                            $('#added_srlEdt').html('');
                            var area = "";
                            for (var srl = 0; srl < len2; srl++) {
                                area = area + '<div class="col-md-3">\n' +
                                    '                                    <div class="app-widget-tile">\n' +
                                    '                                        <div class="line">\n' +
                                    '                                            <div class="title"><span class="badge badge-bordered badge-primary" title="Serial Number">' + sbdt[srl]['srno'] + '</span></div>\n' +
                                    '                                            <div class="title pull-right"><button ' + des + ' type="button" onclick="removeSrl(this)" class="btn btn-xs btn-warning btn-rounded btn-condensed"><span class="fa fa-close"></span></button></div>\n' +
                                    '                                        <input type="hidden" id="" name="srlnumEdt[]" value="' + sbdt[srl]['sbsid'] + '"/>' +
                                    '                                        </div>\n' +
                                    '                                    </div>\n' +
                                    '                                </div>';
                            }
                            $('#added_srlEdt').html(area);
                        } else {
                            $('#added_srlEdt').html("Empty");
                        }
                    }
                    swal.close();
                }
            });
        }

        //EDIT || APPROVE
        $('#edtBtn').click(function (e) {
            e.preventDefault();
            var len = $("input[name='srlnumEdt[]']").length;
            var len2 = +$('#conQty').val();
            if($('#appForm').valid()){
                $('#srlSrchEdt').parent().next('.error').remove();
                if(len==len2){
                    swal({
                            title: "Are you sure this process",
                            text: "",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3bdd59",
                            confirmButtonText: "Yes!",
                            cancelButtonText: "No!",
                            closeOnConfirm: false,
                            closeOnCancel: false
                        },
                        function (isConfirm) {
                            $('#edtBtn').attr('disabled', true);
                            if ($('#func').val() == 'app') {
                                var msg = 'Convertion completed';
                            } else {
                                var msg = 'Convertion updated';
                            }

                            if (isConfirm) {
                                var jqXHR = jQuery.ajax({
                                    type: "POST",
                                    url: "<?= base_url(); ?>Stock/edtConStock",
                                    data: $("#appForm").serialize(),
                                    dataType: 'json',
                                    success: function (data) {
                                        swal({title: "", text: msg, type: "success"},
                                            function () {
                                                $('#edtBtn').attr('disabled', false);
                                                clear_Form('appForm');
                                                $('#srl_Number_AreaEdt').html('');
                                                $('#added_srlEdt').html('');
                                                $('#modal-view').modal('hide');
                                                srchConStck();
                                            });
                                    },
                                    error: function () {
                                        swal({title: "", text: "Faild", type: "error"},
                                            function () {
                                                location.reload();
                                            });
                                    }
                                });
                            } else {
                                swal("Cancelled", " ", "warning");
                            }
                        });
                }else{
                    $('#srlSrchEdt').parent().after("<label id='name-error' class='error' style='font-size: 13px;color: red; font-style: italic;' for='srlSrchEdt'>Quantity not reached</label>");
                }
            }
        });

        //Deactivate Stock
        function deacStck(id) {
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
                            url: "<?= base_url(); ?>Stock/conStck_Deactive",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (data) {
                                swal({title: "", text: "Stock was deactivated!", type: "success"},
                                    function () {
                                        srchConStck();
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

        //activate Stock
        function reacStck(id) {
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
                            url: "<?= base_url(); ?>Stock/conStck_Activate",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (data) {
                                swal({title: "", text: "Stock was activated!", type: "success"},
                                    function () {
                                        srchConStck();
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
