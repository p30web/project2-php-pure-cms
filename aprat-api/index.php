<?php
    ob_start();
    session_start();
    include("includes/config.inc.php");
    include("includes/functions.php");
    include("includes/aparat.class.php");
    $a = new Aparat;
    $m = protect($_GET['m']);
    include("source/header.php");
    switch ($m) {
        case "view":
            include("source/view.php");
            break;
        case "categories":
            include("source/categories.php");
            break;
        case "search":
            include("source/search.php");
            break;
        case "api":
            include("source/api.php");
            break;
        case "aboutus":
            include("source/aboutus.php");
            break;
        default:
            include("source/home.php");
    }
    include("source/footer.php");
?>