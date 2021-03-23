<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
global $Users;
$Users->loggedCheck();
if (!$ACL->hasPermission('crm_tickets')) {
    error403();
    die;
}
global $Route;
if(!isset($Route->path[3])){
    die("file error 1");
}
$fileR=$Route->path[3];
$filesR=explode('-',$fileR);
if(sizeof($filesR)!=3){
    die("file error 2");
}
$noteID=$filesR[0];
$fileID=$filesR[1];
$hash=$filesR[2];
global $database;
$getAttach=$database->get('crm_tickets_attachments','*',[
        "AND"=>[
                "noteID"=>$noteID,
                "fileID"=>$fileID,
                "hash"=>$hash,
        ]
]);
if(!isset($getAttach['id'])){
    die("file error 3");
}
$fileInfo=\Joonika\Upload\getFileInfo($fileID);

header('Content-type: ' . $fileInfo['mime']);
readfile(JK_SITE_PATH.$fileInfo['file']);