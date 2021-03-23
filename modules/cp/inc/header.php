<?php
if(!defined('jk')) die('Access Not Allowed !');

global $View;
global $Users;
$View->setBrandIconUrl("inverse");

?>
<header class="app-header">
    <!-- .top-bar -->
    <div class="top-bar">
        <!-- .top-bar-brand -->
        <div class="top-bar-brand">
            <a href="">
                <img src="<?php
                echo $View->getBrandIconUrl();
                ?>" height="32" alt="">
                <span class="d-none d-md-inline-block"><?php echo $View->title; ?></span>
            </a>
        </div>
        <!-- /.top-bar-brand -->
        <!-- .top-bar-list -->
        <div class="top-bar-list">
            <!-- .top-bar-item -->
            <div class="top-bar-item px-2 d-md-none d-lg-none d-xl-none">
                <!-- toggle menu -->
                <button class="hamburger hamburger-squeeze" type="button" data-toggle="aside" aria-label="Menu"
                        aria-controls="navigation">
                <span class="hamburger-box">
                  <span class="hamburger-inner"></span>
                </span>
                </button>
                <!-- /toggle menu -->
            </div>
            <!-- /.top-bar-item -->
            <!-- .top-bar-item -->
            <div class="top-bar-item top-bar-item-<?php echo JK_DIRECTION_SIDE; ?> px-0">
                <!-- .nav -->
                <ul class="header-nav nav">
                    <?php
                    global $database;
                    $languages=$database->select('jk_languages','*',[
                            "AND"=>[
                                    "websiteID"=>$Route->websiteID,
                                "status"=>"active"
                                ]
                    ]);
                    if(sizeof($languages)>=1){
                      ?>
                        <li class="nav-item dropdown header-nav-dropdown header-nav-dropdown-<?php echo JK_DIRECTION; ?>">
                            <a class="nav-link has-badge" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="fa fa-language"></span>
                            </a>
                            <div class="dropdown-arrow"></div>
                            <!-- .dropdown-menu -->
                            <div class="dropdown-menu dropdown-menu-rich dropdown-menu-right">
                                <h6 class="dropdown-header stop-propagation">
                      <span><?php __e("select language"); ?>
                      </span>
                                </h6>
                                <!-- .dropdown-scroll -->
                                <div class="dropdown-scroll has-scrollable">
                                    <?php
                                    $newUri=ltrim($Route->uri,$Route->lang.'/');

                                    foreach ($languages as $language){
                                            ?>
                                            <a href="<?php echo JK_DOMAIN.$language['slug'].'/'.$newUri; ?>" class="dropdown-item">
                                                <div class="dropdown-item-body">
                                                    <p class="text"> <?php echo $language['name']; ?> </p>
                                                </div>
                                            </a>
                                            <?php
                                        }
                                    ?>

                                </div>
                            </div>
                            <!-- /.dropdown-menu -->
                        </li>

                        <?php

                    }
                    ?>
                    <?php
                    if ($Users->isLogged()) {
                        ?>
                        <!-- .nav-item -->
                        <?php
                        include(__DIR__ . '/header_activities.php');
                        ?>
                        <!-- /.nav-item -->

                        <!-- .nav-item -->
                        <?php
                        include(__DIR__ . '/header_messages.php');
                        ?>
                        <!-- /.nav-item -->

                        <!-- .nav-item -->
                        <?php
                        include(__DIR__ . '/header_sheets.php');
                        ?>
                        <!-- /.nav-item -->

                        <?php
                    }
                    ?>
                    <li class="nav-item dropdown header-nav-dropdown header-nav-dropdown-<?php echo JK_DIRECTION; ?>">
                        <a class="nav-link" href="<?php echo JK_DOMAIN_LANG ?>" target="_blank">
                            <span class="fa fa-eye"></span>
                        </a>
                    </li>
                    <!-- .nav-item -->
                    <!-- /.nav-item -->
                </ul>
                <!-- /.nav -->
                <!-- .btn-account -->
                <div class="dropdown d-none d-sm-flex">
                    <?php
                    if ($Users->isLogged()) {
                        ?>
                        <button class="btn-account" type="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                  <span class="user-avatar">
                    <img src="<?php echo \Joonika\Modules\Users\profileImage(JK_LOGINID) ?>" alt="">
                  </span>
                            <span class="account-summary pr-lg-4 d-none d-md-block">
                    <span class="account-name"><?php echo nickName($Users->loggedID); ?></span>
                    <span class="account-description"><?php echo \Joonika\Modules\Users\usersRoleGroupsHTML($Users->loggedID); ?></span>
                  </span>
                        </button>
                        <div class="dropdown-arrow dropdown-arrow-left"></div>
                        <!-- .dropdown-menu -->
                        <div class="dropdown-menu">
                            <h6 class="dropdown-header d-none d-sm-block d-md-none"> <?php echo nickName($Users->loggedID); ?> </h6>
                            <?php
                            $icons=$Cp->topIconsUsers;
                            if(sizeof($icons)>=1){
                                foreach ($icons as $icon){
                                    ?>
                                    <a class="dropdown-item" href="<?php echo $icon['link'] ?>">
                                        <span class="dropdown-icon <?php echo $icon['icon'] ?>"></span> <?php echo $icon['text'] ?></a>
                            <?php
                                }
                            }
                            ?>
                            <a class="dropdown-item" href="<?php echo JK_DOMAIN_LANG ?>cp/main/logout/">
                                <span class="dropdown-icon oi oi-account-logout"></span> <?php __e("Logout") ?></a>
                        </div>
                        <!-- /.dropdown-menu -->
                        <?php
                    } else {
                        ?>
                        <a class="btn btn-info" href="<?php echo JK_DOMAIN_LANG ?>">
                            <?php __e("Login") ?>
                        </a>
                        <a class="btn btn-success" href="">
                            <?php __e("Register") ?>
                        </a>
                        <?php
                    }
                    ?>


                </div>
                <!-- /.btn-account -->
            </div>
            <!-- /.top-bar-item -->
        </div>
        <!-- /.top-bar-list -->
    </div>
    <!-- /.top-bar -->
</header>