<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('cp')) {
    error403();
    die;
}
global $View;
global $database;
$error=true;
$continue=true;
$errorMessage=__("token not valid or expired");

if($_POST['newPassword']!=$_POST['newPasswordC']){
    $errorMessage=__("password and confirm password not match");
    $continue=false;
}
if($continue){
        $userID=JK_LOGINID;
        $password=hashpass($_POST['newPassword']);
        $update=$database->update('jk_users',[
            "password"=>$password
        ],[
            "id"=>$userID
        ]);
        $error=false;
        echo alertSuccess(__("password change successfully"));
}

if($error){
    echo alertDanger($errorMessage);
}
