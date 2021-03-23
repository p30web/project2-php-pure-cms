<?php
if (!isset($_SESSION['clubUser'])) {
    redirect_to(JK_DOMAIN_LANG);
    exit;
}
global $View;
global $database;
$clientID = $_SESSION['clubUser'];
$client = $database->get('clients_ipinbar', '*', [
    "id" => $clientID
]);
\Joonika\Forms\form_create([
    "id"=>"charge_app_form",
]);
global $data;
$data['mobileNumber']=$client['mobile'];


if(isset($_POST['mobileNumber']) && isset($_POST['selectCharge'])){
    $data['mobileNumber']=$_POST['mobileNumber'];
    $points=updateScore($clientID);
    if($points>=$_POST['selectCharge']/10){
        $api = 'f7a95119d836d279d6d24f1c5efac237';
        $amount = $_POST['selectCharge'];
        $type = "irancell";
        $account = $_POST['mobileNumber'];
        $chargeTrans=$database->insert('club_charge_credit',[
            "userid"=>$client['id'],
            "mobile"=>$_POST['mobileNumber'],
            "price"=>$_POST['selectCharge'],
            "status"=>"start",
        ]);
        $reqID = 3;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://epooli.com/ws/chargesim/recharge');
        curl_setopt($ch, CURLOPT_POSTFIELDS,"api=$api&amount=$amount&type=$type&account=$account&reqID=$reqID");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $res2 = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res2,true);
        if(isset($res['status'])){
            if($res['status']!=0){
                echo alertSuccess("شارژ شما با موفقیت انجام شد");
                die;
            }else{
                echo alertDanger($res['errorMessage']);
            }
        }else{
            echo alertDanger("خطا");
        }
    }else{
        echo alertWarning("میزبان امتیاز شما کافی نیست");
    }
}




echo \Joonika\Forms\field_hidden([
    "name"=>"op",
    "value"=>$_POST['op'],
]);
echo \Joonika\Forms\field_text([
    "name" => "mobileNumber",
    "title" => __("mobile number"),
    "direction" => "ltr",
    "ColType" => "12,12",
]);
$array=[
    "50000"=>"پنج هزار تومانی",
    "10000"=>"ده هزار تومانی",
];
echo \Joonika\Forms\field_select([
    "name" => "selectCharge",
    "title" =>"انتخاب شارژ",
    "array" =>$array,
    "direction" => "rtl",
    "ColType" => "12,12",
]);

echo \Joonika\Forms\field_submit([
    "text" => "انجام شارژ",
    "ColType" => "12,12",
    "btn-class" => "btn btn-success btn-lg btn-block",
    "icon" => ""
]);

\Joonika\Forms\form_end();

$View->footer_js('<script>
' . ajax_validate([
        "on" => "submit",
        "formID" => "charge_app_form",
        "url" => JK_DOMAIN_LANG . 'club/chargeApp',
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
</script>');
echo $View->getFooterJsFiles();
echo $View->footer_js;