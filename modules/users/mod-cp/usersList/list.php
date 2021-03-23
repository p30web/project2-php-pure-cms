<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_list')) {
    error403();
    die;
}
global $View;
global $Users;
global $Cp;
global $database;
$getopt = datatable_get_opt();
if ($getopt) {
    $countall = $database->count('jk_users', [
    ]);

    if ($getopt['search'] != '') {
        $lists = $database->select('jk_users', '*', [
            "AND" => [
                "OR" => [
                    "username[~]" => $getopt['search'],
                    "email[~]" => $getopt['search'],
                    "name[~]" => $getopt['search'],
                    "family[~]" => $getopt['search'],
                ],
            ],
            "ORDER" => [$getopt['orderby'] => $getopt['orderval']],
            "LIMIT" => [$getopt['start'], $getopt['length']]
        ]);
    } else {
        $lists = $database->select('jk_users', '*', [
            "ORDER" => [$getopt['orderby'] => $getopt['orderval']],
            "LIMIT" => [$getopt['start'], $getopt['length']]
        ]);
    }
    $data = [];

    if (sizeof($lists) >= 1) {
        foreach ($lists as $tr) {
            $stText="";
            $roles = \Joonika\Modules\Users\usersRoleGroupsHTML($tr['id']);
            $op1='<button type="button" class="btn btn-info btn-sm" onclick="add_user('.$tr['id'].')"><i class="fa fa-edit"></i></a>';
            $op2='<button type="button" class="btn btn-info btn-sm" onclick="editgroup('.$tr['id'].')"><i class="fa fa-users"></i></a>';
            $op3='<button type="button" class="btn btn-default btn-sm" onclick="changePassword('.$tr['id'].')"><i class="fa fa-key"></i></a>';
            $op4='<button type="button" class="btn btn-default btn-sm" onclick="changeImage('.$tr['id'].')"><i class="fa fa-image"></i></a>';
            if($tr['status']=="inactive"){
                $stText=' <span class="text-danger">('.__("inactive").')</span>';
            }
            array_push($data, [
                "id" => $tr['id'],
                "image" => '<img src="'.\Joonika\Modules\Users\profileImage($tr['id']).'" class="img img-fluid rounded-circle" style="width:30px">',
                "username" => $tr['username'].$stText,
                "email" => $tr['email'],
                "mobile" => $tr['mobile'],
                "sex" => \Joonika\Modules\Users\sexTitle($tr['sex']),
                "name" => $tr['name'],
                "family" => $tr['family'],
                "roleGroup" => $roles.' '.$op2,
                "regDate" => date("Y/m/d-H:i:s", strtotime($tr['regDate'])),
                "operation" => '<div class="btn-group rtl">'.$op1.$op4.$op3.'</div>',
            ]);

        }
    }

    echo datatable_view([
        "CountAll" => $countall,
        "list" => $lists,
        "data" => $data,
    ]);

}
