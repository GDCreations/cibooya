<!--<script type="text/javascript" src="--><?//= base_url(); ?><!--assets/js/custom-js/full_width.js"></script>-->

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
    <?php
    if ($funcPerm[0]->inst == 1) { ?>
        <div class="pull-right">
            <button class="btn btn-sm btn-info btn-icon-fixed btn-rounded" data-toggle="modal" data-target="#modal-add">
                <span class="fa fa-plus"></span>New Transfer
            </button>
        </div>
    <?php }
    ?>
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
                                <option value="all">ALL Status</option>
                                <option value="0">Pending</option>
                                <option value="1">Checked</option>
                                <option value="2">Cancelled</option>
                                <option value="3">Goods Assigned</option>
                                <option value="4">Goods Issued</option>
                                <option value="5">Delivered</option>
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
                                <option value="0">-- Select Branch --</option>
                                <?php
                                foreach ($brncFrm as $brf) {
                                    if ($brf['brch_id']!='0' && $brf['brch_id']!='all') {
                                        echo "<option value='".$brf['brch_id']."'>".$brf['brch_code']." - ".$brf['brch_name']."</option>";
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
                                <option value="all">ALL Status</option>
                                <option value="0">Pending</option>
                                <option value="1">Checked</option>
                                <option value="2">Cancelled</option>
                                <option value="3">Goods Assigned</option>
                                <option value="4">Goods Issued</option>
                                <option value="5">Delivered</option>
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
                                <option value="0">-- Select Branch --</option>
                                <?php
                                foreach ($brncTo as $brt) {
                                    echo "<option value='$brt->brid'>$brt->brcd - $brt->brnm</option>";
                                }
                                ?>
                            </select>
                            <br/></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 col-xs-12 control-label">Item Name</label>
                        <div class="col-md-8 col-xs-12">
                            <select class="bs-select" data-live-search="true" id="items" name="items"
                                    onchange="chckBtn(this.value,this.id)">
                                <option value="0">-- Select Item --</option>
                                <?php
                                foreach ($item as $itm) {
                                    echo "<option value='$itm->itid'>" . $itm->itcd . " - " . $itm->itnm . "</option>";
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
    <div class="block">
        <div class="row form-horizontal">
            <div class="table-responsive">
                <table class="table datatable table-bordered table-striped"
                       id="dataTbReq" width="100%">
                    <thead>
                    <tr>
                        <th class="text-center"> #</th>
                        <th class="text-left" id="Reference number">REF. NO.</th>
                        <th class="text-left" title="Issuing warehouse or branch"> ISSUED BY</th>
                        <th class="text-left" title="Requested or recieved by"> REQ. BY</th>
                        <th class="text-left" title="Item count"> ITEM CNT.</th>
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

    <script type="text/javascript">
        $().ready(function (e) {
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
                    {className: "text-left", "targets": [2]},
                    {className: "text-center", "targets": [0, 1, 3, 5, 6, 7]},
                    {className: "text-right", "targets": [4]},
                    {className: "text-nowrap", "targets": [2]},
                ],
                "aoColumns": [
                    {sWidth: '1%'}, //No
                    {sWidth: '7%'},    //REF
                    {sWidth: '20%'},    //IS BY
                    {sWidth: '20%'},    //RQ BY
                    {sWidth: '7%'},    //ITEM COUNT
                    {sWidth: '10%'},    //CRDT
                    {sWidth: '10%'},     //Status
                    {sWidth: '15%'}     //OPT
                ]
            });
        });

        function srcheckFr() {
            if ($('#srreqFr').prop('checked')) {
                $('#srfrWrh').css('display', 'inline');
                $('#srfrBrnc').css('display', 'none');
            } else {
                $('#srfrWrh').css('display', 'none');
                $('#srfrBrnc').css('display', 'inline');
            }
        }
    </script>
</div>
<!-- END PAGE CONTAINER -->
