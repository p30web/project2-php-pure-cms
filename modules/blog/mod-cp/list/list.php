<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('blog_list')) {
    error403();
    die;
}
global $View;
global $Users;
global $Cp;
global $database;
    $getopt = datatable_get_opt();
    if ($getopt) {
        $countall = $database->count('jk_data', [
            "AND" => [
                "lang" => JK_LANG,
                "status" => ["active","draft"],
                "websiteID" => JK_WEBSITE_ID,
                "module" => "blog_post",
            ]
        ]);

        if ($getopt['search'] != '') {
            $lists = $database->select('jk_data', '*', [
                "AND" => [
                    "text[~]" => $getopt['search'],
                    "lang" => JK_LANG,
                    "status" => ["active","draft"],
                    "module" => "blog_post",
                ],
                "ORDER" => [$getopt['orderby'] => $getopt['orderval']],
                "LIMIT" => [$getopt['start'], $getopt['length']]
            ]);
        } else {
            $lists = $database->select('jk_data', '*', [
                "AND"=>[
                    "status" => ["active","draft"],
                    "lang" => JK_LANG,
                    "module" => "blog_post",
                ],
                "ORDER" => [$getopt['orderby'] => $getopt['orderval']],
                "LIMIT" => [$getopt['start'], $getopt['length']]
            ]);
        }
        $data = [];

        if (sizeof($lists) >= 1) {
            foreach ($lists as $tr) {
                $op1='<a class="btn btn-sm btn-info" href="'.JK_DOMAIN_LANG.'cp/blog/list/edit/'.$tr['id'].'"><i class="fa fa-edit"></i></a>';
                $op2='<a class="btn btn-sm btn-primary" href="'.JK_DOMAIN_LANG.$tr['slug'].'"><i class="fa fa-eye"></i></a>';
                array_push($data, [
                    "id" => $tr['id'],
                    "title" => $tr['title'],
                    "creator" => nickName($tr['creatorID']),
                    "datetime" => \Joonika\Idate\date_int("Y/m/d-H:i:s",$tr['datetime']),
                    "views" => $tr['views'],
                    "status" => $tr['status'],
                    "operation" => '<span class="btn-group">'.$op1.$op2.'</span>',
                ]);
            }
        }

        echo datatable_view([
            "CountAll" => $countall,
            "list" => $lists,
            "data" => $data,
        ]);

}
