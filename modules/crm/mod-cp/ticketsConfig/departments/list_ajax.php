<?php
if(!defined('jk')) die('Access Not Allowed !');
global $ACL;
if (!$ACL->hasPermission('crm_tickets_config')) {
    error403();
    die;
}
global $database;
$extra_float=[];
$getdatas=$database->select('crm_tickets_departments','*',[
    'status'=>"active"
]);
if(sizeof($getdatas)>=1){
    foreach ($getdatas as $getdata){
	    $countReporters=$database->count("crm_tickets_departments_reporters",[
		    "AND"=>[
			    "groupID"=>$getdata['id'],
			    "status"=>"active",
		    ]
	    ]);
	    $countFollowers=$database->count("crm_tickets_departments_followers",[
		    "AND"=>[
			    "groupID"=>$getdata['id'],
			    "status"=>"active",
		    ]
	    ]);
        $extra_float[$getdata['id']]='<button onclick="reporters('.$getdata['id'].')" class="btn btn-sm btn-outline-warning">'.__("reporter").' - '.$countReporters.'</button>';
        $extra_float[$getdata['id']].='<button onclick="followers('.$getdata['id'].')" class="btn btn-sm btn-outline-info">'.__("followers").' - '.$countFollowers.'</button>';
    }
}
NestableTableJS("crm_tickets_departments",JK_DOMAIN_LANG . 'cp/crm/ticketsConfig/departments/list_sort',1,1);
NestableTableGetData('crm_tickets_departments','crm_tickets_departments', JK_LANG,0,$extra_float);
global $View;
echo $View->footer_js;