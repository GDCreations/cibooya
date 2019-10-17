<script type="text/javascript" src="<?= base_url(); ?>assets/js/custom-js/full_width.js"></script>
<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">Stock Components</a></li>
        <li class="active">Item Management</li>
    </ul>
</div>
<div class="app-heading app-heading-bordered app-heading-page">
    <div class="icon icon-lg">
        <span class="fa fa-cubes" style="color: #e69c0f;"></span>
    </div>
    <div class="title">
        <h1>Item Management</h1>
        <p>Add / Photo Uploading / Edit / Reject / Deactive / Search & View</p>
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
                    <label class="col-md-4 col-xs-12 control-label">Category</label>
                    <div class="col-md-8 col-xs-12">
                        <select id="cats" name="cats" class="bs-select" onchange="chckBtn(this.value,this.id)">
                            <option value="0">-- Select Category --</option>
                            <option value="all">All Categories</option>
                            <?php
                            foreach ($category as $cat) {
                                echo "<option value='$cat->ctid'>" . $cat->ctcd . " - " . $cat->ctnm . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
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
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-md-4 col-xs-12 control-label">Brand</label>
                    <div class="col-md-8 col-xs-12">
                        <select id="brds" name="brds" class="bs-select" onchange="chckBtn(this.value,this.id)">
                            <option value="0">-- Select Brand --</option>
                            <option value="all">All Brands</option>
                            <?php
                            foreach ($brand as $brd) {
                                echo "<option value='$brd->bdid'>" . $brd->bdcd . " - " . $brd->bdnm . "</option>";
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
                    <label class="col-md-4 col-xs-12 control-label">Type</label>
                    <div class="col-md-8 col-xs-12">
                        <select id="typs" name="typs" class="bs-select" onchange="chckBtn(this.value,this.id)">
                            <option value="0">-- Select Type --</option>
                            <option value="all">All Types</option>
                            <?php
                            foreach ($type as $tp) {
                                echo "<option value='$tp->tpid'>" . $tp->tpcd . " - " . $tp->tpnm . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 col-xs-12 control-label"><br></label>
                    <div class="col-md-8 col-xs-12">
                        <button class="btn btn-sm btn-primary btn-rounded btn-icon-fixed pull-right" onclick="srch_Item()"><span
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
                <table id="item_table" class="table dataTable table-striped table-bordered" width="100%">
                    <thead>
                    <tr>
                        <th class="text-left">#</th>
                        <th class="text-left">CODE</th>
                        <th class="text-left">ITEM</th>
                        <th class="text-left" title="Category">CAT.</th>
                        <th class="text-left">BRAND</th>
                        <th class="text-left">TYPE</th>
                        <th class="text-left">MODEL</th>
                        <th class="text-left" title="Model Code">MDL CODE</th>
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

    <!-- MODAL ADD NEW BRAND -->
    <div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modal-default-header">
        <div class="modal-dialog modal-lg modal-info" role="document" style="width: 80%">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"
                                                                                              class="icon-cross"></span>
            </button>
            <form id="add_item_form" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> Add Item
                        </h4>
                    </div>
                    <div class="modal-body scroll"  style="max-height: 65vh">
                        <div class="container">
                            <div class="block-content">
                                <div id="smartwizard" class="wizard show-submit">
                                    <ul>
                                        <li>
                                            <a href="#step-1">
                                                <span class="stepNumber">1</span>
                                                <span class="stepDesc"><span class="fa fa-info fa-2x"></span><br/><small>Item Informations</small></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#step-2">
                                                <span class="stepNumber">2</span>
                                                <span class="stepDesc"><span class="fa fa-image fa-2x"></span><br/><small>Item Pictures</small></span>
                                            </a>
                                        </li>
                                    </ul>

                                    <div id="step-1">
                                        <div class="row form-horizontal">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Category <span
                                                                class="fa fa-asterisk req-astrick"></span></label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <select id="cat" name="cat" class="bs-select">
                                                            <option value="0">-- Select Category --</option>
                                                            <?php
                                                            foreach ($category as $cat) {
                                                                if ($cat->stat == 1) {
                                                                    echo "<option value='$cat->ctid'>" . $cat->ctcd . " - " . $cat->ctnm . "</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Brand <span
                                                                class="fa fa-asterisk req-astrick"></span></label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <select id="brd" name="brd" class="bs-select">
                                                            <option value="0">-- Select Brand --</option>
                                                            <?php
                                                            foreach ($brand as $brd) {
                                                                if ($brd->stat == 1) {
                                                                    echo "<option value='$brd->bdid'>" . $brd->bdcd . " - " . $brd->bdnm . "</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Type <span
                                                                class="fa fa-asterisk req-astrick"></span></label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <select id="typ" name="typ" class="bs-select">
                                                            <option value="0">-- Select Type --</option>
                                                            <?php
                                                            foreach ($type as $tp) {
                                                                if ($tp->stat == 1) {
                                                                    echo "<option value='$tp->tpid'>" . $tp->tpcd . " - " . $tp->tpnm . "</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Nature <span
                                                                class="fa fa-asterisk req-astrick"></span></label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <select id="ntr" name="ntr" class="bs-select">
                                                            <option value="0">-- Select Nature --</option>
                                                            <?php
                                                            foreach ($nature as $nt) {
                                                                echo "<option value='$nt->ntid'>$nt->ntnm</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Store Type <span
                                                                class="fa fa-asterisk req-astrick"></span></label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <select id="strtp" name="strtp" class="bs-select">
                                                            <option value="0">-- Select Store Type --</option>
                                                            <?php
                                                            foreach ($store as $str) {
                                                                echo "<option value='$str->strid'>$str->stnm</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Store Scale <span
                                                                class="fa fa-asterisk req-astrick"></span></label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <select id="strscl" name="strscl" class="bs-select">
                                                            <option value="0">-- Select Store Scale --</option>
                                                            <?php
                                                            foreach ($storeScl as $stscl) {
                                                                echo "<option value='$stscl->slid'> (" . $stscl->scl . ") - " . $stscl->scnm . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Max Store Level
                                                        <span
                                                                class="fa fa-asterisk req-astrick"></span></label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <input type="text" id="mxlv" name="mxlv" class="form-control"
                                                               placeholder="Max Store Level"/>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Remark</label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <textarea class="form-control" id="remk" name="remk"
                                                                  rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Item Name <span
                                                                class="fa fa-asterisk req-astrick"></span></label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <input type="text" id="name" name="name" class="form-control"
                                                               placeholder="Item Name"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Item Code <span
                                                                class="fa fa-asterisk req-astrick"></span></label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <input type="text" id="it_code" name="it_code"
                                                               class="form-control text-uppercase"
                                                               placeholder="Item Code"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Model <span
                                                                class="fa fa-asterisk req-astrick"></span></label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <input type="text" id="model" name="model" class="form-control"
                                                               placeholder="Model"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Model Code <span
                                                                class="fa fa-asterisk req-astrick"></span></label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <input type="text" id="md_code" name="md_code"
                                                               class="form-control text-uppercase"
                                                               placeholder="Model Code"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Size Of <span
                                                                class="fa fa-asterisk req-astrick"></span></label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <input type="text" id="szof" name="szof" class="form-control"
                                                               placeholder="Size Area Of Item"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Size Scale <span
                                                                class="fa fa-asterisk req-astrick"></span></label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <select id="szscl" name="szscl" class="bs-select">
                                                            <option value="0">-- Select Size Scale --</option>
                                                            <?php
                                                            foreach ($storeScl as $stscl) {
                                                                echo "<option value='$stscl->slid'> (" . $stscl->scl . ") - " . $stscl->scnm . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Size <span
                                                                class="fa fa-asterisk req-astrick"></span></label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <input type="text" id="size" name="size" class="form-control"
                                                               placeholder="Size"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Color</label>
                                                    <div class="col-md-4 col-xs-6">
                                                        <input type="text" id="clr" name="clr"
                                                               class="form-control bs-colorpicker-lg"
                                                               placeholder="Color Code"/>
                                                    </div>
                                                    <div class="col-md-4 col-xs-6">
                                                        <input type="text" id="clrnm" name="clrnm" class="form-control"
                                                               placeholder="Color Name"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Re Order Level
                                                        <span
                                                                class="fa fa-asterisk req-astrick"></span></label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <input type="text" id="rolv" name="rolv" class="form-control"
                                                               placeholder="Re Order Level"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Discription</label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <textarea class="form-control" id="dscr" name="dscr"
                                                                  rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="step-2">
                                        <div class="row form-horizontal">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="col-md-12 col-xs-12">
                                                        <input type="file" multiple id="pics1" class="item_pics"
                                                               name="pics[]"/>
                                                    </div>
                                                    <span style="color: red">* Maximum 5 photos can be uploaded of the item</span>
                                                </div>
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
                        <button type="button" style="display: none;" id="add_item_btn"
                                class="btn btn-info btn-sm btn-rounded">Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END ADD NEW BRAND -->

    <!-- MODAL VIEW BRAND -->
    <div class="modal fade" id="modal-view" tabindex="-1" role="dialog" aria-labelledby="modal-default-header">
        <div class="modal-dialog modal-lg modal-success" role="document" style="width: 80%;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"
                                                                                              class="icon-cross"></span>
            </button>
            <form id="app_item_form" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> Item
                            Management <span class="text-muted" id="subTitle_edit"></span></h4>
                        <input type="hidden" id="func" name="func"/>
                        <input type="hidden" id="itid" name="itid"/>
                        <input type="hidden" id="hsImg" name="hsImg"/>
                    </div>
                    <div class="modal-body scroll"  style="max-height: 65vh">
                        <div class="container">
                            <div class="block-content">
                                <div id="smartwizard2" class="wizard show-submit">
                                    <ul>
                                        <li>
                                            <a href="#step-3">
                                                <span class="stepNumber">1</span>
                                                <span class="stepDesc"><span class="fa fa-info fa-2x"></span><br/><small>Item Informations</small></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#step-4">
                                                <span class="stepNumber">2</span>
                                                <span class="stepDesc"><span class="fa fa-image fa-2x"></span><br/><small>Item Pictures</small></span>
                                            </a>
                                        </li>
                                    </ul>

                                    <div id="step-3">
                                        <div class="row form-horizontal">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Category <span
                                                                class="fa fa-asterisk req-astrick"></span></label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <select id="cat_edt" name="cat_edt" class="bs-select">
                                                            <option value="0">-- Select Category --</option>
                                                            <?php
                                                            foreach ($category as $cat) {
                                                                if ($cat->stat == 1) {
                                                                    echo "<option value='$cat->ctid'>" . $cat->ctcd . " - " . $cat->ctnm . "</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Brand <span
                                                                class="fa fa-asterisk req-astrick"></span></label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <select id="brd_edt" name="brd_edt" class="bs-select">
                                                            <option value="0">-- Select Brand --</option>
                                                            <?php
                                                            foreach ($brand as $brd) {
                                                                if ($brd->stat == 1) {
                                                                    echo "<option value='$brd->bdid'>" . $brd->bdcd . " - " . $brd->bdnm . "</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Type <span
                                                                class="fa fa-asterisk req-astrick"></span></label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <select id="typ_edt" name="typ_edt" class="bs-select">
                                                            <option value="0">-- Select Type --</option>
                                                            <?php
                                                            foreach ($type as $tp) {
                                                                if ($tp->stat == 1) {
                                                                    echo "<option value='$tp->tpid'>" . $tp->tpcd . " - " . $tp->tpnm . "</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Nature <span
                                                                class="fa fa-asterisk req-astrick"></span></label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <select id="ntr_edt" name="ntr_edt" class="bs-select">
                                                            <option value="0">-- Select Nature --</option>
                                                            <?php
                                                            foreach ($nature as $nt) {
                                                                echo "<option value='$nt->ntid'>$nt->ntnm</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Store Type <span
                                                                class="fa fa-asterisk req-astrick"></span></label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <select id="strtp_edt" name="strtp_edt" class="bs-select">
                                                            <option value="0">-- Select Store Type --</option>
                                                            <?php
                                                            foreach ($store as $str) {
                                                                echo "<option value='$str->strid'>$str->stnm</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Store Scale <span
                                                                class="fa fa-asterisk req-astrick"></span></label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <select id="strscl_edt" name="strscl_edt" class="bs-select">
                                                            <option value="0">-- Select Store Scale --</option>
                                                            <?php
                                                            foreach ($storeScl as $stscl) {
                                                                echo "<option value='$stscl->slid'> (" . $stscl->scl . ") - " . $stscl->scnm . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Max Store Level
                                                        <span
                                                                class="fa fa-asterisk req-astrick"></span></label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <input type="text" id="mxlvEdt" name="mxlvEdt"
                                                               class="form-control"
                                                               placeholder="Max Store Level"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Remark</label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <textarea class="form-control" id="remk_edt" name="remk_edt"
                                                                  rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Item Name <span
                                                                class="fa fa-asterisk req-astrick"></span></label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <input type="text" id="name_edt" name="name_edt"
                                                               class="form-control"
                                                               placeholder="Item Name"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Item Code <span
                                                                class="fa fa-asterisk req-astrick"></span></label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <input type="text" id="it_code_edt" name="it_code_edt"
                                                               class="form-control text-uppercase"
                                                               placeholder="Item Code"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Model <span
                                                                class="fa fa-asterisk req-astrick"></span></label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <input type="text" id="model_edt" name="model_edt"
                                                               class="form-control"
                                                               placeholder="Model"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Model Code <span
                                                                class="fa fa-asterisk req-astrick"></span></label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <input type="text" id="md_code_edt" name="md_code_edt"
                                                               class="form-control text-uppercase"
                                                               placeholder="Model Code"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Size Of <span
                                                                class="fa fa-asterisk req-astrick"></span></label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <input type="text" id="szof_edt" name="szof_edt"
                                                               class="form-control"
                                                               placeholder="Size Area Of Item"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Size Scale <span
                                                                class="fa fa-asterisk req-astrick"></span></label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <select id="szscl_edt" name="szscl_edt" class="bs-select">
                                                            <option value="0">-- Select Size Scale --</option>
                                                            <?php
                                                            foreach ($storeScl as $stscl) {
                                                                echo "<option value='$stscl->slid'> (" . $stscl->scl . ") - " . $stscl->scnm . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Size <span
                                                                class="fa fa-asterisk req-astrick"></span></label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <input type="text" id="size_edt" name="size_edt"
                                                               class="form-control"
                                                               placeholder="Size"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Color</label>
                                                    <div class="col-md-4 col-xs-6">
                                                        <input type="text" id="clr_edt" name="clr_edt"
                                                               class="form-control bs-colorpicker-lg"
                                                               placeholder="Color Code"/>
                                                    </div>
                                                    <div class="col-md-4 col-xs-6">
                                                        <input type="text" id="clrnm_edt" name="clrnm_edt"
                                                               class="form-control"
                                                               placeholder="Color Name"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Re Order Level
                                                        <span
                                                                class="fa fa-asterisk req-astrick"></span></label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <input type="text" id="rolv_edt" name="rolv_edt" class="form-control"
                                                               placeholder="Re Order Level"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Discription</label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <textarea class="form-control" id="dscr_edt" name="dscr_edt"
                                                                  rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-horizontal view_Area">
                                            <hr>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Status</label>
                                                    <label class="col-md-8 control-label" id="itm_stat"></label>
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
                                    <div id="step-4">
                                        <div class="row form-horizontal">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="col-md-12 col-xs-12">
                                                        <input type="file" multiple id="pics1_edt" class="item_pics"
                                                               name="pics_edt[]"/>
                                                    </div>
                                                    <span style="color: red">* Maximum 5 photos can be uploaded of the item</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                        <button type="button" style="display: none;" id="app_item_btn"
                                class="btn btn-success btn-sm btn-rounded">
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END VIEW BRAND -->

    <script type="text/javascript">
        $().ready(function () {
            //Table Initializing
            $('#item_table').DataTable({
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                "aoColumns": [
                    {sWidth: '3%'},
                    {sWidth: '7%'},
                    {sWidth: '15%'},
                    {sWidth: '7%'},
                    {sWidth: '7%'},
                    {sWidth: '7%'},
                    {sWidth: '15%'},
                    {sWidth: '7%'},
                    {sWidth: '5%'},
                    {sWidth: '12%'}
                ],
            });

            //File Uploader Initialiting
            $("#pics1").fileinput({
                allowedFileExtensions: ['jpg', 'png', 'jpeg'],
                showUpload: false,
                showCaption: false,
                browseClass: "btn btn-primary btn-sm btn-rounded",
                removeClass: "btn btn-warning btn-sm btn-rounded",
                maxFileSize: 5000, //Kb
                maxFileCount: 5,
            });

            $('#add_item_form').validate({
                rules: {
                    cat: {
                        notEqual: 0
                    },
                    brd: {
                        notEqual: 0
                    },
                    typ: {
                        notEqual: 0
                    },
                    ntr: {
                        notEqual: 0
                    },
                    strtp: {
                        notEqual: 0
                    },
                    strscl: {
                        notEqual: 0
                    },
                    mxlv: {
                        notEqual: 0,
                        required: true,
                        digits: true
                    },
                    rolv: {
                        notEqual: 0,
                        required: true,
                        digits: true
                    },

                    name: {
                        required: true,
                        remote: {
                            url: "<?= base_url(); ?>Stock/chk_itmName",
                            type: "post",
                            data: {
                                name: function () {
                                    return $("#name").val();
                                },
                                stat: 0
                            }
                        }
                    },
                    it_code: {
                        required: true,
                        remote: {
                            url: "<?= base_url(); ?>Stock/chk_itmCode",
                            type: "post",
                            data: {
                                it_code: function () {
                                    return $("#it_code").val();
                                },
                                stat: 0
                            }
                        }
                    },
                    model: {
                        required: true,
                        remote: {
                            url: "<?= base_url(); ?>Stock/chk_mdlName",
                            type: "post",
                            data: {
                                model: function () {
                                    return $("#model").val();
                                },
                                stat: 0
                            }
                        }
                    },
                    md_code: {
                        required: true,
                        remote: {
                            url: "<?= base_url(); ?>Stock/chk_mdlCode",
                            type: "post",
                            data: {
                                md_code: function () {
                                    return $("#md_code").val();
                                },
                                stat: 0
                            }
                        }
                    },
                    szof: {
                        required: true,
                    },
                    szscl:{
                        notEqual: 0
                    },
                    size: {
                        required: true,
                        decimal: true
                    }
                },
                messages: {
                    cat: {
                        notEqual: "Select a category"
                    },
                    brd: {
                        notEqual: "Select a brand"
                    },
                    typ: {
                        notEqual: "Select a type"
                    },
                    ntr: {
                        notEqual: "Select a nature"
                    },
                    strtp: {
                        notEqual: "Select a store type"
                    },
                    strscl: {
                        notEqual: "Select a store scale"
                    },
                    mxlv: {
                        notEqual: "Enter Max Store Level",
                        required: "Enter Max Store Level",
                    },
                    rolv: {
                        notEqual: "Enter Re Order Level",
                        required: "Enter Re Order Level",
                    },
                    name: {
                        required: "Enter item name",
                        remote: "Already entered item name"
                    },
                    it_code: {
                        required: "Enter item code",
                        remote: "Already entered item code"
                    },
                    model: {
                        required: "Enter model",
                        remote: "Already entered model"
                    },
                    md_code: {
                        required: "Enter model code",
                        remote: "Already entered model code"
                    },
                    szof: {
                        required: "Enter size area of item",
                    },
                    szscl:{
                        notEqual: "Select scale of size"
                    },
                    size: {
                        required: "Enter size"
                    }
                }
            });

            $('#app_item_form').validate({
                rules: {
                    cat_edt: {
                        notEqual: 0
                    },
                    brd_edt: {
                        notEqual: 0
                    },
                    typ_edt: {
                        notEqual: 0
                    },
                    ntr_edt: {
                        notEqual: 0
                    },
                    strtp_edt: {
                        notEqual: 0
                    },
                    strscl_edt: {
                        notEqual: 0
                    },
                    mxlvEdt: {
                        notEqual: 0,
                        required: true,
                        digits: true
                    },
                    rolv_edt: {
                        notEqual: 0,
                        required: true,
                        digits: true
                    },
                    name_edt: {
                        required: true,
                        remote: {
                            url: "<?= base_url(); ?>Stock/chk_itmName",
                            type: "post",
                            data: {
                                name: function () {
                                    return $("#name_edt").val();
                                },
                                itid: function () {
                                    return $("#itid").val();
                                },
                                stat: 1
                            }
                        }
                    },
                    it_code_edt: {
                        required: true,
                        remote: {
                            url: "<?= base_url(); ?>Stock/chk_itmCode",
                            type: "post",
                            data: {
                                it_code: function () {
                                    return $("#it_code_edt").val();
                                },
                                itid: function () {
                                    return $("#itid").val();
                                },
                                stat: 1
                            }
                        }
                    },
                    model_edt: {
                        required: true,
                        remote: {
                            url: "<?= base_url(); ?>Stock/chk_mdlName",
                            type: "post",
                            data: {
                                model: function () {
                                    return $("#model_edt").val();
                                },
                                itid: function () {
                                    return $("#itid").val();
                                },
                                stat: 1
                            }
                        }
                    },
                    md_code_edt: {
                        required: true,
                        remote: {
                            url: "<?= base_url(); ?>Stock/chk_mdlCode",
                            type: "post",
                            data: {
                                md_code: function () {
                                    return $("#md_code_edt").val();
                                },
                                itid: function () {
                                    return $("#itid").val();
                                },
                                stat: 1
                            }
                        }
                    },
                    szof_edt: {
                        required: true,
                    },
                    szscl_edt:{
                        notEqual: 0
                    },
                    size_edt: {
                        required: true,
                        decimal: true
                    }
                },
                messages: {
                    cat_edt: {
                        notEqual: "Select a category"
                    },
                    brd_edt: {
                        notEqual: "Select a brand"
                    },
                    typ_edt: {
                        notEqual: "Select a type"
                    },
                    ntr_edt: {
                        notEqual: "Select a nature"
                    },
                    strtp_edt: {
                        notEqual: "Select a store type"
                    },
                    strscl_edt: {
                        notEqual: "Select a store scale"
                    },
                    mxlvEdt: {
                        notEqual: "Enter Max Store Level",
                        required: "Enter Max Store Level",
                    },
                    rolv_edt: {
                        notEqual: "Enter Re Order Level",
                        required: "Enter Re Order Level",
                    },
                    name_edt: {
                        required: "Enter item name",
                        remote: "Already entered item name"
                    },
                    it_code_edt: {
                        required: "Enter item code",
                        remote: "Already entered item code"
                    },
                    model_edt: {
                        required: "Enter model",
                        remote: "Already entered model"
                    },
                    md_code_edt: {
                        required: "Enter model code",
                        remote: "Already entered model code"
                    },
                    szof_edt: {
                        required: "Enter size area of item",
                    },
                    szscl_edt:{
                        notEqual: "Select scale of size"
                    },
                    size_edt: {
                        required: "Enter size"
                    }
                }
            });
        });
        // Required for Bootstrap tooltips in DataTables
        $(document).ajaxComplete(function () {
            $('[data-toggle="tooltip"]').tooltip({
                "html": true
            });
        });

        //Next Button
        function nextBtnActn() {
            if ($('#modal-view').hasClass('in')) {
                if ($('#func').val() == 'view') {
                    $('#app_item_btn').css('display', 'none');
                    return true;
                } else {
                    if ($('#app_item_form').valid()) {
                        $('#app_item_btn').css('display', 'inline');
                        return true;
                    } else {
                        return false;
                    }
                }
            } else {
                if ($('#add_item_form').valid()) {
                    $('#add_item_btn').css('display', 'inline');
                    return true;
                } else {
                    return false;
                }
            }
        }

        //Previous Button
        function prevBtnActn() {
            $('#add_item_btn').css('display', 'none');
            $('#app_item_btn').css('display', 'none');
            return true;
        }

        //Add New Brand
        $('#add_item_btn').click(function (e) {
            e.preventDefault();
            var formObj = document.getElementById('add_item_form');
            var formData = new FormData(formObj);
            if ($('#add_item_form').valid()) {
                $('#add_item_btn').prop('disabled', true);
                swal({
                    title: "Processing...",
                    text: "Item data saving..",
                    imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                    showConfirmButton: false
                });

                jQuery.ajax({
                    type: "POST",
                    url: "<?= base_url(); ?>Stock/item_Add",
                    data: formData,
                    mimeType: "multipart/form-data",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        swal({title: "", text: "Item Added!", type: "success"},
                            function () {
                                $('#add_item_btn').prop('disabled', false);
                                clear_Form('add_item_form');
                                $('#modal-add').modal('hide');
                                resetSmWizard('smartwizard', 'step-1', 'add_item_btn');
                                srch_Item();
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
        function srch_Item() {
            var check = true;
            if ($('#cats').val() == 0) {
                check = false;
            }
            if ($('#brds').val() == 0) {
                check = false;
            }
            if ($('#typs').val() == 0) {
                check = false;
            }
            chckBtn($('#cats').val(), 'cats');
            chckBtn($('#brds').val(), 'brds');
            chckBtn($('#typs').val(), 'typs');

            if (check) {
                $('#item_table').DataTable().clear();
                $('#item_table').DataTable({
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
                        {className: "text-left", "targets": [2, 6]},
                        {className: "text-center", "targets": [0, 1, 3, 4, 5, 7, 8, 9]},
                        {className: "text-right", "targets": []},
                        {className: "text-nowrap", "targets": [2, 6]},
                    ],
                    "order": [[4, "DESC"]], //ASC  desc
                    "aoColumns": [
                        {sWidth: '3%'},
                        {sWidth: '7%'},
                        {sWidth: '15%'},
                        {sWidth: '7%'},
                        {sWidth: '7%'},
                        {sWidth: '7%'},
                        {sWidth: '15%'},
                        {sWidth: '7%'},
                        {sWidth: '5%'},
                        {sWidth: '12%'}
                    ],

                    "ajax": {
                        url: '<?= base_url(); ?>Stock/searchItem',
                        type: 'post',
                        data: {
                            cat: function () {
                                return $('#cats').val();
                            },
                            brd: function () {
                                return $('#brds').val();
                            },
                            typ: function () {
                                return $('#typs').val();
                            },
                            stat: function () {
                                return $('#stat').val();
                            },
                            dtrg: function () {
                                return $('#dtrng').val();
                            }
                        }
                    },
                });
            }
        }

        //View Supplier
        function viewItm(id, func) {
            swal({
                title: "Loading Data...",
                text: "Brand Details",
                imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                showConfirmButton: false
            });

            $('#func').val(func);
            $('#itid').val(id);

            jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>Stock/get_ItmDet",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (data) {
                    if (func == 'view') {
                        //VIEW MODEL
                        $('#subTitle_edit').html(' - View');
                        $("#modal-view").find('.edit_req').css("display", "none");
                        $("#edit_Area").css('display', 'none');
                        $(".view_Area").css('display', 'block');
                        //Make readonly all fields
                        $("#modal-view :input").attr("readonly", true);
                        $('.file-input').css('pointer-events', 'none');
                        $('#clr_edt').css('pointer-events', 'none');
                        readonlyAllSelct('modal-view');
                        //VIEW MODEL
                    } else if (func == 'edit') {
                        //EDIT MODEL
                        $('#subTitle_edit').html(' - Edit');
                        $('#app_item_btn').html('Update');
                        $("#modal-view").find('.edit_req').css("display", "inline");
                        $("#edit_Area").css('display', 'block');
                        $(".view_Area").css('display', 'none');
                        //Remove readonly all fields
                        $("#modal-view :input").attr("readonly", false);
                        $('.file-input').css('pointer-events', '');
                        $('#clr_edt').css('pointer-events', '');
                        editAllSelct('modal-view');
                        //EDIT MODEL
                    } else if (func == 'app') {
                        //APPROVE MODEL
                        $('#subTitle_edit').html(' - Approve');
                        $('#app_item_btn').html('Approve');
                        $("#modal-view").find('.edit_req').css("display", "inline");
                        $("#edit_Area").css('display', 'block');
                        $(".view_Area").css('display', 'none');
                        //Remove readonly all fields
                        $("#modal-view :input").attr("readonly", false);
                        $('.file-input').css('pointer-events', '');
                        $('#clr_edt').css('pointer-events', '');
                        editAllSelct('modal-view');
                        //APPROVE MODEL
                    }
                    var len = data['item'].length;

                    if (len > 0) {
                        $('#name_edt').val(data['item'][0]['itnm']);
                        $('#it_code_edt').val(data['item'][0]['itcd']);
                        $('#model_edt').val(data['item'][0]['mdl']);
                        $('#md_code_edt').val(data['item'][0]['mlcd']);
                        $('#szof_edt').val(data['item'][0]['szof']);
                        $('#size_edt').val(data['item'][0]['size']);
                        $('#clr_edt').val(data['item'][0]['clcd']);
                        $('#clrnm_edt').val(data['item'][0]['clr']);
                        $('#remk_edt').val(data['item'][0]['remk']);
                        $('#dscr_edt').val(data['item'][0]['dscr']);
                        $('#mxlvEdt').val(data['item'][0]['mxlv']);
                        $('#rolv_edt').val(data['item'][0]['rolv']);

                        set_select('cat_edt', data['item'][0]['ctid']);
                        set_select('brd_edt', data['item'][0]['bdid']);
                        set_select('typ_edt', data['item'][0]['tpid']);
                        set_select('ntr_edt', data['item'][0]['ntid']);
                        set_select('strtp_edt', data['item'][0]['strid']);
                        set_select('strscl_edt', data['item'][0]['scli']);
                        set_select('szscl_edt',data['item'][0]['szsl']);

                        var len2 = data['pics'].length;
                        var picsVw = new Array();
                        if (len2 > 0) {
                            $('#hsImg').val(1);
                            for (var itt = 0; itt < len2; itt++) {
                                var date = new Date(data['pics'][itt]['crdt']);
                                var year = date.getFullYear();
                                picsVw.push("<?= base_url()?>uploads/img/item/" + year + "/" + data['pics'][itt]['pcnm']);
                            }
                        } else {
                            $('#hsImg').val(0);
                        }

                        //File Uploader Initialiting
                        $("#pics1_edt").fileinput('enable');
                        $("#pics1_edt").fileinput('destroy');
                        $("#pics1_edt").fileinput({
                            allowedFileExtensions: ['jpg', 'png', 'jpeg'],
                            showUpload: false,
                            showCaption: false,
                            browseClass: "btn btn-primary btn-sm btn-rounded",
                            removeClass: "btn btn-warning btn-sm btn-rounded",
                            maxFileSize: 5000, //Kb
                            initialPreviewAsData: true,
                            initialPreview: picsVw
                        });
                        var picsVw = new Array();

                        if (data['item'][0]['stat'] == 0) {
                            var stat = "<label class='label label-warning'>Pending</label>";
                        } else if (data['item'][0]['stat'] == 1) {
                            var stat = "<label class='label label-success'>Active</label>";
                        } else if (data['item'][0]['stat'] == 2) {
                            var stat = "<label class='label label-danger'>Reject</label>";
                        } else if (data['item'][0]['stat'] == 3) {
                            var stat = "<label class='label label-info'>Inactive</label>";
                        } else {
                            var stat = "--";
                        }
                        $('#itm_stat').html(": " + stat);
                        $('#crby').html(": " + data['item'][0]['crnm']);
                        $('#crdt').html(": " + data['item'][0]['crdt']);
                        $('#apby').html(": " + ((data['item'][0]['apnm'] != null) ? data['item'][0]['apnm'] : "--"));
                        $('#apdt').html(": " + ((data['item'][0]['apdt'] != null && data['item'][0]['apdt'] != "0000-00-00 00:00:00") ? data['item'][0]['apdt'] : "--"));
                        $('#rjby').html(": " + ((data['item'][0]['rjnm'] != null) ? data['item'][0]['rjnm'] : "--"));
                        $('#rjdt').html(": " + ((data['item'][0]['rjdt'] != null && data['item'][0]['rjdt'] != "0000-00-00 00:00:00") ? data['item'][0]['rjdt'] : "--"));
                        $('#mdby').html(": " + ((data['item'][0]['mdnm'] != null) ? data['item'][0]['mdnm'] : "--"));
                        $('#mddt').html(": " + ((data['item'][0]['mddt'] != null && data['item'][0]['mddt'] != "0000-00-00 00:00:00") ? data['item'][0]['mddt'] : "--"));
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
        $('#app_item_btn').click(function (e) {
            e.preventDefault();
            var formObj = document.getElementById('app_item_form');
            var formData = new FormData(formObj);
            if ($('#app_item_form').valid()) {
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
                            $('#app_item_btn').prop('disabled', true);
                            if (func == 'edit') {
                                swal({
                                    title: "Processing...",
                                    text: "Item details updating..",
                                    imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                                    showConfirmButton: false
                                });

                                jQuery.ajax({
                                    type: "POST",
                                    url: "<?= base_url(); ?>Stock/itm_update",
                                    data: formData,
                                    mimeType: "multipart/form-data",
                                    contentType: false,
                                    cache: false,
                                    processData: false,
                                    success: function (data) {
                                        swal({title: "", text: "Updating Success!", type: "success"},
                                            function () {
                                                $('#app_item_btn').prop('disabled', false);
                                                clear_Form('app_item_form');
                                                $("#pics1_edt").fileinput('destroy');
                                                $('#modal-view').modal('hide');
                                                srch_Item();
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
                                    text: "Brand approving..",
                                    imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                                    showConfirmButton: false
                                });

                                jQuery.ajax({
                                    type: "POST",
                                    url: "<?= base_url(); ?>Stock/itm_update",
                                    data: formData,
                                    mimeType: "multipart/form-data",
                                    contentType: false,
                                    cache: false,
                                    processData: false,
                                    success: function (data) {
                                        swal({title: "", text: "Approved!", type: "success"},
                                            function () {
                                                $('#app_item_btn').prop('disabled', false);
                                                clear_Form('app_item_form');
                                                $("#pics1_edt").fileinput('destroy');
                                                $('#modal-view').modal('hide');
                                                srch_Item();
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

        //Reject Supplier
        function rejectItm(id) {
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
                            url: "<?= base_url(); ?>Stock/itm_Reject",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (data) {
                                swal({title: "", text: "Item was rejected!", type: "success"},
                                    function () {
                                        srch_Item();
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
        function inactItm(id) {
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
                            url: "<?= base_url(); ?>Stock/itm_Deactive",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (data) {
                                swal({title: "", text: "Item was deactivated!", type: "success"},
                                    function () {
                                        srch_Item();
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
        function reactItm(id) {
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
                            url: "<?= base_url(); ?>Stock/itm_Activate",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (data) {
                                swal({title: "", text: "Item was activated!", type: "success"},
                                    function () {
                                        srch_Item();
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
