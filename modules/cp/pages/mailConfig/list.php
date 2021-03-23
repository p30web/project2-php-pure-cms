<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('cp_mailConfig')) {
    error403();
    die;
}
global $View;
global $Users;
global $Cp;
global $database;
$Users->loggedCheck();
    $getopt = datatable_get_opt();
    if ($getopt) {
        $countall = $database->count('jk_emailTemplate', [
                "lang" => JK_LANG,
        ]);

        if ($getopt['search'] != '') {
            $lists = $database->select('jk_emailTemplate', '*', [
                "AND" => [
                    "OR" => [
                        "name[~]" => $getopt['search'],
                        "text[~]" => $getopt['search'],
                    ],
                    "lang" => JK_LANG,
                ],
                "ORDER" => [$getopt['orderby'] => $getopt['orderval']],
                "LIMIT" => [$getopt['start'], $getopt['length']]
            ]);
        } else {
            $lists = $database->select('jk_emailTemplate', '*', [
                    "lang" => JK_LANG,
                "ORDER" => [$getopt['orderby'] => $getopt['orderval']],
                "LIMIT" => [$getopt['start'], $getopt['length']]
            ]);
        }
        $data = [];

        if (sizeof($lists) >= 1) {
            foreach ($lists as $tr) {
                $op1='<button type="button" class="btn btn-info btn-sm" onclick="editText('.$tr['id'].')"><i class="fa fa-edit"></i></a>';
                array_push($data, [
                    "id" => $tr['id'],
                    "name"=>$tr['name'],
                    "lang"=>$tr['lang'],
                    "op"=>$op1,
                ]);
            }
        }

        echo datatable_view([
            "CountAll" => $countall,
            "list" => $lists,
            "data" => $data,
        ]);

}
