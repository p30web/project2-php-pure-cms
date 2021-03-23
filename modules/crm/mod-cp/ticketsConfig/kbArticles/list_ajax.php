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
NestableTableJS("crm_tickets_kb_articles",JK_DOMAIN_LANG . 'cp/crm/ticketsConfig/kbArticles/list_sort',2,2);
NestableTableGetData('crm_tickets_kb_articles','crm_tickets_kb_articles', JK_LANG,0,$extra_float,$countryID);
global $View;
echo $View->footer_js;