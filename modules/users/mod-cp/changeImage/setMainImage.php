<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('cp')) {
    error403();
    die;
}
if(isset($_POST['id'])){
    global $database;
    $getinfo=$database->get('jk_users_profile_images','*',[
        "AND"=>[
            "id"=>$_POST['id'],
            "userID"=>JK_LOGINID
            ]
    ]);
    if(isset($getinfo['id'])){
        $database->update('jk_users',[
            "profileImage"=>$getinfo['fileID']
        ],[
            "id"=>JK_LOGINID
        ]);
        echo redirect_to_js();
    }
}