<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_displacements')) {
    error403();
    die;
}
global $View;
global $Users;
global $Cp;
global $database;
    $getopt = datatable_get_opt();
    if ($getopt) {

            $lists = $database->select('jk_users_displacements', '*', [
                "ORDER" => [$getopt['orderby'] => $getopt['orderval']],
                "LIMIT" => [$getopt['start'], $getopt['length']]
            ]);
            $countall = $database->count('jk_users_displacements', [
            ]);
        $data = [];
        if (sizeof($lists) >= 1) {
            foreach ($lists as $tr) {
                array_push($data, [
                    "id"=>$tr['id'],
                    "userID"=>nickName($tr['userID']),
                    "displacementTypeID"=>\Joonika\Modules\Users\displacementTitle($tr['displacementTypeID']),
                    "roleID"=>\Joonika\Modules\Users\roleTitle($tr['roleID']),
                    "groupID"=>\Joonika\Modules\Users\groupTitle($tr['groupID']),
                    "datetime"=>\Joonika\Idate\date_int("Y/m/d",$tr['datetime']),
                    "datetime_s"=>\Joonika\Idate\date_int("Y/m/d-H:i:s",$tr['datetime_s']),
                    "creatorID"=>nickName($tr['creatorID']),
                    "status"=>__($tr['status']),
                ]);
            }
        }

        echo datatable_view([
            "CountAll" => $countall,
            "list" => $lists,
            "data" => $data,
        ]);

}
