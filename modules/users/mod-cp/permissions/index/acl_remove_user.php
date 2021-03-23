<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_permissions')) {
    error403();
    die;
}
global $View;
global $Users;
global $Route;
global $Cp;
global $database;

if (isset($_POST['userpermID'])) {
    $database->delete('jk_users_perms_users',[
            "id"=>$_POST['userpermID']
    ]);
    echo redirect_to_js();

}