<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('cp_siteSetting')) {
    error403();
    die;
}
if(isset($_POST['remid'])){
    global $database;
    $th=$database->get('jk_thumbnails','*',[
        "AND"=>[
            "id"=>$_POST['remid'],
            "websiteID"=>JK_WEBSITE_ID
        ]
    ]);
    if(isset($th['id'])){
        $database->delete('jk_thumbnails',[
            "id"=>$th['id']
        ]);
        global $View;
        $View->footer_js( '<script>
    $("#thumbnail_th_'.$th['id'].'").remove();
    </script>');
        echo $View->footer_js;
    }
}
