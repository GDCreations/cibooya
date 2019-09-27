<!DOCTYPE html>
<html lang="en">
<head>
    <title> System Updating </title>

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
                <img src="<?= base_url(); ?>assets/images/users/user_default.png" alt="John Doe">
            </div>
            <div class="app-lock-form animated bounceIn" style="display: block;">
                <form action="<?= base_url(); ?>user" method="post">
                    <div class="form-group">

                        <div class="col-md-12">
                            <div class="app-widget-tile">
                                <div class="intval intval-lg" id="timestamp">00:00:00</div>
                                <div class="line">
                                    <div class="title wide text-center">System Updating</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <button class="btn btn-success btn-block btn-icon-fixed"><span
                                            class="fa fa-sign-in"></span>Login
                                </button>
                            </div>
                        </div>
                    </div>
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

</body>

<script type="text/javascript">
    $().ready(function () {
        setInterval(timestamp, 1000);
    });

    function timestamp() {
        $.ajax({
            url: '<?= base_url(); ?>Welcome/timestamp',
            success: function (data) {
                if (data.length > 0) {
                    $('#timestamp').html(data);
                } else {


                    window.location.replace("<?= base_url(); ?>user");
                }
            },
        });
    }

</script>


</html>