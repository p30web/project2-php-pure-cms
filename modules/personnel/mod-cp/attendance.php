<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('personnel_attendance')) {
    error403();
    die;
}
global $View;
global $Users;
global $Route;
global $database;
global $Cp;
$Cp->setSidebarActive('personnel/attendance');
$View->head();
?>
    <div class="card">
        <div class="card-body">
            <?php
            global $attendanceTabs;
            tab_menus($attendanceTabs, JK_DOMAIN_LANG . 'cp/personnel/attendance/',2);
            ?>
            <hr/>
            <?php
            echo alertInfo(__("please select a menu"));
            ?>
        </div>
    </div>
<?php
$View->foot();