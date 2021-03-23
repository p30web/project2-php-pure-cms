<?php
if (!defined('jk')) die('Access Not Allowed !');
global $ACL;
if(isset($_POST['catID'])){
    global $View;
    global $database;
    $fields=[];
    $fieldsDB=$database->select('personnel_fields','id',[
        "AND"=>[
                "status"=>"active",
                "module"=>$_POST['catID'],
        ],
        "ORDER"=>["sort"=>"ASC"],
    ]);
    if(sizeof($fieldsDB)>=1){
        foreach ($fieldsDB as $fieldDB){
            $fields[$fieldDB]=langDefineGet(JK_LANG,'personnel_fields','id',$fieldDB);
        }
    }
    echo \Joonika\Forms\field_select(
        [
            "name" => "fieldID",
            "title" => __("field"),
            "required" => true,
            "first" => true,
            "ColType" => "12,12",
            "array" => $fields,
        ]
    );
    echo $View->footer_js;
}
