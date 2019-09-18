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
                                <!--<div class="app-checkbox">
                                    <label><input type="checkbox" name="app-checkbox-1" value="0"> Remember me</label>
                                </div>-->
                            </div>
                            <div class="col-md-6 col-xs-6">
                                <button class="btn btn-success btn-block">Sign In</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>

            <div class="app-login-box-footer">
                &copy; Boooya 2017. All rights reserved.
            </div>
        </div>

    </div>
    <!-- END APP CONTAINER -->

</div>
<!-- END APP WRAPPER -->

<!--
<div class="modal fade" id="modal-thanks" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="icon-cross"></span></button>
        <div class="modal-content">
            <div class="modal-body">
                <p class="text-center margin-bottom-20">
                    <img src="assets/images/smile.png" alt="Thank you" style="width: 100px;">
                </p>
                <h3 id="modal-thanks-heading" class="text-uppercase text-bold text-lg heading-line-below heading-line-below-short text-center"></h3>
                <p class="text-muted text-center margin-bottom-10">Thank you so much for likes</p>
                <p class="text-muted text-center">We will do our best to make<br> Boooya template perfect</p>
                <p class="text-center"><button class="btn btn-success btn-clean" data-dismiss="modal">Continue</button></p>
            </div>
        </div>
    </div>
</div>-->

<!-- IMPORTANT SCRIPTS -->
<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/jquery/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/bootstrap/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/form-validator/jquery.form-validator.min.js"></script>

<!--        <script type="text/javascript" src="-->
<? //= base_url(); ?><!--assets/js/vendor/jquery/jquery-migrate.min.js"></script>-->


        <script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/moment/moment.min.js"></script>
<!--        <script type="text/javascript" src="js/vendor/customscrollbar/jquery.mCustomScrollbar.min.js"></script>-->
<!-- END IMPORTANT SCRIPTS -->
<!-- APP SCRIPTS -->
<!--        <script type="text/javascript" src="js/app.js"></script>-->
<!--        <script type="text/javascript" src="js/app_plugins.js"></script>-->
<!--        <script type="text/javascript" src="js/app_demo.js"></script>-->
<!-- END APP SCRIPTS -->
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
//$pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';

//if ($pageWasRefreshed) {

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
            toastr.error('Your Account Lock ! Contact MIT !!');
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
        <!--//time out message start-->
        <div class="message-box message-box-warning animated fadeIn " data-sound="alert" style="display: block"
             id="msg_warning">
            <div class="mb-container">
                <div class="mb-middle">
                    <div style="" class="mb-title"><span class="fa fa-warning">&nbsp;</span>Please be patient ...</div>
                    <div class="mb-content">
                        <br>
                        <div><p style="color: white">You Entered wrong login details two times.You have only one chance
                                left.If you again enter a wrong login details account will be lock. </p></div>
                        <div><p style="color: white">Please wait in <span style="font-size: 20px;"
                                                                          id="time">00:30</span> seconds.</p></div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            //start javascript for timer
            function startTimer(duration, display) {
                var timer = duration, minutes, seconds;
                setInterval(function () {
                    minutes = parseInt(timer / 60, 10)
                    seconds = parseInt(timer % 60, 10);
                    minutes = minutes < 10 ? "0" + minutes : minutes;
                    seconds = seconds < 10 ? "0" + seconds : seconds;
                    display.textContent = minutes + ":" + seconds;
                    if (--timer < 0) {
                        timer = duration;
                        document.getElementById("msg_warning").style.display = "none";
                    }
                }, 1000);
            }

            window.onload = function () {
                var fiveMinutes = 30,
                    display = document.querySelector('#time');
                startTimer(fiveMinutes, display);
            };
        </script>
<!--        //end 18-10-2018-->

        <script type="text/javascript">
            // toastr.error('Your are tried wrong password 2 times !!');
        </script>
        <?php
    }else if ($message === "wrngTry3") {
        ?>
        <script type="text/javascript">
            toastr.error('Your are tried wrong password 3 times !!');
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
    //end locked user day end reconsi 2018-11-13
}

//}

?>
