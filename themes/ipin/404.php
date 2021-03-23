<?php
if(!defined('jk')) die('Access Not Allowed !');
header("HTTP/1.0 404 Not Found");
global $View;
global $Theme;
global $Route;
global $database;
$View->title=__("not found")." | ".$View->title;
$thumbnail='<?php echo THEME_CDN; ?>/themes/ipin/assets/img/404.png';
$View->head();
?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-4 text-center">
                <img class="img " src="<?php echo THEME_CDN; ?>/themes/ipin/assets/img/404.png">
                <h5>صفحه درخواستی یافت نشد.</h5>
                <a class="btn btn-info" href="<?php echo JK_DOMAIN_LANG ?>"><i class="fa fa-home"></i> بازگشت به صفحه اصلی</a>
            </div>
        </div>
    </div>

<?php
$View->foot();
