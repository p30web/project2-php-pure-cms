<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('crm_tickets_config')) {
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
$extra_float=[];
$getdatas=$database->select('crm_tickets_subjects','*',[
    'status'=>"active"
]);
if(sizeof($getdatas)>=1){
    foreach ($getdatas as $getdata){
        $btn_c="btn-outline-info";
        if($getdata['important']==1){
            $btn_c="btn-info";
        }
        $extra_float[$getdata['id']]='<button type="button" onclick="importantSubject('.$getdata['id'].')" class="btn btn-sm '.$btn_c.'"><i class="fa fa-headphones"></i> '.__("show on contact center").' </button>';
        $extra_float[$getdata['id']].='<a href="'.JK_DOMAIN_LANG.'cp/crm/ticketsConfig/confirmations/'.$getdata['id'].'" class="btn btn-sm btn-outline-warning"><i class="fa fa-key"></i> '.__("view confirmations").' </button>';
    }
}
NestableTableJS("crm_tickets_subjects",JK_DOMAIN_LANG . 'cp/crm/ticketsConfig/subjects/list_sort',1,1);
NestableTableGetData('crm_tickets_subjects','crm_tickets_subjects', JK_LANG,0,$extra_float,$countryID);
global $View;
echo $View->footer_js;