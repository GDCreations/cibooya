<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">Supplier Management</a></li>
        <li class="active">Supplier Registration</li>
    </ul>
</div>
<div class="app-heading app-heading-bordered app-heading-page">
    <div class="icon icon-lg">
        <span class="fa fa-user" style="color: #e69c0f;"></span>
    </div>
    <div class="title">
        <h1>Supplier Registration</h1>
        <p>Register / Edit / Reject / Deactive / Search & View</p>
    </div>
    <?php
    if ($funcPerm[0]->inst == 1) { ?>
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
        <div class="modal-dialog modal-info" role="document">
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
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input class="form-control" type="text" name="name" id="name"
                                                   placeholder="Supplier Name"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Address <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                        <textarea class="form-control" name="addr" id="addr"
                                                  placeholder="Supplier Address"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Contact <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
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
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input class="form-control" type="email" name="email" id="email"
                                                   placeholder="Email"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Bank Details </label>
                                        <div class="col-md-8 col-xs-12">
                                            <label class="switch">
                                                No <input type="checkbox" value="1" id="bnkDtl" name="bnkDtl"
                                                          onchange="loadBnkDit()">
                                            </label> Yes
                                        </div>
                                    </div>
                                    <div id="bankDtil" style="display: none">
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Bank Name <span
                                                        class="fa fa-asterisk req-astrick"></span></label>
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
                                                        class="fa fa-asterisk req-astrick"></span></label>
                                            <div class="col-md-8 col-xs-12" id="bnkbr_cont">
                                                <select id="bnkbr" name="bnkbr" onchange="" class="bs-select">
                                                    <option value="0">-- Select A Branch --</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group" style="margin-bottom: 15px !important;">
                                            <label class="col-md-4 col-xs-12 control-label">Account Number <span
                                                        class="fa fa-asterisk req-astrick"></span></label>
                                            <div class="col-md-8 col-xs-12">
                                                <input class="form-control" type="text" name="acno" id="acno"
                                                       placeholder="Account Number"/>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
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
                                        class="fa fa-asterisk req-astrick"></span> Required Fields </label>
                        </div>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                        <button type="button" id="add_sup_btn" class="btn btn-info btn-sm btn-rounded">Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END ADD NEW SUPPLIER -->

    <!-- MODAL VIEW SUPPLIER -->
    <div class="modal fade" id="modal-view" tabindex="-1" role="dialog" aria-labelledby="modal-default-header">
        <div class="modal-dialog modal-lg modal-success" role="document">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="icon-cross"></span>
            </button>
            <form id="app_sup_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> Supplier
                            Registering <span class="text-muted" id="subTitle_edit"></span></h4>
                        <input type="hidden" id="func" name="func"/>
                        <input type="hidden" id="spid" name="spid"/>
                    </div>
                    <div class="modal-body scroll" style="max-height: 65vh">
                        <div class="container">
                            <div class="form-horizontal">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Supplier Name <span
                                                    class="fa fa-asterisk req-astrick edit_req"></span></label>
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
                                                    class="fa fa-asterisk req-astrick edit_req"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                        <textarea class="form-control" name="addr_edt" id="addr_edt"
                                                  placeholder="Supplier Address"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Contact <span
                                                    class="fa fa-asterisk req-astrick edit_req"></span></label>
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
                                                    class="fa fa-asterisk req-astrick edit_req"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input class="form-control" type="email" name="email_edt" id="email_edt"
                                                   placeholder="Email"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <lable class="col-md-4 col-xs-12 control-label">Bank Details</lable>
                                        <div class="col-md-4 col-xs-12">
                                            <label class="switch">
                                                No <input type="checkbox" value="1" id="bnkDtlEdt" name="bnkDtlEdt"
                                                          onchange="loadBnkDitEdt()">
                                            </label> Yes
                                        </div>

                                        <div id="bankDtilEdt" style="display: none">
                                            <div id="edit_Area" class="col-md-4">
                                                <button type="button"
                                                        class="btn btn-xs btn-info btn-rounded btn-icon-fixed pull-right"
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
                        <button type="button" id="app_sup_btn" class="btn btn-success btn-sm btn-rounded">
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
        <div class="modal-dialog modal-warning" role="document">
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
                    <button type="button" id="add_new_acc" class="btn btn-warning btn-sm btn-rounded">
                        Add
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--    ADD NEW ACCOUNT-->

    <script type="text/javascript">
        $().ready(function () {
            //Table Initializing
            $('#supp_table').DataTable({
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                "aoColumns": [
                    {sWidth: '3%'},
                    {sWidth: '5%'},
                    {sWidth: '15%'},
                    {sWidth: '15%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '8%'},
                    {sWidth: '12%'}
                ],
            });

            $('#add_sup_form').validate({
                rules: {
                    name: {
                        required: true,
                        remote: {
                            url: "<?= base_url(); ?>Stock/chk_spName",
                            type: "post",
                            data: {
                                name: function () {
                                    return $("#name").val();
                                },
                                stat: 0
                            }
                        }
                    },
                    addr: {
                        required: true
                    },
                    mobi: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 10,
                        remote: {
                            url: "<?= base_url(); ?>Stock/chk_mobile",
                            type: "post",
                            data: {
                                mobi: function () {
                                    return $("#mobi").val();
                                },
                                stat: 0
                            }
                        }
                    },
                    tele: {
                        digits: true,
                        minlength: 10,
                        maxlength: 10,
                        remote: {
                            url: "<?= base_url(); ?>Stock/chk_mobile",
                            type: "post",
                            data: {
                                mobi: function () {
                                    return $("#tele").val();
                                },
                                stat: 0
                            }
                        }
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    bnknm: {
                        notEqual: 0
                    },
                    bnkbr: {
                        notEqual: 0
                    },
                    acno: {
                        required: true,
                        digits: true,
                        minlength: 8,
                        remote: {
                            url: "<?= base_url(); ?>Stock/chk_bnkAcno",
                            type: "post",
                            data: {
                                acno: function () {
                                    return $("#acno").val();
                                },
                                stat: 0
                            }
                        }
                    }
                },
                messages: {
                    name: {
                        required: "Enter supplier name",
                        remote: "Already entered name"
                    },
                    addr: {
                        required: "Enter supplier address"
                    },
                    mobi: {
                        required: "Enter mobile number",
                        digits: "Only numbers are allowed",
                        minlength: "Please enter 10 digits number",
                        maxlength: "Please enter 10 digits number",
                        remote: "This number is already added"
                    },
                    tele: {
                        digits: "Only numbers are allowed",
                        minlength: "Please enter 10 digits number",
                        maxlength: "Please enter 10 digits number",
                        remote: "This number is already added"
                    },
                    email: {
                        required: "Enter email address",
                        email: "Please enter valid email address"
                    },
                    bnknm: {
                        notEqual: "Select a bank"
                    },
                    bnkbr: {
                        notEqual: "Select a bank branch"
                    },
                    acno: {
                        required: "Enter bank account number",
                        digits: "Only numbers are allowed",
                        minlength: "Minumum length is 8 digits",
                        remote: "This account number is already added"
                    }
                }
            });

            $('#app_sup_form').validate({
                rules: {
                    name_edt: {
                        required: true,
                        remote: {
                            url: "<?= base_url(); ?>Stock/chk_spName",
                            type: "post",
                            data: {
                                name: function () {
                                    return $("#name_edt").val();
                                },
                                spid: function () {
                                    return $("#spid").val();
                                },
                                stat: 1
                            }
                        }
                    },
                    addr_edt: {
                        required: true
                    },
                    mobi_edt: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 10,
                        remote: {
                            url: "<?= base_url(); ?>Stock/chk_mobile",
                            type: "post",
                            data: {
                                mobi: function () {
                                    return $("#mobi_edt").val();
                                },
                                spid: function () {
                                    return $("#spid").val();
                                },
                                stat: 1
                            }
                        }
                    },
                    tele_edt: {
                        digits: true,
                        minlength: 10,
                        maxlength: 10,
                        remote: {
                            url: "<?= base_url(); ?>Stock/chk_mobile",
                            type: "post",
                            data: {
                                mobi: function () {
                                    return $("#tele_edt").val();
                                },
                                spid: function () {
                                    return $("#spid").val();
                                },
                                stat: 1
                            }
                        }
                    },
                    email_edt: {
                        required: true,
                        email: true
                    },
                },
                messages: {
                    name_edt: {
                        required: "Enter supplier name",
                        remote: "Already entered name"
                    },
                    addr_edt: {
                        required: "Enter supplier address"
                    },
                    mobi_edt: {
                        required: "Enter mobile number",
                        digits: "Only numbers are allowed",
                        minlength: "Please enter 10 digits number",
                        maxlength: "Please enter 10 digits number",
                        remote: "This number is already added"
                    },
                    tele_edt: {
                        digits: "Only numbers are allowed",
                        minlength: "Please enter 10 digits number",
                        maxlength: "Please enter 10 digits number",
                        remote: "This number is already added"
                    },
                    email_edt: {
                        required: "Enter email address",
                        email: "Please enter valid email address"
                    },
                }
            });

            $('#edit_bank_form').validate({
                rules: {
                    bnknm_edt: {
                        notEqual: 0
                    },
                    bnkbr_edt: {
                        notEqual: 0
                    },
                    acno_edt: {
                        required: true,
                        digits: true,
                        minlength: 8,
                        remote: {
                            url: "<?= base_url(); ?>Stock/chk_bnkAcno",
                            type: "post",
                            data: {
                                acno: function () {
                                    return $("#acno_edt").val();
                                },
                                spid: function () {
                                    return $("#spid").val();
                                },
                                stat: 1
                            }
                        }
                    }
                },
                messages: {
                    bnknm_edt: {
                        notEqual: "Select a bank"
                    },
                    bnkbr_edt: {
                        notEqual: "Select a bank branch"
                    },
                    acno_edt: {
                        required: "Enter bank account number",
                        digits: "Only numbers are allowed",
                        minlength: "Minumum length is 8 digits",
                        remote: "This account number is already added"
                    }
                }
            });
            srch_Supp();
        });

        //Get Branches by Bank
        function getbankbrch(id, html, mhtml) {
            $.ajax({
                url: '<?= base_url(); ?>Stock/getbnkbrch',
                type: 'post',
                data: {
                    id: id,
                },
                dataType: 'json',
                success: function (response) {
                    var len = response['bkbrch'].length;
                    var child1 = $('#' + mhtml).children();
                    var child2 = child1.find('div').children();
                    child2.empty();
                    // TABLE SEARCH FILTER
                    if (len != 0) {
                        $('#' + html).empty();
                        $('#' + html).append("<option value='0'>-- Select A Branch --</option>");
                        child2.append("<li data-original-index=\"0\"><a tabindex=\"0\" class=\"\" data-tokens=\"null\" role=\"option\" aria-disabled=\"false\" aria-selected=\"true\"><span class=\"text\">-- Select A Branch --\n" +
                            "</span><span class=\" fa fa-check check-mark\"></span></a></li>");
                        for (var a = 0; a < len; a++) {
                            var id = response['bkbrch'][a]['brid'];
                            var name = response['bkbrch'][a]['brcd'] + " - " + response['bkbrch'][a]['bcnm'];
                            var $el = $('#' + html);
                            $el.append($("<option></option>")
                                .attr("value", id).text(name));

                            child2.append("<li data-original-index=\"" + (a + 1) + "\"><a tabindex=\"0\" class=\"\" data-tokens=\"null\" role=\"option\" aria-disabled=\"false\" aria-selected=\"true\"><span class=\"text\">" + name + "\n" +
                                "</span><span class=\" fa fa-check check-mark\"></span></a></li>");
                        }
                        //document.getElementById('brnmEdt').value = 15;
                    } else {
                        $('#' + html).empty();
                        $('#' + html).append("<option value='0'>-- No Branch --</option>");
                        child2.append("<li data-original-index=\"0\" class=\"\"><a tabindex=\"0\" class=\"\" data-tokens=\"null\" role=\"option\" aria-disabled=\"false\" aria-selected=\"false\"><span class=\"text\">-- No Branch --</span><span class=\" fa fa-check check-mark\"></span></a></li>");
                    }
                    default_Selector(child1.find('div'));
                }
            });
        }

        //Add New Supplier
        $('#add_sup_btn').click(function (e) {
            e.preventDefault();
            if ($('#add_sup_form').valid()) {
                $('#add_sup_btn').prop('disabled', true);
                swal({
                    title: "Processing...",
                    text: "Supplier's data saving..",
                    imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                    showConfirmButton: false
                });

                jQuery.ajax({
                    type: "POST",
                    url: "<?= base_url(); ?>Stock/supp_Regist",
                    data: $("#add_sup_form").serialize(),
                    dataType: 'json',
                    success: function (data) {
                        swal({title: "", text: "Registration Success!", type: "success"},
                            function () {
                                $('#add_sup_btn').prop('disabled', false);
                                clear_Form('add_sup_form');
                                $('#modal-add').modal('hide');
                                srch_Supp();
                            });
                    },
                    error: function (data, textStatus) {
                        swal({title: "Registration Failed", text: textStatus, type: "error"},
                            function () {
                                location.reload();
                            });
                    }
                });
            }
        });

        //Search Suppliers
        function srch_Supp() {
            var stat = $('#stat').val();
            $('#supp_table').DataTable().clear();
            $('#supp_table').DataTable({
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
                    {className: "text-left", "targets": [2, 3, 5]},
                    {className: "text-center", "targets": [0, 1, 4, 6, 7, 8]},
                    {className: "text-right", "targets": [0]},
                    {className: "text-nowrap", "targets": [2, 3]},
                ],
                "order": [[6, "DESC"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '3%'}, //#
                    {sWidth: '5%'}, //Code
                    {sWidth: '15%'}, //Name
                    {sWidth: '15%'}, //Address
                    {sWidth: '10%'}, //Mobile
                    {sWidth: '10%'}, //Created By
                    {sWidth: '10%'}, //Created date
                    {sWidth: '8%'}, //Status
                    {sWidth: '12%'} //Option
                ],

                "ajax": {
                    url: '<?= base_url(); ?>Stock/searchSupp',
                    type: 'post',
                    data: {
                        stat: stat
                    }
                }
            });
        }

        //View Supplier
        function viewSupp(id, func) {
            swal({
                title: "Loading Data...",
                text: "Supplier's Details",
                imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                showConfirmButton: false
            });

            $('#func').val(func);
            $('#spid').val(id);

            jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>Stock/get_SuppDet",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (data) {
                    if (func == 'view') {
                        //VIEW MODEL
                        $('#subTitle_edit').html(' - View');
                        $('#app_sup_btn').css('display', 'none');
                        $("#modal-view").find('.edit_req').css("display", "none");
                        $("#edit_Area").css('display', 'none');
                        $(".view_Area").css('display', 'block');
                        //Make readonly all fields
                        $("#modal-view :input").attr("readonly", true);
                        $("#modal-view").find('.bootstrap-select').addClass("disabled dropup");
                        $("#modal-view").find('.bootstrap-select').children().addClass("disabled dropup");
                        var des = "disabled";
                        $("#bnkDtlEdt").attr("disabled", true);
                        //VIEW MODEL
                    } else if (func == 'edit') {
                        //EDIT MODEL
                        $('#subTitle_edit').html(' - Edit');
                        $('#app_sup_btn').css('display', 'inline');
                        $('#app_sup_btn').html('Update');
                        $("#modal-view").find('.edit_req').css("display", "inline");
                        $("#edit_Area").css('display', 'block');
                        $(".view_Area").css('display', 'none');
                        //Remove readonly all fields
                        $("#modal-view :input").attr("readonly", false);
                        $("#modal-view").find('.bootstrap-select').removeClass("disabled dropup");
                        $("#modal-view").find('.bootstrap-select').children().removeClass("disabled dropup");
                        var des = "";
                        $("#bnkDtlEdt").attr("disabled", false);
                        //EDIT MODEL
                    } else if (func == 'app') {
                        //APPROVE MODEL
                        $('#subTitle_edit').html(' - Approve');
                        $('#app_sup_btn').css('display', 'inline');
                        $('#app_sup_btn').html('Approve');
                        $("#modal-view").find('.edit_req').css("display", "inline");
                        $("#edit_Area").css('display', 'block');
                        $(".view_Area").css('display', 'none');
                        //Remove readonly all fields
                        $("#modal-view :input").attr("readonly", false);
                        $("#modal-view").find('.bootstrap-select').removeClass("disabled dropup");
                        $("#modal-view").find('.bootstrap-select').children().removeClass("disabled dropup");
                        var des = "";
                        $("#bnkDtlEdt").attr("disabled", false);
                        //APPROVE MODEL
                    }
                    var len = data['spdet'].length;
                    var len2 = data['bkdet'].length;
                    var spdet = data['spdet'];
                    var bkdet = data['bkdet'];
                    if (len > 0) {
                        $('#name_edt').val(spdet[0]['spnm']);
                        $('#addr_edt').val(spdet[0]['addr']);
                        $('#mobi_edt').val(spdet[0]['mbno']);
                        $('#tele_edt').val(spdet[0]['tele']);
                        $('#email_edt').val(spdet[0]['email']);
                        $('#remk_edt').val(spdet[0]['dscr']);

                        if (spdet[0]['stat'] == 0) {
                            var stat = "<label class='label label-warning'>Pending</label>";
                        } else if (spdet[0]['stat'] == 1) {
                            var stat = "<label class='label label-success'>Active</label>";
                        } else if (spdet[0]['stat'] == 2) {
                            var stat = "<label class='label label-danger'>Reject</label>";
                        } else if (spdet[0]['stat'] == 3) {
                            var stat = "<label class='label label-info'>Inactive</label>";
                        } else {
                            var stat = "--";
                        }
                        $('#sup_stat').html(": " + stat);
                        $('#code').html(": " + spdet[0]['spcd']);
                        $('#crby').html(": " + spdet[0]['crnm']);
                        $('#crdt').html(": " + spdet[0]['crdt']);
                        $('#apby').html(": " + ((spdet[0]['apnm'] != null) ? spdet[0]['apnm'] : "--"));
                        $('#apdt').html(": " + ((spdet[0]['apdt'] != null && spdet[0]['apdt'] != "0000-00-00 00:00:00") ? spdet[0]['apdt'] : "--"));
                        $('#rjby').html(": " + ((spdet[0]['rjnm'] != null) ? spdet[0]['rjnm'] : "--"));
                        $('#rjdt').html(": " + ((spdet[0]['rjdt'] != null && spdet[0]['rjdt'] != "0000-00-00 00:00:00") ? spdet[0]['rjdt'] : "--"));
                        $('#mdby').html(": " + ((spdet[0]['mdnm'] != null) ? spdet[0]['mdnm'] : "--"));
                        $('#mddt').html(": " + ((spdet[0]['mddt'] != null && spdet[0]['mddt'] != "0000-00-00 00:00:00") ? spdet[0]['mddt'] : "--"));

                        if (spdet[0]['bkdt'] == 1) {
                            $('#bankDtilEdt').css("display", "block");
                            ($('#bnkDtlEdt').prop('checked', true));
                        } else {
                            $('#bankDtilEdt').css("display", "none");
                            ($('#bnkDtlEdt').prop('checked', false));
                        }
                    }

                    if (len2 > 0) {

                        $('#supp_Bank').DataTable().clear();
                        var t1 = $('#supp_Bank').DataTable({
                            "bInfo": false,
                            destroy: true,
                            searching: false,
                            bPaginate: false,
                            "ordering": false,
                            "columnDefs": [
                                {className: "text-right", "targets": []},
                                {className: "text-left", "targets": [0, 1, 2]},
                                {className: "text-center", "targets": [3]},
                                {className: "text-nowrap", "targets": [0, 1, 2]}
                            ],
                            "aoColumns": [
                                // {sWidth: '3%'},
                                {sWidth: '30%'},
                                {sWidth: '30%'},
                                {sWidth: '30%'},
                                {sWidth: '10%'}
                            ]
                        });

                        for (var ii = 0; ii < len2; ii++) {
                            if (bkdet[ii]['dfst'] == 1) {
                                var dfst = "<label class='label label-info' title='Default Account Number'>D</label> ";
                                var radio = "<div title='Default Account' class='app-radio round'><input type='radio'" +
                                    "onclick='desDefClose($(this))'" + des +
                                    " name='dfstRd[]' value='" + bkdet[ii]['acid'] + "' checked/></div>"
                                var defDes = 'disabled';
                            } else {
                                var dfst = "";
                                var radio = "<div class='app-radio round'><input type='radio'" +
                                    "onclick='desDefClose($(this))'" + des +
                                    " name='dfstRd[]' value='" + bkdet[ii]['acid'] + "'/></div>"
                                var defDes = '';
                            }

                            var bnknm = bkdet[ii]['bkcd'] + " - " + bkdet[ii]['bknm'];
                            var brnm = bkdet[ii]['brcd'] + " - " + bkdet[ii]['bcnm'];
                            var acc = dfst + bkdet[ii]['acno'];
                            var opt = "<button " + defDes + " " + des + " id='dltrw' class='btn btn-xs btn-warning btn-rounded btn_dlt_acc' title='Remove'><span class='fa fa-close'></span></button> " +
                                radio +
                                "<input type='hidden' id='acnoList' name='acnoList[]' value='" + bkdet[ii]['acid'] + "'/>";
                            t1.row.add([
                                // (ii+1),
                                bnknm,
                                brnm,
                                acc,
                                opt
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

        //Disbled default account close button
        function desDefClose(node) {
            $('.btn_dlt_acc').prop('disabled', false);
            node.parent().prev().prop('disabled', true);
        }

        // table data remove
        $('#supp_Bank tbody').on('click', '#dltrw', function () {
            var table = $('#supp_Bank').DataTable();
            table
                .row($(this).parents('tr'))
                .remove()
                .draw();

            if (!table.data().count()) {
                $("#app_sup_btn").hide();
            } else {
                $("#app_sup_btn").show();
            }
        });

        //APPROVE || EDIT HERE
        $('#app_sup_btn').click(function (e) {
            e.preventDefault();

            var table = $('#supp_Bank').DataTable();
            //var row = table.rows().count();

            if (table.rows().count() > 0) {
                if ($('#app_sup_form').valid()) {

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
                                $('#app_sup_btn').prop('disabled', true);
                                if (func == 'edit') {
                                    swal({
                                        title: "Processing...",
                                        text: "Supplier's details updating..",
                                        imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                                        showConfirmButton: false
                                    });

                                    jQuery.ajax({
                                        type: "POST",
                                        url: "<?= base_url(); ?>Stock/supp_update",
                                        data: $("#app_sup_form").serialize(),
                                        dataType: 'json',
                                        success: function (data) {
                                            swal({title: "", text: "Updating Success!", type: "success"},
                                                function () {
                                                    $('#app_sup_btn').prop('disabled', false);
                                                    clear_Form('app_sup_form');
                                                    $('#modal-view').modal('hide');
                                                    srch_Supp();
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
                                        text: "Supplier approving..",
                                        imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                                        showConfirmButton: false
                                    });

                                    jQuery.ajax({
                                        type: "POST",
                                        url: "<?= base_url(); ?>Stock/supp_update",
                                        data: $("#app_sup_form").serialize(),
                                        dataType: 'json',
                                        success: function (data) {
                                            swal({title: "", text: "Approved!", type: "success"},
                                                function () {
                                                    $('#app_sup_btn').prop('disabled', false);
                                                    clear_Form('app_sup_form');
                                                    $('#modal-view').modal('hide');
                                                    srch_Supp();
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
            } else {
                swal("No Any bank Details..", "", "info");
            }
        });

        //Add New bank Account Number
        $('#add_new_acc').click(function (e) {
            if ($('#edit_bank_form').valid()) {
                swal({
                    title: "Processing...",
                    text: "Supplier's account number saving..",
                    imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                    showConfirmButton: false
                });

                var spid = $('#spid').val();
                $('#add_new_acc').prop('disabled', true);

                jQuery.ajax({
                    type: "POST",
                    url: "<?= base_url(); ?>Stock/supp_add_bnkAcc",
                    data: {
                        spid: spid,
                        bknm: function () {
                            return $('#bnknm_edt').val();
                        },
                        bkbr: function () {
                            return $('#bnkbr_edt').val();
                        },
                        acc: function () {
                            return $('#acno_edt').val();
                        },
                    },
                    dataType: 'json',
                    success: function (data) {
                        swal({title: "", text: "Saved!", type: "success"},
                            function () {
                                $('#add_new_acc').prop('disabled', false);
                                clear_Form('edit_bank_form');
                                $('#modal-Bank-New').modal('hide');
                                var len2 = data['accDet'].length;
                                var bkdet = data['accDet'];

                                $('#supp_Bank').DataTable().clear();
                                var t1 = $('#supp_Bank').DataTable();

                                for (var ii = 0; ii < len2; ii++) {
                                    if (bkdet[ii]['dfst'] == 1) {
                                        var dfst = "<label class='label label-info' title='Default Account Number'>D</label> ";
                                        var radio = "<div title='Default Account' class='app-radio round'><input type='radio'" +
                                            "onclick='desDefClose($(this))'" +
                                            " name='dfstRd[]' value='" + bkdet[ii]['acid'] + "' checked/></div>"
                                        var defDes = 'disabled';
                                    } else {
                                        var dfst = "";
                                        var radio = "<div class='app-radio round'><input type='radio'" +
                                            "onclick='desDefClose($(this))'" +
                                            " name='dfstRd[]' value='" + bkdet[ii]['acid'] + "'/></div>"
                                        var defDes = '';
                                    }

                                    var bnknm = bkdet[ii]['bkcd'] + " - " + bkdet[ii]['bknm'];
                                    var brnm = bkdet[ii]['brcd'] + " - " + bkdet[ii]['bcnm'];
                                    var acc = dfst + bkdet[ii]['acno'];
                                    var opt = "<button " + defDes + " id='dltrw' class='btn btn-xs btn-warning btn-rounded btn_dlt_acc' title='Remove'><span class='fa fa-close'></span></button> " +
                                        radio +
                                        "<input type='hidden' id='acnoList' name='acnoList[]' value='" + bkdet[ii]['acid'] + "'/>";
                                    t1.row.add([
                                        // (ii+1),
                                        bnknm,
                                        brnm,
                                        acc,
                                        opt
                                    ]).draw(false);
                                }
                            });
                        //console.log(" awaaa");
                        $("#app_sup_btn").show();
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

        //Reject Supplier
        function rejectSupp(id) {
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
                                        srch_Supp();
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
        function inactSupp(id) {
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
                                        srch_Supp();
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
        function reactSupp(id) {
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
                                        srch_Supp();
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

        // supply bank details show hide
        function loadBnkDit() {
            if ($('#bnkDtl').prop('checked')) {
                $('#bankDtil').css("display", "block");
            } else {
                $('#bankDtil').css("display", "none");
            }
        }

        // supply bank details show hide edit
        function loadBnkDitEdt() {
            if ($('#bnkDtlEdt').prop('checked')) {
                $('#bankDtilEdt').css("display", "block");
            } else {
                $('#bankDtilEdt').css("display", "none");
            }
        }

    </script>
</div>
<!-- END PAGE CONTAINER -->
