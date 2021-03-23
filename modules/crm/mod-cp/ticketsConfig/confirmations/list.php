<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('crm_tickets_config')) {
    error403();
    die;
}
global $View;
global $Users;
global $Cp;
global $database;
$getopt = datatable_get_opt();
if ($getopt) {
if(isset($_GET['subjectID'])){
    $subjectID=$_GET['subjectID'];
}else{
    $subjectID=0;
}
    if ($getopt['search'] != '') {
        $lists = $database->select('jk_users', 'id', [
            "AND" => [
                "OR" => [
                    "name[~]"=>$getopt['search'],
                    "family[~]"=>$getopt['search'],
                ],
                "status" => "active",
            ],
            "ORDER" => [$getopt['orderby'] => $getopt['orderval']],
            "LIMIT" => [$getopt['start'], $getopt['length']]
        ]);
        $countall = $database->count('jk_users', [
            "AND" => [
                "OR" => [
                    "name[~]"=>$getopt['search'],
                    "family[~]"=>$getopt['search'],
                ],
                "status" => "active",
            ],
            ]);
    } else {
        $lists = $database->select('jk_users', 'id', [
            "status"=>"active",
            "ORDER" => [$getopt['orderby'] => $getopt['orderval']],
            "LIMIT" => [$getopt['start'], $getopt['length']]
        ]);
        $countall = $database->count('jk_users', [
            "status"=>"active",
        ]);
    }
    $data = [];
    if (sizeof($lists) >= 1) {
        foreach ($lists as $tr) {
            $op1='<i class="fa fa-eraser" onclick="resetConf('.$tr.')"></i>';
            $description='<i class="fa fa-plus-circle text-info" onclick="confirmAdd('.$tr.','.$subjectID.')"></i>';
            $selects=$database->select('crm_tickets_confirmations','*',[
                "AND"=>[
                    "userID"=>$tr,
                    "subjectID"=>$subjectID,
                    "status"=>"active",
                ]
            ]);
            if(sizeof($selects)>=1){
                foreach ($selects as $select){
                    $description.='<br/><div class="border-top"><i class="fa fa-times" onclick="removeCL('.$select['id'].')"></i> '.\Joonika\Modules\Users\confirmationTitle($select['confirmID']).'</div>';
                }
            }
            array_push($data, [
                "id"=>nickName($tr),
                "description"=>$description,
                "operation"=>$op1,
            ]);
        }
    }

    echo datatable_view([
        "CountAll" => $countall,
        "list" => $lists,
        "data" => $data,
    ]);

}
