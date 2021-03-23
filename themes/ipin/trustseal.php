<?php
global $Route;
?><!DOCTYPE html>
<html lang="fa">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="PRAGMA" content="NO-CACHE">
    <title>مجوز آی‌پین</title>
    <link href="<?php echo THEME_CDN; ?>/themes/ipin/assets/css/trustseal.css" type="text/css" rel="Stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body dir="rtl">
<div id="main">
    <div id="header">
        <?php
        if(isset($Route->path['1'])){
            if(rawurldecode($Route->path[1])=="rahdari"){
                ?>
                <img src="<?php echo THEME_CDN; ?>/themes/ipin/assets/certs/rah.png" title="سازمان راه داری و حمل و نقل جاده ای">
                <?php
            }elseif(rawurldecode($Route->path[1])=="rayaneh"){
                ?>
                <img src="<?php echo THEME_CDN; ?>/themes/ipin/assets/certs/senf.png" title="سازمان نظام صنفی رایانه ای">
                <?php
            }elseif(rawurldecode($Route->path[1])=="kasb"){
                ?>
                <img src="<?php echo THEME_CDN; ?>/themes/ipin/assets/certs/kasb.png" title="کسب و کار اینترنتی">
                <?php
            }

        }
        ?>
    </div>
    <div class="red_bl">
        <div class="red_br">
            <div class="red_tl">
                <div class="red_tr">
                    <div id="content">
                        <style>
                            table,td,tr{
                                border-bottom: 1px solid silver;
                                padding: 10px;
                            }
                        </style>
                        <table border="0" cellspacing="0" cellpadding="0" width="100%" style="font-size: 13px;border-collapse: collapse;">
                            <tbody id="subContent1">
                            <tr>
                                <td colspan="2" class="auto-style1" valign="top">
                                    آدرس سایت :
                                </td>
                                <td id="td_url" class="cell3">ipinbar.net</td>

                            </tr>
                            <tr>
                                <td colspan="2" class="auto-style1" valign="top">
                                    وضعیت نماد :
                                </td>
                                <td class="auto-style1">
                                    معتبر
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="auto-style1" valign="top">
                                    صاحب امتیاز :
                                </td>
                                <td id="td_owner" class="cell3">شبکه جامع رانندگان شجران </td>

                            </tr>
                            <tr>
                                <td colspan="2" class="auto-style1" valign="top">
                                    آدرس :
                                </td>
                                <td id="td_address" class="cell3">تهران تهران توحید ستارخان بین خیابان کوثر دوم و کوثر سوم پلاک76 طبقه 4</td>

                            </tr>
                            <tr>
                                <td colspan="2" class="auto-style1" valign="top">
                                    تلفن :
                                </td>
                                <td id="td_tel" class="cell3">021-62871</td>

                            </tr>
                            <tr class="lastRed">
                                <td colspan="2" nowrap="nowrap" class="auto-style1" valign="top">
                                    پست الكترونیكی :
                                </td>
                                <td id="td_email" class="cell3">Shajaran at hotmail.com</td>

                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>



</body>
</html>
