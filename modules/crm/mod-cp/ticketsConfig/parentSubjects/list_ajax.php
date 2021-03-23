<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('crm_tickets_config')) {
    error403();
    die;
}
global $database;
$extra_float=[];
$getdatas=$database->select('crm_tickets_parent_subjects','*',[
    'status'=>"active"
]);
if(sizeof($getdatas)>=1){
    foreach ($getdatas as $getdata){
        $extra_float[$getdata['id']]='<a href="'.JK_DOMAIN_LANG.'cp/crm/ticketsConfig/subjects/'.$getdata['id'].'" class="btn btn-sm btn-info">'.__("subjects").'</button>';
    }
}
NestableTableJS("crm_tickets_parent_subjects",JK_DOMAIN_LANG . 'cp/crm/ticketsConfig/parentSubjects/list_sort',1,1);
NestableTableGetData('crm_tickets_parent_subjects','crm_tickets_parent_subjects', JK_LANG,0,$extra_float);
global $View;
echo $View->footer_js;