<script type="text/javascript" src="<?= base_url(); ?>assets/js/custom-js/full_width.js"></script>

<!-- START PAGE HEADING -->
<div class="app-heading app-heading-background app-heading-light"
     style="background: url(<?= base_url(); ?>assets/header/header-2.jpg) center center no-repeat;">
    <div class="contact contact-rounded contact-bordered contact-xlg status-online margin-bottom-0">
        <img src="<?= base_url(); ?>uploads/user-image/<?= $_SESSION['uimg'] ?>">
        <div class="contact-container">
            <a href="#"><?= $userinfo[0]->fnme . ' ' . $userinfo[0]->lnme . ' | ' . $userinfo[0]->lvnm ?></a>
            <span><?= $userinfo[0]->brnm . ' (' . $userinfo[0]->brcd . ')' ?></span>
            <p><?= 'Last Login : ' . $userinfo[0]->lldt ?></p>
        </div>
    </div>
</div>
<!-- END PAGE HEADING -->

<!-- START PAGE SEPARATED CONTAINER -->
<div class="app-content-separate app-content-separated-left">

    <div class="app-content-separate-left" data-separate-control-height="true">
        <div class="app-content-separate-panel padding-20 visible-mobile">
            <div class="pull-left">
                <h4 class="text-sm text-uppercase text-bolder margin-bottom-0">Visible On Mobile</h4>
                <p class="subheader">Use this panel to control this sidebar</p>
            </div>
            <button class="btn btn-default btn-icon pull-right" data-separate-toggle-panel=".app-content-separate-left">
                <span class="icon-menu"></span></button>
        </div>
        <div class="app-content-separate-content padding-20">

            <div class="list-group list-group-noborder">
                <div class="list-group-title">Favorite</div>
                <a href="#" class="list-group-item text-bold">Sales<span class="badge badge-info">23,000/-</span></a>
                <a href="#" class="list-group-item text-bold">Customer <span class="badge badge-success">+3</span></a>
                <a href="#" class="list-group-item text-bold">Messages <span
                            class="badge badge-danger">4 / 342</span></a>
                <a href="#" class="list-group-item text-bold">Events <span class="badge badge-warning">2</span></a>
                <div class="list-group-title">Development</div>
                <a href="#" class="list-group-item text-bold">Apps</a>
                <a href="#" class="list-group-item text-bold">Settings</a>
            </div>

            <div class="app-heading app-heading-small heading-transparent">
                <div class="title">
                    <h3>Team</h3>
                    <p>Branch Members</p>
                </div>
            </div>

            <div class="row">
                <?php
                //echo sizeof($memberinfo);
                for ($a = 0; $a < sizeof($memberinfo); $a++) {
                    echo "<div class='col-xs-4'><div class='contact contact-single contact-bordered contact-rounded'>
                        <img src='" . base_url() . "uploads/user-image/" . $memberinfo[$a]->uimg . "'>
                        <div class='contact-container'><a href='#'>" . $memberinfo[$a]->fnme . "<br> " . $memberinfo[$a]->lnme . "</a>
                        </div></div></div>";
                }
                ?>
                <!--
                <div class="col-xs-4">
                    <div class="contact contact-single contact-bordered contact-rounded">
                        <img src="assets/images/users/user_4.jpg">
                        <div class="contact-container">
                            <a href="#">Erin<br> Stewart</a>
                        </div>
                    </div>
                </div>
                -->
            </div>

        </div>
    </div>

    <div class="app-content-separate-content">
        <!-- CONTENT CONTAINER -->
        <div class="container">

            <div class="row">
                <div class="col-lg-8 col-md-6">

                    <div class="row margin-bottom-20">
                        <div class="col-xs-12">
                            <div class="title">
                                <p><b> Profile Details </b> </p>
                            </div>
                        </div>

                    </div>

                    <div class="block block-condensed padding-top-20">

                        <div class="block-content">
                            <table id="user" class="table table-bordered table-striped">
                                <tbody>
                                <tr>
                                    <td class="text-bold">User Name</td>
                                    <td><a href="#"
                                           class="editable editable-click editable-disabled"><?= $userinfo[0]->usnm ?></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-bold">Full Name</td>
                                    <td><a href="#"
                                           class="editable editable-click editable-disabled"><?= $userinfo[0]->fnme . ' ' . $userinfo[0]->lnme ?></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-bold">NIC</td>
                                    <td><a href="#"
                                           class="editable editable-click editable-disabled"><?= $userinfo[0]->unic ?></a>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="20%" class="text-bold">Mobile No</td>
                                    <td width="40%"><a href="#" id="mobile" data-type="text"
                                                       data-pk="<?= $userinfo[0]->auid ?>"
                                                       data-value="<?= $userinfo[0]->almo ?>"
                                                       data-title="Enter Mobile No"><?= $userinfo[0]->almo ?></a></td>
                                </tr>
                                <tr>
                                    <td class="text-bold">Emil</td>
                                    <td><a href="#" id="emil" data-type="text" data-pk="<?= $userinfo[0]->auid ?>"
                                           data-value="<?= $userinfo[0]->emid ?>"
                                           data-title="Enter Email"><?= $userinfo[0]->emid ?></a></td>
                                </tr>

                                <!--<tr>
                                    <td class="text-bold">Event</td>
                                    <td><a href="#" id="event" data-type="combodate" data-template="D MMM YYYY  HH:mm"
                                           data-format="YYYY-MM-DD HH:mm" data-viewformat="MMM D, YYYY, HH:mm"
                                           data-pk="1" data-title="Setup event date and time"></a></td>
                                    <td>Combodate (datetime)</td>
                                </tr>
                                <tr>
                                    <td class="text-bold">Comment</td>
                                    <td><a href="#" id="comments" data-type="textarea" data-pk="1"
                                           data-placeholder="Your comments here..." data-title="Enter comments">awesome
                                            user!</a></td>
                                    <td>Textarea, buttons below. Submit by <i>ctrl+enter</i></td>
                                </tr>
                                <tr>
                                    <td class="text-bold">Fruits</td>
                                    <td><a href="#" id="fruits" data-type="checklist" data-value="2,3"
                                           data-title="Select fruits"></a></td>
                                    <td>Checklist</td>
                                </tr>
                                <tr>
                                    <td class="text-bold">Tags</td>
                                    <td><a href="#" id="tags" data-type="select2" data-pk="1" data-title="Enter tags">html,
                                            javascript</a></td>
                                    <td>Select2 (tags mode)</td>
                                </tr>
                                <tr>
                                    <td class="text-bold">Country</td>
                                    <td><a href="#" id="country" data-type="select2" data-pk="1" data-value="BS"
                                           data-title="Select country"></a></td>
                                    <td>Select2 (dropdown mode)</td>
                                </tr>

                                <tr>
                                    <td class="text-bold">Address</td>
                                    <td><a href="#" id="address" data-type="address" data-pk="1"
                                           data-title="Please, fill address"></a></td>
                                    <td>Custom input, several fields</td>
                                </tr>-->

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <button class="btn btn-info pull-left hidden-mobile" data-toggle="modal"
                                data-target="#modal-add">Password Change
                        </button>
                    </div>

                </div>
                <div class="col-lg-4 col-md-6">

                    <div class="block">
                        <div class="app-heading app-heading-small">
                            <div class="title">
                                <h3>Friends list</h3>
                                <p>Online contacts: 4</p>
                            </div>
                            <div class="heading-elements visible-lg-block">
                                <a href="#" class="btn btn-primary btn-clean">Contacts</a>
                            </div>
                        </div>

                        <div class="contact contact-rounded contact-bordered contact-lg status-online">
                            <img src="<?= base_url(); ?>uploads/user-image/no-image.png">
                            <div class="contact-container">
                                <a href="#">John Doe</a>
                                <span>2 min ago</span>
                            </div>
                            <div class="contact-controls visible-lg-block">
                                <button class="btn btn-twitter btn-clean btn-icon"><span class="fa fa-twitter"></span>
                                </button>
                            </div>
                        </div>
                        <div class="contact contact-rounded contact-bordered contact-lg status-online">
                            <img src="<?= base_url(); ?>uploads/user-image/no-image.png">
                            <div class="contact-container">
                                <a href="#">Juan Obrien</a>
                                <span>15 hours ago</span>
                            </div>
                            <div class="contact-controls visible-lg-block">
                                <button class="btn btn-twitter btn-clean btn-icon"><span class="fa fa-twitter"></span>
                                </button>
                            </div>
                        </div>
                        <div class="contact contact-rounded contact-bordered contact-lg status-online">
                            <img src="<?= base_url(); ?>uploads/user-image/no-image.png">
                            <div class="contact-container">
                                <a href="#">Erin Stewart</a>
                                <span>2 days ago</span>
                            </div>
                            <div class="contact-controls visible-lg-block">
                                <button class="btn btn-twitter btn-clean btn-icon"><span class="fa fa-twitter"></span>
                                </button>
                            </div>
                        </div>
                        <div class="contact contact-rounded contact-bordered contact-lg status-online">
                            <img src="<?= base_url(); ?>uploads/user-image/no-image.png">
                            <div class="contact-container">
                                <a href="#">Elaine Harper</a>
                                <span>2 days ago</span>
                            </div>
                            <div class="contact-controls visible-lg-block">
                                <button class="btn btn-twitter btn-clean btn-icon"><span class="fa fa-twitter"></span>
                                </button>
                            </div>
                        </div>
                        <div class="contact contact-rounded contact-bordered contact-lg status-away">
                            <img src="<?= base_url(); ?>uploads/user-image/no-image.png">
                            <div class="contact-container">
                                <a href="#">Chester Vargas</a>
                                <span>Month ago</span>
                            </div>
                            <div class="contact-controls visible-lg-block">
                                <button class="btn btn-twitter btn-clean btn-icon"><span class="fa fa-twitter"></span>
                                </button>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <!-- MODAL PASS WORD CHANGE -->
            <div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modal-default-header">
                <div class="modal-dialog" role="document">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="icon-cross"></span>
                    </button>
                    <form id="addForm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="modal-default-header"><span class="fa fa-tags"></span>
                                    Password Change
                                </h4>
                            </div>

                            <div class="modal-body">
                                <div class="container">
                                    <div class="row form-horizontal">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-12 control-label">Old Password
                                                    <span class="fa fa-asterisk req-astrick"></span></label>
                                                <div class="col-md-8 col-xs-12">
                                                    <input class="form-control" type="password" name="olpss" id="olpss"
                                                           placeholder="Old Password"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-12 control-label">New Password
                                                    <span class="fa fa-asterisk req-astrick"></span></label>
                                                <div class="col-md-8 col-xs-12">
                                                    <input class="form-control" type="password" name="nwpss" id="nwpss"
                                                           placeholder="New Password"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-12 control-label">Re Type New Password
                                                    <span class="fa fa-asterisk req-astrick"></span></label>
                                                <div class="col-md-8 col-xs-12">
                                                    <input class="form-control" type="password" name="nw2ps" id="nw2ps"
                                                           placeholder="Re Type New Password"/>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <div class="pull-left">
                                    <span class="fa fa-hand-o-right"></span>
                                    <label style="color: red"> <span class="fa fa-asterisk req-astrick"></span> Required
                                        Fields
                                    </label>
                                </div>
                                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                                <button type="button" id="addBtn" class="btn btn-warning btn-sm btn-rounded">Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END ADD NEW  -->


        </div>
        <!-- END CONTENT CONTAINER -->
    </div>
</div>
<!-- END PAGE SEPARATED CONTAINER -->

<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/xeditable/bootstrap-editable.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/vendor/xeditable/ext/address.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/custom-js/user-profile-editable.js"></script>


<script type="text/javascript">
    $().ready(function () {
        //Table Initializing

        $('#addForm').validate({
            rules: {
                olpss: {
                    required: true
                },
                nwpss: {
                    required: true,
                    minlength: 4
                },
                nw2ps: {
                    required: true,
                    equalTo: "#nwpss"
                }
            },
            messages: {
                olpss: {
                    required: 'Please enter Current Password'
                },
                nwpss: {
                    required: 'Please enter New Password'
                },
                nw2ps: {
                    required: 'Please Retype New Password',
                    equalTo: 'This value not match with New Password'
                }
            }
        });

    });


    $("#addBtn").click(function (e) { // update password form
        e.preventDefault();
        if ($("#addForm").valid()) {

            $('#addBtn').prop('disabled', true);
            swal({
                title: "Processing...",
                text: "Data saving..",
                imageUrl: "<?= base_url() ?>assets/img/loading.gif",
                showConfirmButton: false
            });

            jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>welcome/upd_pass",
                data: $("#addForm").serialize(),
                dataType: 'json',
                success: function (data) {
                    swal({title: "", text: "Password Update Successfully!", type: "success"},
                        function () {
                            $('#addBtn').prop('disabled', false);
                            clear_Form('addForm');
                            $('#modal-add').modal('hide');
                            location.reload();
                        });
                },
                error: function (data, textStatus) {
                    swal({title: "Password Update Failed", text: textStatus, type: "error"},
                        function () {
                            location.reload();
                        });
                }
            });

        } else {
            //            alert("Error");
        }
    });

</script>