<?php
/**
 * File Name : visit.php
 * Created by P30web.org.
 * User: Alireza Ahmadi <alireza@p30web.org>
 * Author URI : https://www.p30web.org/
 * Support : https://my.p30web.org/submitticket.php?step=2&deptid=1
 * Date: 03/01/2019
 * Time: 03:01 PM
 * Version : 1.0
 */

//error_reporting(0);
include'includes/aparat.class.php';
$a = new Aparat;

echo "<pre>";

foreach($a->mostviewedvideos(50) as $video){
    print_r($video);
}

echo "</pre>";