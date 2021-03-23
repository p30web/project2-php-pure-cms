<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
global $database;
if (!$ACL->hasPermission('users_displacements')) {
    error403();
    die;
}
NestableTableJS("jk_users_displacements_types",JK_DOMAIN_LANG . 'cp/users/displacements/types/list_sort');
$extra_float=[];
$getdatas=$database->select('jk_users_displacements_types','*',[
    'status'=>"active"
]);
if(sizeof($getdatas)>=1){
    foreach ($getdatas as $getdata){
        if($getdata['inactiveOldValue']==1){
            $btnChangeOldValue="warning";
            $btnChangeOldValueText=__("yes");
        }else{
            $btnChangeOldValue="default";
            $btnChangeOldValueText=__("no");
        }
        if($getdata['extraRoleGroup']==1){
            $btnExtraRoleGroup="info";
            $btnExtraRoleGroupText=__("yes");
        }else{
            $btnExtraRoleGroup="default";
            $btnExtraRoleGroupText=__("no");
        }
        if($getdata['statusType']==1){
            $btnStatusType="success";
            $btnStatusTypeText=__("active");
        }else{
            $btnStatusType="danger";
            $btnStatusTypeText=__("inactive");
        }
        $extra_float[$getdata['id']]='<button type="button" onclick="changeInactiveOldValue('.$getdata['id'].')" class="btn btn-sm btn-'.$btnChangeOldValue.'">'.__("inactive old value").' : '.$btnChangeOldValueText.'</button>';
        $extra_float[$getdata['id']].='<button type="button" onclick="changeExtraRoleGroup('.$getdata['id'].')" class="btn btn-sm btn-'.$btnExtraRoleGroup.'">'.__("extra role and group").' : '.$btnExtraRoleGroupText.'</button>';
        $extra_float[$getdata['id']].='<button type="button" onclick="changeInactiveUserStatus('.$getdata['id'].')" class="btn btn-sm btn-'.$btnStatusType.'">'.__("user status").' : '.$btnStatusTypeText.'</button>';
    }
}


NestableTableGetData('jk_users_displacements_types','jk_users_displacements_types', JK_LANG,0,$extra_float);
global $View;
echo $View->footer_js;