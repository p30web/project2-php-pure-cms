<?php
if(!defined('jk')) die('Access Not Allowed !');
global $View;
global $Users;
global $Cp;
$Users->loggedCheck();

$Cp->setSidebarActive('main/templateSetting');

$View->footer_js( '
<script>
   
</script>
');
$View->head();

?>
    <div class="card card-info IRANSans">
        <div class="card-body">
            <?php __e("soon") ?>
        </div>
    </div>

<?php
$View->foot();