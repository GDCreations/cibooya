<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">General</a></li>
        <li class="active">Branding</li>
    </ul>
</div>
<div class="app-heading app-heading-bordered app-heading-page">
    <div class="icon icon-lg">
        <span class="fa fa-bank" style="color: #e69c0f;"></span>
    </div>
    <div class="title">
        <h1>Branding</h1>
        <p>Company Information</p>
    </div>
</div>
<!-- END PAGE HEADING -->

<!-- START PAGE CONTAINER -->
<div class="container">
    <div class="block">

        <form class="form-horizontal" name="" method="post">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-4 control-label">Company Name</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" value="<?= $compInfo[0]->cmne ?>" name="cmne">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Company Address</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" value="<?= $compInfo[0]->cadd ?>" name="cadd">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Company Phone</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" value="<?= $compInfo[0]->ctel ?>" name="ctel">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">System Link</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" value="<?= $compInfo[0]->syln ?>" name="syln">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-4 control-label">System Name</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" value="<?= $compInfo[0]->synm ?>" name="synm">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Email</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" value="<?= $compInfo[0]->ceml ?>" name="ceml">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Register Date</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" value="<?= $compInfo[0]->regd ?>" name="regd">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Web Mail Link</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" value="<?= $compInfo[0]->wbml ?>" name="wbml">
                    </div>
                </div>

                <div class="form-group margin-top-20">
                    <button class="btn btn-success pull-right" type="submit">Submit</button>
                </div>
            </div>
        </form>

    </div>
</div>
<!-- END PAGE CONTAINER -->

<script>

    $().ready(function () {
        $('#add_sup_form').validate({
            rules: {
                name:{
                    required : true
                },
                addr:{
                    required: true
                },
                mobi:{
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
                tele:{
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
                bnknm:{
                    notEqual: 0
                },
                bnkbr:{
                    notEqual: 0
                },
                acno:{
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
                name:{
                    required : "Enter supplier name"
                },
                addr:{
                    required: "Enter supplier address"
                },
                mobi:{
                    required: "Enter mobile number",
                    digits: "Only numbers are allowed",
                    minlength: "Please enter 10 digits number",
                    maxlength: "Please enter 10 digits number",
                    remote: "This number is already added"
                },
                tele:{
                    digits: "Only numbers are allowed",
                    minlength: "Please enter 10 digits number",
                    maxlength: "Please enter 10 digits number",
                    remote: "This number is already added"
                },
                email: {
                    required: "Enter email address",
                    email: "Please enter valid email address"
                },
                bnknm:{
                    notEqual: "Select a bank"
                },
                bnkbr:{
                    notEqual: "Select a bank branch"
                },
                acno:{
                    required: "Enter bank account number",
                    digits: "Only numbers are allowed",
                    minlength: "Minumum length is 8 digits",
                    remote: "This account number is already added"
                }
            }
        });
    });

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

</script>
