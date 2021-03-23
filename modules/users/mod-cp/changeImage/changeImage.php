<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('cp')) {
    error403();
    die;
}
if(isset($_POST['image'])){
    global $database;
    $database->update('jk_users',[
        "profileImage"=>$_POST['image']
    ],[
        "id"=>$_POST['userID']
    ]);
    $database->insert('jk_users_profile_images',[
        "userID"=>$_POST['userID'],
        "fileID"=>$_POST['image'],
        "datetime"=>date("Y/m/d H:i:s")
    ]);
    echo redirect_to_js("");
    exit();
}
global $View;
$View->footer_js('<script>
function submitImage() {
  ' . ajax_load([
        "url" => JK_DOMAIN_LANG . 'cp/users/changeImage/changeImage',
        "success_response" => "#modal_global_body",
        "data" => "$(\"#changeImageForm\").serialize()",
        "loading" => [
        ]
    ]) . '
}

</script>');
\Joonika\Upload\dropzone_load();
echo $View->getHeaderStylesFiles();
echo \Joonika\Forms\form_create([
    "id"=>"changeImageForm"
]);
echo \Joonika\Forms\field_hidden([
    "name"=>"userID",
    "value"=>$_POST['userID'],
]);
echo \Joonika\Upload\field_upload([
    "title" => __("image"),
    "name" => "image",
    "afterSuccess" => "submitImage();",
    "ColType"=>'12,12',
    "maxfiles"=>1,
    "module"=>"users_profile",
    "text"=>__('Drop files to upload'),
]);
echo \Joonika\Forms\form_end();

echo $View->getFooterJsFiles();
echo $View->getFooterJs();
