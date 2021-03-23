<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('personnel_timeManagement_manage')) {
    error403();
    die;
}
global $database;
$extra_float=[];
$getdatas=$database->select('personnel_time_management_types','*',[
    'status'=>"active"
]);
if(sizeof($getdatas)>=1){
    foreach ($getdatas as $getdata){
	    $txtCal=__("enter");
	    if($getdata['type']==0){
    		$txtCal=__("exit");
	    }
        $extra_float[$getdata['id']]='<i class="fa fa-circle" style="color: '.$getdata['color'].'"></i> '.$txtCal;
    }
}
NestableTableJS("personnel_time_management_types",JK_DOMAIN_LANG . 'cp/personnel/timeManagement/manage/list_sort',1,1);
NestableTableGetData('personnel_time_management_types','personnel_time_management_types', JK_LANG,0,$extra_float);
global $View;
echo $View->footer_js;