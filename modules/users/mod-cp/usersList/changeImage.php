<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_list')) {
    error403();
    die;
}
if(isset($_POST['userID'])){
global $View;
global $Route;
global $database;
if (isset($_POST['saveform'])) {
    $database->update('jk_users',[
        "profileImage"=>$_POST['imgprf']
    ],[
        "id"=>$_POST['userID']
    ]);
    $database->insert('jk_users_profile_images',[
        "userID"=>$_POST['userID'],
        "fileID"=>$_POST['imgprf'],
        "datetime"=>date("Y/m/d H:i:s")
    ]);
    echo alert();
    exit;
}

\Joonika\Forms\form_create([
    "id" => "globalForm",
]);
    echo \Joonika\Forms\field_hidden([
        "name" => "userID",
        "value" => $_POST['userID'],
    ]);
?>
    <div class="row">
        <?php
        global $data;
        echo \Joonika\Forms\field_hidden([
            "name" => "saveform",
            "value" => 1,
        ]);
        echo div_start('col-12');
        echo \Joonika\Upload\field_upload([
            "title" => __("new image profile"),
            "name" => "imgprf",
            "ColType"=>'12,12',
            "maxfiles"=>1,
            "module"=>"users",
        ]);
        echo div_close();
        ?>
    </div>
<?php
echo \Joonika\Forms\field_submit([
    "text" => __("save"),
    "ColType" => "12,12",
    "btn-class" => "btn btn-primary btn-lg btn-block",
    "icon" => "fa fa-save"
]);

\Joonika\Forms\form_end();

$View->footer_js('<script>
' . ajax_validate([
        "on" => "submit",
        "formID" => "globalForm",
        "url" => JK_DOMAIN_LANG . 'cp/users/usersList/changeImage',
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
</script>');
echo $View->getFooterJsFiles();
echo $View->footer_js;
}