<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_permissions')) {
    error403();
    die;
}
global $View;
global $Users;
global $Route;
global $Cp;
global $database;

if (isset($_POST['userID'])) {
    $database->insert('jk_users_perms_users', [
        "permID" => $_POST['permID'],
        "userID" => $_POST['userID'],
        "value" => $_POST['access'],
    ]);
    echo alert(["type" => 'success', "title" => __("added")]);
    $View->footer_js( '
    <script>
    $(\'#modal_global\').on(\'hidden.bs.modal\', function () {
    ' . redirect_to_js('',0,false) . '
})
    </script>
    ');
}
\Joonika\Forms\form_create([
    "id" => "permAddUser"
]);
?>
    <h6 class="text-info text-center"><?php __e("add permission") ?>: <?php
        echo \Joonika\aclNameById($_POST['permID']);
        ?> </h6>
<?php
echo \Joonika\Forms\field_hidden([
    "name" => "permID",
    "value" => $_POST['permID'],
]);

$beforeuser = $database->select('jk_users_perms_users', 'userID', [
    "permID" => $_POST['permID']
]);
if (sizeof($beforeuser) == 0) {
    $beforeuser = 0;
}

$users = $database->select('jk_users', 'ID', [
    "AND" => [
        "id[!]" => $beforeuser,
        "status" => 'active'
    ]
]);

$array = [];
foreach ($users as $u) {
    $array[$u] = nickname($u);
}
echo \Joonika\Forms\field_select([
    "name" => "userID",
    "title" => __("user"),
    "first" => true,
    "array" => $array,
    "required" => true
]);
$array = [];
$array[1] = __("yes");
$array[0] = __("no");
echo \Joonika\Forms\field_select([
    "name" => "access",
    "title" => __("access"),
    "value" => $_POST['permID'],
    "array" => $array
]);
echo \Joonika\Forms\field_submit();
\Joonika\Forms\form_end();
$View->footer_js( '
<script>
' . ajax_validate([
        "on" => "submit",
        "formID" => "permAddUser",
        "validate" => true,
        "prevent" => true,
        "url" => JK_DOMAIN_LANG . 'cp/users/permissions/index/acl_add_user',
        "success_response" => "#modal_global_body",
        "loading" => [
        ]
    ]) . '
</script>
');

echo $View->getFooterJsFiles();
echo $View->getFooterJs();