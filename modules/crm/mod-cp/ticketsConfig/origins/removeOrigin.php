<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('crm_tickets_config')) {
    error403();
    die;
}
if(isset($_POST['remid'])){
    global $database;
    $database->update('crm_tickets_origins_title',[
        "status"=>"removed"
    ],[
        "id"=>$_POST['remid']
    ]);
    echo redirect_to_js();
}