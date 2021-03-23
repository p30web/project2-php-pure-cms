<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('personnel_config_educational_fields')) {
    error403();
    die;
}
global $database;
$extra_float=[];
$getdatas=$database->select('personnel_fields_cats','*',[
    'status'=>"active"
]);
if(sizeof($getdatas)>=1){
    foreach ($getdatas as $getdata){
        $extra_float[$getdata['id']]='<a href="'.JK_DOMAIN_LANG.'cp/personnel/config/educationalFields/'.$getdata['id'].'" class="btn btn-sm btn-info">'.__("fields").'</button>';
    }
}
NestableTableJS("personnel_fields_cats",JK_DOMAIN_LANG . 'cp/personnel/config/educationalFieldsCat/list_sort',1,1);
NestableTableGetData('personnel_fields_cats','personnel_fields_cats', JK_LANG,0,$extra_float);
global $View;
echo $View->footer_js;