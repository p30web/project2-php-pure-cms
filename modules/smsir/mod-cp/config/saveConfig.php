<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
global $Users;
$Users->loggedCheck();
if (!$ACL->hasPermission('smsir_config')) {
    error403();
    die;
}
if(isset($_POST['submit'])){
    jk_options_set("smsirAPIKey",$_POST['smsirAPIKey']);
    jk_options_set("smsirSecretKey",$_POST['smsirSecretKey']);
    jk_options_set("smsirAPIURL",$_POST['smsirAPIURL']);
    echo alertSuccess(__("done"));
}