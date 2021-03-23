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
$Cp->setSidebarActive('crm/ticketsConfig');
$View->head();
?>
    <div class="card">
        <div class="card-body">
            <?php
            global $ticketsConfig;
            tab_menus($ticketsConfig, JK_DOMAIN_LANG . 'cp/crm/ticketsConfig/',2);
            ?>
            <hr/>
            <?php
            echo alertInfo(__("please select a menu"));
            ?>
        </div>
    </div>
<?php
$View->foot();