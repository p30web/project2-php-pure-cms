<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('users_displacements')) {
    error403();
    die;
}
global $database;

$ds=$database->select('jk_users_displacements',"*",[
    "ORDER"=>["datetime"=>"ASC"]
]);
if(sizeof($ds)>=1){
    foreach ($ds as $d){
        $dInfo=\Joonika\Modules\Users\displacementInfo($d['displacementTypeID']);


        if($dInfo['statusType']==1){
            $database->update('jk_users',[
                "status"=>"active"
            ],[
                "id"=>$d['userID']
            ]);
        }else{
            $database->update('jk_users',[
                "status"=>"inactive"
            ],[
                "id"=>$d['userID']
            ]);
        }

    }
    echo alert([
        "text"=>__("done"),
        "type"=>"success",
    ]);
}
