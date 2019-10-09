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
                    <li><a id="dashbrd" href="<?= base_url() ?>Admin"><span class="nav-icon-hexa icon-home"></span>
                            Dashboards </a></li>
                    <?php
                    if (in_array('gnrl', $permMdul, TRUE)) {
                        ?>
                        <li id="gnrl">
                            <a href="#"><span class="nav-icon-hexa fa fa-globe"></span> General</a>
                            <ul>
                                <?php if (in_array("branding", $permission, TRUE)) { ?>
                                    <li><a id="branding" href="<?= base_url() ?>admin/branding">
                                            <span class="nav-icon-hexa fa fa-sliders"></span> Branding</a>
                                    </li>
                                <?php } ?>
                                <?php if (in_array("policyMng", $permission, TRUE)) { ?>
                                    <li><a id="policyMng" href="<?= base_url() ?>admin/policyMng">
                                            <span class="nav-icon-hexa fa fa-list-alt"></span> Policy Management</a>
                                    </li>
                                <?php } ?>
                                <?php if (in_array("rcntAct", $permission, TRUE)) { ?>
                                    <li><a id="rcntAct" href="<?= base_url() ?>admin/rcntAct">
                                            <span class="nav-icon-hexa fa fa-sliders"></span> Recent Activity</a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>
                    <li class="title" id="Settings_title">SETTINGS</li>
                    <?php $Settings_title = true; ?>
                    <?php if (in_array('sysCmp', $permMdul, TRUE)) { ?>
                        <li id="sysCmp">
                            <a href="#"><span class="nav-icon-hexa fa fa-cog"></span> System Components</a>
                            <ul>
                                <?php if (in_array("sysBrnc", $permission, TRUE)) { ?>
                                    <li><a id="sysBrnc" href="<?= base_url() ?>admin/sysBrnc">
                                            <span class="nav-icon-hexa fa fa-columns"></span> Branch Management</a>
                                    </li>
                                <?php } ?>
                                <?php if (in_array("usrMng", $permission, TRUE)) { ?>
                                    <li><a id="usrMng" href="<?= base_url() ?>admin/usrMng">
                                            <span class="nav-icon-hexa fa fa-users"></span> User Management</a>
                                    </li>
                                <?php } ?>
                                <?php if (in_array("usrLvl", $permission, TRUE)) { ?>
                                    <li><a id="usrLvl" href="<?= base_url() ?>admin/usrLvl">
                                            <span class="nav-icon-hexa fa fa-sitemap"></span> User Level</a>
                                    </li>
                                <?php } ?>

                            </ul>
                        </li>
                        <?php $Settings_title = false;
                    } ?>
                    <?php if (in_array('advStts', $permMdul, TRUE)) { ?>
                        <li id="advStts">
                            <a href="#"><span class="nav-icon-hexa fa fa-cogs"></span> Advance Settings</a>
                            <ul>
                                <?php if (in_array("permis", $permission, TRUE)) { ?>
                                    <li>
                                        <a id="permis" href="<?= base_url() ?>Admin/permis"><span
                                                    class="nav-icon-hexa fa fa-check-square-o"></span> Permission
                                            Management</a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                        <?php $Settings_title = false;
                    }
                    //MAIN TITLE
                    if ($Settings_title) { ?>
                        <script>
                            $('#Settings_title').css('display', 'none');
                        </script>
                    <?php } ?>

                    <li class="title" id="Stock_title">STOCK</li>
                    <?php $Stock_title = true;
                    if (in_array('stcCmp', $permMdul, TRUE)) { ?>
                        <li id="stcCmp">
                            <a href="#"><span class="nav-icon-hexa fa fa-cog"></span> Stock Components</a>
                            <ul>
                                <?php if (in_array("supReg", $permission, TRUE)) { ?>
                                    <li>
                                        <a id="supReg" href="<?= base_url() ?>Stock/supReg"><span
                                                    class="nav-icon-hexa fa fa-user"></span> Supplier Registration</a>
                                    </li>
                                <?php } ?>
                                <?php if (in_array("catMng", $permission, TRUE)) { ?>
                                    <li>
                                        <a id="catMng" href="<?= base_url() ?>Stock/catMng"><span
                                                    class="nav-icon-hexa fa fa-th-large"></span> Category Management</a>
                                    </li>
                                <?php } ?>
                                <?php if (in_array("brndMng", $permission, TRUE)) { ?>
                                    <li>
                                        <a id="brndMng" href="<?= base_url() ?>Stock/brndMng"><span
                                                    class="nav-icon-hexa fa fa-anchor"></span> Brand Management </a>
                                    </li>
                                <?php } ?>
                                <?php if (in_array("typeMng", $permission, TRUE)) { ?>
                                    <li>
                                        <a id="typeMng" href="<?= base_url() ?>Stock/typeMng"><span
                                                    class="nav-icon-hexa fa fa-navicon"></span> Type Management </a>
                                    </li>
                                <?php } ?>
                                <?php if (in_array("itemMng", $permission, TRUE)) { ?>
                                    <li>
                                        <a id="itemMng" href="<?= base_url() ?>Stock/itemMng"><span
                                                    class="nav-icon-hexa fa fa-cubes"></span> Item Management </a>
                                    </li>
                                <?php } ?>
                                <?php if (in_array("whsMng", $permission, TRUE)) { ?>
                                    <li>
                                        <a id="whsMng" href="<?= base_url() ?>Stock/whsMng"><span
                                                    class="nav-icon-hexa fa fa-institution"></span> Warehouse Management
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                        <?php $Stock_title = false;
                    } ?>

                    <?php if (in_array('stcAcs', $permMdul, TRUE)) { ?>
                        <li id="stcAcs">
                            <a href="#"><span class="nav-icon-hexa fa fa-database"></span> Stock Access</a>
                            <ul>
                                <?php if (in_array("pchOdr", $permission, TRUE)) { ?>
                                    <li><a id="pchOdr" href="<?= base_url() ?>Stock/pchOdr">
                                            <span class="nav-icon-hexa fa fa-list-ul"></span> Purchase Order </a>
                                    </li>
                                <?php } ?>
                                <?php if (in_array("grnMng", $permission, TRUE)) { ?>
                                    <li><a id="grnMng" href="<?= base_url() ?>Stock/grnMng">
                                            <span class="nav-icon-hexa fa fa-list-ul"></span> Good Received Note (GRN) </a>
                                    </li>
                                <?php } ?>
                                <?php if (in_array("stckMng", $permission, TRUE)) { ?>
                                    <li><a id="stckMng" href="<?= base_url() ?>Stock/stckMng">
                                            <span class="nav-icon-hexa fa fa-cubes"></span> Stock Management </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                        <?php $Stock_title = false;
                    } ?>

                    <?php
                    //MAIN TITLE
                    if ($Stock_title) { ?>
                        <script>
                            $('#Stock_title').css('display', 'none');
                        </script>
                    <?php } ?>


                    <?php if ($_SESSION['role'] == 1) { ?>
                        <li class="title" id="Settings_title">MIT SETTINGS</li>
                        <li><a id="mitVers" href="<?= base_url() ?>Mitadmin/mitVers">
                                <span class="nav-icon-hexa fa fa-code-fork"></span> MIT version Management</a>
                        </li>
                        <li><a id="sysUpdate" href="<?= base_url() ?>Mitadmin/sysUpdate">
                                <span class="nav-icon-hexa fa fa-wrench"></span> system update</a>
                        </li>
                        <li><a id="sysChanlg" href="<?= base_url() ?>Mitadmin/sysChanlg">
                                <span class="nav-icon-hexa fa fa-upload"></span> change log</a>
                        </li>

                    <?php } ?>

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

                <!-- START TOP RIGHT CORNER NOTIFICATION PANEL-->
                <?php
                $tody = date('Y-m-d');
                $role = $_SESSION['role'];
                $usid = $_SESSION['userId'];
                $this->load->model('Generic_model'); // load model
                if ($role == 1) {
                    $this->db->select("syst_mesg.mdle,syst_mesg.chng,user_mas.usnm AS desg, DATE_FORMAT(syst_mesg.crdt, '%Y-%m-%d') AS crdt");
                    $this->db->from("syst_mesg");
                    $this->db->join('user_mas', 'user_mas.auid = syst_mesg.crby');
                    $this->db->where('syst_mesg.stat', 1);
                    $this->db->where(" DATE_ADD(DATE_FORMAT(syst_mesg.crdt, '%Y-%m-%d'), INTERVAL +7 DAY) > '$tody'");
                    $this->db->order_by("syst_mesg.crdt", "desc");
                } else {
                    $this->db->select("test.*, user_mas.usnm AS desg, user_mas.auid , DATE_FORMAT(test.crdt, '%Y-%m-%d') AS crdt");
                    $this->db->from("user_mas");
                    $this->db->join("( SELECT * FROM syst_mesg WHERE cmtp=1
                         UNION SELECT * FROM syst_mesg WHERE cmtp=2 AND uslv='$role' 
                         UNION SELECT * FROM syst_mesg WHERE mgus='$usid') AS test ", "test.crby=user_mas.auid");
                    $this->db->where(" DATE_ADD(DATE_FORMAT(test.crdt, '%Y-%m-%d'), INTERVAL +7 DAY) > '$tody'");
                    $this->db->order_by("test.crdt", "desc");
                }
                $query = $this->db->get();
                $syschng = $query->result();
                ?>
                <!-- END TOP RIGHT CORNER NOTIFICATION PANEL-->

                <ul class="app-header-buttons pull-right">
                    <li>
                        <div class="contact contact-rounded contact-bordered contact-lg contact-ps-controls hidden-xs">

                            <img src="<?= base_url(); ?>uploads/user-image/<?= $_SESSION['uimg'] ?>" alt="">
                            <div class="contact-container">
                                <a href="#"> <?= $_SESSION['username'] ?></a>
                                <span> <?= $_SESSION['roleText'] ?> </span>
                            </div>

                            <div class="contact-controls">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-default btn-icon btn-informer"
                                            data-toggle="dropdown"
                                            title="Notification">
                                        <span class="icon-envelope"></span>
                                        <span class="informer informer-warning informer-sm informer-square"><?= sizeof($syschng); ?></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-form dropdown-left dropdown-form-wide">
                                        <li class="padding-0">
                                            <div class="app-heading title-only app-heading-bordered-bottom">
                                                <div class="icon">
                                                    <span class="icon-text-align-left"></span>
                                                </div>
                                                <div class="title">
                                                    <h2>New Message</h2>
                                                </div>
                                                <div class="heading-elements">
                                                    <a href="#"
                                                       class="btn btn-default btn-icon"><?= sizeof($syschng); ?></a>
                                                </div>
                                            </div>

                                            <div class="app-timeline scroll app-timeline-simple text-sm"
                                                 style="height: 240px;">

                                                <?php for ($i = 0; $i < sizeof($syschng); $i++) { ?>
                                                    <!--<a href="#" class="list-group-item">
                                                        <div class="list-group-status status-online"></div>
                                                        <img src="<? /*= base_url(); */ ?>uploads/user_default.png"
                                                             class="pull-left"
                                                             alt="John Doe"/>
                                                        <span class="contacts-title"><? /*= $syschng[$i]->desg; */ ?></span><span
                                                                class="pull-right"> <? /*= $syschng[$i]->crdt; */ ?></span>
                                                        <p><? /*= $syschng[$i]->mdle . ' - ' . $syschng[$i]->chng; */ ?></p>
                                                    </a>-->

                                                    <div class="app-timeline-item">
                                                        <div class="dot dot-warning"></div>
                                                        <div class="content">
                                                            <div class="title margin-bottom-0">
                                                                <a href="#"><?= $syschng[$i]->desg; ?></a>
                                                                <?= $syschng[$i]->mdle; ?>
                                                                <strong><?= $syschng[$i]->chng ?></strong></div>
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                                <!--<div class="app-timeline-item">
                                                    <div class="dot dot-primary"></div>
                                                    <div class="content">
                                                        <div class="title margin-bottom-0"><a href="#">Jessie
                                                                Franklin</a>
                                                            uploaded new file <strong>844_jswork.pdf</strong></div>
                                                    </div>
                                                </div>

                                                <div class="app-timeline-item">
                                                    <div class="dot dot-warning"></div>
                                                    <div class="content">
                                                        <div class="title margin-bottom-0"><a href="#">Taylor Watson</a>
                                                            changed
                                                            work status <strong>PSD Dashboard</strong></div>
                                                    </div>
                                                </div>

                                                <div class="app-timeline-item">
                                                    <div class="dot dot-success"></div>
                                                    <div class="content">
                                                        <div class="title margin-bottom-0"><a href="#">Dmitry
                                                                Ivaniuk</a>
                                                            approved project <strong>Boooya</strong></div>
                                                    </div>
                                                </div>

                                                <div class="app-timeline-item">
                                                    <div class="dot dot-success"></div>
                                                    <div class="content">
                                                        <div class="title margin-bottom-0"><a href="#">Boris Shaw</a>
                                                            finished
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
                                            <button class="btn btn-block btn-link"><a
                                                        href="<?= base_url() ?>user/systMsg"> Preview All </a></button>
                                        </li>
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
                                    <li><a href="<?= base_url(); ?>welcome/userProfile"><span class="icon-user"></span>Your
                                            Profile</a></li>
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