
<meta http-equiv="refresh" content="30"> <!-- 120 -->
<script src="<?= base_url(); ?>assets/plugins/toastr/toastr.min.js" type="text/javascript"></script>
<link href="<?= base_url(); ?>assets/plugins/toastr/toastr.css" rel="stylesheet" type="text/css"/>

<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li class="active">User Dashboard</li>
    </ul>
</div>
<div class="app-heading app-heading-bordered app-heading-page">
    <div class="icon icon-lg">
        <span class="icon-home" style="color: #e69c0f;"></span>
    </div>
    <div class="title">
        <h1>User Dashboard</h1>
        <p>Subtitle</p>
    </div>
</div>
<!-- END PAGE HEADING -->
<!-- START PAGE CONTAINER -->
<div class="container">
    <div class="block">
    </div>
</div>
<!-- END PAGE CONTAINER -->

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
</script>

<?php
//$pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
//if ($pageWasRefreshed) {
if (isset($_GET['message'])) {
    $message = $_GET['message'];
    if ($message === "success") {
        ?>
        <script type="text/javascript">
            toastr.success('Welcome <?php
                if (!empty($_SESSION['userId'])) {
                    echo $_SESSION['fname'] . " " . $_SESSION['lname'];
                }
                ?>..');
        </script>
        <?php
    }
}

?>