<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('cp_translate')) {
    error403();
    die;
}
global $View;
global $Users;
global $Cp;
global $database;
$Users->loginCheck();

    $getopt = datatable_get_opt();
    if ($getopt) {
        $countall = $database->count('jk_translate', [
            "AND" => [
                "lang" => JK_LANG,
                "status" => "active",
            ]
        ]);

        if ($getopt['search'] != '') {
            $lists = $database->select('jk_translate', '*', [
                "AND" => [
                    "OR" => [
                        "var[~]" => $getopt['search'],
                        "text[~]" => $getopt['search'],
                    ],
                    "lang" => JK_LANG,
                    "status" => "active",
                ],
                "ORDER" => [$getopt['orderby'] => $getopt['orderval']],
                "LIMIT" => [$getopt['start'], $getopt['length']]
            ]);
        } else {
            $lists = $database->select('jk_translate', '*', [
                "AND"=>[
                    "status" => "active",
                    "lang" => JK_LANG,
                ],
                "ORDER" => [$getopt['orderby'] => $getopt['orderval']],
                "LIMIT" => [$getopt['start'], $getopt['length']]
            ]);
        }
        $data = [];

        if (sizeof($lists) >= 1) {
            foreach ($lists as $tr) {
                array_push($data, [
                    "id" => $tr['id'],
                    "lang" => $tr['lang'],
                    "var" => $tr['var'],
                    "text" => '<input type="text" name="trval_' . $tr['id'] . '" id="trval_' . $tr['id'] . '" value="' . $tr['text'] . '"><span id="tr_update_' . $tr['id'] . '"></span>',
                ]);
            }
        }

        echo datatable_view([
            "CountAll" => $countall,
            "list" => $lists,
            "data" => $data,
        ]);

}
