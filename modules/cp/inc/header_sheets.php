<?php
if(!defined('jk')) die('Access Not Allowed !');

?>
<li class="nav-item dropdown header-nav-dropdown header-nav-dropdown-<?php echo JK_DIRECTION; ?>">
    <a class="nav-link" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="fa fa-th"></span>
    </a>
    <div class="dropdown-arrow"></div>
    <!-- .dropdown-menu -->
    <div class="dropdown-menu dropdown-menu-rich dropdown-menu-right">
        <!-- .dropdown-sheets -->
        <div class="dropdown-sheets">
            <!-- .dropdown-sheet-item -->
            <?php
            if(sizeof($Cp->sheets)>=1){
                foreach ($Cp->sheets as $sheet){
                    ?>
                    <div class="dropdown-sheet-item">
                        <a href="<?php echo $sheet['link'] ?>" class="tile-wrapper">
                          <span class="tile tile-lg bg-indigo">
                            <i class="<?php echo $sheet['icon'] ?>"></i>
                          </span>
                            <span class="tile-peek"><?php echo $sheet['name'] ?></span>
                        </a>
                    </div>
            <?php
                }
            }else{
                ?>
                <a href="#" class="dropdown-item">
                    <div class="dropdown-item-body">
                        <p class="text text-muted"> <?php __e("there isn't any sheet") ?> </p>
                    </div>
                </a>
            <?php
            }
            ?>

        </div>
        <!-- .dropdown-sheets -->
    </div>
    <!-- .dropdown-menu -->
</li>
