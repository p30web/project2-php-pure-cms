<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_permissions')) {
    error403();
    die;
}
global $View;
global $database;

if (isset($_POST) && sizeof($_POST) >= 2 && isset($_POST['userID'])) {
    foreach ($_POST as $keyv => $value) {
        if (substr($keyv, 0, 5) === "perm_") {
            $key = str_replace('perm_', '', $keyv);
            $daletebefore = $database->delete('jk_users_perms_users', [
                "AND" => [
                    "permID" => $key,
                    "userID" => $_POST['userID']
                ]
            ]);
            if ($value != '') {
                $insertdb = $database->insert('jk_users_perms_users', [
                    "permID" => $key,
                    "userID" => $_POST['userID'],
                    "value" => $value
                ]);
            }
        }
    }
    echo alert([
        "type" => "success",
        "elem" => "span",
    ]);
    $View->footer_js('
    <script>
    ' . ajax_load([
            "url" => JK_DOMAIN_LANG . 'cp/users/permissions/user/search',
            "data" => "{userID:".$_POST['userID']."}",
            "success_response" => "#seach_perm",
        ]) . '
    </script>
    ');
    echo $View->footer_js;
} elseif (isset($_POST) && sizeof($_POST) == 1 && isset($_POST['userID'])) {
    $daletebefore = $database->delete('jk_users_perms_users', [
        "userID" => $_POST['userID']
    ]);
    echo alert([
        "type" => "success",
        "elem" => "span",
    ]);
    $View->footer_js('
    <script>
    ' . ajax_load([
            "url" => JK_DOMAIN_LANG . 'cp/users/permissions/user/search',
            "data" => "{userID:".$_POST['userID']."}",
            "success_response" => "#seach_perm",
        ]) . '
    </script>
    ');
    echo $View->footer_js;
}