<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_locations_countries')) {
    error403();
    die;
}
global $database;
$extra_float=[];
$getdatas=$database->select('jk_users_locations_countries','*',[
    'status'=>"active"
]);
if(sizeof($getdatas)>=1){
    foreach ($getdatas as $getdata){
        $extra_float[$getdata['id']]='<a href="'.JK_DOMAIN_LANG.'cp/users/locations/provinces/'.$getdata['id'].'" class="btn btn-sm btn-info">'.__("provinces").'</button>';
    }
}
NestableTableJS("jk_users_locations_countries",JK_DOMAIN_LANG . 'cp/users/locations/countries/list_sort',1,1);
NestableTableGetData('jk_users_locations_countries','jk_users_locations_countries', JK_LANG,0,$extra_float);
global $View;
echo $View->footer_js;