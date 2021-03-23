<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_permissions')) {
    error403();
    die;
}
global $View;
global $Users;
global $Cp;
global $database;
$getopt = datatable_get_opt();
if ($getopt) {
    $perm = $database->get('jk_users_permissions',"id", [
            "permKey"=>$_GET['permKey']
    ]);
    $countall = $database->count('jk_users_perms_users', [
            "permID"=>$perm
    ]);

    if ($getopt['search'] != '') {
        $userids=$database->get('users',"id",[
            "OR"=>[
                "name[~]"=>$getopt['search'],
                "family[~]"=>$getopt['search'],
            ]
        ]);
        $lists=$database->select('jk_users_perms_users','*', [
            "AND"=>[
                "permID"=>$perm,
                "userID"=>$userids
                ]
        ]);
    } else {
        $lists=$database->select('jk_users_perms_users','*', [
                "permID"=>$perm,
        ]);
    }
    $data = [];

    if (sizeof($lists) >= 1) {
        foreach ($lists as $tr) {
            array_push($data, [
                "name" => nickName($tr['userID']),
                "permission" => \Joonika\checkValueHtmlFa($tr['value']),
                "operation" => '<button type="button" class="btn btn-warning btn-sm"
                                                            onclick="removeuserperm('.$tr['id'].')"><i
                                                                class="fa fa-times"></i></button><span id="userbtn_span_'.$tr['id'].'"></span>',
            ]);

        }
    }

    echo datatable_view([
        "CountAll" => $countall,
        "list" => $lists,
        "data" => $data,
    ]);

}
