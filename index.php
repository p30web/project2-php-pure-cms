<?php
session_start();
require_once 'bootstrap.php';

if(!function_exists('jk_die')){
    die("site not configured correctly");
}
$Route=new \Joonika\Route();

define("JK_LANG",$Route->lang);
define("JK_LANG_LOCALE",$Route->langLocale);
define("JK_DIRECTION",$Route->direction);
if($Route->direction=='ltr'){
    define("JK_DIRECTION_SIDE","left");
    define("JK_DIRECTION_SIDE_R","right");
}else{
    define("JK_DIRECTION_SIDE","right");
    define("JK_DIRECTION_SIDE_R","left");
}
define("JK_DIRECTION_DASH",$Route->direction.'-');
define("JK_DIRECTION_DASH_R",'-'.$Route->direction);

define("JK_WEBSITE_ID",$Route->websiteID);
define("JK_DOMAIN",$Route->domainFull);
define("JK_DOMAIN_WOP",$Route->domain);
define("JK_DOMAIN_LANG",$Route->domainFull.$Route->lang.'/');
$ACL=new \Joonika\ACL();
$Aparat=new \Joonika\Aparat();

global $translate;
$translate=[];
new \Joonika\Translate();
$View=new \Joonika\View();
$Modules=new \Joonika\Modules();
$Users=new Joonika\Modules\Users\Users();
$Blog=new Joonika\Modules\Blog\Blog();
$Theme=new \Joonika\Theme();
if(isset($_SESSION[JK_DOMAIN_WOP]['userID'])){
    define("JK_LOGINID",$_SESSION[JK_DOMAIN_WOP]['userID']);
}else{
    define("JK_LOGINID",0);
}
$Route->dispatch();
$View->render();