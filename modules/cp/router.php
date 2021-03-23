<?php
if(!defined('jk')) die('Access Not Allowed !');
global $View;
global $Route;
global $Cp;
global $Users;
$Cp=new Joonika\Modules\Cp\Cp();
$path_tmp = $Route->path;
$View->head_file=__DIR__.DS.'inc'.DS.'head.php';
$View->foot_file=__DIR__.DS.'inc'.DS.'foot.php';
$View->login_page=JK_DOMAIN_LANG.'cp/main/login/';
$Route->themeRoute=false;
if (!isset($path_tmp[1]) || $path_tmp[1]=="main") {
    unset($path_tmp[1]);
    if(!isset($path_tmp[2])){
        $path_tmp[1]='main';
    }
$path_tmp=array_values($path_tmp);
    $Route->path = $path_tmp;
    $Route->forceNotRoute = true;
    $Route->dispatch();
    $Route->forceNotRoute = false;
    $View->render();
} else {
    $Route->subFolder = 'mod-cp';
    $newpath = $Route->path;
    if ($newpath[1] == "index") {
        unset($newpath[1]);
    } else {
        unset($newpath[0]);
    }
    $newpath=array_values($newpath);
    $Route->path = $newpath;
    $Route->forceNotRoute = true;
    $Route->dispatch();
    $View->render();
}
