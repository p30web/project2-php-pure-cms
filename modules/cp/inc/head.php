<?php
if(!defined('jk')) die('Access Not Allowed !');

global $View;
global $Route;
global $Users;
global $Cp;
?>
<!DOCTYPE html>
<html lang="<?php echo JK_LANG ?>" dir="<?php echo JK_DIRECTION ?>">
<head >
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $Cp->getSidebarActive(); ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/modules/cp/assets/bootstrap/css/bootstrap.min.css">
    <?php
    if(JK_DIRECTION=="rtl"){
        ?>
        <link rel="stylesheet" href="/modules/cp/assets/bootstrap-rtl/bootstrap-rtl.min.css">
    <?php
    }
    ?>
    <link rel="stylesheet" href="/modules/cp/assets/iranSans/css/fontiran.css">
    <link rel="stylesheet" href="/modules/cp/assets/fa/css/all.min.css">
    <link rel="stylesheet" href="/modules/cp/assets/iranSans/css/fontiran.css">

    <?php
    if(sizeof($View->header_styles_files) >=1 ){
        foreach ($View->header_styles_files as $header_js_file) {
            ?>
            <link rel="stylesheet" href="<?php echo $header_js_file ?>">

            <?php
        }
    }
    ?>


    <link rel="stylesheet" href="/modules/cp/assets/css/style.css?v=2">
</head>
<body>
<!-- .app -->
<div class="app">
    <!-- .app-header -->
    <?php
    if($Cp->topHeader){
    include_once(__DIR__.'/header.php');
    }

    ?>
    <!-- /.app-header -->
    <!-- .app-aside -->
    <?php
    $mainClass="app-main";
    if($Users->isLogged()){
        $mainClass.="-".JK_DIRECTION;
        include_once(__DIR__ . '/sidebar.php');
    }
        ?>
        <!-- /.app-aside -->
    <?php
    if($Cp->topHeader) {
        ?>
        <!-- .app-main -->
    <main class="<?php echo $mainClass ?>">
            <!-- .wrapper -->
            <div class="wrapper">
                <!-- .page -->
                <div class="page">
                    <!-- .page-inner -->
                    <div class="page-inner">
        <?php
    }
            ?>