<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('cp_siteSetting')) {
    error403();
    die;
}
if(isset($_POST)){
    global $database;
    $siteTitle=null;
    $siteDescription=null;
    $siteKeywords=null;
    if(isset($_POST['siteTitle'])) {
        $siteTitle=$_POST['siteTitle'];
    }
    if(isset($_POST['siteDescription'])) {
        $siteTitle=$_POST['siteDescription'];
    }
    if(isset($_POST['siteKeywords'])) {
        $siteTitle=$_POST['siteKeywords'];
    }
    if(isset($_POST['registrationAvailable'])) {
        jk_options_set('registrationAvailable',$_POST['registrationAvailable']);
    }
    if(isset($_POST['defaultSendEmail'])) {
        jk_options_set('defaultSendEmail',$_POST['defaultSendEmail']);
    }
    if(isset($_POST['forgotLink'])) {
        jk_options_set('forgotLink',$_POST['forgotLink']);
    }
        $checkHas=$database->update('jk_languages',[
            "siteTitle"=>$_POST['siteTitle'],
            "siteDescription"=>$_POST['siteDescription'],
            "siteKeywords"=>$_POST['siteKeywords'],
        ],[
            "AND"=>[
            "websiteID"=>JK_WEBSITE_ID,
            "slug"=>JK_LANG
            ]
        ]);
    echo alert([
        "type"=>"success",
        "text"=>__("saved"),
    ]);

}