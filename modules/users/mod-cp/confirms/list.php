<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_confirms')) {
    error403();
    die;
}
global $View;
global $Users;
global $Cp;
global $database;
$getopt = datatable_get_opt();
if ($getopt) {

    if ($getopt['search'] != '') {
        $finds=langDefineSearch(JK_LANG,'jk_users_confirms','id',$getopt['search']);
        $finds=arrayIfEmptyZero($finds);
        $lists = $database->select('jk_users_confirms', '*', [
            "AND" => [
                "id" => $finds,
                "status" => "active",
            ],
            "ORDER" => [$getopt['orderby'] => $getopt['orderval']],
            "LIMIT" => [$getopt['start'], $getopt['length']]
        ]);
        $countall = $database->count('jk_users_confirms', [
            "AND" => [
                "title[~]" => $getopt['search'],
                "status" => "active",
            ],
            ]);
    } else {
        $lists = $database->select('jk_users_confirms', '*', [
            "status"=>"active",
            "ORDER" => [$getopt['orderby'] => $getopt['orderval']],
            "LIMIT" => [$getopt['start'], $getopt['length']]
        ]);
        $countall = $database->count('jk_users_confirms', [
            "status"=>"active",
        ]);
    }
    $data = [];
    if (sizeof($lists) >= 1) {
        foreach ($lists as $tr) {
            $op1='<i class="fa fa-eraser" onclick="resetConf('.$tr['id'].')"></i>';
            $op2='<i class="fa fa-edit" onclick="editC('.$tr['id'].')"></i>';
            for($i=1;$i<=5;$i++){
                $level[$i]='<i class="fa fa-plus-circle text-info" onclick="levelAdd('.$i.','.$tr['id'].')"></i>';
                $corroborants=$database->select('jk_users_confirms_corroborant',"*",[
                    "AND"=>[
                        "status"=>"active",
                        "level"=>$i,
                        "cID"=>$tr['id'],
                    ]
                ]);
                if(sizeof($corroborants)>=1){
                    foreach ($corroborants as $corroborant){
                        $level[$i].='<br/><div class="border-top"><i class="fa fa-times" onclick="removeCL('.$corroborant['id'].')"></i> '.nickName($corroborant['corroborant']).'</div>';
                    }
                }
            }
            array_push($data, [
                "id"=>langDefineGet(JK_LANG,'jk_users_confirms','id',$tr['id']),
                "module"=>$tr['module'],
                "level1"=>$level[1],
                "level2"=>$level[2],
                "level3"=>$level[3],
                "level4"=>$level[4],
                "level5"=>$level[5],
                "operation"=>$op1.' '.$op2,
            ]);
        }
    }

    echo datatable_view([
        "CountAll" => $countall,
        "list" => $lists,
        "data" => $data,
    ]);

}
