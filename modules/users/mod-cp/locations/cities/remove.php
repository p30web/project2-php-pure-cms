<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_locations_cities')) {
    error403();
    die;
}
global $View;
global $database;
if(isset($_POST['remid'])){
    $database->update('jk_users_locations_cities',[
        "status"=>"inactive"
    ],[
        "id"=>$_POST['remid']
    ]);
    $View->footer_js("<script>shownest();</script>");
    echo $View->footer_js;
}