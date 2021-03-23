<?php
if (!defined('jk')) die('Access Not Allowed !');
global $View;
global $Theme;
global $Route;
global $database;

?><!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title><?php echo $View->getTitle(); ?></title>
    <meta name="keywords" content="<?php echo $Theme->siteKeywords; ?>"/>
    <meta name="description" content="<?php echo $Theme->siteDescription; ?>"/>
    <?php
//    if($Route->uri=='fa'){
//?>
<!--        <link rel="canonical" href="https://ipinbar.net/">-->
<!--        --><?php
//    }
    ?>
    <meta name="copyright" content="ipinbar">
    <meta name="language" content="fa">
    <meta name="google" content="notranslate">

    <meta name="robots" content="index follow">

    <meta name="googlebot" content="index follow">
    <meta name="samandehi" content="712692104"/>
    <meta property="og:title" content="<?php echo $View->getTitle(); ?>"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="https://ipinbar.net"/>
    <meta property="og:image" content="<?php echo THEME_CDN; ?>/themes/ipin/assets/img/logo.png"/>
    <meta property="og:site_name" content="<?php echo $Theme->siteTitle; ?>"/>
    <meta property="og:description" content="<?php echo $Theme->siteDescription; ?>"/>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap -->
    <link rel="stylesheet" href="<?php echo THEME_CDN; ?>/themes/ipin/assets/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo THEME_CDN; ?>/themes/ipin/assets/bootstrap-rtl/bootstrap-rtl.css">
    <!-- main style -->
    <!-- owl Carousel assets -->
    <link rel="stylesheet" href="<?php echo THEME_CDN; ?>/themes/ipin/assets/iranSans/css/fontiran.css">
    <link rel="stylesheet" href="<?php echo THEME_CDN; ?>/themes/ipin/assets/css/style.css?v=5">
    <link rel="stylesheet" href="<?php echo THEME_CDN; ?>/themes/ipin/assets/aos/aos.css">
    <style>
        .pt-3, .py-3 {
            padding-top: 1rem!important;
            padding-bottom: 1rem!important;
        }
    </style>
    <!-- fontawesome  -->
    <link rel="stylesheet" href="<?php echo THEME_CDN; ?>/themes/ipin/assets/fa/css/all.css">
    <?php
    if(sizeof($View->header_styles_files) >=1 ){
        foreach ($View->header_styles_files as $header_js_file) {
            ?>
            <link rel="stylesheet" href="<?php echo $header_js_file ?>">

            <?php
        }
    }
    ?>
    <!-- REVOLUTION STYLE SHEETS -->
    <script type="application/lds+json">{"@context":"http://schema.org","@type":"Blog","url":"https://ipinbar.net/fa/blog"}</script>
<!--    <script type="text/javascript" src="https://www.p30rank.ir/google"></script>-->
</head>
<body dir="rtl">
<header>
    <div class="header-output pt-3 background-white">
        <div class="container header-in">
            <div class="position-relative">
                <div class="row">
                    <div class="col-lg-3 col-md-12">
                        <a id="logo" href="<?php echo JK_DOMAIN_LANG ?>" class="d-inline-block float-right ">
                           <h2>آزمایشگاه پی سی وب</h2>
                        </a>
                        <a class="mobile-toggle p-2 background-second-color border-radius-3" href="#"><i
                                    class="fa fa-bars"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="fixed-header-dark" class="header-output">
        <div class="header-output">
            <div class="background-main-color clearfix">
                <div class="container">
                    <div class="position-relative">
                        <div class="row">
                            <div class="col-lg-12 position-inherit">
                                <ul id="menu-main"
                                    class="nav-menu float-lg-right text-lg-right link-padding-tb-16px white-link">
                                    <li class=""><a href="<?php echo JK_DOMAIN_LANG ?>">خانه</a></li>
                                </ul>
                                <div class="search-link pull-left float-lg-left model-link mt-2 mb-2" style="">
                                    <a href="<?php echo JK_DOMAIN_LANG ?>"
                                       class="btn btn-outline-warning  d-inline d-lg-none"><i class="fa fa-home"></i></a>
                                    <a href="<?php echo JK_DOMAIN_LANG ?>cp"
                                       class="btn btn-warning border-main-color"><i class="fa fa-sign-in-alt"></i> ورود / ثبت نام</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>


