<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
global $Users;
$Users->loggedCheck();
if (!$ACL->hasPermission('smsir_sendSms')) {
    error403();
    die;
}
if(isset($_POST['submit'])){
    $numbersFull=$_POST['numbers'];
    $numbers=explode("\n",$numbersFull);
    if(sizeof($numbers)>=1){
        new \Joonika\Modules\Smsir\Smsir();
        foreach ($numbers as $number){
            if($number!=""){
            $number=\Joonika\Idate\tr_num(trim($number),'en');
            $smsSt = \Joonika\Modules\Smsir\sendSmsIr($number, $_POST['tempID'], []);
	            if ($smsSt == "sent") {
		            echo alertSuccess(__("number")." : ".$number.'- sent');
	            } else {
		            echo alertDanger(__("number")." : ".$number.'-'.$smsSt);
	            }
            }
        }
        echo alertSuccess(__("action done"));
    }
}