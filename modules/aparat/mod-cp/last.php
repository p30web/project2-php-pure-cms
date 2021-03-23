<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('aprat_modcp_index')) {
    error403();
    die;
}
global $View;
global $Users;
global $Cp;
global $Aparat;
global $Route;
$Cp->setSidebarActive('aparat/index');

$View->footer_js('
<script>
</script>
');
$View->header_styles_files("/modules/aparat/files/jumbotron-narrow.css");
$View->head();


?>
    <div class="card card-info IRANSans">
        <div class="card-body">
            آخرین ویدیوها:
            <hr style="margin-top: 10px;border-top: 5px solid #eeeeee;" />

            <div class="container">
                <div class="row">
                    <?php foreach($Aparat->mostviewedvideos(150) as $video){ ?>
                        <div class="col-3"> <a href="<?php echo 'https://www.aparat.com/' .'v/'.$video['uid'].'/'.$Aparat->sanitizeStringForUrl($video['title']); ?>">
                                <div class="video_thumb" style="background-image:url('<?php  echo $video['small_poster']; ?>');"></div>
                            </a>
                            <div class="video_duration">
                                <?php echo $Aparat->duration($video['duration']); ?>
                            </div>
                            <div class="video_bazdid">
                                <?php echo $Aparat->ViewFormat($video['visit_cnt']);  ?>
                            </div>
                            <div class="video_information"> <a href="<?php echo 'https://www.aparat.com' . 'v/'.$video['uid'].'/'.$Aparat->sanitizeStringForUrl($video['title']);?>">
                                    <?= $Aparat->truncate($video['title'], 42) ?>
                                </a> </div>
                        </div>
                    <? } ?>
                </div>
            </div>




        </div>
    </div>
<?php
$View->foot();