<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
global $Users;
$Users->loggedCheck();
if (!$ACL->hasPermission('ipinbar_smsSendingSetting')) {
    error403();
    die;
}
if(isset($_POST['submit'])){
    jk_options_set("smsSendingSetting_driverLink",$_POST['smsSendingSetting_driverLink']);
    jk_options_set("smsSendingSetting_clientsLink",$_POST['smsSendingSetting_clientsLink']);
    jk_options_set("smsReceiveTicketDepartment",$_POST['smsReceiveTicketDepartment']);
    echo alertSuccess(__("done"));
}