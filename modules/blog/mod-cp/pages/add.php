<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('blog_pages_add')) {
    error403();
    die;
}

if(isset($_POST['title'])){
    global $database;
    $htmlmode='editor';
    $text=$_POST['text_editor'];
    if(isset($_POST['htmlMode']) && $_POST['htmlMode']=='html'){
        $htmlmode='html';
        $text=$_POST['text_html'];
    }
    $datastyles='';
    $template_default='';
    if(isset($_POST['template'])){
        $template_default=$_POST['template'];
    }
    $addThumb=[];
    $thumbnails=\Joonika\Upload\getThumbnails(JK_WEBSITE_ID);
    if(sizeof($thumbnails)>=1){
        foreach ($thumbnails as $thumbnail){
            $th='thumbnail_'.$thumbnail['id'];
            if(isset($_POST[$th]) && $_POST[$th]!=""){
                $addThumb[$thumbnail['id']]=$_POST[$th];
            }
        }
    }
    if(isset($_POST['editID'])){
        $slug=\Joonika\Modules\Blog\slugify($_POST['slug'],[
            "editID"=>$_POST['editID']
        ]);
        $database->update('jk_data', [
            "title" => $_POST['title'],
            "status" => $_POST['status'],
            "slug" => $slug,
            "description" => $_POST['description'],
            "text" => $text,
            "htmlMode" => $htmlmode,
            "template" => $template_default,
            "datetime"=>date("Y/m/d H:i:s"),
        ],[
            "ID"=>$_POST['editID']
        ]);
        $idinsert=$_POST['editID'];
    }else{
        $slug=\Joonika\Modules\Blog\slugify($_POST['slug']);
        $database->insert('jk_data', [
            "title" => $_POST['title'],
            "status" => $_POST['status'],
            "slug" => $slug,
            "description" => $_POST['description'],
            "text" => $text,
            "htmlMode" => $htmlmode,
            "template" => $template_default,
            "module"=>'blog_page',
            "websiteID"=>JK_WEBSITE_ID,
            "datetime"=>date("Y/m/d H:i:s"),
            "datetime_s"=>date("Y/m/d H:i:s"),
            "creatorID"=>JK_LOGINID,
            "lang"=>JK_LANG,
            "parent" => 0,
        ]);
        $idinsert=$database->id();
    }
    if($idinsert>=1){
        if(isset($_POST['tags'])){
            \Joonika\Modules\Blog\tags_update_data($_POST['tags'],$idinsert);
        }
        if(sizeof($addThumb)>=1){
            \Joonika\Modules\Blog\dataAddTh($addThumb,$idinsert);
        }

    }
    echo alert([
        "type"=>"success",
        "text"=>__("successfully saved"),
    ]);
    echo redirect_to_js(JK_DOMAIN_LANG.'cp/blog/pages/');
}
