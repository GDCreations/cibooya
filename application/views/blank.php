<!DOCTYPE html>
<html lang="en">
<head>
    <title>Boooya - Revolution Admin Template</title>

    <!-- META SECTION -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="<?= base_url(); ?>assets/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?= base_url(); ?>assets/img/favicon.ico" type="image/x-icon">
    <!-- END META SECTION -->

    <script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/jquery/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/bootstrap/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/moment/moment.min.js"></script>

    <script type="text/javascript"
            src="<?= base_url(); ?>assets/js/vendor/customscrollbar/jquery.mCustomScrollbar.min.js"></script>
    <script type="text/javascript"
            src="<?= base_url(); ?>assets/js/vendor/bootstrap-select/bootstrap-select.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/select2/select2.full.min.js"></script>
    <script type="text/javascript"
            src="<?= base_url(); ?>assets/plugins/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
    <!-- CSS INCLUDE -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/styles.css">
    <link rel="stylesheet"
          href="<?= base_url(); ?>assets/css/glyphicon_icon.css">
    <link rel="stylesheet"
          href="<?= base_url(); ?>assets/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css">

    <!--    FILE UPLOADS-->
    <!--    https://plugins.krajee.com/file-input#ajax-resumable-->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/test/css/fileinput.css">
    <!--    FILE UPLOADS-->
    <!-- EOF CSS INCLUDE -->
</head>
<body>

<!-- APP WRAPPER -->
<div class="app">

    <!-- START APP CONTAINER -->
    <div class="app-container">
        <!-- START SIDEBAR -->
        <div class="app-sidebar app-navigation  app-navigation-fixed app-navigation-style-default dir-left"
             data-type="close-other">
            <a href="index.html" class="app-navigation-logo"></a>
            <nav>
                <ul>
                    <li><a href="#"><span class="icon-home"></span> Navigation Item</a></li>
                </ul>
            </nav>
        </div>
        <!-- END SIDEBAR -->

        <!-- START APP CONTENT -->
        <div class="app-content app-sidebar-left">
            <!-- START APP HEADER -->
            <div class="app-header app-header-design-dark ">
                <ul class="app-header-buttons">
                    <li class="visible-mobile"><a href="#" class="btn btn-link btn-icon"
                                                  data-sidebar-toggle=".app-sidebar.dir-left"><span
                                    class="icon-menu"></span></a></li>
                    <li class="hidden-mobile"><a href="#" class="btn btn-link btn-icon"
                                                 data-sidebar-minimize=".app-sidebar.dir-left"><span
                                    class="icon-list"></span></a></li>
                </ul>
                <form class="app-header-search" action="" method="post">
                    <input type="text" name="keyword" placeholder="Search">
                </form>
            </div>
            <!-- END APP HEADER  -->

            <!-- START PAGE HEADING -->
            <div class="app-heading app-heading-bordered app-heading-page">
                <div class="icon icon-lg">
                    <span class="icon-home"></span>
                </div>
                <div class="title">
                    <h1>Blank</h1>
                    <p>Subtitle</p>
                </div>
            </div>
            <div class="app-heading-container app-heading-bordered bottom">
                <ul class="breadcrumb">
                    <li><a href="#">First level</a></li>
                    <li class="active">Current</li>
                </ul>
            </div>
            <!-- END PAGE HEADING -->

            <!-- START PAGE CONTAINER -->
            <div class="container">
                <div class="row">
                    <div class='col-sm-6'>
                        <div class="form-group">
                            <div class='input-group date datetimepicker'>
                                <input type='text' class="form-control datetimepicker" value="<?= date('Y-m-d') ?>"/>
                                <span class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </span>
                            </div>
                        </div>
                    </div>
                    <script type="text/javascript">
                        $(function () {
                            $('.datetimepicker').datetimepicker({
                                format: 'YYYY-MM-DD'
                            });
                        });
                    </script>
                </div>

                <div class="row">
                    <h2>File Uploader</h2>
                    <form enctype="multipart/form-data" id="data_form" name="data_form">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input id="input-id" name="input-id[]" type="file" multiple/>
                            </div>
                            <div class="form-group">
                                <input id="files" name="files" type="text" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <button type="button" id="add_file" class="btn btn-sm btn-warning btn-rounded">SUBMIT</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END PAGE CONTAINER -->

        </div>
        <!-- END APP CONTENT -->

    </div>
    <!-- END APP CONTAINER -->

    <!-- START APP FOOTER -->
    <!-- <div class="app-footer app-footer-default" id="footer">
          <div class="app-footer-line">
              <div class="copyright">&copy; 2016-2017 Boooya. All right reserved in the Ukraine and other
                  countries.
              </div>
              <div class="pull-right">
                  <ul class="list-inline">
                      <li><a href="#">About</a></li>
                      <li><a href="#">Help</a></li>
                      <li><a href="#">Community</a></li>
                      <li><a href="#">Contacts</a></li>
                  </ul>
              </div>
          </div>
      </div>-->
    <!-- END APP FOOTER -->


    <!-- START APP FOOTER -->
    <div class="app-footer app-footer-default" id="footer">
        <!--
        <div class="alert alert-danger alert-dismissible alert-inside text-center">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span class="icon-cross"></span></button>
            We use cookies to offer you the best experience on our website. Continuing browsing, you accept our cookies policy.
        </div>
        -->
        <div class="app-footer-line darken">
            <div class="copyright wide text-center">&copy; 2016-2017 Boooya. All right reserved in the Ukraine and other
                countries.
            </div>
        </div>
    </div>
    <!-- END APP FOOTER -->


</div>
<!-- END APP WRAPPER -->

<!-- START SCRIPTS -->
<!--<script type="text/javascript"-->
<!--        src="-->
<? //= base_url(); ?><!--assets/js/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.js"></script>-->

<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/maskedinput/jquery.maskedinput.min.js"></script>
<script type="text/javascript"
        src="<?= base_url(); ?>assets/js/vendor/form-validator/jquery.form-validator.min.js"></script>

<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/noty/jquery.noty.packaged.js"></script>

<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/datatables/dataTables.bootstrap.min.js"></script>
<!--<script type="text/javascript"-->
<!--        src="-->
<? //= base_url(); ?><!--assets/js/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.js"></script>-->
<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/sweetalert/sweetalert.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/knob/jquery.knob.min.js"></script>

<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/jvectormap/jquery-jvectormap.min.js"></script>
<script type="text/javascript"
        src="<?= base_url(); ?>assets/js/vendor/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script type="text/javascript"
        src="<?= base_url(); ?>assets/js/vendor/jvectormap/jquery-jvectormap-us-aea-en.js"></script>

<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/sparkline/jquery.sparkline.min.js"></script>

<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/morris/raphael.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/morris/morris.min.js"></script>

<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/rickshaw/d3.v3.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/rickshaw/rickshaw.min.js"></script>

<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/isotope/isotope.pkgd.min.js"></script>

<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/dropzone/dropzone.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/nestable/jquery.nestable.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/cropper/cropper.min.js"></script>

<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/tableexport/tableExport.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/tableexport/jquery.base64.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/tableexport/html2canvas.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/tableexport/jspdf/libs/sprintf.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/tableexport/jspdf/jspdf.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/tableexport/jspdf/libs/base64.js"></script>

<!--<script type="text/javascript" src="-->
<? //= base_url(); ?><!--assets/js/vendor/bootstrap-daterange/daterangepicker.js"></script>-->
<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/bootstrap-tour/bootstrap-tour.min.js"></script>
<script type="text/javascript"
        src="<?= base_url(); ?>assets/js/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/fullcalendar/fullcalendar.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/smartwizard/jquery.smartWizard.js"></script>

<script type="text/javascript" src="<?= base_url(); ?>assets/js/app.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/app_plugins.js"></script>
<!--        <script type="text/javascript" src="assets/js/app_demo.js"></script>-->

<!--FILE UPLOADS-->
<!--https://plugins.krajee.com/file-input#ajax-resumable-->
<script type="text/javascript" src="<?= base_url(); ?>assets/test/js/plugins/piexif.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/test/js/plugins/sortable.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/test/js/fileinput.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/test/js/locales/fr.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/test/js/locales/es.js"></script>
<!--<script type="text/javascript" src="--><?//= base_url(); ?><!--assets/test/js/fas/theme.js"></script>-->
<!--<script type="text/javascript" src="--><?//= base_url(); ?><!--assets/test/js/explorer-fas/theme.js"></script>-->
<script type="text/javascript">
    $().ready(function () {
        $("#input-id").fileinput({
            allowedFileExtensions: ['jpg', 'png', 'gif', 'doc','pdf'],
            showUpload: false,
            showCaption: false,
            browseClass: "btn btn-primary btn-sm btn-rounded",
            uploadClass: "btn btn-success btn-sm btn-rounded",
            removeClass: "btn btn-warning btn-sm btn-rounded",
            previewFileType: 'any'
        });
    });

    $('#add_file').click(function (e) {
        e.preventDefault();
        var formObj = document.getElementById('data_form');
        var formData = new FormData(formObj);

        $.ajax({
            url: '<?= base_url()?>User/upload',
            type: 'POST',
            data: formData,
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,

            success: function (data, textStatus, jqXHR) {
                swal({title: "", text: "Normal Customer Added successful", type: "success"},
                    function () {

                    });
            },
            error: function (data, jqXHR, textStatus, errorThrown) {
                swal(" Added Failed!", "You", "error");
            }
        });
    });
</script>
<!--FILE UPLOADS-->
<!-- END SCRIPTS -->
</body>
</html>