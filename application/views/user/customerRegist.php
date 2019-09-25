<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">Customer Management</a></li>
        <li class="active">Customer Registration</li>
    </ul>
</div>
<div class="app-heading app-heading-bordered app-heading-page">
    <div class="icon icon-lg">
        <span class="icon-home" style="color: #e69c0f;"></span>
    </div>
    <div class="title">
        <h1>Customer Registration</h1>
        <p>Register / Edit / Reject / Deactive / Search & View</p>
    </div>
    <?php
    if($funcPerm[0]->inst == 1){ ?>
        <div class="pull-right">
            <button class="btn btn-sm btn-info btn-icon-fixed btn-rounded" data-toggle="modal" data-target="#modal-add">
                <span class="fa fa-plus"></span>Register
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
                    <label class="col-md-4 col-xs-12 control-label">Status</label>
                    <div class="col-md-8 col-xs-12">
                        <select id="stat" name="stat" onchange="srch_Supp();" class="bs-select">
                            <option value="all">All</option>
                            <option value="0">Pending</option>
                            <option value="1">Active</option>
                            <option value="3">Inactive</option>
                            <option value="2">Reject</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="block">
        <div class="row form-horizontal">
            <!--            <div class="block block-condensed">-->
            <div class="table-responsive">
                <table id="supp_table" class="table dataTable table-striped table-bordered" width="100%">
                    <thead>
                    <tr>
                        <th class="text-left">#</th>
                        <th class="text-left">CODE</th>
                        <th class="text-left">NAME</th>
                        <th class="text-left">ADDRESS</th>
                        <th class="text-left">MOBILE</th>
                        <th class="text-left">CREATED BY</th>
                        <th class="text-left">CREATED DATE</th>
                        <th class="text-left">STATUS</th>
                        <th class="text-left">ACTION</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>
            <!--            </div>-->
        </div>
    </div>

    <!-- MODAL ADD NEW SUPPLIER -->
    <div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modal-default-header">
        <div class="modal-dialog" role="document">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"
                                                                                              class="icon-cross"></span>
            </button>
            <form id="add_sup_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> Supplier
                            Registering</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row form-horizontal">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Supplier Name <span
                                                    class="fa fa-asterisk" style="color: red"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input class="form-control" type="text" name="name" id="name"
                                                   placeholder="Supplier Name"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Address <span
                                                    class="fa fa-asterisk"
                                                    style="color: red"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                        <textarea class="form-control" name="addr" id="addr"
                                                  placeholder="Supplier Address"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Contact <span
                                                    class="fa fa-asterisk"
                                                    style="color: red"></span></label>
                                        <div class="col-md-4 col-xs-12">
                                            <input class="form-control" type="text" name="mobi" id="mobi"
                                                   placeholder="Mobile"/>
                                        </div>
                                        <div class="col-md-4 col-xs-12">
                                            <input class="form-control" type="text" name="tele" id="tele"
                                                   placeholder="Land Tele."/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Email <span
                                                    class="fa fa-asterisk"
                                                    style="color: red"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input class="form-control" type="email" name="email" id="email"
                                                   placeholder="Email"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Bank Name <span
                                                    class="fa fa-asterisk" style="color: red"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <select id="bnknm" name="bnknm"
                                                    onchange="getbankbrch(this.value,'bnkbr','bnkbr_cont')"
                                                    class="bs-select">
                                                <option value="0">-- Select A Bank --</option>
                                                <?php
                                                foreach ($bank as $bnk) {
                                                    echo "<option value='$bnk->bnid'>" . $bnk->bkcd . " - " . $bnk->bknm . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Bank Branch <span
                                                    class="fa fa-asterisk" style="color: red"></span></label>
                                        <div class="col-md-8 col-xs-12" id="bnkbr_cont">
                                            <select id="bnkbr" name="bnkbr" onchange="" class="bs-select">
                                                <option value="0">-- Select A Branch --</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Account Number <span
                                                    class="fa fa-asterisk" style="color: red"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input class="form-control" type="text" name="acno" id="acno"
                                                   placeholder="Account Number"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Remark</label>
                                        <div class="col-md-8 col-xs-12">
                                        <textarea class="form-control" rows="5" name="remk" id="remk"
                                                  placeholder="Remark"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="pull-left">
                            <span class="fa fa-hand-o-right"></span> <label style="color: red"> <span
                                        class="fa fa-asterisk"></span> Required Fields </label>
                        </div>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                        <button type="button" id="add_sup_btn" class="btn btn-warning btn-xs btn-rounded">Submit
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
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"
                                                                                              class="icon-cross"></span>
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
                                                    class="fa fa-asterisk edit_req" style="color: red"></span></label>
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
                                                    class="fa fa-asterisk edit_req"
                                                    style="color: red"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                        <textarea class="form-control" name="addr_edt" id="addr_edt"
                                                  placeholder="Supplier Address"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Contact <span
                                                    class="fa fa-asterisk edit_req"
                                                    style="color: red"></span></label>
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
                                                    class="fa fa-asterisk edit_req"
                                                    style="color: red"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input class="form-control" type="email" name="email_edt" id="email_edt"
                                                   placeholder="Email"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <lable class="col-md-9 control-label">Bank Details</lable>
                                        <div id="edit_Area" class="col-md-3">
                                            <button type="button" class="btn btn-xs btn-info btn-rounded btn-icon-fixed"
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
                                                        <!--                                                    <th class="text-left">#</th>-->
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
                        <button type="button" id="app_sup_btn" class="btn btn-warning btn-xs btn-rounded">
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END VIEW SUPPLIER -->

    <!--    ADD NEW ACCOUNT-->
    <div class="modal fade" id="modal-Bank-New" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="modal-default-header">
        <div class="modal-dialog" role="document">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"
                                                                                              class="icon-cross"></span>
            </button>
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> Add New Account
                        Number</h4>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form id="edit_bank_form">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-12 control-label">Bank Name </label>
                                <div class="col-md-8 col-xs-12">
                                    <select id="bnknm_edt" name="bnknm_edt"
                                            onchange="getbankbrch(this.value,'bnkbr_edt','bnkbr_cont_edt')"
                                            class="bs-select">
                                        <option value="0">-- Select A Bank --</option>
                                        <?php
                                        foreach ($bank as $bnk) {
                                            echo "<option value='$bnk->bnid'>" . $bnk->bkcd . " - " . $bnk->bknm . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 col-xs-12 control-label">Bank Branch </label>
                                <div class="col-md-8 col-xs-12" id="bnkbr_cont_edt">
                                    <select id="bnkbr_edt" name="bnkbr_edt" onchange="" class="bs-select">
                                        <option value="0">-- Select A Branch --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 col-xs-12 control-label">Account Number </label>
                                <div class="col-md-8 col-xs-12">
                                    <input type="text" class="form-control" name="acno_edt"
                                           id="acno_edt"
                                           placeholder="Account Number"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="button" id="add_new_acc" class="btn btn-warning btn-xs btn-rounded">
                        Add
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--    ADD NEW ACCOUNT-->
</div>
<!-- END PAGE CONTAINER -->