<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_locations_provinces')) {
    error403();
    die;
}
$exra_float=[];
$countryID=0;
global $Route;
if(isset($Route->path[4])){
    $countryID=$Route->path[4];
}else{
    $countryID=0;
}
global $database;
global $extra_float;
$extra_float=[];
$getdatas=$database->select('jk_users_locations_provinces','*',[
    "AND"=>[
        'status'=>"active",
        'module'=>$countryID,
    ]
]);
if(sizeof($getdatas)>=1){
    foreach ($getdatas as $getdata){
        $extra_float[$getdata['id']]='<a href="'.JK_DOMAIN_LANG.'cp/users/locations/cities/'.$getdata['id'].'" class="btn btn-sm btn-info">'.__("cities").'</button>';
    }
}
NestableTableJS("jk_users_locations_provinces",JK_DOMAIN_LANG . 'cp/users/locations/provinces/list_sort',1,1);
NestableTableGetData('jk_users_locations_provinces','jk_users_locations_provinces', JK_LANG,0,$extra_float,$countryID);
global $View;
echo $View->footer_js;