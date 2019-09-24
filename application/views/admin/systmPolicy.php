<script type="text/javascript" src="<?= base_url(); ?>assets/js/custom-js/full_width.js"></script>

<style>
    .Stat_0 {
        pointer-events: none;
        opacity: 0.6;
    }

    .Stat_1 {
        pointer-events: auto;
        opacity: 1;
    }
</style>

<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">General</a></li>
        <li class="active">System Policy</li>
    </ul>
</div>
<div class="app-heading app-heading-bordered app-heading-page">
    <div class="icon icon-lg">
        <span class="fa fa-list-alt" style="color: #e69c0f;"></span>
    </div>
    <div class="title">
        <h1>System Policy</h1>
        <p>Policy Management</p>
    </div>
</div>
<!-- END PAGE HEADING -->

<!-- START PAGE CONTAINER -->
<div class="container">
    <div class="block">

        <form class="form-horizontal" id="policyUpdate" method="post">
            <!--            <div class="col-md-12">-->
            <table class="table table-head-custom table-striped" width="100%">
                <thead>
                <tr>
                    <th>NO</th>
                    <th>POLICY NAME</th>
                    <th>POLICY DESCRIPTION</th>
                    <th style="width: 30%">OPTION</th>
                </tr>
                </thead>

                <tbody>

                <!--<tr>
                    <td align="left" colspan="4" style="background-color: rgba(63, 186, 228,0.8"><b
                                style="color: white">CSU MODULE</b></td>
                </tr>-->
                <!-- 01 -->
                <tr class="<?= 'Stat_' . $policyinfo[0]->stat ?>">
                    <td align="center">01</td>
                    <td><strong><?= $policyinfo[0]->ponm ?></strong> (<?= $policyinfo[0]->poid ?>)
                    </td>
                    <td><?= $policyinfo[0]->pods ?> </td>
                    <td>
                        <div class="col-md-6">
                            <?php if ($policyinfo[0]->post == 1) {
                                $chk = "checked";
                                $dis1 = "block";
                            } else {
                                $chk = "";
                                $dis1 = "none";
                            } ?>
                            <label class="switch">
                                Disable <input type="checkbox" value="1" id="digey" name="digey" <?= $chk ?>
                                               onchange="eyeMd()"/>
                            </label> Enable
                        </div>
                        <div class="col-md-6" id="eyeCde" style="display: <?= $dis1; ?>">
                            <input type="text" class="form-control" value="<?= $policyinfo[0]->pov3 ?>" name="eycd"
                                   id="eycd">
                        </div>

                    </td>
                    <!--                    <input type="text" value="dd" name="sss"/>-->
                </tr>
                <!-- 02 -->
                <!-- <tr class="<? /*= 'Stat_' . $policyinfo[1]->stat */ ?>">
                    <td align="center">02</td>
                    <td><strong> <? /*= $policyinfo[1]->ponm */ ?></strong> (<? /*= $policyinfo[1]->poid */ ?>)
                    </td>
                    <td><? /*= $policyinfo[1]->pods */ ?> </td>
                    <td>
                        <div class="col-md-6"><input type="number" id="gpmb_min"
                                                     name="gpmb_min"
                                                     value="<? /*= $policyinfo[1]->pov1 */ ?>"
                                                     class="form-control" placeholder="Min">
                        </div>
                        <div class="col-md-6"><input type="number" id="gpmb_max"
                                                     name="gpmb_max"
                                                     value="<? /*= $policyinfo[1]->pov2 */ ?>"
                                                     class="form-control" placeholder="Max">
                        </div>
                    </td>
                </tr>-->

                </tbody>
            </table>

            <div class="form-group margin-top-20">
                <button class="btn btn-sm btn-rounded btn-success pull-right" type="button" id="save">Submit
                </button>
            </div>
            <!--            </div>-->
        </form>

    </div>

    <script type="text/javascript">

        $().ready(function () {
            $('#policyUpdate').validate({
                rules: {
                    eycd: {
                        required: true,
                        digits: true,
                        minlength: 6,
                        maxlength: 6
                    },
                    cadd: {
                        required: true
                    },
                    ctel: {
                        digits: true,
                        minlength: 10,
                        maxlength: 10,
                    },
                    ceml: {
                        required: true,
                        email: true
                    },
                    syln: {
                        required: true,
                    },
                    synm: {
                        required: true,
                    },
                },
                messages: {
                    eycd: {
                        required: "Enter Digital Eye Code"
                    },
                    addr: {
                        required: "Enter supplier address"
                    },
                }
            });
        });

        // DIGITAL EYE ENABLE DISABLE
        function eyeMd() {
            if ($('[name="digey"]').is(':checked')) {
                document.getElementById("eyeCde").style.display = "block";
            } else {
                document.getElementById("eyeCde").style.display = "none";
            }
        }


        //Add New Supplier
        $('#save').click(function (e) {
            e.preventDefault();
            if ($('#policyUpdate').valid()) {

                $('#save').prop('disabled', true);

                swal({
                    title: "Processing...",
                    text: "Policy Updating..",
                    imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                    showConfirmButton: false
                });

                jQuery.ajax({
                    type: "POST",
                    url: "<?= base_url(); ?>admin/updatePolicy",
                    data: $("#policyUpdate").serialize(),
                    dataType: 'json',
                    success: function (data) {
                        swal({title: "", text: "Update Success!", type: "success"},
                            function () {
                                location.reload();
                                /*$('#save').prop('disabled', false);
                                clear_Form('brandingEdt');
                                $('#modal-add').modal('hide');*/
                            });
                    },
                    error: function (data, textStatus) {
                        swal({title: "Update Failed", text: textStatus, type: "error"},
                            function () {
                                location.reload();
                            });
                    }
                });
            }
        });

    </script>
</div>
<!-- END PAGE CONTAINER -->
