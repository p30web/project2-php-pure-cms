<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
global $database;
global $Users;
global $View;
if (isset($_POST['username']) && isset($_POST['password'])) {
    $usercheck = $Users->loginCheck([
        "username" => $_POST['username'],
        "password" => $_POST['password'],
    ]);
    if ($usercheck['status']) {
        $Users->logUser($usercheck['id']);
        echo alertSuccess(__("login successfully"));
        echo redirect_to_js();
    } elseif ($usercheck['message'] != "") {
        echo alertDanger($usercheck['message']);
    }else{
        echo alertDanger(__("fault"));
    }
}