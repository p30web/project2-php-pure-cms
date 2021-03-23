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
if (isset($_POST['grouppermID'])) {
    $database->delete('jk_users_perms_groups', [
        "id" => $_POST['grouppermID']
    ]);
    echo alert(["type" => "success", "text" => __("removed"), "elem" => "span", "class" => "text-success "]);
    echo redirect_to_js();

} elseif (isset($_POST['rolepermID'])) {
    $database->delete('jk_users_perms_groups', [
        "AND" => [
            "roleID" => $_POST['rolepermID'],
            "permID" => $_POST['permID']
        ]
    ]);
    echo alert(["type" => "success", "text" => __("removed"), "elem" => "span", "class" => "text-success "]);
    echo redirect_to_js();
}