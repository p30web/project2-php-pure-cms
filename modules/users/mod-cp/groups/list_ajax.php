<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_groups')) {
    error403();
    die;
}
NestableTableJS("jk_groups",JK_DOMAIN_LANG . 'cp/users/groups/list_sort',20,20);
NestableTableGetData('jk_groups','jk_groups', JK_LANG);
global $View;
echo $View->footer_js;