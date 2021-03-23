<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('crm_tickets_config')) {
    error403();
    die;
}
global $View;
if(isset($_POST['id'])){
    global $database;
    $beforeval=$database->get('crm_tickets_subjects','important',[
        "id"=>$_POST['id']
    ]);
    if($beforeval==1){
        $beforeval=0;
    }else{
        $beforeval=1;
    }
    $database->update('crm_tickets_subjects',[
        "important"=>$beforeval
    ],[
        "id"=>$_POST['id']
    ]);
    $View->footer_js("<script>shownest();</script>");
    echo $View->footer_js;
}