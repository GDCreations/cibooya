<style>
    .form-group .tx-align-tl {
        text-align: left;
    }
    .form-group .tx-align {
        text-align: right;
    }
</style>
<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">Stock Access</a></li>
        <li class="active">Purchase Order</li>
    </ul>
</div>
<div class="app-heading app-heading-bordered app-heading-page">
    <div class="icon icon-lg">
        <span class="fa fa-list-ul" style="color: #e69c0f;"></span>
    </div>
    <div class="title">
        <h1>Purchase Order</h1>
        <p>Add / Edit / Reject / Approve / Search & View</p>
    </div>
    <?php
    if ($funcPerm[0]->inst == 1) { ?>
        <div class="pull-right">
            <button class="btn btn-sm btn-info btn-icon-fixed btn-rounded" data-toggle="modal" data-target="#modal-add">
                <span class="fa fa-plus"></span>Add New
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
                        <select class="bs-select" id="supps" name="supps"
                                onchange="chckBtn(this.value,this.id)">
                            <option value="all">All Suppliers</option>
                            <?php
                            foreach ($supplier as $sup) {
                                echo "<option value='$sup->spid'>" . $sup->spcd . " - " . $sup->spnm . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-md-4 col-xs-12 control-label">Status</label>
                    <div class="col-md-8 col-xs-12">
                        <select id="stat" name="stat" class="bs-select" onchange="srch_Typ()">
                            <option value="all">All</option>
                            <option value="0">Pending</option>
                            <option value="1">Active</option>
                            <option value="3">Inactive</option>
                            <option value="2">Reject</option>
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
                                onclick="srch_Po()">
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
                <table id="pom_table" class="table dataTable table-striped table-bordered" width="100%">
                    <thead>
                    <tr>
                        <th class="text-left">#</th>
                        <th class="text-left">PO NO</th>
                        <th class="text-left">SUPPLIER</th>
                        <th class="text-left">ORDER DATE</th>
                        <th class="text-left">VALUE</th>
                        <th class="text-left">CREATED DATE</th>
                        <th class="text-left">STATUS</th>
                        <th class="text-left">ACTION</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <!-- MODAL ADD NEW PO -->
    <div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modal-default-header">
        <div class="modal-dialog model-lg" role="document" style="width: 80%">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"
                                                                                              class="icon-cross"></span>
            </button>
            <form id="add_po_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> Add Purchase
                            Order
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row form-horizontal">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Supplier Name <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-6 col-xs-12">
                                            <select class="bs-select" id="supp" name="supp"
                                                    onchange="chckBtn(this.value,this.id)">
                                                <option value="0">-- Select Supplier --</option>
                                                <?php
                                                foreach ($supplier as $sup) {
                                                    echo "<option value='$sup->spid'>" . $sup->spcd . " - " . $sup->spnm . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Order Date <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="input-group date">
                                                <input type="text" class="form-control datetimepicker" id="oddt"
                                                       name="oddt" value="<?= date('Y-m-d') ?>"
                                                       style="cursor: pointer;">
                                                <span class="input-group-addon">
                                                    <span class="fa fa-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Reference Details <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-6 col-xs-12">
                                            <input type="text" name="refd" id="refd" class="form-control text-uppercase"
                                                   placeholder="Reference Number"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Delivery To <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-6 col-xs-12">
                                            <select class="bs-select" id="whs" name="whs"
                                                    onchange="chckBtn(this.value,this.id)">
                                                <option value="0">-- Select Warehouse --</option>
                                                <?php
                                                foreach ($warehouse as $wh) {
                                                    echo "<option value='$wh->whid'>" . $wh->whcd . " - " . $wh->whnm . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-horizontal">
                                <h5 class="text-title"><span class="fa fa-tag"></span> Order Details</h5>
                            </div>
                            <div class="row form-horizontal">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Item Name</label>
                                        <div class="col-md-8 col-xs-12">
                                            <select class="bs-select" data-live-search="true" id="item" name="item"
                                                    onchange="chckBtn(this.value,this.id); getScale(this.value); setDataContent('cnty',this.value,'item_pulse');">
                                                <option value="0">-- Select Item --</option>
                                                <script>
                                                    var scale = new Array();
                                                </script>
                                                <?php
                                                foreach ($item as $itm) {
                                                    echo "<option value='$itm->itid'>" . $itm->itcd . " - " . $itm->itnm . "</option>";
                                                    ?>
                                                    <script>
                                                        scale.push([<?= $itm->itid?>, '<?= $itm->scnm . " (" . $itm->scl . ")"?>', <?= $itm->slid?>, '<?= $itm->itcd?>', '<?= $itm->itnm?>']);
                                                    </script>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label" id="stScale">Quantity</label>
                                        <div class="col-md-8 col-xs-12">
                                            <div class="app-spinner pulse pulse-primary col-md-push-6 col-xs-push-6"
                                                 id="item_pulse" style="display: none;"></div>
                                            <input type="text" id="cnty" name="cnty" class="form-control"
                                                   placeholder="Quantity"
                                                   data-container="body" data-toggle="popover" data-placement="top"
                                                   data-html="true"
                                                   data-trigger="focus"
                                                   data-content="No Data"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-md-4 col-xs-12 control-label" id="stScale">Unit Price</label>
                                    <div class="col-md-6 col-xs-10">
                                        <input type="text" id="price" name="price" class="form-control"
                                               placeholder="Price 00.00"/>
                                    </div>
                                    <div class="col-md-2 col-xs-2">
                                        <button type="button" class="btn btn-sm btn-info" style="margin: 0px"
                                                onclick="addItem()"><span
                                                    class="fa fa-plus"></span></button>
                                    </div>
                                    <input type="hidden" id="leng" name="leng">
                                </div>
                            </div>
                            <div class="row form-horizontal">
                                <div class="table-responsive" style="padding: 10px 25px 10px 10px">
                                    <table class="table dataTable table-striped table-bordered" id="poTbl" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-left">CODE</th>
                                            <th class="text-left">ITEM NAME</th>
                                            <th class="text-left">SCALE</th>
                                            <th class="text-left">QTY</th>
                                            <th class="text-left">UNIT PRICE</th>
                                            <th class="text-left">TOTAL</th>
                                            <th class="text-left">OPTION</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                        <th colspan="3"></th>
                                        <th id="ttlQt">00</th>
                                        <th></th>
                                        <th id="ttlSub">00.00</th>
                                        <th></th>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="row form-horizontal">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-5 col-xs-12 control-label">Remarks / Interdiction</label>
                                        <div class="col-md-7 col-xs-12">
                                            <div class="form-group">
                                                         <textarea class="form-control" name="remk" id="remk"
                                                                   rows="8" placeholder="Description"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-6 col-xs-12 control-label">Sub Total</label>
                                        <div class="col-md-4 col-xs-12">
                                            <div class="form-group">
                                                <input type="text" class="form-control text-right"
                                                       name="sbttl" placeholder="Sub Total" id="sbttl"
                                                       readonly/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3  control-label">VAT</label>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" class="form-control text-right"
                                                       name="vtrt" placeholder="VAT Rate" id="vtrt"
                                                       onchange="calVt(this.value)"
                                                       onkeyup="calVt(this.value)"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4 ">
                                            <div class="form-group">
                                                <input type="text" class="form-control text-right"
                                                       name="vtvl" placeholder="VAT Value" id="vtvl" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3  control-label">NBT</label>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" class="form-control text-right"
                                                       name="nbrt" placeholder="NBT Rate" id="nbrt"
                                                       onchange="calNb(this.value)"
                                                       onkeyup="calNb(this.value)"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4 ">
                                            <div class="form-group">
                                                <input type="text" class="form-control text-right"
                                                       name="nbvl" placeholder="NBT Value" id="nbvl" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3  control-label">BTT</label>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" class="form-control text-right"
                                                       name="btrt" placeholder="BTT Rate" id="btrt"
                                                       onchange="calBt(this.value)"
                                                       onkeyup="calBt(this.value)"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4 ">
                                            <div class="form-group">
                                                <input type="text" class="form-control text-right"
                                                       name="btvl" placeholder="BTT Value" id="btvl" readonly/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3  control-label">Other Tax</label>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" class="form-control text-right"
                                                       name="txrt" placeholder="Tax Rate" id="txrt"
                                                       onchange="calTx(this.value)"
                                                       onkeyup="calTx(this.value)"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4 ">
                                            <div class="form-group">
                                                <input type="text" class="form-control text-right"
                                                       name="tax" placeholder="Tax Value" id="tax" readonly/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-6  control-label">Other Charge</label>
                                        <div class="col-md-4 ">
                                            <div class="form-group">
                                                <input type="text" class="form-control text-right"
                                                       name="otchg" placeholder="Other Charge" id="otchg"
                                                       onchange="calTtl()"
                                                       onkeyup="calTtl()"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-6  control-label">Total</label>
                                        <div class="col-md-4 ">
                                            <div class="form-group">
                                                <input type="text" class="form-control text-right"
                                                       name="ttlAmt" placeholder="Total" id="ttlAmt" readonly/>
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
                        <button type="button" id="add_po_btn" class="btn btn-warning btn-sm btn-rounded" disabled>Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END ADD NEW PO -->

    <!-- MODAL EDIT PO -->
    <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="modal-default-header">
        <div class="modal-dialog modal-lg" role="document" style="width: 80%;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"
                                                                                              class="icon-cross"></span>
            </button>
            <form id="app_po_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> Purchase
                            Order
                            Management <span class="text-muted" id="subTitle_edit"></span></h4>
                        <input type="hidden" id="func" name="func"/>
                        <input type="hidden" id="poid" name="poid"/>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row form-horizontal">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Supplier Name <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-6 col-xs-12">
                                            <select class="bs-select" id="supp_edt" name="supp_edt"
                                                    onchange="chckBtn(this.value,this.id)">
                                                <option value="0">-- Select Supplier --</option>
                                                <?php
                                                foreach ($supplier as $sup) {
                                                    echo "<option value='$sup->spid'>" . $sup->spcd . " - " . $sup->spnm . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Order Date <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="input-group date">
                                                <input type="text" class="form-control datetimepicker" id="oddt_edt"
                                                       name="oddt_edt" value="<?= date('Y-m-d') ?>"
                                                       style="cursor: pointer;">
                                                <span class="input-group-addon">
                                                    <span class="fa fa-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Reference Details <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-6 col-xs-12">
                                            <input type="text" name="refd_edt" id="refd_edt"
                                                   class="form-control text-uppercase"
                                                   placeholder="Reference Number"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Delivery To <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-6 col-xs-12">
                                            <select class="bs-select" id="whs_edt" name="whs_edt"
                                                    onchange="chckBtn(this.value,this.id)">
                                                <option value="0">-- Select Warehouse --</option>
                                                <?php
                                                foreach ($warehouse as $wh) {
                                                    echo "<option value='$wh->whid'>" . $wh->whcd . " - " . $wh->whnm . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-horizontal">
                                <h5 class="text-title"><span class="fa fa-tag"></span> Order Details</h5>
                            </div>
                            <div class="row form-horizontal">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Item Name</label>
                                        <div class="col-md-8 col-xs-12">
                                            <select class="bs-select" data-live-search="true" id="item_edt"
                                                    name="item_edt"
                                                    onchange="chckBtn(this.value,this.id); getScale(this.value); setDataContent('cnty_edt',this.value,'item_pulse_edt');">
                                                <option value="0">-- Select Item --</option>
                                                <script>
                                                    scale = new Array();
                                                </script>
                                                <?php
                                                foreach ($item as $itm) {
                                                    echo "<option value='$itm->itid'>" . $itm->itcd . " - " . $itm->itnm . "</option>";
                                                    ?>
                                                    <script>
                                                        scale.push([<?= $itm->itid?>, '<?= $itm->scnm . " (" . $itm->scl . ")"?>', <?= $itm->slid?>, '<?= $itm->itcd?>', '<?= $itm->itnm?>']);
                                                    </script>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label"
                                               id="stScale_edt">Quantity</label>
                                        <div class="col-md-8 col-xs-12">
                                            <div class="app-spinner pulse pulse-primary col-md-push-6 col-xs-push-6"
                                                 id="item_pulse_edt" style="display: none;"></div>
                                            <input type="text" id="cnty_edt" name="cnty_edt" class="form-control"
                                                   placeholder="Quantity"
                                                   data-container="body" data-toggle="popover" data-placement="top"
                                                   data-html="true"
                                                   data-trigger="focus"
                                                   data-content="No Data"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-md-4 col-xs-12 control-label" id="stScale">Unit Price</label>
                                    <div class="col-md-6 col-xs-10">
                                        <input type="text" id="price_edt" name="price_edt" class="form-control"
                                               placeholder="Price 00.00"/>
                                    </div>
                                    <div class="col-md-2 col-xs-2">
                                        <button type="button" class="btn btn-sm btn-info" style="margin: 0px"
                                                onclick="addItem_edt()"><span
                                                    class="fa fa-plus"></span></button>
                                    </div>
                                    <input type="hidden" id="leng_edt" name="leng_edt">
                                </div>
                            </div>
                            <div class="row form-horizontal">
                                <div class="table-responsive" style="padding: 10px 25px 10px 10px">
                                    <table class="table dataTable table-striped table-bordered" id="poTbl_edt"
                                           width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-left">CODE</th>
                                            <th class="text-left">ITEM NAME</th>
                                            <th class="text-left">SCALE</th>
                                            <th class="text-left">QTY</th>
                                            <th class="text-left">UNIT PRICE</th>
                                            <th class="text-left">TOTAL</th>
                                            <th class="text-left">OPTION</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                        <th colspan="3"></th>
                                        <th id="ttlQt_edt">00</th>
                                        <th></th>
                                        <th id="ttlSub_edt">00.00</th>
                                        <th></th>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="row form-horizontal">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-5 col-xs-12 control-label">Remarks / Interdiction</label>
                                        <div class="col-md-7 col-xs-12">
                                            <div class="form-group">
                                                         <textarea class="form-control" name="remk_edt" id="remk_edt"
                                                                   rows="8" placeholder="Description"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-6 col-xs-12 control-label">Sub Total</label>
                                        <div class="col-md-4 col-xs-12">
                                            <div class="form-group">
                                                <input type="text" class="form-control text-right"
                                                       name="sbttl_edt" placeholder="Sub Total" id="sbttl_edt"
                                                       readonly/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3  control-label">VAT</label>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" class="form-control text-right"
                                                       name="vtrt_edt" placeholder="VAT Rate" id="vtrt_edt"
                                                       onchange="calVtEdt(this.value)"
                                                       onkeyup="calVtEdt(this.value)"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4 ">
                                            <div class="form-group">
                                                <input type="text" class="form-control text-right"
                                                       name="vtvl_edt" placeholder="VAT Value" id="vtvl_edt" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3  control-label">NBT</label>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" class="form-control text-right"
                                                       name="nbrt_edt" placeholder="NBT Rate" id="nbrt_edt"
                                                       onchange="calNbEdt(this.value)"
                                                       onkeyup="calNbEdt(this.value)"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4 ">
                                            <div class="form-group">
                                                <input type="text" class="form-control text-right"
                                                       name="nbvl_edt" placeholder="NBT Value" id="nbvl_edt" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3  control-label">BTT</label>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" class="form-control text-right"
                                                       name="btrt_edt" placeholder="BTT Rate" id="btrt_edt"
                                                       onchange="calBtEdt(this.value)"
                                                       onkeyup="calBtEdt(this.value)"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4 ">
                                            <div class="form-group">
                                                <input type="text" class="form-control text-right"
                                                       name="btvl_edt" placeholder="BTT Value" id="btvl_edt" readonly/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3  control-label">Other Tax</label>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" class="form-control text-right"
                                                       name="txrt_edt" placeholder="Tax Rate" id="txrt_edt"
                                                       onchange="calTxEdt(this.value)"
                                                       onkeyup="calTxEdt(this.value)"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4 ">
                                            <div class="form-group">
                                                <input type="text" class="form-control text-right"
                                                       name="tax_edt" placeholder="Tax Value" id="tax_edt" readonly/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-6  control-label">Other Charge</label>
                                        <div class="col-md-4 ">
                                            <div class="form-group">
                                                <input type="text" class="form-control text-right"
                                                       name="otchg_edt" placeholder="Other Charge" id="otchg_edt"
                                                       onchange="calTtlEdt()"
                                                       onkeyup="calTtlEdt()"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-6  control-label">Total</label>
                                        <div class="col-md-4 ">
                                            <div class="form-group">
                                                <input type="text" class="form-control text-right"
                                                       name="ttlAmt_edt" placeholder="Total" id="ttlAmt_edt" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                        <button type="button" id="app_po_btn" class="btn btn-warning btn-sm btn-rounded">
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END EDIT PO -->

    <!-- MODAL VIEW PO -->
    <div class="modal fade" id="modal-view" tabindex="-1" role="dialog" aria-labelledby="modal-default-header">
        <div class="modal-dialog modal-lg" role="document" style="width: 80%;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"
                                                                                              class="icon-cross"></span>
            </button>
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> Purchase Order
                        Management <span class="text-muted"> - View</span></h4>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row form-horizontal">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Supplier Name : </label>
                                    <label class="col-md-6 col-xs-12 control-label" id="supp_vw"></label>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Order Date : </label>
                                    <label class="col-md-6 col-xs-12 control-label" id="oddt_vw"></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Reference Details : </label>
                                    <label class="col-md-6 col-xs-12 control-label" id="refd_vw"></label>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Delivery To : </label>
                                    <div class="col-md-6 col-xs-12 control-label" id="whs_vw"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-horizontal">
                            <h5 class="text-title"><span class="fa fa-tag"></span> Order Details</h5>
                        </div>
                        <div class="row form-horizontal">
                            <div class="table-responsive" style="padding: 10px 25px 10px 10px">
                                <table class="table dataTable table-striped table-bordered" id="poTbl_vw" width="100%">
                                    <thead>
                                    <tr>
                                        <th class="text-left">CODE</th>
                                        <th class="text-left">ITEM NAME</th>
                                        <th class="text-left">SCALE</th>
                                        <th class="text-left">QTY</th>
                                        <th class="text-left">UNIT PRICE</th>
                                        <th class="text-left">TOTAL</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <th colspan="3"></th>
                                    <th id="ttlQt_vw">00</th>
                                    <th></th>
                                    <th id="ttlSub_vw">00.00</th>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="row form-horizontal">
                            <div class="col-md-7">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-md-5 col-xs-12 control-label">Remarks / Interdiction : </label>
                                        <div class="col-md-7 col-xs-12">
                                            <p id="remk_vw"></p>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Status</label>
                                        <label class="col-md-8 col-xs-12 control-label" id="po_stat"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Created By</label>
                                        <label class="col-md-8 control-label" id="crby"></label>
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
                                        <label class="col-md-4 col-xs-12 control-label">Updated By</label>
                                        <label class="col-md-8 col-xs-12 control-label" id="mdby"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Updated Date</label>
                                        <label class="col-md-8 col-xs-12 control-label" id="mddt"></label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Printed Count</label>
                                        <label class="col-md-8 col-xs-12 control-label" id="prcnt"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Printed By</label>
                                        <label class="col-md-8 col-xs-12 control-label" id="prby"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Printed Date</label>
                                        <label class="col-md-8 col-xs-12 control-label" id="prdt"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Re-Printed By</label>
                                        <label class="col-md-8 col-xs-12 control-label" id="rpby"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Re-Printed Date</label>
                                        <label class="col-md-8 col-xs-12 control-label" id="rpdt"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-6 col-xs-6 control-label tx-align">Sub Total : </label>
                                    <label class="col-md-6 col-xs-6 control-label tx-align" id="sbttl_vw"></label>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-6 col-xs-6 control-label tx-align">VAT (<span style="color: #e79500;" id="vtrt_vw"></span>) : </label>
                                    <label class="col-md-6 col-xs-6 control-label tx-align" id="vtvl_vw"></label>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-6 col-xs-6 control-label tx-align">NBT (<span style="color: #e79500;" id="nbrt_vw"></span>) : </label>
                                    <label class="col-md-6 col-xs-6 control-label tx-align" id="nbvl_vw"></label>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-6 col-xs-6 control-label tx-align">BTT (<span style="color: #e79500;" id="btrt_vw"></span>) : </label>
                                    <label class="col-md-6 col-xs-6 control-label tx-align" id="btvl_vw"></label>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-6 col-xs-6 control-label tx-align">Other Tax (<span style="color: #e79500;" id="txrt_vw"></span>) : </label>
                                    <label class="col-md-6 col-xs-6 control-label tx-align" id="tax_vw"></label>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-6 col-xs-6 control-label tx-align">Other Charge : </label>
                                    <label class="col-md-6 col-xs-6 control-label tx-align" id="otchg_vw"></label>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-6 col-xs-6 control-label tx-align">Total : </label>
                                    <label class="col-md-6 col-xs-6 control-label tx-align" id="ttlAmt_vw"></label>
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
    </div>
    <!-- END VIEW BRAND -->

    <script type="text/javascript">
        var mainVal, subVal, mainValEdt, subValEdt;
        $().ready(function () {
            //Table Initializing
            $('#pom_table').DataTable({
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                "aoColumns": [
                    {sWidth: '3%'},
                    {sWidth: '10%'},
                    {sWidth: '20%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '8%'},
                    {sWidth: '12%'}
                ],
            });

            $('#poTbl').DataTable({
                searching: false,
                bPaginate: false,
                "ordering": false,
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                "aoColumns": [
                    {sWidth: '5%'},
                    {sWidth: '20%'},
                    {sWidth: '10%'},
                    {sWidth: '5%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '5%'}
                ],
            });

            mainVal = $('#add_po_form').validate({
                rules: {
                    supp: {
                        notEqual: 0,
                    },
                    oddt: {
                        required: true,
                    },
                    refd: {
                        required: true,
                    },
                    whs: {
                        notEqual: 0
                    },
                    item: {
                        notEqual: 0
                    },
                    cnty: {
                        required: true,
                        notEqual: 0,
                        currency: true,
                        remote: {
                            url: "<?= base_url(); ?>Stock/chk_Mx_ItmLvl",
                            type: "post",
                            data: {
                                item: function () {
                                    return $("#item").val();
                                },
                                qnty: function () {
                                    return $("#cnty").val();
                                },
                            }
                        }
                    },
                    price: {
                        required: true,
                        currency: true
                    },
                    vtrt: {
                        currency: true
                    },
                    nbrt: {
                        currency: true
                    },
                    btrt: {
                        currency: true
                    },
                    txrt: {
                        currency: true
                    },
                    otchg: {
                        currency: true
                    },
                    ttlAmt: {
                        required: true,
                        notEqual: 0,
                        currency: true
                    },
                },
                messages: {
                    supp: {
                        notEqual: "Select a supplier",
                    },
                    oddt: {
                        required: "Enter order date",
                    },
                    refd: {
                        required: "Enter reference code",
                    },
                    whs: {
                        notEqual: "Select a warehouse"
                    },
                    item: {
                        notEqual: "Select an item"
                    },
                    cnty: {
                        required: "Enter quantity",
                        notEqual: "Can't enter zero",
                        currency: "Enter valid quantity"
                    },
                    price: {
                        required: "Enter unit price",
                    },
                    ttlAmt: {
                        notEqual: "Can't enter zero",
                    }
                }
            });

            subVal = $('#add_po_form').validate({
                rules: {
                    item: {
                        notEqual: 0
                    },
                    cnty: {
                        required: true,
                        notEqual: 0,
                        currency: true,
                        remote: {
                            url: "<?= base_url(); ?>Stock/chk_Mx_ItmLvl",
                            type: "post",
                            data: {
                                item: function () {
                                    return $("#item").val();
                                },
                                qnty: function () {
                                    return $("#cnty").val();
                                },
                            }
                        }
                    },
                    price: {
                        required: true,
                        currency: true
                    }
                },
                messages: {
                    item: {
                        notEqual: "Select an item"
                    },
                    cnty: {
                        required: "Enter quantity",
                        notEqual: "Can't enter zero",
                        currency: "Enter valid quantity"
                    },
                    price: {
                        required: "Enter unit price",
                    }
                }
            });

            mainValEdt = $('#app_po_form').validate({
                rules: {
                    supp_edt: {
                        notEqual: 0,
                    },
                    oddt_edt: {
                        required: true,
                    },
                    refd_edt: {
                        required: true,
                    },
                    whs_edt: {
                        notEqual: 0
                    },
                    item_edt: {
                        notEqual: 0
                    },
                    cnty_edt: {
                        required: true,
                        notEqual: 0,
                        currency: true,
                        remote: {
                            url: "<?= base_url(); ?>Stock/chk_Mx_ItmLvl",
                            type: "post",
                            data: {
                                item: function () {
                                    return $("#item_edt").val();
                                },
                                qnty: function () {
                                    return $("#cnty_edt").val();
                                },
                            }
                        }
                    },
                    price_edt: {
                        required: true,
                        currency: true
                    },
                    vtrt_edt: {
                        currency: true
                    },
                    nbrt_edt: {
                        currency: true
                    },
                    btrt_edt: {
                        currency: true
                    },
                    txrt_edt: {
                        currency: true
                    },
                    otchg_edt: {
                        currency: true
                    },
                    ttlAmt_edt: {
                        required: true,
                        notEqual: 0,
                        currency: true
                    },
                },
                messages: {
                    supp_edt: {
                        notEqual: "Select a supplier",
                    },
                    oddt_edt: {
                        required: "Enter order date",
                    },
                    refd_edt: {
                        required: "Enter reference code",
                    },
                    whs_edt: {
                        notEqual: "Select a warehouse"
                    },
                    item_edt: {
                        notEqual: "Select an item"
                    },
                    cnty_edt: {
                        required: "Enter quantity",
                        notEqual: "Can't enter zero",
                        currency: "Enter valid quantity"
                    },
                    price_edt: {
                        required: "Enter unit price",
                    },
                    ttlAmt_edt: {
                        notEqual: "Can't enter zero",
                    }
                }
            });

            subValEdt = $('#app_po_form').validate({
                rules: {
                    item_edt: {
                        notEqual: 0
                    },
                    cnty_edt: {
                        required: true,
                        notEqual: 0,
                        currency: true,
                        remote: {
                            url: "<?= base_url(); ?>Stock/chk_Mx_ItmLvl",
                            type: "post",
                            data: {
                                item: function () {
                                    return $("#item_edt").val();
                                },
                                qnty: function () {
                                    return $("#cnty_edt").val();
                                },
                            }
                        }
                    },
                    price_edt: {
                        required: true,
                        currency: true
                    }
                },
                messages: {
                    item_edt: {
                        notEqual: "Select an item"
                    },
                    cnty_edt: {
                        required: "Enter quantity",
                        notEqual: "Can't enter zero",
                        currency: "Enter valid quantity"
                    },
                    price_edt: {
                        required: "Enter unit price",
                    }
                }
            });

            srch_Po();
        });

        //Get Scale
        function getScale(id) {
            for (var it = 0; it < scale.length; it++) {
                if (scale[it][0] == id) {
                    $('#stScale').html(scale[it][1]);
                    $('#stScale_edt').html(scale[it][1]);
                    return scale[it][1];
                }
            }
            $('#stScale').html('Quantity');
            $('#stScale_edt').html('Quantity');
        }

        function addItem() {
            mainVal.resetForm();
            var valid = true;
            $('#item,#cnty,#price').each(function (i, v) {
                valid = subVal.element(v) && valid;
            });

            if (valid) {
                var leng = $('#leng').val();

                var lengN = +leng + +1;
                $('#leng').val(lengN);

                var t = $('#poTbl').DataTable({
                    destroy: true,
                    searching: false,
                    bPaginate: false,
                    "ordering": false,
                    "columnDefs": [
                        {className: "text-left", "targets": [1, 2]},
                        {className: "text-center", "targets": [0, 6]},
                        {className: "text-right", "targets": [3, 4, 5]},
                        {className: "text-nowrap", "targets": [1]}
                    ],
                    "aoColumns": [
                        {sWidth: '5%'}, //Code
                        {sWidth: '20%'}, //Name
                        {sWidth: '10%'}, //Scale
                        {sWidth: '5%'},  //qty
                        {sWidth: '10%'}, //Unit Price
                        {sWidth: '10%'}, //Total
                        {sWidth: '5%'}  //Option
                    ],
                    "rowCallback": function (row, data, index) {

                    },
                });

                var itid = $('#item').val();
                var qty = $('#cnty').val();
                var untp = $('#price').val();
                var itcd = "";
                var itnm = "";
                var scl = "";
                var slid = 0;

                for (var it = 0; it < scale.length; it++) {
                    if (scale[it][0] == itid) {
                        itcd = scale[it][3];
                        itnm = scale[it][4];
                        scl = scale[it][1];
                        slid = scale[it][2];
                        break;
                    }
                }
                t.row.add([
                    itcd + '<input type="hidden" name="itid[]" value="' + itid + ' ">',     // ITEM CODE
                    itnm,
                    scl, //Scale
                    numeral(qty).format('0,0') + '<input type="hidden" name="qunty[]" value="' + qty + ' ">',         // QUNT
                    numeral(untp).format('0,0.00') + '<input type="hidden" name="unitpr[]" value="' + untp + ' ">',     // UNIT PRICE
                    numeral((+qty * +untp)).format('0,0.00') + '<input type="hidden" name="unttl[]" value="' + (+qty * +untp) + ' ">',
                    '<button type="button" class="btn btn-xs btn-warning" id="dltrw" onclick=""><span><i class="fa fa-close" title="Remove"></i></span></button>'
                ]).draw(false);

                var ttlQt = 0;
                var ttlSub = 0;
                $(" input[name='qunty[]']").each(function () {
                    ttlQt = ttlQt + +this.value;
                });
                $(" input[name='unttl[]']").each(function () {
                    ttlSub = ttlSub + +this.value;
                });

                document.getElementById('ttlQt').innerHTML = ttlQt;
                document.getElementById('ttlSub').innerHTML = numeral(ttlSub).format('0,0.00');
                document.getElementById('sbttl').value = ttlSub;

                calVt($('#vtrt').val());
                calNb($('#nbrt').val());
                calBt($('#btrt').val());
                calTx($('#txrt').val());

                default_Selector($('#item').prev());
                $('#cnty').val('');
                $('#price').val('');
            }
        }

        // TABLE DATA REMOVE
        $('#poTbl tbody').on('click', '#dltrw', function () {
            var table = $('#poTbl').DataTable();

            table
                .row($(this).parents('tr'))
                .remove()
                .draw();

            var leng = document.getElementById('leng').value;
            document.getElementById('leng').value = +leng - +1;

            var ttlQt = 0;
            var ttlSub = 0;
            $(" input[name='qunty[]']").each(function () {
                ttlQt = ttlQt + +this.value;
            });
            $(" input[name='unttl[]']").each(function () {
                ttlSub = ttlSub + +this.value;
            });

            document.getElementById('ttlQt').innerHTML = ttlQt;
            document.getElementById('ttlSub').innerHTML = numeral(ttlSub).format('0,0.00');
            document.getElementById('sbttl').value = ttlSub;

            calVt($('#vtrt').val());
            calNb($('#nbrt').val());
            calBt($('#btrt').val());
            calTx($('#txrt').val());
        });

        // CAL VAT VALUE
        function calVt(txrt) {
            var sbttl = document.getElementById('sbttl').value;
            var txvl = (+sbttl * +txrt) / 100;
            document.getElementById('vtvl').value = txvl;
            calTtl();
        }

        // CAL NBT VALUE
        function calNb(txrt) {
            var sbttl = document.getElementById('sbttl').value;
            var txvl = (+sbttl * +txrt) / 100;
            document.getElementById('nbvl').value = txvl;
            calTtl();
        }

        // CAL BTT VALUE
        function calBt(txrt) {
            var sbttl = document.getElementById('sbttl').value;
            var txvl = (+sbttl * +txrt) / 100;
            document.getElementById('btvl').value = txvl;
            calTtl();
        }

        // CAL TAX VALUE
        function calTx(txrt) {
            var sbttl = document.getElementById('sbttl').value;
            var txvl = (+sbttl * +txrt) / 100;
            document.getElementById('tax').value = txvl;
            calTtl();
        }

        // CAL TOTAL
        function calTtl() {
            var sbttl = document.getElementById('sbttl').value;
            var otchg = document.getElementById('otchg').value;
            //var dsvl = document.getElementById('dsvl').value;

            var tax = document.getElementById('tax').value;
            var vtvl = document.getElementById('vtvl').value;
            var nbvl = document.getElementById('nbvl').value;
            var btvl = document.getElementById('btvl').value;

            document.getElementById('ttlAmt').value = numeral((+sbttl + +tax + +otchg + +vtvl + +nbvl + +btvl)).format('0.00');
            if (document.getElementById('leng').value > 0) {
                $('#add_po_btn').attr('disabled', false);
            } else {
                $('#add_po_btn').attr('disabled', true);
            }
        }

        // CAL VAT VALUE
        function calVtEdt(txrt) {
            var sbttl = document.getElementById('sbttl_edt').value;
            var txvl = (+sbttl * +txrt) / 100;
            document.getElementById('vtvl_edt').value = txvl;
            calTtlEdt();
        }

        // CAL NBT VALUE
        function calNbEdt(txrt) {
            var sbttl = document.getElementById('sbttl_edt').value;
            var txvl = (+sbttl * +txrt) / 100;
            document.getElementById('nbvl_edt').value = txvl;
            calTtlEdt();
        }

        // CAL BTT VALUE
        function calBtEdt(txrt) {
            var sbttl = document.getElementById('sbttl_edt').value;
            var txvl = (+sbttl * +txrt) / 100;
            document.getElementById('btvl_edt').value = txvl;
            calTtlEdt();
        }

        // CAL TAX VALUE
        function calTxEdt(txrt) {
            var sbttl = document.getElementById('sbttl_edt').value;
            var txvl = (+sbttl * +txrt) / 100;
            document.getElementById('tax_edt').value = txvl;

            calTtlEdt();
        }

        // CAL TOTAL
        function calTtlEdt() {
            var sbttl = document.getElementById('sbttl_edt').value;
            var otchg = document.getElementById('otchg_edt').value;
            //var dsvl = document.getElementById('dsvlEdt').value;

            var tax = document.getElementById('tax_edt').value;
            var vtvl = document.getElementById('vtvl_edt').value;
            var nbvl = document.getElementById('nbvl_edt').value;
            var btvl = document.getElementById('btvl_edt').value;

            document.getElementById('ttlAmt_edt').value = (+sbttl + +tax + +otchg + +vtvl + +nbvl + +btvl);

            if (document.getElementById('leng_edt').value > 0) {
                $('#app_po_btn').attr('disabled', false);
            } else {
                $('#app_po_btn').attr('disabled', true);
            }
        }

        //Add New PO
        $('#add_po_btn').click(function (e) {
            e.preventDefault();
            subVal.resetForm();
            var valid = true;
            $('#supp,#oddt,#refd,#whs,#vtrt,#nbrt,#btrt,#txrt,#otchg,#ttlAmt').each(function (i, v) {
                valid = mainVal.element(v) && valid;
            });

            if (valid) {
                $('#add_po_btn').prop('disabled', true);
                swal({
                    title: "Processing...",
                    text: "Purchase Order data saving..",
                    imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                    showConfirmButton: false
                });

                jQuery.ajax({
                    type: "POST",
                    url: "<?= base_url(); ?>Stock/po_Add",
                    data: $("#add_po_form").serialize(),
                    dataType: 'json',
                    success: function (data) {
                        swal({title: "", text: "Purchase Order Added!", type: "success"},
                            function () {
                                $('#add_po_btn').prop('disabled', true);
                                clear_Form('add_po_form');
                                $('#modal-add').modal('hide');
                                $('#poTbl').DataTable().clear().draw();
                                $('#ttlQt').html('00');
                                $('#ttlSub').html('00.00');
                                srch_Po();
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

        //Search Brand
        function srch_Po() {
            var stat = $('#stat').val();
            var supp = $('#supps').val();
            var dtrg = $('#dtrng').val();

            $('#pom_table').DataTable().clear();
            $('#pom_table').DataTable({
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
                    {className: "text-left", "targets": [2]},
                    {className: "text-center", "targets": [0, 1, 3, 5, 6, 7]},
                    {className: "text-right", "targets": [4]},
                    {className: "text-nowrap", "targets": [2]},
                ],
                "order": [[5, "DESC"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '3%'}, //No
                    {sWidth: '10%'},    //PONO
                    {sWidth: '20%'},    //SUPP
                    {sWidth: '8%'},    //Order Date
                    {sWidth: '8%'},    //VALUE
                    {sWidth: '10%'},    //Created Date
                    {sWidth: '10%'},     //Status
                    {sWidth: '12%'}     //OPT
                ],

                "ajax": {
                    url: '<?= base_url(); ?>Stock/searchPo',
                    type: 'post',
                    data: {
                        stat: stat,
                        supp: supp,
                        dtrg: dtrg
                    }
                }
            });
        }

        //View Type
        function editPo(id, func) {
            swal({
                title: "Loading Data...",
                text: "PO Details",
                imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                showConfirmButton: false
            });

            $('#func').val(func);
            $('#poid').val(id);

            jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>Stock/get_PoDet",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (data) {
                    if (func == 'edit') {
                        //EDIT MODEL
                        $('#subTitle_edit').html(' - Edit');
                        $('#app_po_btn').html('Update');
                        //EDIT MODEL
                    } else if (func == 'app') {
                        //APPROVE MODEL
                        $('#subTitle_edit').html(' - Approve');
                        $('#app_po_btn').html('Approve');
                        //APPROVE MODEL
                    }
                    var len = data['po'].length;

                    if (len > 0) {
                        var po = data['po'];
                        set_select('supp_edt', po[0]['spid']);
                        set_select('whs_edt', po[0]['whid']);
                        $('#refd_edt').val(po[0]['rfno']);
                        $('#oddt_edt').val(po[0]['oddt']);
                        $('#remk_edt').val(po[0]['remk']);
                        $('#sbttl_edt').val(po[0]['sbtl']);
                        $('#vtrt_edt').val(po[0]['vtrt']);
                        $('#vtvl_edt').val(po[0]['vtvl']);
                        $('#nbrt_edt').val(po[0]['nbrt']);
                        $('#nbvl_edt').val(po[0]['nbvl']);
                        $('#btrt_edt').val(po[0]['btrt']);
                        $('#btvl_edt').val(po[0]['btvl']);
                        $('#txrt_edt').val(po[0]['txrt']);
                        $('#tax_edt').val(po[0]['txvl']);
                        $('#otchg_edt').val(po[0]['ochg']);
                        $('#ttlAmt_edt').val(po[0]['totl']);
                    }

                    var len2 = data['pod'].length;
                    $('#leng_edt').val(len2);
                    $('#poTbl_edt').DataTable().clear().draw();
                    var t = $('#poTbl_edt').DataTable({
                        destroy: true,
                        searching: false,
                        bPaginate: false,
                        "ordering": false,
                        "columnDefs": [
                            {className: "text-left", "targets": [1, 2]},
                            {className: "text-center", "targets": [0, 6]},
                            {className: "text-right", "targets": [3, 4, 5]},
                            {className: "text-nowrap", "targets": [1]}
                        ],
                        "aoColumns": [
                            {sWidth: '5%'}, //Code
                            {sWidth: '20%'}, //Name
                            {sWidth: '10%'}, //Scale
                            {sWidth: '5%'},  //qty
                            {sWidth: '10%'}, //Unit Price
                            {sWidth: '10%'}, //Total
                            {sWidth: '5%'}  //Option
                        ],
                        "rowCallback": function (row, data, index) {

                        },
                    });

                    var pod = data['pod'];
                    for (var it = 0; it < len2; it++) {
                        var itid = pod[it]['itid'];
                        var itcd = pod[it]['itcd'];
                        var itnm = pod[it]['itnm'];
                        var scl = pod[it]['scnm'] + " (" + pod[it]['scl'] + ")";
                        var qty = pod[it]['qnty'];
                        var untp = pod[it]['untp'];

                        t.row.add([
                            itcd + '<input type="hidden" name="itid_edt[]" value="' + itid + ' "><input type="hidden" name="pdid[]" value="' + pod[it]['pdid'] + ' ">',     // ITEM CODE
                            itnm,
                            scl, //Scale
                            numeral(qty).format('0,0') + '<input type="hidden" name="qunty_edt[]" value="' + qty + ' ">',         // QUNT
                            numeral(untp).format('0,0.00') + '<input type="hidden" name="unitpr_edt[]" value="' + untp + ' ">',     // UNIT PRICE
                            numeral((+qty * +untp)).format('0,0.00') + '<input type="hidden" name="unttl_edt[]" value="' + (+qty * +untp) + ' ">',
                            '<button type="button" class="btn btn-xs btn-warning" id="dltrw_edt" onclick=""><span><i class="fa fa-close" title="Remove"></i></span></button>'
                        ]).draw(false);
                    }

                    var ttlQt = 0;
                    var ttlSub = 0;
                    $(" input[name='qunty_edt[]']").each(function () {
                        ttlQt = ttlQt + +this.value;
                    });
                    $(" input[name='unttl_edt[]']").each(function () {
                        ttlSub = ttlSub + +this.value;
                    });

                    document.getElementById('ttlQt_edt').innerHTML = ttlQt;
                    document.getElementById('ttlSub_edt').innerHTML = numeral(ttlSub).format('0,0.00');
                    document.getElementById('sbttl_edt').value = ttlSub;

                    calTtlEdt();
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

        //Add Item In Edit
        function addItem_edt() {
            mainValEdt.resetForm();
            var valid = true;
            $('#item_edt,#cnty_edt,#price_edt').each(function (i, v) {
                valid = subValEdt.element(v) && valid;
            });

            if (valid) {
                var leng = $('#leng_edt').val();

                var lengN = +leng + +1;
                $('#leng_edt').val(lengN);

                var t = $('#poTbl_edt').DataTable({
                    destroy: true,
                    searching: false,
                    bPaginate: false,
                    "ordering": false,
                    "columnDefs": [
                        {className: "text-left", "targets": [1, 2]},
                        {className: "text-center", "targets": [0, 6]},
                        {className: "text-right", "targets": [3, 4, 5]},
                        {className: "text-nowrap", "targets": [1]}
                    ],
                    "aoColumns": [
                        {sWidth: '5%'}, //Code
                        {sWidth: '20%'}, //Name
                        {sWidth: '10%'}, //Scale
                        {sWidth: '5%'},  //qty
                        {sWidth: '10%'}, //Unit Price
                        {sWidth: '10%'}, //Total
                        {sWidth: '5%'}  //Option
                    ],
                    "rowCallback": function (row, data, index) {

                    },
                });

                var itid = $('#item_edt').val();
                var qty = $('#cnty_edt').val();
                var untp = $('#price_edt').val();
                var itcd = "";
                var itnm = "";
                var scl = "";
                var slid = 0;

                for (var it = 0; it < scale.length; it++) {
                    if (scale[it][0] == itid) {
                        itcd = scale[it][3];
                        itnm = scale[it][4];
                        scl = scale[it][1];
                        slid = scale[it][2];
                        break;
                    }
                }
                t.row.add([
                    itcd + '<input type="hidden" name="itid_edt[]" value="' + itid + ' "><input type="hidden" name="pdid[]" value="0">',     // ITEM CODE
                    itnm,
                    scl, //Scale
                    numeral(qty).format('0,0') + '<input type="hidden" name="qunty_edt[]" value="' + qty + ' ">',         // QUNT
                    numeral(untp).format('0,0.00') + '<input type="hidden" name="unitpr_edt[]" value="' + untp + ' ">',     // UNIT PRICE
                    numeral((+qty * +untp)).format('0,0.00') + '<input type="hidden" name="unttl_edt[]" value="' + (+qty * +untp) + ' ">',
                    '<button type="button" class="btn btn-xs btn-warning" id="dltrw_edt" onclick=""><span><i class="fa fa-close" title="Remove"></i></span></button>'
                ]).draw(false);

                var ttlQt = 0;
                var ttlSub = 0;
                $(" input[name='qunty_edt[]']").each(function () {
                    ttlQt = ttlQt + +this.value;
                });
                $(" input[name='unttl_edt[]']").each(function () {
                    ttlSub = ttlSub + +this.value;
                });

                document.getElementById('ttlQt_edt').innerHTML = ttlQt;
                document.getElementById('ttlSub_edt').innerHTML = numeral(ttlSub).format('0,0.00');
                document.getElementById('sbttl_edt').value = ttlSub;

                //calTtlEdt();
                calVtEdt($('#vtrt_edt').val());
                calNbEdt($('#nbrt_edt').val());
                calBtEdt($('#btrt_edt').val());
                calTxEdt($('#txrt_edt').val());

                default_Selector($('#item_edt').prev());
                $('#cnty_edt').val('');
                $('#price_edt').val('');
            }
        }

        // TABLE DATA REMOVE
        $('#poTbl_edt tbody').on('click', '#dltrw_edt', function () {
            var table = $('#poTbl_edt').DataTable();

            table
                .row($(this).parents('tr'))
                .remove()
                .draw();

            var leng = document.getElementById('leng_edt').value;
            document.getElementById('leng_edt').value = +leng - +1;

            var ttlQt = 0;
            var ttlSub = 0;
            $(" input[name='qunty_edt[]']").each(function () {
                ttlQt = ttlQt + +this.value;
            });
            $(" input[name='unttl_edt[]']").each(function () {
                ttlSub = ttlSub + +this.value;
            });

            document.getElementById('ttlQt_edt').innerHTML = ttlQt;
            document.getElementById('ttlSub_edt').innerHTML = numeral(ttlSub).format('0,0.00');
            document.getElementById('sbttl_edt').value = ttlSub;
            //calTtlEdt();
            calVtEdt($('#vtrt_edt').val());
            calNbEdt($('#nbrt_edt').val());
            calBtEdt($('#btrt_edt').val());
            calTxEdt($('#txrt_edt').val());
        });

        //Set Data-Content with item exist QTY status
        //html - data-content element
        //pulse - Pulse element
        //id - item id
        function setDataContent(html, id, pulse) {
            $('#' + pulse).css('display', 'block');

            if (id != 0) {
                jQuery.ajax({
                    type: "POST",
                    url: "<?= base_url(); ?>Stock/getItm_QtySt",
                    data: {
                        item: id
                    },
                    dataType: 'json',
                    success: function (data) {
                        $('#' + html).attr('data-content', "" +
                            "<h1 style='color: green; font-weight: bold'><span class='fa fa-astrick'></span> Item Quantity Details</h1><br><table>" +
                            "<tr><td><label class='control-label'>Pending PO : </label></td><td class='text-right'> <span style='color: dodgerblue'>" + data[0]['penpoqty'] + "</span></td></tr>" +
                            "<tr><td><label class='control-label'>PO To GRN : </label></td><td class='text-right'> <span style='color: dodgerblue'>" + data[0]['togrnqty'] + "</span></td></tr>" +
                            "<tr><td><label class='control-label'>Pending GRN : </label></td><td class='text-right'> <span style='color: dodgerblue'>" + data[0]['pengrnqty'] + "</span></td></tr>" +
                            "<tr><td><label class='control-label'>GRN To Stock: </label></td><td class='text-right'> <span style='color: dodgerblue'>" + data[0]['tostqty'] + "</span></td></tr>" +
                            "<tr><td><label class='control-label'>Pending Stock: </label></td><td class='text-right'> <span style='color: dodgerblue'>" + data[0]['penstqty'] + "</span></td></tr>" +
                            "<tr style='border-bottom: 2px solid green'><td><label class='control-label'>Available QTY : </label></td><td class='text-right'> <span style='color: dodgerblue'>" + data[0]['avstqty'] + "</span></td></tr>" +
                            "<tr><td class='text-center'><label class='control-label'>Total</label></td>" +
                            "<td class='text-right' style='color: red'>" + (+data[0]['penpoqty'] + +data[0]['togrnqty'] + +data[0]['pengrnqty'] + +data[0]['tostqty'] + +data[0]['penstqty'] + +data[0]['avstqty']) + "</td></tr>" +
                            "</table>"
                        );
                        $('#' + pulse).css('display', 'none');
                        $('#' + html).popover('show');
                    },
                    error: function (data, textStatus) {
                        $('#' + html).attr('data-content', 'Faild');
                        $('#' + pulse).css('display', 'none');
                        $('#' + html).popover('show');
                    }
                });
            } else {
                $('#' + html).attr('data-content', 'No Data');
                $('#' + pulse).css('display', 'none');
                $('#' + html).popover('show');
            }
        }

        //APPROVE || EDIT HERE
        $('#app_po_btn').click(function (e) {
            e.preventDefault();
            subValEdt.resetForm();
            var valid = true;
            $('#supp_edt,#oddt_edt,#refd_edt,#whs_edt,#vtrt_edt,#nbrt_edt,#btrt_edt,#txrt_edt,#otchg_edt,#ttlAmt_edt').each(function (i, v) {
                valid = mainValEdt.element(v) && valid;
            });
            if (valid) {
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
                            $('#app_po_btn').prop('disabled', true);
                            if (func == 'edit') {
                                swal({
                                    title: "Processing...",
                                    text: "Purchase order details updating..",
                                    imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                                    showConfirmButton: false
                                });

                                jQuery.ajax({
                                    type: "POST",
                                    url: "<?= base_url(); ?>Stock/po_update",
                                    data: $("#app_po_form").serialize(),
                                    dataType: 'json',
                                    success: function (data) {
                                        swal({title: "", text: "Updating Success!", type: "success"},
                                            function () {
                                                $('#app_po_btn').prop('disabled', true);
                                                clear_Form('app_po_form');
                                                $('#modal-edit').modal('hide');
                                                $('#poTbl_edt').DataTable().clear().draw();
                                                $('#ttlQt_edt').html('00');
                                                $('#ttlSub_edt').html('00.00');
                                                srch_Po();
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
                                    text: "Purchase order approving..",
                                    imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                                    showConfirmButton: false
                                });

                                jQuery.ajax({
                                    type: "POST",
                                    url: "<?= base_url(); ?>Stock/po_update",
                                    data: $("#app_po_form").serialize(),
                                    dataType: 'json',
                                    success: function (data) {
                                        swal({title: "", text: "Approved!", type: "success"},
                                            function () {
                                                $('#app_po_btn').prop('disabled', true);
                                                clear_Form('app_po_form');
                                                $('#modal-edit').modal('hide');
                                                $('#poTbl_edt').DataTable().clear().draw();
                                                $('#ttlQt_edt').html('00');
                                                $('#ttlSub_edt').html('00.00');
                                                srch_Po();
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

        //Reject Type
        function rejectPo(id) {
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
                            url: "<?= base_url(); ?>Stock/po_Reject",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (data) {
                                swal({title: "", text: "Purchase order was rejected!", type: "success"},
                                    function () {
                                        srch_Po();
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

        //VIEW PO
        function viewPo(id) {
            swal({
                title: "Loading Data...",
                text: "PO Details",
                imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                showConfirmButton: false
            });

            jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>Stock/get_PoDet",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (data) {
                    var len = data['po'].length;

                    if (len > 0) {
                        var po = data['po'];
                        $('#supp_vw').html(po[0]['spnm']);
                        $('#whs_vw').html(po[0]['whnm']);
                        $('#refd_vw').html(po[0]['rfno']);
                        $('#oddt_vw').html(po[0]['oddt']);
                        $('#remk_vw').html((po[0]['remk']=='')?'--':po[0]['remk']);
                        $('#sbttl_vw').html(numeral(po[0]['sbtl']).format('0,0.00'));
                        $('#vtrt_vw').html(po[0]['vtrt']+"%");
                        $('#vtvl_vw').html(numeral(po[0]['vtvl']).format('0,0.00'));
                        $('#nbrt_vw').html(po[0]['nbrt']+"%");
                        $('#nbvl_vw').html(numeral(po[0]['nbvl']).format('0,0.00'));
                        $('#btrt_vw').html(po[0]['btrt']+"%");
                        $('#btvl_vw').html(numeral(po[0]['btvl']).format('0,0.00'));
                        $('#txrt_vw').html(po[0]['txrt']+"%");
                        $('#tax_vw').html(numeral(po[0]['txvl']).format('0,0.00'));
                        $('#otchg_vw').html(numeral(po[0]['ochg']).format('0,0.00'));
                        $('#ttlAmt_vw').html(numeral(po[0]['totl']).format('0,0.00'));
                    }

                    var len2 = data['pod'].length;
                    $('#poTbl_vw').DataTable().clear().draw();
                    var t = $('#poTbl_vw').DataTable({
                        destroy: true,
                        searching: false,
                        bPaginate: false,
                        "ordering": false,
                        "columnDefs": [
                            {className: "text-left", "targets": [1, 2]},
                            {className: "text-center", "targets": [0]},
                            {className: "text-right", "targets": [3, 4, 5]},
                            {className: "text-nowrap", "targets": [1]}
                        ],
                        "aoColumns": [
                            {sWidth: '5%'}, //Code
                            {sWidth: '20%'}, //Name
                            {sWidth: '10%'}, //Scale
                            {sWidth: '5%'},  //qty
                            {sWidth: '10%'}, //Unit Price
                            {sWidth: '10%'}, //Total
                        ],
                        "rowCallback": function (row, data, index) {

                        },
                    });

                    var pod = data['pod'];

                    var ttlQt = 0;
                    var ttlSub = 0;
                    for (var it = 0; it < len2; it++) {
                        var itcd = pod[it]['itcd'];
                        var itnm = pod[it]['itnm'];
                        var scl = pod[it]['scnm'] + " (" + pod[it]['scl'] + ")";
                        var qty = pod[it]['qnty'];
                        var untp = pod[it]['untp'];

                        t.row.add([
                            itcd,     // ITEM CODE
                            itnm,
                            scl, //Scale
                            numeral(qty).format('0,0'),         // QUNT
                            numeral(untp).format('0,0.00'),     // UNIT PRICE
                            numeral((+qty * +untp)).format('0,0.00')
                        ]).draw(false);

                        ttlQt = ttlQt + +qty;
                        ttlSub = ttlSub + (+qty*+untp);
                    }

                    document.getElementById('ttlQt_vw').innerHTML = ttlQt;
                    document.getElementById('ttlSub_vw').innerHTML = numeral(ttlSub).format('0,0.00');
                    document.getElementById('sbttl_vw').value = ttlSub;

                    if(po[0]['grnst']==1){ //IS GRN ADDED
                        var grn = "<label class='label label-info label-bordered label-ghost' title='GRN / GRRN process done'>GRN</label>";
                    }else{
                        var grn = "";
                    }

                    if (po[0]['stat'] == 0) {
                        var stat = "<label class='label label-warning'>Pending</label>";
                    } else if (po[0]['stat'] == 1) {
                        var stat = "<label class='label label-success'>Active</label>";
                    } else if (po[0]['stat'] == 2) {
                        var stat = "<label class='label label-danger'>Reject</label>";
                    } else {
                        var stat = "--";
                    }
                    $('#po_stat').html(": " + stat+" "+grn);
                    $('#prcnt').html(": " + po[0]['prct']);
                    $('#code').html(": " + po[0]['spcd']);
                    $('#crby').html(": " + po[0]['crnm']);
                    $('#crdt').html(": " + po[0]['crdt']);
                    $('#apby').html(": " + ((po[0]['apnm'] != null) ? po[0]['apnm'] : "--"));
                    $('#apdt').html(": " + ((po[0]['apdt'] != null && po[0]['apdt'] != "0000-00-00 00:00:00") ? po[0]['apdt'] : "--"));
                    $('#rjby').html(": " + ((po[0]['rjnm'] != null) ? po[0]['rjnm'] : "--"));
                    $('#rjdt').html(": " + ((po[0]['rjdt'] != null && po[0]['rjdt'] != "0000-00-00 00:00:00") ? po[0]['rjdt'] : "--"));
                    $('#mdby').html(": " + ((po[0]['mdnm'] != null) ? po[0]['mdnm'] : "--"));
                    $('#mddt').html(": " + ((po[0]['mddt'] != null && po[0]['mddt'] != "0000-00-00 00:00:00") ? po[0]['mddt'] : "--"));
                    $('#prby').html(": " + ((po[0]['prnm'] != null) ? po[0]['prnm'] : "--"));
                    $('#prdt').html(": " + ((po[0]['prdt'] != null && po[0]['prdt'] != "0000-00-00 00:00:00") ? po[0]['prdt'] : "--"));
                    $('#rpby').html(": " + ((po[0]['rpnm'] != null) ? po[0]['rpnm'] : "--"));
                    $('#rpdt').html(": " + ((po[0]['rpdt'] != null && po[0]['rpdt'] != "0000-00-00 00:00:00") ? po[0]['rpdt'] : "--"));
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

        //PO PRINT
        function printPo(id) {
            swal({
                title: "Please wait...",
                text: "Purchase Order generating..",
                imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                showConfirmButton: false
            });
            setTimeout(function () {
                window.open('<?= base_url() ?>Stock/prchOrderPrint/' + id, 'popup', 'width=1100,height=600,scrollbars=no,resizable=no');
                swal.close(); // Hide the loading message
            }, 1000);
        }

        //PO SEND MAIL
        function sendPo(id) {
            swal({
                title: "Developing...",
                text: "Mail Send Processing..",
                imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                showConfirmButton: false
            });
            setTimeout(function () {
                swal.close(); // Hide the loading message
            }, 1000);
        }
    </script>
</div>
<!-- END PAGE CONTAINER -->
