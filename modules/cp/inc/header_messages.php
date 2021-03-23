<?php
if(!defined('jk')) die('Access Not Allowed !');

?><li class="nav-item dropdown header-nav-dropdown header-nav-dropdown-<?php echo JK_DIRECTION; ?>">
    <a class="nav-link" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="fa fa-envelope-open"></span>
    </a>
    <div class="dropdown-arrow"></div>
    <!-- .dropdown-menu -->
    <div class="dropdown-menu dropdown-menu-rich dropdown-menu-right">
        <h6 class="dropdown-header stop-propagation">
            <span><?php __e("Messages"); ?></span>
            <a href="#"><?php __e("mark all as read"); ?></a>
        </h6>
        <!-- .dropdown-scroll -->
        <div class="dropdown-scroll has-scrollable">

            <?php
            if(sizeof($Cp->messages)>=1){
                foreach ($Cp->messages as $message){
                    ?>
                    <a href="#" class="dropdown-item <?php
                    if($message['unread']){ echo 'unread'; }
                    ?>">
                        <div class="user-avatar">
                            <img src="<?php echo $message['img']; ?>" alt=""> </div>
                        <div class="dropdown-item-body">
                            <p class="subject"> <?php echo nickName($message['userID']) ?> </p>
                            <p class="text text-truncate"> <?php echo $message['text']; ?> </p>
                            <span class="date"><?php echo $message['date']; ?></span>
                        </div>
                    </a>
                    <?php
                }
            }else{
                ?>
                <a href="#" class="dropdown-item">
                    <div class="dropdown-item-body">
                        <p class="text text-muted"> <?php echo __("no message found"); ?> </p>
                    </div>
                </a>
                <?php
            }
            ?>
        </div>
        <!-- /.dropdown-scroll -->
        <a href="" class="dropdown-footer"><?php __e("All messages"); ?>
            <i class="fa fa-fw fa-long-arrow-alt-right"></i>
        </a>
    </div>
    <!-- /.dropdown-menu -->
</li>
