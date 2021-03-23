<?php
require_once('/etc/nginx/core/bootstrap.php');
$datas=$database->select('tableBar_temp',"*",[
    "AND"=>[
        "status"=>"active",
        "telegramSent"=>0,
    ]
]);
$txt="";
$preTXT="تریلی";
$pres=[];
if(sizeof($datas)>=3){
    foreach ($datas as $dt){
        $nm=$dt['goods_type'].$dt['source'].$dt['destination'];
        if(!in_array($nm,$pres)){
            array_push($pres,$nm);
            $carName=str_replace(" - ","_",$dt['car']);
            $carName="#".str_replace(" ","_",$carName);
            $goodsTypeTitle="#".str_replace(" ","_",$dt['goods_type']);
            $source="#".str_replace(" ","_",$dt['source']);
            $destination="#".str_replace(" ","_",$dt['destination']);
            $txt.="🚛 ".$carName." ".$goodsTypeTitle." ".$source." ⬅️ ".$destination." "."\n";
        }
        $database->update('tableBar_temp',[
            "telegramSent"=>1
        ],[
            "id"=>$dt['id']
        ]);
    }
}
if($txt!=""){
//    require_once('/etc/nginx/core/bootstrap.php');

    include_once '/etc/nginx/core/modules/telegram/src/Telegram.php';
    new \Joonika\Modules\Telegram\Telegram();
    $finalTxt="📣#اعلام_بار جدید"."\n";
    $finalTxt.="📅تاریخ: ".\Joonika\Idate\tr_num(\Joonika\Idate\date_int("Y/m/d",time(),'fa'),'fa')."\n";
    $finalTxt.="⏰ساعت: ".\Joonika\Idate\tr_num(\Joonika\Idate\date_int("H:i",time(),'fa'),'fa')."\n"."\n";
    $finalTxt.="قابل توجه رانندگان گرامی"."\n";
    $finalTxt.="✅ جدیدترین بارهای اعلام شده در تالار #اعلان_بار آی‌پین توسط صاحبان بار"."\n"."\n";
    $finalTxt.=$txt."\n"."\n";
    $finalTxt.="💡رانندگان گرامی می‌توانند جهت دریافت این بارها و اطلاع از سایر بارهای موجود به اپلیکیشن آی‌پین مراجعه کنند"."\n";
    $finalTxt.="📱 https://ipinbar.net/landing/"."\n";
    $finalTxt.="☎️021-62871";
    \Joonika\Modules\Telegram\send(1,'-1001141740609',$finalTxt."\n.");
}