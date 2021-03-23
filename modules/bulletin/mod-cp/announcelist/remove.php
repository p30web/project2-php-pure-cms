<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('faq_list')) {
    error403();
    die;
}
global $View;
global $database;

if(isset($_REQUEST['remid'])){
    $database->delete('bulletin',['id' => $_REQUEST['remid']]);
}
