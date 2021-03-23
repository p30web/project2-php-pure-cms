<?php
if(!defined('jk')) die('Access Not Allowed !');
global $View;
global $Users;
global $Cp;
$Users->loggedCheck();

$Cp->setSidebarActive('main/imageOptimization');

$View->footer_js( '
<script>
   
</script>
');
$View->head();

?>
    <div class="card card-info IRANSans">
        <div class="card-body">
            <?php
//            $factory = new \ImageOptimizer\OptimizerFactory();
            ?>
        </div>
    </div>

<?php
$View->foot();