<?php 
//error_reporting(0);
include'includes/aparat.class.php';
$a = new Aparat;
return print_r($a->commentByVideo('sGNgD', 5));
