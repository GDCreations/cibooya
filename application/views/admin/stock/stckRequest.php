<script type="text/javascript" src="<?= base_url(); ?>assets/js/custom-js/full_width.js"></script>

<style>
    .tbl-warn-msg {
        color: #F69F00;
        font-size: 12px;
        font-style: italic;
    }

    .popover {
        position: absolute;
        top: 0;
        left: 0;
        display: none;
        max-width: 600px;
        padding: 1px;
        text-align: left;
        white-space: normal;
        background-color: #ffffff;
        border: 1px solid #ccc;
        border: 1px solid rgba(0, 0, 0, 0.2);
        -webkit-border-radius: 6px;
        -moz-border-radius: 6px;
        border-radius: 6px;
        -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        -webkit-background-clip: padding-box;
        -moz-background-clip: padding;
        background-clip: padding-box;
    }
</style>

<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">Stock Access</a></li>
        <li class="active">Stock Request</li>
    </ul>
</div>
<div class="app-heading app-heading-bordered app-heading-page">
    <div class="icon icon-lg">
        <span class="fa fa-indent" style="color: #e69c0f;"></span>
    </div>
    <div class="title">
        <h1>Stock Request</h1>
        <p>Request goods from Warehouse or Branch</p>
    </div>
    <?php
    if ($funcPerm[0]->inst == 1) { ?>
        <div class="pull-right">
            <button class="btn btn-sm btn-info btn-icon-fixed btn-rounded" data-toggle="modal" data-target="#modal-add">
                <span class="fa fa-plus"></span>New Request
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
                    <label class="col-md-4 col-xs-12 control-label">Request From</label>
                    <div class="col-md-8 col-xs-12">
                        <label class="switch">
                            <input id="srreqFr" name="srreqFr" type="checkbox" onclick="srcheckFr()"
                                   checked/>Branch
                        </label>Warehouse
                    </div>
                </div>
                <br>
            </div>
        </div>
        <div class="row form-horizontal">
            <div class="col-md-4">
                <div class="form-group" id="srToBrnc">
                    <label class="col-md-4 col-xs-12 control-label">Requester Branch</label>
                    <div class="col-md-8 col-xs-12">
                        <select class="bs-select" name="tobrcs" id="tobrcs"
                                onchange="chckBtn(this.value,this.id);">
                            <option value="all">All Branches</option>
                            <?php
                            foreach ($brncTo as $brt) {
                                echo "<option value='$brt->brid'>$brt->brcd - $brt->brnm</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 col-xs-12 control-label">Status</label>
                    <div class="col-md-8 col-xs-12">
                        <select name="reqSt" id="reqSt" class="bs-select">
                            <option value="all">All Status</option>
                            <option value="0">Pending</option>
                            <option value="1">Approved</option>
                            <option value="2">Cancelled</option>
                            <option value="3">Received</option>
                            <option value="4">Issuing Reject</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group" id="srfrWrh">
                    <label class="col-md-4 col-xs-12 control-label">Warehouse</label>
                    <div class="col-md-8 col-xs-12">
                        <select class="bs-select" name="frwhs" id="frwhs"
                                onchange="chckBtn(this.value,this.id);">
                            <option value="all">All Warehouses</option>
                            <?php
                            foreach ($warehouse as $wh) {
                                echo "<option value='$wh->whid'>$wh->whcd - $wh->whnm</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group" id="srfrBrnc" style="display: none">
                    <label class="col-md-4 col-xs-12 control-label">Issuing Branch</label>
                    <div class="col-md-8 col-xs-12">
                        <select class="bs-select" name="frBrncs" id="frBrncs"
                                onchange="chckBtn(this.value,this.id);">
                            <option value="all">All Branches</option>
                            <?php
                            foreach ($brncFrm as $brf) {
                                if ($brf['brch_id'] != '0' && $brf['brch_id'] != 'all') {
                                    echo "<option value='" . $brf['brch_id'] . "'>" . $brf['brch_code'] . " - " . $brf['brch_name'] . "</option>";
                                }
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
                    <div class="col-md-12 col-xs-12 text-right">
                        <button class="btn btn-sm btn-primary btn-rounded btn-icon-fixed"
                                onclick="srch_Req()">
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
                <table class="table datatable table-bordered table-striped"
                       id="dataTbReq" width="100%">
                    <thead>
                    <tr>
                        <th class="text-center"> #</th>
                        <th class="text-left" id="Reference number">REF. NO.</th>
                        <th class="text-left" title="Requested or recieved by"> REQ. BY</th>
                        <th class="text-left" title="Issuing warehouse or branch"> ISSUING BY</th>
                        <th class="text-left" title="Assigned / Item count"><span style="color: #76AB3C">ASS.</span> / <span style="color: #F69F00">ITEM CNT.</span></th>
                        <th class="text-left" title="Delivered / Issued"><span style="color: #CC00E0">DELI.</span> / <span style="color: #4FB5DD">ISSUED</span></th>
                        <th class="text-left" title="Created date">CRDT</th>
                        <th class="text-left"> STATUS</th>
                        <th class="text-left"> OPTION</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- MODAL ADD NEW REQUEST -->
    <div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modal-default-header">
        <div class="modal-dialog modal-lg modal-info" role="document" style="width: 60%">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"
                                                                                              class="icon-cross"></span>
            </button>
            <form id="addForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> Add Goods
                            Request
                        </h4>
                    </div>
                    <div class="modal-body scroll" style="max-height: 65vh">
                        <div class="container">
                            <div class="row form-horizontal">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Request From</label>
                                        <div class="col-md-8 col-xs-12">
                                            <label class="switch">
                                                <input id="reqFr" name="reqFr" type="checkbox" onclick="checkReq()" value="1"
                                                       checked/>Branch
                                            </label>Warehouse
                                        </div>
                                    </div>
                                    <br>
                                </div>
                            </div>
                            <div class="row form-horizontal">
                                <div class="col-md-6">
                                    <div class="form-group" id="ToBrnc">
                                        <label class="col-md-4 col-xs-12 control-label">Requester Branch <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <select class="bs-select" name="tobrc" id="tobrc"
                                                    onchange="chckBtn(this.value,this.id);">
                                                <option value="0">-- Select Branch --</option>
                                                <?php
                                                foreach ($brncTo as $brt) {
                                                    echo "<option value='$brt->brid'>$brt->brcd - $brt->brnm</option>";
                                                }
                                                ?>
                                            </select>
                                            <br/></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" id="frWrh">
                                        <label class="col-md-4 col-xs-12 control-label">Warehouse <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <select class="bs-select" name="frwh" id="frwh"
                                                    onchange="chckBtn(this.value,this.id);">
                                                <option value="0">-- Select Warehouse --</option>
                                                <?php
                                                foreach ($warehouse as $wh) {
                                                    echo "<option value='$wh->whid'>$wh->whcd - $wh->whnm</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" id="frBrnc" style="display: none">
                                        <label class="col-md-4 col-xs-12 control-label">Issuing Branch <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <select class="bs-select" name="frBrn" id="frBrn"
                                                    onchange="chckBtn(this.value,this.id);">
                                                <option value="0">-- Select Branch --</option>
                                                <?php
                                                foreach ($brncFrm as $brf) {
                                                    if ($brf['brch_id'] != '0' && $brf['brch_id'] != 'all') {
                                                        echo "<option value='" . $brf['brch_id'] . "'>" . $brf['brch_code'] . " - " . $brf['brch_name'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-horizontal">
                                <h5 class="text-title"><span class="fa fa-tag"></span> Request Details</h5>
                            </div>
                            <div class="row form-horizontal">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Item Name</label>
                                        <div class="col-md-8 col-xs-12">
                                            <select class="bs-select" data-live-search="true" id="item"
                                                    name="item"
                                                    onchange="chckBtn(this.value,this.id); getScale(this.value);">
                                                <option value="0">-- Select Item --</option>
                                                <script>
                                                    var scale = new Array();
                                                </script>
                                                <?php
                                                foreach ($item as $itm) {
                                                    echo "<option value='$itm->itid'>" . $itm->itcd . " - " . $itm->itnm . "</option>";
                                                    ?>
                                                    <script>
                                                        scale.push([<?= $itm->itid?>, '<?= $itm->scnm . " (" . $itm->scl . ")"?>', <?= $itm->slid?>, '<?= $itm->itcd?>', '<?= $itm->itnm?>', '<?= $itm->mlcd?>','<?= $itm->mdl?>']);
                                                    </script>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label"
                                               id="stScale">Quantity</label>
                                        <div class="col-md-6 col-xs-10">
                                            <input type="text" id="cnty" name="cnty" class="form-control text-right"
                                                   placeholder="Quantity"/>
                                        </div>
                                        <div class="col-md-2 col-xs-2">
                                            <button type="button" onclick="addItems()" style="margin: 0px" class="btn btn-sm btn-info pull-left">
                                                <span class="fa fa-plus"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-horizontal">
                                <div class="table-responsive" style="padding: 10px 25px 10px 10px">
                                    <table class="table dataTable table-striped table-bordered" id="reqGdTbl"
                                           width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-left">CODE</th>
                                            <th class="text-left">ITEM NAME</th>
                                            <th class="text-left">MODEL</th>
                                            <th class="text-left">SCALE</th>
                                            <th class="text-left">QTY</th>
                                            <th class="text-left">OPTION</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <input type="hidden" id="leng" name="leng" value="0"/>
                                </div>
                            </div>
                            <div class="row form-horizontal">
                                <div class="col-md-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="col-md-5 col-xs-12 control-label">Remarks</label>
                                        <div class="col-md-7 col-xs-12">
                                            <div class="form-group">
                                                         <textarea class="form-control" name="remk" id="remk"
                                                                   rows="4" placeholder="Description"></textarea>
                                            </div>
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
                        <button type="button" id="add_req_btn" class="btn btn-info btn-sm btn-rounded" disabled>Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END ADD NEW REQUEST -->

    <!-- MODAL VIEW || APPROVE || EDIT REQUEST -->
    <div class="modal fade" id="modal-view" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal-default-header">
        <div class="modal-dialog modal-lg modal-info" role="document" style="width: 60%">
            <button type="button" class="close" onclick="closeView();" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"
                                                                                              class="icon-cross"></span>
            </button>
            <form id="appForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> Goods
                            Request <span class="text-muted" id="subTitle">- View</span>
                        </h4>
                        <input type="hidden" id="reqId" name="reqId"/>
                        <input type="hidden" id="func" name="func"/>
                    </div>
                    <div class="modal-body scroll" style="max-height: 65vh">
                        <div class="container">
                            <div class="row form-horizontal">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Request From</label>
                                        <div class="col-md-8 col-xs-12">
                                            <label class="switch">
                                                <input id="reqFrEdt" name="reqFrEdt" type="checkbox" onclick="checkReqEdt()" value="1"
                                                       checked/>Branch
                                            </label>Warehouse
                                        </div>
                                    </div>
                                    <br>
                                </div>
                            </div>
                            <div class="row form-horizontal">
                                <div class="col-md-6">
                                    <div class="form-group" id="ToBrncEdt">
                                        <label class="col-md-4 col-xs-12 control-label">Requester Branch <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <select class="bs-select" name="tobrcEdt" id="tobrcEdt"
                                                    onchange="chckBtn(this.value,this.id);">
                                                <option value="0">-- Select Branch --</option>
                                                <?php
                                                foreach ($brncTo as $brt) {
                                                    echo "<option value='$brt->brid'>$brt->brcd - $brt->brnm</option>";
                                                }
                                                ?>
                                            </select>
                                            <br/></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" id="frWrhEdt">
                                        <label class="col-md-4 col-xs-12 control-label">Warehouse <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <select class="bs-select" name="frwhEdt" id="frwhEdt"
                                                    onchange="chckBtn(this.value,this.id);">
                                                <option value="0">-- Select Warehouse --</option>
                                                <?php
                                                foreach ($warehouse as $wh) {
                                                    echo "<option value='$wh->whid'>$wh->whcd - $wh->whnm</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" id="frBrncEdt" style="display: none">
                                        <label class="col-md-4 col-xs-12 control-label">Issuing Branch <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <select class="bs-select" name="frBrnEdt" id="frBrnEdt"
                                                    onchange="chckBtn(this.value,this.id);">
                                                <option value="0">-- Select Branch --</option>
                                                <?php
                                                foreach ($brncFrm as $brf) {
                                                    if ($brf['brch_id'] != '0' && $brf['brch_id'] != 'all') {
                                                        echo "<option value='" . $brf['brch_id'] . "'>" . $brf['brch_code'] . " - " . $brf['brch_name'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-horizontal">
                                <h5 class="text-title"><span class="fa fa-tag"></span> Request Details</h5>
                            </div>
                            <div class="row form-horizontal edit_Area">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Item Name</label>
                                        <div class="col-md-8 col-xs-12">
                                            <select class="bs-select" data-live-search="true" id="itemEdt"
                                                    name="itemEdt"
                                                    onchange="chckBtn(this.value,this.id); getScale(this.value);">
                                                <option value="0">-- Select Item --</option>
                                                <script>
                                                    scale = new Array();
                                                </script>
                                                <?php
                                                foreach ($item as $itm) {
                                                    echo "<option value='$itm->itid'>" . $itm->itcd . " - " . $itm->itnm . "</option>";
                                                    ?>
                                                    <script>
                                                        scale.push([<?= $itm->itid?>, '<?= $itm->scnm . " (" . $itm->scl . ")"?>', <?= $itm->slid?>, '<?= $itm->itcd?>', '<?= $itm->itnm?>', '<?= $itm->mlcd?>','<?= $itm->mdl?>']);
                                                    </script>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label"
                                               id="stScaleEdt">Quantity</label>
                                        <div class="col-md-6 col-xs-10">
                                            <input type="text" id="cntyEdt" name="cntyEdt" class="form-control text-right"
                                                   placeholder="Quantity"/>
                                        </div>
                                        <div class="col-md-2 col-xs-2">
                                            <button type="button" onclick="addItemsEdt()" style="margin: 0px" class="btn btn-sm btn-info pull-left">
                                                <span class="fa fa-plus"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-horizontal view_Area">
                                <div class="table-responsive" style="padding: 10px 25px 10px 10px">
                                    <table class="table dataTable table-striped table-bordered" id="reqGdTblView"
                                           width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-left" title="Cost value">CSVL</th>
                                            <th class="text-left" title="Display value">DSVL</th>
                                            <th class="text-left" title="Sale value">SLVL</th>
                                            <th class="text-left" title="Market value">MKVL</th>
                                            <th class="text-left" title="Issued Quantity">ISS. QTY.</th>
                                            <th class="text-center">STATUS</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <input type="hidden" id="lengEdt" name="lengEdt" value="0"/>
                                </div>
                            </div>
                            <div class="row form-horizontal edit_Area">
                                <div class="table-responsive" style="padding: 10px 25px 10px 10px">
                                    <table class="table dataTable table-striped table-bordered" id="reqGdTblEdt"
                                           width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-left">CODE</th>
                                            <th class="text-left">ITEM NAME</th>
                                            <th class="text-left">MODEL</th>
                                            <th class="text-left">SCALE</th>
                                            <th class="text-left">QTY</th>
                                            <th class="text-left">OPTION</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <input type="hidden" id="lengEdt" name="lengEdt" value="0"/>
                                </div>
                            </div>
                            <div class="row form-horizontal">
                                <div class="col-md-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="col-md-5 col-xs-12 control-label">Remarks</label>
                                        <div class="col-md-7 col-xs-12">
                                            <div class="form-group">
                                                         <textarea class="form-control" name="remkEdt" id="remkEdt"
                                                                   rows="4" placeholder="Description"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Received By</label>
                                        <label class="col-md-8 col-xs-12 control-label" id="reby"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Received Date</label>
                                        <label class="col-md-8 col-xs-12 control-label" id="redt"></label>
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
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Issue Rejected By</label>
                                        <label class="col-md-8 col-xs-12 control-label" id="isrby"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Issue Rejected Date</label>
                                        <label class="col-md-8 col-xs-12 control-label" id="isrdt"></label>
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
                        <button type="button" class="btn btn-link" data-dismiss="modal" onclick="closeView();">Close</button>
                        <button type="button" id="app_req_btn" class="btn btn-info btn-sm btn-rounded" disabled>Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END VIEW || APPROVE || EDIT REQUEST -->

    <script type="text/javascript">
        var mainVal, subVal, mainValEdt, subValEdt

        $().ready(function (e) {
            $('#reqGdTbl').DataTable({
                "destroy": true,
                "cache": false,
                searching: false,
                paging: false,
                ordering: false,
                "columnDefs": [
                    {className: "text-left", "targets": [1, 2, 3, 4]},
                    {className: "text-center", "targets": [0, 6]},
                    {className: "text-right", "targets": [5]},
                    {className: "text-nowrap", "targets": [2]},
                ],
                "aoColumns": [
                    {sWidth: '1%'}, //No
                    {sWidth: '10%'},    //CODE
                    {sWidth: '20%'},    //Item
                    {sWidth: '20%'},    //Model
                    {sWidth: '10%'},    //Scale
                    {sWidth: '10%'},    //Qty
                    {sWidth: '5%'},     //opt
                ]
            });
            $('#reqGdTblEdt').DataTable({
                "destroy": true,
                "cache": false,
                searching: false,
                paging: false,
                ordering: false,
                "columnDefs": [
                    {className: "text-left", "targets": [1, 2, 3, 4]},
                    {className: "text-center", "targets": [0, 6]},
                    {className: "text-right", "targets": [5]},
                    {className: "text-nowrap", "targets": [2]},
                ],
                "aoColumns": [
                    {sWidth: '1%'}, //No
                    {sWidth: '10%'},    //CODE
                    {sWidth: '20%'},    //Item
                    {sWidth: '20%'},    //Model
                    {sWidth: '10%'},    //Scale
                    {sWidth: '10%'},    //Qty
                    {sWidth: '5%'},     //opt
                ]
            });

            mainVal = $('#addForm').validate({
                rules: {
                    tobrc:{
                        notEqual: 0,
                    },
                    frBrn:{
                        notEqual: function () {
                            return $('#tobrc').val();
                        },
                        min: 1
                    },
                    frwh:{
                        notEqual: 0
                    },
                    item: {
                        notEqual: 0
                    },
                    cnty:{
                        required: true,
                        notEqual: 0,
                        decimal: true
                    }
                },
                messages: {
                    tobrc:{
                        notEqual: "Select requester branch"
                    },
                    frBrn:{
                        notEqual: "Requester & Issuer can't be same",
                        min:  "Select issuing branch"
                    },
                    frwh:{
                        notEqual: "Select warehouse"
                    },
                    item: {
                        notEqual: "Select an item"
                    },
                    cnty:{
                        required: "Enter quantity",
                        notEqual: "Can't enter zero value",
                    }
                }
            });

            subVal = $('#addForm').validate({
                rules: {
                    item: {
                        notEqual: 0
                    },
                    cnty:{
                        required: true,
                        notEqual: 0,
                        decimal: true
                    }
                },
                messages: {
                    item: {
                        notEqual: "Select an item"
                    },
                    cnty:{
                        required: "Enter quantity",
                        notEqual: "Can't enter zero value",
                    }
                }
            });

            mainValEdt = $('#appForm').validate({
                rules: {
                    tobrcEdt:{
                        notEqual: 0,
                    },
                    frBrnEdt:{
                        notEqual: function () {
                            return $('#tobrcEdt').val();
                        },
                        min: 1
                    },
                    frwhEdt:{
                        notEqual: 0
                    },
                    itemEdt: {
                        notEqual: 0
                    },
                    cntyEdt:{
                        required: true,
                        notEqual: 0,
                        decimal: true
                    }
                },
                messages: {
                    tobrcEdt:{
                        notEqual: "Select requester branch"
                    },
                    frBrnEdt:{
                        notEqual: "Requester & Issuer can't be same",
                        min:  "Select issuing branch"
                    },
                    frwhEdt:{
                        notEqual: "Select warehouse"
                    },
                    itemEdt: {
                        notEqual: "Select an item"
                    },
                    cntyEdt:{
                        required: "Enter quantity",
                        notEqual: "Can't enter zero value",
                    }
                }
            });

            subValEdt = $('#appForm').validate({
                rules: {
                    itemEdt: {
                        notEqual: 0
                    },
                    cntyEdt:{
                        required: true,
                        notEqual: 0,
                        decimal: true
                    }
                },
                messages: {
                    itemEdt: {
                        notEqual: "Select an item"
                    },
                    cntyEdt:{
                        required: "Enter quantity",
                        notEqual: "Can't enter zero value",
                    }
                }
            });

            srch_Req();
        });

        function checkReq() {
            if ($('#reqFr').prop('checked')) {
                $('#frWrh').css('display', 'inline');
                $('#frBrnc').css('display', 'none');
            } else {
                $('#frWrh').css('display', 'none');
                $('#frBrnc').css('display', 'inline');
            }
        }

        function checkReqEdt() {
            if ($('#reqFrEdt').prop('checked')) {
                $('#frWrhEdt').css('display', 'inline');
                $('#frBrncEdt').css('display', 'none');
            } else {
                $('#frWrhEdt').css('display', 'none');
                $('#frBrncEdt').css('display', 'inline');
            }
        }

        function srcheckFr() {
            if ($('#srreqFr').prop('checked')) {
                $('#srfrWrh').css('display', 'inline');
                $('#srfrBrnc').css('display', 'none');
            } else {
                $('#srfrWrh').css('display', 'none');
                $('#srfrBrnc').css('display', 'inline');
            }
        }

        //Get Scale
        function getScale(id) {
            for (var it = 0; it < scale.length; it++) {
                if (scale[it][0] == id) {
                    $('#stScale').html(scale[it][1]);
                    $('#stScaleEdt').html(scale[it][1]);
                    return scale[it][1];
                }
            }
            $('#stScale').html('Quantity');
            $('#stScaleEdt').html('Quantity');
        }

        //Add Request
        $('#add_req_btn').click(function (e) {
            e.preventDefault();
            subVal.resetForm();

            var valid = true;
            $('#tobrc,#frBrn,#frwh').each(function (i, v) {
                valid = mainVal.element(v) && valid;
            });

            if(valid){
                $('#add_req_btn').prop('disabled', true);
                swal({
                    title: "Processing...",
                    text: "Request data saving..",
                    imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                    showConfirmButton: false
                });

                jQuery.ajax({
                    type: "POST",
                    url: "<?= base_url(); ?>Stock/stReq_Add",
                    data: $("#addForm").serialize(),
                    dataType: 'json',
                    success: function (data) {
                        swal({title: "", text: "Request Added!", type: "success"},
                            function () {
                                $('#add_req_btn').prop('disabled', true);
                                clear_Form('addForm');
                                $('#modal-add').modal('hide');
                                $('#reqGdTbl').DataTable().clear().draw();
                                srch_Req();
                            });
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

        //Add Items to Req
        function addItems() {
            mainVal.resetForm();
            var valid = true;
            $('#item,#cnty').each(function (i, v) {
                valid = subVal.element(v) && valid;
            });

            var itid = $('#item').val();
            var qty = $('#cnty').val();

            var exist = false;
            $("input[name='itid[]']").each(function () {
                if(+this.value==+itid){
                    exist = true;
                }
            });

            if(!exist){
                if(valid) {
                    var leng = $('#leng').val();

                    var lengN = +leng + +1;
                    $('#leng').val(lengN);

                    var t = $('#reqGdTbl').DataTable({
                        destroy: true,
                        searching: false,
                        bPaginate: false,
                        "ordering": false,
                        "columnDefs": [
                            {className: "text-left", "targets": [1, 2, 3, 4]},
                            {className: "text-center", "targets": [0, 6]},
                            {className: "text-right", "targets": [5]},
                            {className: "text-nowrap", "targets": [2]},
                        ],
                        "aoColumns": [
                            {sWidth: '1%'}, //No
                            {sWidth: '10%'},    //CODE
                            {sWidth: '20%'},    //Item
                            {sWidth: '20%'},    //Model
                            {sWidth: '10%'},    //Scale
                            {sWidth: '10%'},    //Qty
                            {sWidth: '5%'},     //opt
                        ]
                    });

                    var itcd = "";
                    var itnm = "";
                    var scl = "";
                    var slid = 0;
                    var mdl = "";

                    for (var it = 0; it < scale.length; it++) {
                        if (scale[it][0] == itid) {
                            itcd = scale[it][3];
                            itnm = scale[it][4];
                            scl = scale[it][1];
                            slid = scale[it][2];
                            mdl = scale[it][5]+" - "+scale[it][6];;
                            break;
                        }
                    }
                    t.row.add([
                        lengN,
                        itcd + '<input type="hidden" name="itid[]" value="' + itid + ' ">',     // ITEM CODE
                        itnm,
                        mdl, //Model
                        scl, //Scale
                        numeral(qty).format('0,0') + '<input type="hidden" name="qunty[]" value="' + qty + ' ">',         // QUNT
                        '<button type="button" class="btn btn-xs btn-warning" id="dltrw" onclick=""><span><i class="fa fa-close" title="Remove"></i></span></button>'
                    ]).draw(false);

                    default_Selector($('#item').prev());
                    $('#cnty').val('');

                    if(lengN>0){
                        $('#add_req_btn').attr('disabled',false);
                    }else{
                        $('#add_req_btn').attr('disabled',true);
                    }
                }
            }else{
                swal({title: "Already Added",
                    text: "",
                    type: "warning",});
            }
        }
        function addItemsEdt() {
            mainValEdt.resetForm();
            var valid = true;
            $('#itemEdt,#cntyEdt').each(function (i, v) {
                valid = subValEdt.element(v) && valid;
            });

            var itid = $('#itemEdt').val();
            var qty = $('#cntyEdt').val();

            var exist = false;
            $("input[name='itidEdt[]']").each(function () {
                if(+this.value==+itid){
                    exist = true;
                }
            });

            if(!exist){
                if(valid) {
                    var leng = $('#lengEdt').val();

                    var lengN = +leng + +1;
                    $('#lengEdt').val(lengN);

                    var t = $('#reqGdTblEdt').DataTable({
                        destroy: true,
                        searching: false,
                        bPaginate: false,
                        "ordering": false,
                        "columnDefs": [
                            {className: "text-left", "targets": [1, 2, 3, 4]},
                            {className: "text-center", "targets": [0, 6]},
                            {className: "text-right", "targets": [5]},
                            {className: "text-nowrap", "targets": [2]},
                        ],
                        "aoColumns": [
                            {sWidth: '1%'}, //No
                            {sWidth: '10%'},    //CODE
                            {sWidth: '20%'},    //Item
                            {sWidth: '20%'},    //Model
                            {sWidth: '10%'},    //Scale
                            {sWidth: '10%'},    //Qty
                            {sWidth: '5%'},     //opt
                        ]
                    });

                    var itcd = "";
                    var itnm = "";
                    var scl = "";
                    var slid = 0;
                    var mdl = "";

                    for (var it = 0; it < scale.length; it++) {
                        if (scale[it][0] == itid) {
                            itcd = scale[it][3];
                            itnm = scale[it][4];
                            scl = scale[it][1];
                            slid = scale[it][2];
                            mdl = scale[it][5]+" - "+scale[it][6];;
                            break;
                        }
                    }
                    t.row.add([
                        lengN,
                        itcd + '<input type="hidden" name="itidEdt[]" value="' + itid + ' ">' +
                        '<input type="hidden" name="rqsid[]" value="0"/>',     // ITEM CODE
                        itnm,
                        mdl, //Model
                        scl, //Scale
                        numeral(qty).format('0,0') + '<input type="hidden" name="quntyEdt[]" value="' + qty + ' ">',         // QUNT
                        '<button type="button" class="btn btn-xs btn-warning" id="dltrwEdt" onclick=""><span><i class="fa fa-close" title="Remove"></i></span></button>'
                    ]).draw(false);

                    default_Selector($('#itemEdt').prev());
                    $('#cntyEdt').val('');

                    if(lengN>0){
                        $('#app_req_btn').attr('disabled',false);
                    }else{
                        $('#app_req_btn').attr('disabled',true);
                    }
                }
            }else{
                swal({title: "Already Added",
                    text: "",
                    type: "warning",});
            }
        }

        $('#reqGdTbl tbody').on('click', '#dltrw', function () {
            var table = $('#reqGdTbl').DataTable();
            table
                .row($(this).parents('tr'))
                .remove()
                .draw();

            var leng = document.getElementById('leng').value;
            document.getElementById('leng').value = +leng - +1;
            if(+$('#leng').val()>0){
                $('#add_req_btn').attr('disabled',false);
            }else{
                $('#add_req_btn').attr('disabled',true);
            }
        });
        $('#reqGdTblEdt tbody').on('click', '#dltrwEdt', function () {
            var table = $('#reqGdTblEdt').DataTable();
            table
                .row($(this).parents('tr'))
                .remove()
                .draw();

            var leng = document.getElementById('lengEdt').value;
            document.getElementById('lengEdt').value = +leng - +1;
            if(+$('#lengEdt').val()>0){
                $('#app_req_btn').attr('disabled',false);
            }else{
                $('#app_req_btn').attr('disabled',true);
            }
        });

        //SEARCH REQUESTS
        function srch_Req() {
            var rqfr = $('#srreqFr').prop('checked');
            var rqbr = $('#tobrcs').val(); //Requester Branch (goods to brnch)
            var rcbr = $('#frBrncs').val(); //Req receiver Branch (goods from brnch)
            var rcwh = $('#frwhs').val(); //Req receiver warehouse (goods from warehouse)
            var dtrg = $('#dtrng').val(); //Date Range
            var stat = $('#reqSt').val(); //Status

            $('#dataTbReq').DataTable().clear();
            $('#dataTbReq').DataTable({
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
                    {className: "text-center", "targets": [0, 1, 4, 5, 6, 7, 8]},
                    {className: "text-right", "targets": []},
                    {className: "text-nowrap", "targets": [2]},
                ],
                "order": [[6, "DESC"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '1%'}, //No
                    {sWidth: '7%'},    //REF
                    {sWidth: '20%'},    //RQ BY
                    {sWidth: '20%'},    //IS BY
                    {sWidth: '7%'},    //Assigned / ITEM COUNT
                    {sWidth: '7%'},    //Recieved / Issued
                    {sWidth: '10%'},    //CRDT
                    {sWidth: '10%'},     //Status
                    {sWidth: '15%'}     //OPT
                ],
                "ajax": {
                    url: '<?= base_url(); ?>Stock/searchStReq',
                    type: 'post',
                    data: {
                        rqfr: rqfr,
                        rqbr: rqbr,
                        rcbr: rcbr,
                        rcwh: rcwh,
                        dtrg: dtrg,
                        stat: stat,
                        mode: 1
                    }
                }
            });
        }
        
        //VIEW || EDIT || APPROVE view
        function viewStck(id,func) {
            swal({
                title: "Please wait...",
                text: "Retrieving Data...",
                imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                showConfirmButton: false
            });

            $('#func').val(func);
            $('#reqId').val(id);

            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>Stock/vewReqStock",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (response) {
                    var des = "";

                    if(func=='vew' || func=='rec'){
                        //VIEW MODEL
                        $('#subTitle').html(' - View');
                        $('#app_req_btn').css('display', 'none');
                        $("#modal-view").find('.edit_req').css("display", "none");
                        $(".edit_Area").css('display', 'none');
                        $(".view_Area").css('display', 'block');
                        $(".req-astrick").css('display', 'none');
                        //Make readonly all fields
                        $("#modal-view :input").attr("readonly", true);
                        $("#modal-view :input[type='checkbox']").attr('disabled',true);
                        disableSelct('tobrcEdt');
                        disableSelct('frwhEdt');
                        disableSelct('frBrnEdt');
                        //VIEW MODEL
                        var des = "disabled";
                    }else if(func=='edt'){
                        //EDIT MODEL
                        $('#subTitle').html(' - Edit');
                        $('#app_req_btn').css('display', 'inline');
                        $('#app_req_btn').html('Update');
                        $("#modal-view").find('.edit_req').css("display", "inline");
                        $(".edit_Area").css('display', 'block');
                        $(".view_Area").css('display', 'none');
                        $(".req-astrick").css('display', 'inline');
                        //Make readonly all fields
                        $("#modal-view :input").attr("readonly", false);
                        $("#modal-view :input[type='checkbox']").attr('disabled',false);
                        enableSelct('tobrcEdt');
                        enableSelct('frwhEdt');
                        enableSelct('frBrnEdt');
                        //EDIT MODEL
                    }else if(func=='app'){
                        //APPROVE MODEL
                        $('#subTitle').html(' - Approve');
                        $('#app_req_btn').css('display', 'inline');
                        $('#app_req_btn').html('Approve');
                        $("#modal-view").find('.edit_req').css("display", "inline");
                        $(".edit_Area").css('display', 'block');
                        $(".view_Area").css('display', 'none');
                        $(".req-astrick").css('display', 'inline');
                        //Make readonly all fields
                        $("#modal-view :input").attr("readonly", false);
                        $("#modal-view :input[type='checkbox']").attr('disabled',false);
                        enableSelct('tobrcEdt');
                        enableSelct('frwhEdt');
                        enableSelct('frBrnEdt');
                        //APPROVE MODEL
                    }

                    var len = response['req'].length;
                    var req = response['req'];
                    if(len>0){
                        $('#subTitle').html($('#subTitle').html()+" | "+req[0]['rqno']);
                        set_select('tobrcEdt',req[0]['rsbc']);
                        $('#remkEdt').val(req[0]['rmk']);

                        if(req[0]['rqfr']==1){
                            $('#reqFrEdt').prop('checked',true);
                            $('#frWrhEdt').css('display', 'inline');
                            $('#frBrncEdt').css('display', 'none');
                            set_select('frwhEdt',req[0]['rrbc']);
                        }else{
                            $('#reqFrEdt').prop('checked',false);
                            $('#frWrhEdt').css('display', 'none');
                            $('#frBrncEdt').css('display', 'inline');
                            set_select('frBrnEdt',req[0]['rrbc']);
                        }

                        //STATUS
                        if (req[0]['stat'] == 0) {
                            var stat = "<label class='label label-warning'>Pending</label>";
                        } else if (req[0]['stat'] == 1) {
                            var stat = "<label class='label label-success'>Waiting For Goods</label>";
                        } else if (req[0]['stat'] == 2) {
                            var stat = "<label class='label label-danger'>Cancelled</label>";
                        } else if (req[0]['stat'] == 3) {
                            var stat = "<label class='label label-info'>Received</label>";
                        } else if(req[0]['stat']==4){
                            var stat = "<label class='label label-indi'>Issue Rejected</label>";
                        }else{
                            var stat = "NOP";
                        }

                        $('#stc_stat').html(stat);
                        $('#crby').html(": " + req[0]['crnm']);
                        $('#crdt').html(": " + req[0]['crdt']);
                        $('#apby').html(": " + ((req[0]['apnm'] != null) ? req[0]['apnm'] : "--"));
                        $('#apdt').html(": " + ((req[0]['apdt'] != null && req[0]['apdt'] != "0000-00-00 00:00:00") ? req[0]['apdt'] : "--"));
                        $('#rjby').html(": " + ((req[0]['rjnm'] != null) ? req[0]['rjnm'] : "--"));
                        $('#rjdt').html(": " + ((req[0]['rjdt'] != null && req[0]['rjdt'] != "0000-00-00 00:00:00") ? req[0]['rjdt'] : "--"));
                        $('#mdby').html(": " + ((req[0]['mdnm'] != null) ? req[0]['mdnm'] : "--"));
                        $('#mddt').html(": " + ((req[0]['mddt'] != null && req[0]['mddt'] != "0000-00-00 00:00:00") ? req[0]['mddt'] : "--"));
                        $('#reby').html(": " + ((req[0]['renm'] != null) ? req[0]['renm'] : "--"));
                        $('#redt').html(": " + ((req[0]['redt'] != null && req[0]['redt'] != "0000-00-00 00:00:00") ? req[0]['redt'] : "--"));
                        $('#isrby').html(": " + ((req[0]['isrnm'] != null) ? req[0]['isrnm'] : "--"));
                        $('#isrdt').html(": " + ((req[0]['isrdt'] != null && req[0]['isrdt'] != "0000-00-00 00:00:00") ? req[0]['isrdt'] : "--"));

                        if(func=='edt' || func=='app'){
                            var len2 = response['reqs'].length;
                            $('#lengEdt').val(len2);
                            var reqs = response['reqs'];
                            $('#reqGdTblEdt').DataTable().clear();
                            var t = $('#reqGdTblEdt').DataTable({
                                destroy: true,
                                searching: false,
                                bPaginate: false,
                                "ordering": false,
                                "columnDefs": [
                                    {className: "text-left", "targets": [1, 2, 3, 4]},
                                    {className: "text-center", "targets": [0, 6]},
                                    {className: "text-right", "targets": [5]},
                                    {className: "text-nowrap", "targets": [2]},
                                ],
                                "aoColumns": [
                                    {sWidth: '1%'}, //No
                                    {sWidth: '10%'},    //CODE
                                    {sWidth: '20%'},    //Item
                                    {sWidth: '20%'},    //Model
                                    {sWidth: '10%'},    //Scale
                                    {sWidth: '10%'},    //Qty
                                    {sWidth: '5%'},     //opt
                                ]
                            });

                            for (var it = 0; it < len2; it++) {
                                t.row.add([
                                    (it+1),
                                    reqs[it]['itcd'] + '<input type="hidden" name="itidEdt[]" value="' + reqs[it]['itid'] + ' ">' +
                                    '<input type="hidden" name="rqsid[]" value="'+reqs[it]['auid']+'"/>',     // ITEM CODE
                                    reqs[it]['itnm'],
                                    reqs[it]['mlcd']+" - "+reqs[it]['mdl'], //Model
                                    reqs[it]['scnm']+" ("+reqs[it]['scl']+")", //Scale
                                    numeral(reqs[it]['reqty']).format('0,0') + '<input type="hidden" name="quntyEdt[]" value="' + reqs[it]['reqty'] + ' ">',         // QUNT
                                    '<button type="button" '+des+' class="btn btn-xs btn-warning" id="dltrwEdt" onclick=""><span><i class="fa fa-close" title="Remove"></i></span></button>'
                                ]).draw(false);
                            }
                            $('#app_req_btn').attr('disabled',false);
                        }else {
                            var rqfr = req[0]['rqfr'];
                            var rrbc = req[0]['rrbc'];
                            jQuery.ajax({
                                type: "POST",
                                url: "<?= base_url(); ?>Stock/vewReqStock3",
                                data: {
                                    id: id,
                                    rqfr: rqfr,
                                    rrbc: rrbc
                                },
                                dataType: 'json',
                                success: function (data) {
                                    var len2 = data['reqs'].length;
                                    var reqs = data['reqs'];

                                    $('#reqGdTblView').DataTable().clear();
                                    var t = $('#reqGdTblView').DataTable({
                                        destroy: true,
                                        searching: false,
                                        bPaginate: false,
                                        "ordering": false,
                                        "columnDefs": [
                                            {className: "text-left", "targets": []},
                                            {className: "text-center", "targets": [0, 5, 6]},
                                            {className: "text-right", "targets": [1, 2, 3, 4]},
                                            {className: "text-nowrap", "targets": [1]},
                                        ],
                                        "aoColumns": [
                                            {sWidth: '1%'}, //No
                                            {sWidth: '10%'},    //CSVL
                                            {sWidth: '10%'},    //DSVL
                                            {sWidth: '10%'},    //SLVL
                                            {sWidth: '10%'},    //MKVL
                                            {sWidth: '10%'},    //THIS ASS
                                            {sWidth: '10%'},     //STAT
                                        ]
                                    });
                                    var item = 0;
                                    var itmCnt = 1;
                                    for (var vw = 0; vw < len2; vw++) {
                                        if (item == reqs[vw]['itid']) {
                                            if(reqs[vw]['thsAsCnt']!=0){
                                                var receiv = "";
                                                if (reqs[vw]['stat'] == 4) {
                                                    if(func=='rec'){
                                                        receiv = "<button type='button' class='btn btn-xs btn-info' onclick='receivedGd("+id+","+reqs[vw]['sb2id']+","+reqs[vw]['inid']+");' title='Received'>" +
                                                            "<span class='fa fa-cube'></span></button>";
                                                    }
                                                }
                                                t.row.add([
                                                    '*',
                                                    numeral(reqs[vw]['csvl']).format('0,0.00'),     // CSVL
                                                    numeral(reqs[vw]['fcvl']).format('0,0.00'),     // FCVL
                                                    numeral(reqs[vw]['slvl']).format('0,0.00'),     // SLVL
                                                    numeral(reqs[vw]['mkvl']).format('0,0.00'),     // MKVL
                                                    '<strong>' + numeral(reqs[vw]['thsAsCnt']).format('00') + '</strong>',
                                                    receiv
                                                ]).draw();
                                            }else{
                                                rowNode = t.row.add([
                                                    '*',
                                                    '<strong>No assigned goods</strong>', '', '', '', '', '', ''
                                                ]).draw().node();
                                                $(rowNode).children().eq(1).prop('colspan', 7);
                                                $(rowNode).children().eq(1).addClass('text-left tbl-warn-msg');
                                                for (var ittt = 2; ittt < 7; ittt++) {
                                                    $(rowNode).children().eq(2).remove();
                                                }
                                            }
                                        } else {
                                            item = reqs[vw]['itid'];

                                            //STATUS
                                            var content = "";
                                            if(reqs[vw]['stat']==4 || reqs[vw]['stat']==5){
                                                var rqin = data['rqin'];
                                                rqin.forEach(forIn);

                                                function forIn(item, index) {
                                                    if (item.inid == reqs[vw]['inid']) {
                                                        content = "<div class='row form-horizontal'><label class='col-md-4'>Issue Note </label><label class='col-md-8'>: " + item.inno + "</label><br>" +
                                                            "<label class='col-md-4'>Driver Name </label><label class='col-md-8'>: " + item.drnm + "</label><br>" +
                                                            "<label class='col-md-4'>Vehicle No </label><label class='col-md-8'>: " + item.vno + "</label><br>" +
                                                            "<label class='col-md-4'>Contact No </label><label class='col-md-8'>: " + item.mbno + "</label><br>" +
                                                            "<label class='col-md-4'>Date </label><label class='col-md-8'>: " + item.crdt + "</label><br>" +
                                                            "<label class='col-md-4'>By </label><label class='col-md-8'>: " + item.crnm + "</label></div>";
                                                    }
                                                }
                                            }

                                            var receiv = "";
                                            if (reqs[vw]['stat'] == 0) {
                                                var stat = "<label class='label label-warning'>To Issue</label>";
                                            } else if (reqs[vw]['stat'] == 3) {
                                                var stat = "<label class='label label-info'>Assigned</label>";
                                            } else if (reqs[vw]['stat'] == 4) {
                                                var stat = "<label class='label label-indi' style='cursor: pointer' title='Issue Details'" +
                                                    "onclick='popOver(this);' data-container=\"body\" data-toggle=\"popover\" data-placement=\"top\"\n" +
                                                    "                                                   data-html=\"true\"\n" +
                                                    "                                                   data-trigger=\"focus\"\n" +
                                                    "                                                   data-content=\"" + content + "\">On the way</label>";
                                                if(func=='rec'){
                                                    receiv = "<button type='button' class='btn btn-xs btn-info' onclick='receivedGd("+id+","+reqs[vw]['sb2id']+","+reqs[vw]['inid']+");' title='Received'>" +
                                                        "<span class='fa fa-cube'></span></button>";
                                                }

                                            } else if (reqs[vw]['stat'] == 5) {
                                                var stat = "<label class='label label-success' style='cursor: pointer' title='Issue Details'" +
                                                    "onclick='popOver(this);' data-container=\"body\" data-toggle=\"popover\" data-placement=\"top\"\n" +
                                                    "                                                   data-html=\"true\"\n" +
                                                    "                                                   data-trigger=\"focus\"\n" +
                                                    "                                                   data-content=\"" + content + "\">Received</label>";
                                            } else if (reqs[vw]['stat'] == 2) {
                                                var stat = "<label class='label label-danger'>Reject</label>";
                                            } else {
                                                var stat = "NOP";
                                            }

                                            rowNode = t.row.add([
                                                itmCnt,
                                                "ITEM : <strong>" + reqs[vw]['itnm'] + " | " + reqs[vw]['itcd'] + "</strong><br>" +
                                                "MODEL : <strong>" + reqs[vw]['mdl'] + " (" + reqs[vw]['mlcd'] + ")</strong>",
                                                "Scale : <strong>(" + reqs[vw]['scl'] + ") " + reqs[vw]['scnm'] + "</strong><br>" +
                                                "Requested QTY : <strong style='color: red'>" + reqs[vw]['reqty'] + "</strong>",
                                                stat,
                                                '',
                                                '',
                                                ''
                                            ]).draw().node();
                                            $(rowNode).children().eq(1).prop('colspan', 4);
                                            $(rowNode).children().eq(1).addClass('text-left');
                                            $(rowNode).children().eq(2).addClass('text-left');
                                            $(rowNode).children().eq(3).removeClass('text-right');
                                            $(rowNode).children().eq(3).addClass('text-center');
                                            for (var ittt = 4; ittt < 7; ittt++) {
                                                $(rowNode).children().eq(4).remove();
                                            }
                                            $(rowNode).addClass('success');
                                            if (reqs[vw]['stcd'] == null ) {
                                                rowNode = t.row.add([
                                                    '*',
                                                    '<strong>Stocks Not Available</strong>', '', '', '', '', '', ''
                                                ]).draw().node();
                                                $(rowNode).children().eq(1).prop('colspan', 7);
                                                $(rowNode).children().eq(1).addClass('text-left tbl-warn-msg');
                                                for (var ittt = 2; ittt < 7; ittt++) {
                                                    $(rowNode).children().eq(2).remove();
                                                }
                                            } else {
                                                if(reqs[vw]['thsAsCnt']!=0){
                                                    t.row.add([
                                                        '*',
                                                        numeral(reqs[vw]['csvl']).format('0,0.00'),     // CSVL
                                                        numeral(reqs[vw]['fcvl']).format('0,0.00'),     // FCVL
                                                        numeral(reqs[vw]['slvl']).format('0,0.00'),     // SLVL
                                                        numeral(reqs[vw]['mkvl']).format('0,0.00'),     // MKVL
                                                        '<strong>' + numeral(reqs[vw]['thsAsCnt']).format('00') + '</strong>',
                                                        receiv
                                                    ]).draw();
                                                }else {
                                                    rowNode = t.row.add([
                                                        '*',
                                                        '<strong>No assigned goods</strong>', '', '', '', '', '', ''
                                                    ]).draw().node();
                                                    $(rowNode).children().eq(1).prop('colspan', 7);
                                                    $(rowNode).children().eq(1).addClass('text-left tbl-warn-msg');
                                                    for (var ittt = 2; ittt < 7; ittt++) {
                                                        $(rowNode).children().eq(2).remove();
                                                    }
                                                }
                                            }
                                            itmCnt++;
                                        }
                                    }
                                },
                                error: function (data, textStatus) {
                                    alert('Contact System Support');
                                }
                            });
                        }
                    }
                    swal.close();
                }
            });
        }

        //Add Request
        $('#app_req_btn').click(function (e) {
            e.preventDefault();
            subValEdt.resetForm();

            var valid = true;
            $('#tobrcEdt,#frBrnEdt,#frwhEdt').each(function (i, v) {
                valid = mainValEdt.element(v) && valid;
            });

            if(valid){
                $('#app_req_btn').prop('disabled', true);
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
                        $('#app_req_btn').attr('disabled', true);
                        if ($('#func').val() == 'app') {
                            var msg = 'Request approved';
                        } else {
                            var msg = 'Request updated';
                        }

                        if (isConfirm) {
                            var jqXHR = jQuery.ajax({
                                type: "POST",
                                url: "<?= base_url(); ?>Stock/edtReqStock",
                                data: $("#appForm").serialize(),
                                dataType: 'json',
                                success: function (data) {
                                    swal({title: "", text: msg, type: "success"},
                                        function () {
                                            $('#app_req_btn').attr('disabled', false);
                                            clear_Form('appForm');
                                            $('#reqGdTblEdt').DataTable().clear().draw();
                                            $('#modal-view').modal('hide');
                                            srch_Req();
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

        function popOver(node) {
            $(node).popover('toggle');
            $('[data-toggle="popover"]').not($(node).popover()).popover('hide');
        }

        function closeView() {
            $('[data-toggle="popover"]').popover('hide');
        }
        //RECEIVED GOODS
        function receivedGd(rqid,id,inid) {
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
                    swal({
                        title: "Please wait...",
                        text: "Adding as stock...",
                        imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                        showConfirmButton: false
                    });

                    if (isConfirm) {
                        jQuery.ajax({
                            type: "POST",
                            url: "<?= base_url(); ?>Stock/addReqGd_toStc",
                            data: {
                                id:id,
                                rqid:rqid,
                                inid:inid
                            },
                            dataType: 'json',
                            success: function (data) {
                                swal({title: "", text: "New Stock Added", type: "success"},
                                    function () {
                                        viewStck(rqid,'rec');
                                        srch_Req();
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
    </script>
</div>
<!-- END PAGE CONTAINER -->
