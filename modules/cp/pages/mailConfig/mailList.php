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
        $countall = $database->count('jk_emails', [
        ]);

        if ($getopt['search'] != '') {
            $lists = $database->select('jk_emails', '*', [
                    "OR" => [
                        "username[~]" => $getopt['search'],
                        "email[~]" => $getopt['search'],
                    ],
                "ORDER" => [$getopt['orderby'] => $getopt['orderval']],
                "LIMIT" => [$getopt['start'], $getopt['length']]
            ]);
        } else {
            $lists = $database->select('jk_emails', '*', [
                "ORDER" => [$getopt['orderby'] => $getopt['orderval']],
                "LIMIT" => [$getopt['start'], $getopt['length']]
            ]);
        }
        $data = [];

        if (sizeof($lists) >= 1) {
            foreach ($lists as $tr) {
                $op1='<button type="button" class="btn btn-info btn-sm" onclick="editMail('.$tr['id'].')"><i class="fa fa-edit"></i></a>';
                array_push($data, [
                    "id" => $tr['id'],
                    "email"=>$tr['email'],
                    "username"=>$tr['username'],
                    "server"=>$tr['server'],
                    "port"=>$tr['port'],
                    "secureType"=>$tr['secureType'],
                    "fromName"=>$tr['fromName'],
                    "debug"=>$tr['debug'],
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
