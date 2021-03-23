<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('aprat_modcp_cat')) {
    error403();
    die;
}
global $View;
global $Users;
global $Cp;
global $Aparat;
global $Route;
$Cp->setSidebarActive('aparat/cat');

$View->footer_js();
$View->header_styles_files("/modules/aparat/files/jumbotron-narrow.css");
$View->head();


?>
    <div class="card card-info IRANSans">
        <div class="card-body">
            پربازدیدترین ویدیوها:
            <hr style="margin-top: 10px;border-top: 5px solid #eeeeee;" />
            <div class="container">
                <div class="row">
                    <div class="cod-12">
                        <ul class="categories">
                            <?php foreach($Aparat->categories() as $id): ?>
                                <li class="active"><a href="<?php echo '?m=categories&id=' . $id['id']; ?>"><?= $id['name'] ?> <!--<?= $id['videoCnt'] ?>--></span></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div style="clear: both;"></div>
            <?php $ID = (isset($_GET['id'])) ? $_GET['id'] : '22' ?>

            <div class="container">
                <div class="row">
                    <?php foreach($Aparat->categoryvideos($ID, 200) as $video): ?>
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
            </div>



        </div>
    </div>
<?php
$View->foot();