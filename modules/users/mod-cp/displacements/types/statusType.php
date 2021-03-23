<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_displacements')) {
    error403();
    die;
}
global $View;

if(isset($_POST['id'])){
    global $database;
    $before=$database->get('jk_users_displacements_types','statusType',[
        "id"=>$_POST['id'],
    ]);
    if($before==1){
        $before=0;
    }else{
        $before=1;
    }
    $group=$database->update('jk_users_displacements_types',[
        "statusType"=>$before
    ],[
            "id"=>$_POST['id'],
    ]);
}
