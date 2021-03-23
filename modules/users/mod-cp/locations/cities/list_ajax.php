<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_locations_cities')) {
    error403();
    die;
}
global $Route;
if(isset($Route->path[4])){
    $provinceID=$Route->path[4];
}else{
    $provinceID=0;
}
NestableTableJS("jk_users_locations_cities",JK_DOMAIN_LANG . 'cp/users/locations/cities/list_sort',1,1);
NestableTableGetData('jk_users_locations_cities','jk_users_locations_cities', JK_LANG,0,[],$provinceID);
global $View;
echo $View->footer_js;