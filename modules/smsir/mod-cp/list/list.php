<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('smsir_list')) {
    error403();
    die;
}
global $View;
global $Users;
global $Cp;
global $database;
$getopt = datatable_get_opt();
if ($getopt) {
    $countall = $database->count('smsir_temps', [
            "status" => ["active","inactive"],
    ]);
        $lists = $database->select('smsir_temps', '*', [
	        "status" => ["active","inactive"],
            "ORDER" => [$getopt['orderby'] => $getopt['orderval']],
            "LIMIT" => [$getopt['start'], $getopt['length']]
        ]);
    $data = [];
    if (sizeof($lists) >= 1) {
        foreach ($lists as $tr) {
	        $opStatus='<button type="button" onclick="changeStatus('.$tr['id'].')" class="btn btn-sm btn-outline-info" ><i class="fa fa-sync-alt"></i></button>';
            $op1='<button type="button" onclick="addTemplate('.$tr['id'].')" class="btn btn-sm btn-outline-info" ><i class="fa fa-edit"></i></button>';
            array_push($data, [
                "id" => $tr['id'],
                "title" => langDefineGet(JK_LANG,'smsir_temps','id',$tr['id']),
                "templateID"=>$tr['templateID'],
                "vars"=>$tr['vars'],
                "status" => $tr['status'],
                "operation" => '<span class="btn-group">'.$opStatus.$op1.'</span>',
            ]);
        }
    }

    echo datatable_view([
        "CountAll" => $countall,
        "list" => $lists,
        "data" => $data,
    ]);

}
