<?php
if(!defined('jk')) die('Access Not Allowed !');
global $Cp;
$Cp->addSidebar([
    "title"=>"ipin",
    "link"=>"#",
    "name"=>"ipinbar",
    "icon"=>"fa fa-map-marker-alt",
    "sub"=>[
	    [
		    "title"=>__("sms setting"),
		    "link"=>"smsSendingSetting",
		    "name"=>"smsSendingSetting",
		    "icon"=>"fa fa-cogs",
	    ],[
		    "title"=>__("crm setting"),
		    "link"=>"crmSetting",
		    "name"=>"crmSetting",
		    "icon"=>"fa fa-cogs",
	    ]
    ],
]);
global $ipinBarCrmSetting;
$ipinBarCrmSetting = [
	[
		"link" => 'noteModules',
		"permissions" => "ipinbar_crmSetting_noteModules",
		"icon" => "fa fa-clipboard-list",
		"title" => __("notes modules")
	],[
		"link" => 'introductionMethods',
		"permissions" => "ipinbar_crmSetting_introductionMethod",
		"icon" => "fa fa-users",
		"title" => __("the method of introduction")
	]
];