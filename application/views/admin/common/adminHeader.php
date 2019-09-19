<!-- APP WRAPPER -->
<div class="app">
    <!-- START APP CONTAINER -->
    <div class="app-container">
        <!-- START SIDEBAR -->
        <div class="app-sidebar app-navigation app-navigation-fixed scroll app-navigation-style-default app-navigation-open-hover dir-left"
             data-type="close-other">
            <a href="#" class="app-navigation-logo"></a>
            <nav>
                <ul>
                    <li><a id="dashbrd" href="<?= base_url() ?>Admin"><span class="nav-icon-hexa icon-home"></span>
                            Dashboards </a></li>

                    <li id="gnrl">
                        <a href="#"><span class="nav-icon-hexa fa fa-globe"></span> General</a>
                        <ul>
                            <li><a id="branding" href="<?= base_url() ?>admin/branding">
                                    <span class="nav-icon-hexa fa fa-sliders"></span> Branding</a>
                            </li>
                            <li><a id="policyMng" href="<?= base_url() ?>admin/policyMng">
                                    <span class="nav-icon-hexa fa fa-list-alt"></span> Policy Management</a>
                            </li>
                            <li><a id="rcntAct" href="<?= base_url() ?>admin/rcntAct">
                                    <span class="nav-icon-hexa fa fa-sliders"></span> Recent Activity</a>
                            </li>

                        </ul>
                    </li>
                    <li class="title">STOCK</li>
                    <li id="sup_mng">
                        <a href="#"><span class="nav-icon-hexa fa fa-truck"></span> Supplier Management</a>
                        <ul>
                            <li>
                                <a id="sup_reg" href="<?= base_url() ?>Stock/sup_reg"><span
                                            class="nav-icon-hexa fa fa-user"></span> Supplier Registration</a>
                            </li>
                            <li>
                                <a href="#"><span class="nav-icon-hexa fa fa-btc"></span> Supplier's Banks </a>
                            </li>
                        </ul>
                    </li>
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
                                    class="icon-menu"></span></a></li>
                    <li style="text-align: center; vertical-align: middle; padding: 7px 0px;">
                        <div class="hidden-xs"><span id="chk_cnntion" title="Network status:"></span></div>
                    </li>
                    <li style="text-align: center; vertical-align: middle; padding: 7px 0px;">
                        <div class="hidden-xs">
                            <span style="color: #0F9DEA">LK Time : </span><span id="timecontainer2"></span>
                            <span id="lkTime" style="color: #e69c0f;">
                        <script type="text/javascript">new showLocalTime("lkTime", "server-php", 0, "short");</script></span>
                        </div>
                    </li>
                </ul>
                <form class="app-header-search" action="" method="post">
                    <input type="text" name="keyword" placeholder="Search">
                </form>
                <ul class="app-header-buttons pull-right">
                    <li>
                        <div class="contact contact-rounded contact-bordered contact-lg contact-ps-controls hidden-xs">

                            <img src="<?= base_url(); ?>assets/images/users/user_1.jpg" alt="John Doe">
                            <div class="contact-container">
                                <a href="#"> <?= $_SESSION['username'] ?></a>
                                <span> <?= $_SESSION['roleText'] ?> </span>
                            </div>

                            <div class="contact-controls">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-default btn-icon" data-toggle="dropdown"><span
                                                class="icon-envelope"></span></button>
                                    <ul class="dropdown-menu dropdown-left">

                                        <!-- <li><a href="pages-messages-chat.html"><span class="icon-envelope"></span>
                                                 Messages</a></li>
                                         <li><a href="pages-profile-card.html"><span class="icon-users"></span> Contacts</a>
                                         </li>
                                         <li class="divider"></li>
                                         <li><a href="pages-email-inbox.html"><span class="icon-envelope"></span> E-mail
                                                 <span class="label label-danger pull-right">19/2,399</span></a></li>-->
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>

                    </li>
                    <li>
                        <div class="dropdown">
                            <button class="btn btn-default btn-icon btn-informer" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="true"><span class="icon-alarm"></span><span
                                        class="informer informer-danger informer-sm informer-square">+3</span></button>
                            <ul class="dropdown-menu dropdown-form dropdown-left dropdown-form-wide">
                                <li class="padding-0">

                                    <div class="app-heading title-only app-heading-bordered-bottom">
                                        <div class="icon">
                                            <span class="icon-text-align-left"></span>
                                        </div>
                                        <div class="title">
                                            <h2>Notifications</h2>
                                        </div>
                                        <div class="heading-elements">
                                            <a href="#" class="btn btn-default btn-icon"><span class="icon-sync"></span></a>
                                        </div>
                                    </div>

                                    <div class="app-timeline scroll app-timeline-simple text-sm" style="height: 240px;">

                                        <!-- <div class="app-timeline-item">
                                             <div class="dot dot-primary"></div>
                                             <div class="content">
                                                 <div class="title margin-bottom-0"><a href="#">Jessie Franklin</a>
                                                     uploaded new file <strong>844_jswork.pdf</strong></div>
                                             </div>
                                         </div>

                                         <div class="app-timeline-item">
                                             <div class="dot dot-warning"></div>
                                             <div class="content">
                                                 <div class="title margin-bottom-0"><a href="#">Taylor Watson</a> changed
                                                     work status <strong>PSD Dashboard</strong></div>
                                             </div>
                                         </div>

                                         <div class="app-timeline-item">
                                             <div class="dot dot-success"></div>
                                             <div class="content">
                                                 <div class="title margin-bottom-0"><a href="#">Dmitry Ivaniuk</a>
                                                     approved project <strong>Boooya</strong></div>
                                             </div>
                                         </div>

                                         <div class="app-timeline-item">
                                             <div class="dot dot-success"></div>
                                             <div class="content">
                                                 <div class="title margin-bottom-0"><a href="#">Boris Shaw</a> finished
                                                     work on <strong>Boooya</strong></div>
                                             </div>
                                         </div>

                                         <div class="app-timeline-item">
                                             <div class="dot dot-danger"></div>
                                             <div class="content">
                                                 <div class="title margin-bottom-0"><a href="#">Jasmine Voyer</a>
                                                     declined order <strong>Project 155</strong></div>
                                             </div>
                                         </div>-->

                                    </div>

                                </li>
                                <li class="padding-top-0">
                                    <button class="btn btn-block btn-link">Preview All</button>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <!-- <a href="pages-login.html" class="btn btn-default btn-icon"><span class="icon-power-switch"></span></a>-->
                        <div class="contact-controls">
                            <div class="dropdown">
                                <button type="button" class="btn btn-default btn-icon" data-toggle="dropdown"><span
                                            class="icon-power-switch"></span></button>
                                <ul class="dropdown-menu dropdown-left">
                                    <li><a href="<?= base_url(); ?>User"><span class="icon-users"></span> User </a></li>
                                    <li class="divider"></li>
                                    <li><a href=""><span class="icon-user"></span>Your Profile</a></li>
                                    <li><a href="<?= base_url(); ?>welcome/lockScren"><span class="fa fa-lock"></span>
                                            Lock Screen</a></li>
                                    <li class="divider"></li>
                                    <li><a href="<?= base_url(); ?>welcome/logout"><span class="fa fa-sign-out"></span>
                                            Sign Out
                                        </a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <!-- END APP HEADER  -->



