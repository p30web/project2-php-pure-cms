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
    $database->update('jk_users', [
        "password" => hashpass($_POST['password']),
    ], [
        "id" => $_POST['userID'],
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
        echo \Joonika\Forms\field_text(
            [
                "name" => "password",
                "type" => "password",
                "direction" => "ltr",
                "title" => __("password"),
                "required" => true,
                "ColType" => "12,12",
            ]
        );
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
        "url" => JK_DOMAIN_LANG . 'cp/users/usersList/changePassword',
        "success_response" => "#modal_global_body",
        "loading" => ['iclass-size' => 1, 'elem' => 'span']
    ]) . '
</script>');
echo $View->getFooterJsFiles();
echo $View->footer_js;
}