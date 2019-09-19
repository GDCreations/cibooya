<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= $sysinfo[0]->synm ?> - Lock Screen</title>

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
         style="background: url(<?= base_url(); ?>assets/images/background/bg-1.jpg) center center no-repeat fixed;">

        <div class="app-lock">

            <div class="app-lock-user">
                <img src="<?= base_url(); ?>assets/images/users/user_1.jpg" alt="John Doe">
            </div>
            <div class="app-lock-form">
                <form action="<?= base_url(); ?>login/loginMe" method="post">
                    <div class="form-group">
                        <input type="password" class="form-control" name="logps" required>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="app-checkbox">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-success btn-block btn-icon-fixed"><span class="icon-lock"></span>Unlock
                                </button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="lognm" name="lognm" value="<?= $_SESSION['username']; ?>"/>
                    <input type="hidden" class="form-control" id="logcd" name="logcd"/>

                </form>
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
<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/moment/moment.min.js"></script>
<script type="text/javascript"
        src="<?= base_url(); ?>assets/js/vendor/customscrollbar/jquery.mCustomScrollbar.min.js"></script>
<!-- END IMPORTANT SCRIPTS -->
<!-- APP SCRIPTS -->
<script type="text/javascript" src="<?= base_url(); ?>assets/js/app.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/app_plugins.js"></script>
<!-- END APP SCRIPTS -->
</body>
</html>