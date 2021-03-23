<?php
if(!defined('jk')) die('Access Not Allowed !');
?>
<li class="nav-item dropdown header-nav-dropdown header-nav-dropdown-<?php echo JK_DIRECTION; ?>">
    <a class="nav-link has-badge" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php
        $activitySize=sizeof($Cp->activities);
            if($activitySize>=1){
                ?>
        <span class="badge badge-pill badge-warning">
            <?php
                echo $Cp->activities;
            ?>
            </span>
            <?php
            }
            ?>
        <span class="fab fa-spotify"></span>
    </a>
    <div class="dropdown-arrow"></div>
    <!-- .dropdown-menu -->
    <div class="dropdown-menu dropdown-menu-rich dropdown-menu-right">
        <h6 class="dropdown-header stop-propagation">
                      <span><?php __e("Activities"); ?>
                        <span class="badge">(<?php echo $activitySize; ?>)</span>
                      </span>
        </h6>
        <!-- .dropdown-scroll -->
        <div class="dropdown-scroll has-scrollable">
            <?php
            if($activitySize>=1){
                foreach ($Cp->activities as $activity){
                    ?>
                    <a href="<?php $activity['link'] ?>" class="dropdown-item <?php
                    if($activity['unread']){ echo 'unread'; }
                    ?>">
                        <div class="user-avatar">
                            <img src="<?php echo $activity['img']; ?>" alt=""> </div>
                        <div class="dropdown-item-body">
                            <p class="text"> <?php echo $activity['text']; ?> </p>
                            <span class="date"><?php echo $activity['date']; ?></span>
                        </div>
                    </a>
            <?php
                }
            }else{
               ?>
                <a href="#" class="dropdown-item">
                    <div class="dropdown-item-body">
                        <p class="text text-muted"> <?php echo __("no activity found"); ?> </p>
                    </div>
                </a>
            <?php
            }
            ?>

        </div>
        <!-- /.dropdown-scroll -->
        <a href="" class="dropdown-footer"><?php __e("All activities"); ?>
            <i class="fa fa-fw fa-long-arrow-alt-right"></i>
        </a>
    </div>
    <!-- /.dropdown-menu -->
</li>