<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">Stock Components</a></li>
        <li class="active">Category Management</li>
    </ul>
</div>
<div class="app-heading app-heading-bordered app-heading-page">
    <div class="icon icon-lg">
        <span class="fa fa-th-large" style="color: #e69c0f;"></span>
    </div>
    <div class="title">
        <h1>Category Management</h1>
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
                    <label class="col-md-4 col-xs-12 control-label">Status</label>
                    <div class="col-md-8 col-xs-12">
                        <select id="stat" name="stat" onchange="srch_Cat();" class="bs-select">
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
                <table id="cat_table" class="table dataTable table-striped table-bordered" width="100%">
                    <thead>
                    <tr>
                        <th class="text-left">#</th>
                        <th class="text-left">CODE</th>
                        <th class="text-left">CATEGORY</th>
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

    <!-- MODAL ADD NEW SUPPLIER -->
    <div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modal-default-header">
        <div class="modal-dialog" role="document">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"
                                                                                              class="icon-cross"></span>
            </button>
            <form id="add_cat_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> Add New Category</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row form-horizontal">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Category Name <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input class="form-control" type="text" name="name" id="name"
                                                   placeholder="Category Name"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Category Code <span
                                                    class="fa fa-asterisk req-astrick"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input class="form-control text-uppercase" type="text" name="code" id="code"
                                                   placeholder="Category Code"/>
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
                                        class="fa fa-asterisk req-astrick"></span> Required Fields </label>
                        </div>
                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                        <button type="button" id="add_cat_btn" class="btn btn-warning btn-sm btn-rounded">Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END ADD NEW SUPPLIER -->

    <!-- MODAL VIEW SUPPLIER -->
    <div class="modal fade" id="modal-view" tabindex="-1" role="dialog" aria-labelledby="modal-default-header">
        <div class="modal-dialog" role="document">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"
                                                                                              class="icon-cross"></span>
            </button>
            <form id="app_cat_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span> Category
                            Management <span class="text-muted" id="subTitle_edit"></span></h4>
                        <input type="hidden" id="func" name="func"/>
                        <input type="hidden" id="ctid" name="ctid"/>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="form-horizontal">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Category Name <span
                                                    class="fa fa-asterisk req-astrick edit_req"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input class="form-control" type="text" name="name_edt" id="name_edt"
                                                   placeholder="Category Name"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Category Code <span
                                                    class="fa fa-asterisk req-astrick edit_req"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                            <input class="form-control text-uppercase" type="text" name="code_edt" id="code_edt"
                                                   placeholder="Category Code"/>
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
                                        <label class="col-md-8 control-label" id="cat_stat"></label>
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
                        <button type="button" id="app_cat_btn" class="btn btn-warning btn-sm btn-rounded">
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END VIEW SUPPLIER -->

    <script type="text/javascript">
        $().ready(function () {
            //Table Initializing
            $('#cat_table').DataTable({
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                "aoColumns": [
                    {sWidth: '3%'},
                    {sWidth: '5%'},
                    {sWidth: '20%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '8%'},
                    {sWidth: '12%'}
                ],
            });

            $('#add_cat_form').validate({
                rules: {
                    name: {
                        required: true,
                        remote: {
                            url: "<?= base_url(); ?>Stock/chk_catName",
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
                        minlength: 4,
                        maxlength: 4,
                        remote: {
                            url: "<?= base_url(); ?>Stock/chk_catCode",
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
                        required: "Enter category name",
                        remote: "Already entered name"
                    },
                    code: {
                        required: "Enter category code",
                        remote: "Already entered code"
                    }
                }
            });

            $('#app_cat_form').validate({
                rules: {
                    name_edt: {
                        required: true,
                        remote: {
                            url: "<?= base_url(); ?>Stock/chk_catName",
                            type: "post",
                            data: {
                                name: function () {
                                    return $("#name_edt").val();
                                },
                                ctid: function () {
                                    return $("#ctid").val();
                                },
                                stat: 1
                            }
                        }
                    },
                    code_edt: {
                        required: true,
                        minlength: 4,
                        maxlength: 4,
                        remote: {
                            url: "<?= base_url(); ?>Stock/chk_catCode",
                            type: "post",
                            data: {
                                code: function () {
                                    return $("#code_edt").val();
                                },
                                ctid: function () {
                                    return $("#ctid").val();
                                },
                                stat: 1
                            }
                        }
                    }
                },
                messages: {
                    name_edt: {
                        required: "Enter category name",
                        remote: "Already entered name"
                    },
                    code_edt: {
                        required: "Enter category code",
                        remote: "Already entered code"
                    }
                }
            });

            srch_Cat();
        });

        //Add New Supplier
        $('#add_cat_btn').click(function (e) {
            e.preventDefault();
            if ($('#add_cat_form').valid()) {
                $('#add_cat_btn').prop('disabled', true);
                swal({
                    title: "Processing...",
                    text: "Category data saving..",
                    imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                    showConfirmButton: false
                });

                jQuery.ajax({
                    type: "POST",
                    url: "<?= base_url(); ?>Stock/cat_Add",
                    data: $("#add_cat_form").serialize(),
                    dataType: 'json',
                    success: function (data) {
                        swal({title: "", text: "Category Added!", type: "success"},
                            function () {
                                $('#add_cat_btn').prop('disabled', false);
                                clear_Form('add_cat_form');
                                $('#modal-add').modal('hide');
                                srch_Cat();
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

        //Search Suppliers
        function srch_Cat() {
            var stat = $('#stat').val();
            $('#cat_table').DataTable().clear();
            $('#cat_table').DataTable({
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
                    {sWidth: '20%'}, //Name
                    {sWidth: '10%'}, //Created By
                    {sWidth: '10%'}, //Created date
                    {sWidth: '8%'}, //Status
                    {sWidth: '12%'} //Option
                ],

                "ajax": {
                    url: '<?= base_url(); ?>Stock/searchCat',
                    type: 'post',
                    data: {
                        stat: stat
                    }
                }
            });
        }

        //View Supplier
        function viewCat(id, func) {
            swal({
                title: "Loading Data...",
                text: "Category Details",
                imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                showConfirmButton: false
            });

            $('#func').val(func);
            $('#ctid').val(id);

            jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>Stock/get_CatDet",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (data) {
                    if (func == 'view') {
                        //VIEW MODEL
                        $('#subTitle_edit').html(' - View');
                        $('#app_cat_btn').css('display', 'none');
                        $("#modal-view").find('.edit_req').css("display", "none");
                        $("#edit_Area").css('display', 'none');
                        $(".view_Area").css('display', 'block');
                        //Make readonly all fields
                        $("#modal-view :input").attr("readonly", true);
                        //VIEW MODEL
                    } else if (func == 'edit') {
                        //EDIT MODEL
                        $('#subTitle_edit').html(' - Edit');
                        $('#app_cat_btn').css('display', 'inline');
                        $('#app_cat_btn').html('Update');
                        $("#modal-view").find('.edit_req').css("display", "inline");
                        $("#edit_Area").css('display', 'block');
                        $(".view_Area").css('display', 'none');
                        //Remove readonly all fields
                        $("#modal-view :input").attr("readonly", false);
                        //EDIT MODEL
                    } else if (func == 'app') {
                        //APPROVE MODEL
                        $('#subTitle_edit').html(' - Approve');
                        $('#app_cat_btn').css('display', 'inline');
                        $('#app_cat_btn').html('Approve');
                        $("#modal-view").find('.edit_req').css("display", "inline");
                        $("#edit_Area").css('display', 'block');
                        $(".view_Area").css('display', 'none');
                        //Remove readonly all fields
                        $("#modal-view :input").attr("readonly", false);
                        //APPROVE MODEL
                    }
                    var len = data.length;

                    if (len > 0) {
                        $('#name_edt').val(data[0]['ctnm']);
                        $('#code_edt').val(data[0]['ctcd']);
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
                        $('#cat_stat').html(": " + stat);
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
        $('#app_cat_btn').click(function (e) {
            e.preventDefault();
            if ($('#app_cat_form').valid()) {

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
                            $('#app_cat_btn').prop('disabled', true);
                            if (func == 'edit') {
                                swal({
                                    title: "Processing...",
                                    text: "Category details updating..",
                                    imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                                    showConfirmButton: false
                                });

                                jQuery.ajax({
                                    type: "POST",
                                    url: "<?= base_url(); ?>Stock/cat_update",
                                    data: $("#app_cat_form").serialize(),
                                    dataType: 'json',
                                    success: function (data) {
                                        swal({title: "", text: "Updating Success!", type: "success"},
                                            function () {
                                                $('#app_cat_btn').prop('disabled', false);
                                                clear_Form('app_cat_form');
                                                $('#modal-view').modal('hide');
                                                srch_Cat();
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
                                    text: "Category approving..",
                                    imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                                    showConfirmButton: false
                                });

                                jQuery.ajax({
                                    type: "POST",
                                    url: "<?= base_url(); ?>Stock/cat_update",
                                    data: $("#app_cat_form").serialize(),
                                    dataType: 'json',
                                    success: function (data) {
                                        swal({title: "", text: "Approved!", type: "success"},
                                            function () {
                                                $('#app_cat_btn').prop('disabled', false);
                                                clear_Form('app_cat_form');
                                                $('#modal-view').modal('hide');
                                                srch_Cat();
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
        function rejectCat(id) {
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
                            url: "<?= base_url(); ?>Stock/cat_Reject",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (data) {
                                swal({title: "", text: "Category was rejected!", type: "success"},
                                    function () {
                                        srch_Cat();
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
        function inactCat(id) {
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
                            url: "<?= base_url(); ?>Stock/cat_Deactive",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (data) {
                                swal({title: "", text: "Category was deactivated!", type: "success"},
                                    function () {
                                        srch_Cat();
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
        function reactCat(id) {
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
                            url: "<?= base_url(); ?>Stock/cat_Activate",
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (data) {
                                swal({title: "", text: "Category was activated!", type: "success"},
                                    function () {
                                        srch_Cat();
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
