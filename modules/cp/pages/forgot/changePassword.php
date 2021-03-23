<?php
if (!defined('jk')) die('Access Not Allowed !');
global $Users;
global $Route;
if ($Users->isLogged()) {
    if (isset($Route->query_string['return'])) {
        $url = $Route->query_string['return'];
    } else {
        $url = JK_DOMAIN_LANG;
    }
    redirect_to($url);
}
global $database;
if(!isset($_POST['token']) || !isset($_POST['newPassword']) || !isset($_POST['newPasswordC'])){
    error403();
    exit;
}
$error=true;
$continue=true;
$errorMessage=__("token not valid or expired");

if($_POST['newPassword']!=$_POST['newPasswordC']){
    $errorMessage=__("password and confirm password not match");
    $continue=false;
}
if($continue){
$getToken=$database->get('jk_users_token',"*",[
    "token"=>$_POST['token']
]);
if(isset($getToken['id'])){
    $userID=$getToken['userID'];
    $password=hashpass($_POST['newPassword']);
    $update=$database->update('jk_users',[
        "password"=>$password
    ],[
        "id"=>$userID
    ]);
    $error=false;
    echo redirect_to_js(JK_DOMAIN_LANG.'cp/main/login');
}
}

if($error){
    echo alertDanger($errorMessage);
}
