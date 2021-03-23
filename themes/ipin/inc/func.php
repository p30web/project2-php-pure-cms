<?php
if(!defined('jk')) die('Access Not Allowed !');
global $View;
global $Theme;
$View->setTitle($Theme->siteTitle);
if(is_readable(__DIR__.DS.'header.php')){
    $View->head_file=__DIR__.DS.'header.php';
}
if(is_readable(__DIR__.DS.'footer.php')){
    $View->foot_file=__DIR__.DS.'footer.php';
}
define("THEME_CDN","https://cdn.ipinbar.net");
function readingTime($content=""){
    $num=1;
    $newText=explode(" ",$content);
    if(sizeof($newText)>=1){
        $getCountable=[];
        $noCount=[
            ' ', ',', ';', '.', '!', '"', '(', ')', '?', ':', '\'', '«' , '»', '+', '-'
        ];
        foreach ($newText as $nt){
            if(!in_array($nt,$noCount)){
                array_push($getCountable,$nt);
            }
        }
        if(sizeof($getCountable)>=1){
            $sizeC=sizeof($getCountable)/200;
            $num=intval($sizeC)+1;
        }
    }
    return $num;
}