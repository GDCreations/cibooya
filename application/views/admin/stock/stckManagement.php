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
                <div class="form-group">
                    <label class="col-md-4 col-xs-12 control-label">Date Range</label>
                    <div class="col-md-8 col-xs-12">
                        <div class='input-group'>
                            <input type='text' class="form-control dateranger" id="dtrng" name="dtrng"
                                   value="<?= date('Y-m-d', strtotime('-1 months')) ?> / <?= date('Y-m-d') ?>"/>
                            <span class="input-group-addon">
                                <span class="fa fa-calendar"></span>
                            </span>
                        </div>
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

    <!-- MODAL ADD NEW STOCK -->
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
                                        <label class="col-md-4 col-xs-6 control-label">Supplier Name <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
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
                                        <label class="col-md-4 col-xs-6 control-label"> GRN No <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
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
                                <h5 class="text-title"><span class="fa fa-tag"></span> Stock Details</h5>
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
    <!-- END ADD NEW STOCK -->

    <!-- MODAL VIEW STOCK -->
    <div class="modal fade" id="modal-view" tabindex="-1" role="dialog" aria-labelledby="modal-default-header">
        <div class="modal-dialog modal-lg" role="document">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="icon-cross"></span>
            </button>
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> Stock
                        Management <span class="text-muted"> - View</span></h4>
                    <input type="hidden" name="stid_Vw" id="stid_Vw"/>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs nav-pills">
                        <li class="active"><a href="#tabs-1" role="tab" data-toggle="tab">Stock Details</a>
                        </li>
                        <li id="hrfTab2"><a href="#tabs-2" role="tab" data-toggle="tab">Codes / Serial</a>
                        </li>
                    </ul>
                    <div class="tab-content tab-content">
                        <div class="tab-pane active" id="tabs-1">
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
                                            <label class="col-md-4 col-xs-12 control-label">Supplier</label>
                                            <label class="col-md-8 col-xs-12 control-label" id="vewSpl"> </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Brand</label>
                                            <label class="col-md-8 col-xs-12 control-label" id="vewBrnd"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Size (Type)</label>
                                            <label class="col-md-8 col-xs-12 control-label" id="vewTyp"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">GRN No</label>
                                            <label class="col-md-8 col-xs-12 control-label" id="vewGrno"> </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Quantity</label>
                                            <label class="col-md-8 col-xs-12 control-label" id="vewQunty"> </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Free Quantity</label>
                                            <label class="col-md-8 col-xs-12 control-label" id="vewFrQunty"> </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Cost Value</label>
                                            <label class="col-md-8 col-xs-12 control-label" id="vewCstvl"> </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Cost + Tax</label>
                                            <label class="col-md-8 col-xs-12 control-label" id="vewTaxvl"> </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Sales Value</label>
                                            <label class="col-md-8 col-xs-12 control-label" id="vewSalvl"> </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Face (Display) Value</label>
                                            <label class="col-md-8 col-xs-12 control-label" id="vewFcvl"> </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Market Value</label>
                                            <label class="col-md-8 col-xs-12 control-label" id="vewMktvl"> </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-horizontal">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Status</label>
                                            <label class="col-md-10 control-label" id="stc_stat"></label>
                                        </div>
                                        <div class="form-group">
                                            <hr>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-horizontal">
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
                        <div class="tab-pane" id="tabs-2">
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
                            <div class="row form-horizontal scroll" style="height: 300px;" id="srl_Number_Area">
                                <h3>-- No Serial Numbers --</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END VIEW STOCK -->

    <!-- MODAL EDIT APPROVE SUPPLIER -->
    <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="modal-default-header">
        <div class="modal-dialog modal-lg" role="document" style="width: 90%">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="icon-cross"></span>
            </button>
            <form id="appForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> Stock
                            Management
                            <span class="text-muted" id="subTitle_edit"></span></h4>
                        <input type="hidden" id="func" name="func"/>
                        <input type="hidden" id="stkid" name="stkid"/>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row form-horizontal">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Supplier Name </label>
                                        <label class="col-md-6 col-xs-6 control-label" id="supp_edt"></label>
                                        <input type="hidden" id="spid_edt" name="spid_edt"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label"> GRN No </label>
                                        <label class="col-md-6 col-xs-6 control-label" id="grn_edt"></label>
                                        <input type="hidden" id="grid_edt" name="grid_edt"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label"> Stock Warehouse</label>
                                        <label class="col-md-6 col-xs-6 control-label" id="whnm_edt"></label>
                                        <input type="hidden" id="whid_edt" name="whid_edt">
                                    </div>
                                </div>
                            </div>
                            <div class="row form-horizontal">
                                <h5 class="text-title"><span class="fa fa-tag"></span> Stock Details</h5>
                            </div>
                            <div class="row form-horizontal">
                                <div class="col-md-12">
                                    <div class="table-responsive" style="padding: 10px 25px 10px 10px ">
                                        <table class="table dataTable table-bordered table-striped" id="grnTbl_edt"
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
                                        </table>
                                    </div>
                                    <input type="hidden" class="form-control" id="sblnxx" name="">
                                    <input type="hidden" class="form-control" id="qutyaa" name="">
                                </div>
                            </div>
                            <div class="row form-horizontal">
                                <h5 class="text-title"><span class="fa fa-tag"></span> Stock Sub Details</h5>
                                <button type="button" data-toggle='modal'
                                        data-target='#modal_gennummedt'
                                        class="btn btn-info btn-sm btn-rounded pull-right"
                                        id="show">Generate Number
                                </button>
                            </div>
                            <div class="row form-horizontal">
                                <div class="col-md-12 scroll" style="height: 500px;">
                                    <div class="table-responsive" style="padding: 10px 25px 10px 10px ">
                                        <table class="table table-bordered  table-actions" id="stckSub"
                                               style="width: 100%">
                                            <thead>
                                            <tr>
                                                <th width="" class="text-left">NO</th>
                                                <th width="" class="text-left">SERIAL NO</th>
                                                <th width="" class="text-left">BATCH NO</th>
                                                <th width="" class="text-left">PART NO</th>
                                                <th width="" class="text-left">BARCODE</th>
                                                <th width="" class="text-left">ABC</th>
                                                <th width="" class="text-left">XYZ</th>
                                                <th width="" class="text-left">REMARKS</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                            </tfoot>
                                        </table>
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
                        <button type="button" id="edtBtn" class="btn btn-warning btn-sm btn-rounded">
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END EDIT APPROVE SUPPLIER -->

    <!--    GENERATE NUMBERS MODEL-->
    <div class="modal fade" id="modal_gennummedt" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="modal-default-header">
        <div class="modal-dialog" role="document">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="icon-cross"></span>
            </button>
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> Number Generator
                    </h4>
                </div>
                <form id="genNum_form">
                    <div class="modal-body">
                        <div class="container">
                            <div class="row form-horizontal">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-5 col-xs-12 control-label">No
                                            Type</label>
                                        <div class="col-md-7 col-xs-12">
                                            <select class="bs-select"
                                                    name="notypeedt" id="notypeedt"
                                                    onchange="">
                                                <option value="0"> -- Select NO --
                                                </option>
                                                <option value="1"> Serial No</option>
                                                <option value="2"> Batch No</option>
                                                <option value="3"> Part No</option>
                                                <option value="4"> Barcode</option>
                                                <option value="5"> ABC</option>
                                                <option value="6">XYZ</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" id="seqeedt"
                                         style="display: block">
                                        <label class="col-md-5 col-xs-12 control-label">
                                            Enter No.
                                        </label>
                                        <div class="col-md-7 col-xs-12">
                                            <input type="text" class="form-control"
                                                   id="normlnumedt" name="normlnumedt">
                                        </div>
                                    </div>
                                    <div class="form-group" id="strtedt"
                                         style="display: none">
                                        <label class="col-md-5 col-xs-12 control-label">
                                            Start No.
                                        </label>
                                        <div class="col-md-7 col-xs-12">
                                            <input type="text" class="form-control"
                                                   id="strtnumedt" name="strtnumedt">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-6 col-xs-12 control-label">If
                                            Sequence</label>
                                        <div class="col-md-6 col-xs-12">
                                            <label class="switch">
                                                <input onchange="squenceedt()"
                                                       name="sameedt" id="sameedt"
                                                       type="checkbox"
                                                       value="1"/>
                                                No </label>
                                            Yes
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                        <button type="button" id="numGenBtn" onclick="gennumberedt();"
                                class="btn btn-warning btn-sm btn-rounded">
                            Generate
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--   END GENERATE NUMBERS MODEL-->

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
                        tblar_min: 'txpr[]'
                    },
                    'slvl[]': {
                        required: true,
                        currency: true,
                        notEqual: '0',
                        tblar_min: 'csvl[]'
                    },
                    'dsvl[]': {
                        required: true,
                        currency: true,
                        notEqual: '0',
                        tblar_min: 'slvl[]'
                    },
                    'mkvl[]': {
                        currency: true
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
                    }
                }
            });

            //Number Generation
            $("#genNum_form").validate({
                rules: {
                    notypeedt: {
                        notEqual: 0
                    },
                    normlnumedt: {
                        required: true,
                        digits: true
                    },
                    strtnumedt: {
                        required: true,
                        digits: true
                    }
                },
                messages: {
                    notypeedt: {
                        notEqual: "Select number type"
                    },
                    normlnumedt: {
                        required: "Enter number"
                    },
                    strtnumedt: {
                        required: "Enter start number"
                    }
                }
            });

            // EDIT VALIDATE
            $("#appForm").validate({
                rules: {
                    csvlEdt: {
                        required: true,
                        notEqual: '0',
                        currency: true,
                        lessThanOrEqual: '#txvlEdt'
                    },
                    slvlEdt: {
                        required: true,
                        notEqual: '0',
                        currency: true,
                        lessThanOrEqual: '#csvlEdt'
                    },
                    dsvlEdt: {
                        required: true,
                        notEqual: '0',
                        currency: true,
                        lessThanOrEqual: '#slvlEdt'
                    },
                    mkvlEdt: {
                        currency: true
                    },
                    'csvlEdt[]': {
                        required: true,
                        currency: true,
                        notEqual: '0',
                        tblar_min: 'txprEdt[]'
                    },
                    'slvlEdt[]': {
                        required: true,
                        currency: true,
                        notEqual: '0',
                        tblar_min: 'csvlEdt[]'
                    },
                    'dsvlEdt[]': {
                        required: true,
                        currency: true,
                        notEqual: '0',
                        tblar_min: 'slvlEdt[]'
                    },
                    'mkvlEdt[]': {
                        currency: true
                    },
                    'serno[]': {
                        required: true
                    }
                },
                messages: {
                    csvlEdt: {
                        required: 'Please enter cost value',
                        notEqual: "Can't enter zero value",
                    },
                    fcvlEdt: {
                        required: 'Please enter face value',
                        notEqual: "Can't enter zero value",
                    },
                    slvlEdt: {
                        required: 'Please enter sales value',
                        notEqual: "Can't enter zero value",
                    },
                    'csvlEdt[]': {
                        required: 'Please enter cost value',
                        notEqual: "Can't enter zero value"
                    },
                    'slvlEdt[]': {
                        required: 'Please enter sales value',
                        notEqual: "Can't enter zero value"
                    },
                    'dsvlEdt[]': {
                        required: 'Please enter face value',
                        notEqual: "Can't enter zero value"
                    },
                    'serno[]': {
                        required: "This field is required"
                    }
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
                ]
            });
            srchStck();
        });

        function srchStck() {
            var cat = document.getElementById('cats').value;   //CATEGORY
            var brnd = document.getElementById('brnds').value;   //BRAND
            var typ = document.getElementById('typs').value;   //MODE
            var stat = document.getElementById('stats').value;   //STAT
            var dtrng = document.getElementById('dtrng').value;   //Date range

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
                    {className: "text-nowrap", "targets": [2, 3]}
                ],
                "order": [[10, "DESC"]], //ASC  desc
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
                            var txunt = +grnd[a]['untp'] + ((+grnd[a]['untp'] * +grn[0]['rate']) / 100);

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

        // CHECK & COMPARE OTHER VALUE
        function chkValEdt(typvl, type) {
            var txpr = parseInt(document.getElementById('txvlEdt').value);
            var csvl = parseInt(document.getElementById('csvlEdt').value);
            var slvl = parseInt(document.getElementById('slvlEdt').value);
            if (type == 'cost') {
                if (txpr > typvl) {
                    document.getElementById('csvlEdt').style.borderColor = "red";
                    document.getElementById('edtBtn').disabled = true;
                } else {
                    document.getElementById('csvlEdt').style.borderColor = '';
                    document.getElementById('edtBtn').disabled = false;
                }
            } else if (type == 'sale') {
                if (csvl > typvl) {
                    document.getElementById('slvlEdt').style.borderColor = "red";
                    document.getElementById('edtBtn').disabled = true;
                } else {
                    document.getElementById('slvlEdt').style.borderColor = '';
                    document.getElementById('edtBtn').disabled = false;
                }
            } else if (type == 'disp') {
                if (slvl > typvl) {
                    document.getElementById('dsvlEdt').style.borderColor = "red";
                    document.getElementById('edtBtn').disabled = true;
                } else {
                    document.getElementById('dsvlEdt').style.borderColor = '';
                    document.getElementById('edtBtn').disabled = false;
                }
            }
        }

        //ADD STOCK
        $('#addBtn').click(function (e) {
            e.preventDefault();
            if ($('#addForm').valid()) {
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
                                $('#grnTbl').DataTable().clear().draw();
                                $('#modal-add').modal('hide');
                                srchStck();
                                document.getElementById('ttlQt').innerHTML = '00';
                                document.getElementById('ttlQt2').value = 0;
                                document.getElementById('ttlFr').innerHTML = '00';
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

        //VIEW GRN
        function viewStck(auid) {
            swal({
                title: "Please wait...",
                text: "Retrieving Data...",
                imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                showConfirmButton: false
            });

            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>Stock/vewStock",
                data: {
                    auid: auid
                },
                dataType: 'json',
                success: function (response) {
                    $('#stid_Vw').val(auid);
                    var len = response['stdt'].length;
                    if (len > 0) {
                        document.getElementById("vewCat").innerHTML = ": " + response['stdt'][0]['ctcd'] + " | " + response['stdt'][0]['ctnm'];
                        document.getElementById("vewBrnd").innerHTML = ": " + response['stdt'][0]['bdcd'] + " | " + response['stdt'][0]['bdnm'];
                        document.getElementById("vewMdl").innerHTML = ": " + response['stdt'][0]['mlcd'] + " | " + response['stdt'][0]['mdl'];
                        document.getElementById("vewTyp").innerHTML = ": " + response['stdt'][0]['tpcd'] + " | " + response['stdt'][0]['tpnm'];
                        document.getElementById("vewName").innerHTML = ": " + response['stdt'][0]['itcd'] + " | " + response['stdt'][0]['itnm'];
                        document.getElementById("vewSpl").innerHTML = ": " + response['stdt'][0]['spcd'] + ' | ' + response['stdt'][0]['spnm'];
                        document.getElementById("vewCstvl").innerHTML = ": " + numeral(response['stdt'][0]['csvl']).format('0,0.00');
                        document.getElementById("vewFcvl").innerHTML = ": " + numeral(response['stdt'][0]['fcvl']).format('0,0.00');
                        document.getElementById("vewSalvl").innerHTML = ": " + numeral(response['stdt'][0]['slvl']).format('0,0.00');
                        document.getElementById("vewTaxvl").innerHTML = ": " + numeral(response['stdt'][0]['txvl']).format('0,0.00');
                        document.getElementById("vewMktvl").innerHTML = ": " + numeral(response['stdt'][0]['mkvl']).format('0,0.00');
                        document.getElementById("vewGrno").innerHTML = ": " + response['stdt'][0]['grno'];
                        document.getElementById("vewQunty").innerHTML = ": " + response['stdt'][0]['qunt'];
                        document.getElementById("vewFrQunty").innerHTML = ": " + response['stdt'][0]['frqt'];

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
                        $('#mdby').html(": " + ((response['stdt'][0]['apnm'] != null) ? response['stdt'][0]['apnm'] : "--"));
                        $('#mddt').html(": " + ((response['stdt'][0]['apdt'] != null && response['stdt'][0]['apdt'] != "0000-00-00 00:00:00") ? response['stdt'][0]['apdt'] : "--"));

                        var len2 = response['sbdt'].length;
                        var sbdt = response['sbdt'];
                        if (len2 > 0) {
                            $('#hrfTab2').css('pointer-events', '');
                            $('#hrfTab2').find('a').removeClass('text-muted');
                            $('#srl_Number_Area').html('');

                            var area = "";
                            for (var srl = 0; srl < len2; srl++) {
                                var stat = "";
                                if (sbdt[srl]['stat'] == 0) {
                                    stat = '<span class="label label-warning label-ghost label-bordered" title="Inactive">Inact.</span>';
                                } else if (sbdt[srl]['stat'] == 1) {
                                    stat = '<span class="label label-primary label-ghost label-bordered" title="Active">Act.</span>';
                                } else if (sbdt[srl]['stat'] == 2) {
                                    stat = '<span class="label label-success label-ghost label-bordered" title="Sold">Sold</span>';
                                }
                                var trst = "";
                                if (sbdt[srl]['trst'] == 1) {
                                    trst = '<span class="label label-info label-ghost label-bordered" title="Transfered">TR</span>';
                                }

                                var sldt = (sbdt[srl]['sldt'] == null) ? '--' : sbdt[srl]['sldt'];
                                area = area + '<div class="col-md-3">\n' +
                                    '                                    <div class="app-widget-tile">\n' +
                                    '                                        <div class="line">\n' +
                                    '                                            <div class="title"><span class="badge badge-bordered badge-primary" title="Serial Number">' + sbdt[srl]['srno'] + '</span></div>\n' +
                                    '                                            <div class="title pull-right">' + stat + '</div>\n' +
                                    '                                            <div class="title pull-right">' + trst + '</div>\n' +
                                    '                                        </div>\n' +
                                    '                                        <div class="line">\n' +
                                    '                                            <div class="subtitle">Sold At</div>\n' +
                                    '                                            <div class="subtitle pull-right text-success">' + sldt + '</div>\n' +
                                    '                                        </div>\n' +
                                    '                                    </div>\n' +
                                    '                                </div>';
                            }
                            $('#srl_Number_Area').html(area);
                        } else {
                            $('#hrfTab2').css('pointer-events', 'none');
                            $('#hrfTab2').find('a').addClass('text-muted');
                        }
                    }
                    swal.close();
                }
            });
        }

        //SEARCH SEARIAL NUMBER ITEM
        function srchSrlNum() {
            var val = $('#srlSrch').val();
            $('#srl_Number_Area').html('');
            swal({
                title: "Searching...",
                text: "",
                imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                showConfirmButton: false
            });

            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>Stock/srch_SrlNum",
                data: {
                    val: val,
                    stid: function () {
                        return $('#stid_Vw').val();
                    }
                },
                dataType: 'json',
                success: function (data) {
                    var area = "";
                    var len = data.length;
                    if (len > 0) {
                        var stat = "";
                        for (var srl = 0; srl < len; srl++) {
                            if (data[srl]['stat'] == 0) {
                                stat = '<span class="label label-warning label-ghost label-bordered" title="Inactive">Inact.</span>';
                            } else if (data[srl]['stat'] == 1) {
                                stat = '<span class="label label-primary label-ghost label-bordered" title="Active">Act.</span>';
                            } else if (data[srl]['stat'] == 2) {
                                stat = '<span class="label label-success label-ghost label-bordered" title="Sold">Sold</span>';
                            }
                            var trst = "";
                            if (data[srl]['trst'] == 1) {
                                trst = '<span class="label label-info label-ghost label-bordered" title="Transfered">TR</span>';
                            }

                            var sldt = (data[srl]['sldt'] == null) ? '--' : data[srl]['sldt'];
                            area = area + '<div class="col-md-3">\n' +
                                '                                    <div class="app-widget-tile">\n' +
                                '                                        <div class="line">\n' +
                                '                                            <div class="title"><span class="badge badge-bordered badge-primary" title="Serial Number">' + data[srl]['srno'] + '</span></div>\n' +
                                '                                            <div class="title pull-right">' + stat + '</div>\n' +
                                '                                            <div class="title pull-right">' + trst + '</div>\n' +
                                '                                        </div>\n' +
                                '                                        <div class="line">\n' +
                                '                                            <div class="subtitle">Sold At</div>\n' +
                                '                                            <div class="subtitle pull-right text-success">' + sldt + '</div>\n' +
                                '                                        </div>\n' +
                                '                                    </div>\n' +
                                '                                </div>';
                        }
                    }else{
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

        //EDIT || APPROVE STOCK VIEW
        function edtStck(id, func) {
            swal({
                title: "Please wait...",
                text: "Retrieving Data...",
                imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                showConfirmButton: false
            });

            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>Stock/vewStock",
                data: {
                    auid: id
                },
                dataType: 'json',
                success: function (response) {
                    var len = response['stdt'].length;
                    var stdt = response['stdt'];
                    if (len > 0) {
                        $('#func').val(func);
                        $('#stkid').val(id);

                        if (func == 'app') {
                            $('#subTitle_edit').html(" - Approve");
                            $('#edtBtn').html("Approve");
                        } else if (func == 'edt') {
                            $('#subTitle_edit').html(" - Edit");
                            $('#edtBtn').html("Update");
                        }

                        $('#supp_edt').html(stdt[0]['spcd'] + " - " + stdt[0]['spnm']);
                        $('#spid_edt').val(stdt[0]['spid']);
                        $('#grn_edt').html(stdt[0]['grno']);
                        $('#grid_edt').html(stdt[0]['grid']);
                        $('#whnm_edt').html(stdt[0]['whcd'] + " - " + stdt[0]['whnm']);
                        $('#whid_edt').html(stdt[0]['whid']);

                        $('#grnTbl_edt').DataTable().clear();
                        var t = $('#grnTbl_edt').DataTable({
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
                                {sWidth: '20%'},   //
                                {sWidth: '5%'},    //
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

                        t.row.add([
                            1,
                            stdt[0]['itcd'],        // ITEM CODE
                            stdt[0]['itnm'],        // ITEM NAME
                            numeral(stdt[0]['qunt']).format('0,0'),     // ODR QUNT
                            numeral(stdt[0]['frqt']).format('0,0'),     // ODR QUNT
                            numeral(stdt[0]['untp']).format('0,0.00'),  // PRICE
                            numeral(stdt[0]['txvl']).format('0,0.00') + '<input type="hidden"  id="txvlEdt" name="txvlEdt[]" value="' + stdt[0]['txvl'] + '">',       // UNIT PRICE + TAX

                            '<input readonly type="text" class="form-control" style="text-align:right; width: 100px;" id="csvlEdt" name="csvlEdt[]" value="' + stdt[0]['csvl'] + '" onkeyup="chkValEdt(this.value,' + " 'cost'" + ')">',        // COST VALUE
                            '<span class="fa fa-asterisk req-astrick"></span> ' +
                            '<input type="text" class="form-control" style="text-align:right; width: 100px;" id="slvlEdt" name="slvlEdt[]" value="' + stdt[0]['slvl'] + '" onkeyup="chkValEdt(this.value,' + " 'sale'" + ')">',        // SALES VALUE
                            '<span class="fa fa-asterisk req-astrick"></span> ' +
                            '<input type="text" class="form-control" style="text-align:right; width: 100px;" id="dsvlEdt" name="dsvlEdt[]" value="' + stdt[0]['fcvl'] + '" onkeyup="chkValEdt(this.value,' + " 'disp'" + ')">',        // DISPLAY VALUE
                            '<input type="text" class="form-control" style="text-align:right; width: 100px;" id="mkvlEdt" name="mkvlEdt[]" value="' + stdt[0]['mkvl'] + '" onkeyup="chkValEdt(this.value,' + " 'mark'" + ')">',        // MARKET VALUE
                            '<input type="text" class="form-control" style="width: 100%" name="rmksEdt" value="' + response['stdt'][0]['dscr'] + '">',                   // REMARKS

                            // '<label class=""><input type="checkbox" name="blskEdt" id="checkbox_2"  ' + chck + ' class="icheckbox" onchange="showHid()"/> </label>'
                        ]).draw(false);
                        var qty = +stdt[0]['qunt'] + +stdt[0]['frqt']
                        document.getElementById('qutyaa').value = qty;
                        document.getElementById('sblnxx').value = '';

                        var len2 = response['sbdt'].length;
                        var sbdt = response['sbdt'];

                        //STOCK SUB DETAILS
                        $('#stckSub').DataTable().clear();
                        var tt2 = $('#stckSub').DataTable({
                            destroy: true,
                            searching: false,
                            bPaginate: false,
                            "ordering": false,
                            "columnDefs": [
                                {className: "text-left", "targets": []},
                                {className: "text-center", "targets": [0, 1, 2, 3, 4, 5, 6]},
                                {className: "text-right", "targets": []},
                                {className: "text-nowrap", "targets": []}
                            ],
                            "aoColumns": [
                                {sWidth: '5%'},
                                {sWidth: '10%'},    //
                                {sWidth: '10%'},    //
                                {sWidth: '10%'},     //
                                {sWidth: '10%'},
                                {sWidth: '10%'},
                                {sWidth: '10%'},
                                {sWidth: '10%'},
                            ],
                        });

                        if (len2 > 0) {
                            document.getElementById('sblnxx').value = len2;
                            for (var x = 0; x < qty; x++) {
                                tt2.row.add([
                                    x + 1 + '<input type="hidden" class="form-control"  id="" name="sbid[]" value="' + sbdt[x]['ssid'] + '">',
                                    '<input style="width: 100%" type="text" class="form-control"  id="serno_' + x + '" name="serno[]"  value="' + sbdt[x]['srno'] + '" onkeyup=""> ',        // SERIAL NO
                                    '<input style="width: 100%" type="text" class="form-control"  id="batno_' + x + '" name="batno[]" value="' + sbdt[x]['btno'] + '" onkeyup="">',        // BATCH NO
                                    '<input style="width: 100%" type="text" class="form-control"  id="prtno_' + x + '" name="prtno[]" value="' + sbdt[x]['prno'] + '" onkeyup="">',        // PART NO
                                    '<input style="width: 100%" type="text" class="form-control"  id="brcod_' + x + '" name="brcod[]" value="' + sbdt[x]['brcd'] + '" onkeyup="">',        // BARCODE
                                    '<input style="width: 100%" type="text" class="form-control"  id="abcno_' + x + '" name="abcno[]" value="' + sbdt[x]['abc'] + '" onkeyup="">',        // ABC NO
                                    '<input style="width: 100%" type="text" class="form-control"  id="xyzno_' + x + '" name="xyzno[]" value="' + sbdt[x]['xyz'] + '" onkeyup="">',        // XYZ NO
                                    '<input style="width: 100%" type="text" class="form-control"  id="subrm_' + x + '" name="subrm[]" value="' + sbdt[x]['remk'] + '">',                   // REMARKS
                                ]).draw(false);
                            }
                        } else {
                            document.getElementById('sblnxx').value = 0;
                            for (var x = 0; x < qty; x++) {
                                tt2.row.add([
                                    x + 1,
                                    '<input style="width: 100%" type="text"  class="form-control"  id="serno_' + x + '" name="serno[]" value="" onkeyup=""> ',        // SERIAL NO
                                    '<input style="width: 100%" type="text" class="form-control"  id="batno_' + x + '" name="batno[]" value="" onkeyup="">',        // BATCH NO
                                    '<input style="width: 100%" type="text" class="form-control"  id="prtno_' + x + '" name="prtno[]" value="" onkeyup="">',        // PART NO
                                    '<input style="width: 100%" type="text" class="form-control"  id="brcod_' + x + '" name="brcod[]" value="" onkeyup="">',        // BARCODE
                                    '<input style="width: 100%" type="text" class="form-control"  id="abcno_' + x + '" name="abcno[]" value="" onkeyup="">',        // ABC NO
                                    '<input style="width: 100%" type="text" class="form-control"  id="xyzno_' + x + '" name="xyzno[]" value="" onkeyup="">',        // XYZ NO
                                    '<input style="width: 100%" type="text" class="form-control"  id="subrm" name="subrm[]" value="">',                   // REMARKS
                                ]).draw(false);
                            }
                        }
                    }
                    swal.close();
                }
            });
        }

        // REJECT
        function rejecStck(id, grid) {
            swal({
                    title: "Are you sure ?",
                    text: "Your will not be able to revers this process ",
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
                            url: '<?= base_url(); ?>Stock/rejStock',
                            type: 'post',
                            data: {
                                id: id,
                                grid: grid
                            },
                            dataType: 'json',
                            success: function (response) {
                                swal({title: "", text: "Stock Rejected!", type: "success"},
                                    function () {
                                        srchStck();
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

        function squenceedt() {
            if (document.getElementById('sameedt').checked == true) {
                document.getElementById('strtedt').style.display = 'block';
                document.getElementById('seqeedt').style.display = 'none';
            } else {
                document.getElementById('strtedt').style.display = 'none';
                document.getElementById('seqeedt').style.display = 'block';
            }
        }

        //GENERATE NUMBERS
        function gennumberedt() {
            var type = document.getElementById('notypeedt').value;

            if ($('#genNum_form').valid()) {
                if (document.getElementById('sameedt').checked == true) {
                    var qunt = document.getElementById('qutyaa').value;
                    var number = document.getElementById('strtnumedt').value;
                    for (a = 0; a < qunt; a++) {
                        console.log(a);
                        if (type == 1) {
                            var m = "serno_" + a;
                            document.getElementById(m).value = number;
                            number++;
                        } else if (type == 2) {
                            var n = "batno_" + a;
                            document.getElementById(n).value = number;
                            number++;
                        }
                        else if (type == 3) {
                            var o = "prtno_" + a;
                            document.getElementById(o).value = number;
                            number++;
                        }
                        else if (type == 4) {
                            var p = "brcod_" + a;
                            document.getElementById(p).value = number;
                            number++;
                        }
                        else if (type == 5) {
                            var p = "abcno_" + a;
                            document.getElementById(p).value = number;
                            number++;
                        }
                        else if (type == 6) {
                            var p = "xyzno_" + a;
                            document.getElementById(p).value = number;
                            number++;
                        }
                    }
                }
                else {
                    var qunt = document.getElementById('qutyaa').value;
                    var number = document.getElementById('normlnumedt').value;
                    for (a = 0; a < qunt; a++) {
                        if (type == 1) {
                            var m = "serno_" + a;
                            document.getElementById(m).value = number;
                        } else if (type == 2) {
                            var n = "batno_" + a;
                            document.getElementById(n).value = number;
                        }
                        else if (type == 3) {
                            var o = "prtno_" + a;
                            document.getElementById(o).value = number;
                        }
                        else if (type == 4) {
                            var p = "brcod_" + a;
                            document.getElementById(p).value = number;
                        }
                        else if (type == 5) {
                            var p = "abcno_" + a;
                            document.getElementById(p).value = number;
                        }
                        else if (type == 6) {
                            var p = "xyzno_" + a;
                            document.getElementById(p).value = number;
                        }
                    }
                }
                $('#modal_gennummedt').modal('hide');
            }
        }

        //UPDATE || APPROVE STOCK
        $('#edtBtn').click(function (e) {
            e.preventDefault();
            if ($('#appForm').valid()) {
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
                            var msg = 'Stock approved and active';
                        } else {
                            var msg = 'Stock updated';
                        }

                        if (isConfirm) {
                            var jqXHR = jQuery.ajax({
                                type: "POST",
                                url: "<?= base_url(); ?>Stock/edtStock",
                                data: $("#appForm").serialize(),
                                dataType: 'json',
                                success: function (data) {
                                    swal({title: "", text: msg, type: "success"},
                                        function () {
                                            $('#edtBtn').attr('disabled', false);
                                            clear_Form('appForm');
                                            $('#grnTbl_edt').DataTable().clear().draw();
                                            $('#modal-edit').modal('hide');
                                            srchStck();
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
                            url: "<?= base_url(); ?>Stock/stck_Deactive",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (data) {
                                swal({title: "", text: "Stock was deactivated!", type: "success"},
                                    function () {
                                        srchStck();
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
                            url: "<?= base_url(); ?>Stock/stck_Activate",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (data) {
                                swal({title: "", text: "Stock was activated!", type: "success"},
                                    function () {
                                        srchStck();
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
