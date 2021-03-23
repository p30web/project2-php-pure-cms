<?php
if (!defined('jk')) die('Access Not Allowed !');
global $View;
global $Theme;
global $database;
//header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
header("Access-Control-Allow-Origin: *");
$View->title .= " | " . $Theme->siteDescription;
$Theme->siteDescription = "باربری اینترنتی و پایانه اعلام بار با اپلیکیشن و تابلو آنلاین اعلان بار شهری، حمل بار جاده ای با هزاران وانت، نیسان، خاور، تک، جفت، تریلی و بار تانکر.";

$View->header_styles_files('/themes/ipin/assets/css/slider.css');
//$View->footer_js_files('https://code.jquery.com/jquery-migrate-3.0.1.js');
//$View->footer_js_files('/themes/ipin/assets/js/owl.carousel.min.js');
//$View->footer_js_files('/themes/ipin/assets/js/OwlCarousel2Thumbs.min.js');

$View->head();
$View->footer_js('<script>
$(\'.carousel\').carousel()
</script>');
?>
<?php
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}

//include_once('template_part/slider.php');

?>

    <div class="section padding-tb-30px section-ba-2">
        <div class="container">
            <!-- Title -->
            <div class="section-title mb-3">
                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <div class="icon text-main-color"><i class="fa fa-commenting-o"></i></div>
                        <div class="h2">اخبار سایت</div>
                        <div class="des d-none">برای هر چه بهتر ارائه خدمات به شما مشتریان گرامی، انتقادات و پیشنهادات
                            کمک به
                            سزایی به ما خواهد کرد.
                        </div>
                    </div>
                </div>
            </div>
            <!-- // End Title -->

            <div class="row">
                <?php
                $categorySelect = 38;
                $datas = $database->select('jk_data_categories_rel', "dataID", [
                    "categoryID" => $categorySelect
                ]);
                if (sizeof($datas) == 0) {
                    $datas = 0;
                }
                $getPosts = $database->select('jk_data', '*', [
                    "AND" => [
                        "id" => $datas,
                        "status" => "active",
                        "datetime[<=]" => date("Y/m/d H:i:s"),
                        "module" => "blog_post"
                    ],
                    "ORDER" => ["id" => "DESC"]
                ]);
                if (sizeof($getPosts) >= 1) {
                    foreach ($getPosts as $getPost) {
                        $thumbnail = \Joonika\Upload\getDataThumbail($getPost['id'], 'th-70-70', false, 'themes/ipin/assets/img/default-255-155.png');
                        ?>
                        <a href="<?php echo JK_DOMAIN_LANG . $getPost['slug']; ?>" class="col-12 col-md-3">
                            <div class="card mb-4 shadow-sm ">
                                <div class="row">
                                    <div class="col-12">
                                        <p class=""><?php echo $getPost['title'] ?></p>
                                    </div>
                                </div>
                                <div class="w-100"></div>
                                <div class="text-muted p-2" style="height: 90px;overflow: hidden">
                                    <?php echo $getPost['description']; ?>
                                </div>
                                <button type="button" class="btn btn-outline-info btn-sm d-inline">ادامه خبر</button>
                            </div>
                        </a>
                        <?php
                    }
                }
                ?>
            </div>


        </div>
    </div>



    </div>

<?php
$View->foot();
