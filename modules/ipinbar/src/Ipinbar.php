<?php

namespace Joonika\Modules\Ipinbar;

if (!defined('jk')) die('Access Not Allowed !');

class Ipinbar
{
    /**
     * Users constructor.
     */
    public function __construct()
    {
    }

}

function ticketInfoUserBoxSmall($data)
{
    parse_str($data, $args);
    if (isset($args['username']) && $args['username'] != "") {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => "8443",
            CURLOPT_URL => "https://ipinbar.net:8443/validation/getUserInfoByPhone/" . $args['username'],
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
        if (!$err) {
            $res = json_decode($response, true);
            if (sizeof($res) >= 1 && isset($res['id'])) {
                if (isset($res['firstNameFa'])) {
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
                }
            }
        }
    }
}

function ticketInfoUserBoxFull($data)
{
    global $View;
    parse_str($data, $args);
    if (isset($args['username']) && $args['username'] != "") {

        $usBox = "";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => "8443",
            CURLOPT_URL => "https://ipinbar.net:8443/validation/getUserInfoByPhone/" . $args['username'],
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
                "type" => "danger",
                "text" => "خطا در برقراری ارتباط",
            ]);
        } else {


            $res = json_decode($response, true);
            if (is_array($res) && sizeof($res) >= 1 && isset($res['id'])) {
                if (isset($res['firstNameFa'])) {
                    $usBox = '<table class="table table-sm responsive table-bordered m-0">
                        <tr>
                            <td class="bg-info text-white">' . __("name") . '</td>
                            <td>' . $res['firstNameFa'] . '</td>
                        </tr>
                        <tr>

                            <td class="bg-info text-white">' . __("family") . '</td>
                            <td>' . $res['lastNameFa'] . '</td>
                        </tr>
                        <tr>
                            <td class="bg-info text-white">' . __("type") . '</td>
                            <td>' . $res['userAccount']['userAccountType']['titleFA'] . '</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center">
                            <a href="#" class="btn btn-outline-info btn-sm">
                    <i class="fa fa-book"></i>
                    مشاهده اطلاعات تکمیلی
                </a>
                            </td>
                        </tr>
                    </table>';
                }

            }
        }
        if ($usBox != "") {
            ?>
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="card">
                        <div class="card-body p-0 m-0">
                            <?php
                            echo $usBox;
                            ?></div>

                    </div>
                </div>
                <div class="col-12 col-md-8">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="mt-3">
                                <div class="">
                                    <?php
                                    $curl2 = curl_init();
                                    curl_setopt_array($curl2, array(
                                        CURLOPT_PORT => "8443",
                                        CURLOPT_URL => "https://ipinbar.net:8443/validation/getTripInfo/" . $args['username'],
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
                                    $err2 = curl_error($curl2);
                                    curl_close($curl2);
                                    if (!$err2) {
                                        $curl2Res = json_decode($response2, true);
                                        if (isset($curl2Res['TRIP']) && is_array($curl2Res)) {
                                            $keyTitle = [
                                                "TRIP" => "سفر",
                                                "CANCELED" => "لغو شده",
                                                "EXPIRED" => "منقضی شده",
                                                "WAITING" => "انتظار",
                                                "RESERVED" => "رزرو شده",
                                                "FINISH" => "اتمام",
                                            ];
                                            $tr['TRIP'] = $curl2Res['TRIP'];
                                            $tr['CANCELED'] = [];
                                            $tr['EXPIRED'] = [];
                                            $tr['WAITING'] = [];
                                            $tr['RESERVED'] = [];
                                            $tr['FINISH'] = [];

                                            if (isset($curl2Res['CANCELED'])) {
                                                $tr['CANCELED'] = $curl2Res['CANCELED'];
                                            }
                                            if (isset($curl2Res['EXPIRED'])) {
                                                $tr['EXPIRED'] = $curl2Res['EXPIRED'];
                                            }
                                            if (isset($curl2Res['WAITING'])) {
                                                $tr['WAITING'] = $curl2Res['WAITING'];
                                            }
                                            if (isset($curl2Res['RESERVED'])) {
                                                $tr['RESERVED'] = $curl2Res['RESERVED'];
                                            }
                                            if (isset($curl2Res['FINISH'])) {
                                                $tr['FINISH'] = $curl2Res['FINISH'];
                                            }

                                            ?>
                                            <style>
                                                .nav-item.nav-link.active {
                                                    border-width: 1px 1px 0 1px;
                                                }

                                                .nav-item.nav-link {
                                                    padding: 5px 10px 5px 10px;
                                                }
                                            </style>
                                            <nav>
                                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                    <?php
                                                    $randTabId = time() . '_' . rand(10000, 99999);
                                                    if (sizeof($tr) >= 1) {
                                                        foreach ($tr as $k => $v) {
                                                            $sizet = sizeof($v);
                                                            if ($sizet >= 1) {
                                                                $badge = '<span class="badge badge-pill badge-info">' . $sizet . '</span>';
                                                            } else {
                                                                $badge = '<span class="badge badge-pill badge-secondary">0</span>';
                                                            }
                                                            ?>
                                                            <a class="nav-item nav-link <?php if ($k == 'TRIP') { ?>active<?php } ?>"
                                                               id="nav-<?php echo $k; ?>-tab-<?php echo $randTabId; ?>"
                                                               data-toggle="tab"
                                                               href="#nav-<?php echo $k; ?><?php echo $randTabId; ?>"
                                                               role="tab"
                                                               aria-controls="nav-<?php echo $k; ?><?php echo $randTabId; ?>"
                                                               aria-selected="true"><?php echo $keyTitle[$k]; ?><?php echo $badge; ?></a>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </nav>
                                            <div class="tab-content" id="nav-tabContent">
                                                <?php
                                                if (sizeof($tr) >= 1) {
                                                    ?>
                                                    <?php
                                                    foreach ($tr

                                                             as $k => $v) {
                                                        $sizet = sizeof($v);
                                                        ?>
                                                        <div class="tab-pane fade show <?php if ($k == 'TRIP') { ?>active<?php } ?>"
                                                             id="nav-<?php echo $k; ?><?php echo $randTabId; ?>"
                                                             role="tabpanel"
                                                             aria-labelledby="nav-<?php echo $k; ?>-tab-<?php echo $randTabId; ?>"><?php
                                                            if ($sizet >= 1) {
                                                                ?>
                                                                <div class="card mb-1">
                                                                    <div class="card-body"
                                                                         style="height: 200px;overflow-y: scroll">
                                                                        <table class="table table-sm  small">
                                                                            <thead>
                                                                            <tr>
                                                                                <th>کد</th>
                                                                                <th>وضعیت</th>
                                                                                <th>نوع</th>
                                                                                <th>خودرو</th>
                                                                                <th>مبدا</th>
                                                                                <th>مقصد</th>
                                                                                <th>قیمت</th>
                                                                                <th>قیمت مشتری</th>
                                                                                <th>نوع قیمت</th>
                                                                                <th>راننده</th>
                                                                                <th></th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            <?php
                                                                            foreach ($v as $bar) {
                                                                                ?>
                                                                                <tr>
                                                                                    <td>
                                                                                        <span class="badge badge-pill badge-primary"><?php if (isset($bar['code'])) {
                                                                                                echo $bar['code'];
                                                                                            }; ?></span>
                                                                                    </td>
                                                                                    <td><?php
                                                                                        if ($bar['confirm']) {
                                                                                            ?>
                                                                                            <span class="badge badge-pill badge-success">تایید شده</span>
                                                                                            <?php
                                                                                        } else {
                                                                                            ?>
                                                                                            <span class="badge badge-pill badge-danger">تاییده نشده</span>
                                                                                            <?php
                                                                                        }
                                                                                        ?></td>
                                                                                    <td>
                                                                                        <span class="badge badge-pill badge-info"><?php echo $bar['goodsTitle']; ?></span>
                                                                                    </td>
                                                                                    <td><?php if (isset($bar['vehicleTypeTitle'])) {
                                                                                            echo $bar['vehicleTypeTitle'];
                                                                                        } ?></td>
                                                                                    <td><?php echo $bar['originCityTitle'] ?></td>
                                                                                    <td><?php echo $bar['destinationCityTitle'] ?></td>
                                                                                    <td><?php echo number_format($bar['price']); ?></td>
                                                                                    <td><?php echo $bar['customerPrice'] ?></td>
                                                                                    <td><?php echo $bar['priceBase'] ?></td>
                                                                                    <td><?php if (isset($bar['driverFullName'])) {
                                                                                            echo $bar['driverFullName'];
                                                                                        } ?></td>
                                                                                    <td>
                                                                                        <button class="btn btn-info btn-sm"
                                                                                                type="button"
                                                                                                onclick="ViewBarModal(<?php echo $bar['id']; ?>)">
                                                                                            <i class="fa fa-eye"></i>
                                                                                        </button>
                                                                                    </td>
                                                                                </tr>
                                                                                <?php
                                                                            }
                                                                            ?></tbody>
                                                                        </table>
                                                                        <?php
                                                                        $View->footer_js('<script>
function ViewBarModal(id) {
  alert("soon");
}
</script>');
                                                                        ?>
                                                                    </div>
                                                                </div>

                                                                <?php
                                                            } else {
                                                                echo alertInfo(__("no data found"));
                                                            }
                                                            ?>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                            <?php
                                        } else {
                                            echo alertDanger(__("error while receiving data"));
                                        }
                                    } else {
                                        echo alertDanger(__("error while receiving data"));
                                    }
                                    ?>
                                    <table class="table responsive table-sm">

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <?php
        }
    }
}

function getUserInfoByNumber($number, $forceUpdate = false)
{
    global $database;
    $back = [];
    $checkuserid = $database->get('clients_ipinbar', '*', [
        "mobile" => $number
    ]);
    if (isset($checkuserid['id'])) {
        if ($forceUpdate == true) {
            $res = getUserInfoByNumberViewWS($number);
            if (isset($res['userAccount']['userAccountType']['staticRole'])) {
                $status = 'active';
                if ($res['userAccount']['enabled'] == false) {
                    $status = "inactive";
                }
                $database->update('clients_ipinbar', [
                    "username" => $res['userAccount']['username'],
                    "staticRole" => $res['userAccount']['userAccountType']['staticRole'],
                    "firstName" => $res['firstNameFa'],
                    "lastName" => $res['lastNameFa'],
                    "mobile" => $number,
                    "status" => $status,
                    "lastUpdateWS" => date("Y/m/d H:i:s"),
                ], [
                    "mobile" => $number
                ]);
            }
            $back = getUserInfoByNumber($number);

        } else {
            $back = $checkuserid;
        }

    } else {

        if($forceUpdate){
        $res = getUserInfoByNumberViewWS($number);
        if (isset($res['userAccount']['userAccountType']['staticRole'])) {
            $database->insert('clients_ipinbar', [
                "mobile" => $number,
            ]);
            $status = 'active';
            if ($res['userAccount']['enabled'] == false) {
                $status = "inactive";
            }
            $database->update('clients_ipinbar', [
                "username" => $res['userAccount']['username'],
                "staticRole" => $res['userAccount']['userAccountType']['staticRole'],
                "firstName" => $res['firstNameFa'],
                "lastName" => $res['lastNameFa'],
                "mobile" => $number,
                "status" => $status,
                "lastUpdateWS" => date("Y/m/d H:i:s"),
            ], [
                "mobile" => $number
            ]);
            $back = getUserInfoByNumber($number);
        }
        }

    }
    return $back;

}

function getUserInfoByNumberViewWS($number)
{
    $back = [];
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_PORT => "8443",
        CURLOPT_URL => "https://ipinbar.net:8443/validation/getUserInfoByPhone/" . $number,
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

    if (!$err) {
        $response2 = json_decode($response, true);
        $back = $response2;
    }
    return $back;
}

function getUserNameFamily($mobile, $forceUpdate = false)
{
    $res = getUserInfoByNumber($mobile, $forceUpdate);
    if (isset($res['id'])) {
        return $res['firstName'] . ' ' . $res['lastName'];
    } else {
        return '';
    }
}