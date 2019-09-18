<!DOCTYPE html>
<html lang="en">
<head>
    <title>Welcome to <?= $sysinfo[0]->synm ?></title>

    <!-- META SECTION -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="<?= base_url(); ?>assets/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?= base_url(); ?>assets/img/favicon.ico" type="image/x-icon">
    <!-- END META SECTION -->
    <!-- CSS INCLUDE -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/styles.css">
    <!-- EOF CSS INCLUDE -->
</head>
<body>

<!-- APP WRAPPER -->
<div class="app app-fh">

    <!-- START APP CONTAINER -->
    <div class="app-container"
         style="background: url(assets/images/background/bg-1.jpg) center center no-repeat fixed;">

        <div class="app-login-box" style="margin-top: 8%">
            <div class="app-login-box-user"><img src="<?= base_url(); ?>assets/img/user/no-image.png"></div>
            <div class="app-login-box-title">
                <div class="title">Already a member?</div>
                <div class="subtitle">Sign in to your account</div>
            </div>
            <div class="app-login-box-container">
                <form action="<?= base_url(); ?>login/loginMe" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" name="lognm" id="lognm" placeholder="Username"
                               data-validation="required">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="logps" id="logps" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="logcd" id="logcd" placeholder="Digital Code">
                    </div>


                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6 col-xs-6">
                            </div>
                            <div class="col-md-6 col-xs-6">
                                <button class="btn btn-success btn-block">Sign In</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>

            <div class="app-login-box-footer">
                &copy; <?= $sysinfo[0]->synm . ' '.date('Y')?>. All rights reserved.
            </div>
        </div>

    </div>
    <!-- END APP CONTAINER -->

</div>
<!-- END APP WRAPPER -->

<!-- IMPORTANT SCRIPTS -->
<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/jquery/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/bootstrap/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/form-validator/jquery.form-validator.min.js"></script>

<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/moment/moment.min.js"></script>

</body>
</html>

<script src="<?= base_url(); ?>assets/plugins/toastr/toastr.min.js" type="text/javascript"></script>
<link href="<?= base_url(); ?>assets/plugins/toastr/toastr.css" rel="stylesheet" type="text/css"/>


<script type="text/javascript">
    // Toastr options
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-center",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "400",
        "hideDuration": "400",
        "timeOut": "3000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };


    $().ready(function () {

    });

</script>

<?php

if (isset($_GET['message'])) {
    $message = $_GET['message'];

    if ($message === "fail") {
        ?>
        <script type="text/javascript">
            //toastr.error('Error - Wrong login data!');
            toastr.error('Please check login data !');
        </script>
        <?php
    }else if ($message === "userlock") {
        ?>
        <script type="text/javascript">
            toastr.error('Your Account Lock ! <br>Contact System Admin !!');
        </script>
        <?php
    }else if ($message === "sys_update") {
        ?>
        <script type="text/javascript">
            toastr.error('Night Schedule Processing.!!!');
        </script>
        <?php
    }else if ($message === "wrngTry1") {
        ?>
        <script type="text/javascript">
            toastr.error('You tried wrong password 1 times !!');
        </script>
        <?php
    }else if ($message === "wrngTry2") {
        ?>
        <script type="text/javascript">
            toastr.error('You tried wrong password 2 times !!');
        </script>
        <?php
    }else if ($message === "wrngTry3") {
        ?>
        <script type="text/javascript">
            toastr.error('You tried wrong password 3 times !!');
        </script>
        <?php
    }else if ($message === "wrngLgcd") {
        ?>
        <script type="text/javascript">
            toastr.error('Wrong Digital eye code !!');
        </script>
        <?php
    }
    //locked user day end reconsi 2018-11-13
    else if ($message === "Delock"){
        ?>
        <script type="text/javascript">
            toastr.info("You Are Locked !<br/>Day End Reconciliation Is Not Done At Last Day, Please Concat Operation Manager..");
        </script>
        <?php
    }
}

//}

?>
