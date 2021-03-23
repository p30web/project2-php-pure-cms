<!DOCTYPE html>
<html lang="en">
<head>
    <title>Test Club</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<div class="container-fluid">
    <?php
    global $Route;
    $userID=0;
    if(isset($Route->path[2])){
        $userID=$Route->path[2];
    }
    $curl2 = curl_init();
    curl_setopt_array($curl2, array(
        CURLOPT_PORT => "8443",
        CURLOPT_URL => "https://ipinbar.net:8443/validation/getUserInfoByPersonId/".$userID,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "Postman-Token: 23bda599-7f60-414d-9c7d-95b7af335d41",
            "cache-control: no-cache"
        ),
    ));
    $response2 = curl_exec($curl2);
    $err2=curl_error($curl2);

    if(!$err2){
        $res=json_decode($response2,true);
        if(isset($res['firstNameFa'])){
            echo $res['firstNameFa'].' '.$res['lastNameFa'];
            ?>
            <br/>
            به باشگاه مشتریان آی‌پین خوش آمدید
            <?php
        }else{
            ?>
            خطا در دریافت اطلاعات
            <?php
        }

    }
    ?>
</div>

</body>
</html>