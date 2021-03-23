<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACl;
?><aside class="app-aside app-aside-<?php echo JK_DIRECTION_SIDE; ?>">
    <!-- .aside-content -->
    <div class="aside-content">
        <!-- .aside-header -->
        <header class="aside-header d-block d-md-none">
            <!-- .btn-account -->
            <button class="btn-account" type="button" data-toggle="collapse" data-target="#dropdown-aside">
              <span class="user-avatar user-avatar-lg">
                <img src="<?php echo \Joonika\Modules\Users\profileImage(JK_LOGINID) ?>" alt="">
              </span>
                <span class="account-icon">
                <span class="fa fa-caret-down fa-lg"></span>
              </span>
                <span class="account-summary">
                <span class="account-name"><?php echo nickName($Users->loggedID); ?></span>
                <span class="account-description"><?php echo \Joonika\Modules\Users\usersRoleGroupsHTML($Users->loggedID); ?></span>
              </span>
            </button>
            <!-- /.btn-account -->
            <!-- .dropdown-aside -->
            <div id="dropdown-aside" class="dropdown-aside collapse">
                <!-- dropdown-items -->
                <div class="pb-3">
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
                <!-- /dropdown-items -->
            </div>
            <!-- /.dropdown-aside -->
        </header>
        <!-- /.aside-header -->
        <!-- .aside-menu -->
        <section class="aside-menu has-scrollable">
            <!-- .stacked-menu -->
            <nav id="stacked-menu" class="stacked-menu">
                <!-- .menu -->
                <ul class="menu">
                    <!-- .menu-item -->
                    <?php

                    ?>
                    <li class="menu-item <?php
                    if (isset($Route->path[1]) && $Route->path[1] == 'main' && !isset($Route->path[2])) {
                        echo 'has-active';
                    }
                    ?>">
                        <a href="<?php echo JK_DOMAIN_LANG ?>cp/" class="menu-link">
                            <span class="menu-icon oi oi-dashboard"></span>
                            <span class="menu-text"><?php __e("Dashboard") ?></span>
                        </a>
                    </li>

                    <?php
                    $sidebars = $Cp->sidebar();
                    $sidebarActive = $Cp->getSidebarActive();
                    $sidebarActives = explode('/', $sidebarActive);
                    $check = true;
                    $ACl=new \Joonika\ACL();
                    if (sizeof($sidebars) >= 1) {
                        foreach ($sidebars as $sidebar) {
//print_r($sidebar);
                            if($ACl->hasPermission($sidebar['name'])){

                            $thisActive = "";
                            if (isset($sidebar['sub']) && sizeof($sidebar['sub']) >= 1) {
                                if ($check) {
                                    if ($sidebar['name'] == $sidebarActives[0]) {
                                        $thisActive = "has-active";
                                        $check=false;
                                    }
                                }
                                if(isset($sidebar['head'])){
                                    ?>
                                    <li class="menu-header"><?php echo $sidebar['head']; ?></li>
                                    <?php
                                }
                                if(!isset($sidebar['link'])){
                                    $sidebar['link']="#";
                                }
                                ?>
                                <li class="menu-item has-child <?php echo $thisActive; ?>">
                                    <a href="<?php echo $sidebar['icon'] ?>" class="menu-link menu-link-<?php echo JK_DIRECTION; ?>">
                                        <span class="menu-icon <?php echo $sidebar['icon'] ?>"></span>
                                        <span class="menu-text"><?php echo $sidebar['title'] ?></span>
                                        <!--                            <span class="badge badge-warning">New</span>-->
                                    </a>
                                    <!-- child menu -->
                                    <ul class="menu">
                                        <?php
                                        foreach ($sidebar['sub'] as $sidebarsub) {
                                            if($sidebarsub['icon'] && $sidebarsub['icon']!=""){
                                                $icon=$sidebarsub['icon'];
                                            }else{
                                                $icon='';
                                            }
                                            if (isset($sidebarsub['name'])) {
                                                $name = $sidebarsub['name'];
                                            } else {
                                                $name = $sidebarsub['link'];
                                            }
                                            if (substr($sidebarsub['link'], 0, 4) == "http") {
                                                $link = $sidebarsub['link'];
                                            } else {
                                                $link = JK_DOMAIN_LANG . 'cp/' . $sidebar['name'] . '/' . $sidebarsub['link'];
                                            }
                                            if($ACl->hasPermission($sidebar['name'].'_'.$name)){

                                                ?>
                                            <li class="menu-item <?php if ($sidebarActive == $sidebar['name'] . '/' . $name) {
                                                echo 'has-active';
                                            } ?>">
                                                <a href="<?php echo $link ?>"
                                                   class="menu-link">
                                                    <span class="menu-icon <?php echo $icon ?>"></span>
                                                    <?php echo $sidebarsub['title'] ?>
                                                </a>
                                            </li>
                                            <?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                    <!-- /child menu -->
                                </li>

                                <?php
                            } else {
	                            if ($sidebar['name'] == $sidebarActives[0]) {
		                            $thisActive = "has-active";
		                            $check=false;
	                            }
	                            if(!isset($sidebar['link'])){
		                            $sidebar['link']="#";
	                            }
                                ?>

                                <li class="menu-item <?php echo $thisActive; ?>">
                                    <a href="<?php echo $sidebar['link']; ?>" class="menu-link menu-link-<?php echo JK_DIRECTION; ?>">
                                        <span class="menu-icon <?php echo $sidebar['icon'] ?>"></span>
                                        <span class="menu-text"><?php echo $sidebar['title'] ?></span>
                                    </a>
                                </li>
                                <?php
                            }
                            }
                        }
                    }
                    ?>
                </ul>
                <!-- /.menu -->
            </nav>
            <!-- /.stacked-menu -->
        </section>
        <!-- /.aside-menu -->
    </div>
    <!-- /.aside-content -->
</aside>