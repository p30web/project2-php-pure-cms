<?php
if (!defined('jk')) die('Access Not Allowed !');
global $View;
global $Theme;

?><!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title><?php echo $View->getTitle(); ?></title>
    <meta name="keywords" content="<?php echo $Theme->siteKeywords; ?>"/>
    <meta name="description" content="<?php echo $Theme->siteDescription; ?>"/>

    <meta name="copyright" content="ipinbar">
    <meta name="language" content="fa">
    <meta name="google" content="notranslate">

    <meta name="robots" content="index follow">

    <meta name="googlebot" content="index follow">

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
    <!-- fontawesome  -->
    <link rel="stylesheet" href="<?php echo THEME_CDN; ?>/themes/ipin/assets/fa/css/all.css">
    <link rel="stylesheet" href="<?php echo THEME_CDN; ?>/themes/ipin/assets/club/club.css">
    <!-- REVOLUTION STYLE SHEETS -->
    <script type="application/ld+json">{"@context":"http://schema.org","@type":"Blog","url":"https://ipinbar.net/fa/blog/"}</script>

</head>
<body>
