<?php
/**
 * File Name : chanel.php
 * Created by P30web.org.
 * User: Alireza Ahmadi <alireza@p30web.org>
 * Author URI : https://www.p30web.org/
 * Support : https://my.p30web.org/submitticket.php?step=2&deptid=1
 * Date: 12/01/2019
 * Time: 08:33 PM
 * Version : 1.0
 */

if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('aprat_modcp_chanel')) {
    error403();
    die;
}


global $View;
global $Users;
global $Cp;
global $Aparat;
global $Route;
$Cp->setSidebarActive('aparat/chanel');

$View->footer_js();
$View->header_styles_files("/modules/aparat/files/jumbotron-narrow.css");
$View->head();

?>

<?php

$chanel_name = null;
$chanel_length = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $chanel_name = test_input($_POST["chanel_name"]);
    $chanel_length = test_input($_POST["chanel_length"]);
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function CheekUserInformation($Parm)
{
    if (!empty($Parm)) {
        return $Parm;
    } else {
        return "اطلاعات موجود نمی باشد .";
    }
}

function CheekNotNull($Item){
    if($Item !== null){
        return $Item;
    }
}

?>

    <style>
        .card.card-pink {
            background: #d31d5b;
            color: #fff;
            text-align: center;
        }

        .card.card-pink span:nth-child(1){
            padding: 9px 2px 15px 0;
        }

        .card.card-pink span:nth-child(2){
            padding: 10px 2px 12px 0;
            background: rgba(1, 1, 1, 0.15);
        }
    </style>
    <div class="card card-info IRANSans">
        <div class="card-body">
            اطلاعات کانال :
            <hr style="margin-top: 10px;border-top: 5px solid #eeeeee;"/>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <form method="post"
                              action="<?php echo htmlspecialchars(JK_DOMAIN_LANG . "cp/aparat/chanel"); ?>">
                            <label for="chanel_name"> نام کاربری کانال : </label>
                            <input placeholder="نام کاربری کانال مورد نظرتان را وارد کنید" value="<?php echo CheekNotNull($chanel_name); ?>" id="chanel_name" type="text"
                                   name="chanel_name" style="width:30%;">
                            <br>
                            <label> تعداد نمایش :
                                <select name="chanel_length" class="">
                                    <option value="12">12</option>
                                    <option value="24">24</option>
                                    <option value="48">48</option>
                                    <option value="96">96</option>
                                </select>
                            </label>
                            <br>
                            <input type="submit" name="submit" value="آنالیز کانال">
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="card card-info IRANSans">
        <div class="card-body">
            <div class="container">

                <div class="row">
                    <div class="col-12">

                        <span style="background: #4d5568;margin-left: 4px;color: #fff;padding: 4px 7px 4px 7px;border-radius: 2px;"> اطلاعات وارد شده : </span>
                        <span style="background: #d31d5b;color: #fff;padding: 4px 7px 4px 7px;border-radius: 2px;"><?php echo "تعداد نمایش در هر صفحه : " . $chanel_length; ?></span>



                    </div>
                </div>

                <br>

                <?php

                if ($chanel_name != null) {
                    $ProFile = $Aparat->profile($chanel_name);
                    echo '<div class="row">';
                    echo '<div class="col-2">';
                    echo "<img src='" . $ProFile['pic_m'] . "' alt=''>";
                    echo '</div>';

                    echo '<div class="col-10">';
                    echo 'نام کانال : ';
                    echo '<a href="https://www.aparat.com/' . $chanel_name . '" target="_blank">  ' . CheekUserInformation($ProFile['name']) . ' </a>';

                    echo " - ";

                    echo "نام کاربری : " . $chanel_name;

                    echo "<br>";

                    echo CheekUserInformation($ProFile['descr']);

                    echo "<br>";

                    $TypeChanel = ($ProFile['official'] == 'yes' ) ? ' رسمی' : ' عادی';

                    echo "نوع کانال : " . $TypeChanel;

                    echo '</div>';

                    echo '</div>';

                    echo '</div></div></div>';


                    echo '<div class="row">';

                    echo '<div class="col-3">';
                    echo '<div class="card card-pink">';
                    echo '<span class="cl1">دنبال کننده : </span>';
                    echo '<span class="cl2">' . CheekUserInformation($ProFile['follower_cnt']) . '</span>';
                    echo '</div>';
                    echo '</div>';

                    echo '<div class="col-3">';
                    echo '<div class="card card-pink" style="background: #8f8f8f;">';
                    echo '<span>دنبال شونده : </span>';
                    echo '<span>' . CheekUserInformation($ProFile['followed_cnt']) . '</span>';
                    echo '</div>';
                    echo '</div>';

                    echo '<div class="col-3">';
                    echo '<div class="card card-pink" style="background: #4e5668;">';
                    echo '<span>تعداد ویدیو ها : </span>';
                    echo '<span>' . CheekUserInformation($ProFile['video_cnt']) . '</span>';
                    echo '</div>';
                    echo '</div>';

                    echo '<div class="col-3">';
                    echo '<div class="card card-pink" style="background: #b59381;">';
                    echo '<span>ای دی کاربر : </span>';
                    echo '<span>' . CheekUserInformation($ProFile['userid']) . '</span>';
                    echo '</div>';
                    echo '</div>';

                    echo '</div>';




                    echo '<div class="card card-info IRANSans"><div class="card-body">';
                    //echo "<pre style='text-align: left;direction: ltr;'>";
                    $VidioByUser = $Aparat->videobyuser($chanel_name, $chanel_length);

                    $ProfileCategoriesByUser = $Aparat->profilecategories($chanel_name);
                    //echo "</pre>";
                    ?>

                    <div class="row">
                        <div class="cod-12">
                            <ul class="categories">
                                <?php
                                if(!empty($ProfileCategoriesByUser)) :
                                    ?>
                                    <li class="active"><a href="#" ?>همه</a></li> <?php
                                foreach($ProfileCategoriesByUser as $id): ?>
                                    <li class="active"><a href="<?php echo '?m=categories&id=' . $id['id']; ?>"><?= $id['name'] ?> </span></a></li>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <?php foreach($VidioByUser as $video): ?>
                            <div class="col-4 col-md-3">
                                <a href="<?php echo 'https://www.aparat.com/'.'v/'.$video['uid'].'/'.$Aparat->sanitizeStringForUrl($video['title']); ?>">
                                    <div class="video_thumb" style="background-image:url('<?= $video['small_poster'] ?>');"></div>
                                </a>
                                <div class="video_duration"><?= $Aparat->duration($video['duration']) ?></div>
                                <div class="video_bazdid"><?php $Aparat->ViewFormat($video['visit_cnt']); ?></div>
                                <div class="video_information">
                                    <a href="<?php echo 'https://www.aparat.com/'.'v/'.$video['uid'].'/'.$Aparat->sanitizeStringForUrl($video['title']) ?>"><?php echo $Aparat->truncate($video['title'], 42); ?></a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <?php
                } else if ($chanel_name === null) {
                    echo '<br>';
                    echo '<div class="row">';
                    echo '<div class="col-12">';
                    echo '<p>هیچ کانالی وارد نشده است ، برای شروع نام کاربری یک کانال را وارد کنید</p>';
                    echo "</div>";
                    echo "</div>";
                }

                ?>


            </div>
        </div>

    </div>

<?php

$View->foot();