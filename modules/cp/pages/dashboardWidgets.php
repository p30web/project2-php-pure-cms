<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
global $Users;
global $dashboard;
$Users->loggedCheck();
if (!$ACL->hasPermission('cp_dashboardWidgets')) {
    error403();
    die;
}
global $Cp;
global $View;

$Cp->setSidebarActive('main/dashboardWidgets');

$View->footer_js( '
<script>
   
</script>
');
$View->head();

?>
    <div class="card card-info IRANSans">
        <div class="card-body">
                <?php
                echo 'heloo';

                ?>
        </div>
    </div>

<?php
$View->foot();