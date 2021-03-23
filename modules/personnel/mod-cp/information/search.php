<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
global $View;
global $database;
if (!$ACL->hasPermission('personnel_information')) {
    error403();
    die;
}
if($_POST['search']==""){
    $users=$database->select('jk_users','id',[
    ]);
}else{
    $users=$database->select('jk_users','id',[
        "OR"=>[
            "name[~]"=>$_POST['search'],
            "family[~]"=>$_POST['search'],
            "username[~]"=>$_POST['search'],
            "email[~]"=>$_POST['search'],
            ]
    ]);
}
if(sizeof($users)==0){
    echo alertDanger(__("not any personnel found"));
}else{
    new \Joonika\Modules\Personnel\Personnel();
    shuffle($users);
    foreach ($users as $user){
        \Joonika\Modules\Personnel\personnelCardSimple($user,"col-12 col-md-4",true);
    }
}