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
        <li class="active">Stock Transfer</li>
    </ul>
</div>
<div class="app-heading app-heading-bordered app-heading-page">
    <div class="icon icon-lg">
        <span class="fa fa-outdent" style="color: #e69c0f;"></span>
    </div>
    <div class="title">
        <h1>Stock Transfer</h1>
        <p>Transfer goods Warehouse to Branches & Branch to Branches</p>
    </div>
</div>
<!-- END PAGE HEADING -->

<!-- START PAGE CONTAINER -->
<div class="container">
    <div class="block">
        <?php
        if ($funcPerm[0]->inst == 1) { ?>
            <div class="row form-horizontal">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-md-4 col-xs-12 control-label">Issue From</label>
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

                    <div class="form-group">
                        <label class="col-md-4 col-xs-12 control-label">Status</label>
                        <div class="col-md-8 col-xs-12">
                            <select name="reqSt" id="reqSt" class="bs-select">
                                <option value="all">All Status</option>
                                <!--                            <option value="0">Pending</option>-->
                                <option value="1">To Issue</option>
                                <option value="5">Issued</option>
                                <!--                            <option value="2">Cancelled</option>-->
                                <option value="3">Delivered</option>
                                <option value="4">Issuing Reject</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group" id="srToBrnc">
                        <label class="col-md-4 col-xs-12 control-label">Requester Branches</label>
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
                            <br/></div>
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
                                    onclick="srch_rqGd()">
                                <span class="fa fa-search"></span>Search
                            </button>
                            <?php if ($funcPerm[0]->rpnt == 1) { ?>
                                <button type="button" data-toggle="modal" data-target='#modal-isNts'
                                        class='btn btn-sm btn-danger btn-rounded btn-icon-fixed'>
                                    <span class="fa fa-file-text-o"></span> Issue Notes
                                </button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else {
            ?>
            <div class="row form-horizontal">
                <div class="col-md-4">
                    <div class="form-group" id="srfrBrnc">
                        <label class="col-md-4 col-xs-12 control-label">Issuing Branch</label>
                        <div class="col-md-8 col-xs-12">
                            <select class="bs-select" name="frBrncs" id="frBrncs"
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
                    <div class="form-group">
                        <label class="col-md-4 col-xs-12 control-label">Status</label>
                        <div class="col-md-8 col-xs-12">
                            <select name="reqSt" id="reqSt" class="bs-select">
                                <option value="all">All Status</option>
                                <!--                            <option value="0">Pending</option>-->
                                <option value="1">To Issue</option>
                                <option value="5">Issued</option>
                                <!--                            <option value="2">Cancelled</option>-->
                                <option value="3">Delivered</option>
                                <option value="4">Issuing Reject</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group" id="srToBrnc">
                        <label class="col-md-4 col-xs-12 control-label">Requester Branches</label>
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
                            <br/></div>
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
                                    onclick="srch_rqGd()">
                                <span class="fa fa-search"></span>Search
                            </button>
                            <?php if ($funcPerm[0]->rpnt == 1) { ?>
                                <button type="button" data-toggle="modal" data-target='#modal-isNts'
                                        class='btn btn-sm btn-danger btn-rounded btn-icon-fixed'>
                                    <span class="fa fa-file-text-o"></span> Issue Notes
                                </button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
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
                        <th class="text-left" title="Assigned / Item count"><span style="color: #76AB3C">ASS.</span>
                            / <span style="color: #F69F00">ITEM CNT.</span></th>
                        <th class="text-left" title="Delivered / Issued"><span style="color: #CC00E0">DELI.</span> /
                            <span style="color: #4FB5DD">ISSUED</span></th>
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

    <!-- MODAL VIEW || ASSIGN REQUEST -->
    <div class="modal fade" id="modal-view" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="modal-default-header">
        <div class="modal-dialog modal-lg modal-info" role="document" style="width: 60%">
            <button type="button" class="close" data-dismiss="modal" onclick="closeView();" aria-label="Close"><span
                        aria-hidden="true"
                        class="icon-cross"></span>
            </button>
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> Goods
                        Assigning <span class="text-muted" id="subTitle"></span>
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
                                    <label class="col-md-8 col-xs-12 control-label" id="reqFrEdt"></label>
                                    <input type="hidden" name="rqFrEdt" id="rqFrEdt" value=""/>
                                </div>
                                <br>
                            </div>
                        </div>
                        <div class="row form-horizontal">
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
                            <div class="col-md-6">
                                <div class="form-group" id="ToBrncEdt">
                                    <label class="col-md-4 col-xs-12 control-label">Requester Branch </label>
                                    <label class="col-md-8 col-xs-12 control-label" id="tobrcEdt"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row form-horizontal">
                            <h5 class="text-title"><span class="fa fa-tag"></span> Request Details</h5>
                        </div>
                        <div class="row form-horizontal view_Area">
                            <div class="table-responsive" style="padding: 10px 25px 10px 10px">
                                <table class="table dataTable table-striped table-bordered" id="reqGdTblView"
                                       width="100%">
                                    <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-left">STOCK</th>
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
                                        <th class="text-left">STOCK</th>
                                        <th class="text-left" title="Cost value">CSVL</th>
                                        <th class="text-left" title="Display value">DSVL</th>
                                        <th class="text-left" title="Sale value">SLVL</th>
                                        <th class="text-left" title="Market value">MKVL</th>
                                        <th class="text-left" title="Assigned Total / Available Quantity"><span
                                                    style="color: #76AB3C">ASS. T.</span> / <span
                                                    style="color: #F69F00">AV. QTY</span></th>
                                        <th class="text-left" title="Assigned Quantity">ASS. QTY.</th>
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
                    <button type="button" class="btn btn-link" data-dismiss="modal" onclick="closeView();">Close
                    </button>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- END VIEW || ASSIGN REQUEST -->
    <!-- MODAL ISSUE NOTE PRINT || ISSUE -->
    <div class="modal fade" id="modal-iss" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="modal-default-header">
        <div class="modal-dialog modal-lg modal-success" role="document" style="width: 60%">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeIss()"><span aria-hidden="true"
                                                                                                                   class="icon-cross"></span>
            </button>
            <form id="issForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> Goods
                            Issuing <span class="text-muted" id="subTitleIss"></span>
                        </h4>
                        <input type="hidden" id="reqIdIss" name="reqIdIss"/>
                        <input type="hidden" id="funcIss" name="funcIss"/>
                    </div>
                    <div class="modal-body scroll" style="max-height: 65vh">
                        <div class="container">
                            <div class="row form-horizontal">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Request From</label>
                                        <label class="col-md-8 col-xs-12 control-label" id="reqFrIss"></label>
                                        <input type="hidden" name="rqFrIss" id="rqFrIss" value=""/>
                                    </div>
                                    <br>
                                </div>
                            </div>
                            <div class="row form-horizontal">
                                <div class="col-md-6">
                                    <div class="form-group" id="frWrhIss">
                                        <label class="col-md-4 col-xs-12 control-label">Warehouse <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <select class="bs-select" name="frwhIss" id="frwhIss"
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
                                    <div class="form-group" id="frBrncIss" style="display: none">
                                        <label class="col-md-4 col-xs-12 control-label">Issuing Branch <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <select class="bs-select" name="frBrnIss" id="frBrnIss"
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
                                <div class="col-md-6">
                                    <div class="form-group" id="ToBrncIss">
                                        <label class="col-md-4 col-xs-12 control-label">Requester Branch </label>
                                        <label class="col-md-8 col-xs-12 control-label" id="tobrcIss"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-horizontal">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Driver Name <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input type="text" class="form-control" id="drnm" name="drnm"
                                                   placeholder="Driver Name"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Contact Number <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input type="text" class="form-control" id="dctno" name="dctno"
                                                   placeholder="Mobile Number"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Vehicle Number <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input type="text" class="form-control" id="vhnm" name="vhnm"
                                                   placeholder="Number Plate Number"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-horizontal">
                                <h5 class="text-title"><span class="fa fa-tag"></span> Request Details</h5>
                            </div>
                            <div class="row form-horizontal">
                                <div class="table-responsive" style="padding: 10px 25px 10px 10px">
                                    <table class="table dataTable table-striped table-bordered" id="reqGdTblIss"
                                           width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-left">STOCK</th>
                                            <th class="text-left" title="Cost value">CSVL</th>
                                            <th class="text-left" title="Display value">DSVL</th>
                                            <th class="text-left" title="Sale value">SLVL</th>
                                            <th class="text-left" title="Market value">MKVL</th>
                                            <th class="text-left" title="Assigned Quantity">ASS. QTY.</th>
                                            <th class="text-left">OPTION</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <input type="hidden" id="lengIss" name="lengIss" value="0"/>
                                </div>
                            </div>
                            <div class="row form-horizontal">
                                <div class="col-md-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="col-md-5 col-xs-12 control-label">Remarks</label>
                                        <div class="col-md-7 col-xs-12">
                                            <div class="form-group">
                                                         <textarea class="form-control" name="remkIss" id="remkIss"
                                                                   rows="4" placeholder="Description"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                        </button>
                        <button type="button" id="issBtn" class="btn btn-success btn-sm btn-rounded">
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END MODAL ISSUE NOTE PRINT || ISSUE -->
    <!-- MODAL ADD SERIAL STOCK -->
    <div class="modal fade" id="modal-srl" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="modal-default-header">
        <div class="modal-dialog modal-warning modal-lg" role="document">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="icon-cross"></span>
            </button>
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> Select
                        Transfering
                        Items <span class="text-muted" id="qtyTitle"></span></h4>
                </div>
                <form id="addForm">
                    <div class="modal-body">
                        <div class="row form-horizontal">
                            <div class="col-md-6 col-xs-12">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="srlSrch"
                                           placeholder="Serial / Barcode / ect"/>
                                    <span class="input-group-btn">
                                                <button onclick="srchSrlNum(false);" class="btn btn-default btn-sm"
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
                        <button type="button" class="btn btn-link" data-dismiss="modal" onclick="closeIss()">Close</button>
                        <button type="button" id="addBtn" class="btn btn-warning btn-sm btn-rounded">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--    OLD ISSUE NOTES-->
    <div class="modal fade" id="modal-isNts" tabindex="-1" role="dialog"
         aria-labelledby="modal-default-header">
        <div class="modal-dialog modal-success modal-lg" role="document" style="width: 70%">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="icon-cross"></span>
            </button>
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> Issued Notes</h4>
                </div>
                <div class="modal-body scroll" style="max-height: 65vh">
                    <?php
                    if ($funcPerm[0]->inst == 1) { ?>
                        <div class="row form-horizontal">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Issued From</label>
                                    <div class="col-md-8 col-xs-12">
                                        <label class="switch">
                                            <input id="issFr" name="issFr" type="checkbox" onclick="checkIssFr()"
                                                   checked/>Branch
                                        </label>Warehouse
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                        <div class="row form-horizontal">
                            <div class="col-md-6">
                                <div class="form-group" id="issfrWrh">
                                    <label class="col-md-4 col-xs-12 control-label">Warehouse</label>
                                    <div class="col-md-8 col-xs-12">
                                        <select class="bs-select" name="frwhiss" id="frwhiss"
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
                                <div class="form-group" id="issfrBrnc" style="display: none">
                                    <label class="col-md-4 col-xs-12 control-label">Issuing Branch</label>
                                    <div class="col-md-8 col-xs-12">
                                        <select class="bs-select" name="frBrnciss" id="frBrnciss"
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Date Range</label>
                                    <div class="col-md-8 col-xs-12">
                                        <div class='input-group'>
                                            <input type='text' class="form-control dateranger" id="dtrngIss" name="dtrngIss"
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
                                                onclick="srch_issNote()">
                                            <span class="fa fa-search"></span>Search
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } else {
                        ?>
                        <div class="row form-horizontal">
                            <div class="col-md-6">
                                <div class="form-group" style="display: none">
                                    <label class="col-md-4 col-xs-12 control-label">Issuing Branch</label>
                                    <div class="col-md-8 col-xs-12">
                                        <select class="bs-select" name="frBrnciss" id="frBrnciss"
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Date Range</label>
                                    <div class="col-md-8 col-xs-12">
                                        <div class='input-group'>
                                            <input type='text' class="form-control dateranger" id="dtrngIss" name="dtrngIss"
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
                                                onclick="srch_issNote()">
                                            <span class="fa fa-search"></span>Search
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="row form-horizontal">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table datatable table-bordered table-striped"
                                       id="dataTbIssNt" width="100%">
                                    <thead>
                                    <tr>
                                        <th class="text-center"> #</th>
                                        <th class="text-center" title="Issue Note Number"> No</th>
                                        <th class="text-left"> Driver Name</th>
                                        <th class="text-left"> Vehicle No.</th>
                                        <th class="text-left"> Contact</th>
                                        <th class="text-left" title="Created By"> CRBY.</th>
                                        <th class="text-left" title="Created Date"> CRDT.</th>
                                        <th class="text-left"> OPTION</th>
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
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    <!--    OLD ISSUE NOTES-->
    <script type="text/javascript">
        $().ready(function (e) {
            $('#issForm').validate({
                rules: {
                    vhnm: {
                        required: true
                    },
                    drnm: {
                        required: true
                    },
                    dctno: {
                        required: true,
                        digits: true,
                        minlength: 9
                    }
                },
                messages: {
                    vhnm: {
                        required: "Enter vehicle number"
                    },
                    drnm: {
                        required: "Enter driver name"
                    },
                    dctno: {
                        required: "Enter contact number"
                    }
                }
            });

            $('#dataTbIssNt').DataTable({
                "columnDefs": [
                    {className: "text-left", "targets": [2, 3, 4, 5]},
                    {className: "text-center", "targets": [0, 1, 6, 7]},
                    {className: "text-right", "targets": []},
                    {className: "text-nowrap", "targets": [2]},
                ],
                "aoColumns": [
                    {sWidth: '1%'}, //No
                    {sWidth: '5%'}, //Issue No
                    {sWidth: '20%'}, //Driver name
                    {sWidth: '10%'}, //Vehi no
                    {sWidth: '10%'}, //Contact
                    {sWidth: '15%'}, //CRBY
                    {sWidth: '15%'}, //CRDT
                    {sWidth: '10%'}     //OPT
                ]
            });

            srch_rqGd();
        });

        //SEARCH
        function srch_rqGd() {
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
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                "columnDefs": [
                    {className: "text-left", "targets": [2, 3]},
                    {className: "text-center", "targets": [0, 1, 4, 5, 6, 7, 8]},
                    {className: "text-right", "targets": []},
                    {className: "text-nowrap", "targets": [2]},
                ],
                "serverSide": true,
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
                    url: '<?= base_url(); ?>Stock/srchReqStck',
                    type: 'post',
                    data: {
                        rqfr: rqfr,
                        rqbr: rqbr,
                        rcbr: rcbr,
                        rcwh: rcwh,
                        dtrg: dtrg,
                        stat: stat,
                        mode: 2
                    }
                }
            });
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

        //VIEW || EDIT || APPROVE view
        function viewStck(id, func) {
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
                url: "<?= base_url(); ?>Stock/vewReqStock2",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (response) {
                    var des = "";

                    disableSelct('frwhEdt');
                    disableSelct('frBrnEdt');
                    if (func == 'vew') {
                        //VIEW MODEL
                        $('#subTitle').html(' - View');
                        $("#modal-view").find('.edit_req').css("display", "none");
                        $(".edit_Area").css('display', 'none');
                        $(".view_Area").css('display', 'block');
                        $(".req-astrick").css('display', 'none');
                        //Make readonly all fields
                        $("#modal-view :input").attr("readonly", true);
                        //VIEW MODEL
                        var des = "disabled";
                    } else if (func == 'ass') {
                        //EDIT MODEL
                        $('#subTitle').html(' - Edit');
                        $("#modal-view").find('.edit_req').css("display", "inline");
                        $(".edit_Area").css('display', 'block');
                        $(".view_Area").css('display', 'none');
                        $(".req-astrick").css('display', 'inline');
                        //Make readonly all fields
                        $("#modal-view :input").attr("readonly", false);
                        //enableSelct('frwhEdt');
                        //enableSelct('frBrnEdt');
                        //EDIT MODEL
                    }

                    var len = response['req'].length;
                    var req = response['req'];
                    if (len > 0) {
                        $('#subTitle').html(" - " + req[0]['rqno']);
                        set_select('tobrcEdt', req[0]['rsbc']);
                        $('#remkEdt').val(req[0]['rmk']);

                        if (req[0]['rqfr'] == 1) {
                            $('#reqFrEdt').html(": Warehouse");
                            $('#rqFrEdt').val(1);
                            $('#frWrhEdt').css('display', 'inline');
                            $('#frBrncEdt').css('display', 'none');
                            set_select('frwhEdt', req[0]['rrbc']);
                        } else {
                            $('#reqFrEdt').html(": Branch");
                            $('#rqFrEdt').val(2);
                            $('#frWrhEdt').css('display', 'none');
                            $('#frBrncEdt').css('display', 'inline');
                            set_select('frBrnEdt', req[0]['rrbc']);
                        }

                        //STATUS
                        if (req[0]['stat'] == 0) {
                            var stat = "<label class='label label-warning'>Pending</label>";
                        } else if (req[0]['stat'] == 1) {
                            var stat = "<label class='label label-waining'>To Issue</label>";
                        } else if (req[0]['stat'] == 2) {
                            var stat = "<label class='label label-danger'>Cancelled</label>";
                        } else if (req[0]['stat'] == 3) {
                            var stat = "<label class='label label-info'>Delivered</label>";
                        } else if (req[0]['stat'] == 4) {
                            var stat = "<label class='label label-danger'>Issue Rejected</label>";
                        } else if (req[0]['stat'] == 5) {
                            var stat = "<label class='label label-indi'>Issued</label>";
                        } else {
                            var stat = "NOP";
                        }

                        $('#stc_stat').html(stat);
                        $('#tobrcEdt').html(": " + req[0]['rsbrcd'] + " - " + req[0]['rsbrnm']);
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

                        var len2 = response['reqs'].length;
                        $('#lengEdt').val(len2);
                        var reqs = response['reqs'];
                        if (func == 'vew') {
                            $('#reqGdTblView').DataTable().clear();
                            var t = $('#reqGdTblView').DataTable({
                                destroy: true,
                                searching: false,
                                bPaginate: false,
                                "ordering": false,
                                "columnDefs": [
                                    {className: "text-left", "targets": []},
                                    {className: "text-center", "targets": [0, 1, 6, 7]},
                                    {className: "text-right", "targets": [2, 3, 4, 5]},
                                    {className: "text-nowrap", "targets": [1]},
                                ],
                                "aoColumns": [
                                    {sWidth: '1%'}, //No
                                    {sWidth: '10%'},    //STOCK
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
                                    t.row.add([
                                        '*',
                                        reqs[vw]['stcd'],
                                        numeral(reqs[vw]['csvl']).format('0,0.00'),     // CSVL
                                        numeral(reqs[vw]['fcvl']).format('0,0.00'),     // FCVL
                                        numeral(reqs[vw]['slvl']).format('0,0.00'),     // SLVL
                                        numeral(reqs[vw]['mkvl']).format('0,0.00'),     // MKVL
                                        '<strong>' + numeral(reqs[vw]['thsAsCnt']).format('00') + '</strong>',
                                        ''
                                    ]).draw();
                                } else {
                                    item = reqs[vw]['itid'];

                                    //STATUS
                                    var content = "";
                                    if(reqs[vw]['stat']==4 || reqs[vw]['stat']==5){
                                        var rqin = response['rqin'];
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

                                    if (reqs[vw]['stat'] == 0) {
                                        var stat = "<label class='label label-warning'>To Issue</label>";
                                    } else if (reqs[vw]['stat'] == 3) {
                                        var stat = "<label class='label label-info'>Assigned</label>";
                                    } else if (reqs[vw]['stat'] == 4) {
                                        var stat = "<label class='label label-indi' style='cursor: pointer' title='Issue Details'" +
                                            "onclick='popOver(this);' data-container=\"body\" data-toggle=\"popover\" data-placement=\"top\"\n" +
                                            "                                                   data-html=\"true\"\n" +
                                            "                                                   data-trigger=\"focus\"\n" +
                                            "                                                   data-content=\"" + content + "\">Issued</label>";
                                    } else if (reqs[vw]['stat'] == 5) {
                                        var stat = "<label class='label label-success' style='cursor: pointer' title='Issue Details'" +
                                            "onclick='popOver(this);' data-container=\"body\" data-toggle=\"popover\" data-placement=\"top\"\n" +
                                            "                                                   data-html=\"true\"\n" +
                                            "                                                   data-trigger=\"focus\"\n" +
                                            "                                                   data-content=\"" + content + "\">Delivered</label>";
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
                                        '',
                                        ''
                                    ]).draw().node();
                                    $(rowNode).children().eq(1).prop('colspan', 5);
                                    $(rowNode).children().eq(1).addClass('text-left');
                                    $(rowNode).children().eq(2).addClass('text-left');
                                    $(rowNode).children().eq(3).removeClass('text-right');
                                    $(rowNode).children().eq(3).addClass('text-center');
                                    for (var ittt = 4; ittt < 8; ittt++) {
                                        $(rowNode).children().eq(4).remove();
                                    }
                                    $(rowNode).addClass('success');
                                    if (reqs[vw]['stcd'] == null) {
                                        rowNode = t.row.add([
                                            '*',
                                            '<strong>Stocks Not Available</strong>', '', '', '', '', '', ''
                                        ]).draw().node();
                                        $(rowNode).children().eq(1).prop('colspan', 8);
                                        $(rowNode).children().eq(1).addClass('text-left tbl-warn-msg');
                                        for (var ittt = 2; ittt < 8; ittt++) {
                                            $(rowNode).children().eq(2).remove();
                                        }
                                    } else {
                                        t.row.add([
                                            '*',
                                            reqs[vw]['stcd'],
                                            numeral(reqs[vw]['csvl']).format('0,0.00'),     // CSVL
                                            numeral(reqs[vw]['fcvl']).format('0,0.00'),     // FCVL
                                            numeral(reqs[vw]['slvl']).format('0,0.00'),     // SLVL
                                            numeral(reqs[vw]['mkvl']).format('0,0.00'),     // MKVL
                                            '<strong>' + numeral(reqs[vw]['thsAsCnt']).format('00') + '</strong>',
                                            ''
                                        ]).draw();
                                    }
                                    itmCnt++;
                                }
                            }

                        } else {
                            $('#reqGdTblEdt').DataTable().clear();
                            var t = $('#reqGdTblEdt').DataTable({
                                destroy: true,
                                searching: false,
                                bPaginate: false,
                                "ordering": false,
                                "columnDefs": [
                                    {className: "text-left", "targets": []},
                                    {className: "text-center", "targets": [0, 1, 6, 7, 8]},
                                    {className: "text-right", "targets": [2, 3, 4, 5]},
                                    {className: "text-nowrap", "targets": [1]},
                                ],
                                "aoColumns": [
                                    {sWidth: '1%'}, //No
                                    {sWidth: '10%'},    //STOCK
                                    {sWidth: '10%'},    //CSVL
                                    {sWidth: '10%'},    //DSVL
                                    {sWidth: '10%'},    //SLVL
                                    {sWidth: '10%'},    //MKVL
                                    {sWidth: '10%'},    //ASS / AV
                                    {sWidth: '10%'},    //THIS ASS
                                    {sWidth: '7%'},     //opt
                                ]
                            });

                            item = 0;
                            itmCnt = 1;
                            var match = 0;
                            for (var it = 0; it < len2; it++) {
                                var inpr = '';
                                if (reqs[it]['isInpr'] == '1') {
                                    inpr = 'disabled';
                                }

                                if (item == reqs[it]['itid']) {
                                    if (+reqs[it]['thsAsCnt'] > 0) {

                                        t.row.add([
                                            '*',
                                            reqs[it]['stcd'] + '<input type="hidden" name="stidEdt[]" id="stidEdt_' + it + '" value="' + reqs[it]['stid'] + ' ">',
                                            numeral(reqs[it]['csvl']).format('0,0.00'),     // CSVL
                                            numeral(reqs[it]['fcvl']).format('0,0.00'),     // FCVL
                                            numeral(reqs[it]['slvl']).format('0,0.00'),     // SLVL
                                            numeral(reqs[it]['mkvl']).format('0,0.00'),     // MKVL
                                            '<strong><span style="color: #76AB3C">' + numeral(reqs[it]['ascnt']).format('00') + '</span> / <span style="color: #F69F00">' + numeral(reqs[it]['avqn']).format('00') + '</span></strong>' +
                                            '<input type="hidden" name="asCntEdt[]" id="asCntEdt_' + it + '" value="' + reqs[it]['ascnt'] + '" class="match_' + match + '"><input type="hidden" name="avCntEdt[]" id="avCntEdt_' + it + '" value="' + (reqs[it]['avqn'] - (reqs[it]['ascnt'] - reqs[it]['thsAsCnt'])) + '" class="match_' + match + '">',
                                            '<strong>' + numeral(reqs[it]['thsAsCnt']).format('00') + '</strong>' +
                                            '<input type="hidden" name="hqtyEdt[]" id="hqtyEdt_' + it + '" class="match_' + match + '" value="' + reqs[it]['thsAsCnt'] + '"/>',
                                            '<button type="button" ' + inpr + ' class="btn btn-xs btn-warning" onclick="edtAsnGds(' + it + ',' + match + ',this)"><span><i class="fa fa-edit" title="Edit Assigned Goods"></i></span></button> ' +
                                            '<button type="button" ' + inpr + ' class="btn btn-xs btn-danger" onclick="canAsnGds(' + it + ',' + match + ')"><span><i class="fa fa-ban" title="Cancel Assigned Goods"></i></span></button>'
                                        ]).draw();
                                    } else {
                                        t.row.add([
                                            '*',
                                            reqs[it]['stcd'] + '<input type="hidden" name="stidEdt[]" id="stidEdt_' + it + '" value="' + reqs[it]['stid'] + ' ">',
                                            numeral(reqs[it]['csvl']).format('0,0.00'),     // CSVL
                                            numeral(reqs[it]['fcvl']).format('0,0.00'),     // FCVL
                                            numeral(reqs[it]['slvl']).format('0,0.00'),     // SLVL
                                            numeral(reqs[it]['mkvl']).format('0,0.00'),     // MKVL
                                            '<strong><span style="color: #76AB3C">' + numeral(reqs[it]['ascnt']).format('00') + '</span> / <span style="color: #F69F00">' + numeral(reqs[it]['avqn']).format('00') + '</span></strong>' +
                                            '<input type="hidden" name="asCntEdt[]" id="asCntEdt_' + it + '" value="' + reqs[it]['ascnt'] + '" class="match_' + match + '"><input type="hidden" name="avCntEdt[]" id="avCntEdt_' + it + '" value="' + (reqs[it]['avqn'] - (reqs[it]['ascnt'] - reqs[it]['thsAsCnt'])) + '" class="match_' + match + '">',
                                            '<input style="width: 80px" type="text" name="qtyEdt[]" id="qtyEdt_' + it + '" onkeyup="chckQty(this.value,' + it + ',' + match + ')" value="' + reqs[it]['thsAsCnt'] + '" class="text-right form-control match_' + match + '"/>' +
                                            '<input type="hidden" name="hqtyEdt[]" id="hqtyEdt_' + it + '" class="match_' + match + '" value="' + reqs[it]['thsAsCnt'] + '"/>',
                                            '<button type="button" ' + inpr + ' class="btn btn-xs btn-info match_' + match + '" onclick="assignGoods(' + it + ',' + match + ',\'ass\')"><span><i class="fa fa-chevron-right" title="Assign Goods"></i></span></button> ' +
                                            '<button type="button" disabled class="btn btn-xs btn-danger" onclick="canAsnGds(' + it + ',' + match + ')"><span><i class="fa fa-ban" title="Cancel Assigned Goods"></i></span></button>'
                                        ]).draw();
                                    }
                                } else {
                                    item = reqs[it]['itid'];
                                    match = it;
                                    rowNode = t.row.add([
                                        itmCnt,
                                        "ITEM : <strong>" + reqs[it]['itnm'] + " | " + reqs[it]['itcd'] + "</strong><br>" +
                                        "MODEL : <strong>" + reqs[it]['mdl'] + " (" + reqs[it]['mlcd'] + ")</strong>",
                                        "Scale : <strong>(" + reqs[it]['scl'] + ") " + reqs[it]['scnm'] + "</strong><br>" +
                                        "Requested QTY : <strong style='color: red'>" + reqs[it]['reqty'] + "</strong>" +
                                        "<input type='hidden' name='reqtyEdt[]' id='reqtyEdt_" + it + "' value='" + reqs[it]['reqty'] + "'/>" +
                                        "<input type='hidden' name='sbidEdt[]' id='sbidEdt_" + it + "' value='" + reqs[it]['auid'] + "'/>" +
                                        "<input type='hidden' name='itidEdt[]' id='itidEdt_" + it + "' value='" + reqs[it]['itid'] + "'/>",
                                        '',
                                        '',
                                        '',
                                        '',
                                        '',
                                        ''
                                    ]).draw().node();
                                    $(rowNode).children().eq(1).prop('colspan', 5);
                                    $(rowNode).children().eq(2).prop('colspan', 2);
                                    $(rowNode).children().eq(1).addClass('text-left');
                                    $(rowNode).children().eq(2).addClass('text-left');
                                    for (var ittt = 4; ittt < 9; ittt++) {
                                        $(rowNode).children().eq(4).remove();
                                    }
                                    $(rowNode).addClass('success');
                                    if (reqs[it]['stcd'] == null) {
                                        rowNode = t.row.add([
                                            '*',
                                            '<strong>Stocks Not Available</strong>', '', '', '', '', '', '', ''
                                        ]).draw().node();
                                        $(rowNode).children().eq(1).prop('colspan', 8);
                                        $(rowNode).children().eq(1).addClass('text-left tbl-warn-msg');
                                        for (var ittt = 2; ittt < 9; ittt++) {
                                            $(rowNode).children().eq(2).remove();
                                        }
                                    } else {
                                        if (+reqs[it]['thsAsCnt'] > 0) {
                                            t.row.add([
                                                '*',
                                                reqs[it]['stcd'] + '<input type="hidden" name="stidEdt[]" id="stidEdt_' + it + '" value="' + reqs[it]['stid'] + ' ">',
                                                numeral(reqs[it]['csvl']).format('0,0.00'),     // CSVL
                                                numeral(reqs[it]['fcvl']).format('0,0.00'),     // FCVL
                                                numeral(reqs[it]['slvl']).format('0,0.00'),     // SLVL
                                                numeral(reqs[it]['mkvl']).format('0,0.00'),     // MKVL
                                                '<strong><span style="color: #76AB3C">' + numeral(reqs[it]['ascnt']).format('00') + '</span> / <span style="color: #F69F00">' + numeral(reqs[it]['avqn']).format('00') + '</span></strong>' +
                                                '<input type="hidden" name="asCntEdt[]" id="asCntEdt_' + it + '" value="' + reqs[it]['ascnt'] + '" class="match_' + match + '"><input type="hidden" name="avCntEdt[]" id="avCntEdt_' + it + '" value="' + (reqs[it]['avqn'] - (reqs[it]['ascnt'] - reqs[it]['thsAsCnt'])) + '" class="match_' + match + '">',
                                                '<strong>' + numeral(reqs[it]['thsAsCnt']).format('00') + '</strong>' +
                                                '<input type="hidden" name="hqtyEdt[]" id="hqtyEdt_' + it + '" class="match_' + match + '" value="' + reqs[it]['thsAsCnt'] + '"/>',
                                                '<button type="button" ' + inpr + ' class="btn btn-xs btn-warning" onclick="edtAsnGds(' + it + ',' + match + ',this)"><span><i class="fa fa-edit" title="Edit Assigned Goods"></i></span></button> ' +
                                                '<button type="button" ' + inpr + ' class="btn btn-xs btn-danger" onclick="canAsnGds(' + it + ',' + match + ')"><span><i class="fa fa-ban" title="Cancel Assigned Goods"></i></span></button>'
                                            ]).draw();
                                        } else {
                                            t.row.add([
                                                '*',
                                                reqs[it]['stcd'] + '<input type="hidden" name="stidEdt[]" id="stidEdt_' + it + '" value="' + reqs[it]['stid'] + ' ">',
                                                numeral(reqs[it]['csvl']).format('0,0.00'),     // CSVL
                                                numeral(reqs[it]['fcvl']).format('0,0.00'),     // FCVL
                                                numeral(reqs[it]['slvl']).format('0,0.00'),     // SLVL
                                                numeral(reqs[it]['mkvl']).format('0,0.00'),     // MKVL
                                                '<strong><span style="color: #76AB3C">' + numeral(reqs[it]['ascnt']).format('00') + '</span> / <span style="color: #F69F00">' + numeral(reqs[it]['avqn']).format('00') + '</span></strong>' +
                                                '<input type="hidden" name="asCntEdt[]" id="asCntEdt_' + it + '" value="' + reqs[it]['ascnt'] + '" class="match_' + match + '"><input type="hidden" name="avCntEdt[]" id="avCntEdt_' + it + '" value="' + (reqs[it]['avqn'] - (reqs[it]['ascnt'] - reqs[it]['thsAsCnt'])) + '" class="match_' + match + '">',
                                                '<input style="width: 80px" type="text" name="qtyEdt[]" id="qtyEdt_' + it + '" onkeyup="chckQty(this.value,' + it + ',' + match + ')" value="' + reqs[it]['thsAsCnt'] + '" class="text-right form-control match_' + match + '"/>' +
                                                '<input type="hidden" name="hqtyEdt[]" id="hqtyEdt_' + it + '" class="match_' + match + '" value="' + reqs[it]['thsAsCnt'] + '"/>',
                                                '<button type="button" ' + inpr + ' class="btn btn-xs btn-info match_' + match + '" onclick="assignGoods(' + it + ',' + match + ',\'ass\')"><span><i class="fa fa-chevron-right" title="Assign Goods"></i></span></button> ' +
                                                '<button type="button" disabled class="btn btn-xs btn-danger" onclick="canAsnGds(' + it + ',' + match + ')"><span><i class="fa fa-ban" title="Cancel Assigned Goods"></i></span></button>'
                                            ]).draw();
                                        }
                                    }
                                    itmCnt++;
                                }
                            }
                        }
                    }
                    swal.close();
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

        function chckQty(val, row, match) {
            var avqt = +$('#avCntEdt_' + row).val();
            var asqt = +$('#asCntEdt_' + row).val();
            var rqqt = +$('#reqtyEdt_' + match).val();

            var exqty = 0;
            $("input[name='hqtyEdt[]']").filter(".match_" + match).each(function () {
                if (typeof $('#' + ($(this).attr('id')).substring(1)).val() == 'undefined') {
                    exqty = exqty + +$(this).val();
                } else {
                    exqty = exqty + +$('#' + ($(this).attr('id')).substring(1)).val();
                }
            });

            $('#qtyEdt_' + row).next('br').remove();
            $('#qtyEdt_' + row).next('.error').remove();
            $('#qtyEdt_' + row).css('border', '1px dotted');

            if (val == '') {
                $('#qtyEdt_' + row).after("<br><label id='name-error' class='error' style='font-size: 13px;color: red; font-style: italic;' for='qtyEdt_" + row + "'>Enter value</label>");
                $('#qtyEdt_' + row).css('border', '1px dotted red');
                return false;
            } else if (decimal(val)) {
                if (val == 0) {
                    $('#qtyEdt_' + row).after("<br><label id='name-error' class='error' style='font-size: 13px;color: red; font-style: italic;' for='qtyEdt_" + row + "'>Can't enter zero value</label>");
                    $('#qtyEdt_' + row).css('border', '1px dotted red');
                    return false;
                } else {
                    if (rqqt < exqty) {
                        $('#qtyEdt_' + row).after("<br><label id='name-error' class='error' style='font-size: 13px;color: red; font-style: italic;' for='qtyEdt_" + row + "'>Can't enter more than " + rqqt + "</label>");
                        $('#qtyEdt_' + row).css('border', '1px dotted red');
                        return false;
                    } else if (avqt < +val) {
                        $('#qtyEdt_' + row).after("<br><label id='name-error' class='error' style='font-size: 13px;color: red; font-style: italic;' for='qtyEdt_" + row + "'>Can't enter more than available QTY " + avqt + "</label>");
                        $('#qtyEdt_' + row).css('border', '1px dotted red');
                        return false;
                    }
                    return true;
                }
            } else {
                $('#qtyEdt_' + row).after("<br><label id='name-error' class='error' style='font-size: 13px;color: red; font-style: italic;' for='qtyEdt_" + row + "'>Please enter a correct number, format 0.00</label>");
                $('#qtyEdt_' + row).css('border', '1px dotted red');
                return false;
            }
        }

        //Assign Serial numbers view
        var stockAr = new Array();

        function assignGoods(row, match, func) {
            stockAr = {
                "stid": $('#stidEdt_' + row).val(),
                "rqfr": $('#rqFrEdt').val(),
                "rqid": $('#reqId').val(),
                "sbid": $('#sbidEdt_' + match).val(),
                "itid": $('#itidEdt_' + match).val(),
                "qty": $('#qtyEdt_' + row).val(),
                "func": func
            };

            if (chckQty($('#qtyEdt_' + row).val(), row, match)) {
                srchSrlNum(true);
                $('#added_srl').html('');
                $('#modal-srl').modal('show');
            }
        }

        //Search Serial Numbers
        function srchSrlNum(flag) {
            var val = $('#srlSrch').val();
            $('#srl_Number_Area').html('');

            var stid = stockAr.stid;
            var rqfr = stockAr.rqfr;
            var sbid = stockAr.sbid;
            swal({
                title: "Searching...",
                text: "",
                imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                showConfirmButton: false
            });

            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>Stock/srch_SrlNumTrn",
                data: {
                    val: val,
                    stid: stid,
                    rqfr: rqfr
                },
                dataType: 'json',
                success: function (data) {
                    var area = "";
                    var len = data.length;
                    if (len > 0) {
                        var stat = "";
                        for (var srl = 0; srl < len; srl++) {
                            var sbsid = data[srl]['ssid'];
                            var srno = data[srl]['srno'];
                            area = area + '<div class="col-md-3">\n' +
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

                    if (stockAr.func == 'edt' & flag) {
                        var area2 = "";
                        $.ajax({
                            type: "POST",
                            url: "<?= base_url(); ?>Stock/getAddSrlNumTrn",
                            data: {
                                stid: stid,
                                rqfr: rqfr,
                                sbid: sbid
                            },
                            dataType: 'json',
                            success: function (data) {
                                var len = data.length;
                                if (len > 0) {
                                    var stat = "";
                                    for (var srl = 0; srl < len; srl++) {
                                        var sbsid = data[srl]['ssid'];
                                        var srno = data[srl]['srno'];

                                        area2 = area2 + '<div class="col-md-3">\n' +
                                            '                                    <div class="app-widget-tile">\n' +
                                            '                                        <div class="line">\n' +
                                            '                                            <div class="title"><span class="badge badge-bordered badge-primary" title="Serial Number">' + srno + '</span></div>\n' +
                                            '                                            <div class="title pull-right"><button type="button" onclick="removeSrl(this)" class="btn btn-xs btn-warning btn-rounded btn-condensed"><span class="fa fa-close"></span></button></div>\n' +
                                            '                                        <input type="hidden" id="" name="srlnum[]" value="' + sbsid + '"/>' +
                                            '                                        </div>\n' +
                                            '                                    </div>\n' +
                                            '                                </div>';
                                    }
                                } else {
                                    area2 = "<h3>-- No Added Serial Numbers --</h3>";
                                }
                                $('#added_srl').html(area2);
                            },
                            error: function (data, textStatus) {
                                $('#added_srl').html(area2);
                            }
                        });
                    }
                    swal.close();
                },
                error: function (data, textStatus) {
                    $('#srl_Number_Area').html(area);
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

            if (len < +stockAr.qty) {
                $(node).parent().parent().parent().parent().remove();
                if (flag) {
                    $('#added_srl').append('<div class="col-md-3">\n' +
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

        //Remove Serial
        function removeSrl(node) {
            $(node).parent().parent().parent().parent().remove();
        }

        //Add to Transfer
        $('#addBtn').click(function (e) {
            e.preventDefault();
            if ($("input[name='srlnum[]']").length == +stockAr.qty) {
                $('#addBtn').prop('disabled', true);
                swal({
                    title: "Processing...",
                    text: "",
                    imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                    showConfirmButton: false
                });
                jQuery.ajax({
                    type: "POST",
                    url: "<?= base_url(); ?>Stock/addToTran",
                    data: $("#addForm").serialize() + ' & ' + $.param(stockAr),
                    dataType: 'json',
                    success: function (data) {
                        swal({title: "", text: "Added to transfer!", type: "success"},
                            function () {
                                $('#addBtn').prop('disabled', false);
                                clear_Form('addForm');
                                $('#modal-srl').modal('hide');
                                srch_rqGd();
                                viewStck(stockAr.rqid, 'edt');
                                stockAr = new Array();
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

        //EDIT ASSIGNED GOODS
        function edtAsnGds(row, match, node) {
            var oldQty = $('#hqtyEdt_' + row).val();
            $("input[name='qtyEdt[]']").filter(".match_" + match).each(function () {
                $(this).attr('readonly', true);
                $(this).val($('#h' + $(this).attr('id')).val());
            });
            $(".btn-info").filter(".match_" + match).each(function () {
                $(this).attr('disabled', true);
            });

            $(node).parents('tr').children().eq(7).html('<input style="width: 80px" type="text" name="qtyEdt[]" id="qtyEdt_' + row + '" onkeyup="chckQty(this.value,' + row + ',' + match + ')" value="' + oldQty + '" class="text-right form-control match_' + match + '"/>' +
                '<input type="hidden" name="hqtyEdt[]" id="hqtyEdt_' + row + '" class="match_' + match + '" value="' + oldQty + '"/>');
            $(node).parents('tr').children().eq(8).html('<button type="button" class="btn btn-xs btn-info" onclick="assignGoods(' + row + ',' + match + ',\'edt\')"><span><i class="fa fa-chevron-right" title="Assign Goods"></i></span></button>');

        }

        //CANCEL ASSIGNED GOODS
        function canAsnGds(row, match) {
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
                        text: "Cancelling...",
                        imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                        showConfirmButton: false
                    });
                    stockAr = {
                        "stid": $('#stidEdt_' + row).val(),
                        "rqfr": $('#rqFrEdt').val(),
                        "rqid": $('#reqId').val(),
                        "sbid": $('#sbidEdt_' + match).val(),
                        "itid": $('#itidEdt_' + match).val(),
                        "qty": $('#qtyEdt_' + row).val()
                    };

                    if (isConfirm) {
                        var jqXHR = jQuery.ajax({
                            type: "POST",
                            url: "<?= base_url(); ?>Stock/canAsnGds",
                            data: $.param(stockAr),
                            dataType: 'json',
                            success: function (data) {
                                swal({title: "", text: "Cancelled Assigned Goods", type: "success"},
                                    function () {
                                        srch_rqGd();
                                        viewStck(stockAr.rqid, 'ass');
                                        stockAr = new Array();
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
                        swal("Discarded", " ", "warning");
                    }
                });
        }

        function canAsnGdsIss(row, match) {
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
                        text: "Cancelling...",
                        imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                        showConfirmButton: false
                    });
                    stockAr = {
                        "stid": $('#stidIss_' + row).val(),
                        "rqfr": $('#rqFrIss').val(),
                        "rqid": $('#reqIdIss').val(),
                        "sbid": $('#sbidIss_' + match).val(),
                        "itid": $('#itidIss_' + match).val(),
                        "qty": $('#qtyIss_' + row).val()
                    };

                    if (isConfirm) {
                        var jqXHR = jQuery.ajax({
                            type: "POST",
                            url: "<?= base_url(); ?>Stock/canAsnGds",
                            data: $.param(stockAr),
                            dataType: 'json',
                            success: function (data) {
                                swal({title: "", text: "Cancelled Assigned Goods", type: "success"},
                                    function () {
                                        srch_rqGd();
                                        issStck(stockAr.rqid, 'prt');
                                        stockAr = new Array();
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
                        swal("Discarded", " ", "warning");
                    }
                });
        }

        function rejReq(id) {
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
                            url: "<?= base_url(); ?>Stock/reqIsReject",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (data) {
                                swal({title: "", text: "Request rejected!", type: "success"},
                                    function () {
                                        srch_rqGd();
                                        viewStck(id, 'ass')
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

        //PRINT ISSUE NOTE AND ISSUE GOODS
        var issueNote = new Array();

        function issStck(id, func, inid) {
            swal({
                title: "Please wait...",
                text: "Retrieving Data...",
                imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                showConfirmButton: false
            });

            $('#funcIss').val(func);
            $('#reqIdIss').val(id);
            issueNote = {
                'func': func,
                'inid': inid
            }
            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>Stock/vewReqStockIss",
                data: {
                    id: id,
                    func: func,
                    inid: inid
                },
                dataType: 'json',
                success: function (response) {
                    var des = "";

                    disableSelct('frwhIss');
                    disableSelct('frBrnIss');
                    var rqin = response['rqin'];
                    if (func == 'app') {
                        //VIEW MODEL
                        $('#subTitleIss').html(' - Issue Goods');
                        $('#issBtn').html('Issue');
                        $("#modal-iss").find('.edit_req').css("display", "none");
                        $(".view_AreaIss").css('display', 'none');
                        $(".req-astrick").css('display', 'none');
                        //Make readonly all fields
                        $("#modal-iss :input").attr("readonly", true);
                        //VIEW MODEL
                        var des = "disabled";
                        $('#drnm').val(rqin[0]['drnm']);
                        $('#vhnm').val(rqin[0]['vno']);
                        $('#dctno').val(rqin[0]['mbno']);
                        $('#remkIss').val(rqin[0]['rmk']);
                    } else if (func == 'prt') {
                        //APPROVE MODEL
                        $('#subTitleIss').html(' - Print Issue Note');
                        $('#issBtn').html('Print');
                        $("#modal-iss").find('.edit_req').css("display", "inline");
                        $(".view_AreaIss").css('display', 'block');
                        $(".req-astrick").css('display', 'inline');
                        //Make readonly all fields
                        $("#modal-iss :input").attr("readonly", false);
                        //enableSelct('frwhEdt');
                        //enableSelct('frBrnEdt');
                        //APPROVE MODEL
                    }

                    var len = response['req'].length;
                    var req = response['req'];
                    if (len > 0) {
                        if (func == 'app') {
                            $('#subTitleIss').html($('#subTitleIss').html() + " | " + rqin[0]['inno']);
                        } else {
                            $('#subTitleIss').html($('#subTitleIss').html() + " | " + req[0]['rqno']);
                        }
                        set_select('tobrcIss', req[0]['rsbc']);

                        if (req[0]['rqfr'] == 1) {
                            $('#reqFrIss').html(": Warehouse");
                            $('#rqFrIss').val(1);
                            $('#frWrhIss').css('display', 'inline');
                            $('#frBrncIss').css('display', 'none');
                            set_select('frwhIss', req[0]['rrbc']);
                        } else {
                            $('#reqFrIss').html(": Branch");
                            $('#rqFrIss').val(2);
                            $('#frWrhIss').css('display', 'none');
                            $('#frBrncIss').css('display', 'inline');
                            set_select('frBrnIss', req[0]['rrbc']);
                        }

                        $('#tobrcIss').html(": " + req[0]['rsbrcd'] + " - " + req[0]['rsbrnm']);

                        var len2 = response['reqs'].length;
                        $('#lengIss').val(len2);
                        var reqs = response['reqs'];

                        $('#reqGdTblIss').DataTable().clear();
                        var t = $('#reqGdTblIss').DataTable({
                            destroy: true,
                            searching: false,
                            bPaginate: false,
                            "ordering": false,
                            "columnDefs": [
                                {className: "text-left", "targets": []},
                                {className: "text-center", "targets": [0, 1, 6, 7]},
                                {className: "text-right", "targets": [2, 3, 4, 5]},
                                {className: "text-nowrap", "targets": [1]},
                            ],
                            "aoColumns": [
                                {sWidth: '1%'}, //No
                                {sWidth: '10%'},    //STOCK
                                {sWidth: '10%'},    //CSVL
                                {sWidth: '10%'},    //DSVL
                                {sWidth: '10%'},    //SLVL
                                {sWidth: '10%'},    //MKVL
                                {sWidth: '10%'},    //THIS ASS
                                {sWidth: '5%'},     //opt
                            ]
                        });

                        var item = 0;
                        var itmCnt = 1;
                        var match = 0;
                        for (var it = 0; it < len2; it++) {
                            if (item == reqs[it]['itid']) {
                                t.row.add([
                                    '*',
                                    reqs[it]['stcd'] + '<input type="hidden" name="stidIss[]" id="stidIss_' + it + '" value="' + reqs[it]['stid'] + ' ">' +
                                    '<input type="hidden" name="sb2auid[]" id="sb2auid_' + it + '" value="' + reqs[it]['sb2auid'] + ' ">',
                                    numeral(reqs[it]['csvl']).format('0,0.00'),     // CSVL
                                    numeral(reqs[it]['fcvl']).format('0,0.00'),     // FCVL
                                    numeral(reqs[it]['slvl']).format('0,0.00'),     // SLVL
                                    numeral(reqs[it]['mkvl']).format('0,0.00'),     // MKVL
                                    '<strong>' + numeral(reqs[it]['thsAsCnt']).format('00') + '</strong>' +
                                    '<input type="hidden" name="hqtyIss[]" id="hqtyIss_' + it + '" class="match_' + match + '" value="' + reqs[it]['thsAsCnt'] + '"/>',
                                    '<button type="button" ' + des + ' class="btn btn-xs btn-warning" onclick="edtAsnGdsIss(' + it + ',' + match + ')"><span><i class="fa fa-edit" title="Edit Assigned Goods"></i></span></button> ' +
                                    '<button type="button" ' + des + ' class="btn btn-xs btn-danger" onclick="canAsnGdsIss(' + it + ',' + match + ')"><span><i class="fa fa-ban" title="Cancel Assigned Goods"></i></span></button>'
                                ]).draw();
                            } else {
                                item = reqs[it]['itid'];
                                match = it;
                                rowNode = t.row.add([
                                    itmCnt,
                                    "ITEM : <strong>" + reqs[it]['itnm'] + " | " + reqs[it]['itcd'] + "</strong><br>" +
                                    "MODEL : <strong>" + reqs[it]['mdl'] + " (" + reqs[it]['mlcd'] + ")</strong>",
                                    "Scale : <strong>(" + reqs[it]['scl'] + ") " + reqs[it]['scnm'] + "</strong><br>" +
                                    "Requested QTY : <strong style='color: red'>" + reqs[it]['reqty'] + "</strong>" +
                                    "<input type='hidden' name='reqtyIss[]' id='reqtyIss_" + it + "' value='" + reqs[it]['reqty'] + "'/>" +
                                    "<input type='hidden' name='sbidIss[]' id='sbidIss_" + it + "' value='" + reqs[it]['auid'] + "'/>" +
                                    "<input type='hidden' name='itidIss[]' id='itidIss_" + it + "' value='" + reqs[it]['itid'] + "'/>",
                                    '',
                                    '',
                                    '',
                                    '',
                                    ''
                                ]).draw().node();
                                $(rowNode).children().eq(1).prop('colspan', 5);
                                $(rowNode).children().eq(1).addClass('text-left');
                                $(rowNode).children().eq(2).addClass('text-left');
                                for (var ittt = 4; ittt < 8; ittt++) {
                                    $(rowNode).children().eq(4).remove();
                                }
                                $(rowNode).addClass('success');

                                if (reqs[it]['stcd'] == null) {
                                    rowNode = t.row.add([
                                        '*',
                                        '<strong>Assinged Not Available</strong>', '', '', '', '', '', '', ''
                                    ]).draw().node();
                                    $(rowNode).children().eq(1).prop('colspan', 7);
                                    $(rowNode).children().eq(1).addClass('text-left tbl-warn-msg');
                                    for (var ittt = 2; ittt < 8; ittt++) {
                                        $(rowNode).children().eq(2).remove();
                                    }
                                } else {
                                    t.row.add([
                                        '*',
                                        reqs[it]['stcd'] + '<input type="hidden" name="stidIss[]" id="stidIss_' + it + '" value="' + reqs[it]['stid'] + ' ">' +
                                        '<input type="hidden" name="sb2auid[]" id="sb2auid_' + it + '" value="' + reqs[it]['sb2auid'] + ' ">',
                                        numeral(reqs[it]['csvl']).format('0,0.00'),     // CSVL
                                        numeral(reqs[it]['fcvl']).format('0,0.00'),     // FCVL
                                        numeral(reqs[it]['slvl']).format('0,0.00'),     // SLVL
                                        numeral(reqs[it]['mkvl']).format('0,0.00'),     // MKVL
                                        '<strong>' + numeral(reqs[it]['thsAsCnt']).format('00') + '</strong>' +
                                        '<input type="hidden" name="hqtyIss[]" id="hqtyIss_' + it + '" class="match_' + match + '" value="' + reqs[it]['thsAsCnt'] + '"/>',
                                        '<button type="button" ' + des + ' class="btn btn-xs btn-warning" onclick="edtAsnGdsIss(' + it + ',' + match + ')"><span><i class="fa fa-edit" title="Edit Assigned Goods"></i></span></button> ' +
                                        '<button type="button" ' + des + ' class="btn btn-xs btn-danger" onclick="canAsnGdsIss(' + it + ',' + match + ')"><span><i class="fa fa-ban" title="Cancel Assigned Goods"></i></span></button>'
                                    ]).draw();
                                }
                                itmCnt++;
                            }
                        }
                    }
                    swal.close();
                }
            });
        }

        function edtAsnGdsIss(row, match) {
            stockAr = {
                "stid": $('#stidIss_' + row).val(),
                "rqfr": $('#rqFrIss').val(),
                "rqid": $('#reqIdIss').val(),
                "sbid": $('#sbidIss_' + match).val(),
                "itid": $('#itidIss_' + match).val(),
                "qty": $('#hqtyIss_' + row).val(),
                "func": 'edt'
            };

            srchSrlNum(true);
            $('#added_srl').html('');
            $('#modal-srl').modal('show');
        }

        //Print Issue Note
        $('#issBtn').click(function (e) {
            e.preventDefault();
            if ($('#issForm').valid()) {
                swal({
                    title: "Please wait...",
                    text: "Making Issue Note...",
                    imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                    showConfirmButton: false
                });
                $('#issBtn').attr('disabled', true);
                if (+$('#lengIss').val() > 0) {
                    if (issueNote.func == 'app') {
                        $.ajax({
                            url: '<?= base_url(); ?>Stock/issGoods',
                            type: 'post',
                            data: $.param(issueNote),
                            dataType: 'json',
                            success: function (response) {
                                swal({title: "", text: "Issued to deliver", type: "success"},
                                    function () {
                                        srch_rqGd();
                                        $('#issBtn').attr('disabled', false);
                                        clear_Form('issForm');
                                        $('#modal-iss').modal('hide');
                                    });
                            },
                            error: function () {
                                swal({title: "", text: "Issueing Faild", type: "error"},
                                    function () {
                                        location.reload();
                                    });
                            }
                        });
                    } else {
                        $.ajax({
                            url: '<?= base_url(); ?>Stock/makeIsNote',
                            type: 'post',
                            data: $('#issForm').serialize(),
                            dataType: 'json',
                            success: function (response) {
                                setTimeout(function () {
                                    window.open('<?= base_url() ?>Stock/issue_note_print/' + response + '/1', 'popup', 'width=1000,height=600,scrollbars=no,resizable=no');
                                    swal.close(); // Hide the loading message
                                }, 1000);
                                srch_rqGd();
                                $('#issBtn').attr('disabled', false);
                                clear_Form('issForm');
                                $('#modal-iss').modal('hide');
                            },
                            error: function () {
                                swal({title: "", text: "Issue Note Making Faild", type: "error"},
                                    function () {
                                        location.reload();
                                    });
                            }
                        });
                    }
                } else {
                    swal({title: "", text: "No Assigned Goods", type: "warning"});
                }
            }
        });

        function popOver(node) {
            $(node).popover('toggle');
            $('[data-toggle="popover"]').not($(node).popover()).popover('hide');
        }

        function closeView() {
            $('[data-toggle="popover"]').popover('hide');
        }
        
        function closeIss() {
            default_Selector($('#frwhIss').prev());
            $('#drnm').val('');
            $('#vhnm').val('');
            $('#dctno').val('');
        }

        function checkIssFr() {
            if ($('#issFr').prop('checked')) {
                $('#issfrWrh').css('display', 'inline');
                $('#issfrBrnc').css('display', 'none');
            } else {
                $('#issfrWrh').css('display', 'none');
                $('#issfrBrnc').css('display', 'inline');
            }
        }

        //Search old issue notes
        function srch_issNote() {
            var isfr = $('#issFr').prop('checked');
            var isbr = $('#frBrnciss').val(); //Req receiver Branch (goods from brnch)
            var iswh = $('#frwhiss').val(); //Req receiver warehouse (goods from warehouse)
            var dtrg = $('#dtrngIss').val(); //Date Range

            $('#dataTbIssNt').DataTable().clear();
            $('#dataTbIssNt').DataTable({
                "destroy": true,
                "cache": false,
                "processing": true,
                "orderable": true,
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                "columnDefs": [
                    {className: "text-left", "targets": [2, 3, 4, 5]},
                    {className: "text-center", "targets": [0, 1, 6, 7]},
                    {className: "text-right", "targets": []},
                    {className: "text-nowrap", "targets": [2]},
                ],
                "serverSide": true,
                "order": [[6, "DESC"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '1%'}, //No
                    {sWidth: '10%'}, //Issue No
                    {sWidth: '20%'}, //Driver name
                    {sWidth: '10%'}, //Vehi no
                    {sWidth: '10%'}, //Contact
                    {sWidth: '15%'}, //CRBY
                    {sWidth: '15%'}, //CRDT
                    {sWidth: '10%'}     //OPT
                ],
                "ajax": {
                    url: '<?= base_url(); ?>Stock/srchIssNote',
                    type: 'post',
                    data: {
                        isfr: isfr,
                        isbr: isbr,
                        iswh: iswh,
                        dtrg: dtrg,
                    }
                }
            });
        }

        //OLD ISSUE NOTES REPRINT || VIEW
        function issNtRp(id) {
            swal({
                title: "Please wait...",
                text: "Collecting data to print...",
                imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                showConfirmButton: false
            });

            setTimeout(function () {
                window.open('<?= base_url() ?>Stock/issue_note_print/' + id + '/2', 'popup', 'width=1000,height=600,scrollbars=no,resizable=no');
                swal.close(); // Hide the loading message
            }, 1000);
        }
    </script>
</div>
<!-- END PAGE CONTAINER -->
