<?php
if (!defined('jk')) die('Access Not Allowed !');
header('Content-Type: application/json');

global $Route;
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
$ipsAllowed = [
    "192.168.1.1",
    "185.153.185.242",
    "185.37.55.127",
    "195.201.12.83",
];

$continue = true;
$data = [];
$back = [
    "status" => "success",
    "data" => $data,
    "message" => "",
];

//if (!in_array($ip, $ipsAllowed)) {
//    $continue = false;
//    $back['status'] = "INVALID_IP";
//    $back['message'] = "آی پی نامعتبر";
//}

if ($continue) {
    if (!isset($_POST['number'])) {
        $continue = false;
        $back['status'] = "NO_NUMBER";
        $back['message'] = "شماره ارسال نشده است";
    } else {
        $number = $_POST['number'];
    }
}
if ($continue) {
    if (!isset($_POST['type'])) {
        $continue = false;
        $back['status'] = "NO_TYPE";
        $back['message'] = "نوع ارسال نشده است";
    } else {
        $type = $_POST['type'];
    }
}

if ($continue) {
    if (!isset($_POST['amount'])) {
        $continue = false;
        $back['status'] = "NO_AMOUNT";
        $back['message'] = "مقدار ارسال نشده است";
    } else {
        $amount = $_POST['amount'];
    }
}
if ($continue) {
    if (isset($_POST['tripId'])) {
        $tripID = $_POST['tripId'];
    }else{
        $tripID=null;
    }
}
if ($continue) {
    if (isset($_POST['test']) && $_POST['test']=="1") {
        $status = "test";
    }else{
        $status = "active";
    }
}

if ($continue) {
    global $database;
    $foundPhone = $database->has('clients_ipinbar', [
        "mobile" => $number
    ]);
    if ($foundPhone) {
        $userid = $database->get('clients_ipinbar', 'id', [
            "mobile" => $number
        ]);
        $userMobile = $number;
    } else {
        $userid = null;
        $userMobile = $number;
    }
    $database->insert('club_points', [
        "userSource" => "clients_ipinbar",
        "userid" => $userid,
        "userMobile" => $userMobile,
        "point" => $amount,
        "type" => "p",
        "category" => $type,
        "tripID" => $tripID,
        "description" => "",
        "status" => $status,
        "datetime" => date("Y/m/d H:i:s"),
    ]);
    if($database->id()){
        $back = [
            "status" => "success",
            "data" => ["trackID"=>$database->id()],
            "message" => "با موفقیت ثبت شد",
        ];
    }else{
        $back = [
            "status" => "error",
            "data" => $data,
            "message" => "خطای نامشخص",
        ];
    }

}
echo json_encode($back, JSON_UNESCAPED_UNICODE);