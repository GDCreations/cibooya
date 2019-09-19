<?php
/**
 * Created by PhpStorm.
 * User: GDC
 * Date: 9/18/2019
 * Time: 12:34 PM
 */
?>

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
        <p>Subtitle</p>
    </div>
    <div class="pull-right">
        <button class="btn btn-xs btn-info btn-icon-fixed btn-rounded" data-toggle="modal" data-target="#modal-add">
            <span class="fa fa-plus"></span>Register
        </button>
    </div>
</div>
<!-- END PAGE HEADING -->

<!-- START PAGE CONTAINER -->
<div class="container">
    <div class="panel panel-default block">
        <div class="row form-horizontal">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-md-4 col-xs-12 control-label">Status</label>
                    <div class="col-md-8 col-xs-12">
                        <select id="stat" name="stat" onchange="" class="bs-select">
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
    <div class="panel panel-default block">
        <div class="row form-horizontal">
            <!--            <div class="block block-condensed">-->
            <div class="block-content table-responsive">
                <table id="supp_table" class="table table-striped table-bordered datatable-extended">
                    <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">CODE</th>
                        <th class="text-center">NAME</th>
                        <th class="text-center">ADDRESS</th>
                        <th class="text-center">MOBILE</th>
                        <th class="text-center">CREATED BY</th>
                        <th class="text-center">CREATED DATE</th>
                        <th class="text-center">STATUS</th>
                        <th class="text-center">ACTION</th>
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
                                        <label class="col-md-4 col-xs-12 control-label">Address <span class="fa fa-asterisk"
                                                                                                      style="color: red"></span></label>
                                        <div class="col-md-8 col-xs-12">
                                        <textarea class="form-control" name="addr" id="addr"
                                                  placeholder="Supplier Address"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Contact <span class="fa fa-asterisk"
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
                                        <label class="col-md-4 col-xs-12 control-label">Email <span class="fa fa-asterisk"
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
                                            <select id="bnknm" name="bnknm" onchange="getbankbrch(this.value,'bnkbr')"
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
    <!-- END MODAL DEFAULT -->
</div>
<!-- END PAGE CONTAINER -->
<script>
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
                    required: true
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
                    required: "Enter supplier name"
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
    });

    //Get Branches by Bank
    function getbankbrch(id, html) {
        $.ajax({
            url: '<?= base_url(); ?>Stock/getbnkbrch',
            type: 'post',
            data: {
                id: id,
            },
            dataType: 'json',
            success: function (response) {
                var len = response['bkbrch'].length;
                var child1 = $('#bnkbr_cont').children();
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

                        child2.append("<li data-original-index=\"" + (a+1) + "\"><a tabindex=\"0\" class=\"\" data-tokens=\"null\" role=\"option\" aria-disabled=\"false\" aria-selected=\"true\"><span class=\"text\">" + name + "\n" +
                            "</span><span class=\" fa fa-check check-mark\"></span></a></li>");
                    }
                    //document.getElementById('brnmEdt').value = 15;
                } else {
                    $('#' + html).empty();
                    $('#' + html).append("<option value='0'>-- No Branch --</option>");
                    child2.append("<li data-original-index=\"0\" class=\"\"><a tabindex=\"0\" class=\"\" data-tokens=\"null\" role=\"option\" aria-disabled=\"false\" aria-selected=\"false\"><span class=\"text\">-- No Branch --</span><span class=\" fa fa-check check-mark\"></span></a></li>");
                }
            }
        });
    }

    //Add New Supplier
    $('#add_sup_btn').click(function (e) {
        e.preventDefault();
        if ($('#add_sup_form').valid()) {
            $('#add_sup_btn').prop('disabled',true);
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
                            $('#add_sup_btn').prop('disabled',false);
                            clear_Form('add_sup_form');
                            $('#modal-add').modal('hide');
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
                {className: "text-left", "targets": [2, 3, 6]},
                {className: "text-center", "targets": [0, 1, 4, 5, 7, 8, 9]},
                {className: "text-right", "targets": [0]},
                {className: "text-nowrap", "targets": [1]}
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
</script>
