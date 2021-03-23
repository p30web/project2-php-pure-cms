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
global $extra_float;
$extra_float=[];
$getdatas=$database->select('crm_tickets_note_modules','*',[
    'status'=>"active"
]);
if(sizeof($getdatas)>=1){
    foreach ($getdatas as $getdata){
        $extra_float[$getdata['id']]=$getdata['function'];
    }
}
NestableTableJS("crm_tickets_note_modules",JK_DOMAIN_LANG . 'cp/crm/ticketsConfig/noteModules/list_sort',2,1);
NestableTableGetData('crm_tickets_note_modules','crm_tickets_note_modules', JK_LANG,0,$extra_float,$countryID);
global $View;
echo $View->footer_js;