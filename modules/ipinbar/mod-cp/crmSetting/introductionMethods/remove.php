<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('ipinbar_crmSetting_introductionMethods')) {
    error403();
    die;
}
global $View;
global $database;
if(isset($_POST['remid'])){
    $database->update('ipinbar_introduction_methods',[
        "status"=>"inactive"
    ],[
        "id"=>$_POST['remid']
    ]);
    $View->footer_js("<script>shownest();</script>");
    echo $View->footer_js;
}