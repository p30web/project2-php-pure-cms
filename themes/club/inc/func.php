<?php
if(!defined('jk')) die('Access Not Allowed !');
header("Access-Control-Allow-Origin: *");
global $View;
global $Theme;
$View->setTitle($Theme->siteTitle);
if(is_readable(__DIR__.DS.'header.php')){
    $View->head_file=__DIR__.DS.'header.php';
}
if(is_readable(__DIR__.DS.'footer.php')){
    $View->foot_file=__DIR__.DS.'footer.php';
}
function clientRole($title){
    $arrayRole=[
        "GOODS_OWNER_BRONZE"=>"صاحب بار",
    ];
    if(isset($arrayRole[$title])){
        return $arrayRole[$title];
    }else{
        return '-';
    }
}
function clientType($title){
    $arrayRole=[
        "GOODS_OWNER_BRONZE"=>"برنزی",
    ];
    if(isset($arrayRole[$title])){
        return $arrayRole[$title];
    }else{
        return '-';
    }
}
function clientRoleTitle($title){
    $arrayRole=[
        "GOODS_OWNER_BRONZE"=>"صاحب بار گرامی",
        "EMPLOYEE"=>"کارمند گرامی",
        "DRIVER_SILVER"=>"راننده گرامی",
    ];
    if(substr($title,0,11)=="GOODS_OWNER"){
        return "صاحب بار گرامی";
    }elseif(substr($title,0,6)=="DRIVER"){
        return "راننده گرامی";
    }else{
        return "-";
    }
}
function Checkexistence($userID){
    global $database;
    $getU=$database->get('clients_ipinbar','*',[
        "id"=>$userID
    ]);
    $curl2 = curl_init();

    curl_setopt_array($curl2, array(
        CURLOPT_PORT => "8443",
        CURLOPT_URL => "https://ipinbar.net:8443/validation/userInfo",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{\"username\":\"".$getU['username']."\",\"password\":\"".$getU['password']."\"}",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "Postman-Token: 23bda599-7f60-414d-9c7d-95b7af335d41",
            "cache-control: no-cache"
        ),
    ));

    $response2 = curl_exec($curl2);
    $res=json_decode($response2,true);
    print_r($res);

}
function updateScore($userID){
    global $database;
    $p=$database->sum("club_points","point",[
        "AND" => [
            "userSource" => "clients_ipinbar",
            "status" => "active",
            "type" => "p",
            "userid" => $userID,
        ]
    ]);
    $n=$database->sum("club_points","point",[
        "AND" => [
            "userSource" => "clients_ipinbar",
            "status" => "active",
            "type" => "n",
            "userid" => $userID,
        ]
    ]);
    $total=$p-$n;
    $database->update("clients_ipinbar",[
            "points"=>$total
    ],[
            "id" => $userID,
    ]);

    return $total;

}
define("THEME_CDN","https://cdn.ipinbar.net");