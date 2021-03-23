<?php
if (!defined('jk')) die('Access Not Allowed !');
global $database;
if(!isset($_POST['phoneDriver']) && !isset($_POST['phoneBar'])){
    echo alertDanger("مشکل در شماره ارسالی");
    die;
}
$phone="";
if(isset($_POST['phoneBar'])){
    $phone=$_POST['phoneBar'];
    $type="client";
}elseif(isset($_POST['phoneDriver'])){
    $phone=$_POST['phoneDriver'];
    $type="driver";
}
if($phone==""){
    echo alertDanger("شماره تلفن را کامل وارد نمایید");
    die;
}
if($type=="client"){
    $smsID=jk_options_get("smsSendingSetting_clientsLink");
}else{
    $smsID=jk_options_get("smsSendingSetting_driverLink");
}
new \Joonika\Modules\Smsir\Smsir();
if(\Joonika\Modules\Smsir\lastDateSentValid($phone,$smsID,300)){
$smsSt = \Joonika\Modules\Smsir\sendSmsIr($phone, $smsID);
if($smsSt=="sent"){
	echo alertSuccess("با موفقیت ارسال شد");
}else{
	print_r($smsSt);
    echo alertDanger("خطا در ارسال پیامک");
}
}else{
    echo alertDanger("پیامک قبلا برای شما ارسال شده است. لطفا دقایقی دیگر تلاش بفرمایید");
}
