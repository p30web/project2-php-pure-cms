<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('faq_list')) {
    error403();
    die;
}
global $View;
global $Users;
global $Cp;
global $database;
$getopt = datatable_get_opt();
if ($getopt) {
    $countall = $database->count('faq_categories', [
            "status" => "active",
    ]);
        $lists = $database->select('faq_categories', '*', [
            "status" => "active",
            "ORDER" => [$getopt['orderby'] => $getopt['orderval']],
            "LIMIT" => [$getopt['start'], $getopt['length']]
        ]);
    $data = [];
    if (sizeof($lists) >= 1) {
        foreach ($lists as $tr) {
            $op1='<button type="button" onclick="addFaqCat('.$tr['id'].')" class="btn btn-sm btn-info" ><i class="fa fa-edit"></i></button>';
            $op2='<a href="https://ipinbar.net/fa/cp/faq/view/'.$tr['id'].'" class="btn btn-sm btn-info" ><i class="fa fa-eye"></i></a>';
            $questionCount=$database->count("faq_list",[
                "AND"=>[
                    "status"=>"active",
                    "module"=>$tr['id'],
                ]
            ]);
            array_push($data, [
                "id" => $tr['id'],
                "title" => $tr['title'],
                "textCode" => '[textCode]name=faq_list&id='.$tr['id'].'[/textCode]',
                "questionCount" => $questionCount,
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
