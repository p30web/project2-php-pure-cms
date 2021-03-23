<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('blog_pages_add')) {
    error403();
    die;
}

if(isset($_POST['title'])){
    global $database;


    if(isset($_POST['editID'])){

        $database->update('bulletin', [
            "title" => $_POST['title'],
            "text" => $_POST['text'],
            "img"  => $_POST['img'],
            "update_at"=>date("Y/m/d H:i:s"),
        ],[
            "ID"=>$_POST['editID']
        ]);
        $idinsert=$_POST['editID'];
    }else{
        $database->insert('bulletin', [
            "title" => $_POST['title'],
            "text" => $_POST['text'],
            "img"  => $_POST['img'],
            "create_at"=>date("Y/m/d H:i:s"),
        ]);
        $idinsert=$database->id();
    }
    if($idinsert>=1){

    }
    echo alert([
        "type"=>"success",
        "text"=>__("successfully saved"),
    ]);
    echo redirect_to_js(JK_DOMAIN_LANG.'cp/blog/pages/');
}
