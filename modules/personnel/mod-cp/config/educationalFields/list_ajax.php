<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('personnel_config_educational_fields')) {
    error403();
    die;
}
$extra_float=[];
$catID=0;

global $Route;
if(isset($Route->path[4])){
    $catID=$Route->path[4];
}else{
    $catID=0;
}

global $database;

NestableTableJS("personnel_fields",JK_DOMAIN_LANG . 'cp/personnel/config/educationalFields/list_sort',1,1);
NestableTableGetData('personnel_fields','personnel_fields', JK_LANG,0,$extra_float,$catID);
global $View;
echo $View->footer_js;