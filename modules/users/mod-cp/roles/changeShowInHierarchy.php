<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_roles')) {
    error403();
    die;
}
global $View;

if(isset($_POST['id'])){
    global $database;
    $before=$database->get('jk_roles','showInHierarchy',[
        "id"=>$_POST['id'],
    ]);
    if($before==1){
        $before=0;
    }else{
        $before=1;
    }
    $group=$database->update('jk_roles',[
        "showInHierarchy"=>$before
    ],[
        "id"=>$_POST['id'],
    ]);
}
