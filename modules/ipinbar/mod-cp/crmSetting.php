<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('crm_tickets_config')) {
    error403();
    die;
}
global $View;
global $Users;
global $Route;
global $database;
global $Cp;
$Cp->setSidebarActive('ipinbar/crmSetting');
$View->head();
?>
    <div class="card">
        <div class="card-body">
            <?php
            global $ipinBarCrmSetting;
            tab_menus($ipinBarCrmSetting, JK_DOMAIN_LANG . 'cp/ipinbar/crmSetting/',2);
            ?>
            <hr/>
            <?php
            echo alertInfo(__("please select a menu"));
            ?>
        </div>
    </div>
<?php
$View->foot();