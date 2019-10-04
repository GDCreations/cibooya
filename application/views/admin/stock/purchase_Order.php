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
        </div>
    </div>
    <div class="block">
        <div class="row form-horizontal">
            <div class="table-responsive">
                <table id="pom_table" class="table dataTable table-striped table-bordered" width="100%">
                    <thead>
                    <tr>
                        <th class="text-left">#</th>
                        <th class="text-left">CODE</th>
                        <th class="text-left">TYPE</th>
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
        </div>
    </div>

    <!-- MODAL ADD NEW BRAND -->
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
                                            <input type="text" name="refd" id="refd" class="form-control"
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
                                                    onchange="chckBtn(this.value,this.id); getScale(this.value)">
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
                                            <input type="text" id="cnty" name="cnty" class="form-control"
                                                   placeholder="Quantity"/>
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
    <!-- END ADD NEW BRAND -->

    <!-- MODAL VIEW BRAND -->
    <div class="modal fade" id="modal-view" tabindex="-1" role="dialog" aria-labelledby="modal-default-header">
        <div class="modal-dialog" role="document">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"
                                                                                              class="icon-cross"></span>
            </button>
            <form id="app_po_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> Type
                            Management <span class="text-muted" id="subTitle_edit"></span></h4>
                        <input type="hidden" id="func" name="func"/>
                        <input type="hidden" id="poid" name="poid"/>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="form-horizontal">
                                <div class="col-md-12">

                                </div>
                            </div>
                            <div class="form-horizontal view_Area">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Status</label>
                                        <label class="col-md-8 control-label" id="typ_stat"></label>
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
                        <button type="button" id="app_po_btn" class="btn btn-warning btn-sm btn-rounded">
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END VIEW BRAND -->

    <script type="text/javascript">
        var mainVal, subVal;
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
                    {sWidth: '8%'},
                    {sWidth: '10%'},
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
                    dsrt: {
                        currency: true
                    },
                    dsvl: {
                        currency: true
                    },
                    txrt: {
                        notEqual: 0,
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

            $('#app_typ_form').validate({
                rules: {
                    name_edt: {
                        required: true,
                        remote: {
                            url: "<?= base_url(); ?>Stock/chk_typName",
                            type: "post",
                            data: {
                                name: function () {
                                    return $("#name_edt").val();
                                },
                                tpid: function () {
                                    return $("#tpid").val();
                                },
                                stat: 1
                            }
                        }
                    },
                    code_edt: {
                        required: true,
                        minlength: 3,
                        maxlength: 3,
                        remote: {
                            url: "<?= base_url(); ?>Stock/chk_typCode",
                            type: "post",
                            data: {
                                code: function () {
                                    return $("#code_edt").val();
                                },
                                tpid: function () {
                                    return $("#tpid").val();
                                },
                                stat: 1
                            }
                        }
                    }
                },
                messages: {
                    name_edt: {
                        required: "Enter type name",
                        remote: "Already entered name"
                    },
                    code_edt: {
                        required: "Enter type code",
                        remote: "Already entered code"
                    }
                }
            });
            srch_Typ();
        });

        //Get Scale
        function getScale(id) {
            for (var it = 0; it < scale.length; it++) {
                if (scale[it][0] == id) {
                    $('#stScale').html(scale[it][1]);
                    return scale[it][1];
                }
            }
            $('#stScale').html('Quantity');
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
                    '<button type="button" class="btn btn-sm btn-warning" id="dltrw" onclick=""><span><i class="fa fa-close" title="Remove"></i></span></button>'
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

                calTtl();

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
            calTtl();
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
            var sbttl = document.getElementById('sbttl').value;
            var txvl = (+sbttl * +txrt) / 100;
            document.getElementById('vtvlEdt').value = txvl;
            calTtlEdt();
        }

        // CAL NBT VALUE
        function calNbEdt(txrt) {
            var sbttl = document.getElementById('sbttl').value;
            var txvl = (+sbttl * +txrt) / 100;
            document.getElementById('nbvlEdt').value = txvl;
            calTtlEdt();
        }

        // CAL BTT VALUE
        function calBtEdt(txrt) {
            var sbttl = document.getElementById('sbttl').value;
            var txvl = (+sbttl * +txrt) / 100;
            document.getElementById('btvlEdt').value = txvl;
            calTtlEdt();
        }

        // CAL TAX VALUE
        function calTxEdt(txrt) {
            var sbttl = document.getElementById('sbttlEdt').value;
            var txvl = (+sbttl * +txrt) / 100;
            document.getElementById('taxEdt').value = txvl;

            calTtlEdt();
        }

        // CAL TOTAL
        function calTtlEdt() {
            var sbttl = document.getElementById('sbttlEdt').value;
            var otchg = document.getElementById('otchgEdt').value;
            //var dsvl = document.getElementById('dsvlEdt').value;

            var tax = document.getElementById('taxEdt').value;
            var vtvl = document.getElementById('vtvlEdt').value;
            var nbvl = document.getElementById('nbvlEdt').value;
            var btvl = document.getElementById('btvlEdt').value;

            document.getElementById('ttlEdt').value = (+sbttl + +tax + +otchg + +vtvl + +nbvl + +btvl);

            if (document.getElementById('lengEdt').value > 0) {
                $('#app_po_btn').attr('disabled', false);
            } else {
                $('#app_po_btn').attr('disabled', true);
            }
        }

        //Add New Brand
        $('#add_po_btn').click(function (e) {
            e.preventDefault();
            subVal.resetForm();
            var valid = true;
            $('#supp,#oddt,#refd,#whs').each(function (i, v) {
                valid = mainVal.element(v) && valid;
            });

            // if ($('#add_po_form').valid()) {

            //$('#add_typ_btn').prop('disabled', true);
            //swal({
            //    title: "Processing...",
            //    text: "Type data saving..",
            //    imageUrl: "<?//= base_url() ?>//assets/img/loading.gif",
            //    showConfirmButton: false
            //});
            //
            //jQuery.ajax({
            //    type: "POST",
            //    url: "<?//= base_url(); ?>//Stock/typ_Add",
            //    data: $("#add_typ_form").serialize(),
            //    dataType: 'json',
            //    success: function (data) {
            //        swal({title: "", text: "Type Added!", type: "success"},
            //            function () {
            //                $('#add_typ_btn').prop('disabled', false);
            //                clear_Form('add_typ_form');
            //                $('#modal-add').modal('hide');
            //                srch_Typ();
            //            });
            //    },
            //    error: function (data, textStatus) {
            //        swal({title: "Failed", text: textStatus, type: "error"},
            //            function () {
            //                location.reload();
            //            });
            //    }
            //});
            // }
        });

        //Search Brand
        function srch_Typ() {
            var stat = $('#stat').val();

            $('#typ_table').DataTable().clear();
            $('#typ_table').DataTable({
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
                    {className: "text-center", "targets": [0, 1, 4, 5, 6]},
                    {className: "text-right", "targets": [0]},
                    {className: "text-nowrap", "targets": [2, 3]},
                ],
                "order": [[4, "DESC"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '3%'}, //#
                    {sWidth: '5%'}, //Code
                    {sWidth: '20%'}, //Type
                    {sWidth: '10%'}, //Created By
                    {sWidth: '10%'}, //Created date
                    {sWidth: '8%'}, //Status
                    {sWidth: '12%'} //Option
                ],

                "ajax": {
                    url: '<?= base_url(); ?>Stock/searchTyp',
                    type: 'post',
                    data: {
                        stat: stat
                    }
                }
            });
        }

        //View Type
        function viewTyp(id, func) {
            swal({
                title: "Loading Data...",
                text: "Type Details",
                imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                showConfirmButton: false
            });

            $('#func').val(func);
            $('#tpid').val(id);

            jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>Stock/get_TypDet",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (data) {
                    if (func == 'view') {
                        //VIEW MODEL
                        $('#subTitle_edit').html(' - View');
                        $('#app_typ_btn').css('display', 'none');
                        $("#modal-view").find('.edit_req').css("display", "none");
                        $("#edit_Area").css('display', 'none');
                        $(".view_Area").css('display', 'block');
                        //Make readonly all fields
                        $("#modal-view :input").attr("readonly", true);
                        //VIEW MODEL
                    } else if (func == 'edit') {
                        //EDIT MODEL
                        $('#subTitle_edit').html(' - Edit');
                        $('#app_typ_btn').css('display', 'inline');
                        $('#app_typ_btn').html('Update');
                        $("#modal-view").find('.edit_req').css("display", "inline");
                        $("#edit_Area").css('display', 'block');
                        $(".view_Area").css('display', 'none');
                        //Remove readonly all fields
                        $("#modal-view :input").attr("readonly", false);
                        //EDIT MODEL
                    } else if (func == 'app') {
                        //APPROVE MODEL
                        $('#subTitle_edit').html(' - Approve');
                        $('#app_typ_btn').css('display', 'inline');
                        $('#app_typ_btn').html('Approve');
                        $("#modal-view").find('.edit_req').css("display", "inline");
                        $("#edit_Area").css('display', 'block');
                        $(".view_Area").css('display', 'none');
                        //Remove readonly all fields
                        $("#modal-view :input").attr("readonly", false);
                        //APPROVE MODEL
                    }
                    var len = data.length;

                    if (len > 0) {
                        $('#name_edt').val(data[0]['tpnm']);
                        $('#code_edt').val(data[0]['tpcd']);
                        $('#remk_edt').val(data[0]['remk']);

                        if (data[0]['stat'] == 0) {
                            var stat = "<label class='label label-warning'>Pending</label>";
                        } else if (data[0]['stat'] == 1) {
                            var stat = "<label class='label label-success'>Active</label>";
                        } else if (data[0]['stat'] == 2) {
                            var stat = "<label class='label label-danger'>Reject</label>";
                        } else if (data[0]['stat'] == 3) {
                            var stat = "<label class='label label-info'>Inactive</label>";
                        } else {
                            var stat = "--";
                        }
                        $('#typ_stat').html(": " + stat);
                        $('#crby').html(": " + data[0]['crnm']);
                        $('#crdt').html(": " + data[0]['crdt']);
                        $('#mdby').html(": " + ((data[0]['mdnm'] != null) ? data[0]['mdnm'] : "--"));
                        $('#mddt').html(": " + ((data[0]['mddt'] != null && data[0]['mddt'] != "0000-00-00 00:00:00") ? data[0]['mddt'] : "--"));
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
        $('#app_typ_btn').click(function (e) {
            e.preventDefault();
            if ($('#app_typ_form').valid()) {
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
                            $('#app_typ_btn').prop('disabled', true);
                            if (func == 'edit') {
                                swal({
                                    title: "Processing...",
                                    text: "Type details updating..",
                                    imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                                    showConfirmButton: false
                                });

                                jQuery.ajax({
                                    type: "POST",
                                    url: "<?= base_url(); ?>Stock/typ_update",
                                    data: $("#app_typ_form").serialize(),
                                    dataType: 'json',
                                    success: function (data) {
                                        swal({title: "", text: "Updating Success!", type: "success"},
                                            function () {
                                                $('#app_typ_btn').prop('disabled', false);
                                                clear_Form('app_typ_form');
                                                $('#modal-view').modal('hide');
                                                srch_Typ();
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
                                    text: "Type approving..",
                                    imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                                    showConfirmButton: false
                                });

                                jQuery.ajax({
                                    type: "POST",
                                    url: "<?= base_url(); ?>Stock/typ_update",
                                    data: $("#app_typ_form").serialize(),
                                    dataType: 'json',
                                    success: function (data) {
                                        swal({title: "", text: "Approved!", type: "success"},
                                            function () {
                                                $('#app_typ_btn').prop('disabled', false);
                                                clear_Form('app_typ_form');
                                                $('#modal-view').modal('hide');
                                                srch_Typ();
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
        function rejectTyp(id) {
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
                            url: "<?= base_url(); ?>Stock/typ_Reject",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (data) {
                                swal({title: "", text: "Type was rejected!", type: "success"},
                                    function () {
                                        srch_Typ();
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

        //Deactivate Type
        function inactTyp(id) {
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
                            url: "<?= base_url(); ?>Stock/typ_Deactive",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (data) {
                                swal({title: "", text: "Type was deactivated!", type: "success"},
                                    function () {
                                        srch_Typ();
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

        //activate Type
        function reactTyp(id) {
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
                            url: "<?= base_url(); ?>Stock/typ_Activate",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (data) {
                                swal({title: "", text: "Type was activated!", type: "success"},
                                    function () {
                                        srch_Typ();
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
