<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_roles')) {
    error403();
    die;
}
global $database;
$extra_float=[];
$getdatas=$database->select('jk_roles','*',[
    'status'=>"active"
]);
if(sizeof($getdatas)>=1){
    foreach ($getdatas as $getdata){
        if($getdata['showInHierarchy']==1){
            $btnShowInHierarchy="success";
            $btnShowInHierarchyText=__("yes");
        }else{
            $btnShowInHierarchy="danger";
            $btnShowInHierarchyText=__("no");
        }
        $extra_float[$getdata['id']]='<button type="button" onclick="changeShowInHierarchy('.$getdata['id'].')" class="btn btn-sm btn-'.$btnShowInHierarchy.'">'.__("show in hierarchy").' : '.$btnShowInHierarchyText.'</button>';
    }
}

NestableTableJS("jk_roles",JK_DOMAIN_LANG . 'cp/users/roles/list_sort',1,1);
NestableTableGetData('jk_roles','jk_roles', JK_LANG,0,$extra_float);
global $View;
echo $View->footer_js;