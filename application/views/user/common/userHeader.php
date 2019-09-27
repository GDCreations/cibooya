<!-- APP WRAPPER -->
<div class="app">
    <?php
    clearstatcache();
    // LOAD USER PERMISSION MODULE
    $permMdul = $this->Generic_model->getPermisionModule();
    ?>
    <!-- START APP CONTAINER -->
    <div class="app-container">
        <!-- START SIDEBAR -->
        <div class="app-sidebar app-navigation app-navigation-fixed scroll app-navigation-style-default app-navigation-open-hover dir-left"
             data-type="close-other">
            <a href="#" class="app-navigation-logo"></a>
            <nav>
                <ul>
                    <li><a id="dashbrd" href="<?= base_url() ?>User"><span class="nav-icon-hexa icon-home"></span>
                            Dashboards </a></li>

                    <!--                    <li class="title">DEMONSTRATION</li>-->
                    <?php
                    if (in_array('cusMng', $permMdul, TRUE)) {
                        ?>
                        <li id="cusMng">
                            <a href="#"><span class="nav-icon-hexa fa fa-users"></span> Customer Management</a>
                            <ul>
                                <?php if (in_array("cusReg", $permission, TRUE)) { ?>
                                    <li>
                                        <a id="cusReg" href="<?= base_url() ?>user/cusReg"><span
                                                    class="nav-icon-hexa fa fa-user"></span> Customer Registration</a>
                                    </li>
                                <?php } ?>
                                <li>
                                    <a href="#"><span class="nav-icon-hexa fa fa-btc"></span> Customer's Banks </a>
                                </li>
                            </ul>
                        </li>
                    <?php } ?>
                    <li class="title" id="Settings_title">SYSTEM SUPPORT</li>
                    <li id="sysCmp">
                        <a href="#"><span class="nav-icon-hexa fa fa-cog"></span> SYSTEM SUPPORT</a>
                        <ul>
                            <li><a href="http://northpony.com/software/AA_v3.6.zip" target='_blank'>
                                    <span class='nav-icon-hexa fa fa-cloud-download'></span> Ammyy Admin Software</a>
                            </li>
                            <li><a href="http://northpony.com/software/AnyDesk.zip" target='_blank'>
                                    <span class='nav-icon-hexa fa fa-cloud-download'></span> AnyDesk Software</a></li>
                            <li><a href="http://northpony.com/System_support/How_To_Enable_Popup_Chrome_Browser.pdf"
                                   target='_blank'>
                                    <span class='nav-icon-hexa fa fa-file-pdf-o'></span> Enable Popup </a></li>
                            <li><a href="http://northpony.com/System_support/How_to_clear_browse_cache.pdf"
                                   target='_blank'>
                                    <span class='nav-icon-hexa fa fa-file-pdf-o'></span> Clear Browse Cache </a></li>
                            <li><a href="http://northpony.com/System_support/Support_ticket_instructions_file.pdf"
                                   target='_blank'>
                                    <span class='nav-icon-hexa fa fa-file-pdf-o'></span> Support Ticket Instruction </a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="https://support.northpony.com" target="_blank">
                            <span class="nav-icon-hexa fa fa-headphones"></span> Support Ticket
                            <span class="label label-warning animated infinite rubberBand">New !</span>
                        </a></li>


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
                </ul>
                <form class="app-header-search" action="" method="post">
                    <input type="text" name="keyword" placeholder="Search">
                </form>
                <ul class="app-header-buttons">
                    <li style="text-align: center; vertical-align: middle; padding: 7px 0px;">
                        <div class="hidden-xs"><span id="chk_cnntion" title="Network status:"></span></div>
                    </li>
                    <li style="text-align: center; vertical-align: middle; padding: 7px 0px;">
                        <div class="hidden-xs">
                            <span style="color: #0F9DEA"><img src="<?= base_url() ?>assets/img/flags/lk.png"
                                                              alt="Sri Lanka"
                                                              title="Sri Lanka" width="23"
                                                              height="23"/> Time : </span><span
                                    id="timecontainer2"></span>
                            <span id="lkTime" style="color: #e69c0f;">
                                        <script type="text/javascript">new showLocalTime("lkTime", "server-php", 0, "short");</script></span>
                        </div>
                    </li>
                </ul>
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
                                        <!-- <li><a href="pages-profile-social.html"><span class="icon-users"></span> Account</a>
                                         </li>
                                         <li><a href="pages-messages-chat.html"><span class="icon-envelope"></span>
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

                                        <!--<div class="app-timeline-item">
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
                                    <?php $spst = $this->Generic_model->getSpecStting('msve');
                                    if ($_SESSION['role'] == 1 || $_SESSION['role'] == $spst) { ?>
                                        <li><a href="<?= base_url(); ?>admin"><span class="icon-users"></span> Master
                                                Setting</a></li>
                                        <li class="divider"></li>
                                        <?php
                                    }
                                    ?>
                                    <li><a href=""><span class="icon-user"></span>Your Profile</a></li>
                                    <li><a href="<?= base_url(); ?>welcome/lockScren"><span class="icon-lock"></span>
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