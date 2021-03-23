<?php
if(!defined('jk')) die('Access Not Allowed !');
global $Users;
$Users->loggedCheck();
global $ACL;
if (!$ACL->hasPermission('cp_main')) {
    error403();
    die;
}
global $View;
global $Cp;
$View->head();
global $dashboard;
$dashboard=new \Joonika\Modules\Cp\Dashboard();
\Joonika\listModulesReadFiles('cp-dashboard.php');

//$dashboard->get_widgets();
?>

<?php
$View->foot();