<?php

if (!defined('jk')) die('Access Not Allowed !');

global $ACL;

if (!$ACL->hasPermission('crm_contactCenter')) {
    error403();
    die;
}

if(isset($_POST['number']) && $_POST['number']!=""){
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_PORT => "8443",
    CURLOPT_URL => "https://ipinbar.net:8443/validation/getUserInfoByPhone/".$_POST['number'],
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

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
if ($err) {
    echo alert([
        "type"=>"danger",
        "text"=>"خطا در برقراری ارتباط",
    ]);
} else {
    $res=json_decode($response,true);
    if(sizeof($res)>=1 && isset($res['id'])){
        if(isset($res['firstNameFa'])){
            ?>
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <table class="table table-sm responsive table-bordered">
                                <tr>
                                    <td class="bg-info text-white"><?php __e("name"); ?></td>
                                    <td><?php echo $res['firstNameFa'] ?></td>
                                <td class="bg-info text-white"><?php __e("family"); ?></td>
                                    <td><?php echo $res['lastNameFa'] ?></td>
                                    <td class="bg-info text-white"><?php __e("type"); ?></td>
                                    <td><?php echo $res['userAccount']['userAccountType']['titleFA'] ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
            <?php
        }else{
            echo alert([
                "type"=>"danger",
                "text"=>"شماره مورد نظر یافت نشد",
            ]);
        }
    }
}
}