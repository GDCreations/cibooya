<script type="text/javascript" src="<?= base_url(); ?>assets/js/custom-js/full_width.js"></script>

<style>
    .tbl-warn-msg {
        color: #F69F00;
        font-size: 12px;
        font-style: italic;
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
<!--                            <option value="2">Cancelled</option>-->
                            <option value="3">Delivered</option>
                            <option value="4">Issuing Reject</option>
                        </select>
                    </div>
                </div>
            </div>
            <?php }else{
            ?>
            <div class="row form-horizontal">
                <div class="col-md-4">
                    <div class="form-group" id="srfrBrnc">
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
                                <!--                            <option value="2">Cancelled</option>-->
                                <option value="3">Delivered</option>
                                <option value="4">Issuing Reject</option>
                            </select>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
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
                                       value="<?= '2019-10-01' ?> / <?= date('Y-m-d') ?>"/>
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
                            <button type="button" data-toggle="modal" data-target='#modalIsNote'
                                    onclick="reqLoadIsNt()" class='btn btn-sm btn-danger btn-rounded btn-icon-fixed'>
                                <span class="fa fa-file-text-o"></span> Issue Note
                            </button>
                        </div>
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

    <!-- MODAL VIEW || APPROVE || EDIT REQUEST -->
    <div class="modal fade" id="modal-view" tabindex="-1" role="dialog" aria-labelledby="modal-default-header">
        <div class="modal-dialog model-lg modal-info" role="document" style="width: 60%">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"
                                                                                              class="icon-cross"></span>
            </button>
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> Goods
                        Issuing <span class="text-muted" id="subTitle"></span>
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
                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!-- END VIEW || APPROVE || EDIT REQUEST -->
    <!-- MODAL ADD SERIAL STOCK -->
    <div class="modal fade" id="modal-srl" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="modal-default-header">
        <div class="modal-dialog modal-warning modal-lg" role="document">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="icon-cross"></span>
            </button>
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> Select Transfering
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
        <script type="text/javascript">
            $().ready(function (e) {
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
                        } else if (func == 'app') {
                            //APPROVE MODEL
                            $('#subTitle').html(' - Approve');
                            $("#modal-view").find('.edit_req').css("display", "inline");
                            $(".edit_Area").css('display', 'block');
                            $(".view_Area").css('display', 'none');
                            $(".req-astrick").css('display', 'inline');
                            //Make readonly all fields
                            $("#modal-view :input").attr("readonly", false);
                            //enableSelct('frwhEdt');
                            //enableSelct('frBrnEdt');
                            //APPROVE MODEL
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
                                var stat = "<label class='label label-success'>Waiting For Goods</label>";
                            } else if (req[0]['stat'] == 2) {
                                var stat = "<label class='label label-danger'>Cancelled</label>";
                            } else if (req[0]['stat'] == 3) {
                                var stat = "<label class='label label-info'>Received</label>";
                            } else if (req[0]['stat'] == 4) {
                                var stat = "<label class='label label-indi'>Issue Rejected</label>";
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
                                        (it + 1),
                                        reqs[it]['itcd'] + '<input type="hidden" name="itidEdt[]" value="' + reqs[it]['itid'] + ' ">' +
                                        '<input type="hidden" name="rqsid[]" value="' + reqs[it]['auid'] + '"/>',     // ITEM CODE
                                        reqs[it]['itnm'],
                                        reqs[it]['mlcd'] + " - " + reqs[it]['mdl'], //Model
                                        reqs[it]['scnm'] + " (" + reqs[it]['scl'] + ")", //Scale
                                        numeral(reqs[it]['reqty']).format('0,0') + '<input type="hidden" name="quntyEdt[]" value="' + reqs[it]['reqty'] + ' ">',         // QUNT
                                        '<button type="button" ' + des + ' class="btn btn-xs btn-warning" id="dltrwEdt" onclick=""><span><i class="fa fa-close" title="Remove"></i></span></button>'
                                    ]).draw(false);
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
                                        {sWidth: '5%'},     //opt
                                    ]
                                });

                                var item = 0;
                                var itmCnt = 1;
                                var match = 0;
                                for (var it = 0; it < len2; it++) {
                                    if (item == reqs[it]['itid']) {
                                        if(+reqs[it]['thsAsCnt']>0){
                                            t.row.add([
                                                '*',
                                                reqs[it]['stcd'] + '<input type="hidden" name="stidEdt[]" id="stidEdt_' + it + '" value="' + reqs[it]['stid'] + ' ">',
                                                numeral(reqs[it]['csvl']).format('0,0.00'),     // CSVL
                                                numeral(reqs[it]['fcvl']).format('0,0.00'),     // FCVL
                                                numeral(reqs[it]['slvl']).format('0,0.00'),     // SLVL
                                                numeral(reqs[it]['mkvl']).format('0,0.00'),     // MKVL
                                                '<strong><span style="color: #76AB3C">' + numeral(reqs[it]['ascnt']).format('00') + '</span> / <span style="color: #F69F00">' + numeral(reqs[it]['avqn']).format('00') + '</span></strong>' +
                                                '<input type="hidden" name="asCntEdt[]" id="asCntEdt_' + it + '" value="' + reqs[it]['ascnt'] + '" class="match_' + match + '"><input type="hidden" name="avCntEdt[]" id="avCntEdt_' + it + '" value="' + (reqs[it]['avqn'] - (reqs[it]['ascnt'] - reqs[it]['thsAsCnt'])) + '" class="match_' + match + '">',
                                                '<strong>'+numeral(reqs[it]['thsAsCnt']).format('00')+'</strong>' +
                                                '<input type="hidden" name="hqtyEdt[]" id="hqtyEdt_'+it+'" class="match_' + match + '" value="'+reqs[it]['thsAsCnt']+'"/>',
                                                '<button type="button" ' + des + ' class="btn btn-xs btn-warning" onclick="edtAsnGds(' + it + ',' + match + ',this)"><span><i class="fa fa-edit" title="Edit Assigned Goods"></i></span></button> '+
                                                '<button type="button" ' + des + ' class="btn btn-xs btn-danger" onclick="canAsnGds(' + it + ',' + match + ')"><span><i class="fa fa-ban" title="Cancel Assigned Goods"></i></span></button>'
                                            ]).draw();
                                        }else{
                                            t.row.add([
                                                '*',
                                                reqs[it]['stcd'] + '<input type="hidden" name="stidEdt[]" id="stidEdt_' + it + '" value="' + reqs[it]['stid'] + ' ">',
                                                numeral(reqs[it]['csvl']).format('0,0.00'),     // CSVL
                                                numeral(reqs[it]['fcvl']).format('0,0.00'),     // FCVL
                                                numeral(reqs[it]['slvl']).format('0,0.00'),     // SLVL
                                                numeral(reqs[it]['mkvl']).format('0,0.00'),     // MKVL
                                                '<strong><span style="color: #76AB3C">' + numeral(reqs[it]['ascnt']).format('00') + '</span> / <span style="color: #F69F00">' + numeral(reqs[it]['avqn']).format('00') + '</span></strong>' +
                                                '<input type="hidden" name="asCntEdt[]" id="asCntEdt_' + it + '" value="' + reqs[it]['ascnt'] + '" class="match_' + match + '"><input type="hidden" name="avCntEdt[]" id="avCntEdt_' + it + '" value="' + (reqs[it]['avqn'] - (reqs[it]['ascnt'] - reqs[it]['thsAsCnt'])) + '" class="match_' + match + '">',
                                                '<input style="width: 80px" type="text" name="qtyEdt[]" id="qtyEdt_' + it + '" onkeyup="chckQty(this.value,' + it + ',' + match + ')" value="'+reqs[it]['thsAsCnt']+'" class="text-right form-control match_' + match + '"/>'+
                                                '<input type="hidden" name="hqtyEdt[]" id="hqtyEdt_'+it+'" class="match_' + match + '" value="'+reqs[it]['thsAsCnt']+'"/>',
                                                '<button type="button" ' + des + ' class="btn btn-xs btn-info match_' + match + '" onclick="assignGoods(' + it + ',' + match + ',\'ass\')"><span><i class="fa fa-chevron-right" title="Assign Goods"></i></span></button> '+
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
                                            if(+reqs[it]['thsAsCnt']>0){
                                                t.row.add([
                                                    '*',
                                                    reqs[it]['stcd'] + '<input type="hidden" name="stidEdt[]" id="stidEdt_' + it + '" value="' + reqs[it]['stid'] + ' ">',
                                                    numeral(reqs[it]['csvl']).format('0,0.00'),     // CSVL
                                                    numeral(reqs[it]['fcvl']).format('0,0.00'),     // FCVL
                                                    numeral(reqs[it]['slvl']).format('0,0.00'),     // SLVL
                                                    numeral(reqs[it]['mkvl']).format('0,0.00'),     // MKVL
                                                    '<strong><span style="color: #76AB3C">' + numeral(reqs[it]['ascnt']).format('00') + '</span> / <span style="color: #F69F00">' + numeral(reqs[it]['avqn']).format('00') + '</span></strong>' +
                                                    '<input type="hidden" name="asCntEdt[]" id="asCntEdt_' + it + '" value="' + reqs[it]['ascnt'] + '" class="match_' + match + '"><input type="hidden" name="avCntEdt[]" id="avCntEdt_' + it + '" value="' + (reqs[it]['avqn'] - (reqs[it]['ascnt'] - reqs[it]['thsAsCnt'])) + '" class="match_' + match + '">',
                                                    '<strong>'+numeral(reqs[it]['thsAsCnt']).format('00')+'</strong>' +
                                                    '<input type="hidden" name="hqtyEdt[]" id="hqtyEdt_'+it+'" class="match_' + match + '" value="'+reqs[it]['thsAsCnt']+'"/>',
                                                    '<button type="button" ' + des + ' class="btn btn-xs btn-warning" onclick="edtAsnGds(' + it + ',' + match + ',this)"><span><i class="fa fa-edit" title="Edit Assigned Goods"></i></span></button> '+
                                                    '<button type="button" ' + des + ' class="btn btn-xs btn-danger" onclick="canAsnGds(' + it + ',' + match + ')"><span><i class="fa fa-ban" title="Cancel Assigned Goods"></i></span></button>'
                                                ]).draw();
                                            }else{
                                                t.row.add([
                                                    '*',
                                                    reqs[it]['stcd'] + '<input type="hidden" name="stidEdt[]" id="stidEdt_' + it + '" value="' + reqs[it]['stid'] + ' ">',
                                                    numeral(reqs[it]['csvl']).format('0,0.00'),     // CSVL
                                                    numeral(reqs[it]['fcvl']).format('0,0.00'),     // FCVL
                                                    numeral(reqs[it]['slvl']).format('0,0.00'),     // SLVL
                                                    numeral(reqs[it]['mkvl']).format('0,0.00'),     // MKVL
                                                    '<strong><span style="color: #76AB3C">' + numeral(reqs[it]['ascnt']).format('00') + '</span> / <span style="color: #F69F00">' + numeral(reqs[it]['avqn']).format('00') + '</span></strong>' +
                                                    '<input type="hidden" name="asCntEdt[]" id="asCntEdt_' + it + '" value="' + reqs[it]['ascnt'] + '" class="match_' + match + '"><input type="hidden" name="avCntEdt[]" id="avCntEdt_' + it + '" value="' + (reqs[it]['avqn'] - (reqs[it]['ascnt'] - reqs[it]['thsAsCnt'])) + '" class="match_' + match + '">',
                                                    '<input style="width: 80px" type="text" name="qtyEdt[]" id="qtyEdt_' + it + '" onkeyup="chckQty(this.value,' + it + ',' + match + ')" value="'+reqs[it]['thsAsCnt']+'" class="text-right form-control match_' + match + '"/>'+
                                                    '<input type="hidden" name="hqtyEdt[]" id="hqtyEdt_'+it+'" class="match_' + match + '" value="'+reqs[it]['thsAsCnt']+'"/>',
                                                    '<button type="button" ' + des + ' class="btn btn-xs btn-info match_' + match + '" onclick="assignGoods(' + it + ',' + match + ',\'ass\')"><span><i class="fa fa-chevron-right" title="Assign Goods"></i></span></button> '+
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
                    if(typeof $('#'+($(this).attr('id')).substring(1)).val()=='undefined'){
                        exqty = exqty + +$(this).val();
                    }else{
                        exqty = exqty + +$('#'+($(this).attr('id')).substring(1)).val();
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
                        }else if(avqt < +val){
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
            function assignGoods(row, match,func) {
                stockAr = {
                    "stid":$('#stidEdt_' + row).val(),
                    "rqfr":$('#rqFrEdt').val(),
                    "rqid":$('#reqId').val(),
                    "sbid":$('#sbidEdt_'+match).val(),
                    "itid":$('#itidEdt_'+match).val(),
                    "qty": $('#qtyEdt_'+row).val(),
                    "func": func
                };

                if (chckQty($('#qtyEdt_' + row).val(), row, match)) {
                    srchSrlNum();
                    $('#added_srl').html('');
                    $('#modal-srl').modal('show');
                }
            }

            //Search Serial Numbers
            function srchSrlNum() {
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

                        if(stockAr.func=='edt'){
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
                        data: $("#addForm").serialize()+' & '+$.param(stockAr),
                        dataType: 'json',
                        success: function (data) {
                            swal({title: "", text: "Added to transfer!", type: "success"},
                                function () {
                                    $('#addBtn').prop('disabled', false);
                                    clear_Form('addForm');
                                    $('#modal-srl').modal('hide');
                                    srch_rqGd();
                                    viewStck(stockAr.rqid,'edt');
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
            function edtAsnGds(row,match,node) {
                var oldQty = $('#hqtyEdt_'+row).val();
                $("input[name='qtyEdt[]']").filter(".match_" + match).each(function () {
                    $(this).attr('readonly',true);
                    $(this).val($('#h'+$(this).attr('id')).val());
                });
                $(".btn-info").filter(".match_" + match).each(function () {
                    $(this).attr('disabled',true);
                });

                $(node).parents('tr').children().eq(7).html('<input style="width: 80px" type="text" name="qtyEdt[]" id="qtyEdt_' + row + '" onkeyup="chckQty(this.value,' + row + ',' + match + ')" value="'+oldQty+'" class="text-right form-control match_' + match + '"/>' +
                    '<input type="hidden" name="hqtyEdt[]" id="hqtyEdt_'+row+'" class="match_' + match + '" value="'+oldQty+'"/>');
                $(node).parents('tr').children().eq(8).html('<button type="button" class="btn btn-xs btn-info" onclick="assignGoods(' + row + ',' + match + ',\'edt\')"><span><i class="fa fa-chevron-right" title="Assign Goods"></i></span></button>');

            }

            //CANCEL ASSIGNED GOODS
            function canAsnGds(row,match){
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
                            "stid":$('#stidEdt_' + row).val(),
                            "rqfr":$('#rqFrEdt').val(),
                            "rqid":$('#reqId').val(),
                            "sbid":$('#sbidEdt_'+match).val(),
                            "itid":$('#itidEdt_'+match).val(),
                            "qty": $('#qtyEdt_'+row).val()
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
                                            viewStck(stockAr.rqid,'ass');
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
