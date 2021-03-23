<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('faq_list')) {
    error403();
    die;
}
$exra_float=[];
$varPageID=0;
global $Route;
if(isset($Route->path[3])){
    $varPageID=$Route->path[3];
}else{
    $varPageID=0;
}
global $database;
global $extra_float;
$extra_float=[];
$getdatas=$database->select('faq_list','*',[
    "AND"=>[
        'status'=>"active",
        'module'=>$varPageID,
    ]
]);
if(sizeof($getdatas)>=1){
    foreach ($getdatas as $getdata){
        if(strlen($getdata['answer'])>=50){
            $getdata['answer']=substr($getdata['answer'],0,49);
        }
        $extra_float[$getdata['id']]='<span class="small">'.$getdata['answer'].'</span>';
    }
}
NestableTableJS("faq_list",JK_DOMAIN_LANG . 'cp/faq/view/list_sort',1,1);
NestableTableGetData('faq_list','faq_list', "",0,$extra_float,$varPageID);
global $View;
echo $View->footer_js;