<?php
die;
require_once('/etc/nginx/core/bootstrap.php');
//$has = $database->delete('tableBar_temp', [
//]);
$data = [];
$has = false;
$icar = [
    "VANET" =>
        [
            "name" => "وانت",
            "carid" => 1
        ]
    ,
    "NEISAN" =>
        [
            "name" => "نیسان",
            "carid" => 2
        ]
    ,
    "KHAVAR_SE_TON" =>
        [
            "name" => "کامیونت 3 تنی",
            "carid" => 3
        ]
    ,
    "KHAVER_PANJ_TON" =>
        [
            "name" => "خاور 5 تنی",
            "carid" => 4
        ]
    ,
    "BADSAN" =>
        [
            "name" => "911 - بادسان",
            "carid" => 5
        ]
    ,
    "DAH_TON" =>
        [
            "name" => "10تن - تک",
            "carid" => 6
        ]
    ,
    "PANZDAH_TON" =>
        [
            "name" => "جفت - 15تن",
            "carid" => 7
        ]
    ,
    "TEREILER" =>
        [
            "name" => "تریلر",
            "carid" => 8
        ]
    ,
    "KAMARSHEKAN" =>
        [
            "name" => "کمر شکن",
            "carid" => 9
        ]
    ,
    "BUJE" =>
        [
            "name" => "بوژی",
            "carid" => 10
        ]
    ,
];
$availCode=[];


foreach ($icar as $key => $car) {
    echo $key.'
';
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_PORT => "8443",
        CURLOPT_URL => "https://ipinbar.net:8443/validation/getTwoRequest/" . $key,
        CURLOPT_RETURNTRANSFER => true,
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if (!$err) {
        $data = json_decode($response, true);
        print_r($data);
        if (sizeof($data) >= 1) {
            foreach ($data as $dt){
                array_push($availCode,$dt['id']);
                $has=$database->has('tableBar_temp',[
                    "code" => $dt['id'],
                ]);
                if(!$has){
                    $database->insert('tableBar_temp', [
                        "code" => $dt['id'],
                        "car" => $car['name'],
                        "car_type" => $car['carid'],
                        "goods_type" => $dt['goodsTypeTitle'],
                        "source" => $dt['originCityTitle'],
                        "destination" => $dt['destinationCityTitle'],
                        "datetime_fetch" => date("Y/m/d H:i:s", time()),
                        "price" => \Joonika\Idate\tr_num($dt['price'], 'en')
                    ]);
                }
            }

        }
    }

}
if(sizeof($availCode)>=1){
    $uptd=$database->update('tableBar_temp',[
        "status"=>"expire"
    ],[
        "code[!]"=>$availCode
    ]);
}else{
    $uptd=$database->update('tableBar_temp',[
        "status"=>"expire"
    ],[
    ]);
}
