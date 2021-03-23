<?php
if(!defined('jk')) die('Access Not Allowed !');
if(isset($_POST['username']) && isset($_POST['password'])){


    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_PORT => "8443",
        CURLOPT_URL => "https://ipinbar.net:8443/validation/existenceCheck",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{\"username\":\"".$_POST['username']."\",\"password\":\"".$_POST['password']."\"}",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "Postman-Token: 9da95559-7977-4231-a561-af5f1b49595b",
            "cache-control: no-cache"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);
    if ($err) {
        echo alert([
            "type"=>"danger",
            "text"=>"خطا در برقراری ارتباط",
        ]);
    } else {

        if($response=="false"){
            echo alert([
                "type"=>"danger",
                "text"=>"نام کاربری یا رمز عبور اشتباه است",
            ]);

        }elseif($response=="true"){

            global $database;

            $checkuser=$database->get('clients_ipinbar',"*",[
                "username"=>$_POST['username']
            ]);


            if(isset($checkuser['id'])){

                $database->update('clients_ipinbar',[
                    "password"=>$_POST['password'],
                    "lastLogin"=>date("Y/m/d H:i:s"),
                ],[
                    "id"=>$checkuser['id']
                ]);

                $checkuserid=$checkuser['id'];


            }else {

                $database->insert('clients_ipinbar', [
                    "username" => $_POST['username'],
                    "password" => $_POST['password'],
                    "lastLogin" => date("Y/m/d H:i:s"),
                ]);
                $checkuserid = $database->id();
            }

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
                    CURLOPT_POSTFIELDS => "{\"username\":\"".$_POST['username']."\",\"password\":\"".$_POST['password']."\"}",
                    CURLOPT_HTTPHEADER => array(
                        "Content-Type: application/json",
                        "Postman-Token: 23bda599-7f60-414d-9c7d-95b7af335d41",
                        "cache-control: no-cache"
                    ),
                ));

                $response2 = curl_exec($curl2);

                $err2 = curl_error($curl2);

                curl_close($curl2);
            $response2=json_decode($response2,true);
                if (!$err2) {
                    $database->update('clients_ipinbar',[
                        "lastLogin" => date("Y/m/d H:i:s"),
                        "staticRole"=>$response2['userAccount']['userAccountType']['staticRole'],
                        "firstName"=>$response2['firstNameFa'],
                        "lastName"=>$response2['lastNameFa'],
                        "mobile"=>$response2['phone'],
                    ],[
                        "id"=>$checkuserid
                    ]);
                }

                $_SESSION['clubUser']=$checkuserid;
            updateScore($checkuserid);


                echo redirect_to_js(JK_DOMAIN_LANG.'panel');
            }

        }
}else{
    echo alert([
        "type"=>"danger",
        "text"=>"مقادیر وارد شده اشتباه است",
    ]);
}