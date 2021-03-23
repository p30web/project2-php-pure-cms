<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_permissions')) {
    error403();
    die;
}
global $View;
global $database;

if (isset($_POST) && sizeof($_POST) >= 3 && isset($_POST['groupID']) && isset($_POST['roleID'])) {
    foreach ($_POST as $keyv => $value) {
        if (substr($keyv, 0, 5) === "perm_") {
            $key = str_replace('perm_', '', $keyv);
            $daletebefore = $database->delete('jk_users_perms_groups', [
                "AND" => [
                    "permID" => $key,
                    "groupID" => $_POST['groupID'],
                    "roleID" => $_POST['roleID']
                ]
            ]);
            if ($value == '1') {
                $insertdb = $database->insert('jk_users_perms_groups', [
                    "permID" => $key,
                    "groupID" => $_POST['groupID'],
                    "roleID" => $_POST['roleID'],
                    "value"=>1,
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
            "url" => JK_DOMAIN_LANG . 'cp/users/permissions/group/search',
            "data" => "{groupID:".$_POST['groupID'].",roleID:".$_POST['roleID']."}",
            "success_response" => "#seach_perm",
        ]) . '
    </script>
    ');
    echo $View->footer_js;
} elseif (isset($_POST) && sizeof($_POST) == 2 && isset($_POST['groupID']) && isset($_POST['roleID'])) {
    $daletebefore = $database->delete('jk_users_perms_groups', [
        "AND" => [
            "groupID" => $_POST['groupID'],
            "roleID" => $_POST['roleID'],
        ]
    ]);
    echo alert([
        "type" => "success",
        "elem" => "span",
    ]);
    $View->footer_js('
    <script>
    ' . ajax_load([
            "url" => JK_DOMAIN_LANG . 'cp/users/permissions/group/search',
            "data" => "{groupID:".$_POST['groupID'].",roleID:".$_POST['roleID']."}",
            "success_response" => "#seach_perm",
        ]) . '
    </script>
    ');
    echo $View->footer_js;
}