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
        <p>Add / Edit / Reject / Deactive / Search & View</p>
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
                        <select id="cats" name="cats" class="bs-select">
                            <option value="0">-- Select Category --</option>
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
                        <select id="brds" name="brds" class="bs-select">
                            <option value="0">-- Select Brand --</option>
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
                                   value="<?= date('Y-m-d') ?>"/>
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
                        <select id="typs" name="typs" class="bs-select">
                            <option value="0">-- Select Type --</option>
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
                        <button class="btn btn-sm btn-primary btn-rounded btn-icon-fixed"><span
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
        <div class="modal-dialog modal-lg" role="document" style="width: 80%">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"
                                                                                              class="icon-cross"></span>
            </button>
            <form id="add_item_form" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> Add Item
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="block-content">
                                <div class="wizard show-submit">
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
                                                                echo "<option value='$stscl->slid'> (".$stscl->scl.") - ".$stscl->scnm."</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="step-2">
                                        <div class="row form-horizontal">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12">Logo</label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <input type="file" id="pics1" name="pics[]"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12">Logo</label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <input type="file" id="pics2" name="pics[]"/>
                                                    </div>
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
                        <button type="button" id="add_item_btn" class="btn btn-warning btn-xs btn-rounded">Submit
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
            <form id="app_brnd_form" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> Brand
                            Management <span class="text-muted" id="subTitle_edit"></span></h4>
                        <input type="hidden" id="func" name="func"/>
                        <input type="hidden" id="bdid" name="bdid"/>
                        <input type="hidden" id="brd_logo" name="brd_logo"/>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="form-horizontal">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Brand Name <span
                                                    class="fa fa-asterisk req-astrick edit_req"</span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input class="form-control" type="text" name="name_edt" id="name_edt"
                                                   placeholder="Brand Name"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Brand Code <span
                                                    class="fa fa-asterisk req-astrick edit_req"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input class="form-control text-uppercase" type="text" name="code_edt"
                                                   id="code_edt"
                                                   placeholder="Brand Code"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12">Logo</label>
                                        <div class="col-md-8 col-xs-12">
                                            <input type="file" id="logo_edt" name="logo_edt"/>
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
                                        <label class="col-md-8 control-label" id="brd_stat"></label>
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
                        <button type="button" id="app_brd_btn" class="btn btn-warning btn-xs btn-rounded">
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
            });
            $("#pics2").fileinput({
                allowedFileExtensions: ['jpg', 'png', 'jpeg'],
                showUpload: false,
                showCaption: false,
                browseClass: "btn btn-primary btn-sm btn-rounded",
                removeClass: "btn btn-warning btn-sm btn-rounded",
                maxFileSize: 5000, //Kb
            });

            $('#add_brnd_form').validate({
                rules: {
                    name: {
                        required: true,
                        remote: {
                            url: "<?= base_url(); ?>Stock/chk_brdName",
                            type: "post",
                            data: {
                                name: function () {
                                    return $("#name").val();
                                },
                                stat: 0
                            }
                        }
                    },
                    code: {
                        required: true,
                        minlength: 3,
                        maxlength: 3,
                        remote: {
                            url: "<?= base_url(); ?>Stock/chk_brdCode",
                            type: "post",
                            data: {
                                code: function () {
                                    return $("#code").val();
                                },
                                stat: 0
                            }
                        }
                    }
                },
                messages: {
                    name: {
                        required: "Enter brand name",
                        remote: "Already entered name"
                    },
                    code: {
                        required: "Enter brand code",
                        remote: "Already entered code"
                    }
                }
            });

            $('#app_brnd_form').validate({
                rules: {
                    name_edt: {
                        required: true,
                        remote: {
                            url: "<?= base_url(); ?>Stock/chk_brdName",
                            type: "post",
                            data: {
                                name: function () {
                                    return $("#name_edt").val();
                                },
                                bdid: function () {
                                    return $("#bdid").val();
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
                            url: "<?= base_url(); ?>Stock/chk_brdCode",
                            type: "post",
                            data: {
                                code: function () {
                                    return $("#code_edt").val();
                                },
                                bdid: function () {
                                    return $("#bdid").val();
                                },
                                stat: 1
                            }
                        }
                    }
                },
                messages: {
                    name_edt: {
                        required: "Enter brand name",
                        remote: "Already entered name"
                    },
                    code_edt: {
                        required: "Enter brand code",
                        remote: "Already entered code"
                    }
                }
            });
            srch_Brnd();
        });

        $('.buttonNext').click(function (e) {
            console.log('awa');
            e.preventDefault();
            $('.buttonFinish').css('display','none');
        })

        //Add New Brand
        $('#add_brnd_btn').click(function (e) {
            e.preventDefault();
            var formObj = document.getElementById('add_brnd_form');
            var formData = new FormData(formObj);
            if ($('#add_brnd_form').valid()) {
                $('#add_brnd_btn').prop('disabled', true);
                swal({
                    title: "Processing...",
                    text: "Brand data saving..",
                    imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                    showConfirmButton: false
                });

                jQuery.ajax({
                    type: "POST",
                    url: "<?= base_url(); ?>Stock/brnd_Add",
                    data: formData,
                    mimeType: "multipart/form-data",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        swal({title: "", text: "Brand Added!", type: "success"},
                            function () {
                                $('#add_brnd_btn').prop('disabled', false);
                                clear_Form('add_brnd_form');
                                $('#modal-add').modal('hide');
                                srch_Brnd();
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
        function srch_Brnd() {
            var stat = $('#stat').val();

            $('#brnd_table').DataTable().clear();
            $('#brnd_table').DataTable({
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
                    {className: "text-left", "targets": [3, 4]},
                    {className: "text-center", "targets": [0, 1, 2, 5, 6, 7]},
                    {className: "text-right", "targets": [0]},
                    {className: "text-nowrap", "targets": [3, 4]},
                ],
                "order": [[4, "DESC"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '3%'}, //#
                    {sWidth: '5%'}, //Code
                    {sWidth: '5%'}, //LOGO
                    {sWidth: '20%'}, //Category
                    {sWidth: '10%'}, //Created By
                    {sWidth: '10%'}, //Created date
                    {sWidth: '8%'}, //Status
                    {sWidth: '12%'} //Option
                ],

                "ajax": {
                    url: '<?= base_url(); ?>Stock/searchBrnd',
                    type: 'post',
                    data: {
                        stat: stat
                    }
                }
            });
        }

        //View Supplier
        function viewBrd(id, func) {
            swal({
                title: "Loading Data...",
                text: "Brand Details",
                imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                showConfirmButton: false
            });

            $('#func').val(func);
            $('#bdid').val(id);

            jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>Stock/get_BrdDet",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (data) {
                    if (func == 'view') {
                        //VIEW MODEL
                        $('#subTitle_edit').html(' - View');
                        $('#app_brd_btn').css('display', 'none');
                        $("#modal-view").find('.edit_req').css("display", "none");
                        $("#edit_Area").css('display', 'none');
                        $(".view_Area").css('display', 'block');
                        //Make readonly all fields
                        $("#modal-view :input").attr("readonly", true);
                        $('.file-input').css('pointer-events', 'none');
                        //VIEW MODEL
                    } else if (func == 'edit') {
                        //EDIT MODEL
                        $('#subTitle_edit').html(' - Edit');
                        $('#app_brd_btn').css('display', 'inline');
                        $('#app_brd_btn').html('Update');
                        $("#modal-view").find('.edit_req').css("display", "inline");
                        $("#edit_Area").css('display', 'block');
                        $(".view_Area").css('display', 'none');
                        //Remove readonly all fields
                        $("#modal-view :input").attr("readonly", false);
                        $('.file-input').css('pointer-events', '');
                        //EDIT MODEL
                    } else if (func == 'app') {
                        //APPROVE MODEL
                        $('#subTitle_edit').html(' - Approve');
                        $('#app_brd_btn').css('display', 'inline');
                        $('#app_brd_btn').html('Approve');
                        $("#modal-view").find('.edit_req').css("display", "inline");
                        $("#edit_Area").css('display', 'block');
                        $(".view_Area").css('display', 'none');
                        //Remove readonly all fields
                        $("#modal-view :input").attr("readonly", false);
                        $('.file-input').css('pointer-events', '');
                        //APPROVE MODEL
                    }
                    var len = data.length;

                    if (len > 0) {
                        $('#name_edt').val(data[0]['bdnm']);
                        $('#code_edt').val(data[0]['bdcd']);
                        $('#remk_edt').val(data[0]['remk']);
                        $('#brd_logo').val(data[0]['logo']);

                        //File Uploader Initialiting
                        $("#logo_edt").fileinput('enable');
                        $("#logo_edt").fileinput('destroy');
                        $("#logo_edt").fileinput({
                            allowedFileExtensions: ['jpg', 'png', 'jpeg'],
                            showUpload: false,
                            showCaption: false,
                            browseClass: "btn btn-primary btn-sm btn-rounded",
                            removeClass: "btn btn-warning btn-sm btn-rounded",
                            maxFileSize: 5000, //Kb
                            initialPreviewAsData: true,
                            initialPreview: [
                                "<?= base_url()?>uploads/img/brand/" + data[0]['logo']
                            ]
                        });

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
                        $('#brd_stat').html(": " + stat);
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
        $('#app_brd_btn').click(function (e) {
            e.preventDefault();
            var formObj = document.getElementById('app_brnd_form');
            var formData = new FormData(formObj);
            if ($('#app_brnd_form').valid()) {
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
                            $('#app_brd_btn').prop('disabled', true);
                            if (func == 'edit') {
                                swal({
                                    title: "Processing...",
                                    text: "Brand details updating..",
                                    imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                                    showConfirmButton: false
                                });

                                jQuery.ajax({
                                    type: "POST",
                                    url: "<?= base_url(); ?>Stock/brd_update",
                                    data: formData,
                                    mimeType: "multipart/form-data",
                                    contentType: false,
                                    cache: false,
                                    processData: false,
                                    success: function (data) {
                                        swal({title: "", text: "Updating Success!", type: "success"},
                                            function () {
                                                $('#app_brd_btn').prop('disabled', false);
                                                clear_Form('app_brnd_form');
                                                $('#modal-view').modal('hide');
                                                srch_Brnd();
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
                                    url: "<?= base_url(); ?>Stock/brd_update",
                                    data: formData,
                                    mimeType: "multipart/form-data",
                                    contentType: false,
                                    cache: false,
                                    processData: false,
                                    success: function (data) {
                                        swal({title: "", text: "Approved!", type: "success"},
                                            function () {
                                                $('#app_brd_btn').prop('disabled', false);
                                                clear_Form('app_brnd_form');
                                                $('#modal-view').modal('hide');
                                                srch_Brnd();
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
        function rejectBrd(id) {
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
                            url: "<?= base_url(); ?>Stock/brd_Reject",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (data) {
                                swal({title: "", text: "Brand was rejected!", type: "success"},
                                    function () {
                                        srch_Brnd();
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
        function inactBrd(id) {
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
                            url: "<?= base_url(); ?>Stock/brd_Deactive",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (data) {
                                swal({title: "", text: "Brand was deactivated!", type: "success"},
                                    function () {
                                        srch_Brnd();
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
        function reactBrd(id) {
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
                            url: "<?= base_url(); ?>Stock/brd_Activate",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (data) {
                                swal({title: "", text: "Brand was activated!", type: "success"},
                                    function () {
                                        srch_Brnd();
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
