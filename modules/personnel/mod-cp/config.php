<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_locations_countries')) {
    error403();
    die;
}
global $View;
global $Cp;

$Cp->setSidebarActive('personnel/config');
$View->head();

?>
<div class="card">
    <div class="card-body">
        <?php
            global $personnelConfigTabs;
            tab_menus($personnelConfigTabs, JK_DOMAIN_LANG . 'cp/personnel/config/',2);
            ?>
        <hr/>
        <?php
        echo alertInfo(__("please select a menu"));
        ?>
    </div>
</div>
<?php
$View->foot();
