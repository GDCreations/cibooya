<?php
$data = $this->Generic_model->getData('com_det', array('cmne', 'synm'), array('stat' => 1));
?>
</div>
<!-- END APP CONTENT -->
</div>
<!-- END APP CONTAINER -->

<!-- START APP FOOTER -->
<div class="app-footer app-footer-default" id="footer">

    <div class="app-footer-line darken">
        <!--<div class="copyright wide text-center">&copy; 2016-2017 Boooya. All right reserved in the Ukraine and other </div>-->
        <div class="copyright wide text-left">
            &copy; <?= date('Y') ?> - <?= $data[0]->synm ?> | v1.<?= date('m') ?> | Powered By
            <a href="http://www.gdcreations.com" target="_blank">GDC</a></div>
    </div>
</div>
<!-- END APP FOOTER -->

<!-- APP OVERLAY -->
<div class="app-overlay"></div>
<!-- END APP OVERLAY -->
</div>
<!-- END APP WRAPPER -->

<!-- START SCRIPTS -->
<script type="text/javascript" src="<?= base_url(); ?>assets/js/custom-js/common-func.js"></script>
<script type="text/javascript"
        src="<?= base_url(); ?>assets/js/vendor/customscrollbar/jquery.mCustomScrollbar.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/bootstrap-select/bootstrap-select.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/select2/select2.full.min.js"></script>
<!--https://github.com/Eonasdan/bootstrap-datetimepicker-->
<script type="text/javascript" src="<?= base_url(); ?>assets/plugins/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/maskedinput/jquery.maskedinput.min.js"></script>

<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/noty/jquery.noty.packaged.js"></script>

<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/datatables/dataTables.bootstrap.min.js"></script>

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

<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/bootstrap-daterange/daterangepicker.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/bootstrap-tour/bootstrap-tour.min.js"></script>
<script type="text/javascript"
        src="<?= base_url(); ?>assets/js/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/fullcalendar/fullcalendar.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/smartwizard/jquery.smartWizard.js"></script>
<!--Color Picker-->
<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/bootstrap-colorpicker/bootstrap-colorpicker.min.js"></script>

<script type="text/javascript" src="<?= base_url(); ?>assets/js/app.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/app_plugins.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/numeral-js.js"></script>

<!--FILE UPLOADS -- https://plugins.krajee.com/file-input#ajax-resumable-->
<script type="text/javascript" src="<?= base_url(); ?>assets/plugins/file-uploader/js/plugins/piexif.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/plugins/file-uploader/js/plugins/sortable.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/plugins/file-uploader/js/fileinput.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/plugins/file-uploader/js/locales/fr.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/plugins/file-uploader/js/locales/es.js"></script>
<!--FILE UPLOADS-->

<!--        <script type="text/javascript" src="assets/js/app_demo.js"></script>-->
<!-- END SCRIPTS -->
<!--            Show Active Page on Navigation Bar-->
<script>
    var module = "<?= $acm?>";//Active Module Id
    var page = "<?= $acp?>";//Active Page Id
    $().ready(function () {
        $("#" + page).addClass("active");
        if (module != '') {
            $("#" + module).addClass("openable open");
        }
    });

    $().ready(function () {
        //INITIALITING DATETIMEPICKERS
        $('.datetimepicker').datetimepicker({
            format: 'YYYY-MM-DD'
        });
        $('.datetimepicker').css('cursor','pointer');

        //INITIALITING DATERANGERS
        $('.dateranger').daterangepicker({
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            alwaysShowCalendars : true,
            opens: 'center',
            locale: {
                format: 'YYYY-MM-DD'
            }
        });
    });

</script>
<!--            Show Active Page on Navigation Bar-->
</body>
</html>