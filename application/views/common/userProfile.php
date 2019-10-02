<script type="text/javascript" src="<?= base_url(); ?>assets/js/custom-js/full_width.js"></script>

<!-- START PAGE HEADING -->
<div class="app-heading app-heading-background app-heading-light"
     style="background: url(<?= base_url(); ?>assets/header/header-2.jpg) center center no-repeat;">
    <div class="contact contact-rounded contact-bordered contact-xlg status-online margin-bottom-0">
        <img src="<?= base_url(); ?>uploads/user-image/<?= $_SESSION['uimg'] ?>">
        <div class="contact-container">
            <a href="#"><?= $userinfo[0]->fnme .' '.$userinfo[0]->lnme .' | '.$userinfo[0]->lvnm?></a>
            <span><?= $userinfo[0]->brnm .' ('.$userinfo[0]->brcd.')' ?></span>
            <p><?= 'Last Login : '.$userinfo[0]->lldt  ?></p>
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
                <a href="#" class="list-group-item text-bold active">Activivty</a>
                <a href="#" class="list-group-item text-bold">Friends <span class="badge badge-success">+3</span></a>
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
                    <p>Boooya project members</p>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-4">
                    <div class="contact contact-single contact-bordered contact-rounded">
                        <img src="assets/images/users/user_4.jpg">
                        <div class="contact-container">
                            <a href="#">Erin<br> Stewart</a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="contact contact-single contact-bordered contact-rounded">
                        <img src="assets/images/users/user_6.jpg">
                        <div class="contact-container">
                            <a href="#">Sophia<br> Eniston</a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="contact contact-single contact-bordered contact-rounded">
                        <img src="assets/images/users/user_2.jpg">
                        <div class="contact-container">
                            <a href="#">John<br> Doe</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <div class="contact contact-single contact-bordered contact-rounded">
                        <img src="assets/images/users/user_3.jpg">
                        <div class="contact-container">
                            <a href="#">Erica<br> Vasquez</a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="contact contact-single contact-bordered contact-rounded">
                        <img src="assets/images/users/user_7.jpg">
                        <div class="contact-container">
                            <a href="#">Bill<br> Kim</a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="contact contact-single contact-bordered contact-rounded">
                        <img src="assets/images/users/user_9.jpg">
                        <div class="contact-container">
                            <a href="#">Hilda<br> Martinez</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="app-content-separate-content">
        <!-- CONTENT CONTAINER -->
        <div class="container">

            <div class="row">
                <div class="col-lg-8 col-md-6">

                    <div class="row margin-bottom-20">
                        <div class="col-xs-4">
                            <button class="btn btn-primary btn-block btn-icon-fixed"><span
                                        class="fa fa-user-plus"></span> Add to Friends
                            </button>
                        </div>
                        <div class="col-xs-4">
                            <button class="btn btn-primary btn-block btn-icon-fixed"><span
                                        class="fa fa-comments"></span> Message Me
                            </button>
                        </div>
                        <div class="col-xs-4">
                            <button class="btn btn-primary btn-block btn-icon-fixed"><span class="fa fa-plus"></span>
                                Invite to Team
                            </button>
                        </div>
                    </div>

                    <div class="block block-condensed padding-top-20">
                        <div class="block-content">
                            <div class="form-group">
                                <textarea name="text" class="form-control" placeholder="Your message..."
                                          rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-default btn-icon" data-toggle="tooltip"
                                        data-original-title="Connect people to message"><span
                                            class="fa fa-user-plus"></span></button>
                                <button class="btn btn-default btn-icon" data-toggle="tooltip"
                                        data-original-title="Add photo"><span class="fa fa-camera"></span></button>
                                <button class="btn btn-default btn-icon" data-toggle="tooltip"
                                        data-original-title="Mark location on map"><span
                                            class="fa fa-map-marker"></span></button>

                                <button class="btn btn-default btn-icon-fixed pull-right"><span
                                            class="fa fa-paper-plane"></span> Post Message
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="app-timeline">

                        <div class="app-timeline-item">
                            <div class="user"><img src="assets/images/users/user_1.jpg" alt="Taylor Watson"></div>
                            <div class="content">
                                <div class="title"><a href="#">Taylor Watson</a> posted comment to <strong>Awesome
                                        article</strong></div>
                                <p>Praesent <strong>tellus elit</strong>, efficitur sit amet ex id, euismod auctor
                                    risus. <strong>Nullam a arcu tincidunt</strong>, ultrices nulla vitae, porta est.
                                </p>
                                <p>
                                    <a href="#" class="text-muted margin-right-10"><span class="fa fa-comment"></span>
                                        Comments</a>
                                    <a href="#" class="text-muted margin-right-10"><span class="fa fa-share-alt"></span>
                                        Share</a>
                                    <a href="#" class="text-muted"><span class="fa fa-bullhorn"></span> Report</a>

                                    <span class="pull-right text-muted"><i class="fa fa-clock-o"></i> 5 min ago</span>
                                </p>
                                <div class="comments">
                                    <div class="total">3 Comments for this post</div>
                                    <div class="comment">
                                        <div class="contact contact-rounded contact-lg">
                                            <img src="assets/images/users/user_7.jpg">
                                            <div class="contact-container">
                                                <a href="#">Jared Stevens</a>
                                                <span>Hey! This is really awesome thing... Wha do you think about it?</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="comment">
                                        <div class="contact contact-rounded contact-lg">
                                            <img src="assets/images/users/user_4.jpg">
                                            <div class="contact-container">
                                                <a href="#">Lilu Dallas</a>
                                                <span>Multi-pasport...</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="comment">
                                        <div class="contact contact-rounded contact-lg">
                                            <img src="assets/images/users/user_6.jpg">
                                            <div class="contact-container">
                                                <a href="#">Corben Dallas</a>
                                                <span>Wow... nice! Like like like...</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Your comment...">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-default">Post Comment</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="app-timeline-item">
                            <div class="user"><img src="assets/images/users/user_2.jpg" alt="Jessie Franklin"></div>
                            <div class="content">
                                <div class="title"><a href="#">Jessie Franklin</a> commented <strong>New York City
                                        photo</strong></div>
                                <p>Mauris tempor semper viverra. <strong>Aliquam laoreet malesuada</strong> nisl,
                                    fringilla accumsan mi condimentum a. <a href="#">Nullam lacinia egestas</a>. Proin
                                    iaculis malesuada mi, quis <a href="#">@Iaculis</a> magna tristique sed.</p>
                                <p>
                                    <a href="#" class="text-muted margin-right-10"><span class="fa fa-comment"></span>
                                        Comments</a>
                                    <a href="#" class="text-muted margin-right-10"><span class="fa fa-share-alt"></span>
                                        Share</a>
                                    <a href="#" class="text-muted"><span class="fa fa-bullhorn"></span> Report</a>

                                    <span class="pull-right text-muted"><i class="fa fa-clock-o"></i> 12 min ago</span>
                                </p>

                                <div class="comments">
                                    <div class="total">1 Comments for this post</div>
                                    <div class="comment">
                                        <div class="contact contact-rounded contact-lg">
                                            <img src="assets/images/users/user_8.jpg">
                                            <div class="contact-container">
                                                <a href="#">Mary Londro</a>
                                                <span>I saw this place tomorrow... really beautiful place!</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Your comment...">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-default">Post Comment</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="app-timeline-more">
                            <a href="#">...</a>
                        </div>

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
                            <img src="assets/images/users/user_1.jpg">
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
                            <img src="assets/images/users/user_2.jpg">
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
                            <img src="assets/images/users/user_3.jpg">
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
                            <img src="assets/images/users/user_4.jpg">
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
                            <img src="assets/images/users/user_5.jpg">
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

        </div>
        <!-- END CONTENT CONTAINER -->
    </div>
</div>
<!-- END PAGE SEPARATED CONTAINER -->


