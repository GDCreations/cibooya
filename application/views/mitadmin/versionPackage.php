<script type="text/javascript" src="<?= base_url(); ?>assets/js/custom-js/full_width.js"></script>
<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li><a href="#">MIT Settings</a></li>
        <li class="active">Version Management</li>
    </ul>
</div>
<div class="app-heading app-heading-bordered app-heading-page">
    <div class="icon icon-lg">
        <span class="fa fa-check-square-o" style="color: #e69c0f;"></span>
    </div>
    <div class="title">
        <h1>Version Management</h1>
        <p>Permission Enable / Disable / Access Pages</p>
    </div>
</div>
<!-- END PAGE HEADING -->

<!-- START PAGE CONTAINER -->
<div class="container">
    <div class="panel panel-default block">
        <div class="row form-horizontal">

            <form class="form-horizontal" id="pgAccss" name="pgAccss" action=""
                  method="post">
                <div class="table-responsive">
                    <table class="table datatable table-head-custom table-bordered table-actions"
                           id="dataTbMdul" width="100%">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">MENUS / MODULES NAME</th>
                            <th class="text-center">MENU STATUS</th>
                            <th class="text-center">MODULE ACCESS</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <input type="hidden" name="len5" id="len5">
                <button type="button" id="pgAccss_updt_btn"
                        class="btn btn-warning btn-sm btn-rounded pull-right">Submit
                </button>
            </form>

        </div>
    </div>


    <script type="text/javascript">
        $().ready(function () {

            $('#dataTbMdul').DataTable({
                destroy: true,
                searching: false,
                bPaginate: false,
                "ordering": false,
            });

            srchPermOrgin();
        });

        function srchPermOrgin() {
            $('#dataTbMdul').DataTable().clear();

            // SEARCH PAGE ACCESS
            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>mitadmin/getPageMdul",
                data: {

                },
                dataType: 'json',
                success: function (response) {
                    var len5 = response.length;

                    // Basic setting
                    $('#dataTbMdul').DataTable().clear();
                    var t = $('#dataTbMdul').DataTable({
                        destroy: true,
                        searching: false,
                        bPaginate: false,
                        "ordering": false,
                        "columnDefs": [
                            {className: "text-left", "targets": [1]},
                            {className: "text-center", "targets": [0, 2, 3]},
                            {className: "text-right", "targets": [0]},
                            {className: "text-nowrap", "targets": [1]}
                        ],
                        "aoColumns": [
                            {sWidth: '5%'},
                            {sWidth: '50%'},
                            {sWidth: '10%'},
                            {sWidth: '10%'},
                        ],
                        "footerCallback": function (row, data, start, end, display) {
                            var api = this.api(), data;
                            document.getElementById("len5").value = display.length;
                        },

                    });
                    for (var i = 0; i < len5; i++) {
                        var hid = "<label class=''><input type='hidden' name='mdid[" + i + "]'  value=" + response[i]['aid'] + " /> </label>";

                        if (response[i]['stat'] == 1) {
                            var stat = "<label class='label label-success'> Active </label>";
                            var pgac = " <label class='switch switch-sm' title='Page access'><input type='checkbox' name='pgac[" + i + "]' checked value = '1'/> <span></span> </label> ";
                        } else {
                            var stat = "<label class='label label-warning'> Inactive </label>";
                            var pgac = " <label class='switch switch-sm' title='Page access'><input type='checkbox' name='pgac[" + i + "]' value = '1'/> <span></span> </label> ";
                        }

                        t.row.add([
                            i + 1,
                            response[i]['mdnm']  + hid,  // + ' (' + response[i]['mdcd'] + ')'
                            stat,
                            pgac
                        ]).draw(false);
                    }

                    if (len5 == 0) {
                        $('#pgAccss_updt_btn').attr('disabled', true);
                    } else {
                        $('#pgAccss_updt_btn').attr('disabled', false);
                    }
                }
            });
        }

        $('#pgAccss_updt_btn').click(function (e) {
            e.preventDefault();
            swal({
                title: "Processing...",
                text: "",
                imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                showConfirmButton: false
            });

            var len = document.getElementById('len5').value;
            if (len > 0) {
                jQuery.ajax({
                    type: "POST",
                    url: "<?= base_url(); ?>mitadmin/editMitVirs",
                    data: $("#pgAccss").serialize(),
                    dataType: 'json',
                    success: function (response) {
                        swal({title: "", text: "Version Update Successfully", type: "success"},
                            function () {
                                location.reload();
                            });
                    },
                    error: function (data, textStatus) {
                        swal({title: "Update Error", text: textStatus, type: "error"},
                            function () {
                            location.reload();
                            });
                    }
                });
            } else {
                swal("NO Permission Updates", '', "error");
            }

        });

    </script>
</div>
<!-- END PAGE CONTAINER -->

